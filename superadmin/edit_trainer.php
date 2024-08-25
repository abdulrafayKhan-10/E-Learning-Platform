<?php
session_start();

include('../db_connection/connection.php');

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Access the secret key
$secretKey = $_ENV['SECRET_KEY'] ?: 'HE!!O123';

$key = $secretKey;

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("location:trainerlist.php");
    exit();
}

if (isset($_POST["submit"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $id = (int)$id;

    $query = "SELECT * FROM `trainer` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    $trainer = mysqli_fetch_assoc($result);

    $Trainer_Name = $_POST["Trainer_Name"];
    $Personal_Phone_Number = $_POST["Personal_Phone_Number"];
    $Personal_Mail_id = $_POST["Personal_Mail_id"];
    $Date_Of_Birth = $_POST["Date_Of_Birth"];
    $password = $_POST["Password"];
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $created_by = $trainer["created_by"];
    $Aadhar_Card_No = $_POST["Aadhar_Card_No"];
    $Pan_Card_No = $_POST["Pan_Card_No"];
    $Date_Of_joining = $_POST["Date_Of_joining"];
    $Qualification = $_POST["Qualification"];
    $Any_Experience = $_POST["Any_Experience"];
    $Previous_Current_Organization_name = $_POST["Previous/Current_Organization_name"];
    $Designation = $_POST["Designation"];
    $Trainer_Username = $_POST["Trainer_Username"];


    $Trainer_Documents = $_FILES["Trainer_Documents"]["name"];
    $Trainer_Documents_Tmp = $_FILES["Trainer_Documents"]["tmp_name"];
    $Upload_Aadhar_Card = $_FILES["Upload_Aadhar_Card"]["name"];
    $Upload_Aadhar_Card_Tmp = $_FILES["Upload_Aadhar_Card"]["tmp_name"];
    $Upload_Pan_Card = $_FILES["Upload_Pan_Card"]["name"];
    $Upload_Pan_Card_Tmp = $_FILES["Upload_Pan_Card"]["tmp_name"];

    if (empty($Trainer_Documents)) {
        $Trainer_Documents = $trainer["trainer_document"];
    }
    if (empty($Upload_Aadhar_Card)) {
        $Upload_Aadhar_Card = $trainer["aadhar_card_picture"];
    }
    if (empty($Upload_Pan_Card)) {
        $Upload_Pan_Card = $trainer["pan_card_picture"];
    }
    if (empty($password)) {
        $hash_pass = $trainer["password"];
    }

    if (!empty($_POST["Password"])) {
        function encrypt_Password($password, $key)
        {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            return base64_encode($iv . openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv));
        }

        $encryptedPassword = encrypt_Password($_POST['Password'], $key);
    }

    $query = mysqli_prepare($conn, "UPDATE `trainer` SET `name`=?,`contact_number`=?,`email`=?,`password`=?,`username`=?,`dob`=?,`aadhar_card_number`=?,`aadhar_card_picture`=?,`pan_card_number`=?,`pan_card_picture`=?,`date_of_joining`=?,`qualification`=?,`experience`=?,`organization_name`=?,`designation`=?,`trainer_document`=?,`created_by`=?, `hashed_password`=? WHERE `id`='$id'");

    $query->bind_param("ssssssssssssssssss", $Trainer_Name, $Personal_Phone_Number, $Personal_Mail_id, $hash_pass, $Trainer_Username, $Date_Of_Birth, $Aadhar_Card_No, $Upload_Aadhar_Card, $Pan_Card_No, $Upload_Pan_Card, $Date_Of_joining, $Qualification, $Any_Experience, $Previous_Current_Organization_name, $Designation, $Trainer_Documents, $created_by, $encryptedPassword);

    if ($query->execute()) {
        move_uploaded_file($Upload_Aadhar_Card_Tmp, "./assets/img/trainer/" . $Upload_Aadhar_Card);
        move_uploaded_file($Upload_Pan_Card_Tmp, "./assets/img/trainer/" . $Upload_Pan_Card);
        move_uploaded_file($Trainer_Documents_Tmp, "./assets/docs/trainer/" . $Trainer_Documents);
        $_SESSION["success"] = "Trainer Edited Successfully";
        header('location:edit_trainer.php');
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong";
        header('location:edit_trainer.php');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <title>Edit Trainer</title>
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

                    <?php if (isset($_GET["id"]) && !empty($_GET["id"])) {
                        $id = $_GET["id"];
                        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                        $id = (int)$id;
                        $query = "SELECT * FROM `trainer` WHERE `id`='$id'";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            $trainer = mysqli_fetch_assoc($result);
                            $name = $trainer["name"];
                            $contact_number = $trainer["contact_number"];
                            $email = $trainer["email"];
                            $password = $trainer["password"];
                            $username = $trainer["username"];
                            $dob = $trainer["dob"];
                            $aadhar_card_number = $trainer["aadhar_card_number"];
                            $aadhar_card_picture = $trainer["aadhar_card_picture"];
                            $pan_card_number = $trainer["pan_card_number"];
                            $pan_card_picture = $trainer["pan_card_picture"];
                            $date_of_joining = $trainer["date_of_joining"];
                            $qualification = $trainer["qualification"];
                            $experience = $trainer["experience"];
                            $organization_name = $trainer["organization_name"];
                            $designation = $trainer["designation"];
                            $trainer_document = $trainer["trainer_document"];
                            $password = $trainer["password"];
                    ?>
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName">Trainer Name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" required class="form-control" name="Trainer_Name"
                                                    id="exampleInputName" value="<?php echo $name; ?>"
                                                    placeholder="Enter Name">
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
                                                    id="exampleInputCompanyPhone" value="<?php echo $contact_number; ?>"
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
                                                    name="Personal_Mail_id" value="<?php echo $email; ?>"
                                                    id="exampleInputPerEmail" placeholder="Enter Mail Id">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Birth <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input class="form-control" required name="Date_Of_Birth" id="dateMask"
                                                    placeholder="YYYY/MM/DD" type="date"
                                                    value="<?php echo $dob ? $dob : date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputQualification">Aadhar Card No</label>
                                                <input type="number" class="form-control" name="Aadhar_Card_No"
                                                    value="<?php echo $aadhar_card_number; ?>"
                                                    id="exampleInputQualification"
                                                    placeholder="Enter Aadhar Card Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Upload Aadhar Card </label>
                                                <input type="file" class="form-control" name="Upload_Aadhar_Card"
                                                    id="exampleInputcode" placeholder="">
                                                <img src="./assets/img/trainer/<?php echo $aadhar_card_picture; ?>"
                                                    alt="Aadhar Card Picture">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">PAN Card No</label>
                                                <input type="text" class="form-control" name="Pan_Card_No"
                                                    id="exampleInputAadhar" placeholder="Enter Pan Card Number"
                                                    value="<?php echo $pan_card_number; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode"> Upload PAN Card </label>
                                                <input type="file" class="form-control" id="exampleInputcode"
                                                    name="Upload_Pan_Card" placeholder="">
                                                <img src="./assets/img/trainer/<?php echo $pan_card_picture; ?>"
                                                    alt="Pan Card Picture">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Date of joining </label>
                                                <input class="form-control" name="Date_Of_joining" id="dateMask"
                                                    placeholder="YYYY/MM/DD"
                                                    value="<?php echo $date_of_joining ? $date_of_joining : date('Y-m-d'); ?>"
                                                    type="date">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputQualification">Qualification </label>
                                                <input type="text" class="form-control" name="Qualification"
                                                    id="exampleInputQualification" value="<?php echo $qualification; ?>"
                                                    placeholder="Enter qualification">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputExperience">Any Experience</label>
                                                <select class="form-control form-select select2" name="Any_Experience"
                                                    id="exampleInputExperience" data-bs-placeholder="Enter Experience">
                                                    <?php if (!empty($any_experience)) {
                                                            ?>
                                                    <option value="<?php echo $any_experience; ?>">Default:
                                                        <?php echo $any_experience; ?></option>
                                                    <?php } ?>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Previous/Current Organization Name
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="Previous/Current_Organization_name" id="exampleInputUserName"
                                                    value="<?php echo $organization_name; ?>"
                                                    placeholder="Enter Company Name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Designation</label>
                                                <input type="text" class="form-control" name="Designation"
                                                    id="exampleInputDesignation" value="<?php echo $designation; ?>"
                                                    placeholder="Enter Designation">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Trainer Documents</label>
                                                <input type="file" class="form-control" name="Trainer_Documents"
                                                    id="exampleInputcode" placeholder="">
                                                <a class="text-danger"
                                                    href="./assets/docs/trainer/<?php echo $trainer_document; ?>"
                                                    download=""><?php echo $trainer_document; ?></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Trainer Username <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" required class="form-control" name="Trainer_Username"
                                                    value="<?php echo $username; ?>" id="exampleInputUserName"
                                                    placeholder="Enter Username">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Password <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="password" class="form-control" minlength=8 maxlength=10
                                                    name="Password" id='password' placeholder="Enter Password">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputRe-EnterPassword">Re-Enter Password <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="password" class="form-control" minlength=8 maxlength=10
                                                    id='retypepassword' placeholder="Re-Enter Password">
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" value="submit"
                                            class="btn btn-primary mt-3 mb-0" onclick="return check()"
                                            style="text-align:right">Update</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                        }
                    } ?>


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

</body>

</html>