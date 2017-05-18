<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> ThugBird | credu.me </title>

    <!-- ========== META Part ========== !-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="description" content="index">
    <meta name="author" content="beobe">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- ========== CSS Part ========== !-->
    <link href="../../../includes/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../includes/Font-Awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../../includes/css/MiniGame.css" rel="stylesheet">
    <link href="../../../includes/css/Navbar.css" rel="stylesheet">

    <!-- ========== Javascript Part ========== !-->
    <script src="../../../includes/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../includes/js/jquery-3.1.1.min.js"></script>
</head>
<?php if (isset($_SESSION['loggedUserId']) == null) {
    echo '<script type="text/javascript">',
    'window.location.href = "../../Home/";',
    '</script>';
} else {
$previousIsPrivate = $_GET['isPrivate'];
$previousChatRoomName = $_GET['chatRoomName'];

?>
<body id="ChatRoom">
<nav class="navbar navbar-inverse">
    <div class="container-fluid text-center">
        <div class="navbar-header">
            <a class="navbar-brand" href="../../Home"><h3>cred<span>u.me</span></h3></a>
        </div>
        <form class="navbar-form navbar-right" role="search">
            <a type="submit" class="btn btn-danger"
               href="../?isPrivate=<?php echo $previousIsPrivate; ?>&chatRoomName=<?php echo $previousChatRoomName; ?>"><i
                    class="fa fa-times" aria-hidden="true"></i> Go Back </a>
        </form>
    </div>
</nav>
<body>
<?php } ?>
<script src=GamePlay.js></script>
<script src=Environment.js></script>
<script src=Item.js></script>
<script src=Bird.js></script>
</body>
</html>