<?php
session_start();

include "../DatabaseConnection.php";
include "../User.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title> Edit Profile | credu.me </title>

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
    <link href="../../includes/css/Profile.css" rel="stylesheet">
    <link href="../../includes/css/Navbar.css" rel="stylesheet">

    <!-- ========== Javascript Part ========== !-->
    <script src="../../includes/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../includes/js/jquery-3.1.1.min.js"></script>
</head>
<?php if (isset($_SESSION['loggedUserId']) == null) {
    echo '<script type="text/javascript">',
    'window.location.href = "../Home/";',
    '</script>';
} else {
    $isChanging = $_GET['isChanging'];
    $newPhoneNumber = $_GET['newPhoneNumber'];
    $newPassword = $_GET['newPassword'];

    $canProceed = true;

    if ($isChanging) {
        if (!$newPhoneNumber && !$newPassword) {
            $canProceed = false;

            echo '<script type="text/javascript">',
            'window.location.href = "../Home/";',
            '</script>';
        }
    }

    if ($canProceed) { ?>
        <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../Home/"><h3>cred<span>u.me</span></h3></a>
                </div>
                <form class="navbar-form navbar-right" role="search">
                    <a type="submit" class="btn btn-success" href="../Home/"><span class="fa fa-home"></span>
                        Home</a>
                    <a type="submit" class="btn btn-success" href="./"><span class="fa fa-user"></span> Profile</a>
                    <button id="logout" type="submit" class="btn btn-success"><span class="fa fa-sign-out"></span>
                        Log
                        Out
                    </button>
                </form>
            </div>
        </nav>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-xs-2 col-md-4">
                    <!-- EMPTY -->
                </div>
                <div class="col-xs-8 col-md-4">
                    <div class="jumbotron">
                        <div class="jumbotron child">
                            <?php if ($isChanging) {
                                $databaseConnection = new DatabaseConnection();
                                $user = new User($databaseConnection, $_SESSION['loggedUserId']);

                                $user->setPhoneNumber($newPhoneNumber);
                                $user->setPassword($newPassword);

                                echo '<script type="text/javascript">',
                                'window.location.href = "./";',
                                '</script>';
                            } else { ?>
                                <form>
                                    <div class="form-input">
                                        <h3 class="green"> EDIT YOUR PROFILE </h3>
                                        <p> Leave empty if you don't want it to change! </p>
                                        <input id="NewPhoneNumber" type="text" class="form-control"
                                               placeholder="Phone Number" maxlength="18"/>
                                        <br>
                                        <input id="NewPassword" type="text" class="form-control"
                                               placeholder="Password" maxlength="18"/>
                                        <br>
                                        <button id="EditsButton" type="submit" class="btn btn-success"><span
                                                class="fa fa-pencil-square-o"></span>
                                            Edit
                                        </button>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 col-md-4">
                    <!-- EMPTY -->
                </div>
            </div>
        </div>
        </body>
    <?php }
} ?>
<script>
    $("#EditsButton").click(function () {
        if ($("#NewPhoneNumber").val().length > 0 || $("#NewPassword").val().length > 0) {
            var newPhoneNumber = $("#NewPhoneNumber").val();
            var newPassword = $("#NewPassword").val();

            window.location.href = "./EditProfilePage.php?isChanging=1&newPhoneNumber=" + newPhoneNumber + "&newPassword=" + newPassword;
        }

        return false;
    });

    $("#logout").click(function () {
        window.location.href = "../Home/ActionPage.php?isLogin=0";

        return false;
    });
</script>
</html>