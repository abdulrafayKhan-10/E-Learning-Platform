<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $sql = "UPDATE `internship_registration` SET `status`='Active' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["success"] = "Student Registration Accepted.";
        header("location: pendinginternshipregistrations.php");
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again.";
        header("location: pendinginternshipregistrations.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <title>Pending Internship Registration</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
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
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Internship
                            Registrations </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item ">Registrations</li>
                            <li class="breadcrumb-item ">Pending</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <p><b> College</b> </p>
                            <select name="college" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>All</option>
                                <?php
                                $college = mysqli_query($conn, "SELECT * FROM `college`");
                                if (mysqli_num_rows($college) > 0) {
                                    while ($row = mysqli_fetch_assoc($college)) {
                                ?>
                                        <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                <?php
                                    }
                                }
                                ?>


                            </select>

                        </div>
                        <div class="form-group col-md-3">
                            <p><b>Internship / Role</b> </p>
                            <select name="role" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>All</option>
                                <?php
                                $college = mysqli_query($conn, "SELECT * FROM `internship`");
                                if (mysqli_num_rows($college) > 0) {
                                    while ($row = mysqli_fetch_assoc($college)) {
                                ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['internship'] ?></option>
                                <?php
                                    }
                                }
                                ?>


                            </select>

                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" style="height:40px;width:100px;margin-top:35px">Search</button>

                    </div>
                </form>
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
                                                <th class="border-bottom-0">S.No</th>

                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College name</th>

                                                <th class="border-bottom-0">Internship</th>

                                                <th class="border-bottom-0">Applied Date</th>
                                                <th class="border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $reg_query = "SELECT * FROM `internship_registration` WHERE 1=1";

                                            if (isset($_POST["role"]) && !empty($_POST["role"])) {
                                                $reg_query .= " AND `internship_id` = '{$_POST["role"]}'";
                                            }

                                            $result = mysqli_query($conn, $reg_query);

                                            if (mysqli_num_rows($result) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $student = "SELECT * FROM `student` WHERE `id` = '{$row['student_id']}'";

                                                    if (isset($_POST["college"]) && !empty($_POST["college"])) {
                                                        $student .= " AND `college_name` = '{$_POST["college"]}'";
                                                    }

                                                    $student_query = mysqli_query($conn, $student);

                                                    $internship_query = mysqli_query($conn, "SELECT * FROM `internship` WHERE `id` = '{$row['internship_id']}'");

                                                    if (mysqli_num_rows($student_query) > 0 && mysqli_num_rows($internship_query) > 0 && $row['status'] == "Pending") {
                                                        $fetch = mysqli_fetch_assoc($student_query);
                                                        $fetch2 = mysqli_fetch_assoc($internship_query);

                                                        echo '<tr>
                                                        <td>' . $i++ . '</td>
                                                        <td>' . $fetch['id'] . '</td>
                                                        <td>' . $fetch['name'] . '</td>
                                                        <td>' . $fetch['college_name'] . '</td>
                                                        <td>' . $fetch2['internship'] . '</td>
                                                        <td>' . $row['applied_date'] . '</td>
                                                        <td> <div class="col-sm-6 col-md-15 mg-t-10 mg-sm-t-0">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                        <form method="POST">
                                                        <input type="hidden" name="id" value="' . $row['id'] . '">
                                                        <input type="submit" name="submit" value="Accept" class="btn dropdown-item">
                                                        </form>
                                                     
                                                            <a class="btn dropdown-item" href="change_status.php?id=' . $row['id'] . '&type=delete">Delete</a>
                                                            
                                                        </div><!-- dropdown-menu -->
                                                    </div> </td> </tr>';
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
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>

</body>

</html>