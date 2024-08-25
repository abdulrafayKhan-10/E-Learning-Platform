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
    <title>View Placement</title>
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
            <!-- main-sidebar -->

        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">View Courses</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item " aria-current="page">View</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->


                <!-- /row -->

                <!-- row -->

                <div class="row row-sm">

                </div>
            </div>

        </div>
    </div>

    <!-- BACK-TO-TOP -->
    <a href="viewplacements2.php@course=Information&#32;Technology.html#top" id="back-to-top"><i
            class="las la-arrow-up"></i></a>
    <?php include("./script.php"); ?>
</body>

</html>