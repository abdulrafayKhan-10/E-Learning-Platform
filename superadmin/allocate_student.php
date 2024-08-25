<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

if (!isset($_GET['id']) || empty($_GET['id']) && !isset($_GET['course_id']) || empty($_GET['course_id'])) {
    header('location: ./student_manage_batch.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Allocate Batch To Student</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Batch List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Batches</a></li>
                            <li class="breadcrumb-item ">Allocate</li>
                            <li class="breadcrumb-item ">Student</li>
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
                                                <th class="border-bottom-0">Batch Creation Date</th>
                                                <th class="border-bottom-0">Batch ID</th>
                                                <th class="border-bottom-0">Batch Name</th>

                                                <th class="border-bottom-0">Course Name</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Slot</th>
                                                <th class="border-bottom-0">Allocate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $student_id = (int) $_GET['id'];
                                            $course_id = (int) $_GET['course_id'];
                                            $batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `course_id` = '$course_id'");

                                            if (mysqli_num_rows($batch_query) > 0) {
                                                $i = 1;
                                                while ($batch = mysqli_fetch_assoc($batch_query)) {
                                                    $student_batch = mysqli_query($conn, "SELECT * FROM `batch_student` WHERE `student_id` = '$student_id' AND `batch_id` = '{$batch["id"]}'");
                                                    if ($batch['status'] === "Active" && mysqli_num_rows($student_batch) === 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $batch['created_date']; ?></td>
                                                <td>BID_<?php echo $batch['id']; ?></td>
                                                <td><?php echo $batch['batch_name']; ?></td>
                                                <td><?php echo $batch['batchcourse_name']; ?></td>
                                                <td><?php echo $batch['batchtrainer_name']; ?></td>
                                                <td><?php echo $batch['session_slot']; ?></td>
                                                <?php
                                                            if (isset($_GET["type"]) && $_GET["type"] == "reallocate" && isset($_GET["batch_id"])) {
                                                                $bat_id = (int) $_GET["batch_id"];
                                                            ?>

                                                <td><a href="reallocate_batch.php?id=<?php echo $batch['id']; ?>&student_id=<?php echo $student_id; ?>&course_id=<?php echo $course_id; ?>&batch_id=<?php echo $bat_id; ?>"
                                                        class="btn btn-primary">Allocate</td>
                                                <?php
                                                            } else {


                                                            ?>
                                                <td><a href="alloc_student.php?id=<?php echo $batch['id']; ?>&student_id=<?php echo $student_id; ?>&course_id=<?php echo $course_id; ?>"
                                                        class="btn btn-primary">Allocate</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                                        $i++;
                                                    }
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
    session_unset();

    // $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];


    ?>
</body>

</html>