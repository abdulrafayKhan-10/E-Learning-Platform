<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"])) {
    header('location: ./manageinternship.php');
    exit();
}

if (isset($_POST["Update"])) {
    $id = (int) $_POST["id"];
    $company_name = $_POST["company_name"];
    $internship = $_POST["internship"];
    $industry = $_POST["industry"];
    $duration = $_POST["duration"];
    $eligibility = $_POST["eligibility"];
    $location = $_POST["location"];
    $category = $_POST["category"];
    $gender = $_POST["gender"];
    $vacancies = $_POST["vacancies"];
    $last_date_to_apply = $_POST["last_date_to_apply"];
    $certification = $_POST["certification"];
    $full_description = $_POST["full_description"];
    $pre_requirements = $_POST["pre-requirements"];
    $additional_info = $_POST["additional_info"];
    $internship_type = $_POST["internship_type"];
    $food_allowances = $_POST["food_allowances"];
    $transport_allowances = $_POST["transport_allowances"];
    $salary = $_POST["salary"];
    $stifund = $_POST["stifund"];
    $main_image_old = $_POST["main_image_old"];
    $inner_image_old = $_POST["inner_image_old"];


    if (empty($_FILES["main_image"]["name"])) {
        $main_image = $main_image_old;
    } else {
        $main_image = $_FILES["main_image"]["name"];
        $main_image_tmp = $_FILES["main_image"]["tmp_name"];
    }

    if (empty($_FILES["inner_image"]["name"])) {
        $inner_image = $inner_image_old;
    } else {
        $inner_image = $_FILES["inner_image"]["name"];
        $inner_image_tmp = $_FILES["inner_image"]["tmp_name"];
    }

    $update_query = mysqli_prepare($conn, "UPDATE `internship` SET `internship`=?,`company_name`=?,`industry`=?,`duration_days`=?,`eligibility`=?,`location`=?,`internship_category`=?,`gender`=?,`vacancies`=?,`last_date_to_apply`=?,`certification`=?,`full-description`=?,`pre-requirements`=?,`additional_info`=?,`internship_type`=?,`salary`=?,`stifund`=?,`food_allowances`=?,`transport_allowances`=?,`main_image`=?,`inner_image`=? WHERE `id`=?");
    $update_query->bind_param("sssssssssssssssssssssi", $internship, $company_name, $industry, $duration, $eligibility, $location, $category, $gender, $vacancies, $last_date_to_apply, $certification, $full_description, $pre_requirements, $additional_info, $internship_type, $salary, $stifund, $food_allowances, $transport_allowances, $main_image, $inner_image, $id);
    if ($update_query->execute()) {
        $_SESSION["success"] = "Updated Successfully.";
        if ($main_image != $main_image_old) {
            move_uploaded_file($main_image_tmp, "./assets/img/internship/" . $main_image);
        }
        if ($inner_image != $inner_image_old) {
            move_uploaded_file($inner_image_tmp, "./assets/img/internship/" . $inner_image);
        }

        header('location: ./manageinternship.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>batches management</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php") ?>
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php") ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">Update Internship</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item " aria-current="page">Update</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->


                <!-- /row -->
                <form method="post" enctype="multipart/form-data">

                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                                    $id = (int) $id;
                                    $sql = "SELECT * FROM `internship` WHERE `id` = $id";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        $fetch = mysqli_fetch_assoc($result);

                                    ?>
                                        <input name="id" type="hidden" value="<?php echo $fetch['id']; ?>">
                                        <div id="wizard3">
                                            <h3>Overview</h3>
                                            <section>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" name="company_name" class="form-control" placeholder="Course Name" value="<?php echo $fetch['company_name']; ?>">
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Internship Title</label>
                                                    <input type="text" name="internship" class="form-control" placeholder="Title" value="<?php echo $fetch['internship']; ?>">
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Industry</label>

                                                    <select class="form-control form-select select2" name="industry">
                                                        <?php
                                                        switch ($fetch["industry"]) {
                                                            case "Information Technology":
                                                                echo "<option selected value='Information Technology'>Information Technology
                                                    </option>";
                                                                echo "<option value='Non IT'>Non IT</option>";
                                                                echo "<option value='Finance'>Finance</option>";
                                                                echo "<option value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option value='Event'>Event</option>";
                                                                break;
                                                            case "Non IT":
                                                                echo ' <option value="Information Technology">Information Technology
                                                    </option>';
                                                                echo "<option selected value='Non IT'>Non IT</option>";
                                                                echo "<option value='Finance'>Finance</option>";
                                                                echo "<option value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option value='Event'>Event</option>";
                                                                break;
                                                            case "Finance":
                                                                echo "<option value='Information Technology'>Information Technology </option>";
                                                                echo "<option value='Non IT'>Non IT</option>";
                                                                echo "<option selected value='Finance'>Finance</option>";
                                                                echo "<option value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option value='Event'>Event</option>";
                                                                break;
                                                            case "Pharmaceuticals":
                                                                echo "<option value='Information Technology'>Information Technology </option>";
                                                                echo "<option value='Non IT'>Non IT</option>";
                                                                echo "<option value='Finance'>Finance</option>";
                                                                echo "<option selected value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option value='Event'>Event</option>";
                                                                break;
                                                            case "Event":
                                                                echo "<option value='Information Technology'>Information Technology </option>";
                                                                echo "<option value='Non IT'>Non IT</option>";
                                                                echo "<option value='Finance'>Finance</option>";
                                                                echo "<option value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option selected value='Event'>Event</option>";
                                                                break;
                                                            default:
                                                                echo "<option value='Information Technology'>Information Technology </option>";
                                                                echo "<option selected value='Non IT'>Non IT</option>";
                                                                echo "<option value='Finance'>Finance</option>";
                                                                echo "<option value='Pharmaceuticals'>Pharmaceuticals</option>";
                                                                echo "<option value='Event'>Event</option>";
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Duration(Days)</label>
                                                    <input type="number" name="duration" class="form-control" placeholder="Duration(min)" value="<?php echo $fetch["duration_days"] ?>">
                                                </div>

                                                <div class="control-group form-group">
                                                    <label class="form-label">Eligibility</label>

                                                    <select class="form-control form-select select2" name="eligibility">
                                                        <?php
                                                        switch ($fetch["eligibility"]) {
                                                            case "Under Graduate":
                                                                echo "<option selected value='Under Graduate'>Under Graduate</option>";
                                                                echo "<option value='Graduate'>Graduate</option>";
                                                                echo "<option value='Post Graduate'>Post Graduate</option>";
                                                                break;
                                                            case "Graduate":
                                                                echo "<option value='Under Graduate'>Under Graduate</option>";
                                                                echo "<option selected value='Graduate'>Graduate</option>";
                                                                echo "<option value='Post Graduate'>Post Graduate</option>";
                                                                break;
                                                            case "Post Graduate":
                                                                echo "<option value='Under Graduate'>Under Graduate</option>";
                                                                echo "<option value='Graduate'>Graduate</option>";
                                                                echo "<option selected value='Post Graduate'>Post Graduate</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='Under Graduate'>Under Graduate</option>";
                                                                echo "<option value='Graduate'>Graduate</option>";
                                                                echo "<option value='Post Graduate'>Post Graduate</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" class="form-control" placeholder="Enter Location" value="<?php echo $fetch["location"] ?>">
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Internship Category</label>

                                                    <select class="form-control form-select select2" name="category">
                                                        <?php
                                                        switch ($fetch["internship_category"]) {
                                                            case "Virtual":
                                                                echo "<option selected value='Virtual'>Virtual</option>";
                                                                echo "<option value='Offline'>Offline</option>";
                                                                echo "<option value='Hybrid (Dual)'>Hybrid (Dual)</option>";
                                                                break;
                                                            case "Offline":
                                                                echo "<option value='Virtual'>Virtual</option>";
                                                                echo "<option selected value='Offline'>Offline</option>";
                                                                echo "<option value='Hybrid (Dual)'>Hybrid (Dual)</option>";
                                                                break;
                                                            case "Hybrid (Dual)":
                                                                echo "<option value='Virtual'>Virtual</option>";
                                                                echo "<option value='Offline'>Offline</option>";
                                                                echo "<option selected value='Hybrid (Dual)'>Hybrid (Dual)</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='Offline'>Offline</option>";
                                                                echo "<option value='Virtual'>Virtual</option>";
                                                                echo "<option value='Hybrid (Dual)'>Hybrid (Dual)</option>";
                                                                break;
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Preferred For</label>
                                                    <select class="form-control form-select select2" name="gender">

                                                        <?php
                                                        switch ($fetch["gender"]) {
                                                            case "Male":
                                                                echo "<option selected value='Male'>Male</option>";
                                                                echo "<option value='Female'>Female</option>";
                                                                echo "<option value='Both'>Both</option>";
                                                                break;
                                                            case "Female":
                                                                echo "<option value='Male'>Male</option>";
                                                                echo "<option selected value='Female'>Female</option>";
                                                                echo "<option value='Both'>Both</option>";
                                                                break;
                                                            case "Both":
                                                                echo "<option selected value='Both'>Both</option>";
                                                                echo "<option value='Male'>Male</option>";
                                                                echo "<option value='Female'>Female</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='Male'>Male</option>";
                                                                echo "<option value='Female'>Female</option>";
                                                                echo "<option value='Both'>Both</option>";
                                                                break;
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Number of Vacancies</label>
                                                    <input type="number" class="form-control" placeholder="Vaccancies Count" name="vacancies" value="<?php echo $fetch["vacancies"] ?>">
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Last Date to apply</label>
                                                    <input type="date" class="form-control" name="last_date_to_apply" placeholder="YYYY\MM\DD" value="<?php echo $fetch["last_date_to_apply"] ?>">
                                                </div>

                                                <div class="control-group form-group">
                                                    <label class="form-label">Certification</label>

                                                    <select class="form-control form-select select2" name="certification">
                                                        <?php
                                                        switch ($fetch["certification"]) {
                                                            case "Yes":
                                                                echo "<option selected value='Yes'>Yes</option>";
                                                                echo "<option value='No'>No</option>";
                                                                break;
                                                            case "No":
                                                                echo "<option selected value='No'>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='No'>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                        }

                                                        ?>

                                                    </select>
                                                </div>


                                            </section>
                                            <h3> Full information</h3>
                                            <section>

                                                <label class="form-label">Full Description</label>
                                                <div class="form-label">
                                                    <input class="form-control" placeholder="Textarea" name="full_description" rows="5" value="<?php echo $fetch["full-description"] ?>"></input>
                                                </div>


                                                <label class="form-label"> Pre-Requirements</label>
                                                <div class="form-label">
                                                    <input class="form-control" name="pre-requirements" placeholder="Textarea" rows="5" value="<?php echo $fetch["pre-requirements"] ?>"></input>
                                                </div>

                                                <label class="form-label">additional information</label>
                                                <div class="form-label">
                                                    <input class="form-control" name="additional_info" placeholder="Textarea" rows="3" value="<?php echo $fetch["additional_info"] ?>">
                                                </div>

                                            </section>
                                            <h3>Pricings </h3>
                                            <section>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Internship Type</label>
                                                    <select class="form-control form-select select2" name="internship_type" data-bs-placeholder="Internship Type" required>
                                                        <?php switch ($fetch["internship_type"]) {
                                                            case "Paid":
                                                                echo '<option value="Paid" selected>Paid</option>
															<option value="Free">Free</option>
															<option value="Stipend">Stipend</option>';
                                                                break;
                                                            case "Free":
                                                                echo '<option value="Paid">Paid</option>
															<option value="Free" selected>Free</option>
															<option value="Stipend">Stipend</option>';
                                                                break;
                                                            case "Stipend":
                                                                echo '<option value="Paid">Paid</option>
															<option value="Free">Free</option>
															<option value="Stipend" selected>Stipend</option>';
                                                                break;
                                                            default:
                                                                echo '<option value="Paid">Paid</option>
															<option value="Free">Free</option>
															<option value="Stipend">Stipend</option>';
                                                                break;
                                                        } ?>

                                                    </select>

                                                </div>

                                                <div class="control-group form-group">
                                                    <label class="form-label">Food Allowances</label>

                                                    <select class="form-control form-select select2" name="food_allowances">
                                                        <?php
                                                        switch ($fetch["food_allowances"]) {
                                                            case "Yes":
                                                                echo "<option selected value='Yes'>Yes</option>";
                                                                echo "<option value='No'>No</option>";
                                                                break;
                                                            case "No":
                                                                echo "<option value='No' selected>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='No'>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="control-group form-group">
                                                    <label class="form-label">Transport Allowances</label>

                                                    <select class="form-control form-select select2" name="transport_allowances">
                                                        <?php
                                                        switch ($fetch["transport_allowances"]) {
                                                            case "Yes":
                                                                echo "<option selected value='Yes'>Yes</option>";
                                                                echo "<option value='No'>No</option>";
                                                                break;
                                                            case "No":
                                                                echo "<option value='No' selected>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                            default:
                                                                echo "<option selected value='No'>No</option>";
                                                                echo "<option value='Yes'>Yes</option>";
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Enter Value (if paid)</label>
                                                    <input type="number" class="form-control" name="salary" placeholder="0,000/-" value="<?php echo $fetch["salary"] ?>">
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Enter Value (if stifund)</label>
                                                    <input type="number" class="form-control" name="stifund" placeholder="0,000/-" value="<?php echo $fetch["stifund"] ?>">
                                                </div>

                                            </section>
                                            <h3>Uploadings </h3>
                                            <section>

                                                <div class="control-group form-group">
                                                    <label class="form-label">Main Image</label>
                                                    <input type="file" name="main_image" class="form-control">
                                                    <input type="hidden" name="main_image_old" value="<?php echo $fetch["main_image"] ?>">
                                                    <a target="_blank" href="./assets/img/internship/<?php echo $fetch["main_image"] ?>" class="btn btn-primary mt-3 mb-0" style="text-align:right">View Main
                                                        Image</a>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Inner image</label>
                                                    <input type="file" name="inner_image" class="form-control">
                                                    <input type="hidden" name="inner_image_old" value="<?php echo $fetch["inner_image"] ?>">
                                                    <a href="<?php echo "./assets/img/internship/" . $fetch["inner_image"] ?>" class="btn btn-primary mt-3 mb-0" style="text-align:right" target="_blank">View Inner Image</a>
                                                </div>
                                                <div class="control-group form-group">
                                                    <input type="submit" class="btn btn-success" value="Update" name="Update">
                                                </div>
                                            </section>
                                        </div>

                                    <?php  } else {
                                        echo '<div class="alert alert-danger">Internship Not Found</div>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row closed -->

                </form>

            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->



    </div>
    <!-- End Page -->
    <?php include("./scripts.php") ?>
</body>

</html>