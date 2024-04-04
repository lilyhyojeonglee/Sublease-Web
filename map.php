<?php
// session_start(); // Ensure session starts at the very beginning
require_once 'Database.php';
require_once 'SubleaseLogic.php'; // Adjust the path as necessary

// Mocking $uri, $get, and $post for demonstration. You'll need to adapt this part.
$uri = '/map';
$get = $_GET;
$post = $_POST;

// Instantiating and running your application logic
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
                        <?php if (!isset($_SESSION['logout'])): ?>
                            <a href="login.php" class="btn btn-primary me-2">Login/Sign up</a>
                        <?php elseif (!isset($_SESSION['login'])): ?>
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
                                        <div class="mb-3">
                                            <label for="dateRange" class="form-label">Date of Range</label>
                                            <input type="date" class="form-control" id="dateRange">
                                        </div>
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
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
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
                                    <button type="button" class="btn btn-primary" onclick="applyFilters()">Save
                                        changes</button>

                                    <!-- <button type="button" class="btn btn-primary" onclick="applyFilters()">Save</button> -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="list-group list-group-flush border-bottom scrollarea">
                        <?php
            
                        $filePath = __DIR__ . '/views/list.php';
                        if (file_exists($filePath)) {
                            include $filePath;
                        } else {
                            echo "Error: File not found. Looking for $filePath";
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>

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

            function applyFilters() {
                console.log('Applying filters...');
                var modalEl = document.getElementById('filterModal');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    console.log('Modal instance not found');
                }
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