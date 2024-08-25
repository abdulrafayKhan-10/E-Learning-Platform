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
    <title>batches management</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <?php include("./style.php"); ?>

    <style>
    .dropdown-menu {
        position: fixed !important;
    }
    </style>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php
    include("./switcher.php")

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

        </div> <!-- main-content -->
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
                            <li class="breadcrumb-item ">Create</li>
                            <li class="breadcrumb-item ">Manage</li>
                        </ol>
                    </div>

                </div>
                <!-- <form method="post">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b>
                                <p>Company name</p>
                            </b>

                            <select name="company_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">

                                <option value="ALL" selected="selected">ALL</option>
                                <option value="Triaright Solutions LLP">Triaright Solutions LLP</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <P><b> Internship Category</b> </p>
                            <select name="internship_category" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="ALL" selected="selected">ALL</option>
                                <option value="Virtual">Virtual</option>
                                <option value="Offline">Offline</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>

                    </div>
                </form> -->

                <!-- <br>
                <br> -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="table-responsive export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Company name</th>
                                                <th class="border-bottom-0">Internship ID</th>
                                                <th class="border-bottom-0">Internship Category</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Vacancy</th>
                                                <th class="border-bottom-0">Last date</th>
                                                <th class="border-bottom-0">actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM `internship`");

                                            if (mysqli_num_rows($query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $id = $row['id'];
                                                    $company_name = $row['company_name'];
                                                    $internship_category = $row['internship_category'];
                                                    $role = $row['internship'];
                                                    $vacancy = $row['vacancies'];
                                                    $last_date = $row['last_date_to_apply'];

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row['creation_date'] . "</td>";
                                                    echo "<td>" . $company_name . "</td>";
                                                    echo "<td>INTID_" . $row['id'] . "</td>";
                                                    echo "<td>" . $internship_category . "</td>";
                                                    echo "<td>" . $role . "</td>";
                                                    echo "<td>" . $vacancy . "</td>";
                                                    echo "<td>" . $last_date . "</td>";
                                                    echo '  <td>
                                                    <div class="col-sm-6 col-md-15 mg-t-10 mg-sm-t-0">
                                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a href="viewinternship.php?id=' . $id . '"
                                                                class="dropdown-item">View</a>
                                                            <a href="updateinternship.php?id=' . $id . '"
                                                                class="dropdown-item">Update</a>
                                                          
                                                            <a class="btn dropdown-item"
                                                                href="delete.php?id=' . $id . '&type=internship">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>';
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

    <?php include("./scripts.php"); ?>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#file-datatable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
        });
    });
    </script>
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