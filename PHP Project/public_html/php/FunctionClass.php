<?php
require_once 'php/database/DBController.php';
include_once 'php/entities/UserClass.php';
session_start();

class FunctionClass
{
    public function checkForUser()
    {
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            if ($_SESSION['USER_LOGIN_IN'] != 1 && $_COOKIE['user']) {
                $dbController = new Database();
                $dbController->query('SELECT * FROM user WHERE email = :email');
                $dbController->bind(':email', $_COOKIE['user']);
                $dbController->execute();
                $row = $dbController->single();
                if ($row) {
                    $user = new User($row['id'], $row['name'], $row['email'], $row['password']);
                    $_SESSION["USER"] = serialize($user);
                    $_SESSION['USER_LOGIN_IN'] = 1;
                }
            }
        }
    }

    public function register($name, $email, $password)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('SELECT email FROM user WHERE email = :email');
        $dbController->bind(':email', $email);
        $dbController->execute();
        $row = $dbController->single();
        if ($row) {
            self::MessageSend(1, 'User with this email is already registered. Please contact us to reset your password.');
            return true;
        } else {
            $dbController->query('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
            $dbController->bind(':name', $name);
            $dbController->bind(':email', $email);
            $dbController->bind(':password', self::genPass($password, $email));
            $dbController->execute();
            $dbController->query('SELECT * FROM user WHERE email = :email');
            $dbController->bind(':email', $email);
            $dbController->execute();
            $row = $dbController->single();
            $user = new User($row['id'], $row['name'], $row['email'], $row['password']);
            $_SESSION["USER"] = serialize($user);
            $_SESSION['USER_LOGIN_IN'] = 1;

            $tags = $this->getTags();
            foreach($tags as $tag){
                $dbController->query('INSERT INTO user_tags (userId, tagId, title, colour) VALUES (:userId, :tagId, :title, :colour)');
                $dbController->bind(':userId', unserialize($_SESSION['USER'])->getId());
                $dbController->bind(':tagId', $tag['id']);
                $dbController->bind(':title', $tag['title']);
                $dbController->bind(':colour', $tag['colour']);
                $dbController->execute();
            }

            exit(header('Location: index.php'));
        }
    }

    public function login($email, $password)
    {
        $dbController = new Database();
        //Check if this email is registered
        $dbController->query('SELECT * FROM user WHERE email = :email and password = :password');
        $dbController->bind(':email', $email);
        $dbController->bind(':password', self::genPass($password, $email));
        $dbController->execute();
        $row = $dbController->single();
        if ($row) {
            $user = new User($row['id'], $row['name'], $row['email'], $row['password']);
            $_SESSION["USER"] = serialize($user);
            $_SESSION['USER_LOGIN_IN'] = 1;
            exit(header('Location: index.php'));
        } else {
            self::MessageSend(1, 'User with this email is not registered or password is incorrect.');
            return true;
        }
    }

    public function getTags(){
        $dbController = new Database();
        $dbController->query('SELECT id, title, colour FROM tags');
        $dbController->execute();
        return $dbController->resultset();
    }

    public function editUser($id, $name, $email, $password)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('UPDATE user SET name = :name, email = :email, password = :password WHERE id = :id');
        $dbController->bind(':name', $name);
        $dbController->bind(':email', $email);
        $dbController->bind(':password', self::genPass($password, $email));
        $dbController->bind(':id', $id);
        $dbController->execute();
        return true;
    }
    
    public function editCat($catId, $title)
    {
        $dbController = new Database();
        $dbController->query('UPDATE category SET title = :title WHERE id = :catId');
        $dbController->bind(':title', $title);
        $dbController->bind(':catId', $catId);
        $dbController->execute();
        return true;
    }

    public function editTag($userId, $tagId, $title, $colour)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('UPDATE user_tags SET title = :title, colour = :colour WHERE userId = :userId AND tagId = :tagId');
        $dbController->bind(':title', $title);
        $dbController->bind(':colour', $colour);
        $dbController->bind(':userId', $userId);
        $dbController->bind(':tagId', $tagId);
        $dbController->execute();
        return true;
    }

    public function editProject($userId, $projectId, $title, $colour)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('UPDATE project SET title = :title, colour = :colour WHERE userId = :userId AND id = :projectId');
        $dbController->bind(':title', $title);
        $dbController->bind(':colour', $colour);
        $dbController->bind(':userId', $userId);
        $dbController->bind(':projectId', $projectId);
        $dbController->execute();
        return true;
    }
    
    public function addProject($userId, $title, $colour)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('INSERT INTO project (title, colour, userId) VALUES (:title, :colour, :userId)');
        $dbController->bind(':title', $title);
        $dbController->bind(':colour', $colour);
        $dbController->bind(':userId', $userId);
        $dbController->execute();
        return true;
    }
    
    public function addCategory($title, $projectId)
    {
        $dbController = new Database();
        //Check if this email is already used
        $dbController->query('INSERT INTO category (title, projectId) VALUES (:title, :projectId)');
        $dbController->bind(':title', $title);
        $dbController->bind(':projectId', $projectId);
        $dbController->execute();
        return true;
    }

    public function logOut(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            if ($_SESSION['USER_LOGIN_IN'] == 1) {
                if ($_COOKIE['user']) {
                    setcookie('user', '', strtotime('-30 days'), '/');
                    unset($_COOKIE['user']);
                }
                session_unset();
            }
        }
    }

    public function getAllUsers(){
        $dbController = new Database();
        $dbController->query('SELECT * FROM user');
        $dbController->execute();
        $rows = $dbController->resultset();
        return $rows;
    }

    public function deleteUser($email){
        $dbController = new Database();
        $dbController->query('DELETE FROM user WHERE email = :email');
        $dbController->bind(':email', $email);
        $dbController->execute();
    }

    public function deleteTag($userId, $tagId){
        $dbController = new Database();
        $dbController->query('DELETE FROM user_tags WHERE userId = :userId AND tagId = :tagId');
        $dbController->bind(':userId', $userId);
        $dbController->bind(':tagId', $tagId);
        $dbController->execute();
    }
    
    public function deleteCat($catId){
        $dbController = new Database();
        $dbController->query('DELETE FROM category WHERE id = :catId');
        $dbController->bind(':catId', $catId);
        $dbController->execute();
    }

    public function deleteProject($userId, $projectId){
        $dbController = new Database();
        $dbController->query('DELETE FROM category WHERE projectId = :projectId');
        $dbController->bind(':projectId', $projectId);
        $dbController->execute();

        $dbController->query('DELETE FROM project WHERE userId = :userId AND id = :projectId');
        $dbController->bind(':userId', $userId);
        $dbController->bind(':projectId', $projectId);
        $dbController->execute();
    }

    public function errorMsg($message, $header){
        return 'isError = true;
                errorMessage = "<p>'.$message.'</p>";
                errorHeader = "'.$header.'";
                ';
    }

    public function genPass($password, $email){
        return md5('MALIKAS'.md5('321'.$password.'123').md5('678'.$email.'890'));
    }

    public function ULogin($p1){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            if ($p1 == 3 && unserialize($_SESSION['USER'])->getEmail() != 'mr.yavari@mail.ru') self::MessageSend(1, 'This page is only for admin.', 'index.php');
            if ($p1 <= 0 && $_SESSION['USER_LOGIN_IN'] != $p1) self::MessageSend(1, 'This page is only for guests.', 'index.php');
        }
        else {
            if ($p1 == 3)
                self::MessageSend(1, 'This page is only for admin.', 'index.php');
            else if ($p1 == 1)
                self::MessageSend(1, 'This page is only for authorized users.', 'index.php');
        }
    }

    public function MessageSend($p1, $p2, $p3 = '') {
        if ($p1 == 1) $p1 = 'Error';
        else if ($p1 == 2) $p1 = 'Hint';
        else if ($p1 == 3) $p1 = 'Information';
        else if ($p1 == 4) $p1 = 'Success';
        $_SESSION['message'] = $p1.'&'.$p2;
        if ($p3) {
            $_SERVER['HTTP_REFERER'] = $p3;
            exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }
    }

    public function MessageShow() {
        if (isset($_SESSION['message'])) {
            if (!empty($_SESSION['message'])){
                $Message = explode("&", $_SESSION['message']);
                $_SESSION['message'] = "";
                return self::errorMsg($Message[1], $Message[0]);
            }
        }
    }

    public function userManagementPage(){
        if (isset($_GET['delete']) && isset($_GET['confirm'])){
            if ($_GET['confirm'] == true) {
                self::deleteUser($_GET['delete']);
                header('Location: user-management.php');
            }
        }

        if (isset($_POST['save'])) {
            $msg = "";
            self::editUser($_POST['id'], $_POST["name"], $_POST["email"], $_POST["password"]);
            $msg = "You successfully updated info.<br/>";
            self::MessageSend(4, $msg, 'user-management.php');
        }
    }

    public function tagManagementPage(){
        if (isset($_GET['delete']) && isset($_GET['confirm'])){
            if ($_GET['confirm'] == true) {
                $this->deleteTag(unserialize($_SESSION['USER'])->getId(), $_GET['delete']);
                header('Location: tag-management.php');
            }
        }

        if (isset($_POST['save'])) {
            $msg = "";
            $this->editTag(unserialize($_SESSION['USER'])->getId(), $_POST["edit"], $_POST["name"], $_POST["colour"]);
            $msg = "You successfully updated info.<br/>";
            self::MessageSend(4, $msg, 'tag-management.php');
        }
    }

    public function projectManagementPage(){
        if (isset($_GET['deleteCat']) && isset($_GET['confirm'])){    
            if ($_GET['confirm'] == true) {
                $this->deleteCat($_GET['deleteCat']);
                header('Location: project-management.php');
            }
        }

        if (isset($_POST['saveCat'])) {
            $msg = "";
            $this->editCat($_POST["cat"], $_POST["name"]);
            $msg = "You successfully updated info.<br/>";
            self::MessageSend(4, $msg, 'project-management.php');
        }
        
        if (isset($_GET['delete']) && isset($_GET['confirm'])){
            if ($_GET['confirm'] == true) {
                $this->deleteProject(unserialize($_SESSION['USER'])->getId(), $_GET['delete']);
                header('Location: project-management.php');
            }
        }
        if (isset($_POST['save'])) {
            $msg = "";
            $this->editProject(unserialize($_SESSION['USER'])->getId(), $_POST["edit"], $_POST["name"], $_POST["colour"]);
            $msg = "You successfully updated info.<br/>";
            self::MessageSend(4, $msg, 'project-management.php');
        }
        
        if (isset($_POST['saveNewProj'])){
            if ($this->checkLimitProj() < 20){
                $msg = "";
                $this->addProject(unserialize($_SESSION['USER'])->getId(), $_POST["name"], $_POST["colour"]);
                $msg = "You successfully added new project.<br/>";
                self::MessageSend(4, $msg, 'project-management.php');
            }
            else 
                self::MessageSend(1, "You can only have 20 projects.", 'project-management.php');
        }
        
        if (isset($_POST['saveNewCat'])){
            if ($this->checkLimitCat($_POST["projectId"]) < 4){
                $msg = "";
                $this->addCategory($_POST["name"], $_POST["projectId"]);
                $msg = "You successfully added new category.<br/>";
                self::MessageSend(4, $msg, 'project-management.php');
            }
            else
                self::MessageSend(1, "You can only have 4 categories for each project.", 'project-management.php');
        }
    }

    public function registerPage()
    {
        if (isset($_POST["submitReg"])) {
            return $this->register($_POST["name"], $_POST["email"], $_POST["password"]);
        }
        return false;
    }

    public function loginPage()
    {
        if (isset($_POST["submitLog"])) {
            if (isset($_POST['rememberMe']))
                setcookie('user', $_POST["email"], strtotime('+30 days'), '/');
            return $this->login($_POST["email"], $_POST["password"]);
        }
        return false;
    }

    public function getCurrentTask(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $dbController = new Database();
            $dbController->query('SELECT t.id, t.description, t.start, t.end, t.userId, t.categoryId, t.projectId FROM tasks t
                                  INNER JOIN user u
                                   ON t.userId = u.id
                                  WHERE u.id = :id AND t.end IS NULL');
            $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
            $dbController->execute();
            return $dbController->single();
        }
    }

    public function getTagsForTask($taskId){
        $dbController = new Database();
        $dbController->query('SELECT tt.tagId FROM task_tags tt
                                  INNER JOIN tasks t
                                   ON tt.taskId = t.id
                                  WHERE t.id = :taskId');
        $dbController->bind(':taskId', $taskId);
        $dbController->execute();
        return $dbController->resultset();
    }

    public function getCategoriesForProjects($projectId){
        $dbController = new Database();
        $dbController->query('SELECT c.id, c.title FROM category c
                                  INNER JOIN project p
                                   ON c.projectId = p.id
                                  WHERE p.id = :projectId');
        $dbController->bind(':projectId', $projectId);
        $dbController->execute();
        return $dbController->resultset();
    }

    public function getThisWeekProjects(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $dbController = new Database();
            $dbController->query('SELECT p.id, p.title, p.colour, p.userId FROM project p
                                  INNER JOIN user u
                                   ON p.userId = u.id
                                  WHERE u.id = :id');
            $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
            $dbController->execute();
            return $dbController->resultset();
        }
    }

    public function getTagsForCurrentUser(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $dbController = new Database();
            $dbController->query('SELECT p.tagId, p.title, p.colour FROM user_tags p
                                  INNER JOIN user u
                                   ON p.userId = u.id
                                  WHERE u.id = :id');
            $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
            $dbController->execute();
            $userTags = $dbController->resultset();

            for ($i = 0; $i < count($userTags); $i++){
                if (empty($userTags[$i]['colour']))
                    $userTags[$i]['colour'] = '#ffffff';
            }
            return $userTags;
        }
    }

    public function getAllTasks(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $dbController = new Database();
            $dbController->query('SELECT t.id, t.description, t.start, t.end, t.userId, t.categoryId, t.projectId FROM tasks t
                                  INNER JOIN user u
                                   ON t.userId = u.id
                                  WHERE u.id = :id AND t.end IS NOT NULL');
            $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
            $dbController->execute();
            return $dbController->resultset();
        }
    }

    public function getThisWeekTasks(){
        if (isset($_SESSION['USER_LOGIN_IN'])) {
            $pastDate = strtotime(date('Y-m-d', strtotime("-7 days")));
            $todayDate = time();
            $dbController = new Database();
            $dbController->query('SELECT t.id, t.description, t.start, t.end, t.userId, t.categoryId, t.projectId FROM tasks t
                                  INNER JOIN user u
                                   ON t.userId = u.id
                                  WHERE u.id = :id AND t.end IS NOT NULL
                                  AND t.start >= :start AND t.end <= :end');
            $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
            $dbController->bind(':start', $pastDate);
            $dbController->bind(':end', $todayDate);
            $dbController->execute();
            return $dbController->resultset();
        }
    }

    public function getTasksByDays(){
        $alltasks = $this->getThisWeekTasks();
        $tasksByDays = [[], [], [], [], [], [], []];
        if ($alltasks) {
            foreach ($alltasks as $task) {
                switch (date('N', $task['end'])) {
                    case 1:
                        array_push($tasksByDays[1], $task);
                        break;
                    case 2:
                        array_push($tasksByDays[2], $task);
                        break;
                    case 3:
                        array_push($tasksByDays[3], $task);
                        break;
                    case 4:
                        array_push($tasksByDays[4], $task);
                        break;
                    case 5:
                        array_push($tasksByDays[5], $task);
                        break;
                    case 6:
                        array_push($tasksByDays[6], $task);
                        break;
                    case 7:
                        array_push($tasksByDays[0], $task);
                        break;
                }
            }
            return $tasksByDays;
        }
    }

    public function getDayByNumber($num){
        switch ($num){
            case 0:
                return 'sun';
            case 1:
                return 'mon';
            case 2:
                return 'tue';
            case 3:
                return 'wed';
            case 4:
                return 'thu';
            case 5:
                return 'fri';
            case 6:
                return 'sat';
        }
    }
    
    public function printAllTasks(){
        $allTasks = $this->getAllTasks();
        $count = count($allTasks);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++){   
                $task = $allTasks[$i];
                $categoryId = $task['categoryId'] ? $task['categoryId'] : 'undefined';
                $tags = '';
                foreach ($this->getTagsForTask($task['id']) as $tag)
                    $tags .= $tag['tagId'] . ', ';
                $tags = substr($tags, 0, count($tags) - 3);
                echo "{
                    id: $task[id],
                    name: '$task[description]',
                    tagsApplied: [$tags],
                    projectApplied: $task[projectId],
                    categoryApplied: $categoryId,
                    startTime: $task[start],
                    endTime: $task[end]
                    }";
                if ($i != $count - 1)
                    echo ',';
            }
        }
    }

    public function printWeekTasks(){
        $allTasksThisWeek = $this->getTasksByDays();
        if (count($allTasksThisWeek) > 0) {
            for ($i = 0; $i < count($allTasksThisWeek); $i++) {
                $oneDayTasks = $allTasksThisWeek[$i];
                $day = $this->getDayByNumber($i);
                if (count($oneDayTasks) > 0){
                    echo "$day: [";
                    foreach ($oneDayTasks as $task){
                        $categoryId = $task['categoryId'] ? $task['categoryId'] : 'undefined';
                        $tags = '';
                        foreach ($this->getTagsForTask($task['id']) as $tag)
                            $tags .= $tag['tagId'] . ', ';
                        $tags = substr($tags, 0, count($tags) - 3);
                        echo "{
                                    id: $task[id],
                                    name: '$task[description]',
                                    tagsApplied: [$tags],
                                    projectApplied: $task[projectId],
                                    categoryApplied: $categoryId,
                                    startTime: $task[start],
                                    endTime: $task[end]
                                }";
                        if ($day != 'sat')
                            echo ',';
                    }
                    echo "],";
                } else {
                    echo "$day: undefined";
                    if ($day != 'sat')
                        echo ',';
                }
            }
        }
        else{
            echo 'sun: undefined,
                      mon: undefined,
                      tue: undefined,
                      wed: undefined,
                      thu: undefined,
                      fri: undefined,
                      sat: undefined';
        }
    }

    public function printCurrentTask(){
        $row = $this->getCurrentTask();
        if ($row) {
            $categoryId = $row['categoryId'] ? $row['categoryId'] : 'undefined';
            $tags = '';
            foreach ($this->getTagsForTask($row['id']) as $tag)
                $tags .= $tag['tagId'].', ';
            $tags = substr($tags, 0, count($tags) - 3);
            echo "current: {
                id: $row[id],
                name: '$row[description]',
                tagsApplied: [$tags],
                projectApplied: $row[projectId],
                categoryApplied: $categoryId,
                startTime: $row[start],
                endTime: undefined
            },";
        }
        else{
            echo 'current: undefined,';
        }
    }

    public function printWeekProjects(){
        $projects = $this->getThisWeekProjects();
        $count = count($projects);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $project = $projects[$i];
//                $categoryNames = '';
//                $categoryIDs = '';
//                foreach ($this->getCategoriesForProjects($project['id']) as $category) {
//                    $categoryNames .= '"'.$category['title'].'"' . ', ';
//                    $categoryIDs .= $category['id'] . ', ';
//                }
                $allCategories = $this->getCategoriesForProjects($project['id']);
                $categories = '{';
                if (count($allCategories) > 0){
                    foreach ($allCategories as $category) {
                        $categories .= $category['id'].': "'.$category['title'].'"' . ', ';
                    }
                    $categories = substr($categories, 0, count($categories) - 3);
                }
                $categories .= '}';
                echo "{
                id: $project[id],
                name: '$project[title]',
                color: '$project[colour]',
                categories: {$categories}
                }";
                if ($i != $count - 1)
                    echo ',';
            }
        }
    }

    public function printTagsForUser(){
        $tags = $this->getTagsForCurrentUser();
        $count = count($tags);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) { 
                $tag = $tags[$i];
                echo "{
                id: $tag[tagId],
                name: '$tag[title]',
                color: '$tag[colour]'
                }";
                if ($i != $count - 1)
                    echo ',';
            }
        }
    }
    
    public function checkLimitProj(){    
        $dbController = new Database();
        $dbController->query('SELECT p.id FROM project p
                            INNER JOIN user u
                            ON p.userId = u.id
                            WHERE u.id = :id');
        $dbController->bind(':id', unserialize($_SESSION['USER'])->getId());
        $dbController->execute();
        return $dbController->rowCount();
        
    }
    
    public function checkLimitCat($projectId){    
        $dbController = new Database();
        $dbController->query('SELECT c.id FROM category c
                            INNER JOIN project p
                            ON c.projectId = p.id
                            WHERE p.id = :id');
        $dbController->bind(':id', $projectId);
        $dbController->execute();
        return $dbController->rowCount();
    }
}
?>
