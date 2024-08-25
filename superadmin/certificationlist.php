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
     <title>Certifications</title>
     <meta charset="UTF-8">
     <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="Description" content="">

     <?php include("./style.php"); ?>
 </head>

 <body class="ltr main-body app sidebar-mini">
     <?php
        include('./switcher.php');

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
                 <?php include('./partials/sidebar.php'); ?>
             </div>
             <!-- main-sidebar -->

         </div> <!-- main-content -->
         <div class="main-content app-content">

             <!-- container -->
             <div class="main-container container-fluid">


                 <div class="breadcrumb-header justify-content-between">
                     <div class="right-content">
                         <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Certification
                             List</span>
                     </div>

                     <div class="justify-content-center mt-2">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a>
                             </li>
                             <li class="breadcrumb-item ">Certification</li>
                             <li class="breadcrumb-item ">List</li>
                         </ol>
                     </div>

                 </div>
                 <form method="post">
                     <div class="row row-sm">

                         <div class="form-group col-md-3">
                             <b> <label>Course Name</label> </b>

                             <select name="course_name" class="form-control form-select"
                                 data-bs-placeholder="Select Filter">

                                 <option value="" selected="selected">ALL</option>
                                 <?php
                                    $query = "SELECT DISTINCT `course_name`,`course_id` FROM `certificate`";
                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                 <option value="<?= $row['course_id'] ?>"><?= $row['course_name'] ?>
                                 </option>
                                 <?php
                                    }
                                    ?>

                             </select>
                         </div>
                         <div class="form-group col-md-3">
                             <b> <label>College Name</label> </b>

                             <select name="college_name" class="form-control form-select"
                                 data-bs-placeholder="Select Filter">

                                 <option value="" selected="selected">ALL</option>
                                 <?php
                                    $query = "SELECT DISTINCT `college_name` FROM `student`";
                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if (!empty($row['college_name'])) {

                                    ?>
                                 <option value="<?= $row['college_name'] ?>"><?= $row['college_name'] ?>
                                 </option>
                                 <?php
                                        }
                                    }
                                    ?>

                             </select>
                         </div>

                         &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search"
                             style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
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
                                                 <th class="border-bottom-0">Student Id</th>
                                                 <th class="border-bottom-0">Student Name</th>
                                                 <th class="border-bottom-0">College Name</th>
                                                 <th class="border-bottom-0">Course Name</th>
                                                 <th class="border-bottom-0">Issued Date</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php
                                                $certificate = "SELECT * FROM `certificate` WHERE 1=1";

                                                if (isset($_POST["course_name"]) && !empty($_POST["course_name"])) {
                                                    $certificate .= " AND `course_id` = '" . $_POST["course_name"] . "'";
                                                }

                                                $run_certificate = mysqli_query($conn, $certificate);
                                                if (mysqli_num_rows($run_certificate) > 0) {
                                                    $i = 1;
                                                    while ($row = mysqli_fetch_array($run_certificate)) {
                                                        $std_query = "SELECT * FROM `student` WHERE `id` = '{$row['student_id']}'";
                                                        if (isset($_POST["college_name"]) && !empty($_POST["college_name"])) {
                                                            $std_query = "SELECT * FROM `student` WHERE `college_name` = '{$_POST["college_name"]}'";
                                                        }
                                                        
                                                        $student_query = mysqli_query($conn, $std_query);
                                                        $student_row = mysqli_fetch_array($student_query);
                                                        
                                                        if($student_row['id'] == $row['student_id']){
                                                    
                                                        echo "<tr>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td>STID_" . $row['student_id'] . "</td>";
                                                        echo "<td>" . $row['student_name'] . "</td>";

                                                        echo "<td>" . $student_row['college_name'] . "</td>";
                                                        echo "<td>" . $row['course_name'] . "</td>";
                                                        echo "<td>" . $row['uploaded_date'] . "</td>";
                                                        echo "</tr>";
                                                        $i++;
                                                        }
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


                 <div class="modal fade" id="allocate">
                     <div class="modal-dialog" role="document">
                         <div class="modal-content modal-content-demo">
                             <div class="modal-header">
                                 <h6 class="modal-title">confirmation Notification</h6><button aria-label="Close"
                                     class="btn-close" data-bs-dismiss="modal" type="button"><span
                                         aria-hidden="true">&times;</span></button>
                             </div>
                             <div class="modal-body">

                                 <p> Are you sure you want to allocate a student??</p>
                             </div>
                             <div class="modal-footer">
                                 <button class="btn ripple btn-success" type="button">allocate</button>
                                 <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Not
                                     Now</button>
                             </div>
                         </div>
                     </div>
                 </div>



             </div>
         </div>

     </div>



     <?php include("./scripts.php"); ?>

 </body>

 </html>