<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Courses filter
    $courseFilter = isset($_POST['course_name']) ? $_POST['course_name'] : '';
    $courseFilterQuery = ($courseFilter != '') ? " AND course.course_name = '$courseFilter'" : '';

    // Handle Trainer filter
    $trainerFilter = isset($_POST['trainer_name']) ? $_POST['trainer_name'] : '';
    $trainerFilterQuery = ($trainerFilter != '') ? " AND trainer.name = '$trainerFilter'" : '';

    // Modify your existing SQL query to include the filters
    $allocation_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` 
                                            INNER JOIN `trainer` ON allocate_trainer_course.trainer_id = trainer.id
                                            INNER JOIN `course` ON allocate_trainer_course.course_id = course.id
                                            WHERE 1 $courseFilterQuery $trainerFilterQuery");
} else {
    // If the form is not submitted, fetch all records
    $allocation_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` 
                                            INNER JOIN `trainer` ON allocate_trainer_course.trainer_id = trainer.id
                                            INNER JOIN `course` ON allocate_trainer_course.course_id = course.id");
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Allocation Trainer List</title>
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

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Allocate Trainers
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Allocate</li>
                            <li class="breadcrumb-item ">Trainer </li>
                            <li class="breadcrumb-item ">Manage </li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-4">
                            <b> <label>Courses</label> </b>
                            <select name="course_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <?php
                                $course = mysqli_query($conn, "SELECT * FROM `course`");
                                if (mysqli_num_rows($course) > 0) {
                                    while ($row = mysqli_fetch_assoc($course)) {
                                        $isAllocated = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `course_id` = '" . $row['id'] . "'");
                                        if (mysqli_num_rows($isAllocated) > 0) {
                                            echo "<option value='" . $row['course_name'] . "'>" . $row['course_name'] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <b> <label>Trainer</label> </b>
                            <select name="trainer_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <?php
                                $trainer = mysqli_query($conn, "SELECT * FROM `trainer`");
                                if (mysqli_num_rows($trainer) > 0) {
                                    while ($row = mysqli_fetch_assoc($trainer)) {
                                        $isAllocated = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `trainer_id` = '" . $row['id'] . "'");
                                        if (mysqli_num_rows($isAllocated) > 0) {
                                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>
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

                                                <th class="border-bottom-0">Allocate ID</th>
                                                <th class="border-bottom-0">Trainer ID</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Course name</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($allocation_query) > 0) {
                                                $i = 1;
                                                while ($al = mysqli_fetch_assoc($allocation_query)) {
                                                    echo "<tr>
                                                            <td>" . $i . "</td>
                                                            <td>" . $al['created_date'] . "</td>
                                                            <td>ALL_" . $al['id'] . "</td>
                                                            <td>TRALLID_" . $al['trainer_id'] . "</td>
                                                            <td>" . $al['name'] . "</td>
                                                            <td>" . $al['course_name'] . "</td>
                                                        </tr>";
                                                    $i++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No records found</td></tr>";
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