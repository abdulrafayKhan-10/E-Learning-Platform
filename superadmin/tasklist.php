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
    <title>Task List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php"); ?>
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

        </div> <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Tasks List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a></li>
                            <li class="breadcrumb-item ">Tasks</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Batch</label> </b>
                            <select name="batch_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="">Default</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM `batches_tasks`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    if (!empty($row['batch_id'])) {
                                        $batch_id = $row['batch_id'];
                                        $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` = '$batch_id'");
                                        $batch_name = mysqli_fetch_assoc($batch);
                                        echo "<option value='" . $batch_name['id'] . "'>" . $batch_name['batch_name'] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Type</label> </b>
                            <select name="type" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="">Default</option>
                                <option value="Individual">Individual</option>
                                <option value="All">Everyone</option>


                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search"
                            style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
                    </div>
                </form>
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

                                                <th class="border-bottom-0">Task Name</th>
                                                <th class="border-bottom-0">Allocated Students Type</th>
                                                <th class="border-bottom-0">Task Description </th>
                                                <th class="border-bottom-0">Task End Date</th>
                                                <th class="border-bottom-0">Batch Name</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM `batches_tasks` WHERE 1=1";
                                            if (isset($_POST["batch_name"]) && !empty($_POST["batch_name"])) {
                                                $query .= " AND batch_id = '" . $_POST['batch_name'] . "'";
                                            }
                                            if (isset($_POST["type"]) && !empty($_POST["type"])) {
                                                $query .= " AND allocated_students_type = '" . $_POST['type'] . "'";
                                            }
                                            $task_query = mysqli_query($conn, $query);
                                            if (mysqli_num_rows($task_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($task_query)) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row['task_name'] . "</td>";
                                                    echo "<td>" . $row['allocated_students_type'] . "</td>";
                                                    echo "<td>" . $row['task_description'] . "</td>";
                                                    echo "<td>" . $row['task_end_date'] . "</td>";
                                                    echo "<td>" . $row['batch_name'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {

                                                echo "No Tasks found";
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

</body>

</html>