<?php

function displayBoolean($value) {
    return $value ? 'Yes' : 'No';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($selectedHouse['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <style>
        body {
            padding-top: 20px;
        }
        .gallery {
            width: 100%;
            height: auto;
        }
        .gallery img, .large-image img {
            width: 100%;
            height: auto;
        }
        .info-box {
            padding: 15px;
            border: 1px solid #ccc;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container-header" id="home">
    <div class="header">
        <div class="pl-logo" id="pl-logo">
            <a href="/?command=mainp"> 
                <img src="pl_logo.jpg">
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo $_SESSION['currentListing']['image']; ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $_SESSION['currentListing']['image']; ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $_SESSION['currentListing']['image']; ?>" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <!-- <div class="row">
        <div class="col-md-6">
            <div class="large-image">
                <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Large Listing Image">
            </div>
        </div>
        <div class="col-md-6">
            <div class="gallery">
                <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Large Listing Image">
                <img src="<?php echo $_SESSION['currentListing']['image'];?>" alt="Large Listing Image">
                <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Large Listing Image">
                <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Large Listing Image">
            </div>
        </div>
    </div> -->

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
            <div class="info-box text-center">
                    <header>Address</header>
                    <p><?php echo $_SESSION['currentListing']['address']; ?></p>
                </div>
                <div class="info-box">
                    <header>Details</header>
                    <p>Gender: <?php echo $_SESSION['currentListing']['gender']; ?><br>
                        Area: <?php echo $_SESSION['currentListing']['area']; ?><br>
                        Furnished: <?php echo displayBoolean($_SESSION['currentListing']['furnished']); ?><br>
                        Sublease Fee: $<?php echo $_SESSION['currentListing']['subleaseFee']; ?><br>
                        Pet: <?php echo displayBoolean($_SESSION['currentListing']['pet']); ?></p>
                </div>
            </div>
            <div class="col-md-8">
            <div class="info-box"> 
                    <header>Description</header>
                    <p><?php echo $_SESSION['currentListing']['description']; ?></p>
                </div>
            </div>


            <div class="col-md-4">
                    <div class="info-box" id="contact-box" onclick="revealContact()">
                        <header>Contact</header>
                        <p id="contact-info">Log in to reveal</p>
                    </div>
                </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
