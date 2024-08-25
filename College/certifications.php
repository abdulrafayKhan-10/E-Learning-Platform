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
    <title>Certications</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Student List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item ">Student</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <!-- <div class="row row-sm">

                    <div class="form-group col-md-6">
                        <P><b> Semester</b> </p>
                        <select name="country" class="form-control form-select" data-bs-placeholder="Select Filter">
                            <option value="br" selected>All</option>
                            <option value="cz">none</option>
                            <option value="de">1st Sem</option>
                            <option value="pl">2nd Sem</option>
                            <option value="pl">3nd Sem</option>
                            <option value="pl">4nd Sem</option>
                            <option value="pl">5nd Sem</option>
                            <option value="pl">6nd Sem</option>
                            <option value="pl">7nd Sem</option>
                            <option value="pl">8nd Sem</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <P><b> Account Type</b> </p>
                        <select name="country" class="form-control form-select" data-bs-placeholder="Select Filter">
                            <option value="br" selected>All</option>
                            <option value="cz">none</option>
                            <option value="de">College type</option>
                            <option value="pl">Individual type</option>
                        </select>
                    </div>


                    &nbsp &nbsp <a href="javascript:void(0);" class="btn btn-success">Search</a>
                    &nbsp &nbsp <a href="javascript:void(0);" class="btn btn-danger">Reset All </a>
                </div>

                <br>
                <br> -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Author</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College</th>
                                                <th class="border-bottom-0">stream</th>
                                                <th class="border-bottom-0">District</th>
                                                <th class="border-bottom-0">Download Certificate</th>
                                                <th class="border-bottom-0">View Profile</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $college_email = $_COOKIE['college_email'];
                                            $college_query = mysqli_query($conn, "SELECT * FROM `college` WHERE `email` = '{$college_email}'");
                                            if (mysqli_num_rows($college_query) > 0) {
                                                $college = mysqli_fetch_assoc($college_query);
                                                $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `college_name` = '{$college['name']}'");
                                                if (mysqli_num_rows($student_query) > 0) {
                                                    $i = 1;
                                                    while ($student = mysqli_fetch_assoc($student_query)) {
                                                        $certificate = mysqli_query($conn, "SELECT * FROM `certificate` WHERE `student_id` = '{$student['id']}'");
                                                        if (mysqli_num_rows($certificate) > 0) {
                                                            $certificate = mysqli_fetch_assoc($certificate);
                                                            echo "<tr>";
                                                            echo "<td>{$i}</td>";
                                                            echo "<td>{$student['creation_date']}</td>";
                                                            echo "<td>STID_{$student['id']}</td>";
                                                            echo "<td>{$student['name']}</td>";
                                                            echo "<td>{$student['username']}</td>";
                                                            echo "<td>{$student['college_name']}</td>";
                                                            echo "<td>{$student['branch']}</td>";
                                                            echo "<td>{$student['district']}</td>";
                                                            echo "<td><a class='btn btn-info' href='../superadmin/assets/docs/certificate/{$certificate['certificate']}' download=''>Certificate</a></td>";
                                                            echo "<td><a class='btn btn-info' href='studentprofile.php?id={$student['id']}'>view</a></td>";
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
    <?php include("./script.php"); ?>
</body>

</html>