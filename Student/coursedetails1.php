<?php
include('../db_connection/connection.php');
if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
    exit();
}
$id = $_GET['courseid'];
$select_query = "SELECT * FROM `course` WHERE `id` = $id";
$run_query = mysqli_query($conn, $select_query);
$array_data = mysqli_fetch_array($run_query);

if (isset($_POST['submit'])) {
    $stud_id = $_POST["stud_id"];
    $course_id = $_POST["course_id"];
    $query = "INSERT INTO `course_registration`(`course_id`, `student_id`) VALUES ('$course_id','$stud_id')";
    $run_query = mysqli_query($conn, $query);
    $check = true;
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
    <title>Course Details</title>

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

                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Course Details</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Courses</a></li>
                                <li class="breadcrumb-item active" aria-current="page">full details</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->

                    <!-- row -->
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="row row-sm ">
                                        <div class=" col-xl-6 col-lg-12 col-md-12">
                                            <div class="row">
                                                <!--<div class="col-xl-2">
                                <div class="clearfix carousel-slider">
                                    <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                        <div class="carousel-inner">
                                            <ul class="carousel-item active">
                                                <li data-bs-target="#Slider" data-bs-slide-to="0"
                                                    class="thumb active my-2"><img
                                                        src="assets/img/ecommerce/shirt-1.png"
                                                        alt="img"></li>
                                                <li data-bs-target="#Slider" data-bs-slide-to="1"
                                                    class="thumb my-2"><img
                                                        src="assets/img/ecommerce/shirt-3.png"
                                                        alt="img"></li>
                                                <li data-bs-target="#Slider" data-bs-slide-to="2"
                                                    class="thumb my-2"><img
                                                        src="assets/img/ecommerce/shirt-4.png"
                                                        alt="img"></li>
                                                <li data-bs-target="#Slider" data-bs-slide-to="3"
                                                    class="thumb my-2"><img
                                                        src="assets/img/ecommerce/shirt-2.png"
                                                        alt="img"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                                                <div class="col-xl-10">
                                                    <div class="product-carousel  border br-5">
                                                        <div id="Slider" class="carousel slide" data-bs-ride="false">
                                                            <div class="carousel-inner">
                                                                <div class="carousel-item active"><img
                                                                        src="../superadmin/assets/img/course/<?php echo $array_data["inner_image"] ?>"
                                                                        alt="img" class="img-fluid mx-auto d-block"
                                                                        width="540" height="300">
                                                                    <div class="text-center mt-5 mb-5 btn-list">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form method="post">
                                                        <input type="hidden" value="<?php echo $array_data["id"] ?>"
                                                            name="course_id">
                                                        <input type="hidden"
                                                            value="<?php echo $_COOKIE["student_id"] ?>" name="stud_id">


                                                        <div class="text-center  mt-4">
                                                            <?php $query_check = mysqli_query($conn, "SELECT * FROM `course_registration` WHERE `student_id` = '{$_COOKIE['student_id']}' AND `course_id` = {$array_data['id']} ");
                                                            if (mysqli_num_rows($query_check) > 0) {
                                                                echo "<input value='Already Registered' disabled class='btn ripple btn-primary me-2'>";
                                                            } else {


                                                            ?>
                                                            <input type="submit" class="btn ripple btn-primary me-2"
                                                                value="Register" name="submit" id="submit_btn" />

                                                            <?php } ?>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="details col-xl-6 col-lg-12 col-md-12 mt-4 mt-xl-0">

                                            <h4 class="product-title mb-1"><b
                                                    style="color: #ff6700;"><?php echo $array_data['course_name']; ?>
                                                </b>
                                            </h4>
                                            <!-- <p class="text-muted tx-13 mb-1">Information Technology</p> -->
                                            <br>



                                            <p class="card-text tx-15"><span style="color: #13131a;"> Provider Name
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['provider_name_company']; ?>
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Course Type &nbsp
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['course_type']; ?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Duration (Hrs)
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['duration_days']; ?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Hours/day &nbsp
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['hours_per_day']; ?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Training Type
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['training_type']; ?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Certification
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['certification']; ?>
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Orginal Price
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['original_cost']; ?>/-
                                            </p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"> Discount Price
                                                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</span>&nbsp &nbsp
                                                <?php echo $array_data['final_cost']; ?>/-</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Number of
                                                    seats &nbsp &nbsp &nbsp &nbsp &nbsp:</span>&nbsp &nbsp
                                                <?php echo $array_data['slots']; ?></p>
                                            <p class="card-text tx-15"><span style="color: #13131a;">Last date to apply
                                                    &nbsp &nbsp :</span>&nbsp &nbsp &nbsp
                                                <?php echo $array_data['last_date_to_apply']; ?></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($check) && $check === true) { ?>
                    <div class="alert alert-success" role="alert" id="alert">
                        You're Registered for this Course!
                    </div>
                    <?php } ?>
                    <div class="row row-sm">
                        <div class="col-lg-12 col-md-12">
                            <div class="card productdesc">
                                <div class="card-body">
                                    <div class="panel panel-primary">
                                        <div class=" tab-menu-heading">
                                            <div class="tabs-menu1">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs">
                                                    <li><a href="coursedetails1.php@details=6.html#tab5" class="active"
                                                            data-bs-toggle="tab">Course Description</a></li>
                                                    <li><a href="coursedetails1.php@details=6.html#tab6"
                                                            data-bs-toggle="tab">Topic Covered</a></li>
                                                    <li><a href="coursedetails1.php@details=6.html#tab7"
                                                            data-bs-toggle="tab">Benefits of Course</a></li>
                                                    <li><a href="coursedetails1.php@details=6.html#tab7"
                                                            data-bs-toggle="tab">Pre Requirements</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body tabs-menu-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab5">
                                                    <h5 class="mb-2 mt-1 fw-semibold"><span
                                                            style="color:#ff6700;">Course Description :</span></h5>
                                                    <p class="mb-3 tx-13"><span
                                                            style="line-height:30px"><span><?php echo $array_data['course_description']; ?></span>
                                                    </p>

                                                </div>
                                                <div class="tab-pane active" id="tab6">
                                                    <h5 class="mb-2 mt-1 fw-semibold"><span
                                                            style="color:#ff6700;">Topics Covered :</span></h5>
                                                    <p class="mb-3 tx-13"><span
                                                            style="line-height:30px"><?php echo $array_data['topics_covered']; ?></span>
                                                    </p>

                                                </div>
                                                <div class="tab-pane active" id="tab7">
                                                    <h5 class="mb-2 mt-1 fw-semibold"><span
                                                            style="color:#ff6700;">Benefits of Courses :</span></h5>
                                                    <p class="mb-3 tx-13"><span
                                                            style="line-height:30px"><?php echo $array_data['benefits_of_course']; ?></span>
                                                    </p>

                                                </div>
                                                <div class="tab-pane active" id="tab8">
                                                    <h5 class="mb-2 mt-1 fw-semibold"><span
                                                            style="color:#ff6700;">Pre-Requirements :</span></h5>
                                                    <p class="mb-3 tx-14"><span
                                                            style="line-height:30px"><?php echo $array_data['pre_requirements']; ?></span>
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


                    <!-- /row -->


                </div>

            </div>

            <!-- Container closed -->
        </div>
    </div>
    <!-- main-content closed -->

    <div class="modal fade" id="apply">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Confirm registration</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>Course Training Category</h6>
                    <!-- Select2 -->
                    <select class="form-control select2-show-search select2-dropdown">
                        <option value="">Self / Individual</option>
                        <option value="">Institution type</option>
                    </select>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputcode">Insitiutiton Name</label>
                            <input type="text" class="form-control" id="exampleInputcode"
                                placeholder="institution Name">
                        </div>
                    </div>
                    <h6>Payment Mode</h6>
                    <!-- Select2 -->
                    <select class="form-control select2-show-search select2-dropdown">
                        <option value="">Self / Individual</option>
                        <option value="">Institution type</option>
                    </select>
                    <!-- Select2 -->

                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="button">Register</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="apply1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Need more information</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputAadhar">Course Training category</label>
                            <select name="country" class="form-control form-select select2"
                                data-bs-placeholder="Category">
                                <option value="">Self / Individual</option>
                                <option value="">Institution type</option>
                            </select>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputAadhar">Payment mode</label>
                            <select name="country" class="form-control form-select select2"
                                data-bs-placeholder="Category">
                                <option value="">Self / Individual</option>
                                <option value="">Institution</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button">Apply</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not Now</button>
                </div>
            </div>
        </div>
    </div>



    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="coursedetails1.php@details=6.html#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./scripts.php") ?>

</body>

<!-- Mirrored from laravel8.spruko.com/nowa/table-data by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:58 GMT -->

</html>