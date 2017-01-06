<?php
$viewFile = __FILE__;
$titlePageText = ' | Tag Management';
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->ULogin(1);
$func->tagManagementPage();

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
            var tag_to_delete; // from php set to undefined if no user to delete
            tag_to_delete = "<?php if (isset($_GET['delete'])) echo $_GET['delete'];?>";
            var tag_to_edit; // from php set to undefined if no user to edit
            tag_to_edit = "<?php if (isset($_GET['edit'])) echo $_GET['edit'];?>";
            
            if(!!tag_to_delete){
                isError = true;
                errorMessage = "Please confirm that you want to delete tag <b>" + tag_to_delete +"</b>.";
                errorHeader = "Confirm deletion";
                errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
                                + '<a href="tag-management.php?delete='+ tag_to_delete +'&confirm=true" class="btn btn-danger" role="button">Confirm</a>';
            }else if(!!tag_to_edit){
                isError = true;
                errorMessage = '<form class="col-sm-8" id="editTagForm" action="tag-management.php" method="post" target="_self" data-toggle="validator">'+
                            '<div class="form-group"><label for="editName">Tag name</label><input type="text" class="form-control" id="editName" name="name" data-minlength="1" placeholder="Tag Name" required value="<?php if (isset($_GET['name'])) echo $_GET['name']; ?>"><div class="help-block">Minimum of 1 character</div></div>'+
                            '<div id="cp2" class="input-group colorpicker-component"><input name="colour" type="text" value="<?php if (isset($_GET['colour'])) echo $_GET['colour']; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div><br/>'+
                            '<input type="hidden" name="edit" value="<?php if (isset($_GET['edit'])) echo $_GET['edit']; ?>"><button type="submit" class="btn btn-success" name="save">Save</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>';
                errorHeader = "Edit tag "+ tag_to_edit;
                errorFooter = '';
            }

        </script>
        <!-- Time Entries -->
        <div class="container boosterDown">

            <div class="row">
                <h2>Manage Tags</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tag Name</th>
                            <th>Tag colour</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$allTags = $func->getTagsForCurrentUser();
						for ($i = 0; $i < count($allTags); ){ 
							$tag = $allTags[$i];                                            
                            $colour = $tag['colour'];
                            echo '<tr>
                                <th scope="row">'.++$i.'</th>
                                <td>'.$tag['title'].'</td>
                                <td style="color: #555555; background-color: '.$tag['colour'].'">'.$tag['colour'].'</td>
                                <td><a href="tag-management.php?edit='.$tag['tagId'].'&name='.$tag['title'].'&colour='.$colour.'" class="btn btn-primary" role="button">Edit</a></td>
                                <td><a href="tag-management.php?delete='.$tag['tagId'].'" class="btn btn-danger" role="button">Delete</a></td>
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
