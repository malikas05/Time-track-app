<?php
$titlePageText = ' | Register';
$viewFile = __FILE__;
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->ULogin(0);
$func->checkForUser();

$func->registerPage();
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

            <div class="row">
                <h2>Please provide your details to register</h2>
                <script>

                </script>
                <!-- TODO PHP: check if user exist if yes display error message if no display sucess message -->
                <form class="col-sm-8" id="registerForm" action="register.php" method="post" target="_self" data-toggle="validator">
                    <div class="form-group">
                        <label for="registerName">Name</label>
                        <input type="text" class="form-control" id="registerName" placeholder="Name" data-minlength="2" required
                               name="name">
                        <div class="help-block">Minimum of 2 characters</div>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email address</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Email" pattern="/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i" placeholder="Email" data-error="Bruh, that email address is invalid" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Password" data-minlength="5" required>
                        <div class="help-block">Minimum of 5 characters</div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submitReg">Register</button>
                </form>

            </div>
        </div><!-- /.container -->
    </div>

    <?php
        require_once 'libs/footer.php';
    ?>
  </body>
</html>
