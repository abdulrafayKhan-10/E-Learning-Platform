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
    <title>Placements</title>
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


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Placements</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Placements</a></li>

                            <li class="breadcrumb-item ">Streams</li>
                        </ol>
                    </div>

                </div>


                <br>
                <br>
                <!-- row closed -->

                <!-- row opened -->
                <div class="text-wrap">
                    <div class="example">
                        <div class="row row-sm">
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM `placement`");
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query)) {


                            ?>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="card text-center card-img-top-1">
                                    <img class="card-img-top w-100"
                                        src="../superadmin/assets/img/placement/<?php echo $row['main_image'] ?>"
                                        alt="welcome" width="300" height="300">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3"><span
                                                style="color:#ff6700; Font-size:18px"><?php echo $row['job_role'] ?></span>
                                        </h4>
                                        <div class="user-wideget-footer">
                                            <div class="row">
                                                <div class="col-sm-4 border-end">
                                                    <div class="description-block">


                                                        <h5 class="description-header">
                                                            <?php echo $row['years_open_experience'] ?>
                                                        </h5>
                                                        <p class="card-text"><span
                                                                style="color:#999999; Font-size:11px">Experience
                                                                Required</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 border-end">
                                                    <div class="description-block">
                                                        <h5 class="description-header"><?php echo $row['salary'] ?></h5>

                                                        <p class="card-text"><span
                                                                style="color:#999999; Font-size:11px">Salary</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="description-block">
                                                        <h5 class="description-header"><?php echo $row['vacancies'] ?>
                                                        </h5>
                                                        <p class="card-text"><span
                                                                style="color:#999999; Font-size:11px">Vacancy</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="btn btn-primary btn-block"
                                            href="placementdetails.php?id=<?php echo $row['id'] ?>">Check now</a>
                                    </div>
                                </div>
                            </div>
                            <?php  }
                            } ?>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->



    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./script.php"); ?>
</body>

</html>