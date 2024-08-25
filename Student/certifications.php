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
    <title>Certification</title>

    <?php include("./links.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
    <div id="global-loader">
        <img src="assets/img/preloader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->


    </div>
    <!-- Page -->
    <div class="page">
        <?php include("./partials/sidebar.php"); ?>
        <!-- /main-header -->
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY certifications</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">File Manager</a></li>

                            <li class="breadcrumb-item ">MY Certificates</li>
                        </ol>
                    </div>
                </div>
                <form method="post">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Batch id</label> </b>
                            <select name="batch_id" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="ALL">ALL</option>
                                <option value="57">57</option>
                                <option value="0">0</option>
                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search" style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
                    </div>
                </form>

                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card primary-custom-card1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                        <div class="prime-card1">
                                            <img class="img-fluid" src="assets/img/s2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                                        <div class="text-justified align-items-center">
                                            <h4 class="product-title mb-1"><b style="color: #ff6700;">Voice process</b>
                                            </h4>
                                            <!--<p class="text-muted tx-13 mb-1">Stream</p> -->
                                            <br>
                                            <p class="card-text tx-16"><span style="color: #13131a;"><b> Provider Name
                                                        :</b></span>&nbsp Triaright</p>
                                            <p class="card-text tx-15"><span style="color: #13131a;"><b>Trainer Name
                                                        :</b></span>&nbsp demotrainer</p>

                                            <div class="row">
                                                <p><a target="_blank" href="../images/Certification/Certification/0">
                                                        <button class="btn btn-info mt-3 mb-0" type="button">Download MY
                                                            Certificate</button></a> </p>

                                            </div>
                                        </div>
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

    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>


    <?php include("./scripts.php") ?>

</body>



</html>