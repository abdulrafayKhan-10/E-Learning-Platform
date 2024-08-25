 <?php
    session_start();

    include('../db_connection/connection.php');

    if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
        header('location: ../super-admin_login.php');
        exit();
    }

    if (isset($_POST["upload"])) {
        $id = (int) $_POST["id"];
        $name = $_POST["name"];

        $crid = (int) $_POST["crid"];
        $coursename = $_POST["coursename"];
        $certificate = $_FILES["certificate"]["name"];
        $certificate_temp = $_FILES["certificate"]["tmp_name"];

        $query = "INSERT INTO `certificate`(`student_id`, `student_name`, `course_id`, `course_name`, `certificate`) VALUES (?,?,?,?,?)";

        $run_query = mysqli_prepare($conn, $query);
        $run_query->bind_param("isiss", $id, $name, $crid, $coursename, $certificate);

        if ($run_query->execute()) {
            $_SESSION["success"] = "Certificate Uploaded Successfully";
            move_uploaded_file($certificate_temp, "./assets/docs/certificate/" . $certificate);
            header('location: ./studentcertificate.php?crid=' . $crid . '&coursename=' . $coursename);
            exit();
        } else {
            $_SESSION["error"] = "Something went wrong";
            header('location: ./studentcertificate.php?crid=' . $crid . '&coursename=' . $coursename);
            exit();
        }
    }

    if (!isset($_GET["crid"]) || empty($_GET["crid"]) && !isset($_POST["coursename"])) {
        header('location: ./certificationupload.php');
        exit();
    }

    ?>

 <!DOCTYPE html>
 <html lang="en">


 <head>
     <title>Upload Student Certificate</title>
     <meta charset="UTF-8">
     <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="Description" content="">


     <?php include("./style.php") ?>
 </head>

 <body class="ltr main-body app sidebar-mini">
     <?php include("./switcher.php") ?>
     <!-- Page -->
     <div class="page">

         <div>

             <div class="main-header side-header sticky nav nav-item">
                 <?php include("./partials/navbar.php") ?>
             </div>
             <!-- /main-header -->

             <!-- main-sidebar -->
             <div class="sticky">
                 <?php include("./partials/sidebar.php") ?>
             </div>
             <!-- main-sidebar -->

         </div> <!-- main-content -->
         <div class="main-content app-content">

             <!-- container -->
             <div class="main-container container-fluid">


                 <div class="breadcrumb-header justify-content-between">
                     <div class="right-content">
                         <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Upload Certificates
                         </span>
                     </div>

                     <div class="justify-content-center mt-2">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship Management</a>
                             </li>
                             <li class="breadcrumb-item ">Certification</li>
                             <li class="breadcrumb-item ">Upload</li>
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
                                                 <th class="border-bottom-0">S.no</th>
                                                 <th class="border-bottom-0">Student Id</th>
                                                 <th class="border-bottom-0">Student Name</th>
                                                 <th class="border-bottom-0">College Name</th>
                                                 <th class="border-bottom-0">Full Info.</th>
                                                 <th class="border-bottom-0">Upload </th>
                                             </tr>
                                         </thead>
                                         <tbody>

                                             <?php
                                                $id = filter_var($_GET['crid'], FILTER_SANITIZE_NUMBER_INT);
                                                $id = (int) $id;

                                                $course_name = filter_var($_GET['coursename'], FILTER_SANITIZE_SPECIAL_CHARS);


                                                $query = "SELECT * FROM `course_registration` WHERE `course_id` = '$id'";
                                                $result = mysqli_query($conn, $query);
                                                if (mysqli_num_rows($result) > 0) {
                                                    $i = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $student_query = "SELECT * FROM `student` WHERE `id` = '$row[student_id]'";
                                                        $student_result = mysqli_query($conn, $student_query);
                                                        if (mysqli_num_rows($student_result) > 0) {
                                                            $student_row = mysqli_fetch_assoc($student_result);
                                                            echo "<tr>";
                                                            echo "<td>" . $i . "</td>";
                                                            echo "<td>STID_" . $student_row['id'] . "</td>";
                                                            echo "<td>" . $student_row['name'] . "</td>";
                                                            echo "<td>" . $student_row['college_name'] . "</td>";
                                                            echo "<td><a href='./viewstudent.php?id=" . $student_row['id'] . "' class='btn btn-info'>View</a></td>";
                                                            echo '<td><!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#certificate_' . $i . '">
Upload Certiticate</button>

<!-- Modal -->
<div class="modal fade" id="certificate_' . $i . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Certificate</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="./studentcertificate.php" enctype="multipart/form-data">
			<input type="hidden" name="id" value="' . $student_row['id'] . '">
			<input type="hidden" name="name" value="' . $student_row['name'] . '">
			
			<input type="hidden" name="crid" value="' . $row['id'] . '">
			<input type="hidden" name="coursename" value="' . $course_name . '">
			<label>Upload Certificate<span class="text-danger">*</span></label>
			<input type="file" name="certificate" class="form-control" required>
			<button type="submit" class="btn btn-primary" name="upload">Save Changes</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div></td>';
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



             </div>
             <!-- Container closed -->
         </div>

         <?php include("./scripts.php") ?>

         <?php
            if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
                echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
            } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
                echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
            }
            if (session_destroy()) {
                session_start();
                $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
            }

            ?>
 </body>

 </html>