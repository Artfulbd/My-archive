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
    else if(!$kit->_validate($data, $kit->get_create_topic_list())){
        $conObg->detach();
        echo "You fool, Get Lost";
    }
    else{ // do everything here   
        //get user info
        $response = array("status" => "1");
        $qry = "INSERT INTO `topic` ( `topic`, `type_id`) VALUES ('$data->topic', $data->type_id);";
        try {
            mysqli_query($link, $qry);
            //unlink file here
        } catch (Exception $e) { 
            $response = array("status" => "0");
        }

        

        http_response_code(200);
        echo json_encode($response);
        $conObg->detach();
    }

    


?>