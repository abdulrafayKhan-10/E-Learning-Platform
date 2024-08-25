<?php
include("./db_connection/connection.php");


if (isset($_POST['sign_in'])) {

    $username = mysqli_real_escape_string($conn, $_POST['college_username']);
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT * FROM `college` WHERE `username` = '$username'");

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $pass = $row['password'];
        if (password_verify($password, $pass)) {
            setcookie("college_username", $username, time() + (86400 * 30), "/");
            setcookie("college_password", $row['password'], time() + (86400 * 30), "/");
            setcookie("college_email", $row['email'], time() + (86400 * 30), "/");
            header("location: ./College/dashboard.php");
            exit();
        }
    }
}

if (isset($_COOKIE['college_username']) && isset($_COOKIE['college_password'])) {
    header("Location: ./College/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>College Log-In</title>
    <?php
    include("links.php");
    ?>
</head>

<body>
    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>

    <?php
    if (isset($_SESSION['message_failed']) && $_SESSION['message_failed'] == true) {
        echo "<script>toastr.error('" . $_SESSION["err_msg"] . "')</script>";
        session_destroy();
    }

    ?>

    <div class="main">

        <!--login section start-->
        <section class="section section-lg section-header position-relative min-vh-100 flex-column d-flex justify-content-center">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7 col-lg-6">
                        <div class="hero-content-left text-dark">
                            <h1 class="display-2">Welcome<br> College!</h1>
                            <p class="lead">
                                Expereince your dashboard at more ease and security
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5">
                        <div class="card login-signup-card shadow-lg mb-0">
                            <div class="card-body px-md-5 py-5">
                                <div class="mb-5">
                                    <h3>Login</h3>
                                    <p class="text-muted">Sign in to your account to continue.</p>
                                </div>

                                <!--login form-->
                                <form class="login-signup-form" action="" method="POST">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Username</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>

                                            <input type="text" class="form-control" name="college_username" placeholder="Enter your username" required value="">
                                            <span class="error"></span><br>
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label class="font-weight-bold">Password</label>
                                            </div>
                                            <!--<div class="col-auto">
                                                <a href="password-reset.html" class="form-text small text-muted">
                                                    Forgot password?
                                                </a>
                                            </div> -->
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <div class="input-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                            <span class="error"></span><br>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <button class="btn btn-block btn-secondary mt-4 mb-3" type="submit" name="sign_in">Sign
                                        in</button>
                                    <span class="error"></span>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--login section end-->


    </div>
</body>

</html>