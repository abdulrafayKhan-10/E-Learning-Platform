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

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>My Students</title>

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


        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Student List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item ">Student</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post">
                    <div class="row row-sm">

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

                        <button type="submit" class="btn btn-primary" name="searchBtn" style="height:40px;width:80px;"
                            value="search">Search</button>
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
                                                <th class="border-bottom-0">S.No</th>
                                                <th class="border-bottom-0">Date of adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College</th>
                                                <th class="border-bottom-0">stream</th>

                                                <th class="border-bottom-0">View Profile</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                          
											<?php
                                            if(isset($_POST['searchBtn']) || isset($_COOKIE["trainer_id"])) {
                                            
                                    
                                            
                                                // Check if batch_id is provided via POST or trainer_id via COOKIE
                                                $id = isset($_POST['batch_id']) ? $_POST['batch_id'] : $_COOKIE["trainer_id"];
                                            
                                                // Fetch batch information
                                                $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$id'");
                                                if($select_batch) {
                                                    $batch_data = mysqli_fetch_assoc($select_batch);
                                                    if ($batch_data) {
                                                        $trainer_id = $batch_data['trainer_id'];
                                            
                                                        // Fetch trainer information
                                                        $select_trainer = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE trainer_id = '$trainer_id'");
                                                        if($select_trainer) {
                                                            $trainer_data = array();
                                                            while($fetch_trainer = mysqli_fetch_assoc($select_trainer)) {
                                                                $trainer_data[] = $fetch_trainer;
                                                            }
                                            
                                                            // Fetch student information
                                                            $student_data = array();
                                                            foreach($trainer_data as $trainer) {
                                                                $trainer_allocate_id = $trainer['id'];
                                                                $select_student_allocate = mysqli_query($conn, "SELECT * FROM `student_allocate` WHERE allocate_id = '$trainer_allocate_id'");
                                                                if($select_student_allocate) {
                                                                    while($fetch_student_allocate = mysqli_fetch_assoc($select_student_allocate)) {
                                                                        $student_id = $fetch_student_allocate['student_id'];
                                                                        $select_student = mysqli_query($conn, "SELECT * FROM `student` WHERE id = '$student_id'");
                                                                        if($select_student) {
                                                                            while($fetch_student = mysqli_fetch_assoc($select_student)) {
                                                                                $student_data[] = $fetch_student;
                                                                            }
                                                                        } else {
                                                                            echo "Error fetching student: " . mysqli_error($conn);
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo "Error fetching student allocation: " . mysqli_error($conn);
                                                                }
                                                            }
                                            
                                                            // Process fetched data and output HTML table rows
                                                            $i = 1;
                                                            foreach($student_data as $student) {
                                                                echo "<tr>";
                                                                echo "<td>".$i++."</td>";
                                                                echo "<td>".$student['creation_date']."</td>";
                                                                echo "<td> STUD_".$student['id']."</td>";
                                                                echo "<td>".$student['name']."</td>";
                                                                echo "<td>".$student['college_name']."</td>";
                                                                echo "<td>".$student['semester']."</td>";
                                                                echo "<td><a class='btn btn-info' href='studentprofile.php?id=".$student['id']."'>View</a></td>";
                                                                echo "</tr>";
                                            }
                                                        } else {
                                                            echo "Error fetching trainer data: " . mysqli_error($conn);
                                                        }
                                                    } else {
                                                        echo "No batch found for the given ID.";
                                                    }
                                                } else {
                                                    echo "Error fetching batch data: " . mysqli_error($conn);
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


                <div class="modal fade" id="Delete">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal" type="button"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <p> Are you sure you want to Delete a student?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="button">Delete</button>
                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="Block">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal" type="button"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <p> Are you sure you want to Block a student?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="button">Block</button>
                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="Unblock">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal" type="button"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <p> Are you sure you want to Unblock a student?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="button">Unblock</button>
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
    </div>
    <!-- main-content closed -->

    <!-- Sidebar-right-->




    <!-- Footer opened -->

    <!-- Footer closed -->


    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php 
	 include('./script.php'); 
	  ?>

</body>

<!-- Mirrored from laravel8.spruko.com/nowa/table-data by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2022 16:32:58 GMT -->

</html>