<?php
// Check if the user is not logged in, redirect to map.php

// Check if the user is not logged in, redirect to login.php or another appropriate page
if (!isset($_SESSION['user'])) {
    header("Location: index.php?command=showLogin");
    exit;
}

if (isset($_POST['delete']) && isset($_POST['house_id'])) {
  try {
      $this->deleteListing($_POST['house_id']);
      $message = "Listing removed successfully.";
  } catch (Exception $e) {
      $message = $e->getMessage(); 
  }
}

// $userListings = $subleaseLogic->getUserListings($_SESSION['user']['id']);

$userListings = $this->getUserListings($_SESSION['user']['id']);
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
            <a href="?command=mainPage">
              <img src="pl_logo.jpg">
            </a>
          </div>
          <!-- Logout Button on the Right Top Corner -->

          <div class="logout" style="position: absolute; top: 20px; left: 220px;">
            
              <a href="?command=logout" class="btn btn-danger">Log out</a>
            
          </div>
        </div>
    </div>

    
    <div class="profile-username text-center">
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></h1>
</div>

<div class="card-body p-4 text-black">
    <div class="mb-5">
      <h2>Your Listing</h2>
      <div class="col-xs-12">
            <?= isset($message) ? $message : '' ?>
        </div>

      <div class="p-4" style="background-color: #f8f9fa">
        <?php foreach ($userListings as $listing): ?>
            <p class="font-italic mb-1"><?php echo htmlspecialchars($listing['address']); ?></p>
            <a href="edit_listing.php?listing_id=<?php echo htmlspecialchars($listing['house_id']); ?>">
                <button>edit</button>
            </a>

            <form action="?command=profile" method="post">
                <input type="hidden" name="house_id" value="<?php echo htmlspecialchars($listing['house_id']); ?>">
                <input type="submit" name="delete" value="Remove" class="btn btn-danger">
            </form>


        <?php endforeach; ?>
      </div>
    </div>
</div>

   

    <div class="webweb">
        <a href="?command=showsubmission">
            <button type="button">Upload your listing</button>
        </a>
    </div>
    




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
