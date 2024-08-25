<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header('location:./registercourse.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Select Student</title>
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
            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <!-- main-sidebar -->



        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Registration Allocation
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Registration</li>
                            <li class="breadcrumb-item ">Add</li>
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
                                                <th class="border-bottom-0">Date Of Adding</th>
                                                <th class="border-bottom-0">ID No</th>

                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College</th>
                                                <th class="border-bottom-0">stream</th>
                                                <th class="border-bottom-0">District</th>
                                                <th class="border-bottom-0">View Profile</th>
                                                <th class="border-bottom-0">Allocate</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
                                            $id = (int) $id;
                                            $college_name = $_COOKIE['college_username'];
                                            $college_query = mysqli_query($conn, "SELECT * FROM `college` WHERE `username` = '$college_name'");
                                            $college_data = mysqli_fetch_assoc($college_query);
                                            $college_id = $college_data['id'];

                                            if (isset($_GET["type"]) && $_GET["type"] == "course") {
                                                $query = "SELECT * FROM `student` WHERE `college_id`='$college_id'";

                                                $query = $conn->query($query);
                                                if ($query) {
                                                    $i = 1;

                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $query2 = mysqli_query($conn, "SELECT * FROM `course_registration` WHERE `student_id` = '{$row['id']}' AND `course_id` = '$id'");

                                                        if ($query2) {
                                                            $fetch = mysqli_fetch_assoc($query2);

                                                            if (!$fetch) {
                                                                echo "<tr>";
                                                                echo "<td>" . $i++ . "</td>";
                                                                echo "<td>" . $row['creation_date'] . "</td>";
                                                                echo "<td>STID_" . $row['id'] . "</td>";
                                                                echo "<td>" . $row['name'] . "</td>";
                                                                echo "<td>" . $row['college_name'] . "</td>";
                                                                echo "<td>" . $row['branch'] . "</td>";
                                                                echo "<td>" . $row['district'] . "</td>";
                                                                echo "<td><a href='./viewstudent.php?id=" . $row['id'] . "' class='btn btn-info'>View</a></td>";
                                                                echo "<td><a href='allocstudent.php?id=" . $row['id'] . "&course_id=" . $id . "' class='btn btn-success'>Allocate</a></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            // Handle query execution error for course_registration query
                                                            echo "Error executing course_registration query: " . mysqli_error($conn);
                                                        }
                                                    }
                                                } else {
                                                    // Handle query execution error for student query
                                                    echo "Error executing student query: " . mysqli_error($conn);
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
    <!-- BACK-TO-TOP -->

    <?php include("./script.php"); ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>
</body>

</html>