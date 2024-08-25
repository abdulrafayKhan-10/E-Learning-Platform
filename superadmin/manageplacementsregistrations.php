<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Manage Placement Registrations</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Placement </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Placement</a></li>
                            <li class="breadcrumb-item ">Registrations</li>
                            <li class="breadcrumb-item ">Manage</li>
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
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>

                                                <th class="border-bottom-0">S.No</th>

                                                <th class="border-bottom-0">Date Of Adding</th>
                                                <th class="border-bottom-0">Placement ID</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Vacancies</th>
                                                <th class="border-bottom-0">Last date</th>
                                                <th class="border-bottom-0">Actions</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $placement_query = mysqli_query($conn, "SELECT * FROM `placement`");

                                            if (mysqli_num_rows($placement_query) > 0) {
                                                $i = 1;
                                                while ($placement = mysqli_fetch_assoc($placement_query)) {
                                                    $id = $placement["id"];
                                                    $placement_registration_query = mysqli_query($conn, "SELECT * FROM `placement_applicants` WHERE `job_id`='$id'");
                                                    if (mysqli_num_rows($placement_registration_query) > 0) {
                                                        $fetch = mysqli_fetch_assoc($placement_registration_query);
                                                        $reg_id = $fetch['id'];
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        echo "<td>" . $placement['added_date'] . "</td>";
                                                        echo "<td>PLAID_" . $placement['id'] . "</td>";
                                                        echo "<td>" . $placement['job_role'] . "</td>";
                                                        echo "<td>" . $placement['vacancies'] . "</td>";
                                                        echo "<td>" . $placement['last_date_to_apply'] . "</td>";
                                                        echo '  <td>
                                                    <div class="col-sm-6 col-md-15 mg-t-10 mg-sm-t-0">
                                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a href="selectstudentplacement.php?id=' . $id . '"
                                                                class="dropdown-item">Add</a>
                                                          
                                                            <a class="btn dropdown-item"
                                                                href="delete.php?id=' . $reg_id . '&type=placementregistration">Remove</a>
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
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_destroy()) {
        session_start();
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    }

    ?>
</body>


</html>