 <!DOCTYPE html>
    <html>
    <head>
        <title>How to Import XML Data into Mysql Table Using Ajax PHP</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
    <br />
    <div class="container">
        <div class="row">
            <h2 align="center">Import XML Data into Mysql Table Using Ajax PHP</h2>
            <br />
            <div class="col-md-9" style="margin:0 auto; float:none;">
                <span id="message"></span>
                <form method="post" id="import_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Select XML File</label>
                        <input type="file" name="file" id="file" />
                    </div>
                    <br />
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="btn btn-info" value="Import" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form id="searchForm" class="example" style="float: right; margin-right: 80px; margin-bottom: 15px" method="get" action="" enctype="multipart/form-data">
        <input type="text" placeholder="Search.." name="search" id="search" >
        <input type="submit" name="submitData" id="submitData" class="btn btn-info" value="Search" />
    </form>
    <span id="message"></span>
    <span id="messageData"></span>
    </body>
    </html>
    <script>
        $(document).ready(function(){
            $('#import_form').on('submit', function(event){
                event.preventDefault();

                $.ajax({
                    url:"import.php",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                        $('#submit').attr('disabled','disabled'),
                            $('#submit').val('Importing...');
                    },
                    success:function(data)
                    {
                        $('#message').html(data);
                        $('#import_form')[0].reset();
                        $('#submit').attr('disabled', false);
                        $('#submit').val('Import');
                    }
                })

                setInterval(function(){
                    $('#message').html('');
                }, 5000);

            });
            $('#searchForm').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"search.php",
                    method:"GET",
                    data:{search:$('#search').val()},
                    success:function(data)
                    {
                        $('#messageData').html(data);
                        $('#searchForm')[0].reset();
                        $('#submitData').attr('disabled', false);
                        $('#submitData').val('Search');
                    }
                })
            });
        });
    </script>
<?php
