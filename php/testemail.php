<?php
require_once "Mail.php";



$host = "ssl://smtp.gmail.com";
$port = "465";
$username = 'mullarkeydev@gmail.com';
$password = '3mR-soV-0rb-kL9';

$from = $username;
$to = 'smullarkey@shipley.ac.uk';

$subject = "test";
$body = "test";

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