<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("location:./manageplacementsregistrations.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Select Student For Placement</title>
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

        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Placement Allocation
                        </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Allocate</a></li>
                            <li class="breadcrumb-item ">Registered</li>
                            <li class="breadcrumb-item ">Students</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-4">
                            <p><b> College Name</b> </p>

                            <select name="college" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <!-- <option selected="selected">All</option> -->
                                <?php
                                $query = mysqli_query($conn, "SELECT DISTINCT `college_name` FROM `student`");
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo '<option value="' . $row["college_name"] . '">' . $row["college_name"] . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Filter</button>

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
                                                <th class="border-bottom-0">Student Id</th>
                                                <th class="border-bottom-0">Student Name</th>

                                                <th class="border-bottom-0">College Name</th>
                                                <th class="border-bottom-0">Branch</th>
                                                <th class="border-bottom-0">Full Info</th>
                                                <th class="border-bottom-0">Allocate </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
                                            $id = (int) $id;

                                            $query = "SELECT * FROM `placement_applicants` WHERE `job_id`='$id'";
                                            $placement_reg_query = mysqli_query($conn, $query);

                                            if ($placement_reg_query) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($placement_reg_query)) {
                                                    $stu_query = "SELECT * FROM `student` WHERE `id`='{$row['student_id']}'";
                                                    if (isset($_POST["college"]) && !empty($_POST["college"])) {
                                                        $college = $_POST["college"];
                                                        $stu_query .= " AND `college_name`='$college'";
                                                    }
                                                    $student_query = mysqli_query($conn, $stu_query);

                                                    if ($student_query) {
                                                        while ($student = mysqli_fetch_assoc($student_query)) {
                                                            $check_placement_registration_query = mysqli_query($conn, "SELECT * FROM `student_selected_for_placement` WHERE `student_id`='{$student["id"]}' AND `placement_id`='$id'");

                                                            $fetch_check = mysqli_fetch_assoc($check_placement_registration_query);

                                                            if (!$fetch_check) {
                                                                // Your existing code to display the student information and allocate button
                                                                echo "<tr>";
                                                                echo "<td>" . $i++ . "</td>";
                                                                echo "<td>STID_" . $student['id'] . "</td>";
                                                                echo "<td>" . $student["name"] . "</td>";
                                                                echo "<td>" . $student["college_name"] . "</td>";
                                                                echo "<td>" . $student["branch"] . "</td>";
                                                                echo "<td><a href='./viewstudent.php?id=" . $student["id"] . "' class='btn btn-info'>View</a></td>";
                                                                echo "<td><a href='allocstudent.php?id=" . $student['id'] . "&placement_id=" . $id . "' class='btn btn-success'>Allocate</a></td>";
                                                                echo "</tr>";
                                                            }
                                                        }
                                                    } else {
                                                        // Handle query execution error for student query
                                                        echo "Error executing student query: " . mysqli_error($conn);
                                                    }
                                                }
                                            } else {
                                                // Handle query execution error for placement registration query
                                                echo "Error executing placement registration query: " . mysqli_error($conn);
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