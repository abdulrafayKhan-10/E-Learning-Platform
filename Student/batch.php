<?php
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
    exit();
}
include('../db_connection/connection.php');
$stud_id = (int) $_COOKIE['student_id'];
$query = "SELECT * FROM `batch_student` WHERE `student_id` = '$stud_id'";


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
    <title>My Batches</title>

    <?php include("./links.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

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

                                <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">My
                                    Batches</span>
                            </ol>
                        </div>

                    </div>

                    <?php if (mysqli_num_rows($query_run) > 0) {

                        while ($data = mysqli_fetch_assoc($query_run)) { ?>
                    <div class="row row-sm">
                        <div class="col-sm-12 col-lg-12">
                            <div class="card primary-custom-card1">
                                <div class="card-body">
                                    <?php
                                            $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$data[batch_id]'");
                                            $row = mysqli_fetch_assoc($batch);
                                            ?>
                                    <div class="row">

                                        <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                            <div class="text-justified align-items-center">
                                                <h4 class="product-title mb-1"><b style="color: #ff6700;">Batch Name -:
                                                        <?php echo $data['batch_name']; ?></b>
                                                </h4>

                                                <br>




                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Status
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $row['status']; ?>
                                                </p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Id
                                                        :</span>&nbsp &nbsp
                                                    BATID_<?php echo $data['batch_id']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Course
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $data['batch_course_name']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Trainer
                                                        Name
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $data['batch_trainer_name']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Class Duration
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $row['class_duration']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Starting
                                                        Date
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $row['batch_starting_date']; ?>
                                                </p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Batch Ending
                                                        Date
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $row['batch_ending_date']; ?>
                                                </p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"> Shift
                                                        :</span>&nbsp &nbsp
                                                    <?php echo $row['session_slot']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;">Status
                                                        :</span>&nbsp &nbsp
                                                    <?php
                                                            switch ($data['status']) {
                                                                case "Active":
                                                                    echo "Enrolled";
                                                                    break;
                                                                case "Deleted":
                                                                    echo "You've been removed from this batch";
                                                                    break;
                                                                case "Pending":
                                                                    echo "Pending";
                                                                    break;
                                                            }
                                                            ?></p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    } else {
                        echo "<h2>You aren't registered for any Course yet!</h2>";
                    }
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