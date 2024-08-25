<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (isset($_POST["submit"])) {
    $email = $_COOKIE['trainer_email'];

    $new_password = $_POST['new_pass'];
    $match_password = $_POST['match_pass'];

    if ($new_password === $match_password) {
        $hash_pass = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = mysqli_prepare($conn, "UPDATE `trainer` SET `password` = ? WHERE `email` = '$email'");
        $update_query->bind_param("s", $hash_pass);
        if ($update_query->execute()) {
            unset($_COOKIE['trainer_password']);
            setcookie("trainer_password", $hash_pass, time() + (86400 * 30), "/");
            $_SESSION["success"] = "Password changed successfully";
            header('location: changepassword.php');
        }
    }
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php") ?>

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
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Change Password</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Change Password</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Password</li>
                            <li class="breadcrumb-item active" aria-current="page">Change</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->

                <!-- row -->
                <form method="post">
                    <?php if (isset($_SESSION["success"])) { ?>
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION["success"]; ?>
                            </div>
                        </div>
                    <?php session_destroy();
                    } ?>
                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row row-xs formgroup-wrapper">


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Current Password</label>
                                                <input type="password" class="form-control" oninput="checkPassword()" id="current_password" placeholder="Enter Current Password">
                                                <p class="text-danger" id="current_password_msg">Incorrect Password</p>
                                            </div>
                                            <?php
                                            $username = $_COOKIE["trainer_username"];
                                            $query = mysqli_query($conn, "SELECT `password` FROM `trainer` WHERE `username`='$username'");
                                            $current_password_hash = mysqli_fetch_assoc($query)["password"];
                                            ?>
                                            <script>
                                                let check = false;

                                                function debounce(func, wait, immediate) {
                                                    let timeout;
                                                    return function() {
                                                        const context = this,
                                                            args = arguments;
                                                        const later = function() {
                                                            timeout = null;
                                                            if (!immediate) func.apply(context, args);
                                                        };
                                                        const callNow = immediate && !timeout;
                                                        clearTimeout(timeout);
                                                        timeout = setTimeout(later, wait);
                                                        if (callNow) func.apply(context, args);
                                                    };
                                                }

                                                const debouncedCheckPassword = debounce(checkPassword,
                                                    500); // Adjust the delay as needed

                                                function checkPassword() {
                                                    const inputPassword = document.getElementById('current_password').value;
                                                    const passwordMsg = document.getElementById('current_password_msg');

                                                    // Make an AJAX request to a PHP script for password verification
                                                    fetch('verify_password.php', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/x-www-form-urlencoded',
                                                            },
                                                            body: 'current_password=' + encodeURIComponent(
                                                                inputPassword),
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.verify_pass) {
                                                                check = true;
                                                                passwordMsg.textContent = 'Password Matched';
                                                                passwordMsg.classList.remove('text-danger');
                                                                passwordMsg.classList.add('text-success');
                                                            } else {
                                                                check = false;
                                                                passwordMsg.textContent = 'Incorrect Password';
                                                                passwordMsg.classList.remove('text-success');
                                                                passwordMsg.classList.add('text-danger');
                                                            }

                                                            if (check === true) {
                                                                document.querySelector('#new_pass').removeAttribute(
                                                                    'disabled');
                                                                document.querySelector('#match_pass').removeAttribute(
                                                                    'disabled');
                                                                document.querySelector('#submit').removeAttribute(
                                                                    'disabled');
                                                            } else {
                                                                document.querySelector('#new_pass').setAttribute(
                                                                    'disabled', true);
                                                                document.querySelector('#match_pass').setAttribute(
                                                                    'disabled', true);
                                                                document.querySelector('#submit').setAttribute(
                                                                    'disabled', true);
                                                            }
                                                        })
                                                        .catch(error => console.error('Error:', error));
                                                }
                                            </script>


                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">New Password</label>
                                                <input type="text" name="new_pass" class="form-control" id="new_pass" placeholder="Enter New Passowrd" disabled>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Re-Enter New Password</label>
                                                <input type="text" class="form-control" name="match_pass" id="match_pass" placeholder="Re-Enter New Password" disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-info mt-3 mb-0" style="text-align:right" name="submit" id="submit" disabled>Change
                                        Password</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
            <!-- Container closed -->
        </div>


    </div>
    <!-- End Page -->


    <?php include("./script.php"); ?>

</body>

</html>