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
        // Server settings
        setupMailServer($mail);

        // Recipients
        $mail->setFrom("info@cyanovainnovations.com", $_COOKIE["superadmin_username"]);
        addRecipients($mail);
        if (isset($_SESSION["attachment"])) {
            // Attachments
            addAttachments($mail, $attachment, $purpose);
        }

        // Content
        setupMailContent($mail, $recipient_subject, $recipient_message);

        if ($mail->send()) {
            session_unset();

            $_SESSION["mail_sent"] = "Successfully sent!";
            // Check if the request is not AJAX before redirecting
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                header('location: ./compose.php');
                exit();
            }
        } else {
            throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $e->getMessage();
    }
}

// Helper functions

function setupMailServer($mail)
{
    $mail->SMTPDebug = 0; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.hostinger.com';  // Set the SMTP server to send through
    $mail->SMTPAuth = true;  // Enable SMTP authentication
    $mail->Username = 'info@cyanovainnovations.com';  // SMTP username
    $mail->Password = 'CyanovaInnovations@2024';  // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable implicit TLS encryption
    $mail->Port = 465; // TCP port to connect to
    $mail->Debugoutput = 'html'; // Output debug information as HTML
}

function addRecipients($mail)
{
    global $conn;
    // Add logic based on sending format and recipient
    if ($_SESSION["sending_format"] === "All") {
        $recipientType = $_SESSION["recipient"];
        switch ($recipientType) {
            case 'College':
                addRecipientsFromQuery($mail, "SELECT * FROM `college`", 'email', 'name');
                break;
            case 'Trainer':
                addRecipientsFromQuery($mail, "SELECT * FROM `trainer`", 'email', 'name');
                break;
            case 'Student':
                addRecipientsFromQuery($mail, "SELECT * FROM `student`", 'email', 'name');
                break;
        }
    } elseif ($_SESSION["sending_format"] === "Batches" && isset($_SESSION["batch_id"])) {


        $batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` IN (" . $_SESSION["batch_id"] . ")");
        while ($batch = mysqli_fetch_assoc($batch_query)) {
            $course_id = $batch["course_id"]; // Assuming trainer_id is the column containing trainer information in the batch table

            // Fetch course_id from the course table based on the trainer's name
            $course_query = mysqli_query($conn, "SELECT `student_id` FROM `course_registration` WHERE `course_id`='$course_id'");
            // $course_id = mysqli_fetch_assoc($course_query)["course_id"];

            // Fetch student_id from the course_registration table based on the course_id
            // $registration_query = mysqli_query($conn, "SELECT `student_id` FROM `course_registration` WHERE `course_id`='$course_id'");
            while ($registration = mysqli_fetch_assoc($course_query)) {
                $student_id = $registration["student_id"];

                // Fetch student information from the student table based on student_id
                $student_info_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id`='$student_id'");
                $student_info = mysqli_fetch_assoc($student_info_query);

                // Add student email to the BCC list
                $mail->addBCC($student_info["email"], $student_info["name"]);
            }
        }
    } else {
        // Add individual recipient logic here
        if (!empty($_SESSION["recipient_name"]) && !empty($_SESSION["recipient_email"])) {
            $mail->addAddress($_SESSION["recipient_email"], $_SESSION["recipient_name"]);
        } else {
            $mail->addAddress("wot.official.786@gmail.com", "Info Admin");
        }
    }
}

function addRecipientsFromQuery($mail, $query, $emailField, $nameField)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $mail->addBCC($row[$emailField], $row[$nameField]);
        }
    }
}

function addAttachments($mail, $attachment, $purpose)
{
    if (!empty($attachment) && file_exists('./assets/docs/attachments/' . $attachment)) {
        $mail->addAttachment('./assets/docs/attachments/' . $attachment, $purpose);
    }
}

function setupMailContent($mail, $subject, $message)
{
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = strip_tags($message);
}

function handleSuccessfulMail()
{
    session_unset();
    $_SESSION["mail_sent"] = "Email Successfully sent!";
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('location: ./compose.php');
        exit();
    }
}
