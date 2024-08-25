<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Check if form is submitted
//     $college_name = mysqli_real_escape_string($conn, $_POST['college_name']);
//     $trainer_name = mysqli_real_escape_string($conn, $_POST['Trainer_Name']);
//     $course_name = mysqli_real_escape_string($conn, $_POST['course']);

//     // Build the query based on selected filters
//    $filter_query = "SELECT sa.id, sa.student_id, sa.allocate_id, sa.course_id, sa.date
//                  FROM student_allocate sa
//                  JOIN trainer t ON sa.allocate_id = t.id
//                  JOIN course c ON sa.course_id = c.id
//                  JOIN student s ON sa.student_id = s.id
//                  WHERE 1";

// if (!empty($college_name)) {
//     $filter_query .= " AND s.college_name = '$college_name'";
// }

// if (!empty($trainer_name)) {
//     $filter_query .= " AND t.name = '$trainer_name'";
// }

// if (!empty($course_name)) {
//     $filter_query .= " AND c.course_name = '$course_name'";
// }

// $student_allocate_query = mysqli_query($conn, $filter_query);

// if (!$student_allocate_query) {
//     die('Error executing filter query: ' . mysqli_error($conn));
// }
// } else {
//     // If the form is not submitted, fetch all records
//     $student_allocate_query = mysqli_query($conn, "SELECT * FROM `student_allocate`");

//     if (!$student_allocate_query) {
//         die('Error executing query: ' . mysqli_error($conn));
//     }
// }

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>



<!DOCTYPE html>
<html lang="en">


<head>
    <title>Manage Student Allocation</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage allocate Students
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">allocate</li>
                            <li class="breadcrumb-item ">Students </li>
                            <li class="breadcrumb-item ">Manage </li>
                        </ol>
                    </div>

                </div>

                <!-- <form method="post">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>College name</label> </b>
                            <select name="college_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>None</option>
                                <?php
    // $college_query = mysqli_query($conn, "SELECT DISTINCT `name` FROM `college`");
    // while ($college_row = mysqli_fetch_assoc($college_query)) {
    //     echo "<option value='" . $college_row["name"] . "'>" . $college_row["name"] . "</option>";
    // }
    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>
                            <select name="Trainer_Name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>None</option>
                                <?php
    // $trainer_query = mysqli_query($conn, "SELECT DISTINCT `name` FROM `trainer`");
    // while ($trainer_row = mysqli_fetch_assoc($trainer_query)) {
    //     echo "<option value='" . $trainer_row["name"] . "'>" . $trainer_row["name"] . "</option>";
    // }
    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <b> <label>Course name</label> </b>
                            <select name="course" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>None</option>
                                <?php
    // $course_query = mysqli_query($conn, "SELECT DISTINCT `course_name` FROM `course`");
    // while ($course_row = mysqli_fetch_assoc($course_query)) {
    //     echo "<option value='" . $course_row["course_name"] . "'>" . $course_row["course_name"] . "</option>";
    // }
    ?>
                            </select>
                        </div>

                       <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>
                       
                    </div>
                </form> -->
                <!-- 
                <br>
                <br> -->
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

                                                <th class="border-bottom-0">Allocate ID</th>
                                                <th class="border-bottom-0">Student ID</th>
                                                <th class="border-bottom-0">College Name</th>
                                                <th class="border-bottom-0">Student Name</th>
                                                <th class="border-bottom-0">Course name</th>
                                                <th class="border-bottom-0">Trainer name</th>
                                                <!--	<th class="border-bottom-0">Re-allocate</th> -->
                                                <th class="border-bottom-0">Delete</th>



                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
											$student_allocate_query = mysqli_query($conn, "SELECT * FROM `student_allocate`");
if (mysqli_num_rows($student_allocate_query) > 0) {
    $i = 1;
    while ($std_alloc = mysqli_fetch_assoc($student_allocate_query)) {
        $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '{$std_alloc['student_id']}'");
        if (mysqli_num_rows($student_query) > 0) {
            $std = mysqli_fetch_assoc($student_query);
            $trainer_alloc_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `id` = '{$std_alloc['allocate_id']}'");
            if (mysqli_num_rows($trainer_alloc_query) > 0) {
                $id = $std_alloc['id'];
                $tr = mysqli_fetch_assoc($trainer_alloc_query);
                $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = '{$tr['trainer_id']}'");
                if (mysqli_num_rows($trainer_query) > 0) {
                    $trainer = mysqli_fetch_assoc($trainer_query);
                    $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '{$std_alloc['course_id']}'");
                    if (mysqli_num_rows($course_query) > 0) {
                        $course = mysqli_fetch_assoc($course_query);
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $std_alloc['date'] . "</td>";
                        echo "<td>STDALLOCID_" . $std_alloc['allocate_id'] . "</td>";
                        echo "<td>STU_" . $std['id'] . "</td>";
                        echo "<td>" . $std['college_name'] . "</td>";
                        echo "<td>" . $std['name'] . "</td>";
                        echo "<td>" . $course['course_name'] . "</td>";
                        echo "<td>" . $trainer['name'] . "</td>";
                        echo '<td><a href="./delete.php?id=' . $id . '&type=student_unallocate" class="btn btn-danger">Delete</a></td>';
                        echo "</tr>";
                    } else {
                        echo "No Course found";
                    }
                } else {
                    echo "No Trainer found";
                }
            } else {
                echo "No Trainer Allocated";
            }
        } else {
            echo "No Student found";
        }
    }
} else {
    echo "No data found";
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
    <!-- Container closed -->


    <?php include("./scripts.php"); ?>
</body>

</html>