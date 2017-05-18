<?php
session_start();

include "../DatabaseConnection.php";
include "../User.php";
include "Login.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title> Action Page | credu.me </title>

    <!-- ========== META Part ========== !-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="description" content="index">
    <meta name="author" content="beobe">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ========== CSS Part ========== !-->
    <link href="../../includes/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../includes/Font-Awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../includes/css/Home.css" rel="stylesheet">
    <link href="../../includes/css/Navbar.css" rel="stylesheet">

    <!-- ========== Javascript Part ========== !-->
    <script src="../../includes/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../includes/js/jquery-3.1.1.min.js"></script>
</head>
<?php
$isLogin = $_GET['isLogin'];
$error = $_GET['error'];
?>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid text-center">
        <div class="navbar-header">
            <a class="navbar-brand" href=""><h3>cred<span>u.me</span></h3></a>
        </div>
        <form class="navbar-form navbar-right" role="search">
            <a type="submit" class="btn btn-success" href=""><span class="fa fa-home"></span> Home</a>
        </form>
    </div>
</nav>
<div class="container">
    <br><br>
    <br><br>
    <div class="row">

        <div class="col-xs-2 col-sm-4">
            <!-- EMPTY -->
        </div>
        <div class="col-xs-8 col-sm-4">
            <div class="jumbotron action text-center">
                <?php if (!$error) { ?>
                    <p><?php echo ($isLogin) ? "Login" : "Logout" ?> action in progress, please wait.. </p>
                <?php } else { ?>
                    <p><?php echo $error ?></p>
                    <script type="text/javascript">
                        setTimeout(function () {
                            window.location.href = "./";
                        }, 3000);
                    </script>
                <?php } ?>
            </div>
            <?php
            if (!$error) { // Check if there is no error occured in the previous session..
                if ($isLogin) {
                    $databaseConnection = new DatabaseConnection();
                    $login = new Login($databaseConnection);

                    $email = $_GET['email'];
                    $password = $_GET['password'];

                    $login->login($email, $password);

                    if (!$login->getLatestError()) {
                        $_SESSION['loggedUserId'] = $login->getLoggedUserId();

                        echo '<script type="text/javascript">',
                        'window.location.href = "./";',
                        '</script>';
                    } else {
                        echo '<script type="text/javascript">',
                            'window.location.href = "./ActionPage.php?error=' . $login->getLatestError() . '";',
                        '</script>';
                    }
                } else {
                    session_unset();
                    session_destroy();

                    echo '<script type="text/javascript">',
                    'window.location.href = "./";',
                    '</script>';
                }
            }
            ?>
        </div>
        <div class="col-xs-2 col-sm-4">
            <!-- EMPTY -->
        </div>
    </div>
</div>
</body>
<script>
    function redirectIn(seconds) {
        setTimeout(function () {
            window.location.href = "./";
        }, seconds);
    }
</script>
</html>
