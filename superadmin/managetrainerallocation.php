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
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Manage Tainer Allocation</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php
    if (isset($error)) {
        echo "<script>alert('" . $error . "');</script>";
    }
    ?>
    <?php
    include("./switcher.php");
    ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage allocate Trainers
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">allocate</li>
                            <li class="breadcrumb-item ">Trainer </li>
                            <li class="breadcrumb-item ">Manage </li>
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
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Date of adding</th>

                                                <th class="border-bottom-0">allocate ID</th>
                                                <th class="border-bottom-0">Trainer ID</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Course name</th>
                                                <!--		<th class="border-bottom-0">Re-allocate</th> -->
                                                <th class="border-bottom-0">Delete</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $allocation_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course`");
                                            $i = 1;

                                            if (mysqli_num_rows($allocation_query) > 0) {
                                                while ($row = mysqli_fetch_assoc($allocation_query)) {
                                                    $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '" . $row['trainer_id'] . "'");
                                                    $trainer_row = mysqli_fetch_assoc($trainer_query);

                                                    if ($trainer_row["id"] == $row["trainer_id"]) {
                                                        $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '" . $row['course_id'] . "'");
                                                        $course_row = mysqli_fetch_assoc($course_query);

                                                        if ($course_row) {  // Check if $course_row is not null
                                                            echo "<tr>";
                                                            echo "<td>" . $i . "</td>";
                                                            echo "<td>" . $row['created_date'] . "</td>";
                                                            echo "<td>ALLID_" . $row['id'] . "</td>";
                                                            echo "<td>TRID_" . $row['trainer_id'] . "</td>";
                                                            echo "<td>" . $trainer_row["name"] . "</td>";
                                                            echo "<td>" . $course_row['course_name'] . "</td>";
                                                            echo "<td><a class='btn btn-danger' href='./delete.php?id=" . $row['id'] . "&type=allocate'>Delete</a></td>";
                                                            echo "</tr>";
                                                            $i++;
                                                        }
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
</body>

</html>