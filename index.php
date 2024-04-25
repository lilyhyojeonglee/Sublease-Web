<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'SubleaseLogic.php';
// spl_autoload_register(function ($classname) {
//     // $argg = "../opt/src/trivia/$classname.php";
    
//     include "opt/src/trivia/$classname.php";
// });
$uri = $_SERVER['REQUEST_URI'];

$sublease = new SubleaseLogic($_GET);
$sublease->run();