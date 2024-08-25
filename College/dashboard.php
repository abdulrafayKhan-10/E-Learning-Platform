<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php") ?>
            </div>
            <!-- /main-header -->


            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>


        </div>
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
                                                    style="color:#ff6700"></span>, <span
                                                    class="text-primary"><?php
                                                                                                                                                                    if (isset($_COOKIE['college_username'])) {
                                                                                                                                                                        echo $_COOKIE['college_username'];
                                                                                                                                                                    }
                                                                                                                                                                    ?></span>
                                            </h2>
                                            <p class="text-dark tx-15 mb-2 lh-3">Thankyou for choosing us, We are
                                                delighted that you have joined us and we look forward to providing
                                                candidates with a wealth of resources and information that will help
                                                candidates succeed in their academic journey.</p>
                                            <p class="font-weight-semibold tx-12 mb-4" style="color:#ff6700">For any
                                                queries, contact us through support chat or mail us at
                                                info@demo.com </p>

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
                                <!--<p class="tx-12 tx-gray-500 mb-3">On the other hand, we denounce with right indignation and dislike imagesralized <a href="#">Learn more</a></p> -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-12">Courses</label>
                                        <p cla ss="font-weight-bold tx-20">
                                            <?php
                                            $course_query = mysqli_query($conn, "SELECT * FROM `course`");
                                            echo mysqli_num_rows($course_query);
                                            ?>
                                        </p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-12">Internships</label>
                                        <p class="font-weight-bold tx-20">
                                            <?php
                                            $internship_query = mysqli_query($conn, "SELECT * FROM `internship`");
                                            echo mysqli_num_rows($internship_query);
                                            ?>
                                        </p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-12">Placements</label>
                                        <p class="font-weight-bold tx-20">
                                            <?php
                                            $placement_query = mysqli_query($conn, "SELECT * FROM `placement`");
                                            echo mysqli_num_rows($placement_query);
                                            ?>
                                        </p>
                                    </div><!-- col -->

                                </div><!-- row -->

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-12">Registered Students</label>
                                        <p class="font-weight-bold tx-20">
                                            <?php
                                            $student_query = mysqli_query($conn, "SELECT * FROM `student`");
                                            echo mysqli_num_rows($student_query);

                                            ?>
                                        </p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-12">Colleges</label>
                                        <p class="font-weight-bold tx-20">
                                            <?php
                                            $college_query = mysqli_query($conn, "SELECT * FROM `college`");
                                            echo mysqli_num_rows($college_query);
                                            ?>
                                        </p>
                                    </div><!-- col -->
                                    <div class="col border-start text-center">
                                        <label class="tx-12">Trainers</label>
                                        <p class="font-weight-bold tx-20">
                                            <?php
                                            $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer`");
                                            echo mysqli_num_rows($trainer_query);
                                            ?>
                                        </p>
                                    </div><!-- col -->

                                </div><!-- row -->
                                <br>

                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
                </div>
                <div class="row row-sm">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card text-center card-img-top-1">
                            <img class="card-img-top w-100" src="assets/img/1.png" alt="">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Courses</h4>
                                <p class="card-text">These are the currently available courses. Learn more about our
                                    courses.</p>
                                <a class="btn btn-primary btn-Block" href="./registercourse.php">View Courses</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card text-center card-img-top-1">
                            <img class="card-img-top w-100" src="assets/img/1.png" alt="">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Internships</h4>
                                <p class="card-text">Are you willing to participate in internships? Then join us. </p>
                                <a class="btn btn-primary btn-Block" href="./internships.php">View Internships</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card text-center card-img-top-1">
                            <img class="card-img-top w-100" src="assets/img/1.png" alt="">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Placements</h4>
                                <p class="card-text">Are you interested in getting placed? Then check out your desired
                                    placement. </p>
                                <a class="btn btn-primary btn-Block" href="./placements.php">View Placements</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End Page -->

            <!-- BACK-TO-TOP -->
            <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
            <?php include("./script.php"); ?>

</body>

</html>