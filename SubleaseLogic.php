<?php
require_once 'Database.php';
class SubleaseLogic
{
        private $uri;
        private $get;
        private $post;


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
                if (!isset($_SESSION['errorMessages'])) {
                    $_SESSION['errorMessages'] = [];
                }
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $firstName = $_POST['first_name'] ?? '';
                    $lastName = $_POST['last_name'] ?? '';
                    $email = $_POST['email'] ?? '';
                    $phone = $_POST['phone'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $confirmPassword = $_POST['confirm_password'] ?? '';
            
                
                    
                    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
                        $errorMessages['phone'] = "Invalid or missing phone number";
                    }
            
                    if (empty($password)) {
                        $errorMessages['password'] = "Password is required";
                    }
                    if (empty($_SESSION['errorMessages'])) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $result = pg_prepare($dbConnector, "insert_user", "INSERT INTO users (first_name, last_name, email, phone, password) VALUES ($1, $2, $3, $4, $5)");
                        $result = pg_execute($dbConnector, "insert_user", array($firstName, $lastName, $email, $phone, $hashedPassword));
            
                        if ($result) {
                            header("Location: login.php");
                            exit;
                        } else {
                            $_SESSION['errorMessages']['database'] = "An error occurred during signup. Please try again.";
                        }
                    }
            
                    // No need to return errorMessages; they're stored in $_SESSION
                }
            }
            
        
        
            private function handleLogin() {
                $masterPhone = '1234567890';
                $master = 'qwe';

                $database = new Database(); // Assuming Database class is autoloaded or required elsewhere
                $dbConnector = $database->getDbConnector(); // Get the PostgreSQL connection
                $errorMessages = [];
            
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
                        $errorMessages['phonenumber'] = "Invalid or missing phone number";
                    }
            
                    if (empty($password)) {
                        $errorMessages['password'] = "Password is required";
                    }
            
                    if (empty($errorMessages)) {
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
                                $errorMessages['login'] = "Authentication failed. Please check your credentials.";
                            }
                        } else {
                            $errorMessages['login'] = "Authentication failed. Please check your credentials.";
                        }
                    }
            
                    // Here, handle and display the $errorMessages if any
                }
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
                $dbConnector = $database->getDbConnector(); // Assuming getDbConnector is a method within SubleaseLogic that correctly fetches the database connection.
            
                $userId = $_SESSION['user']['id'] ?? null; // Ensure that user ID is stored in session upon login.
                if ($userId === null) {
                    throw new Exception("User not logged in.");
                }
            
                // Assuming 'furnished' and 'petsAllowed' are checkboxes in your form.
                $furnished = isset($listingData['furnished']) && $listingData['furnished'] ? 't' : 'f';
                $petsAllowed = isset($listingData['petsAllowed']) && $listingData['petsAllowed'] ? 't' : 'f';
            
                $query = "INSERT INTO subleases (user_id, name, description, location, address, gender, furnished, subleaseFee, pet, image) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
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
                }
            
                echo "Listing added successfully.";
            }
            
            

        

}
