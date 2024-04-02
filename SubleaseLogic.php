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
        private function handleLogin()
        {
                $errorMessages = [];

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $phoneNumber = isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : '';
                        $password = isset($_POST['password']) ? $_POST['password'] : '';

                        // Basic validation for phone number and password
                        if (empty($phoneNumber) || !preg_match("/^[0-9]{10}$/", $phoneNumber)) {
                                $errorMessages['phonenumber'] = "Invalid or missing phone number";
                        }

                        if (empty($password)) {
                                $errorMessages['password'] = "Password is required";
                        }

                        if (empty($errorMessages)) {
                                $userAuthenticated = $this->authenticateUser($phoneNumber, $password);

                                if ($userAuthenticated) {
                                        $_SESSION['user'] = ['phonenumber' => $phoneNumber];
                                        header("Location: map.php");
                                        exit;
                                } else {
                                        $errorMessages['login'] = "Authentication failed. Please check your credentials.";
                                        // Consider how to handle and display these error messages
                                }
                        }
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
        private function handleSignup()
        {
                $errorMessages = [];

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Email validation
                        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                $email = $_POST['email'];
                        } else {
                                $errorMessages['email'] = "Invalid email format";
                        }

                        // Phone number validation
                        if (preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
                                $phone = $_POST['phone'];
                        } else {
                                $errorMessages['phone'] = "Invalid phone number format";
                        }


                        if (empty($errorMessages)) {
                                header("Location: profile.html");
                                exit;
                        }
                }
        }
}
