<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

if (isset($_POST["accept"])) {
    $id = $_POST["id"];
    $sql = "UPDATE `batches_schedule` SET `status`='Active' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["success"] = "Batch Schedule Accepted.";
        header("location: pendingbatchschedule.php");
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again.";
        header("location: pendingbatchschedule.php");
        exit();
    }
}

if (isset($_POST["reject"])) {
    $id = $_POST["id"];
    $sql = "UPDATE `batches_schedule` SET `status`='Rejected' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["success"] = "Batch Schedule Rejected.";
        header("location: pendingbatchschedule.php");
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again.";
        header("location: pendingbatchschedule.php");
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
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>
                            <select name="trainer_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM `trainer`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $row['username'] . "'>" . $row['name'] . "</option>";
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
                                                <th class="border-bottom-0">Date Of Adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Date Of Schedule</th>
                                                <th class="border-bottom-0">Update</th>
                                                <th class="border-bottom-0">Accept</th>
                                                <th class="border-bottom-0">Reject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "SELECT * FROM `batches_schedule` WHERE 1=1";

                                            if (isset($_POST['trainer_name']) && !empty($_POST['trainer_name'])) {
                                                $query .= " AND `trainer_username` = '" . $_POST['trainer_name'] . "'";
                                            }

                                            $result = mysqli_query($conn, $query);

                                            if (mysqli_num_rows($result) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if ($row['status'] == "Pending") {
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        echo "<td>" . $row['added_date'] . "</td>";
                                                        echo "<td>TRID_" . $row['trainer_id'] . "</td>";
                                                        echo "<td>" . $row['trainer_username'] . "</td>";
                                                        echo "<td>" . $row['date_of_schedule'] . "</td>";
                                                        echo "<td><a href='./update_schedule.php?id=" . $row["id"] . "' class='btn btn-info'>Update</a></td>";
                                                        echo "<form method='post'>
                                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                    <td><button type='submit' name='accept' class='btn btn-success'>Accept</button></td>
                                                    </form>";
                                                        echo "<form method='post'>
                                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                    <td><button type='submit' name='reject' class='btn btn-danger'>Reject</button></td>
                                                    </form>";
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