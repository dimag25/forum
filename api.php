<?php
require_once "./permissions.php";
require_once "./CommonInterface.php";
require_once "./DatabaseInterface.php";

$userid = $_SESSION["userid"];
$username = $_SESSION["user"];
$databaseObj = new DatabaseInterface();

$input = json_decode(file_get_contents('php://input'), false);

if (!is_object($input)) {
    return_error("nice try :)");
}

if (!isset($input->action)) {
    return_error("nice try :)");
}

switch ($input->action) {
    case "get_all_posts":
        if ($data = $databaseObj->GetAllPosts($userid)) {
            return_success($data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "new_post":
        if ($databaseObj->NewPost($userid, $input->data, $username)) {
            return_success($input->data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "edit_post":
        if ($databaseObj->EditPost($input->post_id, $input->data)) {
            return_success($input->data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "get_all_topics":
        if ($data = $databaseObj->GetAllTopics()) {
            return_success($data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "get_topic_data":
        if ($data = $databaseObj->GetTopicDataById($input->topicId)) {
            return_success($data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "get_topic_discuss":
        if ($data = $databaseObj->GetAllTopicDiscussions($input->topicId)) {
            return_success($data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "new_topic":
        if ($databaseObj->NewTopic($input->topicName, $input->topicDesc)) {
            return_success($input->data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "new_discussion":
        if ($databaseObj->NewDiscussion($input->discussionName, $input->disccusionDesc,$input->topicId)) {
            return_success($input->data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "logout":
        session_destroy();
        return_success("logged out");
        break;

    default:
        return_error("Malformed request");
}

