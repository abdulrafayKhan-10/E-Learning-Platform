<?php
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
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
    <title>Course Resgistration</title>

    <?php include("./links.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Page -->
    <div class="page">

        <div>
            <?php include("./partials/sidebar.php"); ?>

            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <div class="breadcrumb-header justify-content-between">
                        <div class="right-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Course
                                Registrations</span>
                        </div>

                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>

                                <li class="breadcrumb-item ">Registrations</li>
                            </ol>
                        </div>

                    </div>
                    <div class="row row-sm">

                        <div class="col-sm-12 col-lg-12">
                            <div class="card primary-custom-card1">
                                <div class="card-body">
                                    <?php
                                    $id = (int) $_COOKIE["student_id"];
                                    $course_registration_query = mysqli_query($conn, "SELECT * FROM `course_registration` WHERE `student_id`='$id'");
                                    if (mysqli_num_rows($course_registration_query) > 0) {
                                        while ($row = mysqli_fetch_array($course_registration_query)) {

                                            $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$row[course_id]'");

                                            if (mysqli_num_rows($course_query) > 0) {
                                                $course = mysqli_fetch_array($course_query);


                                    ?>
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                            <div class="prime-card1">
                                                <img class="img-fluid"
                                                    src="../superadmin/assets/img/course/<?php echo $course['main_image']; ?>"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                            <div class="text-justified align-items-center">
                                                <h4 class="product-title mb-1"><b
                                                        style="color: #ff6700;"><?php echo $course['course_name']; ?></b>
                                                </h4>
                                                <p class="text-muted tx-13 mb-1"></p>
                                                <br>
                                                <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider
                                                            Name
                                                            :</b></span>&nbsp<?php echo $course['provider_name_company']; ?>
                                                </p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"><b> Course Fee
                                                            :</b></span>&nbsp <?php echo $course['final_cost']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"><b>Cateogry
                                                            :</b></span>&nbsp
                                                    <?php echo $course['course_category_name']; ?></p>
                                                <p class="card-text tx-15"><span style="color: #13131a;"><b>Status
                                                            :</b></span>&nbsp
                                                    <?php echo $row['status']; ?></p>

                                                <div class="row">
                                                    <!-- <button class="btn btn-danger mb-3 shadow"><a
                                                            href="../superadmin/connection_files/manage/student_login_removecourse.php?crid=28&sid="><span
                                                                style="color:#ffffff;">Remove</span></a></button> &nbsp
                                                    &nbsp -->
                                                    <a class="btn btn-info mb-3 shadow"
                                                        href="coursedetails1.php?courseid=<?php echo $row['course_id'] ?>"><span
                                                            style="color:#ffffff;">View More</span></a>
                                                    &nbsp &nbsp
                                                    <!-- <button class="btn btn-primary mb-3 shadow"><a
                                                            href="makereferalcodestatus.php?crid=28"><span
                                                                style="color:#ffffff;">Make payment</span></a></button>
                                                    &nbsp &nbsp -->


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                    } ?>
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




    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./scripts.php") ?>
</body>

</html>