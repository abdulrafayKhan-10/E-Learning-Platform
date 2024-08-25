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
    <title>Internship List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Internship List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item ">View</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Company name</label> </b>

                            <select name="company_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">

                                <option value="" selected="selected">ALL</option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT DISTINCT company_name FROM `internship`");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        echo '<option value="' . $row['company_name'] . '">' . $row['company_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <P><b> Internship Category</b> </p>
                            <select name="internship_category" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>All</option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT DISTINCT internship_category FROM `internship`");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        echo '<option value="' . $row['internship_category'] . '">' . $row['internship_category'] . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>

                    </div>
                </form>
                <br>
                <br>
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
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Company</th>
                                                <th class="border-bottom-0">Internship ID</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Vacancy</th>
                                                <th class="border-bottom-0">Last date</th>
                                                <th class="border-bottom-0">Category</th>



                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $query = "SELECT * FROM `internship` WHERE 1=1";
                                            if (isset($_POST['company_name']) && $_POST['company_name'] != '') {
                                                $company_name = $_POST['company_name'];
                                                $query .= " AND company_name = '$company_name'";
                                            }
                                            if (isset($_POST['internship_category']) && $_POST['internship_category'] != '') {
                                                $internship_category = $_POST['internship_category'];
                                                $query .= " AND internship_category = '$internship_category'";
                                            }
                                            $result = mysqli_query($conn, $query);
                                            if (!$result) {
                                                die('Error: ' . mysqli_error($conn));
                                            }
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td>' . $i . '</td>';
                                                echo '<td>' . $row['creation_date'] . '</td>';
                                                echo '<td>' . $row['company_name'] . '</td>';
                                                echo '<td>INTID_' . $row['id'] . '</td>';
                                                echo '<td>' . $row['internship'] . '</td>';
                                                echo '<td>' . $row['vacancies'] . '</td>';
                                                echo '<td>' . $row['last_date_to_apply'] . '</td>';
                                                echo '<td>' . $row['internship_category'] . '</td>';
                                                echo '</tr>';
                                                $i++;
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

    <?php include("./scripts.php"); ?>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#file-datatable').DataTable();
    });
    </script>
</body>