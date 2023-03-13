<?php
// Set the content type to JSON
header('content-type:application/json');

// Include the database connection and functions files
require('../configs/functions.php');

// get mail, subject and message from the request
$name = $_POST['name'];
$mail = $_POST['mail'];
$subject = 'Sreeja Schools - Admission Form';
$mobile = $_POST['mobile'];
$class = $_POST['class'];

// Build the message
$msg = "Name: $name <br> Email: $mail <br> Mobile: $mobile <br> Class: $class";


// Send the mail
if(send_mail($mail, $subject, $msg)=='sent'){
    echo json_encode(['status' => 'success']);
}else{
    echo json_encode(['status' => 'error']);
}