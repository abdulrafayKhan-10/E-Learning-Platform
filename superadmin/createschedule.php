<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["submit"])) {
    $batch_id = (int) $_POST["batch_id"];
    $date_of_training = $_POST["date_of_training"];
    $training_title = $_POST["training_title"];
    $durations = $_POST["durations"];
    $tasks = $_POST["tasks"];
    $shared_documents = $_FILES["shared_documents"]["name"];
    $topics_to_be_covered = $_POST["topics_to_be_covered"];
    $training_starting_time = $_POST["training_starting_time"];
    $training_ending_time = $_POST["training_ending_time"];

    $shared_documents_temp_name = $_FILES["shared_documents"]["tmp_name"];

    $shared_documents_folder = "../Trainer/assets/docs/shared_document/" . $shared_documents;

    $batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `id` = '$batch_id'");
    $batch = mysqli_fetch_assoc($batch_query);

    if ($batch["id"] == $batch_id) {
        $batch_name = $batch["batch_name"];
        $insert_query = mysqli_prepare($conn, "INSERT INTO `batches_schedule`(`batch_name`, `batch_id`, `main_topic`, `class_duration`, `date_of_schedule`, `tasks`, `shared_documents`, `topics_to_be_covered`, `class_starting_time`, `class_ending_time`) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $insert_query->bind_param("ssssssssss", $batch_name, $batch_id, $training_title, $durations, $date_of_training, $tasks, $shared_documents, $topics_to_be_covered, $training_starting_time, $training_ending_time);
        if ($insert_query->execute()) {
            $_SESSION["success"] = "Batch scheduled successfully";
            move_uploaded_file($shared_documents_temp_name, $shared_documents_folder);
            header("location:./createschedule.php");
            exit();
        } else {
            $_SESSION["error"] = "Something went wrong";
            header("location:./createschedule.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <title>Create Schedule</title>
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
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
                                Schedule</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->

                    <div class="row row-sm">

                        <div class="form-group col-md-4">
                            <select name="batch_id" required class="form-control form-select select2"
                                data-bs-placeholder="Select Batch">
                                <?php
                                $batch = mysqli_query($conn, "SELECT * FROM `batch`");
                                if (mysqli_num_rows($batch) > 0) {
                                    while ($row = mysqli_fetch_assoc($batch)) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= $row['batch_name'] ?></option>
                                <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>

                    </div>
                    <br>



                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">


                                    <div class="">
                                        <div class="row row-xs formgroup-wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputDOB">Date of Schedule </label>
                                                    <input class="form-control" name="date_of_training" id="dateMask"
                                                        placeholder="MM/DD/YYYY" type="date" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone"> Main Topic </label>
                                                    <input type="text" class="form-control" name="training_title"
                                                        id="exampleInputPersonalPhone" placeholder="Enter Main Topic"
                                                        required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Class Duration</label>
                                                    <input type="number" class="form-control" min="1" name="durations"
                                                        id="exampleInputcode" placeholder="Enter Duration" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Tasks</label>
                                                    <select name="tasks" class="form-control form-select select2"
                                                        data-bs-placeholder="Select Batch" required>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Shared Documents</label>
                                                    <input type="file" name="shared_documents" class="form-control"
                                                        id="exampleInputcode" placeholder="" required>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Topics to be covered</label>
                                                    <input type="text" name="topics_to_be_covered" class="form-control"
                                                        id="exampleInputAadhar" placeholder="Topics List" required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Class Starting time</label>
                                                    <input name="training_starting_time" class="form-control"
                                                        id="start-date" placeholder="" type="time" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Class Ending time </label>
                                                    <input name="training_ending_time" class="form-control"
                                                        id="end-date" placeholder="" type="time" required>
                                                    <div id="message" style="color:red"></div>
                                                </div>
                                            </div>

                                            <!-- <script>
                                                function checkDateRange() {
                                                    const startDate = new Date(document.getElementById("start-date").value);
                                                    const endDate = new Date(document.getElementById("end-date").value);

                                                    if (startDate < endDate) {
                                                        document.getElementById("message").textContent = "";
                                                        return true;
                                                    } else {
                                                        document.getElementById("message").textContent =
                                                            "Start date is greater than or equal to end date.";
                                                        return false;
                                                    }
                                                }
                                            </script> -->

                                        </div>
                                        <button type="submit" name="submit" onclick="return checkDateRange()"
                                            class="btn btn-info mt-3 mb-0" style="text-align:right">Schedule</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Container closed -->
            </div>
        </form>



    </div>
    <!-- End Page -->

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