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
    <title> Tasks</title>

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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Tasks</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Tasks</li>

                        </ol>
                    </div>

                </div>
                <!-- /breadcrumb -->


                <!-- row -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-6">
                    <?php 
                $select_query = mysqli_query($conn,"SELECT * FROM `batches_tasks` WHERE batch_id = '$id'");
                if(mysqli_num_rows($select_query)>0){
                while($row = mysqli_fetch_assoc($select_query)){
                ?>
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;"><?php echo $row['task_end_date']?></b>
                                            </h4>
                                            <p class="text-muted tx-13 mb-1">Tasks</p>
                                            <br>
                                            <h5 class="mb-2 tx-18 font-weight-semibold text-dark"><span
                                                    style="color:#1D71F2;"><b>Task Details</b></SPAN></h5>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Name
                                                        of Task: </b></span><?php echo $row['task_name']?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"> <span
                                                    style="color:#000000;"><b>Allocate type: </b></span><?php echo $row['allocated_students_type']?> </p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Task
                                                        End Date: </b></span> <?php echo $row['task_end_date']?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span
                                                    style="color:#000000;"><b>Description: </b></span> <?php echo $row['task_description']?></p>
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span
                                                    style="color:#000000;"><b>Batch Name: </b></span> <?php echo $row['batch_name']?></p>
                                            
                                            <p class="mb-1 tx-15 mb-3 text-muted"><span style="color:#000000;"><b>Shared
                                                        Documents: </b></span>
                                                        <br>
                                                <a target="_blank" download=""
                                                    href="./assets/docs/supportive_docs/<?php echo $row['shared_documents']?>" >
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
                                <h3 class="me-2">No Tasks Found</h3>
                            </div>
                            <?php }?>
                    </div>
                    <!-- row closed -->
                 
                    </div>


                    <!-- row closed -->

                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->


        </div>
        <!-- End Page -->

        <!-- BACK-TO-TOP -->
        <a href="tasks.php@batch_id=42&#32;.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

        <?php include('./script.php')?>
</body>

<!-- Mirrored from laravel8.spruko.com/nowa/profile-notifications by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:39 GMT -->

</html>