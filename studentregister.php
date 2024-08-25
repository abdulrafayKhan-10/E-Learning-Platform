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


if (isset($_POST['submitbtn'])) {
    $regex_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $student_name = $_POST['student_name'];
    $student_phoneno = $_POST['phone_number'];
    $student_email = $_POST['mail_id'];
    $student_username = $_POST['student_username'];
    $intership_term = $_POST['intership_term'];
    $password = $_POST['password'];
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

    $encryptedPassword = encrypt_Password($_POST['password'], $key);

    if (preg_match($regex_email, $student_email) == 1) {
        $insert_query = mysqli_prepare($conn, "INSERT INTO `student`( `name`, `contact_number`, `email`, `username`, `internship`, `password`, `hashed_password`) VALUES (?,?,?,?,?,?,?)");
        $insert_query->bind_param("sssssss", $student_name, $student_phoneno, $student_email, $student_username, $intership_term, $hash_pass, $encryptedPassword);

        if ($insert_query->execute()) {
            $_SESSION['message_success'] = "Successfully registered";
        } else {
            $_SESSION['message_failed'] = true;
            $_SESSION["err_msg"] = "Database Error, Unable to register.";
        }
    } else {

        $_SESSION['message_failed'] = true;
        $_SESSION["err_msg"] = "Invalid Email Format";
    }
}
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Student Register</title>

    <?php
    include("links.php");
    ?>
</head>

<body>
    <script>
    <?php
        if (isset($_SESSION['message_success']) && !empty($_SESSION['message_success'])) {
        ?>
    toastr.success('<?php echo $_SESSION["message_success"]; ?>')
    <?php
            // session_destroy();
        } else if (isset($_SESSION['message_failed']) && !empty($_SESSION['message_failed'])) {
        ?>
    toastr.error(<?php echo $_SESSION["err_msg"]; ?>)
    <?php
        }
        session_destroy();
        ?>
    </script>
    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>

    <div class="main">

        <!--sign up section start-->

        <section
            class="section section-lg section-header position-relative min-vh-100 flex-column d-flex justify-content-center">
            <div class="container">
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
                                            Student Name
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="text" name="student_name" class="form-control"
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

                                            <input type="text" maxlength="10" pattern=[0-9]{1}[0-9]{9}
                                                name="phone_number" class="form-control" placeholder="1234567890"
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

                                            <input type="email" name="mail_id" class="form-control"
                                                placeholder="name@address.com" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Student Username
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="text" name="student_username" class="form-control"
                                                placeholder="Enter username" required minlength=8 maxlength=16 required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputQualification">Internship Term </label>
                                        <select class="form-control form-select select2" name="intership_term"
                                            data-bs-placeholder="select Internship Term" required>
                                            <option value="short_term">Short Term</option>
                                            <option value="long_term">Long Term</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="font-weight-bold">
                                            Password
                                        </label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="password" name="password" class="form-control" id='password'
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

                                    <!-- Submit -->
                                    <button class="btn btn-block btn-secondary border-radius mt-4 mb-3" name="submitbtn"
                                        value="submit" type="submit" onclick="return check()">
                                        Register
                                    </button>
                                </form>
                                <script type="text/javascript">
                                function check() {
                                    var b = document.getElementById('password').value;
                                    var c = document.getElementById('retypepassword').value;
                                    if (b != c) {
                                        alert('Password doesnt match');
                                        return false;
                                    } else
                                        return true;
                                }
                                </script>

                            </div>
                            <div class="card-footer bg-soft text-center border-top px-md-5"><small>Already
                                    registered?</small>
                                <a href="student_login.php" class="small"> Login</a>
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


</body>




</html>