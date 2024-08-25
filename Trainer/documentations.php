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
    <title>Documentation</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Documentations</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">File Manager</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Documentations</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->

                <!-- row -->
                <div class="row">
                    <div class="col-lg-12 col-xl-12">

                        <div class="row">
                          
                            <div class="col-xl-2 col-md-4 col-sm-6">

                            <?php 
                $select_query = mysqli_query($conn,"SELECT * FROM `batches_documentation` WHERE batch_id = '$id'");
                if(mysqli_num_rows($select_query) > 0){
                while($row = mysqli_fetch_assoc($select_query)){
                ?>
                                <div class="card p-0 ">
                                    <div class="card-body pt-0 text-center">
                                        <div class="file-manger-icon">
                                            <a target="_blank"
                                                href="./assets/docs/supportive_docs/<?php echo $row['shared_documents'] ?>" download="">
                                                <img src="https://triaright.com/Trainer/assets/img/files/file.png"
                                                    alt="img" class="br-7">
                                        </div>
                                        <h6 class="mb-1 font-weight-semibold">JAVA PROGRAMS </h6>
                                        <span class="text-muted">2023-11-20 11:23:56</span></a>
                                    </div>
                                </div>
                                <?php }} else {?>
                                    <div>
                                <h3 class="me-2">No Documentation Found</h3>
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
    <a href="documentations.php@batch_id=42.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include('./script.php')?>

</body>

<!-- Mirrored from laravel8.spruko.com/nowa/table-data by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:58 GMT -->

</html>