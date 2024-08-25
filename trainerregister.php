<?php
session_start();
include('./db_connection/connection.php');

require __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access the secret key
$secretKey = $_ENV['SECRET_KEY'] ?: 'HE!!O123';

$key = $secretKey;

function encrypt_Password($password, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    return base64_encode($iv . openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv));
}


if (isset($_POST['RegisterBtn'])) {
    $regex_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $trainer_name = $_POST['Trainer_Name'];
    $trainer_phoneno = $_POST['Personal_Phone_Number'];
    $trainer_email = $_POST['Personal_Mail_id'];
    $trainer_username = $_POST['Trainer_Username'];
    $password = $_POST['Password'];
    $select_query = "SELECT * FROM `trainer` WHERE email = '$trainer_email'";
    $select_query_run = mysqli_query($conn, $select_query);
    $fetch_query = mysqli_fetch_array($select_query_run);
    $fetched_email = isset($fetch_query['email']);
    $ip = $_COOKIE['trainer_ip'];
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $created_by = "user";


    $encryptedPassword = encrypt_Password($_POST['Password'], $key);


    if (preg_match($regex_email, $trainer_email) == 1) {
        if ($fetched_email == null) {
            $insert_query = mysqli_prepare($conn, "INSERT INTO `trainer`(`name`, `contact_number`, `email`, `password`, `username`, `ip`, `created_by`, `hashed_password`) VALUES (?,?,?,?,?,?,?,?)");
            $insert_query->bind_param("ssssssss", $trainer_name, $trainer_phoneno, $trainer_email, $hash_pass, $trainer_username, $ip, $created_by, $encryptedPassword);
            if ($insert_query->execute()) {

                $_SESSION['message_success'] = "Registered Successfully";
                header("location: trainerregister.php");
                exit();
            } else {
                $_SESSION['message_failed'] = true;
                $_SESSION["err_msg"] = "Database Error, Unable to register.";
                header("location: trainerregister.php");
                exit();
            }
        } else {
            $_SESSION['message_failed'] = true;
            $_SESSION["err_msg"] = "Email is Already Registered.";
            header("location: trainerregister.php");
            exit();
        }
    } else {

        $_SESSION['message_failed'] = true;
        $_SESSION["err_msg"] = "Invalid Email Format";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trainer Registration</title>
    <?php
    include("links.php")
    ?>
</head>

<body>

    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>
    <div class="main">

        <!--sign up section start-->

        <section
            class="section section-lg section-header position-relative min-vh-100 flex-column d-flex justify-content-center">
            <div class="container">

                <?php
                if (isset($_SESSION['message_success']) && !empty($_SESSION['message_success'])) {
                ?>
                <div class="alert alert-success">
                    Registration Successful
                </div>
                <?php
                    // session_destroy();
                } else if (isset($_SESSION['message_failed']) && !empty($_SESSION['message_failed'])) {
                ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION["err_msg"]; ?>
                </div>
                <?php
                }
                session_destroy();
                ?>
                <div class="row align-items-center justify-content-between">

                    <div class="col-md-5 col-lg-15">
                        <div class="card login-signup-card shadow-lg mb-0">
                            <div class="card-body px-md-5 py-5">
                                <div class="mb-5">
                                    <h3>Create Account</h3>
                                    <p class="text-muted">Sign in to your account to continue.</p>
                                </div>
                                <!--sign up form-->

                                <form class="login-signup-form" action="" method="POST">

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Trainer Name
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="text" name="Trainer_Name" class="form-control"
                                                placeholder="Enter your name" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Phone No
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="number" name="Personal_Phone_Number" class="form-control"
                                                placeholder="1234567890" required max="9999999999" min="1000000000"
                                                required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Email Address
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="email" name="Personal_Mail_id" class="form-control"
                                                placeholder="name@address.com" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Trainer Username
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="text" name="Trainer_Username" class="form-control"
                                                placeholder="Enter username" required minlength=8 maxlength=16 required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Password
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="password" name="Password" class="form-control" id='password'
                                                placeholder="Enter your password" minlength=8 maxlength=10 required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Re-Enter password
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="password" class="form-control" id='retypepassword'
                                                placeholder="Re-Enter your password" minlength=8 maxlength=10 required>
                                        </div>
                                    </div>

                                    <!-- <div>
                                        <input type="checkbox" name="checkbox" id="send_newsletter" required />
                                        By clicking Agree and Join, you agree to the TriaRight <a
                                            href="useragreement.html"> User Agreement</a> and <a
                                            href="privacypolicy.html"> Privacy policy</a>
                                    </div> -->

                                    <!-- Submit -->
                                    <button class="btn btn-block btn-secondary border-radius mt-4 mb-3"
                                        name="RegisterBtn" value="submit" type="submit" onclick="return check()">
                                        Register
                                    </button>
                                </form>
                                <script type="text/javascript">
                                function check() {
                                    var b = document.getElementById('password').value;
                                    var c = document.getElementById('retypepassword').value;
                                    if (b != c) {
                                        toastr.error("Password Does Not Match")
                                        return false;
                                    } else
                                        return true;
                                }
                                </script>

                            </div>
                            <div class="card-footer bg-soft text-center border-top px-md-5"><small>Already
                                    registered?</small>
                                <a href="trainer_login.php" class="small">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--sign up section end-->


    </div>

    <!--scroll bottom to top button start-->
    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="fas fa-hand-point-up"></span>
    </button>
    <!--scroll bottom to top button end-->



</body>

</html>