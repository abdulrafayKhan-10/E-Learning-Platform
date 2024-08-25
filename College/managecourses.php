<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>My Students</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php") ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include("./partials/navbar.php") ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Manage Course</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Manage</li>

                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Name Of The Course</label> </b>
                            <select name="name_of_the_course" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $sql = "SELECT * FROM course";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['course_name'] . '</option>';
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
                                                <th class="border-bottom-0">Date of Adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">College name</th>
                                                <th class="border-bottom-0">Course</th>
                                                <th class="border-bottom-0">Acc type</th>

                                                <th class="border-bottom-0">Trainer Allocation</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $college_name = $_COOKIE['college_username'];
                                            $college_query = mysqli_query($conn, "SELECT * FROM `college` WHERE `username` = '$college_name'");
                                            $college_data = mysqli_fetch_assoc($college_query);
                                            $college_id = $college_data['id'];

                                            $course_reg_query = "SELECT * FROM `course_registration` WHERE 1=1";

                                            if (isset($_POST["name_of_the_course"]) && !empty($_POST["name_of_the_course"])) {
                                                $name_of_the_course = $_POST["name_of_the_course"];
                                                $course_reg_query .= " AND `course_id` = $name_of_the_course";
                                            }

                                            $query = mysqli_query($conn, $course_reg_query);

                                            $i = 1;

                                            if (mysqli_num_rows($query) > 0) {
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '{$row['student_id']}'");
                                                    if (mysqli_num_rows($student_query) > 0) {
                                                        $student_data = mysqli_fetch_assoc($student_query);
                                                        if ($student_data["college_id"] == $college_id) {
                                                            $course_query = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '{$row['course_id']}'");
                                                            $course_data = mysqli_fetch_assoc($course_query);
                                                            echo "<tr>";
                                                            echo "<td>" . $i . "</td>";
                                                            echo "<td>" . $row['added_date'] . "</td>";
                                                            echo "<td>STID_" . $student_data['id'] . "</td>";
                                                            echo "<td>" . $student_data['name'] . "</td>";
                                                            echo "<td>" . $student_data['college_name'] . "</td>";
                                                            echo "<td>" . $course_data['course_name'] . "</td>";
                                                            echo "<td>" . $student_data['account_type'] . "</td>";
                                                            $trainer_alloc_course = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `course_id` = '{$row['course_id']}'");
                                                            if (mysqli_num_rows($trainer_alloc_course) > 0) {
                                                                echo "<td class='text-success fw-bold'>Allocated</td>";
                                                            } else {
                                                                echo "<td class='text-danger fw-bold'>Not Allocated</td>";
                                                            }
                                                            echo "</tr>";
                                                            $i++;
                                                        }
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

            </div>
        </div>

    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./script.php"); ?>
</body>

</html>