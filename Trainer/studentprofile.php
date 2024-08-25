<?php 
include('../db_connection/connection.php');		
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
if(!isset($_GET['id'])) {
    header('location: mystudents.php');
    exit();
}else{
$id = $_GET['id'];
$select_student = mysqli_query($conn,"SELECT * FROM `student` WHERE id = '$id'");
$fetch_student = mysqli_fetch_assoc($select_student);
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
    <title> Student Profile </title>

    <?php include('./style.php');?>
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
                <?php include('./partials/navbar.php');?>
            </div>
            <!-- /main-header -->


            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php');?>

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
                                        if($fetch_student['picture'] == null){
                                        ?>
                                         <img class="br-5" alt=""
                                            src="./assets/icons/add-user.png">
                                            <?php 
                                        }else{?>
                                            <img class="br-5" alt=""
                                            src="../Student/assets/img/profile/<?php echo $fetch_student['picture']?>">
                                      <?php  }
                                        ?>
                                    </span>
                                </div>
                                <div class="my-md-auto mt-4 prof-details">
                                    <h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0" style="color:#ff6700">
                                        <?php echo $fetch_student['username']?></h4>
                                    <!--<p class="tx-13 text-muted ms-md-4 ms-0 mb-2 pb-2 ">
										<span class="me-3"><i class="far fa-address-card me-2"></i>Gender
										</span>
										<span class="me-3"><i class="fa fa-taxi me-2"></i>DD/MM/YYYY</span>
										
									</p> -->
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="fa fa-phone me-2"></i></span><span
                                            class="font-weight-semibold me-2">Phone:</span><span><?php echo $fetch_student['contact_number']?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="fa fa-envelope me-2"></i></span><span
                                            class="font-weight-semibold me-2">Email:</span><span><?php echo $fetch_student['email']?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i
                                                class="far fa-flag me-2"></i></span><span
                                            class="font-weight-semibold me-2">Address:</span><span><?php echo $fetch_student['address']?></span>
                                    </p>

                                    &nbsp


                                    <a target="_blank" download=""
                                        href="../superadmin/assets/docs/student/cv/<?php echo $fetch_student['cv']?>"
                                        class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</a>


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
                                                        <label class="form-label">student Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Student Name"
                                                            value="<?php echo $fetch_student['name']?>" disabled>
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
                                                            value="<?php echo $fetch_student['gender']?>" disabled>
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
                                                            value="<?php echo $fetch_student['dob']?>" disabled>
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
                                                            value="<?php echo $fetch_student['contact_number']?>"
                                                            disabled>
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
                                                            value="<?php echo $fetch_student['alternate_contact_number']?>"
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
                                                            value="<?php echo $fetch_student['email']?>" disabled>
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
                                                            value="<?php echo $fetch_student['address']?>" disabled>
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
                                                            value="<?php echo $fetch_student['district']?>" disabled>
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
                                                            value="<?php echo $fetch_student['state']?>" disabled>
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
                                                            value="<?php echo $fetch_student['pin_code']?>" disabled>
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
                                                            placeholder="qualification" value="<?php echo $fetch_student['qualification']?>" disabled>
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
                                                            value="<?php echo $fetch_student['semester']?>" disabled>
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
                                                            value="<?php echo $fetch_student['branch']?>" disabled>
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
                                                            placeholder="account_type" value="<?php echo $fetch_student['account_type']?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Institutions" placeholder="institution_name"
                                                            value="<?php echo $fetch_student['college_name']?>" disabled>
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

        </div>




    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="studentprofile.php@id=769.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include('./script.php');?>
</body>

<!-- Mirrored from laravel8.spruko.com/nowa/profile by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:31:32 GMT -->

</html>