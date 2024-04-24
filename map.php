<?php
require_once 'Database.php';
require_once 'SubleaseLogic.php'; 

$uri = '/map';
$get = $_GET;
$post = $_POST;

$application = new SubleaseLogic($uri, $get, $post);
$application->run();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Title</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">

    <!-- Custom CSS -->
    <style>
        /* Adjust sidebar width and styling as needed */
        .sidebar {
            position: fixed;
            right: 250px;
            width: 600px;
            height: 100%;
            margin-right: -250px;
            overflow-y: auto;
            /* background: #222; */
        }

        .sublease-image img {
            width: 500px;
        }

        .hover {
            cursor: pointer;
            text-decoration: underline;
            background: blue;
        }
    </style>
</head>

<body>

    <div class="container-header" id="home">

        <div class="header">
            <div class="pl-logo" id="pl-logo">
                <a href="index.html">
                    <img src="pl_logo.jpg">
                </a>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">

            <section class="col">
                <img src="images/temp-map.jpeg" style="width: 70%;">
            </section>

            <section class="sidebar">

                <!-- Sidebar -->
                <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary"
                    style="width: 600px;">
                    <a href=""
                        class="d-flex align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
                        <svg class="bi pe-none me-2" width="30" height="24">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-5 fw-semibold">List group</span>
                    </a>
