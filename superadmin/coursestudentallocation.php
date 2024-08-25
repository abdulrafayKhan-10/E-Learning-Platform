<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["type"]) || !isset($_GET["id"]) || !isset($_GET["crid"]) || !isset($_GET["tid"])) {
    if (isset($_SESSION['previous_url'])) {
        header('location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        header("location:alloc.php?error=" . $error . "");
        exit();
    }
}

if (isset($_POST["search"])) {
    if (!empty($_POST['Semester'])) {
        $_SESSION["Semester"] = $_POST['Semester'];
    }
    if (!empty($_POST['institution_name'])) {
        $_SESSION["institution_name"] = $_POST['institution_name'];
    }
    if (!empty($_POST['account_type'])) {
        $_SESSION["account_type"] = $_POST['account_type'];
    }
    header("location:coursestudentallocation.php?type=" . $_GET["type"] . "&id=" . $_GET["id"] . "&crid=" . $_GET["crid"] . "&tid=" . $_GET["tid"] . "");
    exit();
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Course Student Allocation</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php
    include("./switcher.php")

    ?>
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php"); ?>
            </div>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <div class="sticky">
                <?php include("./partials/sidebar.php"); ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Registration Allocation
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">registration</li>
                            <li class="breadcrumb-item ">add</li>
                        </ol>
                    </div>

                </div>
                <form method="post">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <P><b> College Name</b> </p>
                            <select name="institution_name" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <option value="None">None</option>
                                <?php
                                $query = "SELECT * FROM `college`";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = ($_SESSION["institution_name"] == $row['name']) ? 'selected' : '';
                                    echo '<option value="' . $row['name'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <P><b> Semester</b> </p>
                            <select name="Semester" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <option value="Not Required">None</option>
                                <?php
                                $semesters = ["1stSem", "2ndSem", "3rdSem", "4thSem", "5thSem", "6thSem", "7thSem", "8thSem"];
                                foreach ($semesters as $semester) {
                                    $selected = ($_SESSION["Semester"] == $semester) ? 'selected' : '';
                                    echo '<option value="' . $semester . '" ' . $selected . '>' . $semester . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <P><b> Account Type</b> </p>
                            <select name="account_type" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <!-- <option value="None">None</option> -->
                                <?php
                                $accountTypes = ["college", "individual"];
                                foreach ($accountTypes as $type) {
                                    $selected = ($_SESSION["account_type"] == $type) ? 'selected' : '';
                                    echo '<option value="' . $type . '" ' . $selected . '>' . ucfirst($type) . ' type</option>';
                                }
                                ?>
                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px" name="search">Search</button>

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
                                                <th class="border-bottom-0">Course id</th>
                                                <th class="border-bottom-0">student name</th>
                                                <th class="border-bottom-0">College name</th>
                                                <th class="border-bottom-0">Course</th>
                                                <th class="border-bottom-0">full info.</th>
                                                <th class="border-bottom-0">allocate </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
                                            $id = (int) $id;
                                            $tid = filter_var($_GET["tid"], FILTER_SANITIZE_NUMBER_INT);
                                            $tid = (int) $tid;
                                            $crid = filter_var($_GET["crid"], FILTER_SANITIZE_NUMBER_INT);
                                            $crid = (int) $crid;
                                            $query_allocate = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `id` = '$id'");

                                            if ($query_allocate->num_rows > 0) {
                                                $i = 1;
                                                $row = mysqli_fetch_assoc($query_allocate);
                                                $query = "SELECT * FROM `student` WHERE 1=1";
                                                if (isset($_SESSION['Semester'])) {
                                                    $Semester = mysqli_real_escape_string($conn, $_SESSION["Semester"]);
                                                    $query .= " AND `semester` = '$Semester'";
                                                }
                                                if (isset($_SESSION['institution_name'])) {
                                                    $college_name = mysqli_real_escape_string($conn, $_SESSION["institution_name"]);
                                                    $query .= " AND `college_name` = '$college_name'";
                                                }
                                                if (isset($_SESSION['account_type'])) {
                                                    $account_type = mysqli_real_escape_string($conn, $_SESSION["account_type"]);
                                                    $query .= " AND `account_type` = '$account_type'";
                                                }

                                                $student_query = mysqli_query($conn, $query);
                                                while ($student = mysqli_fetch_assoc($student_query)) {
                                                    $std_all_query = mysqli_query($conn, "SELECT * FROM `student_allocate` WHERE `course_id` = '$crid' AND `allocate_id` = '$id' AND `student_id` = '{$student['id']}'");

                                                    // if (!empty($student['college_name']) && $student["college_name"] != "None") {
                                                    $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$crid'");
                                                    $course = mysqli_fetch_assoc($course_query);
                                                    echo '<tr>
                                                        <td>' . $i . '</td>
                                                        <td>CRID_' . $crid . '</td>
                                                        <td>' . $student["name"] . '</td>
                                                        <td>' . $student["college_name"] . '</td>
                                                        <td>' . $course["course_name"] . '</td>
                                                        <td><a href="./viewstudent.php?id=' . $student["id"] . '" class="btn btn-info">View</a>
                                                        </td>';
                                                    if (mysqli_num_rows($std_all_query) > 0) {
                                                        $fetch_std_all = mysqli_fetch_assoc($std_all_query);
                                                        echo '<td><a href="./delete.php?id=' . $fetch_std_all["id"] . '&type=student_unallocate" class="btn btn-danger">Unallocate</a></td></tr>';
                                                    } else {
                                                        echo '<td> <a href="./allocatestu.php?crid=' . $crid . '&allocateid=' . $id . '&stuid=' . $student["id"] . '" class="btn btn-success">Allocate</a></td>
                                                            </tr>';
                                                    }
                                                    $i++;
                                                    // }
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
        </div>

    </div>
    <?php include("./scripts.php"); ?>
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