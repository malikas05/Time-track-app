<?php
    $titleText = $titlePageText;
    $userLoggedIn = isset($_SESSION['USER_LOGIN_IN']) ? true : false;
    $isSuperUser = isset($_SESSION['USER']) ? unserialize($_SESSION['USER'])->getEmail() == 'mr.yavari@mail.ru' ? true : false : false;
    $logOutPath = "login.php";
    $ajaxHandler = "ajax.php";
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="img/clock.png">
<title>TimeTrack<?php echo $titleText; ?></title>
<!-- Bootstrap core CSS -->
<link href="vendors/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="vendors/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<link href="vendors/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="vendors/js/html5shiv.min.js" type="text/javascript"></script>
  <script src="vendors/js/respond.min.js" type="text/javascript"></script>
<![endif]-->
<!-- 3rd party libraries -->
<script src="vendors/js/jquery.min.js" type="text/javascript"></script>
<script src="vendors/js/moment.js" type="text/javascript"></script>
<script src="vendors/js/transition.js" type="text/javascript"></script>
<script src="vendors/js/collapse.js" type="text/javascript"></script>
<script src="vendors/js/bootstrap.min.js" type="text/javascript"></script>
<script src="vendors/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<!-- Interaction and Helper libraries -->
<script src="js/helpers.js" type="text/javascript"></script>
<script src="js/timer.js" type="text/javascript"></script>
<!-- Data loading script -->
<script type="text/javascript">
    // Use the follwoing to report any errors/issues to the user.
    var ajaxHandler = "<?php echo $ajaxHandler; ?>";
    var isError = false;
    var errorMessage = "Opps... you should not see this window. Something migth have gone wrong. If you see it try reloading this page.";
    var errorHeader = "No Error";
    var errorFooter = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    <?php
        echo $func->MessageShow();
    ?>
    var user_data = {
        today: 'mon', // will be updated latter
        currentTaskExists: false,
        <?php
            $func->printCurrentTask();
        ?>

        thisweek: {
            <?php
                $func->printWeekTasks();
            ?>
        },
        projects: [ // All projects available to user
            <?php
                $func->printWeekProjects();
            ?>
        ],
        tags: [ // All tags available to user
            <?php
                $func->printTagsForUser();
            ?>
        ]
    };
    // user_data is empty do fill with dummy data for current task if user_data == null
    if (user_data === null){
        user_data = {
            today: 'mon', // will be updated latter
            currentTaskExists: false,
            current: undefined,
            thisweek: {
                mon: undefined,
                tue: undefined,
                wed: undefined,
                thu: undefined,
                fri: undefined,
                sat: undefined
            },
            projects: [],
            tags: []
        };
    }
    var empty_task = {
        id: undefined,
        name: "Enter Task Description Here",
        tagsApplied: undefined,  //tag IDs as per tags object bellow
        projectApplied: 1,
        categoryApplied: undefined,
        startTime: undefined,
        endTime: undefined
    };
    if(user_data.current === undefined){
        user_data.current = JSON.parse(JSON.stringify(empty_task));
        user_data.currentTaskExists = false;
    }
    </script>
</script>

<script src="js/interface.js" type="text/javascript"></script>
