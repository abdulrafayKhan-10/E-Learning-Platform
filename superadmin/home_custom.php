<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["customize"])) {
    $logo = $_FILES["logo"]["name"];
    $logo_tmp = $_FILES["logo"]["tmp_name"];
    $heading_one = $_POST["heading_one"];
    $paragraph = $_POST["paragraph"];
    $image = $_FILES["picture"]["name"];
    $image_tmp = $_FILES["picture"]["tmp_name"];

    $insert_query = mysqli_prepare($conn, "INSERT INTO `home_section_one`(`nav_logo`, `heading_one`, `paragraph`, `image`) VALUES (?,?,?,?)");
    $insert_query->bind_param("ssss", $logo, $heading_one, $paragraph, $image);

    if ($insert_query->execute()) {
        $_SESSION["success"] = "Home Customized Successfully";
        move_uploaded_file($logo_tmp, "./assets/img/home/" . $logo);
        move_uploaded_file($image_tmp, "./assets/img/home/" . $image);

        header('location: home_custom.php');
        exit();
    }
}
if (isset($_POST["modify"])) {
    $select = mysqli_query($conn, "SELECT * FROM `home_section_one`");
    $fetch = mysqli_fetch_assoc($select);

    $heading_one = $_POST["heading_one"];
    $paragraph = $_POST["paragraph"];
    $logo = $_FILES["logo"]["name"];
    $logo_tmp = $_FILES["logo"]["tmp_name"];
    $image = $_FILES["picture"]["name"];
    $image_tmp = $_FILES["picture"]["tmp_name"];

    // Check if the logo is empty
    if (empty($logo)) {
        // Use the default logo from the database
        $logo = $fetch["nav_logo"];
    }

    // Check if the image is empty
    if (empty($image)) {
        // Use the default image from the database
        $image = $fetch["image"];
    }

    $update_query = mysqli_prepare($conn, "UPDATE `home_section_one` SET `nav_logo`=?, `heading_one`=?, `paragraph`=?, `image`=?");
    $update_query->bind_param("ssss", $logo, $heading_one, $paragraph, $image);

    if ($update_query->execute()) {
        // Upload new logo if provided
        $_SESSION["success"] = "Home Customized Successfully";
        if (!empty($logo_tmp) && $logo_tmp !== $fetch["nav_logo"]) {
            move_uploaded_file($logo_tmp, "./assets/img/home/" . $logo);
        }

        // Upload new image if provided
        if (!empty($image_tmp) && $image_tmp !== $fetch["image"]) {
            move_uploaded_file($image_tmp, "./assets/img/home/" . $image);
        }

        header('location: home_custom.php');
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong";
        header('location: home_custom.php');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Customize Home</title>

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
                <?php include('./partials/sidebar.php'); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Customize Home</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Sections</a></li>
                                <li class="breadcrumb-item " aria-current="page">Customization</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->


                    <!-- /row -->
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM `home_section_one`");
                    if (mysqli_num_rows($select) > 0) {
                        $row = mysqli_fetch_assoc($select);
                    ?>

                    <section>
                        <div class="container">

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div id="wizard3">
                                                <h1>Section - 1</h1>
                                                <h3>Customize Section 1</h3>
                                                <hr>
                                                <section>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Navbar Logo</label>

                                                        <input type="file" name="logo" class="form-control required"
                                                            placeholder="logo">
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Heading One (H1 Tag)</label>
                                                        <input type="text" name="heading_one"
                                                            class="form-control required"
                                                            value="<?php echo $row['heading_one']; ?>"
                                                            placeholder="Heading" required>
                                                    </div>

                                                    <div class="range-container">
                                                        <label class="form-label">Paragraph: (320 Chars Only)</label>

                                                    </div>
                                                    <div class="control-group form-group">
                                                        <input type="text" name="paragraph" class="form-control"
                                                            maxlength="320" value="<?php echo $row['paragraph']; ?>"
                                                            placeholder="Paragraph" required>
                                                    </div>
                                                    <div class="control-group form-group mb-2">
                                                        <label class="form-label">Picture</label>
                                                        <input type="file" name="picture" class="form-control required"
                                                            placeholder="Picture">
                                                    </div>

                                                </section>
                                                <button name="modify" value="submit" type="submit"
                                                    class="btn btn-primary mt-3 mb-0"
                                                    style="text-align:right">Customize</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>

                    <?php
                    } else {

                    ?>
                    <section>
                        <div class="container">

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div id="wizard3">
                                                <h1>Section - 1</h1>
                                                <h3>Customize Section 1</h3>
                                                <hr>
                                                <section>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Navbar Logo</label>

                                                        <input type="file" name="logo" class="form-control required"
                                                            placeholder="logo" required>
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Heading One (H1 Tag)</label>
                                                        <input type="text" name="heading_one"
                                                            class="form-control required" placeholder="Heading"
                                                            required>
                                                    </div>

                                                    <div class="range-container">
                                                        <label class="form-label">Paragraph: (320 Chars Only)</label>

                                                    </div>
                                                    <div class="control-group form-group">
                                                        <input type="text" name="paragraph" class="form-control"
                                                            maxlength="320" placeholder="Paragraph" required>
                                                    </div>
                                                    <div class="control-group form-group mb-2">
                                                        <label class="form-label">Picture</label>
                                                        <input type="file" name="picture" class="form-control required"
                                                            placeholder="Picture" required>
                                                    </div>

                                                </section>
                                                <button name="customize" value="submit" type="submit"
                                                    class="btn btn-primary mt-3 mb-0"
                                                    style="text-align:right">Customize</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                    <?php } ?>
                    <!-- row -->

                    <!-- row closed -->


                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->
        </form>


    </div>
    <!-- End Page -->

    <?php include("./scripts.php"); ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>
</body>

</html>