<?php
session_start();

include "../DatabaseConnection.php";
include "../User.php";
include "ChatArea.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title> Chat | credu.me </title>

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
    <link href="../../includes/css/Chat.css" rel="stylesheet">
    <link href="../../includes/css/Navbar.css" rel="stylesheet">

    <!-- ========== Javascript Part ========== !-->
    <script src="../../includes/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../includes/js/jquery-3.1.1.min.js"></script>
</head>
<?php
$isPrivate = $_GET['isPrivate'];
$chatRoomName = $_GET['chatRoomName'];
$pathToFolder = "./logs/" . $chatRoomName;
$pathToLog = $pathToFolder . "/log.html";

$userId = $_SESSION['loggedUserId'];

if (!$chatRoomName || isset($_SESSION['loggedUserId']) == null) {
    echo '<script type="text/javascript">',
    'window.location.href = "../Home/";',
    '</script>';
} else { ?>
    <body id="ChatRoom">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid text-center">
            <div class="navbar-header">
                <a class="navbar-brand" href="../Home"><h3>cred<span>u.me</span></h3></a>
            </div>
            <form class="navbar-form navbar-left" role="search">
                <a type="submit" class="btn btn-danger"
                   href="MiniGame?isPrivate=<?php echo $isPrivate; ?>&chatRoomName=<?php echo $chatRoomName; ?>"><i
                        class="fa fa-bomb" aria-hidden="true"></i> Thug Bird </a>
            </form>
            <form class="navbar-form navbar-right" role="search">
                <a type="submit" class="btn btn-success" href="../Home"><span class="fa fa-home"></span> Home</a>
                <a type="submit" class="btn btn-success" href="../Profile"><span class="fa fa-user"></span> Profile</a>
                <button id="logout" type="submit" class="btn btn-success"><span class="fa fa-sign-out"></span> Log Out
                </button>
            </form>
        </div>
    </nav>
    <?php if ($isPrivate) {
        $databaseConnection = new DatabaseConnection();

        $user1 = new User($databaseConnection, $userId);
        $user2 = new User($databaseConnection, $chatRoomName);

        $user1->fetchFriends();

        if (!$user1->isFriendOf($chatRoomName)) {
            echo '<script type="text/javascript">',
            'window.location.href = "../Home/";',
            '</script>';
        }
        ?>
        <div id="Private">
            <div class="text-center">
                <h3><i class="fa fa-lock" aria-hidden="true"></i> Private Chat Room </h3>
                <hr>
            </div>
            <br>
            <div class="container">
                <div class="row">
                    <br><br>
                    <div class="col-xs-12 col-sm-5">
                        <div id="DisplayArea">
                            <div class="text-center">
                                <h4><?php echo $user1->getFullName(); ?></h4>
                            </div>
                            <hr>
                            <p><i class="fa fa-share" aria-hidden="true"></i>
                                <?php echo $user2->getMessageFrom($userId); ?></p>
                        </div>
                        <br>
                        <form name="message_form" action="">
                            <input name="message" type="text" id="message" size=""/>
                            <input name="send" type="submit" id="send" value="Send"/>
                        </form>
                        <br>
                    </div>
                    <div class="col-xs-0 col-sm-2">
                        <br><br><br><br><br><br>
                        <hr>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div id="DisplayArea">
                            <div class="text-center">
                                <h4><?php echo $user2->getFullName(); ?></h4>
                            </div>
                            <hr>
                            <p><i class="fa fa-share" aria-hidden="true"></i>
                                <?php echo $user1->getMessageFrom($chatRoomName); ?></p>
                        </div>
                        <br>
                        <a onclick="location.reload(true);"> Refresh <i class="fa fa-refresh"
                                                                        aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br>
    <?php } else { ?>
        <div id="NoPrivate">
            <div class="text-center">
                <h3><i class="fa fa-users" aria-hidden="true"></i> Chat Room: <?php echo $chatRoomName ?></h3>
                <hr>
            </div>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 text-center">
                        <h4> Students </h4>
                        <hr>
                        <div id="RegisteredUsersArea"> <!-- USERS REGISTERED WILL BE DISPLAYED IN THIS DIVISION -->
                            <?php
                            $databaseConnection = new DatabaseConnection();
                            $chatArea = new ChatArea($databaseConnection, $chatRoomName);

                            if (!$chatArea->isCourseTakenBy($userId)) {
                                echo '<script type="text/javascript">',
                                'window.location.href = "../Home/";',
                                '</script>';
                            }

                            for ($i = 0; $i < count($chatArea->getRegisteredUsers()); $i++) {
                                echo '<h5>' . $chatArea->getRegisteredUsers()[$i]->getFullName() . '</h5>';
                            }
                            ?>
                        </div>
                        <br>
                    </div>
                    <div class="col-xs-1 col-md-0">

                    </div>
                    <div id="DisplayArea" class="col-xs-10 col-sm-9">
                        <br>
                        <form name="message_form" action="">
                            <input name="message" type="text" id="message" size="63"/>
                            <input name="send" type="submit" id="send" value="Send"/>
                        </form>
                        <br>
                        <div id="MessageArea"> <!-- MESSAGES WILL BE DISPLAYED IN THIS DIVISION -->
                            <?php
                            if (file_exists($pathToLog)) {
                                $fileStream = fopen($pathToLog, "r");
                                $contents = fread($fileStream, filesize($pathToLog));
                                fclose($fileStream);

                                echo $contents;
                            } else {
                                mkdir($pathToFolder, 0777, true);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    <?php } ?>
    </body>
<?php } ?>
<script>
    var isPrivate = "<?php echo $isPrivate; ?>";
    var chatRoomName = "<?php echo $chatRoomName; ?>";
    var pathToLog = "<?php echo $pathToLog; ?>";
    var userId = "<?php echo $userId; ?>";

    setInterval(getMessagesSent, 500);

    $(document).ready(function () {
        getMessagesSent();
    });

    $("#send").click(function () {
        if ($("#message").val().length > 0) {
            $.post("PostMessage.php", {
                isPrivate: isPrivate,
                course_id: chatRoomName,
                sender_id: userId,
                message: $("#message").val()
            });
        }

        $("#message").val("");

        if (!isPrivate)
            getMessagesSent();
        else
            for (var i = 0; i < 5; i++)
                location.reload(true);

        return false;
    });

    function getMessagesSent() {
        $.post("StoreMessagesSent.php", {
            pathToLog: pathToLog,
            chatRoomName: chatRoomName
        });

        $.ajax({
            url: pathToLog,
            cache: false,
            success: function (html) {
                $("#MessageArea").html(html);
            }
        });
    }

    $("#logout").click(function () {
        window.location.href = "../Home/ActionPage.php";

        return false;
    });
</script>
</html>