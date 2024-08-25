<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (!isset($_GET["id"])) {
    header('location:./manage_testimony.php');
    exit();
}

if (isset($_POST['update'])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;

    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $picture = null;

    if (!empty($_FILES['picture']['name'])) {
        $picture = htmlspecialchars(basename($_FILES['picture']['name']));
        $picture_tmp = $_FILES['picture']['tmp_name'];
    }

    // Check if there is a new picture to update
    if ($picture !== null) {
        $update_query = mysqli_prepare($conn, "UPDATE `testimonials` SET `name`=?, `picture`=?, `message`=?, `rating`=? WHERE `id`=?");
        $update_query->bind_param("ssssi", $student_name, $picture, $message, $rating, $id);
    } else {
        // No new picture, update without modifying the picture column
        $update_query = mysqli_prepare($conn, "UPDATE `testimonials` SET `name`=?, `message`=?, `rating`=? WHERE `id`=?");
        $update_query->bind_param("sssi", $student_name, $message, $rating, $id);
    }

    if ($update_query->execute()) {
        // If a new picture is provided, move it to the destination folder
        if ($picture !== null) {
            move_uploaded_file($picture_tmp, "./assets/img/testimonial/" . $picture);
        }

        $_SESSION['success'] = "Testimonial Updated Successfully.";
        header('location: manage_testimony.php');
        exit();
    } else {
        $_SESSION["error"] = "Failed to update.";
        header('location: manage_testimony.php');
        exit();
    }
}

$id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Testimonial</title>
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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Testimony</a></li>
                                <li class="breadcrumb-item" aria-current="page">Update</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->

                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="wizard3">
                                        <h3>Create</h3>
                                        <section>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM `testimonials` WHERE `id` = '$id' ");
                                            if (mysqli_num_rows($query) > 0) {
                                                $row = mysqli_fetch_array($query);
                                            ?>
                                            <div class="control-group form-group">
                                                <label class="form-label">Student Name</label>
                                                <input type="text" name="student_name" class="form-control required"
                                                    placeholder="Student Name" value="<?php echo $row['name']; ?>"
                                                    required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Message</label>
                                                <input type="text" name="message" class="form-control required"
                                                    placeholder="Message" value="<?php echo $row['message']; ?>"
                                                    required>
                                            </div>
                                            <div class=" range-container">
                                                <label class="range-label">Rating:</label>
                                                <span id="rangeValue"
                                                    class="range-value"><?php echo $row['rating']; ?></span>
                                            </div>
                                            <div class="control-group form-group">
                                                <input type="range" min="1" max="5" name="rating"
                                                    class="form-range required" placeholder="Rating" step="0.5" required
                                                    value="<?php echo $row['rating']; ?>"
                                                    oninput="updateRangeValue(this.value)">
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Picture</label>
                                                <input type="file" name="picture" class="form-control"
                                                    placeholder="Picture">
                                                <img src="./assets/img/testimonial/<?php echo $row['picture']; ?>"
                                                    alt="<?php echo $row['picture']; ?>" width="120px">
                                            </div>
                                        </section>
                                        <button name="update" value="submit" type="submit"
                                            class="btn btn-primary mt-3 mb-0" onclick="return check()"
                                            style="text-align:right">Update</button>
                                        <?php } ?>
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
</body>

</html>