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
    <title>Testimonial Management</title>
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

                <?php include('./partials/navbar.php'); ?>

            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div> <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Internship
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item ">Create</li>
                            <li class="breadcrumb-item ">Manage</li>
                        </ol>
                    </div>

                </div>

                <br>
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
                                                <th class="border-bottom-0">Studen Name</th>
                                                <th class="border-bottom-0">Message</th>
                                                <th class="border-bottom-0">Rating</th>
                                                <th class="border-bottom-0">Picture</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM `testimonials`");
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $id = $row["id"];
                                                echo "<tr>";
                                                echo "<td>{$i}</td>";
                                                echo "<td>{$row['name']}</td>";
                                                echo "<td>{$row['message']}</td>";
                                                echo "<td>{$row['rating']}</td>";
                                                echo "<td><img src='./assets/img/testimonial/{$row['picture']}' width='100px' ></td>";
                                                echo '<td>
                                                    <div class="col-sm-6 col-md-15 mg-t-10 mg-sm-t-0">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a href="update_testimonial.php?id=' . $id . '" class="dropdown-item">Update</a>
                                                          
                                                           
                                                            <a class="btn dropdown-item" href="./delete.php?id=' . $id . '&type=testimony">Delete</a>

                                                        </div><!-- dropdown-menu -->
                                                    </div>
                                                </td>';
                                                echo "</tr>";
                                                $i++;
                                            }

                                            ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->

            </div>
        </div>

    </div>

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