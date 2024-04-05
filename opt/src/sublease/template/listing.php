<?php

$houseId = $_GET['id']; 
include("views/show.php");
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
        var contactInfo = document.getElementById('contact-info');
        // Check the current state of the paragraph text
        if (contactInfo.innerText === 'Log in to reveal') {
            contactInfo.innerText = 'email@example.com'; // Replace with your actual email
        } else {
            contactInfo.innerText = 'Log in to reveal'; // Hides the email if clicked again
        }
    }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
