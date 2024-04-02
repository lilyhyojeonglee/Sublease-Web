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
                                $this->servePage('index.html');
                                break;
                        case '/login':
                                $this->servePage('login.html');
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

        private function handleSignup()
        {
                $errorMessages = [];

                // Check if the form was submitted
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

                        // You can add further processing here, such as saving the data to a database
                        // For now, we will just redirect to the profile page if everything is fine
                        if (empty($errorMessages)) {
                                header("Location: profile.html");
                                exit;
                        }
                }
        }
}
