<?php 


include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}
$id = $_GET['id'];

?>
	<!DOCTYPE html>
	<html lang="en">


	<head>

	    <meta charset="UTF-8">
	    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="Description" content="">

	    <!-- Title -->
	    <title>Recordings</title>

	    <?php include('./style.php')?>

	</head>

	<body class="ltr main-body app sidebar-mini">


	    <!-- Loader -->
	    <!-- <div id="global-loader">
			<img src="https://triaright.com/Trainer/assets/img/preloader.svg" class="loader-img" alt="Loader">
		</div> -->
	    <!-- /Loader -->

	    <!-- Page -->
	    <div class="page">

	        <div>

	            <div class="main-header side-header sticky nav nav-item">
	                <?php include('./partials/navbar.php')?>
	            </div>
	            <!-- /main-header -->

	            <!-- main-sidebar -->
	            <div class="sticky">
	                <?php include('./partials/sidebar.php')?>
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
	                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Recordings</span>
	                    </div>
	                    <div class="justify-content-center mt-2">
	                        <ol class="breadcrumb">
	                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Courses</a></li>
	                            <li class="breadcrumb-item active" aria-current="page">Recordings</li>
	                        </ol>
	                    </div>
	                </div>
	                <!-- /breadcrumb -->

	                <!-- row -->

	                <div class="row">
	                    <div class="col-xl-2 col-md-4 col-sm-6">
						<?php 
                        $select_query = mysqli_query($conn,"SELECT * FROM `batches_recording` WHERE batch_id = '$id'");
                        if(mysqli_num_rows($select_query) > 0){
                        while($row = mysqli_fetch_assoc($select_query)){
                        ?>

	                        <div class="card p-0 ">

	                            <div class="card-body pt-0 text-center">

	                                <a class="file-manger-icon"
	                                    href="<?php echo $row['driving_link']?>"
	                                    target="_blank">
	                                    <img src="https://triaright.com/Trainer/assets/img/recordings.png" alt="img"
	                                        class="br-7" />
	                                </a>
	                                <h5 class="mb-1 font-weight-semibold"><?php echo $row['recording_topic_name']?></h5>
	                                <h6 class="mb-1 font-weight-semibold"><?php echo $row['date_of_upload']?></h6>

	                            </div>
	                        </div>
							<?php }} else {?>
							<div>
                            <h3 class="me-2">No Recording Found</h3>
                            </div>
                        <?php }?>

	                    </div>
	                    

	                </div>
	        
	            </div>
	        </div>
	        <!-- End Row -->


	    </div>
	    <!-- Container closed -->
	    </div>

	    </div>
	    <!-- Container closed -->
	    </div>
	    <!-- main-content closed -->

	    <!-- Sidebar-right-->




	 

	    </div>
	    <!-- End Page -->

	    <!-- BACK-TO-TOP -->
	    <a href="recordings.php@batch_id=42.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

		<?php include('./script.php')?>

	</body>


	</html>