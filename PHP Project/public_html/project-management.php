<?php
$viewFile = __FILE__;
$titlePageText = ' | Project Management';
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->ULogin(1);
$func->projectManagementPage();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- TODO PHP: check if super user if yes then show the page otherwise redirect -->
<?php
    require_once 'libs/head.php';
?>

</head>
<body>
    <?php
        require_once 'libs/modals.php';
    ?>

    <!-- Main Content -->
    <div id="wrap">
        <?php
            require_once 'libs/navbar.php';
        ?>
        <script>
            var project_to_delete; // from php set to undefined if no user to delete
            project_to_delete = "<?php if (isset($_GET['delete'])) echo $_GET['delete'];?>";
            var project_to_edit; // from php set to undefined if no user to edit
            project_to_edit = "<?php if (isset($_GET['edit'])) echo $_GET['edit'];?>";
            var project_to_add; // set to false if no tag to add
            project_to_add = "<?php if (isset($_GET['addProj'])) echo $_GET['addProj'];?>";
            
            var project_limit_reached = false;  // set to false if tag limimt (20) is not reached
            var category_limit_reached = false;  // set to false if tag limimt (7) is not reached
            
            var category_to_delete; // from php set to undefined if no user to delete
            category_to_delete = "<?php if (isset($_GET['deleteCat'])) echo $_GET['deleteCat'];?>"
            var category_to_edit; // from php set to undefined if no user to edit
            category_to_edit = "<?php if (isset($_GET['editCat'])) echo $_GET['editCat'];?>";
            var category_to_add; // set to false if no tag to add
            category_to_add = "<?php if (isset($_GET['addCat'])) echo $_GET['addCat'];?>";
            
            if(!!project_to_delete){
                isError = true;
                errorMessage = "<p>Please confirm that you want to delete project.</p>";
                errorHeader = "Confirm deletion";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
                                + '<a href="project-management.php?delete=' + project_to_delete + '&confirm=true" class="btn btn-danger" role="button">Confirm</a>';
            }else if(!!project_to_edit){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="editProjectForm" action="project-management.php" method="post" target="_self" data-toggle="validator">'+
                            '<div class="form-group"><label for="editName">Project name</label><input type="text" class="form-control" id="editName" name="name" data-minlength="5" placeholder="Project Name" required value="<?php if (isset($_GET['name'])) echo $_GET['name']; ?>"><div class="help-block">Minimum of 5 characters</div></div>'+
                            '<label for="editColor">Color</label><div id="cp2" class="input-group colorpicker-component"><input name="colour" type="text" value="<?php if (isset($_GET['colour'])) echo $_GET['colour']; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div><br/>'+
                            '<input type="hidden" name="edit" value="<?php if (isset($_GET['edit'])) echo $_GET['edit']; ?>"><button type="submit" class="btn btn-success" name="save">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';
                errorHeader = "Edit project";
                errorFooter = '';
            }else if(!!project_to_add){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="addProjectForm" action="project-management.php" method="post" target="_self"                 data-toggle="validator">'+
                            '<div class="form-group"><label for="editName">Project name</label><input type="text" class="form-control" id="editName" name="name" data-minlength="5" placeholder="Project Name" required><div class="help-block">Minimum of 5 characters</div></div>'+
                            '<label for="editColor">Color</label><div id="cp2" class="input-group colorpicker-component"><input name="colour" type="text" value="#000000" class="form-control" /><span class="input-group-addon"><i></i></span></div><br/>'+
                            '<button type="submit" class="btn btn-success" name="saveNewProj">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';
                errorHeader = "Add project"
                errorFooter = '';
            }else if(project_limit_reached){
                isError = true;
                errorMessage = "<p>Cannot add more projects. You have a limit of 20 please delete or edit projects that you have.</p>";
                errorHeader = "Project limit reached";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>';
            }else if(category_limit_reached){
                isError = true;
                errorMessage = "<p>Cannot add more categories. You have a limit of 7 please delete or edit categories that you have.</p>";
                errorHeader = "Categories limit reached";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>';
            }else if(!!category_to_delete){
                isError = true;
                errorMessage = "<p>Please confirm that you want to delete category.</p>";
                errorHeader = "Confirm deletion";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
                                + '<a href="project-management.php?deleteCat=<?php if (isset($_GET['cat'])) echo $_GET['cat']; ?>&confirm=true" class="btn btn-danger" role="button">Confirm</a>';
            }else if(!!category_to_edit){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="editCategoryForm" action="project-management.php" method="post" target="_self" data-toggle="validator">'+
                            '<div class="form-group"><label for="editName">Category name</label><input type="text" class="form-control" id="editName" name="name" data-minlength="1" placeholder="Category Name" required value="<?php if (isset($_GET['name'])) echo $_GET['name']; ?>"><div class="help-block">Minimum of 1 character</div></div>'+
                            '<input type="hidden" name="cat" value="<?php if (isset($_GET['cat'])) echo $_GET['cat']; ?>"><button type="submit" class="btn btn-success" name="saveCat">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';
                errorHeader = "Edit category";
                errorFooter = '';
            }else if(!!category_to_add){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="addCategoryForm" action="project-management.php" method="post" target="_self"                 data-toggle="validator">'+
                            '<div class="form-group"><label for="editName">Category name</label><input type="text" class="form-control" id="editName" name="name" data-minlength="1" placeholder="Category Name" required><div class="help-block">Minimum of 1 character</div></div>'+
                            '<input type="hidden" name="projectId" value="<?php if (isset($_GET['proj'])) echo $_GET['proj']; ?>"><button type="submit" class="btn btn-success" name="saveNewCat">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';
                errorHeader = "Add category"
                errorFooter = '';
            }
        </script>
        <!-- Time Entries -->
        <div class="container boosterDown">
            <div class="row">
                <h2>Manage Projects and Categories</h2>
                <a href="project-management.php?addProj=true" class="btn btn-primary" role="button">Add Project</a>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Project colour</th>
                            <th>Categories</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $allProjects = $func->getThisWeekProjects();
                        for ($i = 0; $i < count($allProjects); ){ 
                            $project = $allProjects[$i];
                            $categories = '<a href="project-management.php?addCat=true&proj='.$project['id'].'" class="btn btn-primary" role="button">Add Category</a><br>';
                            foreach ($func->getCategoriesForProjects($project['id']) as $category){
                                $categories .= $category['title'].' <a href="project-management.php?editCat='.$project['id'].'&cat='.$category['id'].'&name='.$category['title'].'" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                <a href="project-management.php?deleteCat='.$project['id'].'&cat='.$category['id'].'" class="btn btn-danger btn-xs" role="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a><br/>';
                            }
                            $colour = $project['colour'];
                            echo '<tr>
                                <th scope="row">'.++$i.'</th>
                                <td>'.$project['title'].'</td>
                                <td style="color: #555555; background-color: '.$project['colour'].'">'.$project['colour'].'</td>
                                <td>'.$categories  
                                .'</td><td><a href="project-management.php?edit='.$project['id'].'&name='.$project['title'].'&colour='.$colour.'" class="btn btn-primary" role="button">Edit</a></td>
                                <td><a href="project-management.php?delete='.$project['id'].'" class="btn btn-danger" role="button">Delete</a></td>
                            </tr>';
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div><!-- /.container -->
    </div>

    <?php
        require_once 'libs/footer.php';
    ?>
    <script>
    $(function() {
        $('#cp2').colorpicker();
    });
</script>
  </body>
</html>
