<?php
//Get all needed functions and preset required variables
require_once 'php/FunctionClass.php';
$func = new FunctionClass();

function updateTags($tags, $taskId){
    // clean existing tags?
    $dbController = new Database();
    $dbController->query('DELETE FROM task_tags WHERE taskId = :ID');
    $dbController->bind(':ID', $taskId);
    $dbController->execute();

    // get all possible tags?
/*
    $dbController->query('SELECT id, title, colour FROM tags');
    $dbController->execute();
    $allTags = $dbController->resultset();
*/
    
    $dbController->query('INSERT INTO task_tags (taskId, tagId) VALUES (:taskId, :tagId)');
    foreach ($tags as $tag){
        $dbController->bind(':taskId', $taskId);
        $dbController->bind(':tagId', $tag);
        $dbController->execute();
    }
    // make tags that are in $tags active for task with $taskId
    // if $tags are not set or empty or 'undefined' - make all tagsinactive for the task
}

$returnValue = null;
// check if user is authorized to use the system
$userLoggedIn = isset($_SESSION['USER_LOGIN_IN']) ? true : false;
if ($userLoggedIn){
    // check if there is a data in request
    if(!empty($_POST)){
        // Get info from request
        $taskId = $_POST['id'];
        $userId = unserialize($_SESSION['USER'])->getId();
        $action = $_POST['do'];
        $data = $_POST['data'];
//        echo json_encode($data);
        if($action == "changeField"){
            // Change a field in a task
            $dbController = new Database();
            $field = $data['field'];
            if ($field == "tagId"){
                updateTags($data['value'], $taskId);
            }
            else{
                $value = $data['value'];
                if ($field == 'start' || $field == 'end'){
                    $offset = $data['offset'] * 60;
                    $value = $value - $offset;
                }
                if(!isset($value) || empty($value)) $value = 'undefined';
//                $dbController->query('UPDATE tasks SET '.$field.' = `' . $value . '` WHERE id = '.$taskId.' AND userId = '.$userId);
                $dbController->query("UPDATE tasks SET $field = :value WHERE id = :ID AND userId = :userID");
//                $dbController->bind(':field', $field);
                $dbController->bind(':value', $value);
                $dbController->bind(':ID', $taskId);
                $dbController->bind(':userID', $userId);
                $dbController->execute();
            }
            $returnValue = array('success'=>"true");
        }else if($action == "addTask"){
            // Add a task
            $dbController = new Database();
            $task = $data['task'];
            $offset = $data['offset'] * 60;
            $startTime = $task['startTime'];
            $startTime = $startTime - $offset;
            $endTime = $task['endTime'];
            if(!isset($endTime) || empty($endTime) || $endTime = 'undefined'){
                $endTime = NULL;
            }
            else {
                $endtime = $endtime - $offset;
            }
            $dbController->query('INSERT INTO tasks (description, start, end, userId, categoryId, projectId) VALUES (:NAME, :ST, :ET, :UID, :CATID, :PID)');
            $dbController->bind(':NAME', $task['name']) ;
            $dbController->bind(':ST', $startTime);
            $dbController->bind(':ET', $endTime);
            $dbController->bind(':UID', $userId );
            $dbController->bind(':CATID', $task['categoryApplied']);
            $dbController->bind(':PID', $task['projectApplied']);
            $dbController->execute();
            $lastId = $dbController->lastInsertId();
            $returnValue = array('add'=>$lastId);
        }else if($action == "deleteTask"){
            // Delete a task
            $dbController = new Database();
            $dbController->query('DELETE FROM tasks WHERE id = :ID');
            $dbController->bind(':ID', $taskId);
            $dbController->execute();
            $tags = $data['tagsApplied'];
            updateTags($tags, $taskId);
            $returnValue = array('success'=>"true");
        }else{
            // Something went wrong
            $returnValue = array('error'=>"invalidRequest");
        }
    }else{
        $returnValue = array('error'=>"noData");
    }
}else{
    $returnValue = array('error'=>"loginRequired");
}
echo json_encode($returnValue);
?>
