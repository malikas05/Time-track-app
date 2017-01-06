<?php
$titlePageText = ' | Login';
$viewFile = __FILE__;
require_once 'php/FunctionClass.php';
$func = new FunctionClass();
$func->logOut();
$func->ULogin(0);
$func->checkForUser();

$func->loginPage();
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

    <div class="container boosterDown">

        <div class="row">
            <h2>Please provide your details to log in</h2>
            <script>

            </script>
            <!-- TODO PHP: check if user exist if yes display error message if no display sucess message -->
            <form class="col-sm-8" id="loginForm" action="login.php" method="post" target="_self" data-toggle="validator">
                <div class="form-group">
                    <label for="loginEmail">Email address</label>
                    <input type="email" class="form-control" id="loginEmail" placeholder="Email" name="email" pattern="/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i" data-error="Bruh, that email address is invalid" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="password" data-minlength="5" required>
                    <div class="help-block">Minimum of 5 characters</div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" name="rememberMe"> Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submitLog">Log In</button>
                <p>Not a user? Feel free to register <a href="register.php">here</a></p>
            </form>

        </div>
    </div>
</div>

<?php
require_once 'libs/footer.php';
?>
</body>
</html>
