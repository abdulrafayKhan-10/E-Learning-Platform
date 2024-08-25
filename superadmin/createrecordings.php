<?php
session_start();
include('../db_connection/connection.php');
if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (isset($_POST['submitBtn'])) {
    $recording_name = $_POST['recording_name'];
    $Date_of_Upload = $_POST['Date_of_Upload'];
    $Driving_link = $_POST['Driving_link'];
    $batch_id = $_POST['batch_id'];
    $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$batch_id'");
    $fetch_batch = mysqli_fetch_assoc($select_batch);
    if ($fetch_batch['id'] == $batch_id) {
        $batch_name = $fetch_batch['batch_name'];
        $insert_query = mysqli_prepare($conn, "INSERT INTO `batches_recording`(`recording_topic_name`, `date_of_upload`, `driving_link`,`batch_id`,`batch_name`) VALUES (?,?,?,?,?)");
        $insert_query->bind_param('sssss', $recording_name, $Date_of_Upload, $Driving_link, $batch_id, $batch_name);
        if ($insert_query->execute()) {
            $_SESSION['success'] = "Recording Added Successfully";
            header('location: createrecordings.php');
            exit();
        } else {
            $_SESSION["error"] = "Unexpected Error.";
            header("location: createrecordings.php");
            exit();
        }
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

    <!-- Title -->
    <title>Create Recordings</title>

    <?php
    include('./style.php');
    ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php
    include('./switcher.php');
    ?>

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include('./partials/navbar.php') ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
                                Recordings</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recordings</li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </div>
                    </div>




                </div>
                <br>

                <div class="form-group col-md-4">
                    <select name="batch_id" required class="form-control form-select select2"
                        data-bs-placeholder="Select Batch">
                        <?php

                        $batch = mysqli_query($conn, "SELECT * FROM `batch`");
                        if (mysqli_num_rows($batch) > 0) {
                            while ($row = mysqli_fetch_assoc($batch)) {
                        ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['batch_name'] ?></option>
                        <?php
                            }
                        }

                        ?>
                    </select>
                </div>

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
                                                    type="text" name="recording_name" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Upload</label>
                                                <input class="form-control" id="dateMask" placeholder="MM/DD/YYYY"
                                                    type="date" name="Date_of_Upload" required>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Driving link</label>
                                                <input type="text" class="form-control" id="exampleInputcode"
                                                    placeholder="Enter driving link" name="Driving_link" required>
                                            </div>
                                        </div> <br>





                                    </div>
                                    <button type="submit" name="submitBtn" class="btn btn-info mt-3 mb-0"
                                        data-bs-target="#schedule" data-bs-toggle="modal"
                                        style="text-align:right">Upload Recording</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <!-- Container closed -->
        </form>
    </div>



    <div class="modal fade" id="schedule">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <p> Are you sure you want to upload a recording??</p>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button">Create</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not Now</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('./scripts.php');
    ?>

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