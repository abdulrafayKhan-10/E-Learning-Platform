<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Profile</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Update Profile</span>
                    </div>
                    <div class="justify-content-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Modify</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->
                <?php
                $query = mysqli_query($conn, "SELECT * FROM college WHERE username = '$_COOKIE[college_username]' AND password = '$_COOKIE[college_password]'");
                $data = mysqli_fetch_array($query);
                ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card">
                            <div class="card-body d-md-flex">
                                <div class="">
                                    <span class="profile-image pos-relative">
                                        <?php if (empty($data["picture"]) || !file_exists("./assets/img/profile/" . $data["picture"])) { ?>
                                            <img class="br-5" alt="" src="../assets/Icons/user-profile.png">

                                        <?php } else {
                                            echo '<img class="br-5" alt="" src="./assets/img/profile/' . $data["picture"] . '">';
                                        } ?>
                                    </span>
                                </div>
                                <div class="my-md-auto prof-details">
                                    <h4 class="font-weight-semibold ms-md-4 ms-0 mb-3 pb-0"><span style="color:#ff6700">
                                    </h4>

                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-phone me-2"></i></span><span class="font-weight-semibold me-2">Phone:</span><span><?php echo $data["contact_number"]; ?></span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="fa fa-envelope me-2"></i></span><span class="font-weight-semibold me-2">Email:</span><span>
                                            <?php echo $data["email"]; ?>
                                        </span>
                                    </p>
                                    <p class="text-muted ms-md-4 ms-0 mb-3"><span><i class="far fa-flag me-2"></i></span><span class="font-weight-semibold me-2">Address:</span><span>
                                            <?php echo $data["address"]; ?>
                                        </span>
                                    </p>

                                    &nbsp

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12 col-md-12">
                    <div class="custom-card main-content-body-profile">
                        <div class="tab-content">
                            <div class="main-content-body tab-pane  active" id="about">
                                <div class="card">
                                    <div class="card-body border-0">
                                        <div class="mb-4 main-content-label">College Information</div>
                                        <form class="form-horizontal">
                                            <!--	<div class="mb-4 main-content-label">Name</div> -->
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_name" value="<?php echo $data["name"]; ?> " disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Phone Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_phone_number" value="<?php echo $data["contact_number"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Representative Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_representative_name" value="<?php echo $data["representative_name"]; ?>" disabled>
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
                                                        <input type="Number" readonly class="form-control" placeholder="college_representative_contact_no" value="<?php echo $data["representative_contact_number"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Mail ID</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_mail_id" value="<?php echo $data["email"]; ?>" disabled>
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
                                                        <input type="text" class="form-control" placeholder="college_representative_mail_id" value="<?php echo $data["representative_email"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="address" value="<?php echo $data["address"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">District</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="district" value="<?php echo $data["district"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">State</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="state" value="<?php echo $data["state"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Pincode</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control" placeholder="pin_code" value="<?php echo $data["pin_code"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Stream</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_stream" value="<?php echo $data["college_streams"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Affilated University</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="affiliated_university" value="<?php echo $data["affiliated_university"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Website</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_website" value="<?php echo $data["website"]; ?>" disabled>
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
                                                        <input type="text" class="form-control" placeholder="college_username" value="<?php echo $data["username"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Password</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="password" value="<?php echo $data["password"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">College Code</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="college_code" value="<?php echo $data["college_code"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Created Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="created_date" value="<?php echo $data["creation_date"]; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <a href="updateprofile.php?id=<?php echo $data["id"]; ?>" class="btn btn-info">Update
                                                Profile</a>
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