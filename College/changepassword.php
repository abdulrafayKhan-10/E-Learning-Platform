<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

if (isset($_POST["change_pwd"])) {
    $college_id = $_COOKIE["college_username"];
    $old_password = $_POST["oldpassword"];
    $new_password = $_POST["newpassword"];
    $confirm_password = $_POST["confirmpassword"];

    $query = "SELECT `password` FROM `college` WHERE `username` = '$college_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $current_password_hash = $row["password"];

        if (password_verify($old_password, $current_password_hash)) {
            if ($new_password === $confirm_password) {
                $new_password_hash = password_hash(
                    $new_password,
                    PASSWORD_DEFAULT
                );

                $update_query = "UPDATE `college` SET `password` = '$new_password_hash' WHERE `username` = '$college_id'";
                if (mysqli_query($conn, $update_query)) {
                    unset($_COOKIE["college_password"]);
                    setcookie(
                        "college_password",
                        $new_password_hash,
                        time() + 86400 * 30,
                        "/"
                    );
                    $_SESSION["success"] = "Password changed successfully";
                    header("location: changepassword.php");
                    exit();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Change Password</title>
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
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="show_error" style="display:none;">
                            <div class="alert alert-danger">
                                <p></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form method="post">

                                    <div class="">
                                        <div class="row row-xs formgroup-wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Current Password</label>
                                                    <input type="password" data-pristine-equals="#pwd"
                                                        data-pristine-equals-message="Passwords don't match"
                                                        class="form-control" name="oldpassword" id="oldpassword"
                                                        required />
                                                    <p class="text-danger" id="current_password_msg">Incorrect Password
                                                </div>
                                                </p>
                                                <?php
                                                $username =
                                                    $_COOKIE["college_username"];
                                                $query = mysqli_query(
                                                    $conn,
                                                    "SELECT `password` FROM `college` WHERE `username`='$username'"
                                                );
                                                $current_password_hash = mysqli_fetch_assoc($query)["password"];
                                                ?>
                                                <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const oldPasswordInput = document.getElementById(
                                                        'oldpassword');

                                                    oldPasswordInput.addEventListener('input', debounce(
                                                        checkPassword, 500));

                                                    function checkPassword() {
                                                        const inputPassword = oldPasswordInput.value;
                                                        const passwordMsg = document.getElementById(
                                                            'current_password_msg');

                                                        // Make an AJAX request to a PHP script for password verification
                                                        fetch('verify_password.php', {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/x-www-form-urlencoded',
                                                                },
                                                                body: 'current_password=' +
                                                                    encodeURIComponent(inputPassword),
                                                            })
                                                            .then(response => response.json())
                                                            .then(data => {
                                                                if (data.verify_pass) {
                                                                    passwordMsg.textContent =
                                                                        'Password Matched';
                                                                    passwordMsg.classList.remove(
                                                                        'text-danger');
                                                                    passwordMsg.classList.add(
                                                                        'text-success');
                                                                    // Enable other input fields here
                                                                    document.getElementById('newpassword')
                                                                        .removeAttribute('disabled');
                                                                    document.getElementById(
                                                                            'confirmpassword')
                                                                        .removeAttribute('disabled');
                                                                } else {
                                                                    passwordMsg.textContent =
                                                                        'Incorrect Password';
                                                                    passwordMsg.classList.remove(
                                                                        'text-success');
                                                                    passwordMsg.classList.add(
                                                                        'text-danger');
                                                                    // Disable other input fields here
                                                                    document.getElementById('newpassword')
                                                                        .setAttribute('disabled', true);
                                                                    document.getElementById(
                                                                            'confirmpassword')
                                                                        .setAttribute('disabled', true);
                                                                }
                                                            })
                                                            .catch(error => console.error('Error:', error));
                                                    }

                                                    function debounce(func, wait, immediate) {
                                                        let timeout;
                                                        return function() {
                                                            const context = this,
                                                                args = arguments;
                                                            const later = function() {
                                                                timeout = null;
                                                                if (!immediate) func.apply(context,
                                                                    args);
                                                            };
                                                            const callNow = immediate && !timeout;
                                                            clearTimeout(timeout);
                                                            timeout = setTimeout(later, wait);
                                                            if (callNow) func.apply(context, args);
                                                        };
                                                    }
                                                });
                                                </script>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">New Password</label>
                                                    <input type="password" required class="form-control"
                                                        name="newpassword" id="newpassword" value="" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Re-Enter New Password</label>
                                                    <input type="password" data-pristine-equals="#pwd"
                                                        data-pristine-equals-message="Passwords don't match"
                                                        class="form-control" disabled name="confirmpassword"
                                                        id="confirmpassword" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info mt-3 mb-0" name="change_pwd">Change
                                            Password</button>

                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
            <!-- Container closed -->
        </div>

    </div>
    <!-- End Page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./script.php"); ?>
</body>

</html>