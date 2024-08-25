<?php


include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Documentation List</title>
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
                <?php include('./partials/sidebar.php'); ?>
            </div>
            <!-- main-sidebar -->

        </div> <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Documentation List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a></li>
                            <li class="breadcrumb-item ">Documentation</li>
                            <li class="breadcrumb-item ">List</li>
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
                                                <th class="border-bottom-0">Date of Adding</th>
                                                <th class="border-bottom-0">Description</th>
                                                <th class="border-bottom-0">Document</th>
                                                <th class="border-bottom-0">Additional Information</th>
                                                <th class="border-bottom-0">Batch Name</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
				$doc_query = mysqli_query($conn, "SELECT * FROM `batches_documentation`");
				if (mysqli_num_rows($doc_query) > 0) {
					$i = 1;
					while ($row = mysqli_fetch_assoc($doc_query)) {

						echo "<tr>";
						echo "<td>" . $i++ . "</td>";
						echo "<td>" . $row['date_of_documentation'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";?>
                          <td> <a href="./assets/docs/supportive_docs/<?php echo $row['shared_documents']?>"
                                  class="btn btn-info" download="">Download</a> </td>
                          <?php
						echo "<td>" . $row['additional_information'] . "</td>";
						echo "<td>" . $row['batch_name'] . "</td>";
					
				
					echo "</tr>";
					}
				} else {
				
					echo "No Documentation found";
				
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
    <?php include("./script.php"); ?>

</body>

</html>