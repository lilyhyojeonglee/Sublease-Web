<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'SubleaseLogic.php';

$uri = $_SERVER['REQUEST_URI'];

$sublease = new SubleaseLogic($uri, $_GET, $_POST);
$sublease->run();