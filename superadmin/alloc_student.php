<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["student_id"]) && !empty($_GET["student_id"]) && isset($_GET["course_id"]) && !empty($_GET["course_id"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $student_id = filter_var($_GET["student_id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $student_id = (int) $student_id;
    $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '$student_id' ");
    $student = mysqli_fetch_assoc($student_query);
    $batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` = '$id' ");
    $batch = mysqli_fetch_assoc($batch_query);
    $status = "Active";
    $course_id = (int) $_GET["course_id"];

    $query_batch = mysqli_prepare($conn, "INSERT INTO `batch_student`(`student_id`, `student_name`, `batch_id`, `batch_name`, `batch_course_name`, `batch_trainer_name`, `status`) VALUES (?,?,?,?,?,?,?)");
    $query_course = mysqli_query($conn, "UPDATE `course_registration` SET `status`='$status' WHERE `course_id`='$course_id' AND `student_id`='$student_id'");
    mysqli_stmt_bind_param($query_batch, "issssss", $student_id, $student["name"], $id, $batch["batch_name"], $batch["batchcourse_name"], $batch["batchtrainer_name"], $status);

    // mysqli_stmt_bind_param($query_course, "s", $status);
    if (mysqli_stmt_execute($query_batch) && $query_course) {
        if (isset($_SESSION['previous_url'])) {
            $_SESSION["success"] = "Allocated Batch.";
            header('location: ' . $_SESSION['previous_url']);
            exit();
        }
        $_SESSION["success"] = "Allocated Batch.";
        header('location: student_manage_batch.php');
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong.";
        header('location: student_manage_batch.php');
        exit();
    }
} else {
    $_SESSION["error"] = "Something went wrong. Please try again later.";
    header('location: student_manage_batch.php');
    exit();
}