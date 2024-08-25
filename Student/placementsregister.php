<?php
session_start();
include('../db_connection/connection.php');
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
    exit();
}

$select_query = "SELECT * FROM `placement`";
$run_query = mysqli_query($conn, $select_query);
if (isset($_POST['submit'])) {
    $_SESSION["success"] = "Registered Successfully";
    $stud_id = $_POST["stud_id"];
    $job_id = $_POST["job_id"];
    $query = "INSERT INTO `placement_applicants`(`student_id`, `job_id`) VALUES ('$stud_id','$job_id')";
    $run_query = mysqli_query($conn, $query);
    header("location:placementsregister.php");
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
    <title>Placements</title>
    <?php include("./links.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">


    <!-- Loader -->
    <!-- <div id="global-loader">
        <img src="https://triaright.com/Student/assets/img/preloader.svg" class="loader-img" alt="Loader">
    </div> -->
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div>

            <?php include("./partials/sidebar.php"); ?>



            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">View Placements</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Placements</a></li>
                                <li class="breadcrumb-item " aria-current="page">View</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->


                    <!-- /row -->

                    <!-- row -->

                    <div class="row row-sm">

                        <?php
                        while ($data = mysqli_fetch_array($run_query)) {
                        ?>

                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="carousel slide" data-bs-ride="carousel" id="carouselExample3">
                                    <ol class="carousel-indicators">
                                        <li class="active" data-bs-slide-to="0" data-bs-target="#carouselExample3"></li>
                                        <li data-bs-slide-to="1" data-bs-target="#carouselExample3"></li>

                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img alt="img" class="d-block w-100" src="../superadmin/assets/img/placement/<?php echo $data['main_image']; ?>" width="300" height="300">
                                        </div>
                                        <div class="carousel-item">
                                            <img alt="img" class="d-block w-100" src="../superadmin/assets/img/placement/<?php echo $data['image_two']; ?>" width="300" height="300">
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3"><span style="font-size:20px; color:#1d71f2; text-transform:none;"><?php echo $data['company_name']; ?></span>
                                        </h4>
                                        <p class="card-text"><span style="color: #ff6700; font-size:15px;">Role
                                                :</span><span style="font-size:15px;"> <?php echo $data['job_role'] ?> </p>
                                        <p class="card-text"><span style="color: #ff6700; font-size:15px;">Field
                                                :</span><span style="font-size:15px;"> <?php echo $data['industry'] ?>
                                        </p>
                                        <p class="card-text"><span style="color: #ff6700; font-size:15px;">Last Date
                                                :</span><span style="font-size:15px;">
                                                <?php echo $data['last_date_to_apply'] ?> </p>
                                        <a class="btn btn-primary btn-block" href="placementdetails.php?placementid=<?php echo $data['id'] ?>">Read More</a>
                                        <form method="post">
                                            <input type="hidden" value="<?php echo $data["id"] ?>" name="job_id">
                                            <input type="hidden" value="<?php echo $_COOKIE["student_id"] ?>" name="stud_id">


                                            <div class="text-center  mt-4">
                                                <?php $query_checked = mysqli_query($conn, "SELECT * FROM `placement_applicants` WHERE `student_id` = '{$_COOKIE['student_id']}' AND `job_id` = {$data['id']} ");
                                                if (mysqli_num_rows($query_checked) > 0) {
                                                    echo "<input value='Already Applied' disabled class='btn btn-primary btn-block'>";
                                                } else {


                                                ?>
                                                    <input type="submit" class="btn btn-primary btn-block" value="Apply" name="submit" id="submit_btn" />

                                                <?php } ?>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>

                        <?php } ?>




                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- BACK-TO-TOP -->
    <a href="viewcourses1.php@course=Information&#32;Technology.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./scripts.php") ?>


    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>

</body>

</html>