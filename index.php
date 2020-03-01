<?php
require_once './DatabaseInterface.php';

$databaseObj = new DatabaseInterface();

/* Start session if none */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error_message = null;
$success_message = null;

if (isset($_POST['r_password']) && isset($_POST['r_username'])) {
    $password = $_POST['r_password'];
    $username = $_POST['r_username'];
    $return_array = $databaseObj->Register($username, $password);

    if ($return_array["success"] == false) {
        $error_message = $return_array["data"];
    } else {
        $success_message = $return_array["data"];
    }

} else if (isset($_POST['l_password']) && isset($_POST['l_username'])) {
    $password = $_POST['l_password'];
    $username = $_POST['l_username'];

    $return_array = $databaseObj->Login($username, $password);

    if ($return_array["success"] == false) {
        $error_message = $return_array["data"];
    } else {
        /* set session */
        $_SESSION["user"] = $return_array["data"]["username"];
        $_SESSION["userid"] = $return_array["data"]["id"];

        /* set cookie */
        die(Header("Location: ./main.php"));
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Forum</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="./index.php">Home</a></li>
            <?php /* Check if the user already logged in */
            if (isset($_SESSION["user"])) {
                echo '<li class="active"><a href="./main.php">Posts</a></li>';
                echo '<li><a href="./index.php" id="logout">Logout</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>
<head>
    <title>Login/Regsiter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/custom.css">

</head>
<body>
<section class="col-md-12 column">

    <ol class="breadcrumb">
        <li><a href="#">Forum</a></li>
        <li><a href="#" id="myBtn">Login</a></li>
        <li class="active">Help me in this code?</li>

    </ol>
</section>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <!-- Modal -->
    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Login/Register Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="padding:35px 50px;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <a href="#"></a> <h4><span class="glyphicon glyphicon-lock"></span> Login/Register</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                </div>
                                <div class="panel-body" id="login-panel">
                                    <form id="myForm" action="#" method="POST">
                                        <div class="input-group">
                                            <label for="l_username"><span class="glyphicon glyphicon-user"></span>
                                                Username</label>
                                            <input id="l_email" type="text" class="form-control" name="l_username"
                                                   placeholder="username">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <label for="l_password"><span class="glyphicon glyphicon-eye-open"></span>
                                                Password</label>
                                            <input id="l_password" type="password" class="form-control"
                                                   name="l_password" placeholder="password">
                                        </div>
                                        <br>
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="" checked>Remember me</label>
                                        </div>
                                        <a href="#" id="login">
                                            <button type="submit" class="btn btn-success btn-block"><span
                                                        class="glyphicon glyphicon-off"></span> Login
                                            </button>
                                            <?php
                                            if (isset($error_message)) {
                                                echo "<div class='alert alert-danger'><strong>Error:</strong>" . $error_message . "</div>";
                                            } else if (isset($success_message)) {
                                                echo "<div class='alert alert-success'><strong>Note:</strong>" . $success_message . "</div>";
                                            }
                                            ?>
                                    </form>
                                </div>
                                <div class="panel-body" id="register-panel" hidden>
                                    <form action="#" method="POST">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-user"></i></span>
                                            <input id="r_username" type="text" class="form-control" name="r_username"
                                                   placeholder="username">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-lock"></i></span>
                                            <input id="r_password" type="password" class="form-control"
                                                   name="r_password" placeholder="password">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-home"></i></span>
                                            <input id="r_address" type="text" class="form-control" name="r_address"
                                                   placeholder="address" required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-usd"></i></span>
                                            <input id="r_bank" type="text" class="form-control" name="r_bank"
                                                   placeholder="Bank_Name"
                                                   required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-qrcode"></i></span>
                                            <input id="r_accountId" type="text" class="form-control" name="r_accountId"
                                                   placeholder="Account_Number" required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-briefcase"></i></span>
                                            <input id="r_accountDesc" type="text" class="form-control"
                                                   name="r_accountDesc"
                                                   placeholder="Account_Description" required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
                                            <input id="r_zipCode" type="text" class="form-control" name="r_zipCode"
                                                   placeholder="Zip_Code" required>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">register</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove"></span> Cancel
                    </button>

                    <p>Not a member? <a href="#" id="register">Sign Up</a></p>
                    <p>Forgot <a href="#">Password?</a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="ibox-content m-b-sm border-bottom">
                    <div class="p-xs">
                        <div class="pull-left m-r-md">
                            <i class="fa fa-globe text-navy mid-icon"></i>
                        </div>
                        <h2>Welcome to our forum</h2>
                        <span>Feel free to choose topic you're interested in.</span>
                    </div>
                </div>
                <button type="submit" id="newTopic"><span class="glyphicon glyphicon-off"></span>Add Topic</button>

                <div class="ibox-content forum-container">

                    <div class="forum-title">
                        <div class="pull-right forum-desc">
                            <samll>Total posts: 320,800</samll>
                        </div>
                        <h3>General subjects</h3>
                    </div>


                    <div class="panel-group" id="accordion">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="topicModal" role="dialog">
    <div class="modal-dialog">
        <!-- Topic Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <a href="#"></a> <h4></span> Add Topic</h4>
            </div>
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">

                        <div class="panel-body" id="login-panel">
                            <form id="topicForm" action="#" method="POST">
                                <div class="input-group">
                                    <label for="topic_name"><span class="glyphicon glyphicon-th"></span>Topic
                                        Name</label>
                                    <input id="topic_name" type="text" class="form-control" name="topic_name"
                                           placeholder="topic_name">
                                </div>
                                <br>
                                <div class="input-group">
                                    <label for="topic_description"><span class="glyphicon glyphicon-pencil"></span>Topic
                                        Description</label>
                                    <input id="topic_description" type="text" class="form-control"
                                           name="topic_description" placeholder="topic_description">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" id="addTopicBtn">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./assets/pages/helper.js"></script>
<script src="./assets/pages/index.js"></script
</body>
</html>