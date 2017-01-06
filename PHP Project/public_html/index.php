<?php
$titlePageText = ' | Home';
$viewFile = __FILE__;
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->checkForUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
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

        <!-- Time Entries -->
        <div class="container boosterDown">
            <?php if($userLoggedIn){ ?>
            <h2>My Tasks</h2>
            <div id="tasksOfTheWeek">
            </div>
            <?php } else{
                ?>
                <h2>Please log In</h2>
                <p>It seems that you are not logged in and as a result we cannot save any tasks for you. Please <a href="#" data-toggle="modal" data-target="#signIn">log in</a> or <a href="register.php">create an account</a></p>
                <?php
            } ?>
        </div><!-- /.container -->
    </div>
    <?php if($userLoggedIn){ ?>
    <script type="text/javascript">
        updateTaskList();
    </script>
    <?php }
        require_once 'libs/footer.php';
    ?>
  </body>
</html>
