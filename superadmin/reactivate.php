<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["student_id"]) && !empty($_GET["student_id"]) && isset($_GET["course_id"]) && !empty($_GET["course_id"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $student_id = filter_var($_GET["student_id"], FILTER_SANITIZE_NUMBER_INT);
    $student_id = (int) $student_id;
    $course_id = (int) $_GET["course_id"];
    $status = "Active";
    $query_batch = mysqli_prepare($conn, "UPDATE `batch_student` SET `status`=? WHERE `id`=?");
    $query = mysqli_prepare($conn, "UPDATE `course_registration` SET `status`=? WHERE `student_id`=? AND `course_id`=?");
    mysqli_stmt_bind_param($query_batch, "si", $status, $id);
    mysqli_stmt_bind_param($query, "sii", $status, $student_id, $course_id);
    if (mysqli_stmt_execute($query_batch) && mysqli_stmt_execute($query)) {
        if (isset($_SESSION['previous_url'])) {
            $_SESSION["success"] = "Batch Re-Activated.";
            header('location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            $_SESSION["success"] = "Batch Re-Activated.";
            header('location: student_manage_batch.php');
            exit();
        }
    }
} else {
    $_SESSION["error"] = "Something went wrong. Please try again later.";
    header('location: student_manage_batch.php');
    exit();
}
