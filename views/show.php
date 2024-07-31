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
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
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
                <img src="pl_logo.jpg" alt="Logo">
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="large-image">
                <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Large Listing Image">
            </div>
        </div>
        <div class="col-md-6">
            <div class="gallery">
                <div class="row">
                    <div class="col-6">
                        <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Top Image 1">
                    </div>
                    <div class="col-6">
                        <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Top Image 2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Bottom Image 1">
                    </div>
                    <div class="col-4">
                        <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Bottom Image 2">
                    </div>
                    <div class="col-4">
                        <img src="<?php echo $_SESSION['currentListing']['image']; ?>" alt="Bottom Image 3">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
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
                        Sublease Fee: $<?php echo $_SESSION['currentListing']['subleasefee']; ?><br>
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
