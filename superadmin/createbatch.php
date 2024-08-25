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
    <title>Create Batch</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Create Batch </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">student batch</li>
                            <li class="breadcrumb-item ">Create</li>
                        </ol>
                    </div>

                </div>

                <br>
                <br>
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom dataTable no-footer dtr-inline collapsed" role="grid" aria-describedby="file-datatable_info" style="width: 605px;">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">S.no</th>
                                                    <th class="border-bottom-0">Date of adding</th>
                                                    <th class="border-bottom-0">Trainer ID</th>
                                                    <th class="border-bottom-0">Trainer Name</th>
                                                    <th class="border-bottom-0">Course name</th>
                                                    <th class="border-bottom-0">Total Allocated</th>

                                                    <th class="border-bottom-0">Create</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            $alloc_trainer = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course`");

                                            if (mysqli_num_rows($alloc_trainer) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($alloc_trainer)) {
                                                    $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '{$row['trainer_id']}'");

                                                    if (mysqli_num_rows($trainer_query) > 0) {
                                                        $trainer = mysqli_fetch_assoc($trainer_query);
                                                        $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '{$row['course_id']}'");

                                                        if (mysqli_num_rows($course_query) > 0) {
                                                            $course = mysqli_fetch_assoc($course_query);
                                                            echo "<tr>";
                                                            echo "<td>{$i}</td>";
                                                            echo "<td>{$row['created_date']}</td>";
                                                            echo "<td>TRID_{$row['trainer_id']}</td>";
                                                            echo "<td>{$trainer['name']}</td>";
                                                            echo "<td>{$course['course_name']}</td>";

                                                            $batch_alloc_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `trainer_id` = '{$trainer['id']}'");

                                                            $count = 0;
                                                            while ($fetch_batch_alloc = mysqli_fetch_assoc($batch_alloc_query)) {
                                                                // Check if allocate_id and course_id match
                                                                if ($fetch_batch_alloc['trainer_id'] == $trainer['id'] && $course["id"] == $fetch_batch_alloc["course_id"]) {
                                                                    ++$count;
                                                                }
                                                            }

                                                            echo "<td>{$count}</td>";
                                                            echo "<td><a href='batchfinalcreate.php?id={$row['trainer_id']}&crid={$row['course_id']}' class='btn btn-info'>Create</a></td>";
                                                        }
                                                    }
                                                    $i++;
                                                }
                                            }
                                            ?>

                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

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
    session_destroy();
    // session_start();
    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    // echo "<script>toastr.success('" . $_SESSION["previous_url"] . "')</script>"
    ?>

</body>

</html>