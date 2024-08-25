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
    <title>Manage Schedule</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Batch Schedule</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Batch Management</a>
                            </li>
                            <li class="breadcrumb-item ">Manage</li>
                            <li class="breadcrumb-item ">Batch</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>
                            <select name="trainer_name" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM `trainer`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search" style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
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
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Main Topic</th>
                                                <th class="border-bottom-0">Batch Name</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Date Of Schedule </th>
                                                <th class="border-bottom-0">Starting Time</th>
                                                <th class="border-bottom-0">Duration</th>
                                                <th class="border-bottom-0">Update</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $query = "SELECT * FROM `batches_schedule` WHERE 1=1";



                                            $scheduled_batch_query = mysqli_query($conn, $query);
                                            if (mysqli_num_rows($scheduled_batch_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($scheduled_batch_query)) {
                                                    $query2 = "SELECT * FROM `batch` WHERE `id` = '$row[batch_id]'";
                                                    if (isset($_POST['trainer_name']) && !empty($_POST['trainer_name'])) {
                                                        $query2 .= " AND `batchtrainer_name` = '" . $_POST['trainer_name'] . "'";
                                                    }
                                                    $trainer_batch_query = mysqli_query($conn, $query2);
                                                    if (mysqli_num_rows($trainer_batch_query) > 0 && $row["status"] == "Active") {
                                                        $fetch = mysqli_fetch_assoc($trainer_batch_query);
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        echo "<td>SCHID_" . $row["id"] . "</td>";
                                                        echo "<td>" . $row["main_topic"] . "</td>";
                                                        echo "<td>" . $fetch["batch_name"] . "</td>";
                                                        echo "<td>" . $fetch["batchtrainer_name"] . "</td>";
                                                        echo "<td>" . $row["date_of_schedule"] . "</td>";
                                                        echo "<td>" . $row["class_starting_time"] . "</td>";
                                                        echo "<td>" . $row["class_duration"] . "</td>";

                                                        echo "<td><a href='./update_schedule.php?id=" . $row["id"] . "' class='btn btn-info'>Update</a></td>";
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