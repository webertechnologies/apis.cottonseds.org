<?php
// Set the content type to JSON
header('content-type:application/json');

// Include the database connection and functions files
require('../configs/functions.php');

// get mail, subject and message from the request
$mail = $_POST['mail'];
$subject = $_POST['subject'];
$msg = $_POST['msg'];

// Send the mail
send_mail($mail, $subject, $msg);


// Return the results as a JSON object
echo json_encode(['status' => 'success']);