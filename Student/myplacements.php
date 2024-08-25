<?php
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
	header('location: ../student_login.php');
	exit();
}
include('../db_connection/connection.php');
$stud_id = $_COOKIE['student_id'];
$query = "SELECT * FROM placement_applicants INNER JOIN placement ON placement_applicants.job_id = placement.id WHERE `student_id` =  '$stud_id'";
$query_run = mysqli_query($conn, $query);



?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>My Placements</title>

    <?php include("./links.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <!-- Loader -->
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div>

            <?php include("./partials/sidebar.php"); ?>
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <div class="breadcrumb-header justify-content-between">


                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">

                                <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY
                                    Placements</span>
                            </ol>
                        </div>

                    </div>


                    <?php if(mysqli_num_rows($query_run) == 0) {
                    echo "<h2>You haven't applied for any Placement yet!</h2>";
                } else {
                    while ($array_data = mysqli_fetch_array($query_run)) { ?>
                    <div class="row row-sm">
                        <div class="col-sm-12 col-lg-12">
                            <div class="card primary-custom-card1">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                            <div class="prime-card1">
                                                <img class="img-fluid" src="../superadmin/assets/img/placement/<?php echo $array_data['main_image']; ?>" alt="" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                            <div class="text-justified align-items-center">
                                                <h4 class="product-title mb-1"><b style="color: #ff6700;"><?php echo $array_data['job_role'];?></b>
                                                </h4>
                                                <p class="text-muted tx-13 mb-1"><?php echo $array_data['company_name'];?></p>
                                                <br>




                                                <p class="card-text tx-15"><span style="color: #13131a;"> Industry
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['industry'];?>
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Eligibility &nbsp
                                                    &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['eligibility'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Required Experience
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['years_open_experience'];?> Years</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Type
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['work_mode'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Vacancies
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['vacancies'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Applicant should be
                                                    (Experienced/Fresher)
                                                    &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['experience'];?>
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Gender
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['gender'];?>
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Job type
                                                    &nbsp &nbsp:</span>&nbsp &nbsp
                                                <?php echo $array_data['job_type'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Monthly Salary
                                                    Pkg.
                                                    &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['salary'];?>/-</p>

                                            <p class="card-text tx-15"><span style="color: #13131a;">Last date to apply
                                                    &nbsp &nbsp :</span>&nbsp &nbsp &nbsp
                                                <?php echo $array_data['last_date_to_apply'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Transport
                                                    Allowances &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['transport_allowances'];?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Food Allowances
                                                    &nbsp &nbsp:</span>&nbsp &nbsp
                                                <?php echo $array_data['food_allowances'];?></p>

                                            <p class="card-text tx-15"><span style="color: #13131a;">Location &nbsp
                                                    &nbsp:</span>&nbsp &nbsp
                                                <?php echo $array_data['location'];?></p>

                                                <div class="row">


                                                    <!-- <button class="btn btn-primary mb-3 shadow"><a
                                                            href="schedule.php?batch_id=57"><span
                                                                style="color:#ffffff;">Schedule</span></a></button>
                                                    &nbsp &nbsp
                                                    <button class="btn btn-primary mb-3 shadow"><a
                                                            href="meetings.php?batch_id=57"><span
                                                                style="color:#ffffff;">Meetings</span></a></button>
                                                    &nbsp &nbsp
                                                    <button class="btn btn-primary mb-3 shadow"><a
                                                            href="summary.php?batch_id=57"><span
                                                                style="color:#ffffff;">Summary</span></a></button> &nbsp
                                                    &nbsp
                                                    <button class="btn btn-primary mb-3 shadow"><a
                                                            href="recordings.php?batch_id=57"><span
                                                                style="color:#ffffff;">Recordings</span></a></button>
                                                    &nbsp &nbsp
                                                    <button class="btn btn-primary mb-3 shadow"><a
                                                            href="tasks.php?batch_id=57"><span
                                                                style="color:#ffffff;">Tasks</span></a></button> &nbsp
                                                    &nbsp
                                                    <button class="btn btn-primary mb-3 shadow"><a
                                                            href="documentations.php?batch_id=57"><span
                                                                style="color:#ffffff;">Documentations</span></a></button> -->
                                                    &nbsp &nbsp
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }?>




                    <!-- Container closed -->
                </div>
            </div>
            <!-- End Page -->

            <!-- BACK-TO-TOP -->
            <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

            <?php include("./scripts.php") ?>
</body>

</html>
