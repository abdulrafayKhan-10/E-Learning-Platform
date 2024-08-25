<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
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
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$id = (int) $id;
$query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$id'");
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
$fetch_course_details = mysqli_fetch_assoc($query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <title>View Course</title>

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
                        <span class="main-content-title mg-b-0 mg-b-lg-1">view Course</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="javascript:void(0);">Course</a></li>
                            <li class="breadcrumb-item " aria-current="page">view Course</li>
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
                                            <label class="form-label">Name of the Course</label>
                                            <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['course_name']; ?>">
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Streams</label>
                                            <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['stream_name']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <label class="form-label">Posting Category</label>
                                            <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['posting_category']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <label class="form-label">Course provider Name</label>
                                            <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['provider_name_company']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <div class="control-group form-group">
                                                <label class="form-label">Training Type</label>
                                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['training_type']; ?>">
                                            </div>


                                            <div class="control-group form-group">
                                                <label class="form-label">Offline address ( if offline )</label>
                                                <input type="" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['offline_address']; ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Duration(hrs)</label>
                                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['duration_days']; ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Last date to apply</label>
                                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['last_date_to_apply']; ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Hours per day</label>
                                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['hours_per_day']; ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Certifications</label>
                                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['certification']; ?>">
                                            </div>


                                            <div class="control-group form-group">
                                                <label class="form-label">No of Slots available</label>
                                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['slots']; ?>">
                                            </div>

                                    </section>
                                    <h3> Full information</h3>
                                    <section>

                                        <label class="form-label">Course Description</label>
                                        <div class="form-label">
                                            <input class="form-control" readonly value="<?php echo $fetch_course_details['course_description']; ?>">
                                        </div>
                                        <label class="form-label">Topics Covered</label>
                                        <div class="form-label">
                                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_course_details['topics_covered']; ?>">
                                        </div>
                                        <label class="form-label">Benefits of Course</label>
                                        <div class="form-label">
                                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_course_details['benefits_of_course']; ?>">
                                        </div>

                                        <label class="form-label">Pre-Requirements</label>
                                        <div class="form-label">
                                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_course_details['pre_requirements']; ?>">
                                        </div>
                                        <label class="form-label">additional information</label>
                                        <div class="form-label">
                                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_course_details['additional_info']; ?>">
                                        </div>
                                    </section>
                                    <h3>Pricings </h3>
                                    <section>

                                        <div class="control-group form-group">
                                            <label class="form-label">Course type</label>
                                            <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['course_type']; ?>">
                                        </div>


                                        <div class="control-group form-group">
                                            <label class="form-label">Orginal Cost</label>
                                            <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['original_cost']; ?>">
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Discount %</label>
                                            <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['discount_percentage']; ?>">
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Final cost</label>
                                            <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_course_details['final_cost']; ?>">
                                        </div>
                                    </section>
                                    <h3>Uploadings </h3>
                                    <section>

                                        <div class="control-group form-group">
                                            <label class="form-label">Main Image</label>
                                            <a target="_blank" href="./assets/img/course/<?php echo $fetch_course_details['main_image']; ?>" download="">
                                                <button type="submit" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Inner image</label>
                                            <a target="_blank" href="./assets/img/course/<?php echo $fetch_course_details['inner_image']; ?>" download=""><button type="submit" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">image 2</label>

                                            <a target="_blank" href="./assets/img/course/<?php echo $fetch_course_details['image_two']; ?>" download="">
                                                <button type="submit" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                                        </div>
                                    </section>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row closed -->


            </div>
            <!-- Container closed -->
        </div>
    </div>


    <?php include("./scripts.php"); ?>

</body>

</html>