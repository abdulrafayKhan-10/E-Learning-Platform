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
    <title>Course List</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Course List</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Courses</a></li>
                            <li class="breadcrumb-item ">Create</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">

                        <div class="form-group col-md-4">
                            <P><b>Course Category</b> </p>
                            <select name="category" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query_cat = "SELECT DISTINCT `course_category_name` FROM `course`";
                                $result_cat = mysqli_query($conn, $query_cat);
                                if (mysqli_num_rows($result_cat) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_cat)) {


                                        echo "<option value='" . $row["course_category_name"] . "'>" . $row["course_category_name"] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <P><b>Course Price</b> </p>
                            <select name="price" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query_p = "SELECT DISTINCT `final_cost` FROM `course`";
                                $result = mysqli_query($conn, $query_p);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {


                                        echo "<option value='" . $row["final_cost"] . "'>" . $row["final_cost"] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <P><b>Course Duration</b> </p>
                            <select name="duration" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    All
                                </option>
                                <?php
                                $query_d = "SELECT DISTINCT `duration_days` FROM `course`";
                                $result_d = mysqli_query($conn, $query_d);
                                if (mysqli_num_rows($result_d) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_d)) {


                                        echo "<option value='" . $row["duration_days"] . "'>" . $row["duration_days"] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                </form>
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
                                                <th class="border-bottom-0">date of adding</th>
                                                <th class="border-bottom-0">Course ID</th>
                                                <th class="border-bottom-0">Course name</th>
                                                <th class="border-bottom-0">Category</th>
                                                <th class="border-bottom-0">Price</th>
                                                <th class="border-bottom-0">Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $course_query = "SELECT * FROM `course` WHERE 1=1";

                                            if (isset($_POST['category']) && !empty($_POST['category'])) {
                                                $category = $_POST['category'];
                                                $course_query .= " AND `course_category_name` = '$category'";
                                            }

                                            if (isset($_POST['price']) && !empty($_POST['price'])) {
                                                $price = $_POST['price'];
                                                $course_query .= " AND `final_cost` = '$price'";
                                            }

                                            if (isset($_POST['duration']) && !empty($_POST['duration'])) {
                                                $duration = $_POST['duration'];
                                                $course_query .= " AND `duration_days` = '$duration'";
                                            }

                                            $course_query_run = mysqli_query($conn, $course_query);
                                            if (mysqli_num_rows($course_query_run) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($course_query_run)) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row['creation_date'] . "</td>";
                                                    echo "<td>CRID_" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['course_name'] . "</td>";
                                                    echo "<td>" . $row['course_category_name'] . "</td>";
                                                    echo "<td>" . $row['final_cost'] . "</td>";
                                                    echo "<td>" . $row['duration_days'] . " days</td>";
                                                    echo "</tr>";
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
    <?php include("./scripts.php"); ?>

</body>

</html>