<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

if (!isset($_GET["id"]) && empty($_GET["id"])) {
    header("location:./mystudents.php");
    exit();
}

$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Student Profile</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

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
            <?php
            $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '$id'");

            if (mysqli_num_rows($student_query) > 0) {
                $student = mysqli_fetch_assoc($student_query);

            ?>

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Student Profile</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Student</a></li>
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
                                        <?php
                                            if (!empty($student['picture'])) {
                                                $student['picture'] = "default.png";

                                            ?>
                                        <img class="br-5" alt="<?php echo $student['name']; ?> - Profile Picture"
                                            src="../superadmin/assets/img/student/<?php echo $student['picture']; ?>">
                                        <?php
                                            } else {

                                            ?>
                                        <img class="br-5" alt="<?php echo $student['name']; ?> - Profile Picture"
                                            src="./assets/img/r1.jpg">
                                        <?php
                                            } ?>
                                    </span>
                                </div>
                                <div class="my-md-auto mt-4 prof-details">
                                    <h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0">
                                        Username:<span><?php echo $student['username']; ?></span></h4>

                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="fa fa-phone me-2"></i></span><span
                                            class="font-weight-semibold me-2">Phone:</span><span>+91
                                            <?php echo $student['contact_number']; ?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="fa fa-envelope me-2"></i></span><span
                                            class="font-weight-semibold me-2">Email:</span><span><?php echo $student['email']; ?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="far fa-flag me-2"></i></span><span
                                            class="font-weight-semibold me-2">Address:</span><span>
                                            <?php echo $student['address']; ?></span>
                                    </p>

                                    &nbsp


                                    <a style="text-align:right" class="btn btn-primary mt-3 mb-0"
                                        href="../superadmin/assets/docs/student/cv/<?php echo $student['cv']; ?>"
                                        download="">
                                        Download CV</a>


                                </div>
                            </div>

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
                                        <div class="mb-4 main-content-label">Student Information</div>
                                        <form class="form-horizontal">
                                            <!--	<div class="mb-4 main-content-label">Name</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Student Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Student Name"
                                                            value="<?php echo $student['name']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Gender</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="gender"
                                                            value="<?php echo $student['gender']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of birth</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" class="form-control" id="dateMask"
                                                            placeholder="date_of_birth"
                                                            value="<?php echo $student['dob']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Phone Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="Number" class="form-control"
                                                            placeholder="phone_number"
                                                            value="<?php echo $student['contact_number']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Alternative Phone Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control"
                                                            placeholder="alternative_phone_number"
                                                            value="<?php echo $student['alternate_contact_number']; ?>"
                                                            disabled>
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
                                                        <input type="text" class="form-control" placeholder="mail_id"
                                                            value="<?php echo $student['email']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="address"
                                                            value="<?php echo $student['address']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">District</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="district"
                                                            value="<?php echo $student['district']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">State</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="state"
                                                            value="<?php echo $student['state']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Pincode</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control" placeholder="pincode"
                                                            value="<?php echo $student['pin_code']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Qualification</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="qualification"
                                                            value="<?php echo $student['qualification']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Semester</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="semester"
                                                            value="<?php echo $student['semester']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Branch/Stream</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="stream"
                                                            value="<?php echo $student['branch']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--	<div class="mb-4 main-content-label">Social Info</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Account Type</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="account_type"
                                                            value="<?php echo $student['account_type']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Institutions</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Institutions" placeholder="institution_name"
                                                            value="<?php echo $student['college_name']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="studentprofile.php@id=5020.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./script.php") ?>
</body>

</html>