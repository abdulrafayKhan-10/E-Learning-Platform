<?php
session_start();

include("../db_connection/connection.php");

if (isset($_POST["submit"])) {
    $course_one = $_POST["course_one"];
    $course_two = $_POST["course_two"];
    $course_three = $_POST["course_three"];

    $query = mysqli_prepare($conn, "INSERT INTO `latest_course`(`course_one`, `course_two`, `course_three`) VALUES (?,?,?)");
    mysqli_stmt_bind_param($query, "sss", $course_one, $course_two, $course_three);
    if (mysqli_stmt_execute($query)) {
        header("location: latest_course.php");
    } else {
        echo mysqli_error($conn);
    }
}

$select_query = mysqli_query($conn, "SELECT * FROM `course`");

$check_latest_course = mysqli_query($conn, "SELECT * FROM `latest_course`");

$fetch_id = mysqli_fetch_assoc($check_latest_course)['id'];

if (isset($_POST["update"])) {
    $course_one = $_POST["course_one"];
    $course_two = $_POST["course_two"];
    $course_three = $_POST["course_three"];

    $query = mysqli_prepare($conn, "UPDATE `latest_course` SET `course_one`=?,`course_two`=?,`course_three`=? WHERE `id`='$fetch_id'");
    mysqli_stmt_bind_param($query, "sss", $course_one, $course_two, $course_three);
    if (mysqli_stmt_execute($query)) {
        header("location: latest_course.php");
    } else {
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display 3 Courses</title>
    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php"); ?>

    <div class="page">

        <div class="main-header side-header sticky nav nav-item">

            <?php include('./partials/navbar.php'); ?>

        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        <div class="sticky">
            <?php include('./partials/sidebar.php') ?>
        </div>
        <!-- main-sidebar -->


        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Add Top 3 Latest
                            Course</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Course</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Display Course</li>
                            <li class="breadcrumb-item active" aria-current="page">Add</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->



                <form method="POST">
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Course One</label>
                                                <select name="course_one" class="form-control form-select select2"
                                                    data-bs-placeholder="Course One"
                                                    <?php if ($_SESSION["latest_course_exist"]) {
                                                                                                                                                        echo "disabled";
                                                                                                                                                    } ?>>
                                                    <?php
                                                    if (mysqli_num_rows($select_query) > 0) {
                                                        while ($row = mysqli_fetch_assoc($select_query)) { ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo "Course Name: " . $row['course_name'] . " | Stream Name: " . $row["stream_name"]; ?>
                                                    </option>

                                                    <?php }
                                                        mysqli_data_seek($select_query, 0);
                                                    } else {
                                                        echo "<option value=''>No Course Available</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Course Two</label>
                                                <select name="course_two" class="form-control form-select select2"
                                                    data-bs-placeholder="Course Two"
                                                    <?php if ($_SESSION["latest_course_exist"]) {
                                                                                                                                                        echo "disabled";
                                                                                                                                                    } ?>
                                                    <?php
                                                                                                                                                            if (mysqli_num_rows($select_query) > 0) {
                                                                                                                                                                while ($row = mysqli_fetch_assoc($select_query)) { ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                    <?php echo "Course Name: " . $row['course_name'] . " | Stream Name: " . $row["stream_name"]; ?>
                                                    </option>

                                                    <?php }
                                                                                                                                                                mysqli_data_seek($select_query, 0);
                                                                                                                                                            } else {
                                                                                                                                                                echo "<option value=''>No Course Available</option>";
                                                                                                                                                            }
                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Course Three</label>
                                                <select name="course_three" class="form-control form-select select2"
                                                    data-bs-placeholder="Course Three"
                                                    <?php if ($_SESSION["latest_course_exist"]) {
                                                                                                                                                            echo "disabled";
                                                                                                                                                        } ?>>
                                                    <?php
                                                    if (mysqli_num_rows($select_query) > 0) {
                                                        while ($row = mysqli_fetch_assoc($select_query)) { ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo "Course Name: " . $row['course_name'] . " | Stream Name: " . $row["stream_name"]; ?>
                                                    </option>

                                                    <?php }
                                                    } else {
                                                        echo "<option value=''>No Course Available</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>







                                    </div>

                                    <?php if (isset($check_latest_course)) {
                                        echo "<button type='submit' name='update' class='btn btn-info mt-3 mb-0'
                                        style='text-align:right'>Update
                                        Course</button>";
                                    } else { ?>

                                    <button type="submit" value="submit" name="submit" class="btn btn-info mt-3 mb-0"
                                        style="text-align:right">Add
                                        Course</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <!-- Container closed -->
        </div>


    </div>

    <?php include("./scripts.php"); ?>

</body>

</html>