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

if (isset($_POST["create"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    // Function to sanitize and validate input
    function sanitizeInput($input)
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    // Sanitize and validate each input
    $college_name = sanitizeInput($_POST["college_name"]);
    $college_code = sanitizeInput($_POST["college_code"]);
    $address = sanitizeInput($_POST["address"]);
    $district = sanitizeInput($_POST["district"]);
    $state = sanitizeInput($_POST["state"]);
    $pin_code = sanitizeInput($_POST["pin_code"]);
    $college_phone_number = sanitizeInput($_POST["college_phone_number"]);
    $college_mail_id = sanitizeInput($_POST["college_mail_id"]);
    $college_representative_name = sanitizeInput($_POST["college_representative_name"]);
    $college_representative_contact_no = sanitizeInput($_POST["college_representative_contact_no"]);
    $college_representative_mail_id = sanitizeInput($_POST["college_representative_mail_id"]);
    $college_stream = sanitizeInput($_POST["college_stream"]);
    $affiliated_university = sanitizeInput($_POST["affiliated_university"]);
    $college_website = sanitizeInput($_POST["college_website"]);
    $college_username = sanitizeInput($_POST["college_username"]);
    $password = sanitizeInput($_POST["password"]);

    // Hash the password
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

    if (empty($password)) {
        $select_query = mysqli_query($conn, "SELECT `password` FROM `college` WHERE `id` = '$id'");
        $row = mysqli_fetch_assoc($select_query);
        $hash_pass_fetch = $row["password"];
        $hash_pass = $hash_pass_fetch;
    }

    if (!empty($_POST["password"])) {
        function encrypt_Password($password, $key)
        {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            return base64_encode($iv . openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv));
        }

        $encryptedPassword = encrypt_Password($_POST['password'], $key);
    }


    $query = mysqli_prepare($conn, "UPDATE `college` SET `name`=?,`username`=?,`password`=?,`email`=?,`contact_number`=?,`address`=?,`district`=?,`state`=?,`pin_code`=?,`representative_name`=?,`representative_contact_number`=?,`representative_email`=?,`college_streams`=?,`affiliated_university`=?,`website`=?,`college_code`=?, `hashed_password`=? WHERE `id`='$id'");

    $query->bind_param("sssssssssssssssss", $college_name, $college_username, $hash_pass, $college_mail_id, $college_phone_number, $address, $district, $state, $pin_code, $college_representative_name, $college_representative_contact_no, $college_representative_mail_id, $college_stream, $affiliated_university, $college_website, $college_code, $encryptedPassword);

    if ($query->execute()) {
        $_SESSION["success"] = "College updated successfully";
        header('location: collegelist.php');
        exit();
    } else {
        $_SESSION["error"] = "Error updating college";
        header('location:./collegelist.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Create College</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">


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
        <form method="POST">

            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
                                College</span>
                        </div>
                        <?php if (isset($_SESSION["error"])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo "Error while creating. Error: '" . $_SESSION["error"] . "'"; ?>
                            </div>
                        <?php unset($_SESSION["error"]);
                            session_destroy();
                        } ?>
                        <?php if (isset($_SESSION["success"])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo "Successfully Created."; ?>
                            </div>
                        <?php unset($_SESSION["success"]);
                            session_destroy();
                        } ?>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Credentials</a></li>
                                <li class="breadcrumb-item active" aria-current="page">College</li>
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
                                    <div class="row row-xs formgroup-wrapper">
                                        <?php
                                        $id = $_GET["id"];
                                        if (isset($id)) {
                                            $sql = "SELECT * FROM `college` WHERE `id` = '$id'";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                        ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputName">College Name <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" value="<?php echo $row["name"]; ?>" class="form-control" id="exampleInputName" name="college_name" placeholder="Enter College Name" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputName">College Code</label>
                                                    <input type="text" value="<?php echo $row["college_code"]; ?>" class="form-control" id="exampleInputName" name="college_code" placeholder="Enter College Code">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">Address </label>
                                                    <input type="text" value="<?php echo $row["address"]; ?>" class="form-control " id="exampleInputPerEmail" name="address" rows="5" placeholder="Enter address">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">District</label>
                                                    <input type="text" value="<?php echo $row["district"]; ?>" class="form-control" id="exampleInputPerEmail" name="district" placeholder="Enter District">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">State</label>
                                                    <input type="text" value="<?php echo $row["state"]; ?>" class="form-control" id="exampleInputPerEmail" name="state" placeholder="Enter State">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">PIN code </label>
                                                    <input type="number" value="<?php echo $row["pin_code"]; ?>" class="form-control" id="exampleInputPerEmail" name="pin_code" placeholder="enter Pincode">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">College Phone Number<span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="number" value="<?php echo $row["contact_number"]; ?>" class="form-control" id="exampleInputPersonalPhone" name="college_phone_number" placeholder="Enter Contact Number" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">College Mail Id <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="email" class="form-control" id="exampleInputPerEmail" name="college_mail_id" value="<?php echo $row["email"]; ?>" placeholder="Enter Mail Id" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputCompanyPhone">College Represntative Name
                                                    </label>
                                                    <input type="Text" value="<?php echo $row["representative_name"]; ?>" class="form-control" id="exampleInputCompanyPhone" name="college_representative_name" placeholder="Enter Representative Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPersonalPhone">College Represntative Contact
                                                        No</label>
                                                    <input type="number" class="form-control" id="exampleInputPersonalPhone" name="college_representative_contact_no" value="<?php echo $row["representative_contact_number"]; ?>" placeholder="Enter Represntative Number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPerEmail">College Represntative Mail Id
                                                    </label>
                                                    <input type="email" value="<?php echo $row["representative_email"]; ?>" class="form-control" id="exampleInputPerEmail" name="college_representative_mail_id" placeholder="Enter Represntative Mail Id">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">College Streams</label>
                                                    <input type="text" value="<?php echo $row["college_streams"]; ?>" class="form-control" id="exampleInputQualification" name="college_stream" placeholder="B.SC,B.COM">
                                                </div>

                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">Affliated Univeristy</label>
                                                    <input type="text" value="<?php echo $row["affiliated_university"]; ?>" class="form-control" id="exampleInputQualification" name="affiliated_university" placeholder="Enter University Board">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputQualification">College Website<span style="color:#D3D3D3;font-size: 90%;">
                                                            (Optional)</span></label>
                                                    <input type="text" value="<?php echo $row["website"]; ?>" class="form-control" id="exampleInputQualification" name="college_website" placeholder="Enter Website">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">College Username<span style="color:#D3D3D3;font-size: 90%;"> (Mandatory</span>
                                                        <span style="color:red;font-size: 90%;">*</span><span style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                    <input type="text" class="form-control" id="exampleInputUserName" name="college_username" value="<?php echo $row["username"]; ?>" placeholder="Enter Username" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" minlength=8 maxlenght=10>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputRe-EnterPassword">Re-Enter Password</label>
                                                    <input type="password" class="form-control" id="retypepassword" minlength=8 maxlenght=10 name="re_enter_password" placeholder="Re-Enter Password">
                                                </div>
                                            </div>

                                            <button type="submit" name="create" value="create" class="btn btn-primary mt-3 mb-0" style="text-align:right" onclick="return check()">Update</button>
                                        <?php } ?>
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

</body>

</html>