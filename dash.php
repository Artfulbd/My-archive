<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css.">
    


    <!-- Data Table Plugin-->
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
    <title>My Archive</title>
    <?php
        session_start();
        $_SESSION['status'] = "536";
    ?>

    

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-0" style="margin-top: -10px;">
                        <h4 class="text-center mb-3 text-primary">📚 My archive 👀</h4>
                        <button id="add" class="col-2 align-self-center" onclick=go_there()>Add new +</button>
                        <div class="basic-form">
                            <form>
                                <div class="row mb-4">
                                    <div class="col-4"></div>
                                    <div class="col-4 align-self-center">
                                        <input type="text" class="form-control" placeholder="Global search" oninput=globalSearch(this.value)>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="type" class="form-control" placeholder="Type search"  oninput=fixedSearch()>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="topic" class="form-control" placeholder="Topic search" oninput=fixedSearch()>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="text" class="form-control" placeholder="Content search" oninput=fixedSearch()>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive my-4">
                            <table class="table table-striped zero-configuration">
                                <thead>
                                <tr class=" text-white font-weight-bold" style="background: linear-gradient(90deg, rgba(0,159,255,1) 1%, rgba(0,255,110,1) 100%);">
                                    <th class="border-top-0">Type</th>
                                    <th class="border-top-0">Topic</th>
                                    <th class="border-top-0">Title</th>
                                    <th class="border-top-0">Content</th>
                                    
                                </tr>
                                </thead>
                                <tbody id="contents">
                                <tr>
                                    <td><a class="text-dark">lorem</a></td>
                                    <td><a class="text-dark">sit amet</a></td>
                                    <td><a class="text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, quibusdam.</a></td>
                                    <td><a class="text-dark">sit amet</a></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="js/jqry.js" ></script>

<script>
    function go_there(){
        window.open("add.html");
    }
      
        
      $(document).ready(function(){
        $('html').on('contextmenu', function(e){
          return false;
        })
      })

      function fixedSearch(){
          var type = document.getElementById("type").value;
          var topic = document.getElementById("topic").value;
          var text = document.getElementById("text").value;
          console.log("TYPE: "+type);
          console.log("TOPIC: "+topic);
          console.log("CONTENT: "+text);
          var url = "api/fixed_search.php";
          var raw = "{\"type\":\""+type+"\",\"topic\":\""+topic+"\",\"text\":\""+text+"\",\"limit\":\"20\"}";
          makeRequest(url, raw); 
        }

      function globalSearch(text){
        console.log("got: " + text);
        var url = "api/global_search.php";
        var raw = "{\"global\":\""+text+"\",\"limit\":\"20\"}";
        makeRequest(url, raw); 
      }

      var url = "api/first_n.php";
      var raw = JSON.stringify({
        "id": "722240",
        "key": "nai",
        "machine": "nai",
        "n": "20"
        });
      makeRequest(url, raw);  
     
      function makeRequest(url,raw){
        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
        };

        fetch(url, requestOptions)
        .then(response => response.json())
        .then(function(response){
            if(response.status){load_data(response);}})
        .catch(error => console.log('error', error));
      }

      function load_data(data){
        $("#contents").empty();
        console.log(data);
        
        $.each(data.contents, function (index, value) {
            var filtered_text = value.content_text.substring(0, 70);
            $("#contents").append('<tr><td>'+ value.type +'</td><td>' + value.topic+ '</td><td>'+ value.title +'</td><td><a href="/archive/view.php?take='+value.content_id+'" target="_blank" class="text-dark">'+filtered_text+'</a></td></tr>');
       
        });
      }    
</script>

</body>
</html>