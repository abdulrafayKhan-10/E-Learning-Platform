<?php
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
if (!isset($_GET['id']) && empty($_GET['id'])) {
	header('location: ./profile.php');
	exit();
}
$id = $_GET['id'];
$select_trainer = mysqli_query($conn, "SELECT * FROM `trainer` WHERE id = '$id'");
$Fetching_trainer = mysqli_fetch_assoc($select_trainer);

if (isset($_POST["updateBtn"])) {
	$Trainer_Name = $_POST["Trainer_Name"];
	$Personal_Phone_Number = $_POST["Personal_Phone_Number"];
	$Personal_Mail_id = $_POST["Personal_mail_id"];
	$Date_Of_Birth = $_POST["Date_Of_Birth"];
	$Aadhar_Card_No = $_POST["Aadhar_Card_No"];
	$Pan_Card_No = $_POST["Pan_Card_No"];
	$Date_Of_joining = $_POST["Date_Of_joining"];
	$Qualification = $_POST["Qualification"];
	$Any_Experience = $_POST["any_experience"];
	$Previous_Current_Organization_name = $_POST["prev_current_organization_name"];
	$Designation = $_POST["Designation"];
	$Trainer_Username = $_POST["Trainer_Username"];


	$Upload_Aadhar_Card_name = $_FILES["aadhar_card_document"]["name"];
	$Upload_Aadhar_Card_Tmp = $_FILES["aadhar_card_document"]["tmp_name"];
	$Upload_Pan_Card_name = $_FILES["pan_card_document"]["name"];
	$Upload_Pan_Card_Tmp = $_FILES["pan_card_document"]["tmp_name"];
	$Upload_Trainer_Document_name = $_FILES["trainer_document"]["name"];
	$Upload_Trainer_Document_Tmp = $_FILES["trainer_document"]["tmp_name"];
	$Upload_Trainer_Profile_name = $_FILES["upload_profile"]["name"];
	$Upload_Trainer_Profile_Tmp = $_FILES["upload_profile"]["tmp_name"];


	if (empty($Upload_Aadhar_Card_name)) {
		$Upload_Aadhar_Card_name = $Fetching_trainer["aadhar_card_picture"];
	}
	if (empty($Upload_Trainer_Document_name)) {
		$Upload_Trainer_Document_name = $Fetching_trainer["trainer_document"];
	}
	if (empty($Upload_Pan_Card_name)) {
		$Upload_Pan_Card_name = $Fetching_trainer["pan_card_picture"];
	}
	if (empty($Upload_Trainer_Profile_name)) {
		$Upload_Trainer_Profile_name = $Fetching_trainer["pfp"];
	}


	$query = mysqli_prepare($conn, "UPDATE `trainer` SET `name`=?,`contact_number`=?,`email`=?,`username`=?,`dob`=?,`aadhar_card_number`=?,`aadhar_card_picture`=?,`pan_card_number`=?,`pan_card_picture`=?,`date_of_joining`=?,`qualification`=?,`experience`=?,`organization_name`=?,`designation`=?,`trainer_document`=?,`pfp`=? WHERE `id`='$id'");

	$query->bind_param("ssssssssssssssss", $Trainer_Name, $Personal_Phone_Number, $Personal_Mail_id,  $Trainer_Username, $Date_Of_Birth, $Aadhar_Card_No, $Upload_Aadhar_Card_name, $Pan_Card_No, $Upload_Pan_Card_Tmp, $Date_Of_joining, $Qualification, $Any_Experience, $Previous_Current_Organization_name, $Designation, $Upload_Trainer_Document_name, $Upload_Trainer_Profile_name);

	if ($query->execute()) {
		move_uploaded_file($Upload_Aadhar_Card_Tmp, "../superadmin/assets/img/trainer/" . $Upload_Aadhar_Card_name);
		move_uploaded_file($Upload_Pan_Card_Tmp, "../superadmin/assets/img/trainer/" . $Upload_Pan_Card_name);
		move_uploaded_file($Upload_Trainer_Document_Tmp, "../superadmin/assets/img/trainer/" . $Upload_Trainer_Document_name);
		move_uploaded_file($Upload_Trainer_Profile_Tmp, "../superadmin/assets/img/trainer/" . $Upload_Trainer_Profile_name);
		$_SESSION["success"] = "Trainer Profile Edited Successfully";
		setcookie("trainer_username", $Trainer_Username, time() + (86400 * 30), "/");
		setcookie("trainer_email", $Personal_Mail_id, time() + (86400 * 30), "/");

		header('location:./profile.php');
		exit();
	} else {
		$_SESSION["error"] = "Something went wrong";
		header('location:updatetrainerprofile.php?id=' . $id);
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
	<title>Update Profile</title>
	<?php include('./style.php') ?>


</head>

<body class="ltr main-body app sidebar-mini">



	<!-- Loader -->
	<!-- <div id="global-loader">
			<img src="https://triaright.com/Trainer/assets/img/preloader.svg" class="loader-img" alt="Loader">
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
		<form method="POST" enctype="multipart/form-data">

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
							<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY Account</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Profile</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card custom-card">
								<div class="card-body d-md-flex">
									<div class="">
										<span class="profile-image pos-relative">
											<?php if ($Fetching_trainer['pfp'] == null) { ?>
												<img class="br-5" alt="" src="./assets/icons/add-user.png">
											<?php } else { ?>
												<img class="br-5" alt="" src="../superadmin/assets/img/trainer/<?php echo $Fetching_trainer['pfp'] ?>">
											<?php } ?>

										</span>
									</div>
									<div class="my-md-auto mt-4 prof-details">
										<h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0"><span style="color:#ff6700"><?php echo $Fetching_trainer['username'] ?></h4>
										<!--<p class="tx-13 text-muted ms-md-4 ms-0 mb-2 pb-2 ">
										<span class="me-3"><i class="far fa-address-card me-2"></i>Gender
										</span>
										<span class="me-3"><i class="fa fa-taxi me-2"></i>DD/MM/YYYY</span>
										
									</p> -->
										<p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-phone me-2"></i></span><span class="font-weight-semibold me-2">Phone:</span><span><?php echo $Fetching_trainer['contact_number'] ?></span>
										</p>
										<p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-envelope me-2"></i></span><span class="font-weight-semibold me-2">Email:</span><span><?php echo $Fetching_trainer['email'] ?></span>
										</p>
										<p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="far fa-flag me-2"></i></span><span class="font-weight-semibold me-2">Designation:</span><span><?php echo $Fetching_trainer['designation'] ?></span>
										</p>

										&nbsp

									</div>
								</div>
								<!--<div class="card-footer py-0">
								<div class="profile-tab tab-menu-heading border-bottom-0">
									<nav class="nav main-nav-line p-0 tabs-menu profile-nav-line border-0 br-5 mb-0	">
										<a class="nav-link  mb-2 mt-2 active" data-bs-toggle="tab"
											href="#about">About</a>
										<a class="nav-link mb-2 mt-2" data-bs-toggle="tab" href="#edit">Edit Profile</a>
										<a class="nav-link  mb-2 mt-2" data-bs-toggle="tab"
											href="#timeline">Timeline</a>
										<a class="nav-link  mb-2 mt-2" data-bs-toggle="tab" href="#gallery">Gallery</a>
										<a class="nav-link  mb-2 mt-2" data-bs-toggle="tab" href="#friends">Friends</a>
										<a class="nav-link  mb-2 mt-2" data-bs-toggle="tab" href="#settings">Account
											Settings</a>
									</nav>
								</div> -->
							</div>
						</div>
					</div>
				</div>

				<!-- Row -->
				<div class="row row-sm">
					<div class="col-lg-12 col-md-12">
						<div class="custom-card main-content-body-profile">
							<div class="tab-content">
								<div class="main-content-body tab-pane  active" id="about">
									<div class="card">
										<div class="card-body border-0">
											<div class="mb-4 main-content-label">Trainer Information</div>
											<form class="form-horizontal" method="POST">
												<!--	<div class="mb-4 main-content-label">Name</div> -->
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Trainer Name</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Trainer Name" name="Trainer_Name" id="exampleInputName" value="<?php echo $Fetching_trainer['name'] ?>">


														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Trainer Username</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Trainer Username" name="Trainer_Username" id="exampleInputName" value="<?php echo $Fetching_trainer['username'] ?>">


														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Phone Number</label>
														</div>
														<div class="col-md-9">
															<input type="Number" class="form-control" placeholder="Enter Phone Number" name="Personal_Phone_Number" id="exampleInputName" min="0" placeholder="" value="<?php echo $Fetching_trainer['contact_number'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Email ID</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Enter Email" name="Personal_mail_id" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['email'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Date of birth</label>
														</div>
														<div class="col-md-9">
															<input type="date" class="form-control" id="dateMask" placeholder="DD/MM/YYYY" name="Date_Of_Birth" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['dob'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Aadhar Card No</label>
														</div>
														<div class="col-md-9">
															<input type="number" min="0" class="form-control" placeholder="Pincode" name="Aadhar_Card_No" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['aadhar_card_number'] ?>">
														</div>
													</div>
												</div>

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Aadhar Card Document</label>
														</div>
														<div class="col-md-9">
															<input type="file" name="aadhar_card_document" class="form-control">

														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label"> PAN Card No</label>
														</div>
														<div class="col-md-9">
															<input type="number" class="form-control" placeholder="Enter Pincode" min="0" name="Pan_Card_No" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['pan_card_number'] ?>">
														</div>
													</div>
												</div>

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">PAN Card Document</label>
														</div>
														<div class="col-md-9">
															<input type="file" name="pan_card_document" class="form-control">


														</div>
													</div>
												</div>
												<!--<div class="mb-4 main-content-label">Contact Info</div>-->

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Date of Joining</label>
														</div>
														<div class="col-md-9">
															<input type="date" class="form-control" id="dateMask" placeholder="DD/MM/YYYY" name="Date_Of_joining" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['date_of_joining'] ?>">
														</div>
													</div>
												</div>


												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Qualification</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Enter Qualification" name="Qualification" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['qualification'] ?>">
														</div>
													</div>
												</div>

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Designation</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Enter Designation" name="Designation" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['designation'] ?>">
														</div>
													</div>
												</div>

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Any Experience</label>
														</div>
														<div class="col-md-9">
															<select class="form-control form-select select2" required name="any_experience" id="exampleInputExperience" data-bs-placeholder="Enter Experience">
																<?php if (!empty($Any_Experience)) {
																?>
																	<option value="<?php echo $Any_Experience; ?>">Default:
																		<?php echo $Any_Experience; ?></option>
																<?php } ?>
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Previous organization name</label>
														</div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Enter Previous Organization Name" name="prev_current_organization_name" id="exampleInputName" placeholder="" value="<?php echo $Fetching_trainer['organization_name'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Trainer Document</label>
														</div>
														<div class="col-md-9">
															<input type="file" name="trainer_document" class="form-control">

														</div>
													</div>
												</div>


												<div class="form-group ">
													<div class="row row-sm">
														<div class="col-md-3">
															<label class="form-label">Upload Profile Picture</label>
														</div>
														<div class="col-md-9">
															<input type="file" class="form-control" name="upload_profile">
														</div>
													</div>
												</div>


												<button type="submit" name="updateBtn" class="btn btn-primary mt-3 mb-0" style="text-align:right">Update</button> &nbsp;

											</form>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

			</div>

		</form>



	</div>
	<!-- End Page -->

	<!-- BACK-TO-TOP -->
	<a href="updatetrainerprofile.php#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

	<?php include('./script.php') ?>

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