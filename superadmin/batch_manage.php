<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $batch_name = $_POST["batch_name"];
    $class_duration = $_POST["class_duration"];
    $batch_starting_date = $_POST["batch_starting_date"];
    $batch_ending_date = $_POST["batch_ending_date"];
    $session_slot = $_POST["update_session_slot"];
    $additional_info = $_POST["additional_info"];

    $update_query = mysqli_prepare($conn, "UPDATE `batch` SET `batch_name`=?,`class_duration`=?, `batch_starting_date`=?,`batch_ending_date`=?,`session_slot`=?,`additional_info`=? WHERE `id` = '$id'");
    $update_query->bind_param("ssssss", $batch_name, $class_duration, $batch_starting_date, $batch_ending_date, $session_slot, $additional_info);

    if ($update_query->execute()) {
        header('location: ./managebatch.php');
        exit();
    } else {
        $error = $update_query->error;
        echo $error;
    }
}

if (isset($_GET["id"]) && isset($_GET["status"]) && $_GET["status"] == "delete") {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int)$id;
    $update = mysqli_prepare($conn, "UPDATE `batch` SET `status` = 'Deleted' WHERE `id` = '$id'");
    if ($update->execute()) {
        header('location: ./managebatch.php');
        exit();
    } else {
        $error = $update->error;
        echo $error;
    }
}

if (isset($_GET["id"]) && isset($_GET["status"]) && $_GET["status"] == "complete") {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int)$id;
    $status = "Completed";
    $query = mysqli_prepare($conn, "UPDATE `batch` SET `status` = ? WHERE `id` = ?");
    $query->bind_param("si", $status, $id);

    if ($query->execute()) {
        header('location: ./managebatch.php');
        exit();
    } else {
        $error = $query->error;
        echo $error;
    }
} else {
    $error = "Something went wrong. Please try again later.";
    echo $error;
}
