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
    <title>Schedule</title>

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
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Schedule</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Schedule</li>

                        </ol>
                    </div>

                </div>
                <!-- /breadcrumb -->

                <!-- row -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-6">
                <?php 
                $select_query = mysqli_query($conn,"SELECT * FROM `batches_schedule` WHERE batch_id = '$id'");
                if(mysqli_num_rows($select_query)>0){
                while($row = mysqli_fetch_assoc($select_query)){
                ?>
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;"><?php echo $row['date_of_schedule'];?></b>
                                            </h4>
                                            <p class="text-muted tx-13 mb-1">Schedule</p>
                                            <br>
                                            <h5 class="mb-2 tx-18 font-weight-semibold text-dark"><span
                                                    style="color:#1D71F2;"><?php echo $row['main_topic'];?></span></h5>

                                            <p class="mb-1 tx-15 mb-3 text-muted"><span
                                                    style="color:#000000;"><b>Tasks:</b></span> <?php echo $row['tasks'];?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"> <span
                                                    style="color:#000000;"><b>Duration:</b></span> <?php echo $row['class_duration'];?> Hour</p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span
                                                    style="color:#000000;"><b>Starting time:</b></span> <?php echo $row['class_starting_time'];?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Ending
                                                        time:</b></span> <?php echo $row['class_ending_time'];?></p>
                                       
                                        
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Topics
                                                        Covered:</b></span> <?php echo $row['topics_to_be_covered'];?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Batch Name:</b></span> <?php echo $row['batch_name'];?></p>

                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Shared
                                                        Documents:</b></span>
                                                        <br>
                                                <a target="_blank"
                                                    href="./assets/docs/supportive_docs/<?php echo $row['shared_documents'];?>" download="">
                                                    <button class="btn btn-info mt-3 mb-0"
                                                        type="button">Download</button></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }} else {?>
                            <div>
                                <h3 class="me-2">No Schedule Found</h3>
                            </div>
                            <?php }?>
                        </div>

                </div>
                <!-- row closed -->


            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->

        <!-- Sidebar-right-->
    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="schedule.php@batch_id=42.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    
<?php include('./script.php')?>
</body>



</html>