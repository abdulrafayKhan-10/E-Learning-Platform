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
    <title>My Students</title>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">


    <?php include("./style.php"); ?>
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

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Student List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item ">Student</li>
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
                                                <th class="border-bottom-0">S.No</th>
                                                <th class="border-bottom-0">Date of adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Author</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College</th>
                                                <th class="border-bottom-0">stream</th>
                                                <th class="border-bottom-0">District</th>
                                                <th class="border-bottom-0">View Profile</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $college_name = $_COOKIE["college_username"];
                                            $query = "SELECT * FROM `college` WHERE `username` = '$college_name'";
                                            // if (isset($_POST["search"])) {
                                            // 	$stream = $_POST["stream"];
                                            // 	$query .= " AND `college_streams` = '$stream'";
                                            // }
                                            $college_query = mysqli_query($conn, $query);
                                            $college = mysqli_fetch_assoc($college_query);
                                            $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `college_id` = '{$college["id"]}'");
                                            if (mysqli_num_rows($student_query) > 0) {
                                                $i = 1;
                                                while ($student = mysqli_fetch_assoc($student_query)) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $student["creation_date"] . "</td>";
                                                    echo "<td>STID_" . $student["id"] . "</td>";
                                                    echo "<td>" . $student["created_by"] . "</td>";
                                                    echo "<td>" . $student["name"] . "</td>";
                                                    echo "<td>" . $student["college_name"] . "</td>";
                                                    echo "<td>" . $college["college_streams"] . "</td>";
                                                    echo "<td>" . $student["district"] . "</td>";
                                                    echo "<td><a class='btn btn-info' href='studentprofile.php?id=" . $student["id"] . "'>View</a></td>";
                                                    echo "</tr>";
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
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!-- Sidebar-right-->




    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./script.php"); ?>

</body>

</html>