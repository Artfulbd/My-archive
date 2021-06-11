<?php
    class Tools {
        private $fileReqUrl = "http://something.php";
        private $common = array('id','key','machine');
        private $create_type_list = array('type');
        private $create_topic_list = array('type_id', 'topic');
        private $create_content_list = array('type', 'topic','title','content');
        private $first_n_list = array('n');
        private $global_search_list = array('global', 'limit');
        private $fixed_search_list = array('type', 'topic', 'text', 'limit');
        private $topic_list = array('type');
        private $content_list = array('content_id');

        function _validate($data, $list){
            if($data == null){
                return false;
            }
            $size = count($list); $i = 0;
            // checking for property presence and injection
            
            while($i < $size && property_exists($data, $list[$i]) && $this->test_input($data->{$list[$i++]}));
            return ($size == $i && $this->checkKey($data));
        }

        private function checkKey($data){
            //check key machanism here
            return true;
        }
        
        function get_create_type_list(){
            return array_merge($this->common, $this->create_type_list);
        }
        function get_create_topic_list(){
            return array_merge($this->common, $this->create_topic_list);
        }
        function get_create_content_list(){
            return array_merge($this->common, $this->create_content_list);
        }
        function get_first_n_list(){
            return array_merge($this->common, $this->first_n_list);
        }
        function get_global_search_list(){
            return $this->global_search_list;
        }
        function get_fixed_search_list(){
            return $this->fixed_search_list;
        }
        function get_type_list(){
            return $this->common;
        }

        function get_topic_list(){
            return array_merge($this->common, $this->topic_list);
        }
        function get_content_list(){
            return array_merge($this->common, $this->content_list);
        }
        
        function test_input($data) {  // return true if VALID
            //$data = trim($data);
            $operators = array(
                ' select * ',
                ' select ',
                ' union all ',
                ' union ',
                ' all ',
                ' where ',
                ' and 1 ',
                ' and ',
                ' 1=1 ',
                ' 2=2',
                ' --',
                ' - -- '
            );
           
            if(is_array($data) || is_object($data))
            {
                $isInjection = false;
                foreach($data as $value)
                {
                    $isInjection =  $this->test_input($value) ? false : true;
                    
                    if($isInjection) return false;
                }
                return true;
            }
            else
            {
                foreach($operators as $operator)
                {
                    if (preg_match("/".$operator."/i", urldecode(strtolower($data)))) {
                        //printf("operator:%s: || data:%s:\n",$operator, $data);
                        return false;
                    }
                }
                $holdOn = $data;
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return strcmp($holdOn,$data)? false : true;
            }
        }

        // post request to server, cURL
        function make_req($url, $load ){
            //url-ify the data for the POST
            $json_string = json_encode($load);

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $json_string);

            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

            //execute post
            $result = curl_exec($ch);
            return $result;
        }

        //get client IP address
        function get_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }  
    
?>