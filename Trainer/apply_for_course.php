<?php
session_start();
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
$course_id = $_GET['id'];
if (isset($_POST['submitBtn'])) {
	$trainer_name = $_POST['trainer_name'];
	$course_name = $_POST['course_name'];
	$trainer_id = $_POST['trainer_id'];
	$insert_query = ($conn->query("INSERT INTO `trainer_applying_for_courses`(`trainer_name`, `trainer_id`, `course_name`, `course_id`) VALUES ('$trainer_name','$trainer_id','$course_name','$course_id')"));
	if ($insert_query) {
		$_SESSION['success'] = "Applied Successfully";
		header("location:apply_for_course.php");
		exit();
	} else {
		$_SESSION['error'] = "Error in applying";
		header("location:apply_for_course.php");
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>Apply For Course</title>

    <?php
	include('./style.php');
	?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php
	include('./switcher.php');
	?>
    <!-- Loader -->

    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
        <?php
		if (isset($_SESSION['message_success']) && $_SESSION['message_success'] == true) {
			echo "<script>toastr.success('Applied Successfully!');</script>";
			session_destroy();
		} elseif (isset($_SESSION['message_failed']) && $_SESSION['message_failed'] == true) {
			echo "<script>toastr.error('Error in applying');</script>";
			session_destroy();
		}
		?>
        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include('./partials/navbar.php') ?>
            </div>
            <!-- /main-header -->
            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form action="" method="POST">
            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Trainer Applying
                                for Course</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                                <li class="breadcrumb-item active" aria-current="page">Meetings</li>
                            </ol>
                        </div>
                    </div>



                </div>
                <br>


                <!-- row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <?php
								$un = $_COOKIE['trainer_username'];
								$select_trainer_name = ($conn->query("SELECT * FROM `trainer` WHERE `username` = '$un'"))->fetch_assoc();
								?>

                                <div class="">
                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Trainer </label>
                                                <input class="form-control" name="trainer_name" id="trainer_name"
                                                    required value="<?php echo $select_trainer_name['name'] ?>"
                                                    type="text">
                                                <input type="hidden" name="trainer_id" id="trainer_id"
                                                    value="<?php echo $select_trainer_name['id'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php

												$select_courses = ($conn->query("SELECT * FROM `course` WHERE id = '$course_id'"))->fetch_assoc();
												?>
                                                <label for="course">Course</label>
                                                <input type="text" class="form-control" name="course_name"
                                                    id="course_name"
                                                    value="<?php echo $select_courses['course_name'] ?>" required>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" name="submitBtn" class="btn btn-info mt-3 mb-0"
                                        data-bs-toggle="modal" style="text-align:right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <a href="courselist.php" class="btn btn-success	mt-3 mb-0 mx-3	"><i
                        class="las la-angle-left pe-2"></i>Go to Course List</a>
            </div>
            <!-- Container closed -->
        </form>
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php
	include('./script.php');
	?>

    <?php
	if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
		echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
	} else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
		echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
	}
	session_destroy();
	?>
</body>

</html>