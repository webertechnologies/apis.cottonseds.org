<?php
// Start the session
session_start();

// display_errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$con = mysqli_connect("34.172.217.6","hydro","hydro123","weber_technologies");
if (!$con) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}

// Connect to the local database
// $con = mysqli_connect("localhost","root","","weber_technologies");
// if (!$con) {  
//     die("Failed to connect with MySQL: ". mysqli_connect_error());  
// }