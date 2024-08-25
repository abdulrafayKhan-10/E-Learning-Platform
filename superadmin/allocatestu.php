<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["allocateid"]) || !isset($_GET["crid"]) || !isset($_GET["stuid"])) {
    if (isset($_SESSION['previous_url'])) {
        header('location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        header("location:alloc.php?error=" . $error . "");
        exit();
    }
}
if (!empty($_GET["allocateid"]) || !empty($_GET["crid"]) || !empty($_GET["stuid"])) {
    $allocateId = filter_var($_GET["allocateid"], FILTER_SANITIZE_NUMBER_INT);
    $allocateId = (int) $allocateId;
    $crid = filter_var($_GET["crid"], FILTER_SANITIZE_NUMBER_INT);
    $crid = (int) $crid;
    $stuid = filter_var($_GET["stuid"], FILTER_SANITIZE_NUMBER_INT);
    $stuid = (int) $stuid;

    $query = mysqli_prepare($conn, "INSERT INTO `student_allocate`(`student_id`, `allocate_id`, `course_id`) VALUES (?,?,?)");

    $query->bind_param("iii", $stuid, $allocateId, $crid);

    if ($query->execute()) {
        if (isset($_SESSION['previous_url'])) {
            $_SESSION["success"] = "Student Allocated Successfully.";
            header('location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            $_SESSION["success"] = "Student Allocated Successfully.";
            // Fallback redirection if previous_url is not set

            header("location:alloc.php?crid=" . $crid . "");
            exit();
        }
    } else {
        if (isset($_SESSION['previous_url'])) {
            $_SESSION["error"] = "Something went wrong.";
            header('location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            $_SESSION["error"] = "Something went wrong.";
            header("location:alloc.php");
            exit();
        }
    }
} else {
    if (isset($_SESSION['previous_url'])) {
        header('location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        $error = "Invalid Id";
        header("location:alloc.php?error=" . $error . "");
        exit();
    }
}