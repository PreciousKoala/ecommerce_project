<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once ROOT_DIR . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    // the gmail account and the app password are save in the .env file and it's ignored by git.
    $env = file_get_contents(ROOT_DIR . "/.env");
    $lines = explode("\n", $env);

    foreach ($lines as $line) {
        preg_match("/([^#]+)\=(.*)/", $line, $matches);
        if (isset($matches[2])) {
            putenv(trim($line));
        }
    }

    // to mail stuff, we're using google's smtp server
    $mail->Host = "smtp.gmail.com";

    // username (google email)
    $mail->Username = getenv("MAIL_USER");
    /*
        password guide:
        to use google's smtp server, we need to follow these steps:

        -enable 2-factor-authentication
        -at the bottom of the 2fa page, click to generate an app password
        -generate a 16 character password and use it here.
    */
    $mail->Password = getenv("MAIL_PASS");
    /*
        if you wish to test this with your own email and app password, either make an .env file with MAIL_USER
        and MAIL_PASS variables that hold your details, or replace the $mail->Username/Password object variables
        directly and remove the section of code that fetches the .env file.
    */

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom("no-reply@kamifold.com", "KamiFold");
    $mail->addAddress($email);
    $mail->IsHtml(true);

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = "test";

    $mail->send();

} catch (Exception $e) {
    $mailError = $e->errorMessage();
} catch (\Exception $e) {
    $mailError = $e->getMessage();
}