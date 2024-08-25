<?php
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}
$username = $_COOKIE['trainer_username'];
$email = $_COOKIE['trainer_email'];
$select_trainer = mysqli_query($conn, "SELECT * FROM `trainer` WHERE (username = '$username') && (email = '$email')");
$Fetching_trainer = mysqli_fetch_assoc($select_trainer);
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>My Profile</title>

    <?php
    include('./style.php');
    ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <?php
    include('./switcher.php');
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

        </div> <!-- main-content -->
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
                                    <h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0"><span style="color:#ff6700">
                                            <?php echo $Fetching_trainer['username'] ?>
                                    </h4>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-phone me-2"></i></span><span class="font-weight-semibold me-2">Phone:</span><span><?php echo $Fetching_trainer['contact_number'] ?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-envelope me-2"></i></span><span class="font-weight-semibold me-2">Email:</span><span><?php echo $Fetching_trainer['email'] ?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="far fa-flag me-2"></i></span><span class="font-weight-semibold me-2">Designation:</span><span><?php echo $Fetching_trainer['designation'] ?></span>
                                    </p>

                                    &nbsp;

                                </div>
                            </div>
                            <!-- <div class="card-footer py-0">
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
                                        <form class="form-horizontal">
                                            <!--	<div class="mb-4 main-content-label">Name</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Trainer Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" class="form-control" placeholder="Trainer Name" name="Trainer_Name" id="exampleInputName" value="<?php echo $Fetching_trainer['name'] ?>">
                                                        <input type="hidden" name="id" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Phone Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="Number" class="form-control" placeholder="10 Digit Number" name="Personal_Phone_Number" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['contact_number'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Email ID</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" class="form-control" placeholder="Email" name="Personal_mail_id" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['email'] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of birth</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="date" class="form-control" id="dateMask" name="Date_Of_Birth" value="<?php echo $Fetching_trainer['dob']; ?>" id="exampleInputName">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Aadhar Card No</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="number" class="form-control" name="Aadhar_Card_No" id="exampleInputName" disabled value="<?php echo $Fetching_trainer['aadhar_card_number'] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Aadhar Card Document</label>
                                                    </div>
                                                    <a href="../superadmin/assets/img/trainer/<?php echo $Fetching_trainer['aadhar_card_picture']; ?>" download="" class="btn btn-primary mt-1 mx-2 mb-0" style="text-align:right">Download</a>

                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label"> PAN Card No</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="number" class="form-control" placeholder="Pincode" name="Pan_Card_No" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['pan_card_number']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">PAN Card Document</label>
                                                    </div>
                                                    <a target="_blank" class="btn btn-primary mt-1 mb-0 mx-2" style="text-align:right" href="../superadmin/assets/img/trainer/<?php echo $Fetching_trainer['pan_card_picture']; ?>" download="">Download</a>

                                                </div>
                                            </div>
                                            <!--<div class="mb-4 main-content-label">Contact Info</div>-->

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of Joining</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="date" class="form-control" id="dateMask" placeholder="DD/MM/YYYY" name="Date_Of_joining" id="exampleInputName" disabled value="<?php echo $Fetching_trainer['date_of_joining']; ?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Qualification</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" class="form-control" placeholder="Qualification" name="Qualification" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['qualification']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">designation</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" class="form-control" placeholder="Designation" name="Designation" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['designation']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Any Experience</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="Text" class="form-control" name="any_experience" id="exampleInputName" disabled value="<?php echo $Fetching_trainer['experience']; ?>" placeholder="Expereince">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Previous organisation name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" class="form-control" placeholder="Organization" name="prev_current_organization_name" id="exampleInputName" disabled placeholder="" value="<?php echo $Fetching_trainer['organization_name']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Trainer Document</label>
                                                    </div>
                                                    <a class="btn btn-primary mt-1 mx-2 mb-0" style="text-align:right" target="_blank" href="../superadmin/assets/img/trainer/<?php echo $Fetching_trainer['trainer_document']; ?>" download="">Download</a>

                                                </div>
                                            </div>



                                        </form>
                                        <a class="btn btn-primary" href="updatetrainerprofile.php?id=<?php echo $Fetching_trainer['id'] ?>">update
                                            profile</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Page -->

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