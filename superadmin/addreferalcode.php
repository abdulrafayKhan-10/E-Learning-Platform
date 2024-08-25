<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
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

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Switcher -->
    <div class="switcher-wrapper">
        <div class="demo_changer">
            <div class="form_holder sidebar-right1">
                <div class="row">
                    <div class="predefined_styles">

                        <div class="swichermainleft text-center">
                            <h4>LTR AND RTL VERSIONS</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">LTR</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch25"
                                                id="myonoffswitch54" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch54" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">RTL</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch25"
                                                id="myonoffswitch55" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch55" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Navigation Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Vertical Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch34" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch34" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Horizantal Click Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch35" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch35" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Horizantal Hover Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch15"
                                                id="myonoffswitch111" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch111" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Light Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Light Theme</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitch1" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch1" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Light Primary</span>
                                        <div class="">
                                            <input class="wd-25 ht-25 input-color-picker color-primary-light"
                                                value="#38cab3" id="colorID" type="color" data-id="bg-color"
                                                data-id1="bg-hover" data-id2="bg-border" data-id7="transparentcolor"
                                                name="lightPrimary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Dark Theme Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Theme</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitch2" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch2" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Primary</span>
                                        <div class="">
                                            <input class="wd-25 ht-25 input-dark-color-picker color-primary-dark"
                                                value="#38cab3" id="darkPrimaryColorID" type="color" data-id="bg-color"
                                                data-id1="bg-hover" data-id2="bg-border" data-id3="primary"
                                                data-id8="transparentcolor" name="darkPrimary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Transparent Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex mt-2 mb-3">
                                        <span class="me-auto">Transparent Theme</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch1"
                                                id="myonoffswitchTransparent" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitchTransparent" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Transparent Primary</span>
                                        <div class="">
                                            <input
                                                class="wd-30 ht-30 input-transparent-color-picker color-primary-transparent"
                                                value="#38cab3" id="transparentPrimaryColorID" type="color"
                                                data-id="bg-color" data-id1="bg-hover" data-id2="bg-border"
                                                data-id3="primary" data-id4="primary" data-id9="transparentcolor"
                                                name="tranparentPrimary">
                                        </div>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Transparent Background</span>
                                        <div class="">
                                            <input
                                                class="wd-30 ht-30 input-transparent-color-picker color-bg-transparent"
                                                value="#38cab3" id="transparentBgColorID" type="color" data-id5="body"
                                                data-id6="theme" data-id9="transparentcolor"
                                                name="transparentBackground">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Transparent Bg-Image Style</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">BG-Image Primary</span>
                                        <div class="">
                                            <input
                                                class="wd-30 ht-30 input-transparent-color-picker color-bgImg-transparent"
                                                value="#38cab3" id="transparentBgImgPrimaryColorID" type="color"
                                                data-id="bg-color" data-id1="bg-hover" data-id2="bg-border"
                                                data-id3="primary" data-id4="primary" data-id9="transparentcolor"
                                                name="tranparentPrimary">
                                        </div>
                                    </div>
                                    <div class="switch-toggle">
                                        <a class="bg-img1 bg-img" href="javascript:void(0);"><img
                                                src="assets/img/media/bg-img1.jpg" id="bgimage1" alt="switch-img"></a>
                                        <a class="bg-img2 bg-img" href="javascript:void(0);"><img
                                                src="assets/img/media/bg-img2.jpg" id="bgimage2" alt="switch-img"></a>
                                        <a class="bg-img3 bg-img" href="javascript:void(0);"><img
                                                src="assets/img/media/bg-img3.jpg" id="bgimage3" alt="switch-img"></a>
                                        <a class="bg-img4 bg-img" href="javascript:void(0);"><img
                                                src="assets/img/media/bg-img4.jpg" id="bgimage4" alt="switch-img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft leftmenu-styles">
                            <h4>Leftmenu Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Light Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch3" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch3" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Color Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch4" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch4" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch5" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch5" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Gradient Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch2"
                                                id="myonoffswitch25" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch25" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft header-styles">
                            <h4>Header Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Light Header</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch3"
                                                id="myonoffswitch6" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch6" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Color Header</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch3"
                                                id="myonoffswitch7" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch7" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Dark Header</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch3"
                                                id="myonoffswitch8" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch8" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Gradient Header</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch3"
                                                id="myonoffswitch26" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch26" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Layout Width Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Full Width</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch4"
                                                id="myonoffswitch9" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch9" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Boxed</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch4"
                                                id="myonoffswitch10" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch10" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Layout Positions</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Fixed</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch5"
                                                id="myonoffswitch11" class="onoffswitch2-checkbox" checked>
                                            <label for="myonoffswitch11" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Scrollable</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch5"
                                                id="myonoffswitch12" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch12" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft vertical-switcher">
                            <h4>Sidemenu layout Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section">
                                    <div class="switch-toggle d-flex">
                                        <span class="me-auto">Default Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch13" class="onoffswitch2-checkbox default-menu" checked>
                                            <label for="myonoffswitch13" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Closed Menu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch30" class="onoffswitch2-checkbox default-menu">
                                            <label for="myonoffswitch30" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Icon with Text</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch14" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch14" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Icon Overlay</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch15" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch15" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Hover Submenu</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch32" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch32" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                    <div class="switch-toggle d-flex mt-2">
                                        <span class="me-auto">Hover Submenu style 1</span>
                                        <p class="onoffswitch2 my-0"><input type="radio" name="onoffswitch6"
                                                id="myonoffswitch33" class="onoffswitch2-checkbox">
                                            <label for="myonoffswitch33" class="onoffswitch2-label"></label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swichermainleft">
                            <h4>Reset All Styles</h4>
                            <div class="skin-body">
                                <div class="switch_section my-4">
                                    <button class="btn btn-danger btn-Block ResetCustomStyles" type="button">Reset All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Switcher -->

    <!-- Loader -->
    <!--<div id="global-loader">-->
    <!--	<img src="assets/img/preloader.svg" class="loader-img" alt="Loader">-->
    <!--</div>-->
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div>

        <div class="main-header side-header sticky nav nav-item">
                
                <?php include('./partials/navbar.php'); ?>
            
        </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php'); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form action="connection_files/create/referal_code_create.php" method="POST" enctype="multipart/form-data">

            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">add Referal
                                Code</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Courses</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Referal Code</li>
                                <li class="breadcrumb-item active" aria-current="page">add</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->




                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">


                                    <div class="">
                                        <div class="row row-xs formgroup-wrapper">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dropdown">Login Type</label>
                                                    <select id="dropdown1" onchange="showOptions1()"
                                                        class="form-control form-select select2"
                                                        data-bs-placeholder="Performer" name="Login_Type" required>
                                                        <option></option>
                                                        <option value="Employee">Employee</option>
                                                        <option value="College">College</option>
                                                        <option value="CollegeMentor">College Mentor</option>
                                                        <option value="Trainer">Trainer</option>
                                                        <option value="Company">Company</option>
                                                    </select>
                                                </div>
                                                <div id="optionsDiv">
                                                    <div class="col-md-6">
                                                        <div class="form-group">


                                                            <script>
                                                            function showOptions1() {
                                                                var harsha = document.getElementById("dropdown1").value;
                                                                if (harsha === "Employee") {
                                                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">Username</label>
<select name="Username" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="Bala Tripura Sundari">Bala Tripura Sundari</option>
<option value="Ammigalla Pavan">Ammigalla Pavan</option>
<option value="Shyam Kothapelly">Shyam Kothapelly</option>
<option value="Lolapwad Tarun Ramesh">Lolapwad Tarun Ramesh</option>
<option value="Gattu Pari Purna">Gattu Pari Purna</option>
<option value="Kotapati Madhu Varshini">Kotapati Madhu Varshini</option>
<option value="DEMO">DEMO</option>
<option value="ruchi">ruchi</option>
	
</select>

`;
                                                                } else if (harsha === "Company") {
                                                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">Username</label>
<select name="Username" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="Vispo Business Solutions">Vispo Business Solutions</option>
<option value="earnathome">earnathome</option>
<option value="andhra company">andhra company</option>
<option value="testing">testing</option>
<option value="DevSai">DevSai</option>
<option value="saiteja">saiteja</option>
<option value="InfoLumi Business Solutions">InfoLumi Business Solutions</option>
	
</select>

`;
                                                                } else if (harsha === "College") {
                                                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">Username</label>
<select name="Username" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="GNR Degree College">GNR Degree College</option>
<option value="Gayatri Degree & PG College">Gayatri Degree & PG College</option>
<option value="SNR Degree College">SNR Degree College</option>
<option value="SV Degree College">SV Degree College</option>
<option value="Vidya Degree College">Vidya Degree College</option>
<option value="Vijetha Junior & Degree College">Vijetha Junior & Degree College</option>
<option value="Vignana Sudha Degree & PG College">Vignana Sudha Degree & PG College</option>
<option value="R K Degree College">R K Degree College</option>
<option value="Krishnaveni Degree College">Krishnaveni Degree College</option>
<option value="S V S Degree College">S V S Degree College</option>
<option value="SRI VIVEKANANDA DEGREE COLLEGE">SRI VIVEKANANDA DEGREE COLLEGE</option>
<option value="Sri Y N Degree College">Sri Y N Degree College</option>
<option value="S V R M Degree College">S V R M Degree College</option>
<option value="S.V.G.M. GOVERNMENT DEGREE COLLEGE">S.V.G.M. GOVERNMENT DEGREE COLLEGE</option>
<option value="QSPIRE ">QSPIRE </option>
<option value="SAI PARAMESHWARA DEGREE COLLEGE">SAI PARAMESHWARA DEGREE COLLEGE</option>
<option value="Satya institute of Technology and Management">Satya institute of Technology and Management</option>
<option value="Sri Hari Degree College">Sri Hari Degree College</option>
<option value="SVR DEGREE COLLEGE">SVR DEGREE COLLEGE</option>
<option value=" BGBS Womens Degree College"> BGBS Womens Degree College</option>
<option value="Dadi Veerunaidu College">Dadi Veerunaidu College</option>
<option value="Aditya Degree College AWDCKKD">Aditya Degree College AWDCKKD</option>
<option value="Aditya Degree College ASCSKKD">Aditya Degree College ASCSKKD</option>
<option value="Aditya Degree College for women Rajahmundry">Aditya Degree College for women Rajahmundry</option>
<option value="Gayathri Degree College">Gayathri Degree College</option>
<option value="Aditya degree college">Aditya degree college</option>
<option value="universe">universe</option>
<option value="BRR & GKR CHAMBERS DEGREE & PG COLLEGE ">BRR & GKR CHAMBERS DEGREE & PG COLLEGE </option>
<option value="SRI ABN & PRR COLLEGE OF SCIENCE">SRI ABN & PRR COLLEGE OF SCIENCE</option>
<option value="S. V. K. P. & Dr. K. S. Raju Arts and Science College (A)">S. V. K. P. & Dr. K. S. Raju Arts and Science College (A)</option>
<option value="Gokul degree college">Gokul degree college</option>
<option value="Sir CR Reddy Degree College For Womens">Sir CR Reddy Degree College For Womens</option>
<option value="MCV DEGREE COLLEGE ">MCV DEGREE COLLEGE </option>
<option value="DR.SARVEPALLI RADHA KRISHNA DEGREE COLLEGE">DR.SARVEPALLI RADHA KRISHNA DEGREE COLLEGE</option>
<option value="Andhra Pradesh residential degree College">Andhra Pradesh residential degree College</option>
<option value="DONBOSCO DEGREE COLLEGE">DONBOSCO DEGREE COLLEGE</option>
<option value="SRI SAMHITHA DEGREE COLLEGE">SRI SAMHITHA DEGREE COLLEGE</option>
<option value="SRI VENKATESHWARA DEGREE COLLEGE ">SRI VENKATESHWARA DEGREE COLLEGE </option>
<option value="SRI VASAVI DEGREE COLLEGE">SRI VASAVI DEGREE COLLEGE</option>
<option value="Demo Degree College">Demo Degree College</option>
<option value="SV DEGREE COLLEGE PEDAGUMMULURU">SV DEGREE COLLEGE PEDAGUMMULURU</option>
<option value="AKRG Degree College">AKRG Degree College</option>
<option value="CNR Arts & Science College- Annamayya">CNR Arts & Science College- Annamayya</option>
<option value="Sri Balaji Vidya Vihar degree college">Sri Balaji Vidya Vihar degree college</option>
<option value="MVN JS & RVR College of Arts and Science">MVN JS & RVR College of Arts and Science</option>
<option value="Jyothirmayee women’s degree college ">Jyothirmayee women’s degree college </option>
<option value="Sree Devi degree college ">Sree Devi degree college </option>
<option value="Sapthagiri Degree college Hindupur">Sapthagiri Degree college Hindupur</option>
<option value="SPVM Degree College Gorantla">SPVM Degree College Gorantla</option>
<option value="SVV Degree College, Penumuru ">SVV Degree College, Penumuru </option>
<option value="Sri Rachapudy Nagabhushanam Degree & P.G College, Badvel">Sri Rachapudy Nagabhushanam Degree & P.G College, Badvel</option>
<option value="SMJL DEGREE COLLEGE, KADIRI-515 591">SMJL DEGREE COLLEGE, KADIRI-515 591</option>
<option value="SAI DEGREE COLLEGE">SAI DEGREE COLLEGE</option>
<option value="SPACE DEGREE FOR WOMEN                                  ">SPACE DEGREE FOR WOMEN                                  </option>
<option value="Vellore institute of Technology AP">Vellore institute of Technology AP</option>
	
</select>

`;
                                                                } else if (harsha === "CollegeMentor") {
                                                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">Username</label>
<select name="Username" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="KOMARAPURI GOVINDA">KOMARAPURI GOVINDA</option>
<option value="kiya">kiya</option>
<option value="V MURALI KRISHNA MADASU">V MURALI KRISHNA MADASU</option>
<option value="Dr Y.Ramesh">Dr Y.Ramesh</option>
<option value="M.Murthy">M.Murthy</option>
<option value="Naim Beig">Naim Beig</option>
<option value="M.s.v.v.v.prasad">M.s.v.v.v.prasad</option>
<option value="D. Madhuri Devi">D. Madhuri Devi</option>
<option value="K.Suresh Babu">K.Suresh Babu</option>
<option value="K Rama Krishna ">K Rama Krishna </option>
<option value="B.satyanarayana">B.satyanarayana</option>
<option value="Sasikala">Sasikala</option>
<option value="K Suribabu">K Suribabu</option>
<option value="demomentor">demomentor</option>
	
</select>

`;
                                                                } else if (harsha === "Trainer") {
                                                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">Username</label>
<select name="Username" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="Nandamuru Koteswara Rao">Nandamuru Koteswara Rao</option>
<option value="M Sandeep Kumar">M Sandeep Kumar</option>
<option value="Uma Kiran V">Uma Kiran V</option>
<option value="V Bala Tripura Sunadri">V Bala Tripura Sunadri</option>
<option value="SRIKANTH ">SRIKANTH </option>
<option value="Nikhil Chakka">Nikhil Chakka</option>
<option value="Shaik Ashraf rahil">Shaik Ashraf rahil</option>
<option value="Senthan M S V S">Senthan M S V S</option>
<option value="Shiva Krishna">Shiva Krishna</option>
<option value="Balaji">Balaji</option>
<option value="CH.Varsha">CH.Varsha</option>
<option value="demotrainer">demotrainer</option>
<option value="saitejaswi kolliboina">saitejaswi kolliboina</option>
<option value="Vasundhara">Vasundhara</option>
<option value="Narender">Narender</option>
<option value="Madhu Varshini">Madhu Varshini</option>
<option value="Saieshwari Gogu">Saieshwari Gogu</option>
<option value="tirdhala ashok">tirdhala ashok</option>
<option value="Ramu">Ramu</option>
<option value="G Venkatesh">G Venkatesh</option>
<option value="Mekanaboyina Venkata murali Krishna">Mekanaboyina Venkata murali Krishna</option>
<option value="demotesting">demotesting</option>
<option value="Madanu Augustin">Madanu Augustin</option>
<option value="jammu suresh kumar">jammu suresh kumar</option>
<option value="Tiruvidhula Naga Sai Priyanka">Tiruvidhula Naga Sai Priyanka</option>
<option value="Akhila V">Akhila V</option>
<option value="Shanti Kiran">Shanti Kiran</option>
<option value="Cmr 1">Cmr 1</option>
<option value="Cmr 2">Cmr 2</option>
<option value="Srinivas Yerrravelli">Srinivas Yerrravelli</option>
<option value="vijay kumar sampathi">vijay kumar sampathi</option>
<option value="K Bharath Kumar ">K Bharath Kumar </option>
<option value="Kishore Kumar ">Kishore Kumar </option>
<option value="preeti">preeti</option>
	
</select>

`;
                                                                } else {
                                                                    document.getElementById("optionsDiv").innerHTML =
                                                                        '';
                                                                }
                                                            }
                                                            </script>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">Referal Code</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputPersonalPhone" placeholder="Enter Referal Code"
                                                        name="Referal_Code" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputDOB">Starting Time</label>
                                                    <input class="form-control" id="start-date" placeholder="MM/DD/YYYY"
                                                        type="date" name="Starting_Time" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputDOB">Ending Time</label>
                                                    <input class="form-control" id="end-date" placeholder="MM/DD/YYYY"
                                                        type="date" name="Ending_Time" required>
                                                    <div id="message" style="color:red"></div>
                                                </div>

                                                <script>
                                                function checkDateRange() {
                                                    const startDate = new Date(document.getElementById("start-date")
                                                        .value);
                                                    const endDate = new Date(document.getElementById("end-date").value);

                                                    if (startDate < endDate) {
                                                        document.getElementById("message").textContent = "";
                                                        return true;
                                                    } else {
                                                        document.getElementById("message").textContent =
                                                            "Start date is greater than or equal to end date.";
                                                        return false;
                                                    }
                                                }
                                                </script>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputProEmail">% of Discount</label>
                                                    <input type="number" class="form-control" id="exampleInputProEmail"
                                                        placeholder="0-100 %" min="1" max="100" name="Discount"
                                                        required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputProEmail">Times of Usage</label>
                                                    <input type="number" class="form-control" min="1"
                                                        id="exampleInputProEmail" placeholder="" name="Times_of_Usage"
                                                        required>
                                                </div>
                                            </div>




                                        </div>
                                        <button type="submit" name="submit" onclick="return checkDateRange()"
                                            class="btn btn-info mt-3 mb-0" data-bs-target="#schedule"
                                            data-bs-toggle="modal" style="text-align:right">Add Referal Code</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Container closed -->
            </div>
        </form>



        <!-- Footer opened -->
        <div class="main-footer">
            <div class="container-fluid pd-t-0-f ht-100p">
                Copyright © 2023 <a href="www.triaright.in" class="text-primary">triaright</a>. Designed with <span
                    class="fa fa-heart text-danger"></span> by <a href="www.mycompany.co.in"> my company</a> . All
                rights reserved
            </div>
        </div>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./scripts.php"); ?>

</body>

</html>