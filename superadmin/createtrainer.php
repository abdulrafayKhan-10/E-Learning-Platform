<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["submit"])) {
    $Trainer_Name = $_POST["Trainer_Name"];
    $Personal_Phone_Number = $_POST["Personal_Phone_Number"];
    $Personal_Mail_id = $_POST["Personal_Mail_id"];
    $Date_Of_Birth = $_POST["Date_Of_Birth"];
    $Aadhar_Card_No = $_POST["Aadhar_Card_No"];
    $Upload_Aadhar_Card = $_FILES["Upload_Aadhar_Card"]["name"];
    $Upload_Aadhar_Card_Tmp = $_FILES["Upload_Aadhar_Card"]["tmp_name"];
    $Pan_Card_No = $_POST["Pan_Card_No"];
    $Upload_Pan_Card = $_FILES["Upload_Pan_Card"]["name"];
    $Upload_Pan_Card_Tmp = $_FILES["Upload_Pan_Card"]["tmp_name"];
    $Date_Of_joining = $_POST["Date_Of_joining"];
    $Qualification = $_POST["Qualification"];
    $Any_Experience = $_POST["Any_Experience"];
    $Previous_Current_Organization_name = $_POST["Previous/Current_Organization_name"];
    $Designation = $_POST["Designation"];
    $Trainer_Documents = $_FILES["Trainer_Documents"]["name"];
    $Trainer_Documents_Tmp = $_FILES["Trainer_Documents"]["tmp_name"];
    $Trainer_Username = $_POST["Trainer_Username"];
    $Password = $_POST["Password"];
    $hash_pass = password_hash($Password, PASSWORD_DEFAULT);
    $created_by = "admin";

    $query = mysqli_prepare($conn, "INSERT INTO `trainer`(`name`, `contact_number`, `email`, `password`, `username`, `dob`, `aadhar_card_number`, `aadhar_card_picture`, `pan_card_number`, `pan_card_picture`, `date_of_joining`, `qualification`, `experience`, `organization_name`, `designation`, `trainer_document`, `ip`, `created_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $query->bind_param("ssssssssssssssssss", $Trainer_Name, $Personal_Phone_Number, $Personal_Mail_id, $hash_pass, $Trainer_Username, $Date_Of_Birth, $Aadhar_Card_No, $Upload_Aadhar_Card, $Pan_Card_No, $Upload_Pan_Card, $Date_Of_joining, $Qualification, $Any_Experience, $Previous_Current_Organization_name, $Designation, $Trainer_Documents, $ip, $created_by);

    if ($query->execute()) {
        move_uploaded_file($Upload_Aadhar_Card_Tmp, "./assets/img/trainer/" . $Upload_Aadhar_Card);
        move_uploaded_file($Upload_Pan_Card_Tmp, "./assets/img/trainer/" . $Upload_Pan_Card);
        move_uploaded_file($Trainer_Documents_Tmp, "./assets/docs/trainer/" . $Trainer_Documents);
        $_SESSION["success"] = "Trainer Added Successfully";
        header('location:createtrainer.php');
    } else {
        $_SESSION["error"] = "Something went wrong";
        header('location:createtrainer.php');
    }
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <title>Create Trainer</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <?php if (isset($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "</script>";
    } ?>

    <?php include("./switcher.php"); ?>
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">

                <?php include('./partials/navbar.php'); ?>

            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
                                Trainer</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Credentials</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Trainer</li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                                                    <label for="exampleInputName">Trainer Name <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control" name="Trainer_Name"
                                                        id="exampleInputName" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone">Personal Phone Number <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="number" required class="form-control"
                                                        name="Personal_Phone_Number" maxlength="14" minlength="10"
                                                        id="exampleInputCompanyPhone"
                                                        placeholder="Enter Contact Number">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail"> Personal Mail Id <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="email" required class="form-control"
                                                        name="Personal_Mail_id" id="exampleInputPerEmail"
                                                        placeholder="Enter Mail Id">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputDOB">Date of Birth <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input class="form-control" required name="Date_Of_Birth"
                                                        id="dateMask" placeholder="YYYY/MM/DD" type="date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">Aadhar Card No <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="number" required class="form-control"
                                                        name="Aadhar_Card_No" id="exampleInputQualification"
                                                        placeholder="Enter Aadhar Card Number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Upload Aadhar Card <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="file" required class="form-control"
                                                        name="Upload_Aadhar_Card" id="exampleInputcode" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar">PAN Card No <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control" name="Pan_Card_No"
                                                        id="exampleInputAadhar" placeholder="Enter Pan Card Number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Upload PAN Card <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="file" required class="form-control"
                                                        id="exampleInputcode" name="Upload_Pan_Card" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Date of joining <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input class="form-control" required name="Date_Of_joining"
                                                        id="dateMask" placeholder="YYYY/MM/DD" type="date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">Qualification <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control"
                                                        name="Qualification" id="exampleInputQualification"
                                                        placeholder="Enter qualification">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputExperience">Any Experience <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <select class="form-control form-select select2" required
                                                        name="Any_Experience" id="exampleInputExperience"
                                                        data-bs-placeholder="Enter Experience">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Previous/Current Organisation Name
                                                        <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control"
                                                        name="Previous/Current_Organization_name"
                                                        id="exampleInputUserName" placeholder="Enter Company Name">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Designation <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control" name="Designation"
                                                        id="exampleInputDesignation" placeholder="Enter Designation">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Trainer Documents <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="file" class="form-control" required
                                                        name="Trainer_Documents" id="exampleInputcode" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Trainer Username <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" required class="form-control"
                                                        name="Trainer_Username" id="exampleInputUserName"
                                                        placeholder="Enter Username">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Password <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="password" required class="form-control" minlength=8
                                                        maxlength=10 name="Password" id='password'
                                                        placeholder="Enter Password">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputRe-EnterPassword">Re-Enter Password <span
                                                            style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span
                                                            style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="password" required class="form-control" minlength=8
                                                        maxlength=10 id='retypepassword'
                                                        placeholder="Re-Enter Password">
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary mt-3 mb-0" onclick="return check()"
                                                style="text-align:right">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Container closed -->
            </div>

        </form>

        <script type="text/javascript">
        function check() {
            var b = document.getElementById('password').value;
            var c = document.getElementById('retypepassword').value;
            if (b != c) {
                alert('Password doesnt match');
                return false;
            } else
                return true;
        }
        </script>


    </div>
    <!-- End Page -->

    <?php include("./scripts.php"); ?>
    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    // session_start();
    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    // echo "<script>toastr.success('" . $_SESSION["previous_url"] . "')</script>"
    ?>

</body>

</html>