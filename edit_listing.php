<?php
require_once 'Database.php'; 
require_once 'SubleaseLogic.php';
//<a href="edit_listing.php?listing_id=<?php echo htmlspecialchars($listing['house_id']);
$houseId = $_GET['listing_id'];
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

$subleaseLogic = new SubleaseLogic("/edit", $_GET, $_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  $subleaseLogic = new SubleaseLogic($uri, $get, $post);
  $listingData = [
    'area' => filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS), 
    'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    'location' => filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    'latitude' => filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
    'longitude' => filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
    'photoPath' => 'images/listing1.webp', // Assuming static or handle file upload to get path
    'address' => filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . 
    (!empty($_POST['address2']) ? ' ' . filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''),
    'gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    'furnished' => isset($_POST['furnished']) ? true : false, 
    'rent' => filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT),
    'petsAllowed' => isset($_POST['petsAllowed']) ? true : false,
];
// if (empty($listingData['latitude']) || empty($listingData['longitude'])) {
//   echo '<div class="alert alert-danger" role="alert">Please type address and choose one from the suggestions.</div>';
// } 
if(empty($listingData['area'])) {
  echo '<div class="alert alert-danger" role="alert">Please choose an area.</div>';
} 
elseif (empty($listingData['rent'])) {
  echo '<div class="alert alert-danger" role="alert">Enter sublease fee.</div>';
} 
elseif (empty($listingData['gender'])) {
  echo '<div class="alert alert-danger" role="alert">Please choose a gender preference.</div>';
} else {
  try {
      $subleaseLogic->editListing($listingData);
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<div class="container">
    <h1>Edit Listing: <?php echo htmlspecialchars($houseId); ?></h1>
    <main>
        <div class="py-5 text-center">
            <h2>Sublease Information</h2>
            <p>Update the form to edit your house for sublease</p>
        </div>
        <div class="row g-5">
            <div class="info-box">
                <h4 class="mb-3">Sublease Information</h4>
                <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?listing_id=<?php echo htmlspecialchars($houseId); ?>" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="house_id" value="<?php echo htmlspecialchars($houseId); ?>">
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['address']); ?>" readonly>
                        <div class="invalid-feedback">Please enter your address.</div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="zip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="zip" name="zip" value="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['zip']); ?>" readonly>
                        <div class="invalid-feedback">Zip code required.</div>
                    </div> -->
                    <!-- Other form fields remain editable as before -->
                    <div class="mb-3">
                      <label for="area" class="form-label">Area <span class="text-body-secondary"></span></label>
                        <select type="option" class="form-select" id="area" name="area" required="">
                          <option value="">Choose...</option>
                          <option>JPA</option>
                          <option>Corner</option>
                          <option>MSC</option>
                          <option>Not</option>
                        </select>     
                    <div class="mb-3">
                        <label for="price" class="form-label">Rent</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($selectedHouse['rentalTerms']['subleasefee']); ?>" required>
                        <div class="invalid-feedback">Please enter an amount.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prefer Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Choose...</option>
                            <option value="Male" <?php echo $selectedHouse['rentalTerms']['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $selectedHouse['rentalTerms']['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Doesn't matter" <?php echo $selectedHouse['rentalTerms']['gender'] === "Doesn't matter" ? 'selected' : ''; ?>>Doesn't matter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input id="furnished" name="furnished" type="checkbox" class="form-check-input" <?php echo $selectedHouse['rentalTerms']['furnished'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="furnished">Check if it's Furnished</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input id="pets-allowed" name="petsAllowed" type="checkbox" class="form-check-input" <?php echo $selectedHouse['rentalTerms']['pet'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="pets-allowed">Check if Pets Allowed</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" the form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($selectedHouse['propertyDetails']['description']); ?>" required>
                    </div>
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Update listing</button>
                </form>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>