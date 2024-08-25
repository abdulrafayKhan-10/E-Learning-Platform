<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"])) {
    header('location: ./manageplacement.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>View Placement</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1">View Placement</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="javascript:void(0);">Placement</a></li>
                            <li class="breadcrumb-item " aria-current="page">View</li>
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
                                <?php
                                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                                $id = (int) $id;
                                $sql = "SELECT * FROM `placement` WHERE `id` = $id";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    $fetch = mysqli_fetch_assoc($result);

                                ?>
                                    <div id="wizard3">
                                        <h3>Overview</h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" readonly class="form-control" disabled placeholder="Course Name" value="<?php echo $fetch['company_name']; ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Title" value="<?php echo $fetch['job_role']; ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Salary</label>
                                                <input type="number" class="form-control" readonly disabled placeholder="Stream" value="<?php echo $fetch["salary"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Industry</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Duration(min)" value="<?php echo $fetch["industry"] ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Experience</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Experience" value="<?php echo $fetch["experience"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Work Mode</label>
                                                <input type="" class="form-control" readonly disabled placeholder="Work Mode" value="<?php echo $fetch["work_mode"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Years Of Experience Required</label>
                                                <input type="number" class="form-control" readonly disabled placeholder="Offline" value="<?php echo $fetch["years_open_experience"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Eligibility</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Eligibility" value="<?php echo $fetch["eligibility"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Location</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Location" value="<?php echo $fetch["location"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Last Date to apply</label>
                                                <input type="text" class="form-control" name="last_date_to_apply" placeholder="YYYY\MM\DD" value="<?php echo $fetch["last_date_to_apply"] ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Job Type</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Job Type" value="<?php echo $fetch["job_type"] ?>">
                                            </div>


                                        </section>
                                        <h3> Full information</h3>
                                        <section>

                                            <label class="form-label">Vacancies</label>
                                            <div class="form-label">
                                                <input class="form-control" readonly disabled placeholder="Vacancies" rows="5" value="<?php echo $fetch["vacancies"] ?>"></input>
                                            </div>


                                            <label class="form-label">Gender</label>
                                            <div class="form-label">
                                                <input class="form-control" readonly disabled placeholder="Gender" value="<?php echo $fetch["gender"] ?>"></input>
                                            </div>

                                            <label class="form-label">Last Date Of Registration</label>
                                            <div class="form-label">
                                                <input class="form-control" readonly disabled placeholder="Last Date Of Registration" rows="3" value="<?php echo $fetch["last_date_to_apply"] ?>">
                                            </div>

                                        </section>
                                        <h3>Pricings </h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Full Description</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Paid" value="<?php echo $fetch["full_description"] ?>">

                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Requirements</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Requirements" value="<?php echo $fetch["requirements"] ?>">
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="form-label">Additional Info</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Additional Info" value="<?php echo $fetch["additional_info"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Food Allowances</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Food Allowances" value="<?php echo $fetch["food_allowances"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Transport Allowances</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="Transport Allowances" value="<?php echo $fetch["transport_allowances"] ?>">
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">ESI</label>
                                                <input type="text" class="form-control" readonly disabled placeholder="ESI" value="<?php echo $fetch["esi"] ?>">
                                            </div>

                                        </section>
                                        <h3>Uploadings </h3>
                                        <section>

                                            <div class="control-group form-group">
                                                <label class="form-label">Main Image</label>
                                                <a download="" href="./assets/img/placement/<?php echo $fetch["main_image"] ?>" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</a>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Inner Image</label>
                                                <a download="" href="<?php echo "./assets/img/placement/" . $fetch["inner_image"] ?>" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</a>
                                            </div>
                                            <div class="control-group form-group">
                                                <label class="form-label">Inner Image Two</label>
                                                <a download="" href="<?php echo "./assets/img/placement/" . $fetch["image_two"] ?>" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</a>
                                            </div>

                                        </section>
                                    </div>

                                <?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row closed -->


            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->



    </div>
    <!-- End Page -->
    <?php include("./scripts.php") ?>
</body>

</html>