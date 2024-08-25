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
    <title>Internship Registrations</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php") ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Add Internship
                            Registrations</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship</a></li>
                            <li class="breadcrumb-item ">Registrations</li>
                            <li class="breadcrumb-item ">Add</li>
                        </ol>
                    </div>

                </div>

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
                                                <th class="border-bottom-0">S.No</th>

                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Internship ID</th>
                                                <th class="border-bottom-0">Role</th>
                                                <th class="border-bottom-0">Vacancies</th>
                                                <th class="border-bottom-0">Last date</th>
                                                <th class="border-bottom-0">add student</th>





                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
											$select_reg_query = mysqli_query($conn, "SELECT internship_id, MIN(applied_date) AS applied_date FROM `internship_registration` GROUP BY internship_id");

											if ($select_reg_query) {
												$i = 1;
												while ($row = mysqli_fetch_assoc($select_reg_query)) {
													$select_internship = mysqli_query($conn, "SELECT `id`, `internship`, `vacancies`, `last_date_to_apply` FROM `internship` WHERE `id`='{$row["internship_id"]}'");

													if ($select_internship) {
														if (mysqli_num_rows($select_internship) > 0) {
															$fetch_internship = mysqli_fetch_assoc($select_internship);
															echo "<tr>";
															echo "<td>" . $i++ . "</td>";
															echo "<td>" . $row["applied_date"] . "</td>";
															echo "<td>INTID_" . $fetch_internship["id"] . "</td>";
															echo "<td>" . $fetch_internship["internship"] . "</td>";
															echo "<td>" . $fetch_internship["vacancies"] . "</td>";
															echo "<td>" . $fetch_internship["last_date_to_apply"] . "</td>";
															echo "<td><a href='selectstudent.php?id=" . $fetch_internship["id"] . "&type=internship' class='btn btn-info'>Add Student</a></td>";
															echo "</tr>";
														}
													} else {
														// Handle query execution error
														echo "Error executing internship query: " . mysqli_error($conn);
													}
												}
											} else {
												// Handle query execution error
												echo "Error executing internship registration query: " . mysqli_error($conn);
											}
											?>

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
	}
	if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
		echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
	}
	session_destroy();
	?>
</body>

</html>