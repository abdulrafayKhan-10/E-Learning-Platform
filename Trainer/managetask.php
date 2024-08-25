<?php 
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
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
    <title> Manage Tasks</title>

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
                <?php include('./partials/navbar.php')?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php')?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form  method="POST" enctype="multipart/form-data">

            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
				<div class="main-container container-fluid">


<div class="breadcrumb-header justify-content-between">
	<div class="right-content">
		<span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Tasks </span>
	</div>

	<div class="justify-content-center mt-2">
		<ol class="breadcrumb">
			<li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a>
			</li>
			<li class="breadcrumb-item ">Tasks</li>
			<li class="breadcrumb-item ">Manage</li>
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
								<th class="border-bottom-0">S.No</th>
								<th class="border-bottom-0">Task Name</th>
								<th class="border-bottom-0">Allocated Students Type</th>
								<th class="border-bottom-0">Task Description </th>
								<th class="border-bottom-0">Task End Date</th>
								<th class="border-bottom-0">Batch Name</th>

								<th class="border-bottom-0">Actions</th>

							</tr>
						</thead>
						<tbody>
							<?php
				$task_query = mysqli_query($conn, "SELECT * FROM `batches_tasks`");
				if (mysqli_num_rows($task_query) > 0) {
					$i = 1;
					while ($row = mysqli_fetch_assoc($task_query)) {

						echo "<tr>";
						echo "<td>" . $i++ . "</td>";
						echo "<td>" . $row['task_name'] . "</td>";
						echo "<td>" . $row['allocated_students_type'] . "</td>";
						echo "<td>" . $row['task_description'] . "</td>";
						echo "<td>" . $row['task_end_date'] . "</td>";
						echo "<td>" . $row['batch_name'] . "</td>";
						echo "<td>
						<div class='col-sm-6 col-md-15 mg-t-10 mg-sm-t-0'>
							<button type='button' class='btn btn-info dropdown-toggle'
								data-bs-toggle='dropdown' aria-expanded='false'>
								<i class='fe fe-more-horizontal'></i>
							</button>

							<div class='dropdown-menu'>
								<a href='viewtasks.php?task_id=" . $row['id'] . "' class='dropdown-item'>view</a>
								<a href='updatetasks.php?task_id=" . $row['id'] . "'
									class='dropdown-item'>update</a>
								<a href='delete.php?task_id=" . $row['id'] . "'
									class='dropdown-item'>Delete</a>
							</div>
						</div>
					</td>
					</tr>";
					}
				} else {
				
					echo "No Tasks found";
				
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
    </div>
    </div>
    </div>



    </div>
    <!-- Container closed -->
    </div>
    </form>



    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php 
	 include('./script.php'); 
	  ?>

</body>

<!-- Mirrored from laravel8.spruko.com/nowa/emptypage by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:40 GMT -->

</html>