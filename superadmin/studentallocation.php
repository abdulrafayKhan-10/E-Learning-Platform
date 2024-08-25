<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Allocation</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <?php include("./switcher.php"); ?>
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
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Course List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Create</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Course ID</th>
                                                <th class="border-bottom-0">Course name</th>
                                                <th class="border-bottom-0">Price</th>
                                                <th class="border-bottom-0">Duration</th>
                                                <th class="border-bottom-0">map students</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $course_query = mysqli_query($conn, "SELECT * FROM `course`");

                                            if (mysqli_num_rows($course_query) > 0) {
                                                $i = 1;

                                                while ($row = mysqli_fetch_assoc($course_query)) {
                                                    $allocate_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `course_id` = '" . $row['id'] . "'");
                                                    if (mysqli_num_rows($allocate_query) > 0) {
                                                        $crid = $row['id'];
                                                        $date = $row['creation_date'];
                                                        $cname = $row['course_name'];
                                                        $cprice = $row['final_cost'];
                                                        $cduration = $row['duration_days'];

                                                        echo '
                                        <tr>
                                            <td>' . $i . '</td>
                                            <td>' . $date . '</td>
                                            <td>CRID_' . $crid . '</td>
                                            <td>' . $cname . '</td>
                                            <td>' . $cprice . '</td>
                                            <td>' . $cduration . '</td>
                                            <td><a href="alloc.php?crid=' . $crid . '" class="btn btn-info">Allocate</a></td>
                                        </tr>
                                        ';
                                                    }
                                                    $i++;
                                                }
                                            } else {
                                                echo '<tr><td colspan="7" class="text-center">No records found</td></tr>';
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>

    </div>


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