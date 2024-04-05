<?php
//<a href="edit_listing.php?listing_id=<?php echo htmlspecialchars($listing['house_id']);
$houseId = $_GET['listing_id'];
$jsonDir = 'opt/src/sublease/template/data/data.json';
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
   

    <h1><?=$houseId?></h1>
    <main>
        
        <div class="py-5 text-center">
            <h2>Sublease information</h2>
            <p>Fill out the form to upload your house for sublease</p>
        </div>
        <div class="container">
        <div class="row g-5">
            <div class="info-box">
                <h4 class="mb-3">Sublease Information</h4>
                <!-- Update the action to the correct script file or endpoint -->
                <form class="needs-validation" action="/edit" method="POST" enctype="multipart/form-data" novalidate="">
                    <input type="hidden" name="house_id" value=<?=$houseId?> >
            
                    <div class="Address col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value=<?php echo htmlspecialchars($selectedHouse['propertyDetails']['address']); ?> required="">
                        <div class="invalid-feedback">
                            Please enter your address.
                        </div>
                    </div>
                    <div class="Address2 col-12">
                      <label for="address2" class="form-label">Address 2 <span class="text-body-secondary">(Optional)</span></label>
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
                    </div>
                    
                    <div class="Area col-12">
                      <label for="area" class="form-label">Area <span class="text-body-secondary"></span></label>
                      <select type="option" class="form-select" id="area" name="area" required="">
                        <option value=<?php echo ($selectedHouse['propertyDetails']['location']); ?>>Choose...</option>
                        <option>JPA</option>
                        <option>Corner</option>
                        <option>MSC</option>
                        <option>Not</option>
                      </select>
                    </div>

                    <div class="Zip col-md-3">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="zip" name="zip" placeholder="" required="">
                    <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>

            <div class="Photo col-12">
                  <label for="photos" class="form-label">Photos</label>
                  <input id="photos" type="file" name="photo" accept="image/png, image/jpeg" />
              </div>
            <div class="Price col-12">
              <label for="price" class="form-label">Rent</label>
              <div class="input-group"></div>
                <input type="text" class="form-control" id="price" name="price" placeholder="Rent fee per month" value=<?php echo ($selectedHouse['rentalTerms']['subleasefee']); ?>>
              <div class="invalid-feedback">
                Please enter an amount.
              </div>
            </div>

            <div class="Gender col-mid-3">
                <label class="form-label">Prefer Gender</label>
                <select type="option" class="form-select" id="gender" name="gender">
                  <option ><?php echo ($selectedHouse['rentalTerms']['gender']); ?></option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Doesn't matter</option>
                </select>
                

            </div>

          <!-- <div class="Furnished col-mid-3"> -->
          <div class="form-check">
            <input id="furnished" name="furnished" type="checkbox" class="form-check-input" value="true" <?php if(($selectedHouse['rentalTerms']['furnished']) == "true") echo "checked"; ?>>
            <label class="form-check-label" for="furnished">Check if its Furnished</label>
          </div>
         
            <div class="form-check">
              <input id="pets-allowed" name="petsAllowed" type="checkbox" class="form-check-input" value="true" <?php if(($selectedHouse['rentalTerms']['pet']) == "true") echo "checked"; ?>>
              <label class="form-check-label" for="pets-allowed">Check if Pets Allowed</label>
            </div>
              
          <!-- </div> -->
            <div class="Description col-12">
              <label for="description" class="form-label">Description</label>
              <div class="input-group"></div>
                <input type="text" class="form-control" id="description" name="description" value=<?php echo htmlspecialchars($selectedHouse['propertyDetails']['description']); ?> placeholder="Add extra information about your listing" required="">
              </div>



          </div>
                    <!-- Add other fields similarly, ensuring they have 'name' attributes -->

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Update listing</button>
                    <!-- <button class="w-100 btn btn-primary btn-lg" type="submit">Submit listing</button> -->
                </form>
            </div>
        </div>
        </div>
    </main>

    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
