<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"]) && empty($_GET["id"]) && !isset($_GET["trainer_id"]) && empty($_GET["trainer_id"])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
if (!isset($_GET["type"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $trainer_id = filter_var($_GET["trainer_id"], FILTER_SANITIZE_NUMBER_INT);
    $trainer_id = (int) $trainer_id;

    $insert = mysqli_prepare($conn, "INSERT INTO `allocate_trainer_course`(`trainer_id`, `course_id`) VALUES (?,?)");
    mysqli_stmt_bind_param($insert, "ii", $trainer_id, $id);
    if (mysqli_stmt_execute($insert)) {
        if (isset($_SESSION['previous_url'])) {
            header('Location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            // Fallback redirection if previous_url is not set
            header('Location: ./dashboard.php');
            exit();
        }
    }
}


if (isset($_GET["cr_id"]) && !empty($_GET["cr_id"]) && isset($_GET["trainer_id"]) && !empty($_GET["trainer_id"]) && isset($_GET["type"]) && $_GET["type"] == "unallocate") {
    $id = filter_var($_GET["cr_id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $trainer_id = filter_var($_GET["trainer_id"], FILTER_SANITIZE_NUMBER_INT);
    $trainer_id = (int) $trainer_id;
    $delete = mysqli_prepare($conn, "DELETE FROM `allocate_trainer_course` WHERE `trainer_id` = ? AND `course_id` = ?");
    mysqli_stmt_bind_param($delete, "ii", $trainer_id, $id);
    if (mysqli_stmt_execute($delete)) {
        if (isset($_SESSION['previous_url'])) {
            header('Location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            // Fallback redirection if previous_url is not set
            header('Location: ./dashboard.php');
            exit();
        }
    } else {
        echo "Something went wrong 1";
        echo mysqli_error($conn);
    }
} else {
    echo "Something went wrong 2";
    echo mysqli_error($conn);
}
