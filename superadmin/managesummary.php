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

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title> Manage Summary </title>

    <?php
    include('./style.php');
    ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php
    include('./switcher.php');
    ?>

    <!-- Loader -->
    <!-- <div id="global-loader">
			<img src="assets/img/preloader.svg" class="loader-img" alt="Loader">
		</div> -->
    <!-- /Loader -->

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


        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Summary </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a>
                            </li>
                            <li class="breadcrumb-item ">Summary</li>
                            <li class="breadcrumb-item ">Manage</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Batch Name</label> </b>
                            <select name="batch" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="">All</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT DISTINCT `batch_name` FROM `batches_summary`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    if (!empty($row['batch_name'])) {
                                        echo "<option value='" . $row['batch_name'] . "'>" . $row['batch_name'] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Date Of Summary</label> </b>
                            <select name="date" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="">All</option>

                                <?php
                                $query = mysqli_query($conn, "SELECT DISTINCT `date_of_summary` FROM `batches_summary`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    if (!empty($row['date_of_summary'])) {
                                        echo "<option value='" . $row['date_of_summary'] . "'>" . $row['date_of_summary'] . "</option>";
                                    }
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
                                                <th class="border-bottom-0">S.No</th>
                                                <th class="border-bottom-0">Date of Summary</th>
                                                <th class="border-bottom-0">Summary Id</th>

                                                <th class="border-bottom-0">Batch Name</th>
                                                <th class="border-bottom-0">Performer of the day</th>
                                                <th class="border-bottom-0">Topics to be Covered </th>
                                                <th class="border-bottom-0">Overall Feedback</th>
                                                <th class="border-bottom-0">Overall Attendance</th>

                                                <th class="border-bottom-0">Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $batch = "SELECT * FROM `batches_summary` WHERE 1=1";
                                            if(isset($_POST["batch"]) && !empty($_POST["batch"])) {
                                                $batch .= " AND `batch_name` = '" . $_POST["batch"] . "'";
                                            }
                                            if(isset($_POST["date"]) && !empty($_POST["date"])) {
                                                $batch .= " AND `date_of_summary` = '" . $_POST["date"] . "'";
                                            }
                                            $meeting_query = mysqli_query($conn, $batch);
                                            if (mysqli_num_rows($meeting_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($meeting_query)) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row['date_of_summary'] . "</td>";
                                                    echo "<td>SUMID_" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['batch_name'] . "</td>";
                                                    echo "<td>" . $row['performer_of_day'] . "</td>";
                                                    echo "<td>" . $row['topics_covered'] . "</td>";
                                                    echo "<td>" . $row['overall_feedback'] . "</td>";
                                                    echo "<td>" . $row['attendance'] . "%</td>";
                                                    echo "<td>
										<div class='col-sm-6 col-md-15 mg-t-10 mg-sm-t-0'>
											<button type='button' class='btn btn-info dropdown-toggle'
												data-bs-toggle='dropdown' aria-expanded='false'>
												<i class='bi bi-three-dots'></i>
											</button>

											<div class='dropdown-menu'>
												<a href='viewsummary.php?summary_id=" . $row['id'] . "' class='dropdown-item'>view</a>
												<a href='updatesummary.php?summary_id=" . $row['id'] . "'
													class='dropdown-item'>update</a>
												<a href='delete.php?summary_id=" . $row['id'] . "'
													class='dropdown-item'>Delete</a>
											</div>
										</div>
									</td>
									</tr>";
                                                }
                                            } else {

                                                echo "No Summary found";
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

    <?php
    include('./scripts.php');
    ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_unset()) {

        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    }

    ?>
</body>

</html>