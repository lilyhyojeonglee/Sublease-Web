<?php
// db.php
$host = "db";
$port = "5432";

$dbname = "example"; 
$user = "localuser"; 
$password = "cs4640LocalUser!";
$dsn = "pgsql:host=$host;dbname=$dbname;";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Connection error: " . $e->getMessage());
    die("Could not connect to the database. Please try again later.");
}
?>
