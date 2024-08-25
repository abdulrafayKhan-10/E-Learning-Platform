<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (!isset($_GET['task_id']) && empty($_GET['task_id'])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}
$id = filter_var(isset($_GET['task_id']), FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$query = mysqli_query($conn, "SELECT * FROM `batches_tasks` WHERE `id` = '$id'");
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
$fetch_tasks_details = mysqli_fetch_assoc($query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>View Tasks</title>

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
        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> View Task</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Batches Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">Task</li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>
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
                                <label for="exampleInputDOB">Name of the Task</label>
                                <input type="text" class="form-control" id="exampleInputName"
                                    name="batch_id" value="" hidden>
                                <input class="form-control" id="dateMask" placeholder="Name"
                                    type="text" name="Name_of_the_Task" value="<?php echo $fetch_tasks_details['task_name']?>" disabled required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dropdown">allocated Students Type</label>
                                <select id="dropdown" disabled onchange="showOptions1()"
                                    class="form-control form-select select2"
                                    data-bs-placeholder="Select Batch"
                                    name="allocated_Students_Type" required>
                                    <?php if($fetch_tasks_details['allocated_students_type'] == "All") {?>
                                    <option value="All"  selected>All</option>
                                    <option value="Individual">Individual</option>
                                    <?php } else {?>
                                        <option value="All" >All</option>
                                        <option value="Individual" selected>Individual</option>
                                    <?php } ?>
                                </select>
                            </div>
                                    </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputcode">Task Description</label>
                                <input type="text" class="form-control" id="exampleInputcode"
                                    placeholder="Task Description" value="<?php echo $fetch_tasks_details['task_description']?>" disabled name="Description" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputUserName">Task End Date</label>
                                <input class="form-control" id="dateMask" placeholder="" type="date"
                                    name="task_end_date"  value="<?php echo $fetch_tasks_details['task_end_date']?>" disabled required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputUserName">Batch Name</label>
                                <input class="form-control" id="dateMask" placeholder="" type="text"
                                    name="task_end_date"  value="<?php echo $fetch_tasks_details['batch_name']?>" disabled required>
                            </div>
                        </div>



                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="exampleInputcode"> Shared Documents</label>
                                <br>    
                                <a href="./assets/docs/supportive_docs/<?php echo $fetch_tasks_details['shared_documents']?>" target="_blank" download="" class="btn btn-primary mx-2">Download</a>
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