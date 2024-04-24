<?php

require_once 'Database.php'; // Your database connection class
require_once 'SubleaseLogic.php'; 

$uri = '/submission';
$get = $_GET;
$post = $_POST;
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $subleaseLogic = new SubleaseLogic($uri, $get, $post);
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
if (empty($listingData['latitude']) || empty($listingData['longitude'])) {
  echo '<div class="alert alert-danger" role="alert">Please type address and choose one from the suggestions.</div>';
} 
elseif(empty($listingData['area'])) {
  echo '<div class="alert alert-danger" role="alert">Please choose an area.</div>';
} 
elseif (empty($listingData['rent'])) {
  echo '<div class="alert alert-danger" role="alert">Enter sublease fee.</div>';
} 
elseif (empty($listingData['gender'])) {
  echo '<div class="alert alert-danger" role="alert">Please choose a gender preference.</div>';
} else {
  try {
      $subleaseLogic->addListing($listingData);
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }
}
} else {
// Handle non-POST requests
}
//   try {
//       $subleaseLogic->addListing($listingData);

//   } catch (Exception $e) {
//       echo "Error: " . $e->getMessage();
//   }
// } else {
//   // Handle non-POST requests or include form HTML below
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submit Sublease Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/main.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNOZZ7qu-OgHKxCvIsYYRNL9J8e8aX10o&libraries=places"></script>
    <!-- <script>
    // Initialize Place Autocomplete
    function initAutocomplete() {
      var input = document.getElementById('address');
      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          if (place.geometry) {
              document.getElementById('latitude').value = place.geometry.location.lat();
              document.getElementById('longitude').value = place.geometry.location.lng();
          }
      });
    }
    </script>
   -->
   <script>
// Initialize Place Autocomplete
function initAutocomplete() {
    var input = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setFields(['address_components', 'geometry']); // Specify that you need address components and geometry
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
        }
        // Extract postal code from address components
        if (place.address_components) {
            var postalCode = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (addressType === 'postal_code') {
                    postalCode = place.address_components[i].long_name;
                    break;
                }
            }
            if (postalCode) {
                document.getElementById('zip').value = postalCode;
            } else {
                document.getElementById('zip').value = ''; 
        }
      }
    });
}
</script>

</head>
<body>
<div class="container">
    <main>
        <div class="py-5 text-center">
            <h2>Sublease information</h2>
            <p>Fill out the form to upload your house for sublease</p>
        </div>

        <div class="row g-5">
            <div class="info-box">
                <h4 class="mb-3">Sublease Information</h4>
                <!-- Update the action to the correct script file or endpoint -->
                <form class="needs-validation" action="submission.php" method="POST" enctype="multipart/form-data" novalidate="">
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <div class="Address col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required="">
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
                        <option value="">Choose...</option>
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
                <input type="text" class="form-control" id="price" name="price" placeholder="Rent fee per month" required="">
              <div class="invalid-feedback">
                Please enter an amount.
              </div>
            </div>

            <div class="Gender col-mid-3">
                <label class="form-label">Prefer Gender</label>
                <select type="option" class="form-select" id="gender" name="gender" required="">
                  <option value="">Choose...</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Doesn't matter</option>
                </select>
                

          </div>

          <div class="Furnished col-mid-3">
          <div class="form-check">
            <input id="furnished" name="furnished" type="checkbox" class="form-check-input" value="true">
            <label class="form-check-label" for="furnished">Check if its Furnished</label>
          </div>
          
                  <option value="">Choose...</option>
                  <option>Furnished</option>
                  <option>NOT Furnished</option>

                </select>
                

          </div>
              
          </div>
            <div class="Pets my-3">
            <div class="form-check">
              <input id="pets-allowed" name="petsAllowed" type="checkbox" class="form-check-input" value="true">
              <label class="form-check-label" for="pets-allowed">Check if Pets Allowed</label>
            </div>
              <!-- <label class="form-label">Pets</label>
            <div class="form-check">
              <input id="pets-allowed" name="pets" type="radio" class="form-check-input" checked="" required="">
              <label class="form-check-label" for="pets-allowed">Allowed</label>
            </div>
            <div class="form-check">
              <input id="pets-not-allowed" name="pets" type="radio" class="form-check-input" required="">
              <label class="form-check-label" for="pets-not-allowed">Not allowed</label>
            </div> -->
          </div>
            <div class="Description col-12">
              <label for="description" class="form-label">Description</label>
              <div class="input-group"></div>
                <input type="text" class="form-control" id="description" name="description" placeholder="Add extra information about your listing" required="">
              </div>



          </div>

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Submit listing</button>
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Submit listing</button>
                </form>
            </div>
        </div>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initAutocomplete();
    });
</script>
</body>
</html>
