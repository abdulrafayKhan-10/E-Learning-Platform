<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}

if (!isset($_GET["id"]) && !isset($_GET["crid"])) {
	header('location: ./createbatch.php');
	exit();
}

if (isset($_POST["create"])) {
	$batch_name = htmlspecialchars($_POST["batch_name"]);
	$class_duration = htmlspecialchars($_POST["class_duration"]);
	$batchcourse_id = htmlspecialchars($_POST["batchcourse_id"]);
	$course_id = htmlspecialchars($_POST["course_id"]);
	$batchcourse_name = htmlspecialchars($_POST["batchcourse_name"]);
	$batchtrainer_id = htmlspecialchars($_POST["batchtrainer_id"]);
	$trainer_id = htmlspecialchars($_POST["trainer_id"]);
	$batchtrainer_name = htmlspecialchars($_POST["batchtrainer_name"]);
	$batch_starting_date = htmlspecialchars($_POST["batch_starting_date"]);
	$batch_ending_date = htmlspecialchars($_POST["batch_ending_date"]);
	$session_slot = htmlspecialchars($_POST["session_slot"]);
	$additional_info = htmlspecialchars($_POST["additional_info"]);
	$created_by = "Admin";

	$query = mysqli_prepare($conn, "INSERT INTO `batch`(`batch_name`, `class_duration`, `batchcourse_id`, `course_id`, `batchcourse_name`, `batchtrainer_id`, `trainer_id`, `batchtrainer_name`, `batch_starting_date`, `batch_ending_date`, `session_slot`, `additional_info`, `created_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

	if ($query) {
		$query->bind_param(
			"sssssssssssss",
			$batch_name,
			$class_duration,
			$batchcourse_id,
			$course_id,
			$batchcourse_name,
			$batchtrainer_id,
			$trainer_id,
			$batchtrainer_name,
			$batch_starting_date,
			$batch_ending_date,
			$session_slot,
			$additional_info,
			$created_by
		);
		if ($query->execute()) {
			$_SESSION["success"] = "Batch Created Successfully.";
			header('location: ./createbatch.php');
			exit();
		} else {
			$_SESSION["error"] = "Something went wrong.";
			header('location: ./createbatch.php');
			exit();
		}
	} else {
		$_SESSION["error"] = "Something went wrong.";
		header('location: ./createbatch.php');
		exit();
	}
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
	<title>Create Batch</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="">

	<?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
	<?php include("./switcher.php"); ?>
	<!-- Page -->
	<div class="page">

		<div>

			<div class="main-header side-header sticky nav nav-item">
				<?php include("./partials/navbar.php") ?>
			</div>
			<!-- /main-header -->

			<!-- main-sidebar -->
			<div class="sticky">
				<?php include("./partials/sidebar.php") ?>
			</div>
			<!-- main-sidebar -->

		</div>

		<form method="POST">

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
							<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create batch</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Courses</a></li>
								<li class="breadcrumb-item active" aria-current="page">Student Batch</li>
								<li class="breadcrumb-item active" aria-current="page">Create</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- row -->
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">

									<?php
									$trainer_id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
									$trainer_id = (int) $trainer_id;
									$course_id = filter_var($_GET["crid"], FILTER_SANITIZE_NUMBER_INT);
									$course_id = (int) $course_id;

									$query_cr = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$course_id'");
									$row_cr = mysqli_fetch_assoc($query_cr);
									$query_tr = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '$trainer_id'");
									$row_tr = mysqli_fetch_assoc($query_tr);


									?>


									<div class="">
										<div class="row row-xs formgroup-wrapper">
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputName">Batch Name</label>
													<input type="text" name="batch_name" class="form-control" id="exampleInputName" placeholder="Enter Batch Name">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputPersonalPhone">Class Duration</label>
													<input type="text" name="class_duration" class="form-control" id="exampleInputPersonalPhone" value="">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputCompanyPhone">Course ID</label>
													<input type="text" name="batchcourse_id" class="form-control" id="exampleInputCompanyPhone" readonly value="COURSE_<?php echo $row_cr['id']; ?>">
													<input type="text" name="course_id" class="form-control" id="exampleInputCompanyPhone" hidden value="<?php echo $row_cr['id']; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputPersonalPhone">Course Name</label>
													<input type="text" name="batchcourse_name" class="form-control" id="exampleInputPersonalPhone" readonly value="<?php echo $row_cr['course_name']; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputCompanyPhone"> Trainer ID</label>
													<input type="text" name="batchtrainer_id" class="form-control" id="exampleInputCompanyPhone" readonly value="TRTRA_<?php echo $trainer_id; ?>">
													<input type="text" name="trainer_id" class="form-control" id="exampleInputCompanyPhone" hidden value="<?php echo $trainer_id; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputPersonalPhone">Trainer Name</label>
													<input type="text" name="batchtrainer_name" class="form-control" id="exampleInputPersonalPhone" readonly value="<?php echo $row_tr['name']; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputPersonalPhone">Batch starting date</label>
													<input type="date" name="batch_starting_date" class="form-control" id="exampleInputPersonalPhone" placeholder="DD/MM/YYYY">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputPersonalPhone">Batch ending date</label>
													<input type="date" name="batch_ending_date" class="form-control" id="exampleInputPersonalPhone" placeholder="DD/MM/YYYY">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">

													<label for="exampleInputAadhar">Session slot</label>
													<select name="session_slot" class="form-control form-select select2" data-bs-placeholder="Select session">
														<option value="Morning-1">Morning-1</option>
														<option value="Morning-2">Morning-2</option>
														<option value="Afternoon-1">Afternoon-1</option>
														<option value="Afternoon-2">Afternoon-2</option>
														<option value="Evening-1" selected>Evening-1</option>
														<option value="Evening-2" selected>Evening-2</option>
													</select>
												</div>
											</div>


											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputcode"> additional information</label>
													<input type="text" name="additional_info" class="form-control" id="exampleInputcode" placeholder="">
												</div>
											</div>
											<button type="submit" name="create" value="create" class="btn btn-primary mt-3 mb-0" data-bs-target="#modaldemo1" data-bs-toggle="modal" style="text-align:right">Create batch</button>
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

	<?php include("./scripts.php") ?>

</body>

</html>