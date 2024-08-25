<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header('location: ./internships.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Internship Details</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php") ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1">Placement Details</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Placement</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Full Details</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
                <?php
                $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
                $id = (int)$id;
                $query = mysqli_query($conn, "SELECT * FROM `placement` WHERE `id` = $id");
                if (mysqli_num_rows($query) > 0) {


                    $row = mysqli_fetch_array($query);
                ?>
                <!-- row -->
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body ">
                                <div class="row row-sm ">
                                    <div class=" col-xl-6 col-lg-12 col-md-12">
                                        <div class="row">

                                            <div class="col-xl-10">
                                                <div class="product-carousel  border br-5">
                                                    <div id="Slider" class="carousel slide" data-bs-ride="false">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active"><img
                                                                    src="../superadmin/assets/img/placement/<?php echo $row['main_image'] ?>"
                                                                    alt="img" class="img-fluid mx-auto d-block">
                                                                <div class="text-center mt-5 mb-5 btn-list">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="details col-xl-6 col-lg-12 col-md-12 mt-4 mt-xl-0">

                                        <h4 class="product-title mb-1"><b
                                                style="color: #ff6700;"><?php echo $row['job_role'] ?></b>
                                        </h4>
                                        <p class="text-muted tx-13 mb-1"><?php echo $row["industry"] ?></p>
                                        <br>



                                        <p class="card-text tx-15"><span style="color: #13131a;"> Company
                                                Name:</span><?php echo $row["company_name"] ?>
                                        </p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Salary:</span><?php echo $row["salary"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Experience (Years):</span><?php echo $row["years_open_experience"] ?>
                                        </p>
                                        <p class="card-text tx-15"><span style="color: #13131a;"> Eligibility:
                                            </span><?php echo $row["eligibility"] ?>
                                        </p>
                                        <p class="card-text tx-15"><span style="color: #13131a;"> Work
                                                Mode:</span><?php echo $row["work_mode"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;"> Job
                                                Type:</span><?php echo $row["job_type"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Location:</span><?php echo $row["location"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Experience Level:</span><?php echo $row["experience"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Pricing(paid):</span><?php echo $row["salary"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                ESI:</span><?php echo $row["esi"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">
                                                Gender:</span><?php echo $row["gender"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">No. of
                                                Vacancies:</span><?php echo $row["vacancies"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">Last Date To
                                                Apply:</span><?php echo $row["last_date_to_apply"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">Food
                                                Allowance:</span><?php echo $row["food_allowances"] ?></p>
                                        <p class="card-text tx-15"><span style="color: #13131a;">Travel
                                                Allowance:</span><?php echo $row["transport_allowances"] ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-lg-12 col-md-12">
                        <div class="card productdesc">
                            <div class="card-body">
                                <div class="panel panel-primary">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li><a href="internshipdetails.php@details=1.html#tab5" class="active"
                                                        data-bs-toggle="tab">Full Description</a></li>

                                                <li><a href="internshipdetails.php@details=1.html#tab6"
                                                        data-bs-toggle="tab">Pre Requirements</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab5">
                                                <h5 class="mb-2 mt-1 fw-semibold"><span style="color:#ff6700;">Full
                                                        Description :</span></h5>
                                                <p class="mb-3 tx-13"><span
                                                        style="line-height:30px"><?php echo $row["full_description"] ?></span>
                                                </p>

                                            </div>
                                            <div class="tab-pane active" id="tab6">
                                                <h5 class="mb-2 mt-1 fw-semibold"><span
                                                        style="color:#ff6700;">Requirements :</span></h5>
                                                <p class="mb-3 tx-13"><span
                                                        style="line-height:30px"><?php echo $row["requirements"] ?></span>
                                                </p>

                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /row -->
                <?php } ?>

                <!-- /row -->


            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->

    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./script.php"); ?>
</body>


</html>