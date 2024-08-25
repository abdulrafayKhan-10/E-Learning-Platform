<?php
session_start();
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
if (isset($_POST['suggestBtn'])) {
	$course_name = $_POST['course_name'];
	$course_description = $_POST['course_description'];
	$topics_covered = $_POST['topics_to_be_covered'];
	$Duration = $_POST['duration'];
	$course_benefits = $_POST['benefits'];
	$training_type = $_POST['training_type'];
	$suitable_student_qualification = $_POST['suitable_student_qualification'];
	$pre_requirements = $_POST['pre_requirements'];
	$approx_cost_for_course = $_POST['cost_of_course'];
	$hours_per_day = $_POST['hours_per_day'];
	$supportive_documents_name = $_FILES["supportive_documents"]["name"];
	$supportive_documents_tmpname = $_FILES["supportive_documents"]["tmp_name"];
	$additional_information = $_POST['additional_info'];

	$insert_query_selector =  mysqli_prepare($conn, "INSERT INTO `suggesting_course`(`course_name`, `course_description`, `topics_covered`, `Duration`, `course_benefits`, `training_type`, `suitable_student_qualification`, `pre_requirements`, `approx_cost_for_course`, `hours_per_day`, `supportive_documents`, `additional_information`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
	$insert_query_selector->bind_param("ssssssssssss", $course_name, $course_description, $topics_covered, $Duration, $course_benefits, $training_type, $suitable_student_qualification, $pre_requirements, $approx_cost_for_course, $hours_per_day, $supportive_documents_name, $additional_information);
	if ($insert_query_selector->execute()) {
		$_SESSION['message_success'] = true;
		move_uploaded_file($supportive_documents_tmpname, "./assets/docs/supportive_docs/" . $supportive_documents_name);
		header('location: suggestions.php');
	} else {
		$_SESSION['message_failed'] = true;
		$_SESSION["err_msg"] = "Unexpected Error. Please fill the correct details according to the required format.";
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
    <title>Suggestions</title>
    <?php
	include('./style.php');
	?>

</head>

<body class="ltr main-body app sidebar-mini">
    <?php
	include('./switcher.php');
	?>
    <?php
	if (isset($_SESSION['message_success']) && $_SESSION['message_success'] == true) {
		echo "<script>toastr.success('Suggested Course Added Successfully')</script>";
		session_destroy();
	}
	?>

    <?php
	if (isset($_SESSION['message_failed']) && $_SESSION['message_failed'] == true) {
		echo "<script>toastr.error('" . $_SESSION["err_msg"] . "')</script>";
		session_destroy();
	}
	?>
    <!-- Loader -->
    <!-- <div id="global-loader">
        <img src="assets/img/preloader.svg" class="loader-img" alt="Loader">
    </div> -->
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

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
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Suggest a
                                Course</span>
                        </div>

                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Courses</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Suggestions</li>
                                <li class="breadcrumb-item active" aria-current="page">add</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->

                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">


                                    <div class="">
                                        <div class="row row-xs formgroup-wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputName">Name of the Course</label>
                                                    <input type="text" name="course_name" class="form-control" required
                                                        id="exampleInputName" placeholder="Enter Course Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone"> Course Description</label>
                                                    <textarea class="form-control" required name="course_description"
                                                        placeholder="Textarea" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone">Topics to be covered</label>
                                                    <textarea class="form-control" required name="topics_to_be_covered"
                                                        placeholder="Textarea" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone"> Duration</label>
                                                    <input type="number" class="form-control" required name="duration"
                                                        id="exampleInputPersonalPhone" placeholder="duration of Course">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone">Benefits of Course</label>
                                                    <textarea class="form-control" required placeholder="Textarea"
                                                        name="benefits" rows="2"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Training Type</label>
                                                    <select class="form-control form-select select2" required
                                                        name="training_type" data-bs-placeholder="Select Country">
                                                        <option value="Hybrid">Hybrid</option>
                                                        <option value="Offline">Offline</option>
                                                        <option value="Virtual Live Sessions">Virtual Live Sessions
                                                        </option>
                                                        <option value="Virtual Recorded Sessions">Virtual Recorded
                                                            Sessions</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">suitable student
                                                        qualification</label>
                                                    <input type="text" class="form-control" required
                                                        name="suitable_student_qualification"
                                                        id="exampleInputQualification"
                                                        placeholder="Enter qualification">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone">Pre-requirements</label>
                                                    <textarea class="form-control" required placeholder="Textarea"
                                                        name="pre_requirements" rows="2"></textarea>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Approx Cost for Course</label>
                                                    <input type="number" required class="form-control"
                                                        id="exampleInputAadhar" name="cost_of_course"
                                                        placeholder="Course cost">
                                                </div>
                                            </div>




                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Hours per day </label>
                                                    <input class="form-control" required id="number" placeholder="00:00"
                                                        name="hours_per_day" type="number">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Supportive documents</label>
                                                    <input type="file" required class="form-control"
                                                        id="exampleInputcode" name="supportive_documents"
                                                        placeholder="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Additional information</label>
                                                    <input type="text" required class="form-control"
                                                        id="exampleInputcode" name="additional_info"
                                                        placeholder="Additional information">
                                                </div>
                                            </div>


                                            <input type="submit" name="suggestBtn" value="Suggest a Course"
                                                class="btn btn-primary mt-3 mb-0" data-bs-target="#suggest"
                                                data-bs-toggle="modal" style="text-align:right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Container closed -->
            </div>
        </form>


    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php
	include('./script.php');
	?>

</body>

</html>