<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> TimeTrack</a>
    <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <?php
            if($userLoggedIn){
                echo '<li class="dropdown">';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage <span class="caret"></span></a>';
                echo '<ul class="dropdown-menu">';
                echo '<li><a href="time-management.php">Time Entries</a></li>';
                echo '<li><a href="project-management.php">Projects and categories</a></li>';
                echo '<li><a href="tag-management.php">Tags</a></li>';
                if($isSuperUser){
                    echo '<li role="separator" class="divider"></li><li><a href="user-management.php">Users</a></li>';
                }
                echo '</ul>';
                echo '</li>';
            }
        ?>

        <li><?php
            if($userLoggedIn){
                echo  '<a href="'.$logOutPath.'">Log Out</a>';
            } else {
                echo '<a href="#" data-toggle="modal" data-target="#signIn">Log In</a>';
            }
        ?></li>
    </ul>
    <?php if($userLoggedIn){ ?>
    <div id="navbar" >
        <div class="form-inline col-sm-12 current-task" id="currentTask" data-day-id="cur">
        </div>
    </div><!--/.nav-collapse -->
    <?php } ?>
  </div>
</nav>
<?php if($userLoggedIn){ ?>
<script type="text/javascript">
    // Update Tags and Project Data for current task id there is a running task
    createCurrentTaskPlaceholder();
    updateTask(user_data.current, "#currentTask");
</script>
<?php } ?>
