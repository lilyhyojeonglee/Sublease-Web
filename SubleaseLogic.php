<?php
require_once 'Database.php';

class SubleaseLogic
{

        private $get;

        private $errormessage;
        private $message;


        public function __construct($get)
        {
                session_start(); //
                // $this->uri = $uri;
                $this->get = $get;
                // $this->post = $post;
        }

        public function run()
        {
                //         $this->handleLogout();
                //         exit; // Stop further execution
                //     }
                $command = "";
                if (isset($this->get['command'])) {
                        $command = $this->get['command'];
                }
                switch ($command) {
                        // case '/':
                        //         if ($this->isLoggedIn()) {
                        //                 $this->servePage('index.html'); // Show dashboard if logged in
                        //         } else {
                        //                 $this->servePage('index.html'); // Show the index page otherwise
                        //         }
                        //         break;
                        case "profile":
                                $this->handleProfile();
                                break;
                        case "login":
                                $this->handleLogin();
                                break;
                        case "showLogin":
                                $this->showLogin();
                                break;
                        case "showmap":
                                $this->showmap();
                                break;
                        case "signup":
                                $this->handleSignup();
                                break;
                        case "logout":
                                $this->handleLogout();
                        case "submission":
                                $this->addListing();
                                break;
                        case "applyFilters":
                                $this->applyFilters();
                                break;
                        case "edit":
                                $this->editListing();
                                break;
                        case "getContactInfo":
                                $this->handleContactInfo();
                                break;
                                    
                        default:
                               $this->showAction();
                               break;
                }
        }

        private function servePage($page)
        {
                include $page;
        }
        private function showAction()
        {
                // Your logic here to display something based on the ID
                include 'index.html';
        }

        private function pageNotFound()
        {
                // include('map.php');
        }

        private function handleProfile()
{
        if ($this->isLoggedIn()) {
          
                include 'profile.php'; 
        } 

        if($this->isLoggedOut()) {
                header("Location: index.php?command=showLogin");
                exit;
        }
        
        // else {
        //         header("Location: map.php");
        //         exit;
        // }
}

