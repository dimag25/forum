<?php

require_once './CommonInterface.php';

class DatabaseInterface
{
    const debug = true;

    public function __construct()
    {
        $this->MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=forum", "root", "");
        $this->MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function GetMySQLdb()
    {
        return $this->MySQLdb;
    }

    /*
     * CheckErrors - if debug mode is set we will output the error in the response, if the debug is off we will be redirected to 404.php
     */
    public function CheckErrors($e, $pass = false)
    {
        if ($pass == true) return true;

        if (self::debug) {
            die($e->getMessage());
        } else {
            // return error if there is something strange in the database
            return_error(":)");
        }
    }

    public function GetAllPosts($id)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM posts");
            $cursor->execute();
            $retval = "";

            foreach ($cursor->fetchAll() as $obj) {
                if ($obj["user_id"] == $id) {
                    $retval .= "<li class='speech-bubble-right'><h2>{$obj["user_name"]}</h2><p>{$obj["post_data"]}<a style='float:right;color: white;margin-right: 20px;' href='#' onclick='post_edit(this);'>edit</a></p><input value='{$obj["post_id"]}' hidden></li>";
                } else {
                    $retval .= "<li class='speech-bubble-left'><h2>{$obj["user_name"]}</h2><p>{$obj["post_data"]}</p><input name='post_id' value='{$obj["post_id"]}' hidden></li>";
                }
            }

            return $retval;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function NewPost($id, $data, $name)
    {
        try {
            $cursor = $this->MySQLdb->prepare("INSERT INTO posts (user_id,post_data,user_name) value (:id,:post_data,:name)");
            $cursor->execute(array(":id" => $id, ":post_data" => $data, ":name" => $name));
            if ($cursor->rowCount()) return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function EditPost($id, $data)
    {
        try {
            $cursor = $this->MySQLdb->prepare("UPDATE posts SET post_data=:post_data WHERE post_id=:id");
            $cursor->execute(array(":id" => $id, ":post_data" => $data));
            if ($cursor->rowCount()) return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function Register($username, $password)
    {
        try {
            # Check if the username or email is taken
            $cursor = $this->MySQLdb->prepare("SELECT username FROM users WHERE username=:username");
            $cursor->execute(array(":username" => $username));
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }

        /* New User */
        if (!($cursor->rowCount())) {
            try {
                $cursor = $this->MySQLdb->prepare("INSERT INTO users (username, password) value (:username,:password)");
                $cursor->execute(array(":password" => $password, ":username" => $username));
                return array("success" => true, "data" => "You have successfully registered<br>");
            } catch (PDOException $e) {
                $this->CheckErrors($e);
            }
        } /* Already exists */
        else {
            return array("success" => false, "data" => "username already exists in the system<br>");
        }
    }

    public function Login($username, $password)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
            $cursor->execute();
        } //SQL injection
        catch (PDOException $e) {
            $this->CheckErrors($e);
        }

        if (!$cursor->rowCount()) {
            return array("success" => false, "data" => "Wrong Username/Password!<br>");
        } else {
            $cursor->setFetchMode(PDO::FETCH_ASSOC);
            return array("success" => true, "data" => $cursor->fetch());
        }
    }

    public function NewTopic($topic_name, $topic_description)
    {
        try {
            $cursor = $this->MySQLdb->prepare("INSERT INTO topic (topic_name,topic_description) value (:topic_name,:topic_description)");
            $cursor->execute(array(":topic_name" => $topic_name, ":topic_description" => $topic_description));
            if ($cursor->rowCount()) return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function GetAllTopics()
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM topic");
            $cursor->execute();
            $retval = "";
            $index = 1;
            foreach ($cursor->fetchAll() as $obj) {
                $retval .= "<div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse$index\">{$obj["topic_name"]}</a>                             
                                </h4>
                            </div>
                            <div id=\"collapse$index\" class=\"panel-collapse collapse in\">
                                <div class=\"panel-body\"><div class=\"forum-item active\">
                                        <div class=\"row\">
                                            <div class=\"col-md-9\">
                                                <div class=\"forum-icon\">
                                                    <i class=\"fa fa-shield\"></i>
                                                </div>
                                                <a href=\"./topic.php?topic_id={$obj["topic_id"]}\" class=\"forum-item-title\">{$obj["topic_name"]}</a>
                                                <div class=\"forum-sub-title\">{$obj["topic_description"]}</div>
                                            </div>
                                            <div class=\"col-md-1 forum-info\">
                            <span class=\"views-number\">
                                 {$obj["views"]}
                            </span>
                                                <div>
                                                    <small>Views</small>
                                                </div>
                                            </div>
                                            <div class=\"col-md-1 forum-info\">
                            <span class=\"views-number\">
                                {$obj["discussions"]}
                            </span>
                                                <div>
                                                    <small>Discussions</small>
                                                </div>
                                            </div>
                                            <div class=\"col-md-1 forum-info\">
                            <span class=\"views-number\">
                                {$obj["posts"]}
                            </span>
                                                <div>
                                                    <small>Posts</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div></div>
                            </div>
                        </div>";
                $index += 1;
            }
            return $retval;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function GetTopicDataById($id)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM topic where topic_id =:id ");
            $cursor->execute(array(":id" => $id));
            foreach ($cursor->fetchAll() as $row) {
                $topicName = $row['topic_name'];
                $topicDescription = $row['topic_description'];
                $views = $row['views'];
                $discussions = $row['discussions'];
                $posts = $row['posts'];
                $return_arr[] = array("topic_name" => $topicName,
                    "views" => $views,
                    "topic_description" => $topicDescription,
                    "discussions" => $discussions,
                    "posts" => $posts);
            }
            return json_encode($return_arr);
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function NewDiscussion($discuss_name, $discuss_description,$topicId)
    {
        try {
            $cursor = $this->MySQLdb->prepare("INSERT INTO discussions (discussion_name,discussion_desc,topic_id) 
            value (:discussion_name,:discussion_desc,:topic_id)");
            $cursor->execute(array(":discussion_name" => $discuss_name, ":discussion_desc" => $discuss_description,
                ":topic_id"=>$topicId));
            if ($cursor->rowCount()) return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function GetAllTopicDiscussions($topicId)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM discussions where topic_id =:topic_id ");
            $cursor->execute(array(":topic_id" => $topicId));
            $retval = "";
            $index = 1;
            foreach ($cursor->fetchAll() as $obj) {
                $retval .= "<div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse$index\">{$obj["discussion_name"]}</a>                             
                                </h4>
                            </div>
                            <div id=\"collapse$index\" class=\"panel-collapse collapse in\">
                                <div class=\"panel-body\"><div class=\"forum-item active\">
                                        <div class=\"row\">
                                            <div class=\"col-md-9\">
                                                <div class=\"forum-icon\">
                                                    <i class=\"fa fa-shield\"></i>
                                                </div>
                                                <a class=\"forum-item-title\">{$obj["discussion_name"]}</a>
                                                <div class=\"forum-sub-title\">{$obj["discussion_desc"]}</div>
                                            </div>
                                            <div class=\"col-md-1 forum-info\">
                            <span class=\"views-number\">
                                 {$obj["views_total"]}
                            </span>
                                                <div>
                                                    <small>Views</small>
                                                </div>
                                            </div>
                                            <div class=\"col-md-1 forum-info\">
                            <span class=\"views-number\">
                                {$obj["posts_total"]}
                            </span>
                                                <div>
                                                    <small>Posts</small>
                                                </div>
                                            </div>
                   
                                        </div>
                                    </div></div>
                            </div>
                        </div>";
                $index += 1;
            }
            return $retval;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }
}