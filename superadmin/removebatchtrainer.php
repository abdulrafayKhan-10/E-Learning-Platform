<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["remove"])) {
    $trainer_id = $_POST["trainer_id"];
    $course_id = $_POST["course_id"];
    $batch_id = $_POST["batch_id"];
    $status = "Removed";

    $update_query = mysqli_prepare($conn, "UPDATE `batch` SET `status`=? WHERE `id`=? AND `batchcourse_id`=? AND `batchtrainer_id`=?");

    $update_query->bind_param("ssss", $status, $batch_id, $course_id, $trainer_id);

    if ($update_query->execute()) {
        $_SESSION["success"] = "Batch Trainer Removed Successfully";
        header('location: ./removebatchtrainer.php?trainer_id=' . $trainer_id . '&course_id=' . $course_id . '&batch_id=' . $batch_id);
        exit();
    } else {
        $_SESSION["error"] = "Something went wrong. Please try again";
        header("location:./removebatchtrainer.php?trainer_id=' . $trainer_id . '&course_id=' . $course_id . '&batch_id=' . $batch_id");
        exit();
    }
}

if (!isset($_GET["trainer_id"]) && !isset($_GET["course_id"]) && !isset($_GET["batch_id"])) {
    header('location: ./managebatch.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Remove Batch Student</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php
    include("./switcher.php")

    ?>
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php"); ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Batch Allocation </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Student batch</li>
                            <li class="breadcrumb-item ">Create</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Course id</th>
                                                <th class="border-bottom-0">Trainer name</th>
                                                <th class="border-bottom-0">Course</th>
                                                <th class="border-bottom-0">Batch Name</th>
                                                <th class="border-bottom-0">Allocate </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $batch_id = filter_var($_GET["batch_id"], FILTER_SANITIZE_NUMBER_INT);
                                            $batch_id = (int) $batch_id;

                                            $course_id = filter_var($_GET["course_id"], FILTER_SANITIZE_SPECIAL_CHARS);


                                            $trainer_id = filter_var($_GET["trainer_id"], FILTER_SANITIZE_SPECIAL_CHARS);


                                            $query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `batchcourse_id` = '$course_id' AND `batchtrainer_id` = '$trainer_id'");

                                            if (mysqli_num_rows($query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    if ($row["status"] == "Active") {
                                                        echo "<tr>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td>" . $row["batchcourse_id"] . "</td>";
                                                        echo "<td>" . $row["batchtrainer_name"] . "</td>";
                                                        echo "<td>" . $row["batchcourse_name"] . "</td>";
                                                        echo "<td>" . $row["batch_name"] . "</td>";
                                                        echo "<form action='' method='post'>
														<input type='hidden' name='batch_id' value='" . $row["id"] . "'>
														<input type='hidden' name='course_id' value='" . $row["batchcourse_id"] . "'>
														<input type='hidden' name='trainer_id' value='" . $row["batchtrainer_id"] . "'>
                                                        <td><button type='submit' name='remove' class='btn btn-danger'>De-allocate</button></td>
														
                                                        </form>
														";

                                                        echo "</tr>";
                                                        $i++;
                                                    }
                                                }
                                            } else {
                                                echo "No data found";
                                            }
                                            ?>

                                            <tr>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("./scripts.php"); ?>
    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_destroy()) {
        session_start();
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    }

    ?>
</body>

</html>