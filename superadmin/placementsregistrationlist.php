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

    <title>Placement Registration List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"> -->
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
        </div> <!-- main-content -->
        <div class="main-content app-content">
            <!-- container -->
            <div class="main-container container-fluid">
                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Placement List</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Placement</a></li>
                            <li class="breadcrumb-item ">Registrations</li>
                            <li class="breadcrumb-item ">List</li>
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
                            <p><b>Placement / Role</b> </p>
                            <select name="role" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>All</option>
                                <?php
                                $college = mysqli_query($conn, "SELECT * FROM `placement`");
                                if (mysqli_num_rows($college) > 0) {
                                    while ($row = mysqli_fetch_assoc($college)) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= $row['job_role'] ?></option>
                                <?php
                                    }
                                }
                                ?>


                            </select>

                        </div>
                        <div class="form-group col-md-3">
                            <p><b>Company</b> </p>
                            <select name="company" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>All</option>
                                <?php
                                $college = mysqli_query($conn, "SELECT DISTINCT `company_name` FROM `placement`");
                                if (mysqli_num_rows($college) > 0) {
                                    while ($row = mysqli_fetch_assoc($college)) {
                                ?>
                                <option value="<?= $row['company_name'] ?>"><?= $row['company_name'] ?></option>
                                <?php
                                    }
                                }
                                ?>


                            </select>

                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>

                    </div>
                </form>
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="table-responsive export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Date of Adding OR Applying</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Placement Applied ID</th>
                                                <th class="border-bottom-0">Student Name</th>
                                                <th class="border-bottom-0">Company Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $plac_query = "SELECT * FROM `placement_applicants` WHERE 1=1";
                                            if (isset($_POST["role"]) && !empty($_POST["role"])) {
                                                $role = (int) $_POST["role"];
                                                $plac_query .= " AND `job_id` = '$role'";
                                            }

                                            $placement_list_query = mysqli_query($conn, $plac_query);
                                            if (mysqli_num_rows($placement_list_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($placement_list_query)) {
                                                    $placement_q = "SELECT * FROM `placement` WHERE `id` = '{$row["job_id"]}'";
                                                    if(isset($_POST["company"]) && !empty($_POST["company"])){
                                                        $placement_q .= " AND `company_name` = '{$_POST["company"]}'";
                                                    }
                                                    $placement_query = mysqli_query($conn, $placement_q);
                                                    if (mysqli_num_rows($placement_query) > 0) {
                                                        $std_query = "SELECT * FROM `student` WHERE `id` = '{$row['student_id']}'";
                                                        if (isset($_POST["college"]) && !empty($_POST["college"])) {
                                                            $std_query = "SELECT * FROM `student` WHERE `college_name` = '{$_POST["college"]}' AND `id` = '{$row['student_id']}'";
                                                        }

                                                        $student_query = mysqli_query($conn, $std_query);
                                                        $student = mysqli_fetch_assoc($student_query);
                                                        if (mysqli_num_rows($student_query) > 0) {
                                                            $placement = mysqli_fetch_assoc($placement_query);
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            echo "<td>" . $row['applied_date'] . "</td>";
                                                            echo "<td>" . $placement['job_role'] . "</td>";
                                                            echo "<td>PLAID_" . $placement['id'] . "</td>";
                                                            echo "<td>" . $student['name'] . "</td>";
                                                            echo "<td>" . $placement['company_name'] . "</td>";
                                                            echo "</tr>";
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

    </script>
    <?php include("./scripts.php"); ?>
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#file-datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script> -->
</body>

</html>