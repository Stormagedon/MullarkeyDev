<?php
require_once "Mail.php";

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}

// MSG SUBJECT
if (empty($_POST["msg_subject"])) {
    $errorMSG .= "Subject is required ";
} else {
    $msg_subject = $_POST["msg_subject"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = $_POST["message"];
}


if (empty($_POST["phone"])) {
    $phone = "n/a ";
} else {
    $phone = $_POST["phone"];
}

//$EmailTo = "steve@mullarkey.dev";
//$Subject = "New Message Received";

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Phone: ";
$Body .= $phone;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "Subject: ";
$Body .= $msg_subject;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

// send email
///$success = mail($EmailTo, $Subject, $Body, "From:".$email);


$host = "ssl://smtp.gmail.com";
$port = "465";
$username = 'mullarkeydev@gmail.com';
$password = 'nbpaiknsvjzmiryl';  // '3mR-soV-0rb-kL9';

$from = $username;
$to = 'steve@mullarkey.dev';

$subject = "New message from mullarkey.dev";
$body = $Body;

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo($mail->getMessage());
} else {
  echo("Message successfully sent!\n");
}


?>
