<?php
session_start();
include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}
if (isset($_POST['submitBtn'])) {
    $description = $_POST['description'];
    $additional_information = $_POST['additional_information'];
    $shared_documents_name = $_FILES['shared_documents']['name'];
    $shared_documents_tmp = $_FILES['shared_documents']['tmp_name'];
    $date_of_documentation = $_POST['date_of_documentation'];
    $batch_id = $_POST['batch_id'];

    $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$batch_id'");
    $fetch_batch = mysqli_fetch_assoc($select_batch);
    if ($fetch_batch['id'] == $batch_id) {
        $batch_name = $fetch_batch['batch_name'];
        $insert_query = mysqli_prepare($conn, "INSERT INTO `batches_documentation`(`shared_documents`, `description`, `additional_information`, `date_of_documentation`, `batch_id`, `batch_name`) VALUES (?,?,?,?,?,?)");
        $insert_query->bind_param('ssssss', $shared_documents_name, $description, $additional_information, $date_of_documentation, $batch_id, $batch_name);

        if ($insert_query->execute()) {
            move_uploaded_file($shared_documents_tmp, "./assets/docs/supportive_docs/" . $shared_documents_name);
            $_SESSION['success'] = "Documentation Uploaded Successfully.";
            header("location:uploaddocumentation.php");
            exit();
        } else {
            $_SESSION["error"] = "Unexpected Error.";
            header("location:uploaddocumentation.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Something went wrong";
        header("location:uploaddocumentation.php");
        exit();
    }
}
$_SESSION["previous_url"] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>Add Documentation</title>
    <?php
    include('./style.php');
    ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php
    include('./switcher.php');
    ?>

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include('./partials/navbar.php') ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Upload
                                Documentations</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">batches management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Documentation</li>
                                <li class="breadcrumb-item active" aria-current="page">Upload</li>
                            </ol>
                        </div>
                    </div>


                </div>
                <br>

                <div class="form-group col-md-4">
                    <select name="batch_id" required class="form-control form-select select2"
                        data-bs-placeholder="Select Batch">
                        <?php
                        $trainer_id = $_COOKIE['trainer_id'];
                        $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE trainer_id = '$trainer_id'");
                        if (mysqli_num_rows($batch) > 0) {
                            while ($row = mysqli_fetch_assoc($batch)) {
                        ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['batch_name'] ?></option>
                        <?php
                            }
                        }

                        ?>
                    </select>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="">
                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode"> Shared Documents</label>
                                                <input type="file" class="form-control" id="exampleInputcode"
                                                    placeholder="" name="shared_documents" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode"> Description</label>
                                                <input type="text" class="form-control" id="exampleInputcode"
                                                    placeholder="" name="description" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode"> additional information</label>
                                                <input type="text" class="form-control" id="exampleInputcode"
                                                    placeholder="" name="additional_information">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Date of documentation</label>
                                                <input type="date" class="form-control" id="exampleInputcode"
                                                    placeholder="" name="date_of_documentation" required>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" name="submitBtn" class="btn btn-info mt-3 mb-0"
                                        data-bs-target="#schedule" data-bs-toggle="modal" style="text-align:right">Add
                                        Documentation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </form>
        <!-- Container closed -->
    </div>

    <?php
    include('./script.php');
    ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_unset()) {
        $_SESSION["previous_url"] = $_SERVER['REQUEST_URI'];
    }
    ?>
    <script>
    toastr.success('Hello world!')
    </script>
</body>


</html>