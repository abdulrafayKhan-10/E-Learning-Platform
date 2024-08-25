<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}
$college_id = $_GET['id'];
$select_college = mysqli_query($conn, "SELECT * FROM `college` WHERE `id` = '$college_id'");
$fetch_college = mysqli_fetch_array($select_college);
if (isset($_POST["create"])) {

	// Function to sanitize and validate input
	function sanitizeInput($input)
	{
		return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
	}

	// Sanitize and validate each input
	$college_name = sanitizeInput($_POST["college_name"]);
	$college_code = sanitizeInput($_POST["college_code"]);
	$address = sanitizeInput($_POST["address"]);
	$district = sanitizeInput($_POST["district"]);
	$state = sanitizeInput($_POST["state"]);
	$pin_code = sanitizeInput($_POST["pin_code"]);
	$college_phone_number = sanitizeInput($_POST["college_phone_number"]);
	$college_mail_id = sanitizeInput($_POST["college_mail_id"]);
	$college_representative_name = sanitizeInput($_POST["college_representative_name"]);
	$college_representative_contact_no = sanitizeInput($_POST["college_representative_contact_no"]);
	$college_representative_mail_id = sanitizeInput($_POST["college_representative_mail_id"]);
	$college_stream = sanitizeInput($_POST["college_stream"]);
	$affiliated_university = sanitizeInput($_POST["affiliated_university"]);
	$college_website = sanitizeInput($_POST["college_website"]);
	$college_username = sanitizeInput($_POST["college_username"]);
	$password = sanitizeInput($_POST["password"]);
	$created_by = "user";
	// Hash the password
	$hash_pass = password_hash($password, PASSWORD_DEFAULT);


	$query = mysqli_prepare($conn, "INSERT INTO `college`(`name`, `username`, `password`, `email`, `contact_number`,  `address`, `district`, `state`, `pin_code`, `representative_name`, `representative_contact_number`, `representative_email`, `college_streams`, `affiliated_university`, `website`, `college_code`, `created_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

	$query = mysqli_prepare($conn, "UPDATE `college` SET `name`=?,`username`=?,`password`=?,`email`=?,`contact_number`=?,`address`=?,`district`=?,`state`=?,`pin_code`=?,`representative_name`=?,`representative_contact_number`=?,`representative_email`=?,`college_streams`=?,`affiliated_university`=?,`website`=?,`college_code`=?,`created_by`=? WHERE id = '$college_id'");

	$query->bind_param("sssssssssssssssss", $college_name, $college_username, $hash_pass, $college_mail_id, $college_phone_number, $address, $district, $state, $pin_code, $college_representative_name, $college_representative_contact_no, $college_representative_mail_id, $college_stream, $affiliated_university, $college_website, $college_code, $created_by);

	if ($query->execute()) {
		$_SESSION["success"] = "College Updated successfully";
		header('location: collegesignup.php');
		exit();
	} else {
		$_SESSION["error"] = "Error Update college";
		echo "Error: " . $query->error;
	}
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
	<title>College Update</title>
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

				<?php include('./partials/navbar.php'); ?>

			</div>
			<!-- /main-header -->

			<!-- main-sidebar -->
			<div class="sticky">
				<?php include('./partials/sidebar.php') ?>
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
							<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
								College</span>
						</div>
						<?php if (isset($_SESSION["error"])) { ?>
							<div class="alert alert-danger" role="alert">
								<?php echo "Error while creating. Error: '" . $_SESSION["error"] . "'"; ?>
							</div>
						<?php unset($_SESSION["error"]);
							session_destroy();
						} ?>
						<?php if (isset($_SESSION["success"])) { ?>
							<div class="alert alert-success" role="alert">
								<?php echo "Successfully Updated."; ?>
							</div>
						<?php unset($_SESSION["success"]);
							session_destroy();
						} ?>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Credentials</a></li>
								<li class="breadcrumb-item active" aria-current="page">College</li>
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
									<div class="row row-xs formgroup-wrapper">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputName">College Name <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['name']?>" class="form-control" id="exampleInputName" name="college_name" placeholder="Enter College Name" >
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputName">College Code <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['college_code']?>" class="form-control" id="exampleInputName" name="college_code" placeholder="Enter College Code" >
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">Address <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['address']?>" class="form-control " id="exampleInputPerEmail" name="address" rows="5" placeholder="Enter address" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">District <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['district']?>" class="form-control" id="exampleInputPerEmail" name="district" placeholder="Enter District" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">State <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['state']?>" class="form-control" id="exampleInputPerEmail" name="state" placeholder="Enter State" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">PIN code <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="number" class="form-control" id="exampleInputPerEmail" value="<?php echo $fetch_college['pin_code']?>" name="pin_code" placeholder="enter Pincode" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPersonalPhone">College Phone Number<span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="number" value="<?php echo $fetch_college['contact_number']?>" class="form-control" id="exampleInputPersonalPhone" name="college_phone_number" placeholder="Enter Contact Number" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">College Mail Id <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="email" value="<?php echo $fetch_college['email']?>" class="form-control" id="exampleInputPerEmail" name="college_mail_id" placeholder="Enter Mail Id" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputCompanyPhone">College Represntative Name
													<span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="Text" value="<?php echo $fetch_college['representative_name']?>" class="form-control" id="exampleInputCompanyPhone" name="college_representative_name" placeholder="Enter Representative Name" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPersonalPhone">College Representative Contact
													No<span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="number" value="<?php echo $fetch_college['representative_contact_number']?>" class="form-control" id="exampleInputPersonalPhone" name="college_representative_contact_no"  placeholder="Enter Represntative Number">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPerEmail">College Represntative Mail Id
													<span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="email" class="form-control" id="exampleInputPerEmail" name="college_representative_mail_id" placeholder="Enter Represntative Mail Id" value="<?php echo $fetch_college['representative_email']?>" >
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputQualification">College Streams seperate
													your streams by comma(,) <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['college_streams']?>" class="form-control" id="exampleInputQualification" name="college_stream" placeholder="B.SC,B.COM" >
											</div>

										</div>


										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputQualification">Affliated Univeristy <span style="color:#D3D3D3;font-size: 90%;"> (Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['affiliated_university']?>" class="form-control" id="exampleInputQualification" name="affiliated_university" placeholder="Enter University Board" >
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputQualification">College Website<span style="color:#D3D3D3;font-size: 90%;">
														(Optional)</span></label>
												<input type="text" value="<?php echo $fetch_college['website']?>" class="form-control" id="exampleInputQualification" name="college_website" placeholder="Enter Website">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputUserName">College Username <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['username']?>" class="form-control" id="exampleInputUserName" name="college_username" placeholder="Enter Username" >
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleInputPassword">Password <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
													<span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
												<input type="text" value="<?php echo $fetch_college['password']?>" class="form-control" id="password" name="password" placeholder="Enter Password" minlength=8 maxlenght=10 >
											</div>
										</div>


										<button type="submit" name="create" value="create" class="btn btn-primary mt-3 mb-0" style="text-align:right" onclick="return check()">Update</button>
									</div>

								</div>  
							</div>
						</div>
					</div>



				</div>
				<!-- Container closed -->
			</div>


		</form>

		<script type="text/javascript">
			function check() {
				var b = document.getElementById('password').value;
				var c = document.getElementById('retypepassword').value;
				if (b != c) {
					alert('Password doesnt match');
					return false;
				} else
					return true;
			}
		</script>

	</div>
	<!-- End Page -->

	<?php include("./scripts.php"); ?>

</body>

</html>