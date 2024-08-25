<?php

session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["course_id"]) && !empty($_GET["course_id"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $course_id = filter_var($_GET["course_id"], FILTER_SANITIZE_NUMBER_INT);
    $course_id = (int) $course_id;
    $query = mysqli_prepare($conn, "INSERT INTO `course_registration`(`course_id`, `student_id`) VALUES (?,?)");
    $query->bind_param("ii", $course_id, $id);
    if ($query->execute()) {
        header("location:./selectstudent.php?id=" . $course_id . "&type=course");
        exit();
    }
} else {
    $error = "Invalid Request";
    header("location:./dashboard.php?error=" . $error . "");
    exit();
}