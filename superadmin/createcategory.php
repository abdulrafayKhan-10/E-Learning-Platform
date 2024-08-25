<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST['create'])) {
    $category_name = $_POST['category'];
    $sql = "INSERT INTO `course_category` (`category_name`) VALUES ('$category_name')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['success'] = "Category created successfully";
        header('location: createcategory.php');
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong";
        header('location: createcategory.php');
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
    <title>Create Category</title>

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Switcher -->
    <?php include("./switcher.php"); ?>
    <!-- End Switcher -->

    <!-- Page -->
    <div class="page">


        <div class="main-header side-header sticky nav nav-item">

            <?php include('./partials/navbar.php'); ?>

        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        <div class="sticky">
            <?php include('./partials/sidebar.php') ?>
        </div>
        <!-- main-sidebar -->


        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Create Category</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:void(0);">Category</a></li>
                                <li class="breadcrumb-item " aria-current="page">Create</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->


                    <!-- /row -->

                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div id="wizard3">
                                        <h3>Overview</h3>
                                        <section>
                                            <div class="control-group form-group">
                                                <label class="form-label">Category Name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span> <span
                                                        style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control required" name="category"
                                                    placeholder="Category Name" required>
                                            </div>

                                        </section>
                                        <button name="create" value="submit" type="submit"
                                            class="btn btn-primary mt-3 mb-0" style="text-align:right">Create</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
        // session_destroy();
    } else if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }

    session_destroy();

    ?>
</body>

</html>