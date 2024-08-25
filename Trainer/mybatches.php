	<?php 


	include('../db_connection/connection.php');
	
	if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
		header('location: ../trainer_login.php');
		exit();
	}
	$id = $_COOKIE['trainer_id'];
	$select_trainer_batches = mysqli_query($conn,"SELECT * FROM `batch` WHERE trainer_id = '$id'");
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>

	    <meta charset="UTF-8">
	    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="Description" content="">

	    <!-- Title -->
	    <title> My Batches</title>

	    <?php include('./style.php')?>
	</head>

	<body class="ltr main-body app sidebar-mini">



	    <!-- Loader -->

	    <!-- /Loader -->

	    <!-- Page -->
	    <div class="page">

	        <div>

	            <div class="main-header side-header sticky nav nav-item">
	                <?php include('./partials/navbar.php');?>
	            </div>

	            <!-- /main-header -->

	            <!-- main-sidebar -->
	            <div class="sticky">
	                <?php include('./partials/sidebar.php');?>
	            </div>
	            <!-- main-sidebar -->

	        </div>
	        <!-- main-content -->
	        <div class="main-content app-content">

	            <!-- container -->
	            <div class="main-container container-fluid">


	                <div class="breadcrumb-header justify-content-between">


	                    <div class="justify-content-center mt-2">
	                        <ol class="breadcrumb">
	                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY Batches</span>
	                        </ol>
	                    </div>

	                </div>

	                <div class="row row-sm">
	                    <?php if(mysqli_num_rows($select_trainer_batches) > 0){
								while($row = mysqli_fetch_assoc($select_trainer_batches)) {	
								?>
	                    <div class="col-sm-12 col-lg-12">
	                        <div class="card primary-custom-card1">
	                            <div class="card-body">
	                                <div class="row">
	                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
	                                        <div class="prime-card1">
	                                            <img class="img-fluid" src="./assets/img/s2.jpg" alt="">
	                                        </div>
	                                    </div>
	                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
	                                        <div class="text-justified align-items-center">
	                                            <h4 class="product-title mb-1"><b
	                                                    style="color: #ff6700;"><?php echo $row['batchcourse_name']?></b>
	                                            </h4>
	                                            <p class="text-muted tx-13 mb-1"></p>
	                                            <br>




	                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
	                                                        :</b></span>&nbsp; <?php echo $row['batchtrainer_name']?> </p>
	                                            <?php 
												$course_id = $row['course_id'];
												$select_coursesdata = mysqli_query($conn,"SELECT * FROM `course` WHERE id = '$course_id'");
												$fetch_coursedata = mysqli_fetch_assoc($select_coursesdata);
												?>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b> Course Fee
	                                                        :</b></span> &nbsp;
	                                                <?php echo $fetch_coursedata['final_cost']?></p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Cateogry
	                                                        :</b></span>&nbsp;
	                                                <?php echo $fetch_coursedata['posting_category']?></p>

	                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Batch Name
	                                                        :</b></span>&nbsp; <?php echo $row['batch_name']?> </p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b> Class Duration
	                                                        :</b></span>&nbsp; <?php echo $row['class_duration']?> Hours
	                                            </p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Batch Starting
	                                                        Date :</b></span>&nbsp;
	                                                <?php echo $row['batch_starting_date']?></p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Batch Ending
	                                                        Date:</b></span>&nbsp; <?php echo $row['batch_ending_date']?>
	                                            </p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Session Slot
	                                                        :</b></span>&nbsp; <?php echo $row['session_slot']?> </p>
	                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Additional
	                                                        Information :</b></span>&nbsp;
	                                                <?php echo $row['additional_info']?> </p>

	                                            <div class="row">


	                                                <button class="btn btn-primary mb-3 shadow"><a
	                                                        href="schedule.php?id=<?php echo $row['id']?>"><span
	                                                            style="color:#ffffff;">Schedule</span></a></button> &nbsp;
	                                                &nbsp;
	                                                <button class="btn btn-primary mb-3 shadow"><a
	                                                        href="meetings.php?id=<?php echo $row['id']?>"><span
	                                                            style="color:#ffffff;">Meetings</span></a></button> &nbsp;
	                                                &nbsp;
	                                                <button class="btn btn-primary mb-3 shadow"><a href="summary.php?id=<?php echo $row['id']?>"><span
	                                                            style="color:#ffffff;">Summary</span></a></button> &nbsp;
	                                                &nbsp;
	                                                <button class="btn btn-primary mb-3 shadow"><a
	                                                        href="recordings.php?id=<?php echo $row['id']?>"><span
	                                                            style="color:#ffffff;">Recordings</span></a></button>
	                                                &nbsp; &nbsp;
	                                                <button class="btn btn-primary mb-3 shadow"><a href="tasks.php?id=<?php echo $row['id']?>"
	                                                        stu_id=""><span
	                                                            style="color:#ffffff;">Tasks</span></a></button> &nbsp;
	                                                &nbsp;
	                                                <button class="btn btn-primary mb-3 shadow"><a
	                                                        href="documentations.php?id=<?php echo $row['id']?>"><span
	                                                            style="color:#ffffff;">Documentations</span></a></button>
	                                                &nbsp; &nbsp;
	                                            </div>


	                                        </div>
	                                    </div>
	                                </div>
	                            </div>


	                        </div>
	                    </div>
	                    <?php }} else {?>
	                    <div>
	                        <h3 class="me-2">No Results Found</h3>
	                    </div>
	                    <?php }?>
	                </div>
	            </div>


	        </div>
	    </div>

	    </div>

	    </div>
	    </div>

	    </div>
	    <!-- Container closed -->
	    </div>
	    <!-- main-content closed -->








	    </div>

	    <!-- End Page -->

	    <!-- BACK-TO-TOP -->
	    <a href="#top" id="back-to-top" style="display: block;"><i class="las la-arrow-up"></i></a>

	    <?php include('./script.php')?>





	    </div>
	    </div>
	</body>

	</html>