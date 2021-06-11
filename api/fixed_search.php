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
    else if(!$kit->_validate($data, $kit->get_fixed_search_list())){
        $conObg->detach();
        echo "You fool, Get Lost";
    }
    else{ // do everything here   
        //get user info
        $response = array("status" => "0");
        if($data->type || $data->topic ||$data->text){
            
            $qry = "SELECT ct.`content_id`, type.type, topic.`topic`, ct.`title`, ct.`content_text` FROM `content` ct join topic on ct.topic_id = topic.topic_id join type on topic.type_id = type.type_id WHERE (ct.title LIKE '%$data->text%' or ct.content_text LIKE '%$data->text%') and type.type LIKE '%$data->type%' and topic.topic LIKE '%$data->topic%' limit $data->limit ;";
            try {
                $data = mysqli_fetch_all(mysqli_query($link, $qry), MYSQLI_ASSOC);
                $response = array("status" => "1", "contents" => $data);
                //unlink file here
            } catch (Exception $e) { 
                $response = array("status" => "0");
            }
        }
        

        

        http_response_code(200);
        echo json_encode($response);
        $conObg->detach();
    }

    


?>