
<?php 
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
	

<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="">
		
		<!-- Title -->
		<title>Course List</title>

		<?php 
	 include('./style.php'); 
	  ?>

	</head>

	<body class="ltr main-body app sidebar-mini">

	<?php 
	 include('./switcher.php'); 
	  ?>

		<!-- Loader -->
		<!-- <div id="global-loader">
			<img src="assets/img/preloader.svg" class="loader-img" alt="Loader">
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

			</div>			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

                    
<div class="breadcrumb-header justify-content-between">
						<div class="right-content">
						  <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Apply Trainer Course </span> 
						</div>
						
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
							
								<li class="breadcrumb-item ">Apply</li>
								<li class="breadcrumb-item ">Trainer</li>
							</ol>
						</div>
 
					</div>
				<!--	<div class="row row-sm">
			
								&nbsp &nbsp 		<a href="" class="btn btn-success" data-bs-target="#allocate" data-bs-toggle="modal">Apply Courses</a>	
                                               								
									</div> -->
									
																		
<br>	
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										
										<div class="table-responsive  export-table">
											<table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
												<thead>
													<tr>
														<th class="border-bottom-0">S.no</th>
											
														<th class="border-bottom-0">Course ID</th>
														<th class="border-bottom-0">Course name</th>
														<th class="border-bottom-0">Price</th>
														<th class="border-bottom-0">Duration</th>
														<th class="border-bottom-0">View</th>
														<th class="border-bottom-0">Apply</th>
											
													</tr>
												</thead>
												<tbody>
																									
												<?php 
												$select_query_result = ($conn->query("SELECT * FROM `course`"));
												if(mysqli_num_rows($select_query_result) > 0){
													$i = 1;
												while($row = mysqli_fetch_array($select_query_result)){
												
												?>
													<tr>
														<td><?php echo $i++;?></td>
														<td>COURSE_<?php echo $row['id']?></td>
														<td><?php echo $row['course_name']?></td>											
														<td><?php echo $row['final_cost']?></td>											
														<td><?php echo $row['duration_days']?></td>											
														<td><a href="viewcourse.php?id=<?php echo $row['id']?>" class="btn btn-primary">view</a></td>
																																										<td>
																																											<?php 
						$select_applied_course = mysqli_query($conn,"SELECT * FROM `trainer_applying_for_courses` WHERE (trainer_id = '$_COOKIE[trainer_id]') &&course_id = '$row[id]'");
						if(mysqli_num_rows($select_applied_course) > 0){
						?>																					<button disabled class="btn btn-success mb-3 shadow mt-3"><span style="color:#ffffff;">Applied</span></button> &nbsp; &nbsp;
<?php } else {?>
	<button class="btn btn-info mb-3 shadow mt-3"><a href="./apply_for_course.php?id=<?php echo $row['id']?>"><span style="color:#ffffff;">Apply</span></a></button> &nbsp; &nbsp;
<?php } ?>
										   	
														</td>
													</tr>

												<?php 
												}}else{
													echo "No data found";
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

    
		               <div class="modal fade" id="allocate">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <p> Are you sure you want to apply for courses?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-success" type="button">Apply</button>
                                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not Now</button>
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

            <!-- Sidebar-right-->
		


            
                       <!-- Footer opened -->
			
			<!-- Footer closed -->


		</div>
		<!-- End Page -->

        <!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

	    <?php 
	 include('./script.php'); 
	  ?>
    </body>

<!-- Mirrored from laravel8.spruko.com/nowa/table-data by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:58 GMT -->
</html>
