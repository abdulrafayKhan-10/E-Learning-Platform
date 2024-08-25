<?php
session_start();

include('../db_connection/connection.php');

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>College Details</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">College List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">College</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-4">
                            <P><b> Affliated University</b> </p>
                            <select name="affiliated_university" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    None
                                </option>
                                <?php
                                $query = "SELECT `affiliated_university` FROM `college`";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row["affiliated_university"] != $_SESSION["affiliated_university"] && !empty($row["affiliated_university"])) {
                                            $_SESSION["affiliated_university"] = $row["affiliated_university"];
                                            echo "<option value='" . $row["affiliated_university"] . "'>" . $row["affiliated_university"] . "</option>";
                                        }
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <P><b>District</b> </p>
                            <select name="district" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected>
                                    None
                                </option>
                                <?php
                                $query = "SELECT `district` FROM `college`";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row["district"] != $_SESSION["district"] && !empty($row["district"])) {
                                            $_SESSION["district"] = $row["district"];
                                            echo "<option value='" . $row["district"] . "'>" . $row["district"] . "</option>";
                                        }
                                    }
                                }
                                ?>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Search</button>
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
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Pin Code</th>
                                                <th class="border-bottom-0">Representative Contact No.</th>
                                                <th class="border-bottom-0">Representative Email</th>
                                                <th class="border-bottom-0">College Code</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM `college` WHERE 1=1";

                                            if (!empty($_POST['affiliated_university'])) {
                                                $affiliated_university = mysqli_real_escape_string($conn, $_POST['affiliated_university']);
                                                $query .= " AND `affiliated_university` = '$affiliated_university'";
                                            }

                                            if (!empty($_POST['district'])) {
                                                $district = mysqli_real_escape_string($conn, $_POST['district']);
                                                $query .= " AND `district` = '$district'";
                                            }
                                            $result = mysqli_query($conn, $query);
                                            if (mysqli_num_rows($result) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $i . "</td>";
                                                    echo "<td>" . $row["name"] . "</td>";

                                                    echo "<td>" . $row["pin_code"] . "</td>";

                                                    echo "<td>" . $row["representative_contact_number"] . "</td>";
                                                    echo "<td>" . $row["representative_email"] . "</td>";
                                                    echo "<td>" . $row["college_code"] . "</td>";

                                                    echo "</tr>";
                                                    $i++;
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
    <!-- Container closed -->



    <?php include("./scripts.php"); ?>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    }
    if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    ?>
</body>

</html>