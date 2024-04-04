<?php
// Check if the user is not logged in, redirect to map.php
require_once 'SubleaseLogic.php';
require_once 'Database.php';

// Assuming {UserName} comes from the session or database
// if (isset($_GET['logout'])) {
//   session_destroy(); // Destroy all session data
//   header("Location: map.php"); // Redirect to map.php
//   exit;
// }

// Check if the user is not logged in, redirect to map.php
// if (!isset($_SESSION['user'])) {
//   header("Location: map.php");
//   exit;
// }

// Assuming {UserName} comes from the session or database
$userName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : "User"; // Placeholder
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
            <?php if (!isset($_SESSION['logout'])) : ?>
             <a href="map.php" class="btn btn-danger">Logout</a>
            <?php else: ?>
              <a href="profile.php" class="btn btn-danger">IDK</a>
            <?php endif; ?>
          </div>
        </div>
    </div>

    <div class="profile-username text-center">
        <h1>Welcome <?php echo htmlspecialchars($userName); ?></h1>
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
            <a href="submission.html">
                <button>edit</button>
            </a>
            <button>Remove</button>

            <p class="font-italic mb-0">HOME ADDRESS</p>
            <a href="submission.html">
                <button>edit</button>
            </a>
            <button>Remove</button>

          </div>
        </div>
    </div>

   

    <div class="webweb">
        <a href="submission.html">
            <button type="button">Upload your listing</button>
        </a>
    </div>
    




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