<!-- EDITED TO DISPLAY DIFFERENT BUTTON BAR FOR LOGIN USER AND GUEST USER -->
                    <div>
                    <?php if (!(isset($_SESSION['user']))): ?>
                        <a href="/showLogin" class="btn btn-primary me-2">Login/Sign up</a>
                    <?php else: ?>
                        <a href="profile.php" class="btn btn-primary me-2">Account</a>
                    <?php endif; ?>

                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
                    </div>
                        



                    <!-- <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true"> -->
                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                        aria-hidden="true">

                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <!-- Filter form -->
                                <div class="modal-body">

                                    <form id="filterForm">
                                        <!-- area, subleasefee(max), gender, furnished, pet,  -->
                                        <div class="mb-3">
                                            <label for="dateRange" class="form-label">Date of Range</label>
                                            <input type="date" class="form-control" id="dateRange">
                                        </div>
                                        <!-- dateRange numberOfBeds budgetRange sortLowToHigh sortHighToLow-->
                                        <div class="mb-3">
                                            <label for="numberOfBeds" class="form-label">Number of Beds</label>
                                            <input type="number" class="form-control" id="numberOfBeds">
                                        </div>
                                        <div class="mb-3">
                                            <label for="budgetRange" class="form-label">Budget Range</label>
                                            <input type="text" class="form-control" id="budgetRange">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender">
                                                <option selected>Choose...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Furnished</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="furnished"
                                                    id="furnished" value="True" >
                                                <label class="form-check-label" for="furnished">
                                                    Furnished
                                                </label>
                                            </div>
                                        </div>  
                                        <div class="mb-3">
                                            <label class="form-label">Pets</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="petsallowed"
                                                    id="petsallowed" value="True" >
                                                <label class="form-check-label" for="petsallowed">
                                                    Pets Allowed
                                                </label>
                                            </div>
                                        </div> 
                                        <div class="mb-3">
                                            <label class="form-label">Sort by Price</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sortPrice"
                                                    id="sortLowToHigh" value="lowToHigh" checked>
                                                <label class="form-check-label" for="sortLowToHigh">
                                                    Lowest to Highest
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sortPrice"
                                                    id="sortHighToLow" value="highToLow">
                                                <label class="form-check-label" for="sortHighToLow">
                                                    Highest to Lowest
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    <!-- <button type="button" id="savechange" class="btn btn-primary" onclick="applyFilters()">Save changes</button> -->
                                    <button type="button" id="savechange" class="btn btn-primary" ">Save changes</button>

                                    <!-- <button type="button" class="btn btn-primary" onclick="applyFilters()">Save</button> -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- <div class="list-group list-group-flush border-bottom scrollarea">
                        <div class="col-xs-12">STH<?= isset($message) ? $message : '' ?></div>
                        <?php
            
                        // $filePath = __DIR__ . '/views/list.php';
                        // if (file_exists($filePath)) {
                        //     include $filePath;
                        // } else {
                        //     echo "Error: File not found. Looking for $filePath";
                        // }
                        ?>
                    </div> -->
                    <h2>Sublease Availability</h2>
                        <div id="listings" class="list-group list-group-flush border-bottom scrollarea">
                            <?php
                            $jsonPath = 'data/data.json';

                            if (file_exists($jsonPath)) {
                                $json = file_get_contents($jsonPath);
                                $data = json_decode($json, true);
                            } else {
                                echo "Error: json file not found.";

                            }

                            foreach ($data as $item):
                            ?>
                                <a href="listing.php?id=<?php echo urlencode($item['house_id']); ?>" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <strong class="mb-1"><?php echo htmlspecialchars($item['propertyDetails']['address']); ?></strong>
                                        <small><?php echo ($item['propertyDetails']['area']); ?></small>
                                    </div>
                                    <div class="col-10 mb-1 small"><?php echo htmlspecialchars($item['propertyDetails']['description']); ?></div>
                                    <div class="sublease-image">
                                        <img src="<?php echo htmlspecialchars($item['propertyDetails']['image']); ?>" alt="Item image">
                                    </div>
                                </a>
                            <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('#savechange').click(function(){
        //         $.ajax({
        //             type:'GET',
        //             url:"filter.php",
        //             data:{
        //                 gender:$('#gender').val(),
        //             },
        //             success:function(data){
        //                 $('#listings').html(data)
        //             }
        //         })
        //     })
        //     $("list-group-item").on("mouseover", function() {
        //         $(this).addClass("hover");
        //     });
        //     $("list-group-item").on("mouseout", function() {
        //         $(this).removeClass("hover");
        //     });

        // });

        $(document).ready(function() {
    // Event listener for the "Save changes" button click
            $('#savechange').click(function(){
                // Get the selected gender filter value
                var gender = $('#gender').val();
                var dateRange = $('#dateRange').val();
                var numberOfBeds = $('#numberOfBeds').val();
                var budgetRange = $('#budgetRange').val();
                var sortPrice = $('input[name="sortPrice"]:checked').val();
                var furnished = $('#furnished').is(':checked'); 
                var petsallowed = $('#petsallowed').is(':checked');
                // dateRange numberOfBeds budgetRange sortLowToHigh sortHighToLow
                
                // Make an AJAX request to filter.php with the selected gender filter
                $.ajax({
                    type: 'GET',
                    url: "filter.php",
                    data: { 
                        gender: gender,
                        dateRange: dateRange,
                        numberOfBeds: numberOfBeds,
                        budgetRange: budgetRange,
                        sortPrice: sortPrice,
                        furnished: furnished,
                        petsallowed: petsallowed
                    }, // Send the gender filter value as data
                    success: function(data){
                        // $('#listings').html(data);                  
                        // Update the listings container with the filtered data
                        
                        displayFilteredListings(data);
                        closeModal();
                        
                    },
                    error: function(xhr, status, error) {
                        $('#listings').html(data);
                        // Handle AJAX request errors
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            });
            
            // Function to display filtered listings in the listings container
            
            function displayFilteredListings(data) {
                // Clear previous listings
                $('#listings').empty();
                
                // Parse the JSON response
                var listings = JSON.parse(data);
                
                // Iterate over the listings and append them to the container
                listings.forEach(function(listing) {
                    // Create HTML for each listing item
                    
                    var listingHtml = `
                        <a href="listing.php?id=${encodeURIComponent(listing.house_id)}" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <strong class="mb-1">${listing.address}</strong>
                                <small>${listing.area}</small>
                            </div>
                            <div class="col-10 mb-1 small">${listing.description}</div>
                            <div class="sublease-image">
                                <img src="${listing.image}" alt="Item image">
                            </div>
                        </a>
                    `;
                    
                    // Append the listing HTML to the container
                    $('#listings').append(listingHtml);
                });
            }
            var modalEl = document.getElementById('filterModal');
            var modalInstance = new bootstrap.Modal(document.getElementById('filterModal'), {
                backdrop: false
            });
            const closeModal = () => {
                modalInstance.hide();
                removeModalBackdrop();
            }
            const removeModalBackdrop = () => {
                document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
                    backdrop.remove();
                });
            }

            
        });
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed');

            var modalEl = document.getElementById('filterModal');
            var modalInstance = new bootstrap.Modal(document.getElementById('filterModal'), {
                backdrop: false
            });

            console.log('Modal instance obtained:', modalInstance);

            function closeModal() {
                modalInstance.hide();
                removeModalBackdrop(); // Call to remove the backdrop manually
            }
            
            document.querySelector('#filterModal .btn-primary').addEventListener('click', applyFilters);

            // Function to manually remove the modal backdrop
            function removeModalBackdrop() {
                document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
                    backdrop.remove();
                });
            }
        });
    </script>


</body>

</html>