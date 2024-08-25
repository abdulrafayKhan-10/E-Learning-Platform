<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST['create'])) {
    $course_name = mysqli_real_escape_string($conn, $_POST['name_of_the_course']);
    $stream = $_POST['stream'];
    $posting_category = mysqli_real_escape_string($conn, $_POST['posting_category']);
    $provider_name = mysqli_real_escape_string($conn, $_POST['provider_name']);
    $training_type = mysqli_real_escape_string($conn, $_POST['training_type']);
    $offline_address = mysqli_real_escape_string($conn, $_POST['offline_address']);
    $duration = $_POST['duration'];
    $last_date = $_POST['last_date'];
    $hours_perday = $_POST['hours_perday'];
    $certifications = mysqli_real_escape_string($conn, $_POST['certifications']);
    $no_of_slots = $_POST['no_of_slots'];
    $course_description = mysqli_real_escape_string($conn, $_POST['course_description']);
    $topics_covered = mysqli_real_escape_string($conn, $_POST['topics_covered']);
    $benefits = mysqli_real_escape_string($conn, $_POST['benefits']);
    $pre_requirements = mysqli_real_escape_string($conn, $_POST['pre_requirements']);
    $additional_information = mysqli_real_escape_string($conn, $_POST['additional_information']);
    $course_type = mysqli_real_escape_string($conn, $_POST['course_type']);
    $course_category_id = (int) $_POST['course_category_id'];
    $course_category_query = mysqli_query($conn, "SELECT * FROM `course_category` WHERE `id` = '$course_category_id'");
    $course_category = mysqli_fetch_assoc($course_category_query);
    $course_category_name = $course_category['category_name'];
    $original_cost = $_POST['original_cost'];
    $discount = $_POST['discount'];
    $final_cost = $_POST['final_cost'];
    $main_image_name = $_FILES['main_image']['name'];
    $main_image_tmp = $_FILES['main_image']['tmp_name'];
    $inner_image_name = $_FILES['inner_image']['name'];
    $inner_image_tmp = $_FILES['inner_image']['tmp_name'];
    $image2_name = $_FILES['image2']['name'];
    $image2_tmp = $_FILES['image2']['tmp_name'];

    $query = mysqli_prepare($conn, "INSERT INTO `course`(`course_name`, `stream_name`, `posting_category`, `provider_name_company`, `training_type`, `offline_address`, `duration_days`, `last_date_to_apply`, `hours_per_day`, `certification`, `slots`, `course_description`, `topics_covered`, `benefits_of_course`, `pre_requirements`, `additional_info`, `course_type`, `original_cost`, `discount_percentage`, `final_cost`, `main_image`, `inner_image`, `image_two`, `course_category_name`, `course_category_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($query, "sssssssssssssssssssssssss", $course_name, $stream, $posting_category, $provider_name, $training_type, $offline_address, $duration, $last_date, $hours_perday, $certifications, $no_of_slots, $course_description, $topics_covered, $benefits, $pre_requirements, $additional_information, $course_type, $original_cost, $discount, $final_cost, $main_image_name, $inner_image_name, $image2_name, $course_category_name, $course_category_id);


    if (mysqli_stmt_execute($query)) {
        $_SESSION["success"] = "Course created successfully!";

        move_uploaded_file($main_image_tmp, "./assets/img/course/" . $main_image_name);
        move_uploaded_file($inner_image_tmp, "./assets/img/course/" . $inner_image_name);
        move_uploaded_file($image2_tmp, "./assets/img/course/" . $image2_name);

        header("location: createcourse.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong!";
        header("location: createcourse.php");
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
    <title>Create Course</title>

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


        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Create Course</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Course</a></li>
                                <li class="breadcrumb-item " aria-current="page">Create</li>
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
                                        <h3>Overview</h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Name of the Course <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control required"
                                                    name="name_of_the_course" placeholder="Course Name" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Stream <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" required name="stream"
                                                    data-bs-placeholder="select qulification" required>
                                                    <?php
                                                    $select_query = "SELECT * FROM `stream`";

                                                    $select_query_run = mysqli_query($conn, $select_query);

                                                    if (mysqli_num_rows($select_query_run) > 0) {

                                                        while ($i = mysqli_fetch_assoc($select_query_run)) {

                                                            if ($i["stream_location"] == "courses") {

                                                    ?>
                                                    <option value="<?php echo $i["stream_name"] ?>">
                                                        <?php echo $i["stream_name"] ?>
                                                    </option>
                                                    <?php }
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Course Category<span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2"
                                                    name="course_category_id" data-bs-placeholder="Course Category"
                                                    required>
                                                    <?php
                                                    $select_query = mysqli_query($conn, "SELECT * FROM `course_category`");
                                                    if (mysqli_num_rows($select_query) > 0) {

                                                        while ($i = mysqli_fetch_assoc($select_query)) {

                                                    ?>
                                                    <option value="<?php echo $i["id"] ?>">
                                                        <?php echo $i["category_name"] ?>
                                                    </option>
                                                    <?php }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Posting Category <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="posting_category"
                                                    data-bs-placeholder="Posting Category" required>
                                                    <option value="self">Self</option>
                                                    <option value="others">others</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Provider name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="provider_name"
                                                    data-bs-placeholder="Select stream" required>
                                                    <?php
                                                    $query = "SELECT * FROM `trainer`";
                                                    $run_query = mysqli_query($conn, $query);
                                                    if ($run_query) {
                                                        while ($row = mysqli_fetch_assoc($run_query)) {
                                                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Training type <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="training_type"
                                                    data-bs-placeholder="Select training type" required>
                                                    <option value="VirtualLiveSession">Virtual Live Session</option>
                                                    <option value="Offline">Offline</option>
                                                    <option value="Hybrid">Hybrid</option>
                                                    <option value=" VirtualRecordedSessions"> Virtual Recorded Sessions
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Offline address ( if offline ) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input class="form-control required" name="offline_address"
                                                    placeholder="Offline address">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Duration(Days) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control required" name="duration"
                                                    placeholder="Duration(Days)" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Last date to apply <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="date" class="form-control required" name="last_date"
                                                    placeholder="DD/MM/YYYY" required>
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Hours per day <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control required" name="hours_perday"
                                                    placeholder="Hours" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Certification <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="certifications"
                                                    data-bs-placeholder="yes/no" required>
                                                    <option value="yes">yes</option>
                                                    <option value="no">no</option>

                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">No of Slots available <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control required" name="no_of_slots"
                                                    placeholder="Seating Count" required>
                                            </div>

                                        </section>
                                        <h3> Full information</h3>
                                        <section>

                                            <label class="form-label">Course Description <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="description"
                                                    name="course_description" required>
                                            </div>
                                            <label class="form-label">Topics Covered <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="topics covered"
                                                    name="topics_covered" required>
                                            </div>
                                            <label class="form-label">Benefits of Course <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="benefits"
                                                    name="benefits" required>
                                            </div>

                                            <label class="form-label">Pre-Requirements <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Optional) </span></label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="pre-requirements"
                                                    name="pre_requirements">
                                            </div>
                                            <label class="form-label">Additional information <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Optional)</span></label>
                                            <div class="form-label">
                                                <input type="text" class="form-control"
                                                    placeholder="additional information" name="additional_information">
                                            </div>
                                        </section>
                                        <h3>Pricings </h3>
                                        <section>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Course type <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="course_type"
                                                    data-bs-placeholder="Paid /free" required>
                                                    <option value="paid">paid</option>
                                                    <option value="free">Free</option>

                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Orginal Cost <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" name="original_cost"
                                                    placeholder="0,000 INR" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Discount % <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" name="discount"
                                                    placeholder="0-100 %" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Final cost <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" name="final_cost"
                                                    placeholder="0,000 INR" required>
                                            </div>
                                        </section>
                                        <h3>Uploadings </h3>
                                        <section>

                                            <div class="control-group form-group">
                                                <label class="form-label">Main Image (1200px*800px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" class="form-control" name="main_image"
                                                    placeholder="Choose File" width="540" height="300" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Inner image (600px*600px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" class="form-control" name="inner_image"
                                                    placeholder="Choose File" width="540" height="300" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">image2(1200px*800px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" class="form-control" name="image2"
                                                    placeholder="Choose File" width="540" height="300" required>
                                            </div>
                                        </section>
                                        <button name="create" value="submit" type="submit"
                                            class="btn btn-primary mt-3 mb-0" style="text-align:right">Finish</button>

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