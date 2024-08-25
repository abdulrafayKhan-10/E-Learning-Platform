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
    <title>Upload Certificate</title>
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
                <?php include('./partials/sidebar.php'); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Certification
                            Upload</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a>
                            </li>
                            <li class="breadcrumb-item ">Certification</li>
                            <li class="breadcrumb-item ">Upload</li>
                        </ol>
                    </div>

                </div>
                <form method="post">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>

                            <select name="trainer_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">

                                <option value="" selected="selected">ALL</option>
                                <?php
                                $query = "SELECT DISTINCT `batchtrainer_name` FROM `batch`";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?= $row['batchtrainer_name'] ?>"><?= $row['batchtrainer_name'] ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Course name</label> </b>

                            <select name="course_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">

                                <option value="" selected="selected">ALL</option>
                                <?php
                                $query = "SELECT DISTINCT `batchcourse_name` FROM `batch`";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?= $row['batchcourse_name'] ?>"><?= $row['batchcourse_name'] ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search"
                            style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
                    </div>
                </form>

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
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Batch ID</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Course Name</th>
                                                <th class="border-bottom-0">Batch Name</th>
                                                <th class="border-bottom-0">view students</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $select_batch = "SELECT * FROM `batch` WHERE 1=1";

                                            if (isset($_POST["trainer_name"]) && !empty($_POST["trainer_name"])) {
                                                $select_batch .= " AND `batchtrainer_name` = '" . $_POST["trainer_name"] . "'";
                                            }
                                            if (isset($_POST["course_name"]) && !empty($_POST["course_name"])) {
                                                $select_batch .= " AND `batchcourse_name` = '" . $_POST["course_name"] . "'";
                                            }

                                            $run_batch_query = mysqli_query($conn, $select_batch);
                                            if (mysqli_num_rows($run_batch_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_array($run_batch_query)) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i . "</td>";
                                                    echo "<td>BATID_" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['batchtrainer_name'] . "</td>";
                                                    echo "<td>" . $row['batchcourse_name'] . "</td>";
                                                    echo "<td>" . $row['batch_name'] . "</td>";
                                                    echo "<td><a href='studentcertificate.php?crid=" . $row['course_id'] . "&coursename=" . $row['batchcourse_name'] . "' class='btn btn-info'>Upload</a></td>";
                                                    echo "</tr>";
                                                    $i++;
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