<?php
// Check if the user is not logged in, redirect to map.php
require_once 'SubleaseLogic.php';
require_once 'Database.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<div class="container-header" id="home">
        <div class="header">
          <div class="pl-logo" id="pl-logo">
            <a href="index.html">
              <img src="pl_logo.jpg">
            </a>
          </div>
          <!-- Logout Button on the Right Top Corner -->

          <div class="logout" style="position: absolute; top: 20px; left: 220px;">
            
              <a href="/logout" class="btn btn-danger">IDK</a>
            
          </div>
        </div>
    </div>

    <div class="profile-username text-center">
        <h1>Welcome  {USER}</h1>
    </div>

    
    <div class="card-body p-4 text-black">
        <div class="mb-5">
          <h2>Your Listing</h2>
          
          <div class="p-4" style="background-color: #f8f9fa">
            <p class="font-italic mb-1" style="margin: 0;">1709 JPA</p>
            <a href="submission.html">
                <button>edit</button>
            </a>
            <button>Remove</button>
            <p class="font-italic mb-1">611 Madison Ave</p>
            <a href="submission1.html">
                <button>edit</button>
            </a>
            <button>Remove</button>

            <p class="font-italic mb-0">HOME ADDRESS</p>
            <a href="submission1.html">
                <button>edit</button>
            </a>
            <button>Remove</button>

          </div>
        </div>
    </div>

   

    <div class="webweb">
        <a href="submission.php">
            <button type="button">Upload your listing</button>
        </a>
    </div>
    




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
