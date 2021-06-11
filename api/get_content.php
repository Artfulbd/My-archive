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
    else if(!$kit->_validate($data, $kit->get_content_list())){
        $conObg->detach();
        echo "You fool, Get Lost";
    }
    else{ // do everything here   
        //get user info
        $response = array("status" => "1");
        $qry = "SELECT type, type.type_id, topic, ct.`topic_id`, ct.`title`, ct.`content_text`, ct.`creation_time`, ct.`edit_time`, ct.`last_viewed` FROM `content` ct 
        join topic on topic.topic_id = ct.topic_id 
        join type on type.type_id = topic.type_id 
        WHERE content_id =  $data->content_id;";
        try {
            $data = mysqli_fetch_all(mysqli_query($link, $qry), MYSQLI_ASSOC);
            $response = array("status" => "1", "content" => $data);
            //unlink file here
        } catch (Exception $e) { 
            $response = array("status" => "0");
        }

        

        http_response_code(200);
        echo json_encode($response);
        $conObg->detach();
    }

    


?>