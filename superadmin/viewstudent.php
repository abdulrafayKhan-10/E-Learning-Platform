<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
	if (isset($_SESSION['previous_url'])) {
		header('location: ' . $_SESSION['previous_url']);
		exit();
	} else {
		$error = "Invalid Id";
		header("location:coursestudentallocation.php?error=" . $error . "");
		exit();
	}
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>View Student</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>
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
                <?php include("./partials/sidebar.php"); ?>
            </div>
            <!-- main-sidebar -->

        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> view Student</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Student</li>
                            <li class="breadcrumb-item active" aria-current="page">view</li>
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
								$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
								$id = (int) $id;

								$student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '{$id}'");

								if (mysqli_num_rows($student_query) > 0) {
									$std = mysqli_fetch_assoc($student_query);

								?>
                                <div class="">
                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName">Student Name</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="student_name" value="<?php echo $std['name']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $std['id']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputCompanyPhone"> Gender</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="gender" value="<?php echo $std['gender']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Birth</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="date_of_birth" value="<?php echo $std['dob']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPersonalPhone"> Phone Number</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="phone_number" value="<?php echo $std['contact_number']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPersonalPhone"> Alternative Phone Number</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="alternative_phone_number"
                                                    value="<?php echo $std['alternate_contact_number']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Mail Id</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="mail_id" value="<?php echo $std['email']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">address</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="address" value="<?php echo $std['address']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">District</label>
                                                <input type="text" class="form-control" name="district"
                                                    id="exampleInputPerEmail" value="<?php echo $std['district']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">State</label>
                                                <input type="text" class="form-control" name="state"
                                                    id="exampleInputPerEmail" value="<?php echo $std['state']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">PIN code</label>
                                                <input type="number" class="form-control" name="pincode"
                                                    id="exampleInputPerEmail" value="<?php echo $std['pin_code']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Qualification</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="qualification" value="<?php echo $std['qualification']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Semester</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="semester" value="<?php echo $std['semester']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Branch/Stream</label>
                                                <input type="text" class="form-control " name="stream"
                                                    id="exampleInputPerEmail" value="<?php echo $std['branch']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Account type</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="account_type" value="<?php echo $std['account_type']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Institution Name</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="institution_name" value="<?php echo $std['college_name']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Student Username</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="student_username" value="<?php echo $std['username']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Password</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="password" value="<?php echo $std['password']; ?>">
                                            </div>
                                        </div>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">ID no</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    value="STU_<?php echo $std['id']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Date of Account Creation</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    name="created_date" value="<?php echo $std['creation_date']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Account Created By</label>
                                                <input readonly type="text" class="form-control" id="exampleInputName"
                                                    value="<?php echo $std['created_by']; ?>">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Student CV</label><br>
                                                <a target="_blank" style="text-align:right"
                                                    href="./assets/docs/student/cv/<?php echo $std['cv']; ?>"
                                                    class="btn btn-primary mt-3 mb-0" download="">
                                                    Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php }
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container closed -->
        </div>
    </div>
    <?php include("./scripts.php") ?>
</body>

</html>