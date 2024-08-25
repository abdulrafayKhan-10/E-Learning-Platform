<?php
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
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
    <title>Dashboard</title>

    <?php
	include('./style.php');
	?>

</head>

<body class="ltr main-body app sidebar-mini">
    <?php
	include('./switcher.php');
	?>

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
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Dashboard</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>

                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
                <div class="row">
                    <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card"><img class="img-fluid" src="assets/img/reg.gif" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h2 class="text-dark font-weight-semibold mb-3 mt-2">Hi <span
                                                    style="color:#ff6700"><?php
																																if (isset($_COOKIE['trainer_username'])) {
																																	$username = $_COOKIE['trainer_username'];
																																	$select_trainername = mysqli_query($conn, "SELECT * FROM `trainer` WHERE username = '$username' ");
																																	$fetch_trainername = mysqli_fetch_assoc($select_trainername);
																																	echo $fetch_trainername['name'];
																																}
																																?></span>, Welcome to <span class="text-primary">Invictus Solutions</span></h2>
                                            <p class="text-dark tx-15 mb-2 lh-3">Thankyou for choosing us, We are
                                                delighted that you have joined us and we look forward you provide a
                                                wealth of resources and information that will help candidates to succeed
                                                in their academic journey.</p>
                                            <p class="font-weight-semibold tx-12 mb-4" style="color:#ff6700">For any
                                                queries, contact us through support chat or mail us at
                                                info@invictussolutions.com </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-lg-5">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Our Progress</div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-14">Courses<br> Assigned</label>
                                        <p class="font-weight-bold tx-20">18</p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-14">Batches <br>allocated</label>
                                        <p class="font-weight-bold tx-20">1</p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-14">Total<br> Students</label>
                                        <p class="font-weight-bold tx-20">0</p>
                                    </div><!-- col -->

                                </div><!-- row -->

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-14">Batch-1</label>
                                        <p class="font-weight-bold tx-20">5049</p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-14">batch-2</label>
                                        <p class="font-weight-bold tx-20">55</p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-14">batch-3</label>
                                        <p class="font-weight-bold tx-20">43</p>
                                    </div><!-- col -->

                                </div><!-- row -->
                                <br>

                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xl-12">

                        <div class="row">
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="createschedule.php">
                                            <img src="assets/img/schedule.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Schedule</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="createmeetings.php">
                                            <img src="assets/img/meetings.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Meetings</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="createsummary.php">
                                            <img src="assets/img/summary.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Summary</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="addtask.php">
                                            <img src="assets/img/task.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Tasks</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="createrecordings.php">
                                            <img src="assets/img/recordings.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Recordings</h6>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card p-0 ">

                                    <div class="card-body pt-0 text-center">

                                        <a class="file-manger-icon" href="uploaddocumentation.php">
                                            <img src="assets/img/files/file.png" alt="img" class="br-7" />
                                        </a>
                                        <h6 class="mb-1 font-weight-semibold">Documents</h6>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php
	include('./script.php');
	?>
</body>

</php>