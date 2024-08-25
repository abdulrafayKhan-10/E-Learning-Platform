<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (isset($_GET['s_id'])) {
    $id = filter_var($_GET['s_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $query = "SELECT * FROM `batches_schedule` WHERE `id` = '$id'";
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
    $schedule = mysqli_fetch_assoc($run);

    if (!$id) {
        echo "Schedule not found!";
        exit();
    }

    if (isset($_POST['UpdateBtn'])) {
        // Updated code here is similar to the createcourse.php file

        // Retrieve updated values
        $scheduled_date = $_POST['scheduled_date'];
        $main_topic = $_POST['main_topic'];
        $Duration = $_POST['Duration'];
        $tasks = $_POST['tasks'];
        $Shared_Documents_name = $_FILES['Shared_Documents']['name'];
        $Shared_Documents_tmpname = $_FILES['Shared_Documents']['tmp_name'];
        $Topics_to_be_covered = $_POST['Topics_to_be_covered'];
        $Training_Starting_time = $_POST['Training_Starting_time'];
        $Training_Ending_time = $_POST['Training_Ending_time'];
        $batch_id = $_POST['batch_id'];
        if (empty($Shared_Documents_name)) {
            $Shared_Documents_name = $schedule["shared_documents"];
        }
        $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$batch_id'");
        $fetch_batch = mysqli_fetch_assoc($select_batch);
        if ($fetch_batch['id'] == $batch_id) {
            $batch_name = $fetch_batch['batch_name'];

            // Update query
            $update_query = "UPDATE `batches_schedule` SET `date_of_schedule`=?,`main_topic`=?,`class_duration`=?,`tasks`=?,`shared_documents`=?,`topics_to_be_covered`=?,`class_starting_time`=?,`class_ending_time`=?,`batch_id`=?,`batch_name`=? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            $update_stmt->bind_param(
                "ssssssssssi",
                $scheduled_date,
                $main_topic,
                $Duration,
                $tasks,
                $Shared_Documents_name,
                $Topics_to_be_covered,
                $Training_Starting_time,
                $Training_Ending_time,
                $batch_id,
                $batch_name,
                $id

            );

            if (mysqli_stmt_execute($update_stmt)) {
                move_uploaded_file($Shared_Documents_tmpname, "./assets/docs/supportive_docs/" . $Shared_Documents_name);
                $_SESSION['success'] = "Schedule updated successfully!";
                header("location: manageschedule.php");
                exit();
            } else {
                echo mysqli_error($conn);
            }

            mysqli_stmt_close($update_stmt);
        }
    }
} elseif (!isset($_GET["s_id"]) || empty($_GET["s_id"])) {
    echo "<script>alert('Error')</script>";
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
    <title>Update Schedule</title>

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
                                Schedule</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                                <li class="breadcrumb-item active" aria-current="page">Update</li>
                            </ol>
                        </div>
                    </div>


                    <br>
                    <div class="form-group col-md-4">
                        <select name="batch_id" required class="form-control form-select select2"
                            data-bs-placeholder="Select Batch">
                            <?php
                            if (isset($_GET['s_id'])) {
                                $id = $_GET['s_id'];
                                $sql = mysqli_query($conn, "SELECT * FROM `batches_schedule` WHERE id = '$id'");
                                $fetch_sql = mysqli_fetch_assoc($sql);
                                $selected_batch_id = $fetch_sql['batch_id'];


                                $trainer_id = $_COOKIE['trainer_id'];
                                $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE trainer_id = '$trainer_id'");
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
                                                    <label for="exampleInputDOB">Date of Schedule</label>
                                                    <input class="form-control" name="scheduled_date" id="dateMask"
                                                        placeholder="MM/DD/YYYY" type="date"
                                                        value="<?php echo $schedule['date_of_schedule'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">Main Topic</label>
                                                    <input type="text" class="form-control" name="main_topic"
                                                        id="exampleInputPersonalPhone" placeholder="Enter Main Topic"
                                                        required value="<?php echo $schedule['main_topic'] ?>">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Duration</label>
                                                    <input type="number" class="form-control" min="1" name="Duration"
                                                        id="exampleInputcode" placeholder="Enter Duration" required
                                                        value="<?php echo $schedule['class_duration'] ?>">
                                                </div>
                                            </div>




                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Tasks</label>
                                                    <select name="tasks" class="form-control form-select select2"
                                                        data-bs-placeholder="Select Batch" required>
                                                        <?php if ($schedule['tasks'] == 'Yes') { ?>
                                                        <option value="Yes" selected>Yes</option>
                                                        <option value="No">No</option>
                                                        <?php } ?>
                                                        <?php if ($schedule['tasks'] == 'No') { ?>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" selected>No</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Shared Documents</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        name="Shared_Documents" placeholder="" width="540" height="300">
                                                    <img src="./assets/docs/supportive_docs/<?php echo $schedule['shared_documents'] ?>"
                                                        width="300" height="300">
                                                    <p class="text-danger">Leave It Empty If You Want This Image.</p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Topics to be covered</label>
                                                    <input type="text" name="Topics_to_be_covered" class="form-control"
                                                        id="exampleInputAadhar" placeholder="Topics List" required
                                                        value="<?php echo $schedule['topics_to_be_covered'] ?>">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Class Starting Time</label>
                                                    <input name="Training_Starting_time" class="form-control"
                                                        id="start-date" placeholder="" type="time" required
                                                        value="<?php echo $schedule['class_starting_time'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Class Ending time </label>
                                                    <input name="Training_Ending_time" class="form-control"
                                                        id="end-date" placeholder="" type="time" required
                                                        value="<?php echo $schedule['class_ending_time'] ?>">
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
                                        <button type="submit" name="UpdateBtn" onclick="return checkDateRange()"
                                            class="btn btn-info mt-3 mb-0" data-bs-target="#schedule"
                                            data-bs-toggle="modal" style="text-align:right">Update Schedule</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Container closed -->
            </div>
            <!-- Container closed -->
        </form>
    </div>

    <!-- JS -->
    <?php include('./script.php'); ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>
</body>

</html>