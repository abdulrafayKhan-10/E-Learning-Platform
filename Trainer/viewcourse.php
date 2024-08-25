<?php 
include('../db_connection/connection.php');
$id = $_GET['id'];
$select_query_result = ($conn->query("SELECT * FROM `course` WHERE id = '$id'"));
$fetch_query = mysqli_fetch_array($select_query_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Course</title>
    <?php 
    include('./style.php');
    ?>
</head>
<body class="ltr main-body app sidebar-mini">
<?php 
	 include('./switcher.php'); 
	  ?>
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
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['course_name']; ?>">
                            </div>
                            
                                                                        <div class="control-group form-group">
                                <label class="form-label">Streams</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['stream_name']; ?>">
                            </div>
                            

                            
                            <div class="control-group form-group">
                                <label class="form-label">Posting Category</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['posting_category']; ?>">
                            </div>
                            
                                                                        

                            <div class="control-group form-group">
                                <label class="form-label">Course provider Name</label>
                                <input type="text" readonly class="form-control required"disabled placeholder=""  value="<?php echo $fetch_query['provider_name_company']; ?>">
                            </div>


                            
                            <div class="control-group form-group">																																<div class="control-group form-group">
                                <label class="form-label">Training Type</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['training_type']; ?>">
                            </div>
                            
                            
                            <div class="control-group form-group">
                                <label class="form-label">Offline address ( if offline )</label>
                                <input type="" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['offline_address']; ?>">
                            </div>
                            
                            <div class="control-group form-group">
                                <label class="form-label">Duration(hrs)</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['duration_days']; ?>">
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Last date to apply</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['last_date_to_apply']; ?>">
                            </div>

                            <div class="control-group form-group">
                                <label class="form-label">Hours per day</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['hours_per_day']; ?>">
                            </div>
                            
                            <div class="control-group form-group">
                                <label class="form-label">Certifications</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['certification']; ?>">
                            </div>
                            

                            <div class="control-group form-group">
                                <label class="form-label">No of Slots available</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['slots']; ?>">
                            </div>
                    
                        </section>
                        <h3> Full information</h3>
                        <section>

                        <label class="form-label">Course Description</label>
                            <div class="form-label">
                            <input class="form-control" readonly value="<?php echo $fetch_query['course_description']; ?>">
                        </div>
                        <label class="form-label">Topics Covered</label>
                            <div class="form-label">
                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_query['topics_covered']; ?>">
                        </div>
                        <label class="form-label">Benefits of Course</label> 
                            <div class="form-label">
                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_query['benefits_of_course']; ?>">
                        </div>
                        
                        <label class="form-label">Pre-Requirements</label>
                            <div class="form-label">
                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_query['pre_requirements']; ?>">
                        </div>
                     <label class="form-label">additional information</label>
                            <div class="form-label">
                            <input class="form-control" readonly disabled placeholder="" value="<?php echo $fetch_query['additional_info']; ?>">
                        </div>
                        </section>
                        <h3>Pricings </h3>
                        <section>
                        
                                                                    <div class="control-group form-group">
                                <label class="form-label">Course type</label>
                                <input type="text" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['course_type']; ?>">
                            </div>
                            

                            <div class="control-group form-group">
                                <label class="form-label">Orginal Cost</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['original_cost']; ?>">
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Discount %</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['discount_percentage']; ?>">
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Final cost</label>
                                <input type="number" readonly class="form-control required" disabled placeholder="" value="<?php echo $fetch_query['final_cost']; ?>">
                            </div>
                        </section>
                                                                <h3>Uploadings </h3>
                        <section>

                            <div class="control-group form-group">
                                <label class="form-label">Main Image (1200px*800px)</label>
                                <a target="_blank" href="../superadmin/assets/img/course/<?php echo $fetch_query['main_image'];?>" download="">
                                 <button type="submit" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">Inner image (600px*600px)</label>
                                <a target="_blank" href="../superadmin/assets/img/course/<?php echo $fetch_query['inner_image'];?>" download="" ><button type="submit"   class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label">image2(1200px*800px)</label>
                                
                                <a target="_blank" href="../superadmin/assets/img/course/<?php echo $fetch_query['image_two'];?>" download=""> <button type="submit" class="btn btn-primary mt-3 mb-0" style="text-align:right">Download</button>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
            <a href="courselist.php" class="btn btn-success	mt-0 mb-0 mx-3 mb-3"><i class="las la-angle-left me-2"></i>Go to Course List</a>
        </div>
    </div>
    <!-- row closed -->

</div>
<!-- Container closed -->
</div>
<?php 
	 include('./script.php'); 
	  ?>
</body>
</html>