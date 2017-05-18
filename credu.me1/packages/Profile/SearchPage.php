<?php
session_start();

include "../DatabaseConnection.php";
include "../User.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title> Search | credu.me </title>

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
$firstName = $_GET['firstName'];
$lastName = $_GET['lastName'];

if (isset($_SESSION['loggedUserId']) == null) {
    echo '<script type="text/javascript">',
    'window.location.href = "../Home/";',
    '</script>';
} else { ?>
    <body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="../Home/"><h3>cred<span>u.me</span></h3></a>
            </div>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input id="SearchedUser" type="text" class="form-control" placeholder="John Smith">
                </div>
                <button id="SearchUser" type="submit" class="btn btn-success"><span class="fa fa-search"></span>
                    Search
                </button>
            </form>
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
    <div class="container">
        <br><br>
        <br><br>
        <div class="row">

            <div class="col-xs-2 col-sm-4">
                <!-- EMPTY -->
            </div>
            <div class="col-xs-8 col-sm-4">
                <div class="all-center">
                    <div class="jumbotron">
                        <div class="jumbotron child">
                            <h4> Search Results </h4>
                            <div id="scrollbox">
                                <div class="list-group">
                                    <?php
                                    $databaseConnection = new DatabaseConnection();

                                    $databaseConnection->initiateConnection();
                                    $connection = $databaseConnection->getConnection();

                                    $sql_query = "SELECT * FROM USERS WHERE FIRST_NAME = '" . $firstName . "' OR LAST_NAME = '" . $lastName . "'
                                                  ORDER BY FIRST_NAME, LAST_NAME";
                                    $sql_result = mysqli_query($connection, $sql_query);

                                    while ($row = mysqli_fetch_assoc($sql_result)) { ?>
                                        <a class="list-group-item list-group-item last"
                                           onclick="seeProfileOf('<?php echo $row['ID']; ?>')"><?php echo $row['FIRST_NAME'] . " " . $row['LAST_NAME'] ?></a>
                                    <?php }

                                    $databaseConnection->killConnection();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 col-sm-4">
                <!-- EMPTY -->
            </div>
        </div>
    </div>
    </body>
<?php } ?>
<script>
    var firstName = "<?php echo $firstName ?>";
    var lastName = "<?php echo $lastName ?>";

    $(document).ready(function () {
        $("#SearchedUser").val(firstName + " " + lastName);
    });

    $("#SearchUser").click(function () {
        if ($("#SearchedUser").val().length > 0) {
            var fullName = $("#SearchedUser").val();
            var names = fullName.split(" ");

            if (names.length == 2)
                window.location.href = "./SearchPage.php?firstName=" + names[0] + "&lastName=" + names[1];
        }

        $("#SearchedUser").val("");

        return false;
    });

    $("#logout").click(function () {
        window.location.href = "../Home/ActionPage.php?isLogin=0";

        return false;
    });

    function seeProfileOf(userId) {
        window.location.href = "./?userId=" + userId;
    }
</script>
</html>
