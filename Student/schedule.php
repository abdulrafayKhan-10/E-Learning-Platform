<?php
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
	header('location: ../student_login.php');
	exit();
}
include('../db_connection/connection.php');
$stud_id = $_COOKIE['student_id'];
$query = "SELECT *
FROM ((batches_schedule
INNER JOIN batch ON batches_schedule.batch_id = batch.id)
INNER JOIN course_registration ON batch.course_id = course_registration.course_id) WHERE student_id = '$stud_id'";
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
    <title>Schedules</title>

    <?php include("./links.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <!-- Loader -->
    <!-- <div id="global-loader">
        <img src="assets/img/preloader.svg" class="loader-img" alt="Loader">
    </div> -->
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

                                <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Schedules</span>
                            </ol>
                        </div>

                    </div>

                    <?php if(mysqli_num_rows($query_run) == 0) {
                    echo "<h2>No Schedules found!</h2>";
                } else {
                    while ($data = mysqli_fetch_array($query_run)) { ?>
                    <div class="row row-sm">
                        <div class="col-sm-12 col-lg-12">
                            <div class="card primary-custom-card1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="text-justified align-items-center">
                                                <h4 class="product-title mb-1"><b
                                                        style="color: #ff6700;"><?php echo $data['date_of_schedule']; ?></b>
                                                </h4>
                                                <!-- <p class="text-muted tx-13 mb-1">Non IT</p> -->
                                                <br>




                                                <p class="card-text tx-15"><span style="color: #13131a;">Topic
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['main_topic'];?>
                                                </p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Class Duration
                                                        &nbsp
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['class_duration'];?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Tasks   &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['tasks'];?></p>
                                                    <p class="card-text tx-15"><span style="color: #13131a;"> Topics Covered   &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['topics_to_be_covered'];?></p>
                                                    <p class="card-text tx-15"><span style="color: #13131a;"> Starting Time  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['class_starting_time'];?></p>
                                                    <p class="card-text tx-15"><span style="color: #13131a;"> Ending Time  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['class_ending_time'];?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Name
                                                        &nbsp
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                    <?php echo $data['batch_name'];?></p>
                                                    <p class="card-text tx-15"><span style="color: #13131a;"> Download Documents
                                                        &nbsp
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp

														<button class="btn btn-primary mb-3 shadow"><a
                                                            href="../superadmin/assets/docs/shared_document/<?php echo $data['shared_documents']; ?>" Download><span
                                                                style="color:#ffffff;">Download</span></a></button>
														</p>
                                                


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }
                ?>




                    <!-- Container closed -->
                </div>
            </div>
            <!-- End Page -->

            <!-- BACK-TO-TOP -->
            <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

            <?php include("./scripts.php") ?>
</body>

</html>