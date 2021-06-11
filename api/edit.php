<?php
    header("Access-Controll-Allow-Origin: *");
    header("Access-Controll-Allow-Headers: access");
    header("Access-Controll-Allow-Methods: POST");
    header("Access-Controll-Allow-Credentials: true");
    header("Content-Type: application/json");

    include_once 'personal/connection.php';
    include_once 'personal/extraTools.php';

    $kit = new Tools();
    $conObg = new ConnectTo('archive');
    $link = $conObg->giveLink();  
    $data = json_decode(file_get_contents("php://input"));
    if($link == null){
        http_response_code(404);
        echo json_encode(array("status" => '0', "msg" => "problem on server"));
    }
    else if(!$kit->_validate($data, $kit->get_create_content_list())){
        $conObg->detach();
        echo "You fool, Get Lost";
    }
    else{ // do everything here   
        //get user info
        mysqli_autocommit($link, false);
        $response = array("status" => "0");
        $topic_id = -1;
        $type_id = -1;
        if($data->type){
            
            $qry1 = "SELECT `type_id`, `type` FROM `type` WHERE type = '$data->type';";
            $type = mysqli_fetch_all(mysqli_query($link, $qry1), MYSQLI_ASSOC);
            $type_id = $type == '' ? 0 : $type[0]['type_id'];   
        }

       if($type_id>0 && $data->topic){
            $qry1 = "SELECT `topic_id`, `topic` FROM `topic` WHERE topic = '$data->topic';";
            $topic = mysqli_fetch_all(mysqli_query($link, $qry1), MYSQLI_ASSOC);
            $topic_id = $topic == ''? 0 : $topic[0]['topic_id'];
        }

        if($topic_id > 0 && $data->title && $data->content){
            $qry = "SELECT `content_id` FROM `content` WHERE title = '$data->title';";
            $content_id = mysqli_fetch_all(mysqli_query($link, $qry), MYSQLI_ASSOC);
            if($content_id){
                $content_id = $content_id[0]['content_id'];
                $qry = "UPDATE `content` SET `content_text`= '$data->content', edit_time = CURRENT_TIMESTAMP WHERE content_id = $content_id;";
            }
            try {
                mysqli_query($link, $qry);
                $response = array("status" => "1");
                mysqli_commit($link);
                //unlink file here
            } catch (Exception $e) { 
                mysqli_rollback($link);
                $response = array("status" => "0");
            }
        };

        

        http_response_code(200);
        echo json_encode($response);
        $conObg->detach();
    }

    


?>