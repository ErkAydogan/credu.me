<?php
session_start();

include "../DatabaseConnection.php";
include "../User.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title> Profile | credu.me </title>

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
    $databaseConnection = new DatabaseConnection();
    $userIdFromGet = $_GET['userId'];
    $isAddingFriend = $_GET['isAddingFriend'];
    $isRemovingFriend = $_GET['isRemovingFriend'];

    $user = null;
    $isOtherUser = false;
    $canProceed = true;

    if ($userIdFromGet) {
        $tempUser = new User($databaseConnection, $userIdFromGet);

        if (!$tempUser->doesUserExist()) {
            $canProceed = false;

            echo '<script type="text/javascript">',
            'window.location.href = "./";',
            '</script>';
        }
    }

    if ($canProceed) {
        if ((!$userIdFromGet || $userIdFromGet == $_SESSION['loggedUserId']) && ($isAddingFriend || $isRemovingFriend)) {
            echo '<script type="text/javascript">',
            'window.location.href = "./";',
            '</script>';
        } else {
            if (!$userIdFromGet || $userIdFromGet == $_SESSION['loggedUserId']) {
                $user = new User($databaseConnection, $_SESSION['loggedUserId']);
            } else {
                $user = new User($databaseConnection, $userIdFromGet);
                $isOtherUser = true;
            }

            $user->fetchFriends();
            $user->fetchCoursesTaken();
            ?>
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
                <div class="row">
                    <div class="col-xs-2 col-md-4">
                        <!-- EMPTY -->
                    </div>
                    <div class="col-xs-8 col-md-4">
                        <div class="jumbotron">
                            <div class="jumbotron child">
                                <?php
                                $user->printUserInfo();
                                $loggedUser = new User($databaseConnection, $_SESSION['loggedUserId']);

                                if ($isAddingFriend) {
                                    $loggedUser->addFriend($user->getUserId());

                                    echo '<script type="text/javascript">',
                                    'alert("You successfully added a friend..");',
                                    '</script>';

                                    echo '<script type="text/javascript">',
                                        'window.location.href = "./?userId=' . $user->getUserId() . '";',
                                    '</script>';
                                } else if ($isRemovingFriend) {
                                    $loggedUser->removeFriend($user->getUserId());

                                    echo '<script type="text/javascript">',
                                        'window.location.href = "./?userId=' . $user->getUserId() . '";',
                                    '</script>';
                                } else if ($isOtherUser) {
                                    if ($user->isFriendOf($loggedUser->getUserId())) { ?>
                                        <a class="link"
                                           onclick="sendPrivateMessageTo('<?php echo $user->getUserId(); ?>');"><i
                                                class="fa fa-share" aria-hidden="true"></i> Send Private Message </a>
                                        <br>
                                        <a class="link"
                                           href="./?isRemovingFriend=1&userId=<?php echo $user->getUserId(); ?>"><i
                                                class="fa fa-close" aria-hidden="true"></i> Remove Friend
                                        </a>
                                    <?php } else { ?>
                                        <a class="link"
                                           href="./?isAddingFriend=1&userId=<?php echo $user->getUserId(); ?>"><i
                                                class="fa fa-plus" aria-hidden="true"></i> Add as Friend </a><br>
                                    <?php }
                                } else { ?>
                                    <a class="link" href="./EditProfilePage.php"><i class="fa fa-pencil-square-o"
                                                                                    aria-hidden="true"></i> Edit Profile
                                    </a><br>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-md-4">
                        <!-- EMPTY -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-md-1">
                        <!-- EMPTY -->
                    </div>
                    <div class="col-xs-8 col-md-4">
                        <div class="jumbotron">
                            <div class="jumbotron child">
                                <h4> Courses Taken [<?php echo count($user->getCoursesTaken()); ?>]</h4>
                                <div id="scrollbox">
                                    <div class="list-group">
                                        <?php
                                        /** ----- PRINTING COURSES TAKEN ----- */
                                        for ($i = 0; $i < count($user->getCoursesTaken()); $i++) {
                                            if ($i == count($user->getCoursesTaken()) - 1) { ?>
                                                <a class="list-group-item list-group-item last"
                                                   onclick="joinChatRoom('<?php echo $user->getCoursesTaken()[$i]; ?>');"><?php echo $user->getCoursesTaken()[$i]; ?></a>
                                            <?php } else { ?>
                                                <a class="list-group-item list-group-item"
                                                   onclick="joinChatRoom('<?php echo $user->getCoursesTaken()[$i]; ?>');"><?php echo $user->getCoursesTaken()[$i]; ?></a>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <!-- EMPTY -->
                    </div>
                    <div class="col-xs-2 col-md-1">
                        <!-- EMPTY -->
                    </div>
                    <div class="col-xs-8 col-md-4">
                        <div class="jumbotron">
                            <div class="jumbotron child">
                                <h4>Friends [<?php echo count($user->getFriends()); ?>]</h4>
                                <div id="scrollbox">
                                    <div class="list-group">
                                        <?php
                                        /** ----- PRINTING FRIENDS ----- */
                                        for ($i = 0; $i < count($user->getFriends()); $i++) {
                                            if ($i == count($user->getFriends()) - 1) { ?>
                                                <a class="list-group-item list-group-item last"
                                                   onclick="seeProfileOf('<?php echo $user->getFriends()[$i]->getUserId(); ?>')"><?php echo $user->getFriends()[$i]->getFullName(); ?></a>
                                            <?php } else { ?>
                                                <a id="UserLink" href="#"
                                                   class="list-group-item list-group-item"
                                                   onclick="seeProfileOf('<?php echo $user->getFriends()[$i]->getUserId(); ?>')"><?php echo $user->getFriends()[$i]->getFullName(); ?></a>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-md-1">
                        <!-- EMPTY -->
                    </div>
                </div>
            </div>
            </body>
        <?php }
    }
} ?>
<script>
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

    $("#ChatRoomLink").click(function () {
        alert($("#ChatRoomLink").innerText);
    });

    function sendPrivateMessageTo(userId) {
        window.location.href = "../Chat/?isPrivate=1&chatRoomName=" + userId;
    }

    function joinChatRoom(chatRoomName) {
        window.location.href = "../Chat/?chatRoomName=" + chatRoomName;
    }

    function seeProfileOf(userId) {
        window.location.href = "./?userId=" + userId;
    }
</script>
</html>