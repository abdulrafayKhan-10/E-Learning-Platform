<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (isset($_POST['createBtn'])) {

    $company_name = $_POST['company_name'];
    $job_role = $_POST['job_role'];
    $salary = $_POST['salary'];
    $industry = $_POST['industry'];
    $experience =  $_POST['experience'];
    $workmode = $_POST['workmode'];
    $years_of_experience = $_POST['years_of_experience'];
    $eligibility = $_POST['eligibility'];
    $location = $_POST['location'];
    $jobtype = $_POST['eligibility'];
    $preffered_for = $_POST['preffered_for'];
    $number_of_vacancies = $_POST['number_of_vacancies'];
    $last_date = $_POST['last_date'];
    $full_description = $_POST['full_description'];
    $requirements = $_POST['requirements'];
    $additional_information = $_POST['additional_information'];
    $food_allowance = $_POST['food_allowance'];
    $transport_allowance = $_POST['transport_allowance'];
    $espf = $_POST['espf'];
    $main_image_name = $_FILES['main_image']['name'];
    $main_image_tmpname = $_FILES['main_image']['tmp_name'];
    $main_image_with_date = date('Y-m-d-H-s') . $main_image_name;
    $main_image_path = "./assets/img/placement/" . $main_image_with_date;

    $inner_image_name = $_FILES['inner_image']['name'];
    $inner_image_tmpname = $_FILES['inner_image']['tmp_name'];
    $inner_image_with_date = date('Y-m-d-H-s') . $inner_image_name;
    $inner_image_path = "./assets/img/placement/" . $inner_image_with_date;

    $image2_name = $_FILES['image2']['name'];
    $image2_tmpname = $_FILES['image2']['tmp_name'];
    $image2_with_date = date('Y-m-d-H-s') . $image2_name;
    $image2_path = "./assets/img/placement/" . $image2_with_date;


    $insert_query = mysqli_prepare($conn, "INSERT INTO `placement`(`company_name`, `job_role`, `salary`, `industry`, `experience`, `work_mode`, `years_open_experience`, `eligibility`, `location`, `job_type`, `gender`, `vacancies`, `last_date_to_apply`, `full_description`, `requirements`, `additional_info`, `food_allowances`, `transport_allowances`, `esi`, `main_image`, `inner_image`, `image_two`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $insert_query->bind_param("ssssssssssssssssssssss", $company_name, $job_role, $salary, $industry, $experience, $workmode, $years_of_experience, $eligibility, $location, $jobtype, $preffered_for, $number_of_vacancies, $last_date, $full_description, $requirements, $additional_information, $food_allowance, $transport_allowance, $espf, $main_image_with_date, $inner_image_with_date, $image2_with_date);
    if ($insert_query->execute()) {
        $_SESSION['message_success'] = true;
        move_uploaded_file($main_image_tmpname, $main_image_path);
        move_uploaded_file($inner_image_tmpname, $inner_image_path);
        move_uploaded_file($image2_tmpname, $image2_path);
        header("location: addplacements.php");
    } else {
        $_SESSION['message_failed'] = true;
        $_SESSION["err_msg"] = "Fill Correct Details.";
    }
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Add Placement</title>

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php include("./switcher.php"); ?>

    <?php
    if (isset($_SESSION['message_success']) && $_SESSION['message_success'] == true) {
        echo "<script>toastr.success('Placement Added!')</script>";
        session_destroy();
    }
    ?>

    <?php
    if (isset($_SESSION['message_failed']) && $_SESSION['message_failed'] == true) {
        echo "<script>toastr.error('" . $_SESSION["err_msg"] . "')</script>";
        session_destroy();
    }
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
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Placement</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Placement</a></li>
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
                                                <label class="form-label">Company Name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>

                                                <input type="text" name="company_name" class="form-control required"
                                                    placeholder="Company Name" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Job Role <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" name="job_role" class="form-control required"
                                                    placeholder="Role" required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Salary <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" name="salary" class="form-control required"
                                                    placeholder="Enter Salary" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Industry <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="industry" class="form-control form-select select2"
                                                    data-bs-placeholder="Select Stream" required>

                                                    <option value="Information Technology">Information Technology
                                                    </option>
                                                    <option value="Non IT">Non IT</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Pharmaceuticals">Pharmaceuticals</option>
                                                    <option value="Management">Management</option>
                                                    <option value="Management">Event</option>

                                                </select>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Experience <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="experience" class="form-control form-select select2"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Fresher">Fresher</option>
                                                    <option value="Experience">Experience</option>
                                                    <option value="Both">Both</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Work Mode <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="workmode" class="form-control form-select select2"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="WorkfromHome">Work from Home</option>
                                                    <option value="WorkFromoffice">Work From office</option>
                                                    <option value="Hybrid">Hybrid</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Years of Experience <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" name="years_of_experience"
                                                    class="form-control required" placeholder="Experience" required>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Eligibility <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="eligibility" class="form-control form-select select2"
                                                    data-bs-placeholder="Select Eligibility" required>
                                                    <option value="UnderGraduate">Under Graduate</option>
                                                    <option value="Graduate">Graduate</option>
                                                    <option value="Post Graduate">Post Graduate</option>




                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Location <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" name="location" class="form-control required"
                                                    placeholder="Enter Location" required>
                                            </div>
                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Job Type <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="jobtype" class="form-control form-select select2"
                                                    data-bs-placeholder="Select Type" required>
                                                    <option value="FullTime">Full Time</option>
                                                    <option value="PartTime">Part Time</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Preferred For <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="preffered_for" class="form-control form-select select2"
                                                    data-bs-placeholder="Select Eligibility" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Both">Both</option>
                                                </select>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Number of Vaccancies <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" name="number_of_vacancies"
                                                    class="form-control required" placeholder="Vaccancies Count"
                                                    required>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Last Date to apply <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="date" name="last_date" class="form-control required"
                                                    placeholder="Vaccancies Count" required>
                                            </div>



                                        </section>
                                        <h3> Full information</h3>
                                        <section>

                                            <label class="form-label">Full Description <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                            <div class="form-label">
                                                <input type="text" name="full_description" class="form-control"
                                                    placeholder="Textarea" required>
                                            </div>


                                            <label class="form-label">Requirements <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                    style="color:red;font-size: 90%;">*</span><span
                                                    style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                            <div class="form-label">
                                                <input type="text" name="requirements" class="form-control"
                                                    placeholder="Textarea" required>
                                            </div>

                                            <label class="form-label">Additional information <span
                                                    style="color:#D3D3D3;font-size: 90%;">(Optional)</span></label>
                                            <div class="form-label">
                                                <input type="text" name="additional_information" class="form-control"
                                                    placeholder="Textarea">
                                            </div>

                                        </section>
                                        <h3>Facilities </h3>
                                        <section>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Food Allowances <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="food_allowance" class="form-control form-select select2"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">Transport Allowances <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="transport_allowance"
                                                    class="form-control form-select select2"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>

                                            <div class="control-group form-group mb-2">
                                                <label class="form-label">ESI/PF <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select name="espf" class="form-control form-select select2"
                                                    data-bs-placeholder="Yes/No" required>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>

                                        </section>

                                        <h3>Uploadings </h3>
                                        <section>

                                            <div class="control-group form-group">
                                                <label class="form-label">Main Image (1200px*800px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" name="main_image" class="form-control"
                                                    placeholder="Choose File" required width="540" height="300">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Inner image (600px*600px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" name="inner_image" class="form-control"
                                                    placeholder="Choose File" required width="540" height="300">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">image2(1200px*800px) <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="file" name="image2" class="form-control required"
                                                    placeholder="Choose File" required width="540" height="300">
                                            </div>
                                        </section>
                                        <button name="createBtn" value="submit" type="submit"
                                            class="btn btn-primary mt-3 mb-0" onclick="return check()"
                                            style="text-align:right">Generate</button>
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
</body>

</html>