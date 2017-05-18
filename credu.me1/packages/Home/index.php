<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Home | credu.me </title>

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

<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid text-center">
        <div class="navbar-header">
            <a class="navbar-brand" href=""><h3>cred<span>u.me</span></h3></a>
        </div>
        <?php if (isset($_SESSION['loggedUserId']) != null) { ?>
            <form class="navbar-form navbar-right" role="search">
                <a type="submit" class="btn btn-success" href="../Profile"><span class="fa fa-user"></span> Profile</a>
                <button id="logout" type="submit" class="btn btn-success"><span class="fa fa-sign-out"></span> Log Out
                </button>
            </form>
        <?php } ?>
    </div>
</nav>
<div class="container-fluid">
    <br><br>
    <br><br>
    <div class="row">
        <div class="col-xs-0 col-sm-1">
            <!-- EMPTY -->
        </div>
        <div class="col-xs-12 col-sm-8">
            <h1>Sign In.</h1>
            <h1>Start Chatting with Your Classmates.</h1>
            <h1>Expand Your Network.</h1>
            <br><br>
        </div>
        <div class="col-xs-2 col-sm-0">
            <!-- EMPTY -->
        </div>
        <div class="col-xs-8 col-sm-2">
            <?php if (isset($_SESSION['loggedUserId']) != null) { ?>
                <!-- Do nothing.. -->
            <?php } else { ?>
                <div class="jumbotron text-center">
                    <form>
                        <div class="form-input">
                            <h3> LOG IN </h3>
                            <br>
                            <input id="email" type="text" class="form-control" placeholder="Email"/>
                            <br>
                            <input id="password" type="password" class="form-control" placeholder="Password"/>
                            <br>
                            <button id="sign" type="submit" class="btn btn-success"><span class="fa fa-sign-in"></span>
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div class="col-xs-2 col-sm-1">
            <!-- EMPTY -->
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br>
</body>
<script>
    $("#sign").click(function () {
        if ($("#email").val().length > 0 && $("#password").val().length > 0) {
            window.location.href = "./ActionPage.php?isLogin=1&error=0&email=" + $("#email").val() + "&password=" + $("#password").val();
        } else {
            location.reload(true);
        }

        return false;
    });

    $("#logout").click(function () {
        window.location.href = "ActionPage.php";

        return false;
    });
</script>
</html>
