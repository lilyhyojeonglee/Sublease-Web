<?php


class SubleaseLogic
{
        private $uri;
        private $get;
        private $post;

        //     public function __construct($input)
//     {
//         session_start();
//         $this->input = $input;
//     }

        public function __construct($uri, $get, $post)
        {
                session_start();
                $this->uri = $uri;
                $this->get = $get;
                $this->post = $post;
        }

        public function run()
        {
                switch ($this->uri) {
                        case '/':
                                if ($this->isLoggedIn()) {
                                        $this->servePage('dashboard.html'); // Show dashboard if logged in
                                } else {
                                        $this->servePage('index.html'); // Show the index page otherwise
                                }
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
        private function handleLogin() {
                global $pdo; // Use the PDO connection from db.php
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
                        // Fetch user from database
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
                        $stmt->execute([$phone]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
                        // Check if user exists and password is correct
                        if ($user && password_verify($password, $user['password'])) {
                            $_SESSION['user'] = $user; // Store user info in session
                            header("Location: dashboard.html");
                            exit;
                        } else {
                            $errorMessages['login'] = "Authentication failed. Please check your credentials.";
                            // Handle the error, display message to the user
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
                // Destroy the session on logout and redirect to the login or index page
                session_destroy();
                header("Location: index.html");
                exit;
        }

        private function isLoggedIn()
        {
                // Check if user session exists
                return isset($_SESSION['user']);
        }
        private function handleSignup() {
                global $pdo; // Use the PDO connection from db.php
                $errorMessages = [];
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $firstName = $_POST['first_name'];
                    $lastName = $_POST['last_name'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirm_password'];
            
                    // Validate input and make sure passwords match
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMessages['email'] = "Invalid email format";
                    }
                    if (!preg_match("/^[0-9]{10}$/", $phone)) {
                        $errorMessages['phone'] = "Invalid phone number format";
                    }
                    if ($password !== $confirmPassword) {
                        $errorMessages['password'] = "Passwords do not match";
                    }
            
                    if (empty($errorMessages)) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        // Insert user into the database
                        try {
                            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                            $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword]);
                            // Redirect or inform the user of a successful signup
                            header("Location: login.php"); // Redirect to login page after successful signup
                            exit;
                        } catch (PDOException $e) {
                            $errorMessages['database'] = "Error during signup: " . $e->getMessage();
                            // Handle the error, perhaps log it and display a user-friendly message
                        }
                    }
            
                    // Here, handle and display the $errorMessages if any
                }
            }
            
}