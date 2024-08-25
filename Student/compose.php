<?php
session_start();

include("../db_connection/connection.php");

if (!isset($_COOKIE['student_username']) && !isset($_COOKIE['student_password'])) {
    header('location: ../student_login.php');
    exit();
}

if (isset($_POST["submit"])) {
    $recipient = $_POST["recipient"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $purpose = $_POST["purpose"];
    if (isset($_FILES["add_attachments"]["name"]) && !empty($_FILES["add_attachments"]["name"])) {
        $add_attachments = $_FILES["add_attachments"]["name"];
        $add_attachments_tmp = $_FILES["add_attachments"]["tmp_name"];
    } else {
        $add_attachments = "";
    }

    switch ($recipient) {
        case "Superadmin":
            $admin_query = mysqli_query($conn, "SELECT * FROM `superadmin`");
            if (mysqli_num_rows($admin_query) > 0) {
                $admin = mysqli_fetch_assoc($admin_query);
                $student_id = (int) $_COOKIE["student_id"];
                $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` ='$student_id'");
                if (mysqli_num_rows($student_query) > 0) {
                    $student = mysqli_fetch_assoc($student_query);
                    $sender_email = $student["email"];
                    $sender_name = $student["name"];
                    $sender_id = $student["id"];
                    $sender_type = "Student";
                    $recipient_id = $admin["id"];
                    $recipient_name = $admin["username"];
                    $recipient_email = $admin["email"];
                    $sending_format = "Individuals";

                    $mail_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `recipient_email`, `recipient_id`, `recipient_name`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $mail_query->bind_param("sssssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $recipient_email, $recipient_id, $recipient_name, $sending_format, $subject, $message, $add_attachments, $purpose, $recipient);
                    if ($mail_query->execute()) {
                        if (!empty($add_attachments)) {
                            move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments);
                        }

                        $_SESSION["attachment"] = $add_attachments;
                        $_SESSION["sending_format"] = $sending_format;
                        $_SESSION["recipient_name"] = $recipient_name;
                        $_SESSION["recipient_email"] = $recipient_email;
                        $_SESSION["recipient"] = $recipient;
                        $_SESSION["purpose"] = $purpose;
                        $_SESSION["subject"] = $subject;
                        $_SESSION["message"] = $message;

                        header('location: ./sendmail.php');
                        exit();
                    } else {
                        $_SESSION["error"] = "Something went wrong";
                        header('location: ./compose.php');
                        exit();
                    }
                }
            }

            break;
        case "Trainer":
            $trainer_email = $_POST["User_ID"];
            $trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `email` ='$trainer_email'");
            if (mysqli_num_rows($trainer_query) > 0) {
                $student_id = (int) $_COOKIE["student_id"];
                $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` ='$student_id'");
                if (mysqli_num_rows($student_query) > 0) {
                    $student = mysqli_fetch_assoc($student_query);
                    $trainer = mysqli_fetch_assoc($trainer_query);
                    $sender_email = $student["email"];
                    $sender_name = $student["name"];
                    $sender_id = $student["id"];
                    $sender_type = "Student";
                    $recipient_id = $trainer["id"];
                    $recipient_name = $trainer["name"];
                    $recipient_email = $trainer["email"];
                    $sending_format = "Individuals";

                    $mail_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `recipient_email`, `recipient_id`, `recipient_name`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $mail_query->bind_param("sssssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $recipient_email, $recipient_id, $recipient_name, $sending_format, $subject, $message, $add_attachments, $purpose, $recipient);
                    if ($mail_query->execute()) {
                        if (!empty($add_attachments)) {
                            move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments);
                        }

                        $_SESSION["attachment"] = $add_attachments;
                        $_SESSION["sending_format"] = $sending_format;
                        $_SESSION["recipient_name"] = $recipient_name;
                        $_SESSION["recipient_email"] = $recipient_email;
                        $_SESSION["recipient"] = $recipient;
                        $_SESSION["purpose"] = $purpose;
                        $_SESSION["subject"] = $subject;
                        $_SESSION["message"] = $message;

                        header('location: ./sendmail.php');
                        exit();
                    } else {
                        $_SESSION["error"] = "Something went wrong";
                        header('location: ./compose.php');
                        exit();
                    }
                } else {
                    $_SESSION["error"] = "Sender Student Not Found";
                    header('location: ./compose.php');
                    exit();
                }
            } else {
                $_SESSION["error"] = "Trainer Email Not Found";
                header('location: ./compose.php');
                exit();
            }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>Compose</title>

    <?php include("./links.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Page -->
    <div class="page">

        <div>
            <?php include("./partials/sidebar.php"); ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- main-content -->
                <div class="main-content app-content">
                    <!-- container -->
                    <div class="main-container container-fluid">
                        <!-- breadcrumb -->
                        <div class="breadcrumb-header justify-content-between">
                            <div class="left-content">
                                <span class="main-content-title mg-b-0 mg-b-lg-1" style="color: #ff6700"> Compose
                                    Mail</span>
                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION["mail_sent"]) && !empty($_SESSION["mail_sent"])) {
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . $_SESSION['mail_sent'] . "</div> ";
                            unset($_SESSION["mail_sent"]);
                        }
                        ?>
                        <div class="row row-sm">
                            <div class="form-group col-md-6">
                                <label for="dropdown">Recipient</label>
                                <select id="dropdown1" onchange="showOptions1()" name="recipient" required
                                    class="form-select">
                                    <option value="Superadmin">Super Admin</option>
                                    <option value="Trainer">Trainer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="optionsDiv" style="display:none">
                                <label for="exampleInputAadhar">User ID</label>
                                <select name="User_ID" required class="form-select">
                                    <?php
                                    $trainer = mysqli_query($conn, "SELECT * FROM `trainer`");
                                    while ($row = mysqli_fetch_assoc($trainer)) {
                                        echo "<option value='{$row['email']}'>{$row['username']}</option>";
                                    }

                                    ?>
                                </select>
                            </div>

                        </div>
                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="">
                                            <div class="row row-xs formgroup-wrapper">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputCompanyPhone"
                                                            style="color: #ff6700"><b>Subject</b></label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputCompanyPhone" placeholder="Enter Subject"
                                                            name="subject" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputAadhar"
                                                            style="color: #ff6700"><b>Purpose</b></label>
                                                        <select name="purpose" class="form-select" required>
                                                            <option value="query">query</option>
                                                            <option value="feedback">feedback</option>
                                                            <option value="issue">issue</option>
                                                            <option value="General">General</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-label">
                                                        <label for="exampleInputAadhar"
                                                            style="color: #ff6700"><b>Describe</b></label>
                                                        <input class="form-control" placeholder="Textarea"
                                                            name="message" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputcode">Add Attachments</label>
                                                        <input type="file" class="form-control" id="exampleInputcode"
                                                            placeholder="" name="add_attachments">
                                                    </div>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary mt-3 mb-0"
                                                    style="text-align: right">send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container closed -->
                </div>
            </form>



        </div>
        <!-- End Page -->

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

        <?php include("./scripts.php") ?>
        <script>
        function showOptions1() {
            var type = document.getElementById("dropdown1");
            if (type.value == "Student") {
                document.getElementById("optionsDiv").style.display = "block";
            } else {
                document.getElementById("optionsDiv").style.display = "none";
            }
            if (type.value == "Superadmin") {
                document.getElementById("optionsDiv").style.display = "none";
            } else {
                document.getElementById("optionsDiv").style.display = "block";
            }

        }
        </script>


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