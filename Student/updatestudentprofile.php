<?php
session_start();
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
    exit();
}
include('../db_connection/connection.php');
$id = $_COOKIE["student_id"];
$select_query = "SELECT * FROM `student` WHERE `id` = $id";
$run_query = mysqli_query($conn, $select_query);
$data = mysqli_fetch_array($run_query);

if (isset($_POST['updatebtn'])) {
    $names = $_POST['student_name'];
    $usernames = $_POST['student_user_name'];
    $genders = $_POST['gender'];
    $dobs  = $_POST['date_of_birth'];
    $phones  = $_POST['phone_number'];
    $alt_phones  = $_POST['alternative_phone_number'];
    $mails  = $_POST['mail_id'];
    $addresses = $_POST['address'];
    $districts = $_POST['district'];
    $states = $_POST['state'];
    $pincodes  = $_POST['pincode'];
    $qualifications = $_POST['qualification'];
    $sems = $_POST['semester'];
    $branchs = $_POST['branch'];
    $types = $_POST['account_type'];
    $insts = $_POST['institution_name'];

    $user_profile = $_FILES['upload_profile']['name'] . date('Y-m-d-H-s');
    $profile_tmp = $_FILES['upload_profile']['tmp_name'];
    $img_path = './assets/img/profile/' . $user_profile;
    move_uploaded_file($profile_tmp, $img_path);


    $user_cv = $_FILES['upload_cv']['name'] . date('Y-m-d-H-s');
    $cv_tmp = $_FILES['upload_cv']['tmp_name'];
    $cv_path = '../superadmin/assets/docs/student/cv/' . $user_cv;
    move_uploaded_file($cv_tmp, $cv_path);

    $update_query = "UPDATE `student` SET `name`='$names',`contact_number`='$phones',`email`='$mails',`username`='$usernames',`picture`='$user_profile',`gender`='$genders',`address`='$addresses',`alternate_contact_number`='$alt_phones',`state`='$states',`district`='$districts',`dob`='$dobs',`pin_code`='$pincodes',`qualification`='$qualifications',`branch`='$branchs',`semester`='$sems',`account_type`='$types',`college_name`='$insts',`cv`='$user_cv' WHERE `id` = $id";


    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        $_SESSION["success"] = "Profile Updated Successfully";
        header("location: profile.php");
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again.";
        header("location: profile.php");
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
    <title>Update Profile</title>
    <?php include("./links.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Loader -->

    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div>
            <?php include("./partials/sidebar.php"); ?>
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->

                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY Accounts</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
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
                                            <?php
                                            if ($data['picture'] == "") {
                                                echo "<img class='br-5' src='assets/img/profile/user.png'>";
                                            } else { ?>

                                                <img class='br-5' alt='' src='assets/img/profile/<?php echo $data['picture']; ?>'>

                                            <?php }

                                            ?>


                                        </span>
                                    </div>
                                    <div class="my-md-auto mt-4 prof-details">
                                        <h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0"> <span style="color:#ff6700"></h4>
                                        <!--<p class="tx-13 text-muted ms-md-4 ms-0 mb-2 pb-2 ">
										<span class="me-3"><i class="far fa-address-card me-2"></i>Gender
										</span>
										<span class="me-3"><i class="fa fa-taxi me-2"></i>DD/MM/YYYY</span>
										
									</p> -->
                                        <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-phone me-2"></i></span><span class="font-weight-semibold me-2">Phone:
                                                <?php echo $data['contact_number']; ?></span></span>
                                        </p>
                                        <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-envelope me-2"></i></span><span class="font-weight-semibold me-2">Email:
                                                <?php echo $data['email']; ?></span></span>
                                        </p>
                                        <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="far fa-flag me-2"></i></span><span class="font-weight-semibold me-2">Address:
                                                <?php echo $data['address']; ?></span></span>
                                        </p>

                                        &nbsp
                                        <button class="btn btn-primary mb-3 shadow"><a href="../superadmin/assets/docs/student/cv/<?php echo $data['cv']; ?>" target="_blank" Download><span style="color:#ffffff;">CV
                                                    Download</span></a></button>

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
                <form method="POST" enctype="multipart/form-data">

                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="custom-card main-content-body-profile">
                                <div class="tab-content">
                                    <div class="main-content-body tab-pane  active" id="about">
                                        <div class="card">
                                            <div class="card-body border-0">
                                                <div class="mb-4 main-content-label">Student Information</div>
                                                <form class="form-horizontal">
                                                    <!--	<div class="mb-4 main-content-label">Name</div> -->
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Student Name</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="Student Name" name="student_name" value="<?php echo $data['name']; ?>" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Username</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="Student Username" name="student_user_name" value="<?php echo $data['username']; ?>" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Gender</label>
                                                            </div>
                                                            <div class="col-md-9">

                                                                <select name="gender" required class="form-control" data-bs-placeholder="<?php echo $data['gender']; ?>">

                                                                    <option value="male">Male
                                                                    </option>
                                                                    <option value="female">Female</option>
                                                                    <option value="others">others</option>
                                                                    <option value="ratherNotSay">Rather Not Say</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Date of Birth</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control" placeholder="DD/MM/YYYY" name="date_of_birth" value="<?php echo $data['dob']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Phone Number</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="Number" class="form-control" placeholder="10 Digit Number" name="phone_number" value="<?php echo $data['contact_number']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Alternative Phone
                                                                    Number</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" placeholder="10 Digit Number" name="alternative_phone_number" value="<?php echo $data['alternate_contact_number']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="mb-4 main-content-label">Contact Info</div>-->
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Email ID</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="mail" class="form-control" placeholder="Email" name="mail_id" value="<?php echo $data['email']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Address</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="address" value="<?php echo $data['address']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">District</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="District" name="district" value="<?php echo $data['district']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">State</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="State" name="state" value="<?php echo $data['state']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Pincode</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" placeholder="Pincode" name="pincode" value="<?php echo $data['pin_code']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Qualification</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="qualification" required class="form-control" data-bs-placeholder="<?php echo $data['qualification']; ?>" required>

                                                                    <option value="10th" selected="selected">10th
                                                                    </option>
                                                                    <option value="+12">+12</option>
                                                                    <option value="polythecnic">Polytechnic</option>
                                                                    <option value="degree">Degree</option>
                                                                    <option value="btech">B.Tech</option>
                                                                    <option value="pg">Post Graduation</option>
                                                                    <option value="phd">Ph.d</option>
                                                                    <option value="Not Required">none</option>



                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Semester</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="semester" required class="form-control" required data-bs-placeholder="<?php echo $data['semester']; ?>">

                                                                    <option value="1stsem">1st sem</option>
                                                                    <option value="2ndsem">2nd sem</option>
                                                                    <option value="3rdsem">3rd sem</option>
                                                                    <option value="4thsem">4th sem</option>
                                                                    <option value="5thsem">5th sem</option>
                                                                    <option value="6thsem">
                                                                        6th sem</option>
                                                                    <option value="7thsem">7th sem</option>
                                                                    <option value="8thsem">8th sem</option>
                                                                    <option value="Not Required"> Not Required
                                                                    </option>


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Branch/Stream</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="Branch/Stream" name="branch" value="<?php echo $data['branch']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--	<div class="mb-4 main-content-label">Social Info</div> -->
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Account
                                                                    Type</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="account_type" required class="form-control" data-bs-placeholder="<?php echo $data['account_type']; ?>" required>

                                                                    <option value="college">college</option>
                                                                    <option value="individual">
                                                                        individual
                                                                    </option>




                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Institutions</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="Institutions" name="institution_name" value="<?php echo $data['college_name']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group ">
                                                            <div class="row row-sm">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Referral
                                                                        Code</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input readonly type="text" class="form-control"
                                                                        placeholder="Referral Code"
                                                                        value="TRIARIGHT_134">
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Upload
                                                                    Resume</label>
                                                            </div>
                                                            <div class="col-md-9">

                                                                <input type="file" class="form-control" name="upload_cv" value="<?php echo $data['cv']; ?>" required>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Upload Profile
                                                                    Picture</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="file" class="form-control" name="upload_profile" value="<?php echo $data['picture']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <button class="btn btn-primary mb-3 shadow"><a href="" data-bs-target="#apply" data-bs-toggle="modal"><span style="color:#ffffff;">Update profile</span></a></button>  -->


                                                    <input type="submit" class="btn btn-success mt-3 mb-0" style="text-align:right" value="Update" name="updatebtn" />
                                                    &nbsp
                                                    &nbsp


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>



        </div>
        <!-- End Page -->

        <!-- BACK-TO-TOP -->
        <a href="updatestudentprofile.php@id=769.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

        <?php include("./scripts.php") ?>

</body>

<!-- Mirrored from laravel8.spruko.com/nowa/profile by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:31:32 GMT -->

</html>