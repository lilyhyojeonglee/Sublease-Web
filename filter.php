<?php
require_once 'Database.php';
require_once 'SubleaseLogic.php'; 

// echo $_GET["gender"];
$gender = $_GET["gender"];
$sortPrice = $_GET["sortPrice"];
$petsallowed = $_GET["petsallowed"];
$furnished = $_GET["furnished"];
$maxBudget = $_GET["budgetRange"] ?? null;

$database = new Database();
$dbConnector = $database->getDbConnector();
// $query = "SELECT * FROM subleases WHERE gender = $1";
$query = "SELECT * FROM subleases";
$values = [];
// if (!empty($filters['sortPrice'])) {




if($gender == 'Female' || $gender == 'Male' ){
    $values[]= " gender = '" . $gender . "' ";
    // $values[] = $gender
}
if($petsallowed === "true"){
    $values[]= " pet=true ";
}
if($furnished === "true"){
    $values[]= " furnished=true ";
}
if ($maxBudget !== null && is_numeric($maxBudget)) {
    $values[] = "subleasefee <= {$maxBudget}";
}
if (!empty($values)) {
    $query .= " WHERE";
    $query .= implode(" AND ", $values);
}

if ($sortPrice  === 'lowToHigh') {
    $query .= " ORDER BY subleasefee ASC";
} else {
    $query .= " ORDER BY subleasefee DESC";
}


$result = pg_query($dbConnector, $query);
// $result = pg_execute($dbConnector, "filter", $values);
// $result = pg_execute($dbConnector, "filter", array(3));


// Check if the query execution was successful
if (!$result) {
    // Handle query execution failure
    throw new Exception('Failed to fetch user listings: ' . pg_last_error($dbConnector));
}
echo $query;
// Fetch all the listings and return them as JSON
$listings = pg_fetch_all($result);
echo json_encode($listings);
?>