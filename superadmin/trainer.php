<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

$query_t = "SELECT * FROM `trainer` WHERE 1=1";

if (isset($_POST["trainer_name"]) && !empty($_POST["trainer_name"])) {
    $trainer_name = $_POST["trainer_name"];
    $query_t .= " AND `username` = '$trainer_name'";
}
$select_query = mysqli_query($conn, $query_t);


?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <title>Trainers Details</title>

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

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Trainer list </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">Trainer</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>
                            <select name="trainer_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM `trainer`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $row['username'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search"
                            style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
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
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Contact Number</th>
                                                <th class="border-bottom-0">Date Of Birth</th>
                                                <th class="border-bottom-0">Aadhar Card No#</th>

                                                <th class="border-bottom-0">Pan Card Number</th>
                                                <th class="border-bottom-0">Aadhar Picture</th>
                                                <th class="border-bottom-0">Pan Card Picture</th>

                                                <th class="border-bottom-0">Trainer Document</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($select_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($select_query)) {
                                            ?>

                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['dob']; ?></td>

                                                <td><?php echo $row['aadhar_card_number']; ?></td>
                                                <td><?php echo $row['pan_card_number']; ?></td>
                                                <td><a href="./assets/img/trainer/<?php echo $row['aadhar_card_picture']; ?>"
                                                        target="_blank" class="btn btn-info">View</a></td>
                                                <td><a href="./assets/img/trainer/<?php echo $row['pan_card_picture']; ?>"
                                                        target="_blank" class="btn btn-info">View</a></td>
                                                <td><a href="./assets/docs/trainer/<?php echo $row['trainer_document']; ?>"
                                                        target="_blank" download="" class="btn btn-success">Download</a>
                                                </td>


                                            </tr>

                                            <?php
                                                }
                                            } else { ?>
                                            <?php echo "No data found";
                                            } ?>

                                        </tbody>
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