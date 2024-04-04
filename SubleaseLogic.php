<?php


class SubleaseLogic
{
        private $uri;
        private $get;
        private $post;


        public function __construct($uri, $get, $post)
        {
                // session_start();
                $this->uri = $uri;
                $this->get = $get;
                $this->post = $post;
        }

        public function run()
        {
                // if (isset($_GET['logout'])) {
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
                        
                        case '/logout':
                                $this->handleLogout();
                                break;
                        case '/signup':
                                $this->handleSignup();
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
            
                    // Validation logic remains the same...
                    
                    // Basic validation for phone number and password
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
                $database = new Database(); // Assuming Database class is autoloaded or required elsewhere
                $dbConnector = $database->getDbConnector(); // Get the PostgreSQL connection
                $errorMessages = [];
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $phone = $_POST['phonenumber'] ?? '';
                    $password = $_POST['password'] ?? '';
            
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



        private function handleLogout()
        {
                
                if (isset($_GET['logout'])) {

                        session_destroy(); // Destroy the session
                        header("Location: map.php"); // Redirect to map.php
                        exit;
                    }
                // Destroy the session on logout and redirect to the login or index page
                // session_destroy();
                // header("Location: index.html");
                // exit;
        }

        private function isLoggedIn()
{
    return isset($_SESSION['user']);
}


        private function isLoggedOut()
        {
        // Assuming logout means the user session does not exist
                return !isset($_SESSION['user']);
        }

        

}
