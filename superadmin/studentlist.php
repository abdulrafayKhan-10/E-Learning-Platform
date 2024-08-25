<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

// Store the current URL in the session
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Access the secret key
$secretKey = $_ENV['SECRET_KEY'] ?: 'HE!!O123';

$key = $secretKey;

function decryptPassword($encryptedPassword, $key)
{
    $data = base64_decode($encryptedPassword);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

?>

<!DOCTYPE html>
<html lang="en">


<head>

    <title>Student List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>

    <style>
    .pointer {
        cursor: pointer;
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
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Student List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">Student</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
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
                                <option value="1stSem">1st Sem</option>
                                <option value="2ndSem">2nd Sem</option>
                                <option value="3rdSem">3rd Sem</option>
                                <option value="4thSem">4th Sem</option>
                                <option value="5thSem">5nd Sem</option>
                                <option value="6thSem">6nd Sem</option>
                                <option value="7thSem">7nd Sem</option>
                                <option value="8thSem">8nd Sem</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <P><b> Account Type</b> </p>
                            <select name="account_type" class="form-control form-select"
                                data-bs-placeholder="Select Filter">
                                <option value="" selected="selected">All</option>
                                <option value="None">None</option>

                                <option value="college">College type</option>
                                <option value="individual">Individual type</option>
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
                                                <th class="border-bottom-0">Date Of Adding</th>
                                                <th class="border-bottom-0">ID No</th>
                                                <th class="border-bottom-0">Created By</th>
                                                <th class="border-bottom-0">Student name</th>
                                                <th class="border-bottom-0">Password</th>

                                                <th class="border-bottom-0">College</th>
                                                <th class="border-bottom-0">stream</th>
                                                <th class="border-bottom-0">District</th>

                                                <th class="border-bottom-0">Delete</th>
                                                <th class="border-bottom-0">Edit</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM `student` WHERE 1=1";
                                            if (!empty($_POST['Semester'])) {
                                                $Semester = mysqli_real_escape_string($conn, $_POST['Semester']);
                                                $query .= " AND `semester` = '$Semester'";
                                            }
                                            if (!empty($_POST['institution_name'])) {
                                                $college_name = mysqli_real_escape_string($conn, $_POST['institution_name']);
                                                $query .= " AND `college_name` = '$college_name'";
                                            }
                                            if (!empty($_POST['account_type'])) {
                                                $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
                                                $query .= " AND `account_type` = '$account_type'";
                                            }

                                            $result = mysqli_query($conn, $query);
                                            if (mysqli_num_rows($result) > 0) { ?>
                                            <tr>
                                                <?php
                                                    $i = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td>" . $row['creation_date'] . "</td>";
                                                        echo "<td>STID_" . $row['id'] . "</td>";
                                                        echo "<td>" . $row['created_by'] . "</td>";
                                                        echo "<td>" . $row['name'] . "</td>";
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

                                                        echo "<td>" . $row['college_name'] . "</td>";
                                                        echo "<td>" . $row['branch'] . "</td>";
                                                        echo "<td>" . $row['district'] . "</td>";
                                                        echo "<td><a class='btn btn-danger' href='./delete.php?id=" . $row['id'] . "&user=student'>Delete</a></td>";
                                                        echo "<td><a href='student_edit.php?id=" . $row['id'] . "' class='btn btn-info'>Update</a></td>";
                                                        echo "</tr>";
                                                        $i++;
                                                    }
                                                    ?>

                                            </tr>

                                            <?php } ?>
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
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    if (session_unset()) {
        $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    }

    ?>

</body>


</html>