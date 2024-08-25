<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
include('../db_connection/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_username'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (isset($_SESSION["sending_format"]) && isset($_SESSION["purpose"])) {
    if ($_SESSION["sending_format"] !== "All") {
        if (!empty($_SESSION["recipient_name"]) && !empty($_SESSION["recipient_email"])) {
            $recipient_name = $_SESSION["recipient_name"];
            $recipient_email = $_SESSION["recipient_email"];
        }
    }
    $recipient_subject = $_SESSION["subject"];
    $recipient_message = $_SESSION["message"];
    if (isset($_SESSION["attachment"]) && !empty($_SESSION["attachment"])) {
        $attachment = $_SESSION["attachment"];
    }
    $purpose = $_SESSION["purpose"];
    $sender_email = $_SESSION["sender_email"];
    $sender_name = $_SESSION["sender_name"];
    if (isset($_SESSION["college_name"]) && !empty($_SESSION["college_name"])) {

        $college_name = $_SESSION["college_name"];
    }


    //Create an instance; passing `true` enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = 0; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.hostinger.com';  //Set the SMTP server to send through
        $mail->SMTPAuth = true;  //Enable SMTP authentication
        $mail->Username = 'info@cyanovainnovations.com';  //SMTP username
        $mail->Password = 'CyanovaInnovations@2024';  //SMTP password
        $mail->SMTPSecure = 'ssl'; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->Debugoutput = 'html'; // Output debug information as HTML
        $mail->clearAllRecipients();
        // Check if the request is not AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            // echo "Before creating PHPMailer instance<br>";
            // echo "After creating PHPMailer instance<br>";
        }

        $mail->setFrom("info@cyanovainnovations.com", $sender_name);
        //Recipients
        if (!empty($recipient_email) && !empty($recipient_name)) {
            $mail->addAddress($recipient_email, $recipient_name);     //Add a recipient

        } else {
            $mail->addAddress("support@cyanovainnovations.com", "Info Admin");
        }



        //$mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('', '');
        if ($_SESSION["sending_format"] === "All" && $_SESSION["recipient"] === "Student") {

            $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `college_name` = '$college_name'");
            if (mysqli_num_rows($student_query) > 0) {
                while ($student = mysqli_fetch_assoc($student_query)) {
                    $mail->addBCC($student["email"], $student["name"]);
                }
            }
        } else if ($_SESSION["sending_format"] === "batches" && isset($_SESSION["batch_id"])) {
            $b_id = $_SESSION["batch_id"];
            $batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id`='$b_id'");
            if (mysqli_num_rows($batch_query) > 0) {
                while ($batch = mysqli_fetch_assoc($batch_query)) {
                    $course_query = mysqli_query($conn, "SELECT * FROM `course_registration` WHERE `id` = '$batch[course_id]'");
                    while ($course = mysqli_fetch_assoc($course_query)) {
                        $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '$course[student_id]'");
                        while ($student = mysqli_fetch_assoc($student_query)) {
                            // Add each student as a BCC recipient
                            $mail->addBCC($student["email"], $student["name"]);
                        }
                    }
                }
            }
        }

        // $mail->addCC('');
        // $mail->addBCC('');

        //Attachments
        if (!empty($attachment) && file_exists('../superadmin/assets/docs/attachments/' . $attachment)) {
            $mail->addAttachment('../superadmin/assets/docs/attachments/' . $attachment, $purpose); //Add attachments

        }
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $recipient_subject;
        $mail->Body    = $recipient_message;
        $mail->AltBody = strip_tags($recipient_message);

        if ($mail->send()) {
            session_destroy();
            session_start();
            $_SESSION["mail_sent"] = "Successfully sent!";
            // Check if the request is not AJAX before redirecting
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                header('location: ./compose.php');
                exit();
            }
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}