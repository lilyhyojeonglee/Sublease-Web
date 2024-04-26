<?php

// $houseId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$jsonDir = 'data/data.json';
$jsonData = file_get_contents($jsonDir);

// Decode the JSON data into an array
$houses = json_decode($jsonData, true);

// Search for the house by ID
$selectedHouse = null;
foreach ($houses as $house) {
    if ($house['house_id'] === $houseId) {
        $selectedHouse = $house;
        break;
    }
}

if (null === $selectedHouse) {
    echo "House not found";
    exit;
}

// display boolean values as 'Yes' or 'No'
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
    <div class="row">
        <div class="col-md-6">
            <div class="large-image">
                <img src="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['image']); ?>" alt="Large Listing Image">
            </div>
        </div>
        <div class="col-md-6">
            <div class="gallery">
                <img src="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['image']); ?>" alt="Large Listing Image">
                <img src="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['image']); ?>" alt="Large Listing Image">
                <img src="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['image']); ?>" alt="Large Listing Image">
                <img src="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['image']); ?>" alt="Large Listing Image">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
            <div class="info-box text-center">
                    <header>Address</header>
                    <p><?php echo htmlspecialchars($selectedHouse['propertyDetails']['address']); ?></p>
                </div>
                <div class="info-box">
                    <header>Details</header>
                    <p>Gender: <?php echo ($selectedHouse['rentalTerms']['gender']); ?><br>
                        Area: <?php echo ($selectedHouse['propertyDetails']['location']); ?><br>
                        Furnished: <?php echo displayBoolean($selectedHouse['rentalTerms']['furnished']); ?><br>
                        Sublease Fee: $<?php echo ($selectedHouse['rentalTerms']['subleaseFee']); ?><br>
                        Pet: <?php echo displayBoolean($selectedHouse['rentalTerms']['pet']); ?></p>
                </div>
            </div>
            <div class="col-md-8">
            <div class="info-box"> 
                    <header>Description</header>
                    <p><?php echo htmlspecialchars($selectedHouse['propertyDetails']['description']); ?></p>
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
