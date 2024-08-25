<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Trainer Allocation</title>
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
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Allocate Trainers
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">allocate</li>
                            <li class="breadcrumb-item ">Trainer</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">

                        <div class="form-group col-md-4">
                            <P><b>Qualification</b> </p>
                            <select name="qualification" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query_cat = "SELECT DISTINCT `qualification` FROM `trainer`";
                                $result_cat = mysqli_query($conn, $query_cat);
                                if (mysqli_num_rows($result_cat) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_cat)) {
                                        if (!empty($row["qualification"]) && $row["qualification"] != '') {
                                            echo "<option value='" . $row["qualification"] . "'>" . $row["qualification"] . "</option>";
                                        }
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <P><b>Added Date</b> </p>
                            <select name="date" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query_p = "SELECT DISTINCT `creation_date` FROM `trainer`";
                                $result = mysqli_query($conn, $query_p);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {


                                        echo "<option value='" . $row["creation_date"] . "'>" . $row["creation_date"] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                </form>

                <br>
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
                                                <th class="border-bottom-0">Date of adding</th>

                                                <th class="border-bottom-0">Trainer ID</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Qualification</th>
                                                <th class="border-bottom-0">Experience</th>
                                                <th class="border-bottom-0">Details</th>

                                                <th class="border-bottom-0">User status</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $trainer_query = "SELECT * FROM `trainer` WHERE 1=1";

                                            if (isset($_POST['qualification']) && !empty($_POST['qualification'])) {
                                                $qualification = $_POST['qualification'];
                                                $trainer_query .= " AND `qualification` = '{$qualification}'";
                                            }

                                            if (isset($_POST['date']) && !empty($_POST['date'])) {
                                                $date = $_POST['date'];
                                                $trainer_query .= " AND `creation_date` = '{$date}'";
                                            }

                                            $query = mysqli_query($conn, $trainer_query);


                                            if (mysqli_num_rows($query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['creation_date']; ?></td>
                                                <td>TRID_<?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['qualification']; ?></td>
                                                <td><?php echo $row['experience']; ?></td>
                                                <td><a href="./view_trainer.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-info">Details</a></td>

                                                <td>
                                                    <a href="allocatetrainercourse.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-info">Allocate</a>
                                                    <?php }
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


            </div>
        </div>

    </div>


    <?php include("./scripts.php"); ?>
</body>

</html>