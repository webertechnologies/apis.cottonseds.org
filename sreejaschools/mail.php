<?php
// Include the functions files
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
send_mail($mail, $subject, $msg);

echo "<script>window.location.href='https://sreejaschools.com/thankyou.html'</script>";