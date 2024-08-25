<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}

if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["internship_id"]) && !empty($_GET["internship_id"])) {
	$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
	$id = (int) $id;
	$internship_id = filter_var($_GET["internship_id"], FILTER_SANITIZE_NUMBER_INT);
	$internship_id = (int) $internship_id;
	$query = mysqli_prepare($conn, "INSERT INTO `student_selected_for_internship`(`student_id`, `internship_id`) VALUES (?,?)");
	$query->bind_param("ss", $id, $internship_id);
	if ($query->execute()) {
		$_SESSION["success"] = "Student Allocated Successfully.";
		header("location:./selectstudent.php?id=" . $internship_id);
		exit();
	}
} else if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["placement_id"]) && !empty($_GET["placement_id"])) {
	$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
	$id = (int) $id;
	$placement_id = filter_var($_GET["placement_id"], FILTER_SANITIZE_NUMBER_INT);
	$placement_id = (int) $placement_id;
	$query = mysqli_prepare($conn, "INSERT INTO `student_selected_for_placement`(`student_id`, `placement_id`) VALUES (?,?)");
	$query->bind_param("ss", $id, $placement_id);
	if ($query->execute()) {
		$_SESSION["success"] = "Student Allocated Successfully.";
		header("location:./selectstudentplacement.php?id=" . $placement_id);
		exit();
	}
} else if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["course_id"]) && !empty($_GET["course_id"])) {
	$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
	$id = (int) $id;
	$course_id = filter_var($_GET["course_id"], FILTER_SANITIZE_NUMBER_INT);
	$course_id = (int) $course_id;
	$query = mysqli_prepare($conn, "INSERT INTO `course_registration`(`course_id`, `student_id`) VALUES (?,?)");
	$query->bind_param("ii", $course_id, $id);
	if ($query->execute()) {
		$_SESSION["success"] = "Student Allocated Successfully.";
		header("location:./selectstudent.php?id=" . $course_id . "&type=course");
		exit();
	}
} else {
	$error = "Invalid Request";
	$_SESSION["error"] = $error;
	header("location:./dashboard.php?error=" . $error . "");
	exit();
}
