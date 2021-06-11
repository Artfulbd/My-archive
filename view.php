<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/autocomplete.css">
    <title>Add something!</title>
</head>
<?php
    $content_id = null;
    $create_time = null;
    $edit_time = "Not edited yet";
    $catched_title = "Some title";
    $catched_type = "Somte Type";
    $catched_topic = "Some topic";
    $catched_text = "Some textvdfv";
    if(isset($_GET['take'])){
        $content_id = $_GET['take'];
    }
    // requesting and loading data
    $load = [
        'key' => 'some key',
        'id' => 'soe id',
        'machine' => 'do not know',
        'content_id' => $content_id
        ];
    $json_string = json_encode($load);
    $url = "localhost/archive/api/get_content.php";
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $json_string);

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

    //execute post
    //$result = curl_exec($ch);
    $data = json_decode(curl_exec($ch));
    if($data->status == 1)
    {
        $data = $data->content;
        /*print_r($data);
        echo $data[0]->title;*/
        $catched_title = $data[0]->title;
        $catched_type = $data[0]->type;
        $catched_topic = $data[0]->topic;
        $catched_text = $data[0]->content_text;
        $create_time = $data[0]->creation_time;
        $edit_time = $data[0]->edit_time == '' ? "Not edited yet" :$data[0]->edit_time;
    }
    
?>
<body>
<div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center mb-4 text-primary">📚 Take a look 📖</h4>
                        <button id="save_button" class="col-1 align-self-center" onclick=saveEdited()>Save</button>
                        <button id="edit_button" class="col-1 align-self-center" onclick=enableInput()>Edit</button>
                        <div class="basic-form">
                            <form id="main_data" autocomplete="off">
                                <div class="row mb-4">
                                    <div class="col-4"></div>
                                    <div class="col-4 align-self-center">
                                        <input id="type" type="text" class="form-control" placeholder= "<?php echo $catched_type; ?>" >
                                    </div>
                                    <div class="col-4"></div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-4">
                                        <input id="topic" type="text" class="form-control" placeholder="<?php echo $catched_topic; ?>">
                                    </div>
                                    <div id="warning"></div>
                                    
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <input id="title" type="text" class="form-control" placeholder="<?php echo $catched_title; ?>">
                                    </div>
                                    <div id="times">Created at: <?php echo $create_time; ?><br>Last edited: <?php echo $edit_time; ?></div>
                                    <div class="col-4"></div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <textarea id="text" class="form-control" placeholder="<?php echo $catched_text; ?>" id="w3review"  rows="10" cols="50"></textarea>
                                    </div>
                                    <div class="col-40"></div>
                                    
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="js/jqry.js" ></script>
<script>
    disableInput();

    function disableInput(){
        document.getElementById("save_button").disabled = true;
        document.getElementById("edit_button").disabled = true;
        document.getElementById("type").disabled = true;
        document.getElementById("topic").disabled = true;
        document.getElementById("title").disabled = true;
        document.getElementById("text").disabled = true;
        console.log("I was called");
    }

    function enableInput(){
        document.getElementById("edit_button").disabled = true;
        document.getElementById("save_button").disabled = false;
        document.getElementById("type").disabled = true;
        document.getElementById("topic").disabled = true;
        document.getElementById("title").disabled = true;
        document.getElementById("text").disabled = false;
        console.log("I was called");
    }
    
    function saveEdited(){
        saveEverything();
        disableInput();
        
    }

    function saveEverything(){
        var type = document.getElementById("type").value;
        var topic = document.getElementById("topic").value.trim();
        var title = document.getElementById("title").value.trim();
        var text = document.getElementById("text").value.trim();
        console.log("Type: "+type);

        if(type == '' || topic == '' || title == '' || text == ''){
            document.getElementById("warning").innerHTML = "Fillup every field..!";
        }else{
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            var url = "api/edit.php";
            var raw = "{\"id\":\"722240\",\"key\":\"nai\",\"machine\":\"nai\",\"type\":\""+type+"\",\"topic\":\""+topic+"\",\"title\":\""+title+"\",\"content\":\""+text+"\"}";
            var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
            };

            fetch(url, requestOptions)
            .then(response => response.json())
            .then(function(response){
            if(response.status == 1)
            {
                document.getElementById("warning").innerHTML = "Saved Successfully.!";
                location.reload();
            }
            else{
                document.getElementById("warning").innerHTML = "Already exists..!";
            }
        })
            .catch(error => console.log('error', error));
        }
        
                
    }
    

    
</script>
    

</body>
</html>