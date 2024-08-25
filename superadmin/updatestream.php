<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
        exit();
    }
}

if (isset($_POST["update"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $location = $_POST["location"];
    $name = $_POST["name"];

    if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
        $image_name = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];
    } else {
        $image_name = $_POST["old_image"];
    }



    if (empty($image_name)) {
        $query = mysqli_prepare($conn, "UPDATE `stream` SET `stream_name`=?,`stream_location`=? WHERE `id`='$id'");
        $query->bind_param("ss", $name, $location);
        if ($query->execute()) {
            $_SESSION['message_success'] = true;
            header("location: managestreams.php");
        } else {
            $_SESSION['message_failed'] = true;
            $_SESSION["err_msg"] = "Unexpected Error. Please fill the correct details according to the required format.";
        }
    }

    $query = mysqli_prepare($conn, "UPDATE `stream` SET `stream_name`=?,`stream_location`=?,`image`=? WHERE `id`='$id'");
    $query->bind_param("sss", $name, $location, $image_name);
    if ($query->execute()) {
        $_SESSION['message_success'] = "Stream Updated Successfully";
        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            move_uploaded_file($image_tmp, "./assets/img/stream/" . $image_name);
        }
        header("location: managestreams.php");
        exit();
    } else {
        $_SESSION['message_failed'] = "Fill Correct Details.";
        $_SESSION["err_msg"] = "Unexpected Error. Please fill the correct details according to the required format.";
        header("location: managestreams.php");
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
    <title>Update Stream</title>

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
                                        <?php
                                        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
                                        $id = (int) $id;
                                        $query = mysqli_query($conn, "SELECT * FROM `stream` WHERE `id`='$id'");
                                        $fetch = mysqli_fetch_assoc($query);
                                        ?>
                                        <div class="row row-xs formgroup-wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">Stream Location</label>
                                                    <select name="location" class="form-control form-select select2"
                                                        data-bs-placeholder="Enter Stream">
                                                        <?php
                                                        switch ($fetch['stream_location']) {
                                                            case 'courses':
                                                                echo '<option value="courses" selected>Courses</option>
                                                                        <option value="internship">Internship</option>
                                                                        <option value="placements">Placements</option>';
                                                                break;
                                                            case 'internship':
                                                                echo '<option value="courses">Courses</option>
                                                                        <option value="internship" selected>Internship</option>
                                                                        <option value="placements">Placements</option>';
                                                                break;
                                                            case 'placements':
                                                                echo '<option value="courses">Courses</option>
                                                                        <option value="internship">Internship</option>
                                                                        <option value="placements" selected>Placements</option>';
                                                                break;
                                                            default:
                                                                echo '<option value="courses">Courses</option>";
                                                                        <option value="internship">Internship</option>
                                                                        <option value="placements">Placements</option>';
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">Stream Name</label>
                                                    <input name="name" type="text" class="form-control"
                                                        id="exampleInputPersonalPhone"
                                                        value="<?php echo $fetch['stream_name']; ?>"
                                                        placeholder="Enter stream name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Upload Image</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        name="image" placeholder="" width="540" height="300">
                                                    <img src="./assets/img/stream/<?php echo $fetch['image']; ?>">
                                                    <p class="text-danger">Leave It Empty If You Want This Image.</p>

                                                    <input type="hidden" name="old_image"
                                                        value="<?php echo $fetch['image']; ?>">
                                                </div>
                                            </div>





                                        </div>
                                        <button type="submit" value="submit" name="update"
                                            class="btn btn-info mt-3 mb-0" style="text-align:right">Update
                                            Stream</button>
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