<?php
$viewFile = __FILE__;
$titlePageText = ' | Admin Panel';
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->ULogin(3);
$func->userManagementPage();

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
            var user_to_delete;
            user_to_delete = "<?php if (isset($_GET['delete'])) echo $_GET['delete'];?>"; // from php set to undefined if no user to delete
            var user_to_edit;
            user_to_edit = "<?php if (isset($_GET['edit'])) echo $_GET['edit'];?>"; // from php set to undefined if no user to edit

            if(!!user_to_delete){
                isError = true;
                errorMessage = "Please confirm that you want to delete user <b>" + user_to_delete + "</b>.";
                errorHeader = "Confirm deletion";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
                    + '<a href="user-management.php?delete=' + user_to_delete + '&confirm=true" class="btn btn-danger" role="button">Confirm</a>';
            }else if(!!user_to_edit){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="editUserForm" action="user-management.php" method="post" target="_self" data-toggle="validator">'+
                    '<div class="form-group"><label for="editName">Name</label><input type="text" class="form-control" id="editName" placeholder="Name" name="name" data-minlength="2" required value="<?php if (isset($_GET['name'])) echo $_GET['name']; ?>"><div class="help-block">Minimum of 2 characters</div></div>'+
                    '<div class="form-group"><label for="editEmail">Email address</label><input type="email" class="form-control" id="editEmail" placeholder="Email" name="email" value="' + user_to_edit + '" placeholder="Email" data-error="Bruh, that email address is invalid" required><div class="help-block with-errors"></div></div>'+
                    '<div class="form-group"><label for="editPassword">Password</label><input type="password" class="form-control" id="editPassword" placeholder="Password" name="password" data-minlength="5" required><div class="help-block">Minimum of 5 characters</div></div>'+
                    '<input type="hidden" name="id" value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?>"><button type="submit" class="btn btn-success" name="save">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';

                errorHeader = "Edit user "+ user_to_edit;
                errorFooter = '';
            }

        </script>
        <div class="container boosterDown">

            <div class="row">
                <h2>Manage Users</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $allUsers = $func->getAllUsers();
                    for ($i = 0; $i < count($allUsers); ){ 
                        $user = $allUsers[$i];
                        echo '<tr>
                            <th scope="row">'.++$i.'</th>
                            <td>'.$user['email'].'</td>
                            <td>'.$user['name'].'</td>
                            <td><a href="user-management.php?edit='.$user['email'].'&name='.$user['name'].'&id='.$user['id'].'" class="btn btn-primary" role="button">Edit</a></td>
                            <td><a href="user-management.php?delete='.$user['email'].'" class="btn btn-danger" role="button">Delete</a></td>
                        </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
        require_once 'libs/footer.php';
    ?>
  </body>
</html>
