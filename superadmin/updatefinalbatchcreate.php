<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}


// if (isset($_POST["update"])) {

// 	$id = $_POST["id"];
// 	$batch_name = $_POST["batch_name"];
// 	$class_duration = $_POST["class_duration"];
// 	$batch_starting_date = $_POST["batch_starting_date"];
// 	$batch_ending_date = $_POST["batch_ending_date"];
// 	$session_slot = $_POST["update_session_slot"];
// 	$additional_info = $_POST["additional_info"];

// 	$update_query = mysqli_prepare($conn, "UPDATE `batch` SET `batch_name`=?,`class_duration`=?, `batch_starting_date`=?,`batch_ending_date`=?,`session_slot`=?,`additional_info`=? WHERE `id` = '$id'");
// 	$update_query->bind_param("ssssss", $batch_name, $class_duration, $batch_starting_date, $batch_ending_date, $session_slot, $additional_info);

// 	if ($update_query->execute()) {
// 		header('location: ./managebatch.php');
// 		exit();
// 	} else {
// 		$error = $update_query->error;
// 		echo $error;
// 	}
// }

if (!isset($_GET["id"]) && empty($_GET["id"])) {
	header('location: ./managebatch.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">


<head>
	<title>Update Batch</title>
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
				<?php include("./partials/navbar.php"); ?>
			</div>
			<!-- /main-header -->

			<!-- main-sidebar -->
			<div class="sticky">
				<?php include("./partials/sidebar.php") ?>
			</div>
			<!-- main-sidebar -->

		</div>
		<form method="POST" action="./batch_manage.php">

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
							<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> update batch</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Courses</a></li>
								<li class="breadcrumb-item active" aria-current="page">Student Batch</li>
								<li class="breadcrumb-item active" aria-current="page">update</li>
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
										<?php
										$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
										$id = (int) $id;
										$query = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$id'");
										if (mysqli_num_rows($query) > 0) {
											$batch_row = mysqli_fetch_assoc($query);

										?>
											<div class="row row-xs formgroup-wrapper">
												<div class="col-md-6">
													<input name="id" type="hidden" value="<?php echo $batch_row['id']; ?>">
													<div class="form-group">
														<label for="exampleInputName">Batch name</label>

														<input type="text" class="form-control" id="exampleInputName" name="batch_name" value="<?php echo $batch_row['batch_name']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputPersonalPhone">Class Duration</label>
														<input type="text" class="form-control" id="exampleInputPersonalPhone" name="class_duration" value="<?php echo $batch_row['class_duration']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputCompanyPhone"> Course ID</label>
														<input type="text" class="form-control" id="exampleInputCompanyPhone" name="course_id" readonly value="<?php echo $batch_row['course_id']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputPersonalPhone">Course Name</label>
														<input type="text" class="form-control" id="exampleInputPersonalPhone" name="course_name" readonly value="<?php echo $batch_row['batchcourse_name']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputCompanyPhone"> Trainer ID</label>
														<input type="text" class="form-control" id="exampleInputCompanyPhone" name="trainer_id" readonly value="<?php echo $batch_row['trainer_id']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputPersonalPhone">Trainer name</label>
														<input type="text" class="form-control" id="exampleInputPersonalPhone" name="trainer_name" readonly value="<?php echo $batch_row['batchtrainer_name']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputPersonalPhone">Batch starting date</label>
														<input type="date" class="form-control" id="exampleInputPersonalPhone" name="batch_starting_date" value="<?php echo $batch_row["batch_starting_date"] ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputPersonalPhone">Batch ending date</label>
														<input type="date" class="form-control" id="exampleInputPersonalPhone" name="batch_ending_date" value="<?php echo $batch_row['batch_ending_date']; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputAadhar">Session slot</label>
														<select name="update_session_slot" class="form-control form-select select2" data-bs-placeholder="Select Session">
															<option value="Morning-1" <?php if ($batch_row["session_slot"] == "Morning-1") {
																							echo "selected";
																						} ?>>
																Morning-1
															</option>
															<option value="Morning-2" <?php if ($batch_row["session_slot"] == "Morning-2") {
																							echo "selected";
																						} ?>>
																Morning-2
															</option>
															<option value="Afternoon-1" <?php if ($batch_row["session_slot"] == "Afternoon-1") {
																							echo "selected";
																						} ?>>
																Afternoon-1
															</option>
															<option value="Afternoon-2" <?php if ($batch_row["session_slot"] == "Afternoon-2") {
																							echo "selected";
																						} ?>>
																Afternoon-2
															</option>
															<option value="Evening-1" <?php if ($batch_row["session_slot"] == "Evening-1") {
																							echo "selected";
																						} ?>>
																Evening-1
															</option>
															<option value="Evening-2" <?php if ($batch_row["session_slot"] == "Evening-2") {
																							echo "selected";
																						} ?>>
																Evening-2
															</option>
														</select>

													</div>
												</div>


												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputcode"> additional information</label>
														<input type="text" class="form-control" id="exampleInputcode" name="additional_info" value="<?php echo $batch_row['additional_info']; ?>">
													</div>
												</div>
												<button type="submit" name="update" class="btn btn-success mt-3 mb-0" style="text-align:right">Update</button>

											</div>
										<?php } else {
											header('location: ./managebatch.php');
										} ?>
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
	<?php include("./scripts.php"); ?>

</body>

</html>