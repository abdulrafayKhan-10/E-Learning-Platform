<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}

if (isset($_POST["allocate"])) {
	$id = filter_var($_POST["batch_id"], FILTER_SANITIZE_NUMBER_INT);
	$id = (int) $id;
	$staus = "Active";
	$update_query = mysqli_prepare($conn, "UPDATE `batch` SET `status`=? WHERE `id`=?");
	$update_query->bind_param("ss", $staus, $id);
	if ($update_query->execute()) {
		header('location: ./addbatchtrainer.php?trainer_id=' . $_GET["trainer_id"] . '&course_id=' . $_GET["course_id"] . '&batch_id=' . $_GET["batch_id"]);
	}
}

if (!isset($_GET["trainer_id"]) && !isset($_GET["course_id"]) && !isset($_GET["batch_id"])) {
	header('location: ./managebatch.php');
	exit();
}

$id = filter_var($_GET['batch_id'], FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$trainer_id = filter_var($_GET['trainer_id'], FILTER_SANITIZE_SPECIAL_CHARS);
$course_id = filter_var($_GET['course_id'], FILTER_SANITIZE_SPECIAL_CHARS);


$query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `batchtrainer_id` = '$trainer_id' AND `batchcourse_id` = '$course_id' AND `status`='Removed'");

if (mysqli_num_rows($query) == 0) {
	header("location:./managebatch.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<title>Add Batch Trainer</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="">

	<?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
	<?php require("./switcher.php"); ?>

	<!-- Page -->
	<div class="page">

		<div>

			<div class="main-header side-header sticky nav nav-item">
				<?php include('./partials/navbar.php'); ?>
			</div>
			<!-- /main-header -->

			<!-- main-sidebar -->
			<div class="sticky">
				<?php include('./partials/sidebar.php') ?>
			</div>
			<!-- main-sidebar -->

		</div>
		<!-- main-content -->
		<div class="main-content app-content">

			<!-- container -->
			<div class="main-container container-fluid">


				<div class="breadcrumb-header justify-content-between">
					<div class="right-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Batch Allocation </span>
					</div>

					<div class="justify-content-center mt-2">
						<ol class="breadcrumb">
							<li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
							<li class="breadcrumb-item ">Student batch</li>
							<li class="breadcrumb-item ">Create</li>
						</ol>
					</div>

				</div>
				<!--			<div class="row row-sm">
					                 <div class="form-group col-md-3">
										<select name="country" class="form-control form-select" data-bs-placeholder="Select Filter">
												<option value="br">Filter4</option>
												<option value="cz">Filter3</option>
												<option value="de">Filter2</option>
												<option value="pl" selected>Course name</option>
											</select>
									</div>
														                 <div class="form-group col-md-3">
										<select name="country" class="form-control form-select" data-bs-placeholder="college name">
												<option value="br">Filter4</option>
												<option value="cz">Filter3</option>
												<option value="de">Filter2</option>
												<option value="pl" selected>College name</option>
											</select>
									</div>
														                 <div class="form-group col-md-3">
										<select name="country" class="form-control form-select" data-bs-placeholder="Stream">
												<option value="br">B.sc</option>
												<option value="br">BBA</option>
												<option value="br">MBA</option>
												<option value="br">M.Tech</option>
												<option value="br">MBA</option>
												<option value="cz">B.tech</option>
												<option value="de">B.com</option>
												<option value="pl" selected>BA</option>
												<option value="pl" selected>Others</option>
											</select>
									</div>
									
									<div class="form-group col-md-3">
										<select name="country" class="form-control form-select" data-bs-placeholder="">
												<option value="br">1st sem
												</option>
												<option value="cz">2nd Sem</option>
												<option value="de">3rd Sem</option>
												<option value="pl">4th Sem</option>
												<option value="pl">5th Sem</option>
												<option value="pl">6th Sem</option>
												<option value="pl">7th Sem</option>
												<option value="pl">8th Sem</option>
											</select>
									</div>
									
									
									


&nbsp &nbsp	<a href="javascript:void(0);" class="btn btn-info">Search</a>	
                                               &nbsp &nbsp <a href="javascript:void(0);" class="btn btn-danger">Reset All </a>		
								&nbsp &nbsp 		<a href="batchfinalCreate.html" class="btn btn-success" >Create batch</a>	
                                               								
									</div>
									
<br>																		
<br>	-->

				<div class="row row-sm">
					<div class="col-lg-12">
						<div class="card custom-card overflow-hidden">
							<div class="card-body">

								<div class="table-responsive  export-table">
									<table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
										<thead>
											<tr>
												<th class="border-bottom-0">S.no</th>
												<th class="border-bottom-0">Course Id</th>
												<th class="border-bottom-0">Trainer Name</th>
												<th class="border-bottom-0">Batch Name</th>
												<th class="border-bottom-0">Allocate</th>




											</tr>
										</thead>
										<tbody>
											<?php

											if (mysqli_num_rows($query) > 0) {
												$i = 1;
												while ($row = mysqli_fetch_assoc($query)) {
													if ($row["status"] == "Removed") {
														echo "<tr>";
														echo "<td>" . $i++ . "</td>";
														echo "<td>" . $row['batchcourse_id'] . "</td>";
														echo "<td>" . $row['batchtrainer_name'] . "</td>";
														echo "<td>" . $row['batch_name'] . "</td>";
														echo "<form method='POST'>
													<input type='hidden' name='batch_id' value='" . $row['id'] . "'>
													<td><button type='submit' name='allocate' class='btn btn-success'>Allocate</button></td>
													</form>";
														echo "</tr>";
													}
												}
											}
											?>
										</tbody>

									</table>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>