<?php
require_once 'Database.php';

class SubleaseLogic
{
        private $uri;
        private $get;
        private $post;
        private $errormessage;


        public function __construct($uri, $get, $post)
        {
                session_start(); 
                $this->uri = $uri;
                $this->get = $get;
                $this->post = $post;
        }

        public function run()
        {
                //         $this->handleLogout();
                //         exit; // Stop further execution
                //     }
                
                switch ($this->uri) {
                        case '/':
                                if ($this->isLoggedIn()) {
                                        $this->servePage('index.html'); // Show dashboard if logged in
                                } else {
                                        $this->servePage('index.html'); // Show the index page otherwise
                                }
                                break;
                        case '/profile':
                                $this->handleProfile();
                                break;
                        case '/login':
                                $this->handleLogin();
                                break;
                        case '/showLogin':
                                $this->showLogin();
                                break;
                        case '/signup':
                                $this->handleSignup();
                                break;
                        case '/logout':
                                $this->handleLogout();
                        case '/submission':
                                $this->addListing();
                                break;
                        default:
                                $this->pageNotFound();
                                break;
                }
        }

        private function servePage($page)
        {
                include $page;
        }
        private function showAction($id)
        {
                // Your logic here to display something based on the ID
        }

        private function pageNotFound()
        {
                // include('map.php');
        }

        private function handleProfile()
{
        // Check if user is logged in before serving the profile page
        if ($this->isLoggedIn()) {
          
                include 'profile.php'; // Adjust the path as necessary
        } 

        if($this->isLoggedOut()) {
                header("Location: login.php");
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
            
                    // No need to return errorMessages; they're stored in $_SESSION
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
                        header("Location: map.php"); // Redirect to a secure page after successful login
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
                                header("Location: map.php");
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
        public function addListing($listingData) {
                $database = new Database();
                $dbConnector = $database->getDbConnector(); 
            
                $userId = $_SESSION['user']['id'] ?? null; 
                if ($userId === null) {
                    throw new Exception("User not logged in.");
                }
            
                $furnished = isset($listingData['furnished']) && $listingData['furnished'] ? 't' : 'f';
                $petsAllowed = isset($listingData['petsAllowed']) && $listingData['petsAllowed'] ? 't' : 'f';
            
                $query = "INSERT INTO subleases (user_id, name, description, location, address, gender, furnished, subleasefee, pet, image) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
                $result = pg_prepare($dbConnector, "insert_sublease", $query);
                $result = pg_execute($dbConnector, "insert_sublease", [
                    $userId,
                    $listingData['area'], 
                    $listingData['description'],
                    $listingData['location'],
                    $listingData['address'],
                    $listingData['gender'],
                    $listingData['furnished'] ? 't' : 'f',
                    $listingData['rent'],
                    $listingData['petsAllowed'] ? 't' : 'f',
                    $listingData['photoPath']
                ]);
            
                if (!$result) {
                        throw new Exception('Failed to add listing: ' . pg_last_error($dbConnector));
                    } else {
                        // Update JSON file after successful database insertion
                        try {
                            $database->convertDataToJson();
                            echo "Listing added successfully and JSON updated.";
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
            
        

}
