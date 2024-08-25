<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

if (isset($_POST["update"])) {
    $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contactNumber = $_POST["contact_number"];
    $collegeName = $_POST["college_name"];
    $collegePhoneNumber = $_POST["college_phone_number"];
    $representativeName = $_POST["college_representative_name"];
    $representativeContactNo = $_POST["college_representative_contact_no"];

    $representativeMailId = $_POST["college_representative_mail_id"];
    $district = $_POST["district"];
    $state = $_POST["state"];
    $pinCode = $_POST["pin_code"];
    $collegeStream = $_POST["college_stream"];
    $affiliatedUniversity = $_POST["affiliated_university"];
    $collegeWebsite = $_POST["college_website"];
    $collegeUsername = $_POST["college_username"];
    $collegeCode = $_POST["college_code"];

    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        $password = $_POST["old_password"];
    } else {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    if (!isset($_FILES["picture"]) || empty($_FILES["picture"])) {
        $picture = $_POST["old_image"];
    } else {
        $picture = $_FILES["picture"]["name"];
        $tmp_name = $_FILES["picture"]["tmp_name"];
    }

    $update_query =  mysqli_prepare($conn, "UPDATE `college` SET `name`=?,`username`=?,`password`=?,`email`=?,`contact_number`=?,`address`=?,`district`=?,`state`=?,`pin_code`=?,`representative_name`=?,`representative_contact_number`=?,`representative_email`=?,`college_streams`=?,`affiliated_university`=?,`website`=?,`college_code`=?,`picture`=? WHERE `id`= '$id'");
    $update_query->bind_param('sssssssssssssssss', $collegeName, $collegeUsername, $password, $email, $contactNumber, $address, $district, $state, $pinCode, $representativeName, $representativeContactNo, $representativeMailId, $collegeStream, $affiliatedUniversity, $collegeWebsite, $collegeCode, $picture);

    if ($update_query->execute()) {

        move_uploaded_file($tmp_name, "./assets/img/profile/$picture");

        header('location: profile.php');
        exit();
    }
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header('location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <!-- main-sidebar -->

    <!-- main-sidebar -->

    </div>

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php") ?>

            </div>

            <!-- /main-header -->

            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>
        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">MY Accounts</span>
                    </div>
                    <div class="justify-content-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
                <?php
                $query = mysqli_query($conn, "SELECT * FROM college WHERE username = '$_COOKIE[college_username]' AND password = '$_COOKIE[college_password]'");
                $data = mysqli_fetch_array($query);
                ?>

            </div>

            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12 col-md-12">
                    <div class="custom-card main-content-body-profile">
                        <div class="tab-content">
                            <div class="main-content-body tab-pane  active" id="about">
                                <div class="card">
                                    <div class="card-body border-0">
                                        <div class="mb-4 main-content-label"></div>
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $data["id"]; ?>">
                                            <!--	<div class="mb-4 main-content-label">Name</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $data["email"]; ?> ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $data["address"]; ?> ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Contact Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" value="<?php echo $data["contact_number"]; ?> ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_name" name="college_name" value=" <?php echo $data["name"]; ?> ">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Representative Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="college_representative_name" class="form-control" placeholder="college_representative_name" value="<?php echo $data["representative_name"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Representative Contact
                                                            No</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="Number" class="form-control" name="college_representative_contact_no" placeholder="college_representative_contact_no" value="<?php echo $data["representative_contact_number"]; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!--<div class="mb-4 main-content-label">Contact Info</div>-->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Representative Mail ID</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_representative_mail_id" name="college_representative_mail_id" value="<?php echo $data["representative_email"]; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">District</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="district" placeholder="district" value="<?php echo $data["district"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">State</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="state" class="form-control" placeholder="state" value="<?php echo $data["state"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Pincode</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control" placeholder="pin_code" name="pin_code" value="<?php echo $data["pin_code"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Stream</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_stream" name="college_stream" value="<?php echo $data["college_streams"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Affilated University</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="affiliated_university" name="affiliated_university" value="<?php echo $data["affiliated_university"]; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Website</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_website" name="college_website" value="<?php echo $data["website"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--	<div class="mb-4 main-content-label">Social Info</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Username</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_username" name="college_username" value="<?php echo $data["username"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Password</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="password">
                                                        <p class="text-danger">Leave It Empty If You Want Default
                                                            Password
                                                        </p>
                                                        <input type="hidden" name="old_password" value="<?php echo $data["password"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Code</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_code" name="college_code" value="<?php echo $data["college_code"]; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Profile Picture</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="file" name="picture" class="form-control" placeholder="Picture">
                                                        <p class="text-danger">Leave It Empty If You Want Default Image
                                                        </p>
                                                        <input type="hidden" name="old_image" value="<?php echo $data["picture"]; ?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <button type="submit" name="update" class="btn btn-dark">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php include("./script.php"); ?>
</body>

</html>