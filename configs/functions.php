<?php
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function get_safe_value($con, $str){
    if($str!=''){
        $str=trim($str);
    return mysqli_real_escape_string($con, $str);
    }
}
function pr($arr){
    echo'<pre>';
    print_r($arr);
}
function prx($arr){
    echo'<pre>';
    print_r($arr);
    die();
}

function send_mail($email,$subject,$msg){
    //Load Composer's autoloader
require '../vendor/autoload.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

    //Server settings                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sreejaschools@gmail.com';                     //SMTP username
    $mail->Password   = 'mxiwrxdkfddhhyxn';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('sreejaschools@gmail.com', 'Sreeja Schools');
    $mail->addAddress("sreejaschools@gmail.com", 'STM USER');     //Add a recipient
    $mail->addAddress("sreejaschools@gmail.com");               //Name is optional
    $mail->addReplyTo("sreejaschools@gmail.com", 'USER');
    $mail->addCC('sreejaschools@gmail.com');
    $mail->addBCC('sreejaschools@gmail.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    $mail->AltBody = 'Email from Sreeja Schools';

    $mail->send();

}
?>