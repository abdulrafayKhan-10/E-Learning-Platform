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
$query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '$id'");
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

    <title>View Trainer</title>

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
                        <span class="main-content-title mg-b-0 mg-b-lg-1">View Trainer</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="javascript:void(0);">Trainer</a></li>
                            <li class="breadcrumb-item " aria-current="page">Details</li>
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
                                    <h3>Trainer Details</h3>
                                    <section>
                                        <div class="control-group form-group">
                                            <label class="form-label">Trainer Name</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder="" value="<?php echo $fetch_course_details['name']; ?>">
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder="" value="<?php echo $fetch_course_details['email']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <label class="form-label">Username</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder="" value="<?php echo $fetch_course_details['username']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <label class="form-label">Date Of Birth</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder="" value="<?php echo $fetch_course_details['dob']; ?>">
                                        </div>



                                        <div class="control-group form-group">
                                            <div class="control-group form-group">
                                                <label class="form-label">Aadhar Card No#</label>
                                                <input type="text" readonly class="form-control required" disabled
                                                    placeholder=""
                                                    value="<?php echo $fetch_course_details['aadhar_card_number']; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group form-group">
                                            <div class="control-group form-group">
                                                <label class="form-label">Aadhar Card</label>
                                                <a href="./assets/img/trainer/<?php echo $fetch_course_details['aadhar_card_picture']; ?>"
                                                    target="_blank" class="btn btn-primary">Check</a>
                                            </div>
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Contact Number</label>
                                            <input type="" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['contact_number']; ?>">
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Pan Card No#</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['pan_card_number']; ?>">
                                        </div>
                                        <div class="control-group form-group">
                                            <div class="control-group form-group">
                                                <label class="form-label">Pan Card</label>
                                                <a href="./assets/img/trainer/<?php echo $fetch_course_details['pan_card_picture']; ?>"
                                                    target="_blank" class="btn btn-primary">Check</a>
                                            </div>
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Date Of Joining</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['date_of_joining']; ?>">
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Qualification</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['qualification']; ?>">
                                        </div>

                                        <div class="control-group form-group">
                                            <label class="form-label">Experience</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['experience']; ?>">
                                        </div>


                                        <div class="control-group form-group">
                                            <label class="form-label">Organization Name</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['organization_name']; ?>">
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Designation</label>
                                            <input type="text" readonly class="form-control required" disabled
                                                placeholder=""
                                                value="<?php echo $fetch_course_details['designation']; ?>">
                                        </div>
                                        <div class="control-group form-group">
                                            <label class="form-label">Organization Name</label>
                                            <a href="./assets/docs/trainer/<?php echo $fetch_course_details['trainer_document']; ?>"
                                                class="btn btn-primary" download="">Trainer Document</a>
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