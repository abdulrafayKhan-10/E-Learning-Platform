<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}

if (!isset($_GET['r_id']) && empty($_GET['r_id'])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
$id = filter_var(isset($_GET['r_id']), FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$query = mysqli_query($conn, "SELECT * FROM `batches_recording` WHERE `id` = '$id'");
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
$fetch_recording_details = mysqli_fetch_assoc($query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>View Recording</title>

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
                                Recordings</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recordings</li>
                                <li class="breadcrumb-item active" aria-current="page">View</li>
                            </ol>
                        </div>
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
                                                <label for="exampleInputDOB">Recording Topic Name</label>
                                                <input class="form-control" placeholder="enter the recording name"
                                                    type="text" name="recording_name" value="<?php echo $fetch_recording_details['recording_topic_name']?>" required disabled >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Upload</label>
                                                <input class="form-control" id="dateMask" placeholder="MM/DD/YYYY"
                                                    type="date" name="Date_of_Upload" value="<?php echo $fetch_recording_details['date_of_upload']?>" required disabled>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Driving link</label>
                                                <input type="text" class="form-control" id="exampleInputcode"
                                                    placeholder="Enter driving link" value="<?php echo $fetch_recording_details['driving_link']?>" name="Driving_link" required disabled>
                                            </div>
                                        </div> <br>





                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> View
                                Recording</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recording</li>
                                <li class="breadcrumb-item active" aria-current="page">View</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->


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
                                                <label for="exampleInputDOB">Date of Summary</label>
                                                <input class="form-control" name="Date_of_Summary" id="dateMask"
                                                    placeholder="MM/DD/YYYY" type="date"
                                                    value="<?php echo $fetch_summary_details['date_of_summary']?>" required disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Performer of the day</label>
                                                <input type="text" name="Performer_of_the_day" class="form-control"
                                                    id="exampleInputPersonalPhone"
                                                    value="<?php echo $fetch_summary_details['performer_of_day']?>"
                                                    placeholder="Enter candidate name" required disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Topics Covered</label>
                                                <input type="text" name="Topics_Covered" class="form-control"
                                                    id="exampleInputAadhar"
                                                    value="<?php echo $fetch_summary_details['topics_covered']?>"
                                                    placeholder="Topics List" required disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Overall Feedback</label>
                                                <input type="text" name="Overall_Feedback" class="form-control"
                                                    id="exampleInputAadhar" placeholder="Feedback"
                                                    value="<?php echo $fetch_summary_details['overall_feedback']?>" required disabled>
                                            </div>
                                        </div>


                                    </div>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        <!-- Container closed -->
    </div>
    </div>


    <?php include("./scripts.php"); ?>

</body>

</html>