<?php
// db.php
$host = "localhost"; // Or the appropriate host for your database
$dbname = "your_actual_database_name"; // Replace with your actual database name
$user = "your_actual_database_user"; // Replace with your actual database username
$password = "your_actual_database_password"; // Replace with your actual database password
$dsn = "pgsql:host=$host;dbname=$dbname;";

try {
    $pdo = new PDO($dsn, $user, $password);
    // Set error mode to exceptions to handle errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionally, set the default fetch mode to fetch_assoc for convenience
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // It's better to log this error and not show it directly for security reasons
    error_log("Connection error: " . $e->getMessage());
    // You might want to show a generic error message to the user
    die("Could not connect to the database. Please try again later.");
}
?>
