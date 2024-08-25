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

function decryptPassword($encryptedPassword, $key)
{
    $data = base64_decode($encryptedPassword);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}


if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM `college` WHERE `created_by`='User'");
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>College Registrations</title>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">College
                            Registrations</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Credentials</a></li>
                            <li class="breadcrumb-item ">College</li>
                            <li class="breadcrumb-item ">Registrations</li>
                        </ol>
                    </div>

                </div>

                <br>
                <br>
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.No</th>
                                                <th class="border-bottom-0">Date of adding</th>
                                                <th class="border-bottom-0">College ID</th>
                                                <th class="border-bottom-0">College name</th>
                                                <th class="border-bottom-0">Phone No</th>
                                                <th class="border-bottom-0">Username</th>
                                                <th class="border-bottom-0">Password</th>
                                                <th class="border-bottom-0">Delete</th>
                                                <th class="border-bottom-0">update</th>



                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (mysqli_num_rows($query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i++; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['creation_date']; ?>
                                                        </td>
                                                        <td>
                                                            COLLID_<?php echo $row['id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['contact_number']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['username']; ?>
                                                        </td>
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


                                                        <td>
                                                            <a href="delete.php?id=<?php echo $row['id']; ?>&user=college" class="btn btn-danger">Delete</a>
                                                        </td>
                                                        <td>
                                                            <a href="collegeupdate.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Update</a>
                                                        </td>

                                                <?php }
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

</body>

</html>