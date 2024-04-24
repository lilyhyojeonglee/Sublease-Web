<?php

$houseId = $_GET['id']; 
include 'views/show.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">

    <style>
        body {
            padding-top: 20px;
        }
        .gallery {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Adjusts to a 2x2 grid */
            gap: 10px;
        }
        .gallery img {
            width: 100%;
            height: auto;
        }
        .info-box {
            padding: 15px;
            border: 1px solid #ccc;
            margin-top: 15px;
        }
        .info-box header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .large-image img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
   
<script>
    // JavaScript function to reveal contact information
    function revealContact() {
    fetch('/getContactInfo')  // Assuming '/getContactInfo' is the endpoint we will create in PHP
        .then(response => response.text())
        .then(data => {
            document.getElementById('contact-info').innerText = data;
        })
        .catch(error => console.error('Error fetching contact info:', error));
}
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
