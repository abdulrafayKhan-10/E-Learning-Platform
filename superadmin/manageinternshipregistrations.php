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
    <title>Manage Internship Registrations</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>
    <style>
    .dropdown-menu {
        position: fixed !important;
    }
    </style>
</head>

<body class="ltr main-body app sidebar-mini">

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
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item ">Registrations</li>
                            <li class="breadcrumb-item ">Manage</li>
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

                                                <th class="border-bottom-0">Date Of Applying</th>
                                                <th class="border-bottom-0">Internship ID</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Vacancies</th>
                                                <th class="border-bottom-0">Last date</th>
                                                <th class="border-bottom-0">Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $internship_query = mysqli_query($conn, "SELECT * FROM `internship`");

                                            if (mysqli_num_rows($internship_query) > 0) {
                                                $i = 1;
                                                while ($internship = mysqli_fetch_assoc($internship_query)) {
                                                    $id = $internship["id"];
                                                    $internship_registration_query = mysqli_query($conn, "SELECT * FROM `internship_registration` WHERE `internship_id`='$id'");
                                                    if (mysqli_num_rows($internship_registration_query) > 0) {
                                                        $fetch = mysqli_fetch_assoc($internship_registration_query);
                                                        $reg_id = $fetch['id'];
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        echo "<td>" . $internship['creation_date'] . "</td>";
                                                        echo "<td>INTID_" . $internship['id'] . "</td>";
                                                        echo "<td>" . $internship['internship'] . "</td>";
                                                        echo "<td>" . $internship['vacancies'] . "</td>";
                                                        echo "<td>" . $internship['last_date_to_apply'] . "</td>";
                                                        echo '  <td>
                                                    <div class="col-sm-6 col-md-15 mg-t-10 mg-sm-t-0">
                                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a href="selectstudent.php?id=' . $id . '"
                                                                class="dropdown-item">Add</a>
                                                          
                                                            <a class="btn dropdown-item"
                                                                href="delete.php?id=' . $reg_id . '&type=internshipregistration">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>';
                                                        echo "</tr>";
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