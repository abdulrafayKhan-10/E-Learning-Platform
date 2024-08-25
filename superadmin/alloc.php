<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_GET["error"])) {
    $error = $_GET["error"];
    echo "<script>toastr.error('$error')</script>";
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Allocate</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <?php include("./switcher.php") ?>

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php"); ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Trainer
                            Allocation
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Manage</a></li>
                            <li class="breadcrumb-item ">Allocation</li>
                            <li class="breadcrumb-item ">Trainer</li>
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
                                                <th class="border-bottom-0">Course id</th>
                                                <th class="border-bottom-0">Trainer Id</th>

                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Course Name</th>

                                                <th class="border-bottom-0">Allocate</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $id = filter_var($_GET["crid"], FILTER_SANITIZE_NUMBER_INT);
                                            $id = (int) $id;
                                            $query_allocate = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `course_id` = '$id'");

                                            if (mysqli_num_rows($query_allocate) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query_allocate)) {
                                                    $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '{$row['course_id']}'");
                                                    $course_row = mysqli_fetch_assoc($course_query);
                                                    $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '{$row['trainer_id']}'");
                                                    $trainer_row = mysqli_fetch_assoc($trainer_query);
                                                    if (mysqli_num_rows($trainer_query) > 0) {
                                                        $trainer_name = $trainer_row['name'];
                                                        echo "<tr>";
                                                        echo "<td>{$i}</td>";
                                                        echo "<td>{$row['course_id']}</td>";
                                                        echo "<td>{$row['trainer_id']}</td>";
                                                        echo "<td>{$trainer_row['name']}</td>";
                                                        echo "<td>{$course_row['course_name']}</td>";
                                                        echo "<td><a href='./coursestudentallocation.php?type=allocate&id={$row['id']}&crid={$row['course_id']}&tid={$row['trainer_id']}' class='btn btn-info'>Allocate</a></td>";
                                                        echo "</tr>";
                                                        $i++;
                                                    } else {
                                                        $trainer_name = "Not Available";
                                                    }
                                                }
                                            } else {
                                                echo "No Data Found";
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
    <!-- Container closed -->
    <?php include("./scripts.php") ?>
    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_unset()) {
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    }

    // echo "<script>toastr.success('" . $_SESSION["previous_url"] . "')</script>"
    ?>

</body>

</html>