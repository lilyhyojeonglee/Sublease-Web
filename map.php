<?php

$listingsData = $this->getAllListings();


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
    <!-- <script type="module" src="./index.js"></script> -->

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
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      gmp-map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
        padding-top: 50px;
      }
    </style>
</head>

<body>

      



    
  
    <div class="container-header" id="home">

        <div class="header">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="#" style="font-size: 30px; padding-left: 20px;" >HomeEZ</a>
            
                <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
              
            </div>
            </div>
        </nav>
            <!-- <div class="pl-logo" id="pl-logo">
                <a href="index.html">
                    <img src="pl_logo.jpg">
                </a>
            </div> -->
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">

            <div class="col-8">
            <div id="map"></div>
            
            </div>

            <section class="col-4 sidebar ">

                <!-- Sidebar -->
                <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary"
                    style="width: 600px;">
                    <a href=""
                        class="d-flex align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
                        <svg class="bi pe-none me-2" width="30" height="24">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <h3 >Sublease Availability</h3>
                    </a>
<!-- EDITED TO DISPLAY DIFFERENT BUTTON BAR FOR LOGIN USER AND GUEST USER -->
                    <div>
                    <?= $message ?>
                    

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
                                        <!-- <div class="mb-3">
                                            <label for="dateRange" class="form-label">Date of Range</label>
                                            <input type="date" class="form-control" id="dateRange">
                                        </div> -->
                                        <!-- dateRange numberOfBeds budgetRange sortLowToHigh sortHighToLow-->
                                        <!-- <div class="mb-3">
                                            <label for="numberOfBeds" class="form-label">Number of Beds</label>
                                            <input type="number" class="form-control" id="numberOfBeds"> -->
                                        <!-- </div> -->
                                        <div class="mb-3">
                                            <label for="budgetRange" class="form-label">Max Budget</label>
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


                   
                   
                    <!-- <h2>Sublease Availability</h2> -->
                        <div id="listings" class="list-group list-group-flush border-bottom scrollarea">
                        <?php 
                            $listings = json_decode($listingsData); // Decode the JSON string into an array
                            
                            foreach ($listings as $item):
                                $house_id = $item->house_id;
                                $address = htmlspecialchars($item->address);
                                $area = htmlspecialchars($item->area);
                                $subleasefee = htmlspecialchars($item->subleasefee);
                                $image = htmlspecialchars($item->image);
                        ?>
                        <a href="listing.php?id=<?php echo urlencode($house_id); ?>" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" data-house-id="<?php echo $house_id; ?>">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <strong class="mb-1"><?php echo $address; ?></strong>
                                <small><?php echo $area; ?></small>
                            </div>
                            <div class="col-10 mb-1 small">$<?php echo $subleasefee; ?></div>
                            <div class="sublease-image">
                                <img src="<?php echo $image; ?>" alt="Item image">
                            </div>
                        </a>
                        <?php endforeach; ?>
                            
                </div>
            </section>
        </div>
    </div>
    

<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: "AIzaSyCNOZZ7qu-OgHKxCvIsYYRNL9J8e8aX10o", v: "beta"});</script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script async src = " https://maps.googleapis.com/maps/api/js?key=AIzaSyCNOZZ7qu-OgHKxCvIsYYRNL9J8e8aX10o&callback=console.debug&libraries=maps, marker&v=beta ">  </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
       let map;

        async function initMap() {
        // The location of Uluru
        const position = { lat: 38.0341532, lng: -78.5176498 };
        // Request needed libraries.
        //@ts-ignore
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

        // The map, centered at Uluru
        map = new Map(document.getElementById("map"), {
            zoom: 15,
            center: position,
            mapId: "DEMO_MAP_ID",
        });


        // The marker, positioned at Uluru
        const marker = new AdvancedMarkerView({
            map: map,
            position: position,
            title: "Uluru",
        });
        const listings = <?php echo $listingsData; ?>;

        // Plot markers on the map
        listings.forEach(listing => {
            const { latitude, longitude, address } = listing;

            new google.maps.Marker({
                map: map,
                position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
                title: address,
            });
        });
        }

        // Call the initMap function when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            initMap();
        });

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
                    }, 
                    success: function(data){
    
                        displayFilteredListings(data);
                        
                        
                    },
                    error: function(xhr, status, error) {
                        $('#listings').html(data);
                        // Handle AJAX request errors
                        console.error("AJAX Error: " + status + " - " + error);
                    }

                });
                closeModal();
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
                            <div class="col-10 mb-1 small">$${listing.subleasefee}</div>
                            <div class="sublease-image">
                                <img src="${listing.image}" alt="Item image">
                            </div>
                        </a>
                    `;
                    
                    // Append the listing HTML to the container
                    $('#listings').append(listingHtml);
                });
                displayMarkersOnMap(data);
            }
            function displayMarkersOnMap(data) {
                var listings = JSON.parse(data);
                // Remove existing markers from the map
                map.data.forEach(function(feature) {
                    map.data.remove(feature);
                });

                // Iterate over the listings and create markers for each listing
                listings.forEach(function(listing) {
                    // Extract latitude and longitude from the listing data
                    const latitude = parseFloat(listing.latitude);
                    const longitude = parseFloat(listing.longitude);

                    // Create a marker for each listing
                    new google.maps.Marker({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                        title: listing.address
                    });
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
        // document.addEventListener('DOMContentLoaded', function () {
        //     console.log('DOM fully loaded and parsed');

        //     var modalEl = document.getElementById('filterModal');
        //     var modalInstance = new bootstrap.Modal(document.getElementById('filterModal'), {
        //         backdrop: false
        //     });

        //     console.log('Modal instance obtained:', modalInstance);

        //     function closeModal() {
        //         modalInstance.hide();
        //         removeModalBackdrop(); // Call to remove the backdrop manually
        //     }
            
        //     document.querySelector('#filterModal .btn-primary').addEventListener('click', applyFilters);

        //     // Function to manually remove the modal backdrop
        //     function removeModalBackdrop() {
        //         document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
        //             backdrop.remove();
        //         });
        //     }
        // });
    </script>


</body>

</html>