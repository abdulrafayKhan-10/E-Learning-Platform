<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

$query_t = "SELECT * FROM `trainer` WHERE 1=1";

if (isset($_POST["trainer_name"]) && !empty($_POST["trainer_name"])) {
    $trainer_name = $_POST["trainer_name"];
    $query_t .= " AND `username` = '$trainer_name'";
}
$select_query = mysqli_query($conn, $query_t);


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

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <title>Trainers List</title>

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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Trainer list </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">Trainer</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Trainer name</label> </b>
                            <select name="trainer_name" class="form-control form-select" data-bs-placeholder="Select Filter">
                                <option value="">ALL</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM `trainer`");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $row['username'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        &nbsp &nbsp <button type="submit" class="btn btn-primary" name="search" style="height:40px;width:100px;margin-top:35px" value="search">Search</button>
                    </div>
                </form>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Username</th>
                                                <th class="border-bottom-0">Email</th>
                                                <th class="border-bottom-0">Trainer ID</th>
                                                <th class="border-bottom-0">Trainer Name</th>
                                                <th class="border-bottom-0">Password</th>

                                                <th class="border-bottom-0">Qualification</th>
                                                <th class="border-bottom-0">Experience</th>

                                                <th class="border-bottom-0">User status</th>
                                                <th class="border-bottom-0">Delete</th>
                                                <th class="border-bottom-0">Edit</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($select_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($select_query)) {
                                            ?>

                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td>ID_<?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <?php

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

                                                        ?>
                                                        <td><?php echo $row['qualification'] ?? null; ?></td>
                                                        <td><?php echo $row['experience'] ?? null; ?></td>
                                                        <td style=color:#4aa02c> <b> Active <b></td>
                                                        <td><a href="delete.php?id=<?php echo $row['id']; ?>&user=trainer" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</a>
                                                        </td>
                                                        <td><a href="edit_trainer.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a></td>
                                                    </tr>

                                                <?php
                                                }
                                            } else { ?>
                                            <?php echo "No data found";
                                            } ?>

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