<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (!isset($_GET['s_id']) && empty($_GET['s_id'])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
$id = filter_var(isset($_GET['s_id']), FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$query = mysqli_query($conn, "SELECT * FROM `batches_schedule` WHERE `id` = '$id'");
if (mysqli_num_rows($query) == 0) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
$fetch_schedule_details = mysqli_fetch_assoc($query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>View Schedule</title>

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.alert('" . $_SESSION["error"] . "')</script>";
    } ?>
    <?php include("./switcher.php") ?>
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
        <div class="main-content app-content">

<!-- container -->
<div class="main-container container-fluid">


    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> View
                Schedule</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
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
                                    <label for="exampleInputDOB">Date of Schedule</label>
                                    <input class="form-control" name="scheduled_date" id="dateMask"
                                        placeholder="MM/DD/YYYY" type="date" required value="<?php echo $fetch_schedule_details['date_of_schedule'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPersonalPhone">Main Topic</label>
                                    <input type="text" class="form-control" name="main_topic"
                                        id="exampleInputPersonalPhone" placeholder="Enter Main Topic"
                                        required value="<?php echo $fetch_schedule_details['main_topic'] ?>" disabled>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputcode">Duration</label>
                                    <input type="number" class="form-control" min="1" name="Duration"
                                        id="exampleInputcode" placeholder="Enter Duration" required value="<?php echo $fetch_schedule_details['class_duration'] ?>" disabled>
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputAadhar">Tasks</label>
                                    <select name="tasks" class="form-control form-select select2"
                                        data-bs-placeholder="Select Batch" required disabled>
                                        <?php if($fetch_schedule_details['tasks'] == 'Yes') {?>
                                                        <option value="Yes" selected >Yes</option>
                                                        <option value="No">No</option>
                                                        <?php }?>
                                                        <?php if($fetch_schedule_details['tasks'] == 'No') {?>
                                                        <option value="Yes" >Yes</option>
                                                        <option value="No" selected>No</option>
                                                        <?php }?>
                                     
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputcode"> Shared Documents</label>
                                    <input type="file" name="Shared_Documents" class="form-control"
                                        id="exampleInputcode" placeholder="" value="<?php echo $fetch_schedule_details['shared_documents'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputAadhar">Topics to be covered</label>
                                    <input type="text" name="Topics_to_be_covered" class="form-control"
                                        id="exampleInputAadhar" placeholder="Topics List" required value="<?php echo $fetch_schedule_details['topics_to_be_covered'] ?>" disabled>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUserName">Class Starting Time</label>
                                    <input name="Training_Starting_time" class="form-control"
                                        id="start-date" placeholder="" type="time" required value="<?php echo $fetch_schedule_details['class_starting_time'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUserName">Class Ending time </label>
                                    <input name="Training_Ending_time" class="form-control"
                                        id="end-date" placeholder="" type="time" required value="<?php echo $fetch_schedule_details['class_ending_time'] ?>" disabled>
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
                      
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- Container closed -->
</div>
        <!-- Container closed -->
    </div>
    </div>


    <?php include("./script.php"); ?>

</body>

</html>