<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// require_once 'controller.php';
// controller.php is the one handles logic, I think??????

if ('/' === $uri) {
    include 'index.html';
} elseif ('/show' === $uri && isset($_GET['id'])) {
    show_action($_GET['id']);
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}

