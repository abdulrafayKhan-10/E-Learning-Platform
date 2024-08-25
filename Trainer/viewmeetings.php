<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (!isset($_GET['id']) && empty($_GET['id'])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
$id = filter_var(isset($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$query = mysqli_query($conn, "SELECT * FROM `batches_meetings` WHERE `id` = '$id'");
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
$fetch_meeting_details = mysqli_fetch_assoc($query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>View Meetings</title>

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
          <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> View Meetings</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Meetings</li>
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
                                <label for="exampleInputDOB">Date of Meeting link</label>
                                <input class="form-control" name="date_of_meeting_link" id="dateMask" required disabled value="<?php echo $fetch_meeting_details['date_of_meeting_link']; ?>" type="date">
                            </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="form-group">
                        <label for="exampleInputAadhar">Platform</label>
                        <select name="Platform" required class="form-control form-select select2"  disabled>
                        <option value="<?php echo $fetch_meeting_details['platform']; ?>" selected><?php echo $fetch_meeting_details['platform']; ?></option>
                        
                        </select>
                            </div>
                            </div>
                                                                        
                            
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputcode">Meeting link</label>
                                <input type="text" required name="Meeting_link" value="<?php echo $fetch_meeting_details['meeting_link']; ?>" disabled class="form-control" id="exampleInputcode" >
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


    <?php include("./script.php"); ?>

</body>

</html>