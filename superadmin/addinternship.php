<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["create"])) {
    $company_name = mysqli_real_escape_string($conn, $_POST["company_name"]);
    $internship_title = mysqli_real_escape_string($conn, $_POST["internship_title"]);
    $industry = mysqli_real_escape_string($conn, $_POST["industry"]);
    $duration = mysqli_real_escape_string($conn, $_POST["duration"]);
    $eligibility = mysqli_real_escape_string($conn, $_POST["eligibility"]);
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
    $internship_category = mysqli_real_escape_string($conn, $_POST["internship_category"]);
    $preferred_for = mysqli_real_escape_string($conn, $_POST["preferred_for"]);
    $number_of_vacancies = mysqli_real_escape_string($conn, $_POST["number_of_vacancies"]);
    $last_date_to_apply = mysqli_real_escape_string($conn, $_POST["last_date_to_apply"]);
    $certification = mysqli_real_escape_string($conn, $_POST["certification"]);
    $full_description = mysqli_real_escape_string($conn, $_POST["full_description"]);
    $pre_requirements = mysqli_real_escape_string($conn, $_POST["pre_requirements"]);
    $additional_information = mysqli_real_escape_string($conn, $_POST["additional_information"]);
    $internship_type = mysqli_real_escape_string($conn, $_POST["internship_type"]);
    $enter_value_ifpaid = mysqli_real_escape_string($conn, $_POST["enter_value_ifpaid"]);
    $enter_value_ifstifund = mysqli_real_escape_string($conn, $_POST["enter_value_ifstifund"]);
    $food_allowances = mysqli_real_escape_string($conn, $_POST["food_allowances"]);
    $transport_allowances = mysqli_real_escape_string($conn, $_POST["transport_allowances"]);

    // File uploads require additional handling
    $main_image = htmlspecialchars(basename($_FILES["main_image"]["name"]));
    $main_image_tmp = $_FILES["main_image"]["tmp_name"];
    $inner_image = htmlspecialchars(basename($_FILES["inner_image"]["name"]));
    $inner_image_tmp = $_FILES["inner_image"]["tmp_name"];

    $query = mysqli_prepare($conn, "INSERT INTO `internship` (`internship`, `company_name`, `industry`, `duration_days`, `eligibility`, `location`, `internship_category`, `gender`, `vacancies`, `last_date_to_apply`, `certification`, `full-description`, `pre-requirements`, `additional_info`, `internship_type`, `salary`, `stifund`, `food_allowances`, `transport_allowances`, `main_image`, `inner_image`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    if ($query === false) {
        die(mysqli_error($conn));  // Print the error for debugging purposes
    }
    $query->bind_param("sssssssssssssssssssss", $internship_title, $company_name, $industry, $duration, $eligibility, $location, $internship_category, $preferred_for, $number_of_vacancies, $last_date_to_apply, $certification, $full_description, $pre_requirements, $additional_information, $internship_type, $enter_value_ifpaid, $enter_value_ifstifund, $food_allowances, $transport_allowances, $main_image, $inner_image);



    if ($query->execute()) {
        $_SESSION['success'] = "Internship Added Successfully.";
        move_uploaded_file($main_image_tmp, "./assets/img/internship/" . $main_image);
        move_uploaded_file($inner_image_tmp, "./assets/img/internship/" . $inner_image);
        header("location: addinternship.php");
        exit();
    } else {
        $_SESSION['error'] = "Fill Correct Details.";
        header("location: addinternship.php");
        exit();
    }
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <title>Add Internship</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

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
        <form method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Internship</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Internship</a></li>
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
                                        <h3>Overview</h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control" name="company_name"
                                                    placeholder="Company Name" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Internship Title</label>
                                                <input type="text" class="form-control" name="internship_title"
                                                    placeholder="Title" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Industry</label>
                                                <select class="form-control form-select select2" name="industry"
                                                    data-bs-placeholder="Select Stream" required>
                                                    <option value="Information Technology">Information Technology
                                                    </option>
                                                    <option value="Non IT">Non IT</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Pharmaceuticals">Pharmaceuticals</option>
                                                    <option value="Management">Management</option>
                                                    <option value="event">Event</option>
                                                    <!-- <option value="TESTING">TESTING</option>
                                                    <option value="sample dinesh">sample dinesh</option> -->
                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Duration(Days)</label>
                                                <input type="number" class="form-control" name="duration"
                                                    placeholder="Duration(Days)" required>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Eligibility</label>
                                                <select class="form-control form-select select2" name="eligibility"
                                                    data-bs-placeholder="Select Eligibility" required>
                                                    <option value="Under Graduate">Under Graduate</option>
                                                    <option value="Graduate">Graduate</option>
                                                    <option value="Post Graduate">Post Graduate</option>




                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Location</label>
                                                <input type="" class="form-control" name="location"
                                                    placeholder="Enter Location" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Internship Category</label>
                                                <select class="form-control form-select select2"
                                                    name="internship_category" data-bs-placeholder="Select Category"
                                                    required>
                                                    <option value="Virtual">Virtual</option>
                                                    <option value="Offline">Offline</option>
                                                    <option value="Hybrid (Dual)">Hybrid (Dual)</option>

                                                </select>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Preferred For</label>
                                                <select class="form-control form-select select2" name="preferred_for"
                                                    data-bs-placeholder="Select Eligibility" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Both">Both</option>
                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Number of Vacancies</label>
                                                <input type="number" class="form-control" name="number_of_vacancies"
                                                    placeholder="Vacancies Count" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Last Date to apply</label>
                                                <input type="date" class="form-control" name="last_date_to_apply"
                                                    placeholder="DD/MM/YYYY" required>
                                            </div>



                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Certification</label>
                                                <select class="form-control form-select select2" name="certification"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>


                                        </section>
                                        <h3> Full information</h3>
                                        <section>

                                            <label class="form-label">Full Description</label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="Textarea"
                                                    name="full_description" required>
                                            </div>


                                            <label class="form-label"> pre-Requirements</label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="Textarea"
                                                    name="pre_requirements" required>
                                            </div>

                                            <label class="form-label">additional information</label>
                                            <div class="form-label">
                                                <input type="text" class="form-control" placeholder="Textarea"
                                                    name="additional_information" required>
                                            </div>

                                        </section>
                                        <h3>Pricings </h3>
                                        <section>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Internship type</label>
                                                <select class="form-control form-select select2" name="internship_type"
                                                    data-bs-placeholder="Internship Type" required>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Free">Free</option>
                                                    <option value="Stipend">Stipend</option>
                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Enter Value (if paid)</label>
                                                <input type="number" class="form-control" name="enter_value_ifpaid"
                                                    placeholder="0,000/-">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Enter Value (if stifund)</label>
                                                <input type="number" class="form-control" name="enter_value_ifstifund"
                                                    placeholder="0,000/-">
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Food Allowances</label>
                                                <select class="form-control form-select select2" name="food_allowances"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Transport Allowances</label>
                                                <select class="form-control form-select select2"
                                                    name="transport_allowances" data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>

                                        </section>
                                        <h3>Uploadings </h3>
                                        <section>

                                            <div class="control-group form-group">
                                                <label class="form-label">Main Image (1200px*800px)</label>
                                                <input type="file" class="form-control" name="main_image"
                                                    placeholder="Choose File" required width="540" height="300">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Inner image (600px*600px)</label>
                                                <input type="file" class="form-control" name="inner_image"
                                                    placeholder="Choose File" required width="540" height="300">
                                            </div>

                                        </section>
                                        <button type="submit" name="create" value="create"
                                            class="btn btn-primary mt-3 mb-0" style="text-align:right"
                                            onclick="return check()">Create</button>

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
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>
</body>

</html>