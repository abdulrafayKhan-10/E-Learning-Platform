<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

$select_query = "SELECT * FROM `stream` WHERE 1=1";

if (isset($_POST['location'])) {
    $location = $_POST['location'];
    $select_query .= " AND `stream_location` LIKE '$location%'";
}

$select_query_run = mysqli_query($conn, $select_query);
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <title>Manage Stream</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php") ?>

    <?php
    if (isset($_SESSION['message_success']) && !empty($_SESSION['message_success'])) {
        echo "<script>toastr.success('{$_SESSION["message_success"]}')</script>";
    }
    ?>

    <?php
    if (isset($_SESSION['message_failed']) && !empty($_SESSION['message_failed'])) {
        echo "<script>toastr.error('" . $_SESSION["err_msg"] . "')</script>";
    }

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

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Streams </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">company</li>
                            <li class="breadcrumb-item ">Pending</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">

                        <div class="form-group col-md-4">
                            <P><b>Stream Location / Category</b> </p>
                            <select name="location" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query = "SELECT DISTINCT `stream_location` FROM `stream`";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {


                                        echo "<option value='" . $row["stream_location"] . "'>" . $row["stream_location"] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                </form>
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.No</th>
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Stream ID</th>
                                                <th class="border-bottom-0">Category</th>
                                                <th class="border-bottom-0">Name</th>

                                                <th class="border-bottom-0">update</th>
                                                <th class="border-bottom-0">Delete</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($select_query_run) > 0) {

                                                while ($i = mysqli_fetch_assoc($select_query_run)) {


                                            ?>
                                            <tr>
                                                <td><?php echo $i["id"] ?></td>
                                                <td><?php echo $i["date"] ?></td>
                                                <td>TRSTRM_<?php echo $i["id"] ?></td>
                                                <td><?php echo $i["stream_location"] ?></td>
                                                <td><?php echo $i["stream_name"] ?></td>

                                                <td> <a href="updatestream.php?id=<?php echo $i["id"] ?>"
                                                        class="btn btn-info">update</a>
                                                </td>
                                                <td> <a class="btn btn-danger"
                                                        href="delete.php?id=<?php echo $i["id"] ?>&type=stream">Delete</a>
                                                </td>

                                            </tr>
                                            <?php

                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->




                <div class="modal fade" id="reject">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal" type="button"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <p> Are you sure you want to Delete a stream?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="button">Reject</button>
                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>

    </div>
    <!-- Container closed -->


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