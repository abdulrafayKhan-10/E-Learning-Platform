<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_GET["error"]) && !empty($_GET["error"])) {
    $error = htmlspecialchars($_GET["error"], ENT_QUOTES, 'UTF-8');
}

// Store the current URL in the session

?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>Dashboard</title>

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php
    if (isset($error)) {
        echo "<script>alert('" . $error . "');</script>";
    }
    ?>

    <?php include("./switcher.php") ?>
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
        <!-- main-content -->
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


                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Credentials - student</div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">

                                        <label class="tx-12">Sign up</label>
                                        <a href="candidatesignup.php" style="color:#1D71F2">
                                            <p class="font-weight-bold tx-24"><?php
                                                                                $sql = "SELECT * FROM `student` WHERE `created_by` = 'User'";
                                                                                $result = mysqli_query($conn, $sql);
                                                                                $fetch = mysqli_fetch_assoc($result);
                                                                                if ($fetch["created_by"] == "User") {
                                                                                    $count = mysqli_num_rows($result);
                                                                                    echo $count;
                                                                                }

                                                                                ?></p>
                                        </a>
                                    </div><!-- col -->

                                    <div class="col border-start text-center">
                                        <label class="tx-12">Total </label>
                                        <a href="studentlist.php" style="color:#4AA02C">
                                            <p class="font-weight-bold tx-24">
                                                <?php
                                                $sql = "SELECT * FROM `student`";
                                                $result = mysqli_query($conn, $sql);


                                                $count = mysqli_num_rows($result);
                                                echo $count;


                                                ?>
                                            </p>
                                        </a>
                                    </div><!-- col -->

                                </div><!-- row -->

                            </div>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Credentials - College</div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-12">Sign up</label>
                                        <a href="collegesignup.php" style="color:#1D71F2">
                                            <p class="font-weight-bold tx-24">
                                                <?php
                                                $sql = "SELECT * FROM `college` WHERE `created_by` = 'User'";
                                                $result = mysqli_query($conn, $sql);
                                                $fetch = mysqli_fetch_assoc($result);
                                                if ($fetch["created_by"] == "User") {
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                }
                                                ?>
                                            </p>
                                        </a>
                                    </div><!-- col -->

                                    <div class="col border-start text-center">
                                        <label class="tx-12">Total</label>
                                        <a href="collegelist.php" style="color:#4AA02C">
                                            <p class="font-weight-bold tx-24">
                                                <?php
                                                $sql = "SELECT * FROM `college`";
                                                $result = mysqli_query($conn, $sql);
                                                $count = mysqli_num_rows($result);
                                                echo $count;
                                                ?>
                                            </p>
                                        </a>
                                    </div><!-- col -->

                                </div><!-- row -->

                            </div>

                        </div>
                    </div>



                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Credentials - Trainer</div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <label class="tx-12">Sign up</label>
                                        <a href="trainersignup.php" style="color:#1D71F2">
                                            <p class="font-weight-bold tx-24">
                                                <?php
                                                $sql = "SELECT * FROM `trainer` WHERE `created_by` = 'user'";
                                                $result = mysqli_query($conn, $sql);
                                                $fetch = mysqli_fetch_assoc($result);
                                                if ($fetch["created_by"] == "user") {
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                }
                                                ?>
                                            </p>
                                        </a>
                                    </div><!-- col -->

                                    <div class="col border-start text-center">
                                        <label class="tx-12">Total</label>
                                        <a href="trainerlist.php" style="color:#4AA02C">
                                            <p class="font-weight-bold tx-24">
                                                <?php
                                                $sql = "SELECT * FROM `trainer`";
                                                $result = mysqli_query($conn, $sql);
                                                $count = mysqli_num_rows($result);
                                                echo $count;
                                                ?>
                                            </p>
                                        </a>
                                    </div><!-- col -->


                                </div><!-- row -->

                            </div>

                        </div>
                    </div>


                </div>

                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Courses</span>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-lg-12 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-header pb-1">
                                <div class="card-title mb-2">Listings</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group projects-list border-0">
                                    <a href="courselist.php" style="color:#1d71f2"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Registered</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `course`";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>

                                                </b></h4>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-header pb-1">
                                <div class="card-title mb-2">Registrations</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group projects-list border-0">
                                    <a href="courseregistrationslist.php" style="color:#1d71f2"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Applied</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b><?php
                                                                                                $sql = "SELECT * FROM `course_registration` ";
                                                                                                $result = mysqli_query($conn, $sql);
                                                                                                $count = mysqli_num_rows($result);
                                                                                                echo $count;
                                                                                                ?></b></h4>
                                        </div>
                                    </a>
                                    <a href="courseregistrationslist.php" style="color:#4AA02C"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Active</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b><?php
                                                                                                $sql = "SELECT * FROM `course_registration` WHERE `status` = 'Active'";
                                                                                                $result = mysqli_query($conn, $sql);
                                                                                                $count = mysqli_num_rows($result);
                                                                                                echo $count;
                                                                                                ?></b></h4>
                                        </div>
                                    </a>
                                    <a href="courseregistrationslist.php" style="color:#b9bf00"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Pending</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b><?php
                                                                                                $sql = "SELECT * FROM `course_registration` WHERE `status` = 'Pending'";
                                                                                                $result = mysqli_query($conn, $sql);
                                                                                                $count = mysqli_num_rows($result);
                                                                                                echo $count;
                                                                                                ?></b></h4>
                                        </div>
                                    </a>


                                    <a href="courseregistrationslist.php?type=delete" style="color:#ff0000"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Deleted</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `course_registration` WHERE `status` = 'Deleted'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-header pb-1">
                                <div class="card-title mb-2">Allocation</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group projects-list border-0">
                                    <a href="managecourseregistrations.php" style="color:#1d71f2"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Allocated</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `student_allocate`";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-header pb-1">
                                <div class="card-title mb-2">Student Batch</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group projects-list border-0">
                                    <a href="batchlist.php" style="color:#1d71f2"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Created</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `batch`";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>
                                    <a href="batchlist.php?type=active" style="color:#ff6700"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Active</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `batch` WHERE `status` = 'Active'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>
                                    <a href="batchlist.php?type=complete" style="color:#4AA02C"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold ">Completed</p>
                                            <h4 class=" mb-0 font-weight-semibold  tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `batch` WHERE `status` = 'Completed'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>
                                    <a href="batchlist.php?type=delete" style="color:#4AA02C"
                                        class="list-group-item list-group-item-action flex-column align-items-start border-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="tx-13 mb-2 font-weight-semibold text-danger">Deleted</p>
                                            <h4 class=" mb-0 font-weight-semibold text-danger tx-18"><b>
                                                    <?php
                                                    $sql = "SELECT * FROM `batch` WHERE `status` = 'Deleted'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($result);
                                                    echo $count;
                                                    ?>
                                                </b></h4>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Others</span>
                    </div>
                </div>
                <div class="row">


                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Internships</div>

                            </div>
                            <div class="card-body">

                                <div class="col text-center">
                                    <label class="tx-14">Listed</label>
                                    <a href="internshiplist.php" style="color:#1d71f2">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `internship`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>

                                        </p>
                                    </a>
                                </div><!-- col -->
                                <div class="col border-start text-center">
                                    <label class="tx-14">Companies</label>
                                    <a style="color:#1d71f2" href="internshiplist.php">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT DISTINCT `company_name` FROM `internship`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->


                                <div class="col border-start text-center">
                                    <label class="tx-14">Applicants</label>
                                    <a href="internshipregistrationlist.php" style="color:#000000">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `internship_registration`";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = mysqli_num_rows($result);
                                                echo $count;
                                            } else {
                                                echo "0";
                                            }

                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->



                                <div class="col border-start text-center">
                                    <label class="tx-14">Selected </label>

                                    <p class="font-weight-bold tx-24" style="color:#4AA20C">
                                        <?php
                                        $sql = "SELECT * FROM `student_selected_for_internship`";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        echo $count;
                                        ?>
                                    </p>

                                </div><!-- col -->




                            </div>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Placements</div>

                            </div>
                            <div class="card-body">

                                <div class="col text-center">
                                    <label class="tx-14">Listed</label>
                                    <a href="placementslist.php" style="color:#1d71f2">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `placement`";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = mysqli_num_rows($result);
                                                echo $count;
                                            }
                                            ?>

                                        </p>
                                    </a>
                                </div><!-- col -->
                                <div class="col border-start text-center">
                                    <label class="tx-14">Companies</label>
                                    <a style="color:#1d71f2">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT DISTINCT `company_name` FROM `placement`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->

                                <div class="col border-start text-center">
                                    <label class="tx-14">Applicants</label>
                                    <a href="placementsregistrationlist.php" style="color:#000000">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `placement_applicants`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->



                                <div class="col border-start text-center">
                                    <label class="tx-14">Selected </label>
                                    <a href="placementsregistrationlist.php?type=selected" style="color:#4AA20C">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `student_selected_for_placement`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->



                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title pb-0  mb-2">Enquiries</div>

                            </div>
                            <div class="card-body">

                                <div class="col text-center">
                                    <label class="tx-14">User Queries</label>
                                    <a href="contactformmsgs.php" style="color:#1d71f2">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `messages` WHERE `user_type` = 'Anonymous'";
                                            $result = mysqli_query($conn, $sql);

                                            $count = mysqli_num_rows($result);
                                            echo $count;

                                            ?>

                                        </p>
                                    </a>
                                </div><!-- col -->
                                <div class="col border-start text-center">
                                    <label class="tx-14">Live Chats</label>
                                    <a style="color:#1d71f2" href="livechat.php">
                                        <p class=" font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `messages` WHERE `user_type` = 'Admin'";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->

                                <div class="col border-start text-center">
                                    <label class="tx-14">Mails</label>
                                    <a href="inbox.php" style="color:#000000">
                                        <p class="font-weight-bold tx-24">
                                            <?php
                                            $sql = "SELECT * FROM `mail`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </p>
                                    </a>
                                </div><!-- col -->

                            </div>

                        </div>
                    </div>




                </div>
                <!-- End Page -->


                <?php include("./scripts.php"); ?>
                <?php
                if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
                    echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
                } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
                    echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
                }

                if (session_unset()) {
                    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
                }

                ?>

</body>

</html>