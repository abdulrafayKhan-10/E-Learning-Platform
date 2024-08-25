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
    <title>Meetings List</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Meetings List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a></li>
                            <li class="breadcrumb-item ">Meetings</li>
                            <li class="breadcrumb-item ">List</li>
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
                                $query = mysqli_query($conn, "SELECT * FROM `batches_meetings`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    if (!empty($row['batch_id'])) {
                                        $batch_id = $row['batch_id'];
                                        $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` = '$batch_id'");
                                        $batch_name = mysqli_fetch_assoc($batch);
                                        echo "<option value='" . $batch_name['id'] . "'>" . $batch_name['batchtrainer_name'] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Platform</label> </b>
                            <select name="platform" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT DISTINCT `platform` FROM `batches_meetings` ORDER BY `platform` ASC");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $row['platform'] . "'>" . $row['platform'] . "</option>";
                                }
                                ?>

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
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Id</th>
                                                <th class="border-bottom-0">Date of Meeting Link</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Platform</th>
                                                <th class="border-bottom-0">Meeting Link</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $meet = "SELECT * FROM `batches_meetings` WHERE 1=1";
                                            if (isset($_POST['platform']) && !empty($_POST['platform'])) {
                                                $platform = $_POST['platform'];
                                                $meet .= " AND `platform` = '$platform'";
                                            }
                                            if (isset($_POST['trainer_name']) && !empty($_POST['trainer_name'])) {
                                                $trainer_name = (int) $_POST['trainer_name'];
                                                $meet .= " AND `batch_id` = '$trainer_name'";
                                            }
                                            $meetings = mysqli_query($conn, $meet);
                                            if (mysqli_num_rows($meetings) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($meetings)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>SCHMEETID_" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['date_of_meeting_link'] . "</td>";
                                                    if (!empty($row["batch_id"])) {
                                                        $batch_id = $row['batch_id'];
                                                        $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` = '$batch_id'");
                                                        $batch_name = mysqli_fetch_assoc($batch);
                                                        echo "<td>" . $batch_name['batchtrainer_name'] . "</td>";
                                                    } else {
                                                        echo "<td>No Trainer Found</td>";
                                                    }
                                                    echo "<td>" . $row['platform'] . "</td>";
                                                    echo "<td><a class='btn btn-primary btn-sm' href=" . $row['meeting_link'] . " target='_blank'>View</a></td>";

                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "No data found";
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