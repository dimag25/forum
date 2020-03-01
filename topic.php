<?php
require_once "permissions.php";

$user     = $_SESSION["user"];
$userid   = $_SESSION["userid"];
//$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$parts = parse_url($url);
//$query="";
//parse_str($parts['query'], $query);
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
            <li class="active"><a href="./main.php">Posts</a></li>
        </ul>
    </div>
</nav>
<head>
    <title>Topic:</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header" >
            <a class="navbar-brand" href="#" id="topicHeader">
                <?php
              //  echo $query['topic_id'];
                ?>
            </a>

        </div>
        <ul class="nav navbar-nav" style="float: right">
            <li><a href="#" id="logout">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="panel-group" id="topicAccordion">

</div>
<button type="submit"  id="newDiscuss" ><span class="glyphicon glyphicon-off" ></span>Add Discussion</button>
<!-- Modal -->
<div class="modal fade" id="discussModal" role="dialog">
    <div class="modal-dialog">
        <!-- Discussion Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <a href="#"></a> <h4></span> Add Discussion</h4>
            </div>
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">

                        <div class="panel-body" id="login-panel">
                            <form id="discussForm" action="#" method="POST">
                                <div class="input-group">
                                    <label for="discussName"><span class="glyphicon glyphicon-th"></span>Discussion Name</label>
                                    <input id="discuss_name" type="text" class="form-control" name="discussName" placeholder="Enter name...">
                                </div>
                                <br>
                                <div class="input-group">
                                    <label for="discussionDescription"><span class="glyphicon glyphicon-pencil"></span>Discussion Description</label>
                                    <input id="discuss_desc" type="text" class="form-control" name="discussionDescription" placeholder="Enter description..">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" id="addDiscussBtn">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div></div></div>

<script src="./assets/pages/helper.js"></script>
<script src="./assets/pages/topic.js"></script>
</body>
</html>
