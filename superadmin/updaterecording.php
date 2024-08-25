<?php
session_start();

include('../db_connection/connection.php');
if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_GET['r_id'])) {
    $id = filter_var($_GET['r_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $query = "SELECT * FROM `batches_recording` WHERE `id` = '$id'";
    $run = mysqli_query($conn, $query);
    if (!$run) {
        if (isset($_SESSION['previous_url'])) {
            header('Location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            // Fallback redirection if previous_url is not set
            header('Location: ./dashboard.php');
            exit();
        }
    }
    $recording = mysqli_fetch_assoc($run);

    if (!$id) {
        echo "Recording not found!";
        exit();
    }

    if (isset($_POST['UpdateBtn'])) {
        // Updated code here is similar to the createcourse.php file

        // Retrieve updated values
        $recording_name = $_POST['recording_name'];
        $Date_of_Upload = $_POST['Date_of_Upload'];
        $Driving_link = $_POST['Driving_link'];
        $batch_id = $_POST['batch_id'];
        $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$batch_id'");
        $fetch_batch = mysqli_fetch_assoc($select_batch);
        if ($fetch_batch['id'] == $batch_id) {
            $batch_name = $fetch_batch['batch_name'];

            // Update query
            $update_query = "UPDATE `batches_recording` SET `recording_topic_name`=?,`date_of_upload`=?,`driving_link`=?,`batch_id`=?,`batch_name`=? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            $update_stmt->bind_param(
                "sssssi",
                $recording_name,
                $Date_of_Upload,
                $Driving_link,
                $batch_id,
                $batch_name,
                $id
            );

            if (mysqli_stmt_execute($update_stmt)) {
                session_destroy();
                $_SESSION["success"] = "Recording updated successfully!";
                header("location: managerecordings.php");
                exit();
            } else {
                $_SESSION["error"] = "Error updating recording.";
                header("location: managerecordings.php");
                exit();
            }
        }
    }
} elseif (!isset($_GET["r_id"]) || empty($_GET["r_id"])) {

    $_SESSION["error"] = "Recording not found!";
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <title>Update Recording</title>

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Switcher -->
    <?php include("./switcher.php"); ?>
    <!-- End Switcher -->

    <!-- Page -->
    <div class="page">

        <div class="main-header side-header sticky nav nav-item">

            <?php include('./partials/navbar.php'); ?>

        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        <div class="sticky">
            <?php include('./partials/sidebar.php') ?>
        </div>
        <!-- main-sidebar -->


        <form method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Update
                                Recordings</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recordings</li>
                                <li class="breadcrumb-item active" aria-current="page">Update</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <br>

                <div class="form-group col-md-4">
                    <select name="batch_id" required class="form-control form-select select2"
                        data-bs-placeholder="Select Batch">
                        <?php
                        if (isset($_GET['r_id'])) {
                            $id = $_GET['r_id'];
                            $sql = mysqli_query($conn, "SELECT * FROM `batches_recording` WHERE id = '$id'");
                            $fetch_sql = mysqli_fetch_assoc($sql);
                            $selected_batch_id = $fetch_sql['batch_id'];



                            $batch = mysqli_query($conn, "SELECT * FROM `batch`");
                            if (mysqli_num_rows($batch) > 0) {
                                while ($row = mysqli_fetch_assoc($batch)) {
                        ?>
                        <option value="<?php echo $row['id'] ?>"
                            <?php if (isset($selected_batch_id) && $selected_batch_id == $row['id']) echo "selected"; ?>>
                            <?php echo $row['batch_name'] ?></option>
                        <?php

                                }
                            }
                        } ?>
                    </select>
                </div>

                <!-- row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">


                                <div class="">
                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Recording Topic Name</label>
                                                <input class="form-control" placeholder="enter the recording name"
                                                    type="text" name="recording_name"
                                                    value="<?php echo $recording['recording_topic_name'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Upload</label>
                                                <input class="form-control" id="dateMask" placeholder="MM/DD/YYYY"
                                                    type="date" name="Date_of_Upload"
                                                    value="<?php echo $recording['date_of_upload'] ?>" required>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Driving link</label>
                                                <input type="text" class="form-control" id="exampleInputcode"
                                                    placeholder="Enter driving link"
                                                    value="<?php echo $recording['driving_link'] ?>" name="Driving_link"
                                                    required>
                                            </div>
                                        </div> <br>





                                    </div>
                                    <button type="submit" name="UpdateBtn" class="btn btn-info mt-3 mb-0"
                                        data-bs-target="#schedule" data-bs-toggle="modal"
                                        style="text-align:right">Update Recording</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>

    <!-- JS -->
    <?php include('./scripts.php'); ?>

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