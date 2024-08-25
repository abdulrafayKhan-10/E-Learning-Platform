<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (isset($_POST['createBtn'])) {
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $picture = htmlspecialchars(basename($_FILES['picture']['name']));
    $picture_tmp = $_FILES['picture']['tmp_name'];


    $query = mysqli_prepare($conn, "INSERT INTO `testimonials`(`name`, `picture`, `message`, `rating`) VALUES (?,?,?,?)");
    $query->bind_param("ssss", $student_name, $picture, $message, $rating);

    if ($query->execute()) {
        $_SESSION["success"] = "Testimonial Added Successfully.";
        move_uploaded_file($picture_tmp, "./assets/img/testimonial/" . $picture);

        header('location: testimonial.php');
        exit();
    } else {

        $_SESSION["error"] = "Fill Correct Details.";
        header("location: testimonial.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Add Testimonial</title>
    <style>
    .range-container {
        display: flex;
        align-items: center;
    }

    .range-label {
        margin-right: 10px;
        font-size: 14px;
        color: #333;
    }

    .range-value {
        font-size: 16px;
        color: #007bff;
    }

    .form-range {
        width: 80%;
        margin-top: 10px;
    }
    </style>
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
                <?php include('./partials/sidebar.php'); ?>
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
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Testimonial</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Testimony</a></li>
                                <li class="breadcrumb-item " aria-current="page">Add</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->


                    <!-- /row -->

                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div id="wizard3">
                                        <h3>Create</h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Student Name<span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>

                                                <input type="text" name="student_name" class="form-control required"
                                                    placeholder="Student Name" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Message <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" name="message" class="form-control required"
                                                    placeholder="Message" required>
                                            </div>

                                            <div class="range-container">
                                                <label class="range-label">Rating:</label><span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span>
                                                <span id="rangeValue" class="range-value">3.0</span>
                                            </div>
                                            <div class="control-group form-group">
                                                <input type="range" min="1" max="5" name="rating"
                                                    class="form-range required" placeholder="Rating" step="0.5" required
                                                    oninput="updateRangeValue(this.value)">
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Picture <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" name="picture" class="form-control required"
                                                    placeholder="Picture" required>
                                            </div>

                                        </section>
                                        <button name="createBtn" value="submit" type="submit"
                                            class="btn btn-primary mt-3 mb-0" onclick="return check()"
                                            style="text-align:right">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row closed -->


                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->
        </form>


    </div>
    <!-- End Page -->

    <?php include("./scripts.php"); ?>

    <script>
    function updateRangeValue(value) {
        document.getElementById('rangeValue').textContent = value;
    }
    </script>

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