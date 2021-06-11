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
    else if(!$kit->_validate($data, $kit->get_topic_list())){
        $conObg->detach();
        echo "You fool, Get Lost";
    }
    else{ // do everything here   
        //get user info
        $response = array("status" => "0");
        $qry2 = "SELECT `topic_id`, `topic` FROM `topic` 
        join type on topic.type_id = type.type_id
        WHERE type.type = '$data->type';";
        try {
            $topics = mysqli_fetch_all(mysqli_query($link, $qry2), MYSQLI_ASSOC);
            $response = array("status" => "1", "topics" => $topics);
            //unlink file here
        } catch (Exception $e) { 
            $response = array("status" => "0");
        }

        

        http_response_code(200);
        echo json_encode($response);
        $conObg->detach();
    }

    


?>