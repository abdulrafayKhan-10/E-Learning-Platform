<?php
session_start();

include('../db_connection/connection.php');

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Access the secret key
$secretKey = $_ENV['SECRET_KEY'] ?: 'HE!!O123';

$key = $secretKey;

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

function decryptPassword($encryptedPassword, $key)
{
    $data = base64_decode($encryptedPassword);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>College List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

    <style>
    .pointer {
        cursor: pointer !important;
    }
    </style>

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
                                                <th class="border-bottom-0">Date of adding</th>
                                                <th class="border-bottom-0">College ID</th>
                                                <th class="border-bottom-0">College Name</th>
                                                <th class="border-bottom-0">Password</th>
                                                <th class="border-bottom-0">Representative Name</th>
                                                <th class="border-bottom-0">District</th>
                                                <th class="border-bottom-0">Affliate Univerity Board</th>
                                                <th class="border-bottom-0">College Streams</th>
                                                <th class="border-bottom-0">Address</th>
                                                <th class="border-bottom-0">Website</th>

                                                <th class="border-bottom-0">Edit</th>
                                                <th class="border-bottom-0">Delete</th>



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
                                                    echo "<td>" . $row["creation_date"] . "</td>";
                                                    echo "<td>COL_" . $row["id"] . "</td>";
                                                    echo "<td>" . $row["name"] . "</td>";
                                                    $decryptedPassword = decryptPassword($row["hashed_password"], $key);
                                                    echo "<td class='pointer'>
            <i class='bi bi-eye show-password' id='show-password-" . $row["id"] . "' data-id='show_password_" . $row["id"] . "' title='Show Password'></i>
            <span class='password' id='password_" . $row["id"] . "' style='display:none;'>" . $decryptedPassword . "</span>
            <i class='bi bi-eye-slash hide-password' id='hide-password-" . $row["id"] . "' data-id='hide_password_" . $row["id"] . "' style='display:none;' title='Hide Password'></i>
        </td>";

                                                    echo '
            <script>
                document.querySelector("#show-password-' . $row["id"] . '").addEventListener("click", function() {
                    document.querySelector("#password_' . $row["id"] . '").style.display = "block";
                    document.querySelector("#show-password-' . $row["id"] . '").style.display = "none";
                    document.querySelector("#hide-password-' . $row["id"] . '").style.display = "inline-block";
                });

                document.querySelector("#hide-password-' . $row["id"] . '").addEventListener("click", function() {
                    document.querySelector("#password_' . $row["id"] . '").style.display = "none";
                    document.querySelector("#show-password-' . $row["id"] . '").style.display = "inline-block";
                    document.querySelector("#hide-password-' . $row["id"] . '").style.display = "none";
                });
            </script>
        ';
                                                    echo "<td>" . $row["representative_name"] . "</td>";
                                                    echo "<td>" . $row["district"] . "</td>";
                                                    echo "<td>" . $row["affiliated_university"] . "</td>";
                                                    echo "<td>" . $row["college_streams"] . "</td>";
                                                    echo "<td>" . $row["address"] . "</td>";
                                                    echo "<td><a class='text-primary' href='https://" . $row["website"] . "'>" . $row["website"] . "</a></td>";
                                                    echo "<td><a class='btn btn-warning' href='college_edit.php?id=" . $row["id"] . "'>Edit</a></a></td>";
                                                    echo "<td><a class='btn btn-danger' href='delete.php?id=" . $row["id"] . "&user=college'>Delete</a></a></td>";
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