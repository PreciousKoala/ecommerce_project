<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once ROOT_DIR . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    // to mail stuff, we're using google's smtp server
    $mail->Host = "smtp.gmail.com";

    // username (google email)
    $mail->Username = MAIL_USER;
    /*
        password guide:
        to use google's smtp server, we need to follow these steps:

        -enable 2-factor-authentication
        -at the bottom of the 2fa page, click to generate an app password
        -generate a 16 character password and use it here.
    */

    $mail->Password = MAIL_PASS;
    /*
        if you wish to test this with your own email and app password, either make an .env file with MAIL_USER
        and MAIL_PASS variables that hold your details, or replace the $mail->Username/Password object variables
        directly and remove the section of code that fetches the .env file from config.php.
    */

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom("no-reply@kamifold.com", "KamiFold");

    // body and subject variables are defined before the inclusion of mailer.php
    $mail->addAddress($email);
    $mail->Subject = $subject;


    $mail->msgHTML($body, ROOT_DIR);

    $mail->send();

} catch (Exception $e) {
    $mailError = $e->errorMessage();
} catch (\Exception $e) {
    $mailError = $e->getMessage();
}