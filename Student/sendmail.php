<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include('../db_connection/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_SESSION["sending_format"]) && isset($_SESSION["purpose"])) {
    if ($_SESSION["sending_format"] !== "All" && isset($_SESSION["recipient_name"]) && isset($_SESSION["recipient_email"])) {
        $recipient_name = $_SESSION["recipient_name"];
        $recipient_email = $_SESSION["recipient_email"];
    }
    $recipient_subject = $_SESSION["subject"];
    $recipient_message = $_SESSION["message"];
    if (isset($_SESSION["attachment"])) {
        $attachment = $_SESSION["attachment"];
    }
    $purpose = $_SESSION["purpose"];

    try {
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.hostinger.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'info@cyanovainnovations.com';  // SMTP username
        $mail->Password = 'CyanovaInnovations@2024';  // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable implicit TLS encryption
        $mail->Port = 465; // TCP port to connect to
        $mail->Debugoutput = 'html'; // Output debug information as HTML     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->setFrom("info@cyanovainnovations.com", $_COOKIE["superadmin_username"]);

        if (!empty($attachment) && file_exists('../superadmin/assets/docs/attachments/' . $attachment)) {
            $mail->addAttachment('../superadmin/assets/docs/attachments/' . $attachment, $purpose);
        }

        $mail->addAddress($recipient_email, $recipient_name);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $recipient_subject;
        $mail->Body    = $recipient_message;
        $mail->AltBody = strip_tags($recipient_message);

        if ($mail->send()) {
            $_SESSION["success"] = "Message has been sent";
            header('location: compose.php');
            exit();
        } else {
            $_SESSION["error"] = "Message could not be sent.";
            header('location: compose.php');
            exit();
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION["error"] = "Message could not be sent. Mailer Error: {$e->getMessage()}";
        header('location: compose.php');
        exit();
    }
}
