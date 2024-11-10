<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo '<script>window.location.href = "../user/login.php";</script>';
    exit();
}

include("../important/db.php");

$icon = "home";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google+ Data Import</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Google+ Data Import</h1>
        <form id="uploadForm" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label for="file" class="col-sm-2 control-label">Select ZIP File:</label>
                <div class="col-sm-10">
                    <input type="file" id="file" name="file" class="form-control" accept=".zip" required>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Enter Username:</label>
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>

        <div id="response"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('http://serv00.net/apiv1-internal/take_out_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                document.getElementById('response').innerHTML = JSON.stringify(data, null, 2);
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
