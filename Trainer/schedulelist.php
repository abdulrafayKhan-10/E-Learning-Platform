<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Schedule List</title>
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

        </div> <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Schedule List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a></li>
                            <li class="breadcrumb-item ">Schedule</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
											<th class="border-bottom-0">S.No</th>
									<th class="border-bottom-0">Date of Schedule</th>
									<th class="border-bottom-0">Main Topic</th>
									<th class="border-bottom-0">Duration </th>
									<th class="border-bottom-0">Tasks</th>
									<th class="border-bottom-0">Covering Topics</th>
									<th class="border-bottom-0">Starting Time</th>
									<th class="border-bottom-0">Ending Time</th>
		
                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$meetings = mysqli_query($conn, "SELECT * FROM `batches_schedule`");
											if (mysqli_num_rows($meetings) > 0) {
												$i = 1;
												while ($row = mysqli_fetch_assoc($meetings)) {

													echo "<tr>";
													echo "<td>" . $i++ . "</td>";
										echo "<td>" . $row['date_of_schedule'] . "</td>";
										echo "<td>" . $row['main_topic'] . "</td>";
										echo "<td>" . $row['class_duration'] . "</td>";
										echo "<td>" . $row['tasks'] . "</td>";
										echo "<td>" . $row['topics_to_be_covered'] . "</td>";
										echo "<td>" . $row['class_starting_time'] . "</td>";
										echo "<td>" . $row['class_ending_time'] . "</td>";
												
                                                    echo "</tr>";
												}
											} else {
												echo "No Schedule found";
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->






            </div>
        </div>

    </div>
    <?php include("./script.php"); ?>

</body>

</html>