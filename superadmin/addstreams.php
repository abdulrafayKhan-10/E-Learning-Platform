<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["submit"])) {
    $location = $_POST["location"];
    $name = $_POST["name"];
    $image_name = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];

    $query = mysqli_prepare($conn, "INSERT INTO `stream`(`stream_name`, `stream_location`, `image`) VALUES (?,?,?)");
    $query->bind_param("sss", $name, $location, $image_name);
    if ($query->execute()) {
        $_SESSION['message_success'] = "Stream Added Successfully";
        move_uploaded_file($image_tmp, "./assets/img/stream/" . $image_name);
        header("location: addstreams.php");
        exit();
    } else {
        $_SESSION['message_failed'] = "Fill Correct Details.";
        $_SESSION["err_msg"] = "Unexpected Error. Please fill the correct details according to the required format.";
        header("location: addstreams.php");
        exit();
    }
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <title>Add Stream</title>

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php include("./switcher.php"); ?>

    <?php
    if (isset($_SESSION['message_success']) && !empty($_SESSION['message_success'])) {
        echo "<script>toastr.success('{$_SESSION["message_success"]}')</script>";
    }
    ?>

    <?php
    if (isset($_SESSION['message_failed']) && !empty($_SESSION['message_failed'])) {
        echo "<script>toastr.error('" . $_SESSION["err_msg"] . "')</script>";
    }
    session_destroy();
    ?>

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

        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Add Streams</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">General</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Streams</li>
                            <li class="breadcrumb-item active" aria-current="page">Add</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->



                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">


                                    <div class="">
                                        <div class="row row-xs formgroup-wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Stream Location</label>
                                                    <select name="location" class="form-control form-select select2"
                                                        data-bs-placeholder="Enter Stream">
                                                        <option value="courses">Courses</option>
                                                        <option value="internship">Internship</option>
                                                        <option value="placements">Placements</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">Stream Name</label>
                                                    <input name="name" type="text" class="form-control"
                                                        id="exampleInputPersonalPhone" placeholder="Enter stream name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Upload Image</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        name="image" placeholder="" required width="540" height="300">
                                                </div>
                                            </div>





                                        </div>
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-info mt-3 mb-0" style="text-align:right">Add Stream</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <!-- Container closed -->
        </div>


    </div>
    <!-- End Page -->

    <?php include("./scripts.php"); ?>

</body>

</html>