        private function handleSignup() {
                $database = new Database(); 
                $dbConnector = $database->getDbConnector();
                
                // Initialize the session errorMessages array if it's not already set
                // if (!isset($_SESSION['errorMessages'])) {
                //     $_SESSION['errorMessages'] = [];
                // }
        
                // $this->errormessage = '';
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $firstName = $_POST['first_name'] ?? '';
                    $lastName = $_POST['last_name'] ?? '';
                    $email = $_POST['email'] ?? '';
                    $phone = $_POST['phone'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $confirmPassword = $_POST['confirm_password'] ?? '';
            
                
                    
                    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
                        $this->errormessage  = "Invalid or missing phone number";
                    }
            
                    if (empty($password)) {
                        $this->errormessage  = "Password is required";
                    }
                    if (empty($this->errormessage)) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $result = pg_prepare($dbConnector, "insert_user", "INSERT INTO users (first_name, last_name, email, phone, password) VALUES ($1, $2, $3, $4, $5)");
                        $result = pg_execute($dbConnector, "insert_user", array($firstName, $lastName, $email, $phone, $hashedPassword));
            
                        if ($result) {
                            header("Location: login.php");
                            exit;
                        } else {
                                $this->errormessage  = "An error occurred during signup. Please try again.";
                        }
                    }
            
                }
                $this->showSignup(); 
            }

            private function showSignup($message="")
        {
                
                if (!empty($this->errormessage)) {
                $message = "<div class='alert alert-danger'>{$this->errormessage}</div>";
                }
                include('signup.php');
        }
            
            
        
        
            private function handleLogin() {
                $masterPhone = '1234567890';
                $master = 'qwe';

                $database = new Database(); // Assuming Database class is autoloaded or required elsewhere
                $dbConnector = $database->getDbConnector(); // Get the PostgreSQL connection
                // $errorMessages = [];
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $phone = $_POST['phonenumber'] ?? '';
                    $password = $_POST['password'] ?? '';
                
                    if ($phone === $masterPhone && $password === $master) {
                        // Login successful
                        $_SESSION['user'] = ['phone' => $phone]; // Store minimal user info or just a flag in session
                        header("Location: index.php?command=showmap"); // Redirect to a secure page after successful login
                        exit;
                    }
                    // Basic validation for phone number and password
                    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
                        $this->errormessage = "Invalid or missing phone number";
                    }
            
                    elseif (empty($password)) {
                        $this->errormessage  = "Password is required";
                    }
            
                    elseif (empty($errorMessages)) {
                        // Prepare the query to fetch user from database
                        $result = pg_prepare($dbConnector, "login_query", "SELECT * FROM users WHERE phone = $1");
                        $result = pg_execute($dbConnector, "login_query", array($phone));
                        if ($user = pg_fetch_assoc($result)) {
                            // Check if user exists and password is correct
                            if (password_verify($password, $user['password'])) {
                                $_SESSION['user'] = $user; // Store user info in session
                                header("Location: index.php?map.php");
                                exit;
                            } else {
                                $this->errormessage  = "Authentication failed. Please check your credentials.";
                            }
                        } else {
                                $this->errormessage  = "Authentication failed. Please check your credentials.";
                        }
                    }
            
                    // Here, handle and display the $errorMessages if any
                }
                $this->showLogin();
            }
            
            
        private function showLogin($message="")
        {
                
                if (!empty($this->errormessage)) {
                $message = "<div class='alert alert-danger'>{$this->errormessage}</div>";
                }
                include('login.php');
        }
        private function showProfile($message="")
        {
                
                if (!empty($this->message)) {
                $message = "<div class='alert alert-primary'>{$this->message}</div>";
                }
                include('profile.php');
        }

        private function authenticateUser($phoneNumber, $password)
        {

                if ($phoneNumber == 'in the database' && $password == 'in the database') {
                        return true;
                }
                return false;
        }


        private function showmap()
        {
                include('map.php');
        }
        private function handleLogout()
        {
                
                session_destroy();
                $_SESSION['user'] = [];
                $this->showmap();
                
        }

        private function isLoggedIn()
        {
        return isset($_SESSION['user']);
        }


        private function isLoggedOut()
        {
                return !isset($_SESSION['user']);
        }

        // public function addListing($listingData) {
        //         $database = new Database(); 
        //         $dbConnector = $database->getDbConnector();
        
        //         $query = "INSERT INTO subleases (user_id, name, description, location, address, gender, furnished, subleaseFee, pet, image) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
        
        //         $userId = $_SESSION['user']['id'] ?? null;
        //         if ($userId === null) {
        //             throw new Exception("User not logged in.");
        //         }
        
        //         $result = pg_prepare($dbConnector, "insert_sublease", $query);
        //         $result = pg_execute($dbConnector, "insert_sublease", [
        //             $userId,
        //             $listingData['name'], 
        //             $listingData['description'],
        //             $listingData['location'],
        //             $listingData['address'],
        //             $listingData['gender'],
        //             $listingData['furnished'] ? 'true' : 'false',
        //             $listingData['rent'],
        //             $listingData['petsAllowed'] ? 'true' : 'false',
        //             $listingData['photoPath']
        //         ]);
        
        //         if (!$result) {
        //             throw new Exception('Failed to add listing: ' . pg_last_error($dbConnector));
        //         }
        
        //         echo "Listing added successfully.";
        //     }
        public function editListing() {
                $this->message = '';
                $database = new Database();
                $dbConnector = $database->getDbConnector(); 
            
                $userId = $_SESSION['user']['id'] ?? null; 
                if ($userId === null) {
                    throw new Exception("User not logged in.");
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        $house_id=$_POST['house_id'] ?? '';
                        $address = $_POST['address'] ?? '';
                        $address2 = $_POST['address2'] ?? '';
                        $area=$_POST['area'] ?? '';
                        $zip = $_POST['zip'] ?? '';
                        $photo = 'images/listing1.webp';
                        $price=$_POST['price'] ?? '';
                        $gender = $_POST['gender'] ?? '';
                        $furnished = $_POST['furnished'] ? 't' : 'f';
                        $pets=$_POST['petsAllowed']? 't' : 'f';
                        $description = $_POST['description'] ?? '';
                        $location = null;
                        
                $query = "UPDATE subleases SET 
                
                area= $1,
                description= $2,
                location= $3,
                address= $4,
                gender= $5,
                furnished= $6,
                subleasefee= $7,
                pet= $8,
                image=$9
                WHERE house_id = $10";
                $result = pg_prepare($dbConnector, "update_sublease", $query);

                $new_des = $description;
                $new_area = $address; 
                $house_id = $house_id; 
                
                $result = pg_execute($dbConnector, "update_sublease", array($area, $description, $location, $address, $gender, $furnished, $price, $pets, $photo, $house_id));


            
                if (!$result) {
                        throw new Exception('Failed to add listing: ' . pg_last_error($dbConnector));
                    } else {
                        // Update JSON file after successful database insertion
                        try {
                            $database->convertDataToJson();
                            echo "Listing added successfully and JSON updated.";
                            $this->message = "Listing updated successfully.";
                            $this->showProfile();
                            exit;
                        } catch (Exception $e) {
                            // Handle error if JSON conversion fails
                            echo 'Error updating JSON: ' . $e->getMessage();
                        }
                    }
            
                echo "Listing added successfully.";
        }
}
        public function addListing($listingData) {
                $this->message = '';
                $database = new Database();
                $dbConnector = $database->getDbConnector(); 
            
                $userId = $_SESSION['user']['id'] ?? null; 
                if ($userId === null) {
                    throw new Exception("User not logged in.");
                }
            
                $furnished = isset($listingData['furnished']) && $listingData['furnished'] ? 't' : 'f';
                $petsAllowed = isset($listingData['petsAllowed']) && $listingData['petsAllowed'] ? 't' : 'f';
            
                $query = "INSERT INTO subleases (user_id, area, description, location, latitude, longitude, address, gender, furnished, subleasefee, pet, image) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)";
                $result = pg_prepare($dbConnector, "insert_sublease", $query);
                $result = pg_execute($dbConnector, "insert_sublease", [
                    $userId,
                    $listingData['area'], 
                    $listingData['description'],
                    $listingData['location'],
                    $listingData['latitude'],
                    $listingData['longitude'],
                    $listingData['address'],
                    $listingData['gender'],
                    $listingData['furnished'] ? 't' : 'f',
                    $listingData['rent'],
                    $listingData['petsAllowed'] ? 't' : 'f',
                    $listingData['photoPath']
                ]);
            
                if (!$result) {
                        throw new Exception('Failed to update listing: ' . pg_last_error($dbConnector));
                    } else {
                        // Update JSON file after successful database insertion
                        try {
                            $database->convertDataToJson();
                            echo "Listing added successfully and JSON updated.";
                            $this->message = "Listing added successfully.";
                            $this->showProfile();
                            exit;
                        } catch (Exception $e) {
                            // Handle error if JSON conversion fails
                            echo 'Error updating JSON: ' . $e->getMessage();
                        }
                    }
            
                echo "Listing added successfully.";
            }
            
            
            public function getUserListings($userId) {
                $database = new Database();
                $dbConnector = $database->getDbConnector();
        
                $query = "SELECT * FROM subleases WHERE user_id = $1";
                $result = pg_prepare($dbConnector, "fetch_user_listings", $query);
                $result = pg_execute($dbConnector, "fetch_user_listings", array($userId));
        
                if (!$result) {
                    throw new Exception('Failed to fetch user listings: ' . pg_last_error($dbConnector));
                }
        
                $listings = pg_fetch_all($result);
                return $listings ?: [];
            }

            public function getAllListings() {
                $database = new Database();
                $dbConnector = $database->getDbConnector();
                
                $query = "SELECT * FROM subleases";
                $result = pg_query($dbConnector, $query);
                
                if (!$result) {
                    throw new Exception('Failed to fetch listings: ' . pg_last_error($dbConnector));
                }
                
                $listings = pg_fetch_all($result);
                
                // Close the database connection
                pg_close($dbConnector);
                
                // Convert listings to JSON format
                return json_encode($listings);
            }
            
            
        public function deleteListing($house_id){
                $userId = $_SESSION['user']['id'] ?? null;
                if ($userId === null) {
                        throw new Exception("User not logged in or does not own the listing.");
                }

                $database = new Database();
                $dbConnector = $database->getDbConnector();

                $deleteQuery = "DELETE FROM subleases WHERE house_id = $1";
                $result = pg_prepare($dbConnector, "delete_listing", $deleteQuery);
                $result = pg_execute($dbConnector, "delete_listing", array($house_id));

                if (!$result) {
                        error_log('Failed to delete listing: ' . pg_last_error($dbConnector));
                        throw new Exception('Failed to delete listing: ' . pg_last_error($dbConnector));
                }

                // Update JSON file after successful database deletion
                try {
                        $database->convertDataToJson();
                } catch (Exception $e) {
                        error_log('Error updating JSON after deleting listing: ' . $e->getMessage());
                        throw new Exception('Error updating JSON after deleting listing: ' . $e->getMessage());
                }

                return "Listing removed successfully.";
        }

        private function handleContactInfo() {
                if ($this->isLoggedIn()) {
                    $userId = $_SESSION['user']['id'];
                    $email = $this->getUserEmail($userId);
                    echo $email;
                } else {
                    echo "Please login to reveal email.";
                }
                exit;
            }
            
            private function getUserEmail($userId) {
                $database = new Database();
                $dbConnector = $database->getDbConnector();
                $query = "SELECT email FROM users WHERE id = $1";
                $result = pg_prepare($dbConnector, "fetch_user_email", $query);
                $result = pg_execute($dbConnector, "fetch_user_email", array($userId));
            
                if ($row = pg_fetch_assoc($result)) {
                    return $row['email'];
                } else {
                    error_log('Failed to fetch email: ' . pg_last_error($dbConnector));
                    return "Email not found.";
                }
            }
            

       

}
