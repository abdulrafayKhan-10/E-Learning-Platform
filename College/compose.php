<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
    exit();
}

$college_query = "SELECT * FROM college WHERE username = '" . $_COOKIE['college_username'] . "' AND password = '" . $_COOKIE['college_password'] . "'";

$college_result = mysqli_query($conn, $college_query);

$college = mysqli_fetch_assoc($college_result);

if (isset($_POST["submit"])) {

    $sender_id = (int) $college["id"];
    $sender_email = $_COOKIE['college_email'];
    $sender_name = $_COOKIE['college_username'];
    $sender_type = "College";

    if (isset($_POST["student"]) && !empty($_POST["student"])) {
        $student_email = $_POST["student"];
    }


    $recipient = $_POST["recipient"];
    $subject = $_POST["subject"];
    $purpose = $_POST["purpose"];
    $message = $_POST["message"];

    if (isset($_FILES["add_attachments"]) && !empty($_FILES["add_attachments"]["name"])) {
        $add_attachments = $_FILES["add_attachments"]["name"];
        $add_attachments_with_date = $recipient . date('Y-m-d-H-s') . $add_attachments;
        $add_attachments_tmp = $_FILES["add_attachments"]["tmp_name"];
    } else {
        $add_attachments_with_date = "";
    }

    switch ($recipient) {
        case "Superadmin":
            $recipient_type = "Admin";

            $admin = mysqli_query($conn, "SELECT * FROM `superadmin`");

            if (mysqli_num_rows($admin) > 0) {

                $admin = mysqli_fetch_assoc($admin);

                $admin_email = $admin["email"];
                $admin_name = $admin["username"];
                $admin_id = (int) $admin["id"];

                $insert_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `recipient_name`, `recipient_email`, `recipient_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $insert_query->bind_param("sssssssssssss", $sender_email, $sender_id, $admin_name, $admin_email, $admin_id, $sender_name, $sender_type, $recipient, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);

                if ($insert_query->execute()) {
                    if (!empty($add_attachments)) {
                        move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments_with_date);
                        $_SESSION["attachment"] = $add_attachments_with_date;
                    }

                    $_SESSION["recipient_name"] = $admin_name;
                    $_SESSION["recipient_email"] = $admin_email;

                    $_SESSION["sender_name"] = $sender_name;
                    $_SESSION["sender_email"] = $sender_email;
                    $_SESSION["sending_format"] = $recipient;

                    $_SESSION["subject"] = $subject;
                    $_SESSION["message"] = $message;
                    $_SESSION["purpose"] = $purpose;
                    $_SESSION["recipient"] = $recipient;
                    header('location: ./sendmail.php');
                }
            }

            break;
        case "Student":
            $recipient_type = "Student";

            if ($student_email == "All") {

                $student_query = mysqli_query($conn, "SELECT * FROM `student`");
                if (mysqli_num_rows($student_query) > 0) {
                    $insert_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?)");
                    $insert_query->bind_param("ssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $student_email, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);
                    if ($insert_query->execute()) {
                        if (!empty($add_attachments)) {
                            move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments_with_date);
                            $_SESSION["attachment"] = $add_attachments_with_date;
                        }
                        $_SESSION["college_name"] = $college["name"];
                        $_SESSION["sender_name"] = $sender_name;
                        $_SESSION["sender_email"] = $sender_email;
                        $_SESSION["sending_format"] = $student_email;
                        $_SESSION["subject"] = $subject;
                        $_SESSION["message"] = $message;
                        $_SESSION["purpose"] = $purpose;
                        $_SESSION["recipient"] = $recipient;
                        header('location: ./sendmail.php');
                    }
                }
            } else {
                $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `email` = '{$student_email}'");
                if (mysqli_num_rows($student_query) > 0) {

                    $student = mysqli_fetch_assoc($student_query);

                    $student_name = $student["name"];
                    $student_id = (int) $student["id"];

                    $insert_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `recipient_name`, `recipient_email`, `recipient_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $insert_query->bind_param("sssssssssssss", $sender_email, $sender_id, $student_name, $student_email, $student_id, $sender_name, $sender_type, $recipient, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);

                    if ($insert_query->execute()) {
                        if (!empty($add_attachments)) {
                            move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments_with_date);
                            $_SESSION["attachment"] = $add_attachments_with_date;
                        }

                        $_SESSION["recipient_name"] = $student_name;
                        $_SESSION["recipient_email"] = $student_email;

                        $_SESSION["sender_name"] = $sender_name;
                        $_SESSION["sender_email"] = $sender_email;
                        $_SESSION["sending_format"] = $recipient;

                        $_SESSION["subject"] = $subject;
                        $_SESSION["message"] = $message;
                        $_SESSION["purpose"] = $purpose;
                        $_SESSION["recipient"] = $recipient;
                        header('location: ./sendmail.php');
                    }
                }
            }
            break;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Compose</title>
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

        <form action="" method="POST" enctype="multipart/form-data">

            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Compose Mail</span>
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
                                class="form-control form-select select2" data-bs-placeholder="Select Country">
                                <option value="Superadmin">Super Admin</option>

                                <option value="Student">Student</option>
                            </select>
                        </div>


                        <div class="form-group col-md-4" id="optionsDiv">
                            <label for="exampleInputAadhar" hidden>User ID</label>
                            <select name="User_ID" hidden required class="form-control form-select select2"
                                data-bs-placeholder="Select Country">
                                <option value="ALL"></option>
                            </select>
                        </div>

                        <script>
                        function showOptions1() {
                            var harsha = document.getElementById("dropdown1").value;
                            if (harsha === "Student") {

                                document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">User ID</label>
<select name="student" required class="form-control form-select select2" data-bs-placeholder="Select Student">
<option value='All'>All</option>
	<?php
    $student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `college_id` = '{$college['id']}'");
    while ($student = mysqli_fetch_assoc($student_query)) {
        echo "<option value='{$student['email']}'>{$student['name']} | STID_{$student['id']} | Username : {$student['username']}</option>";
    }
    ?>
</select>

`;
                            } else {
                                document.getElementById("optionsDiv").innerHTML = `
			<label for="exampleInputAadhar" hidden>User ID</label>
			<select name="User_ID" required hidden class="form-control form-select select2" data-bs-placeholder="Select Country">
			<option value="">ALL</option>
			</select>
			`;
                            }
                        }
                        </script>


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
                                                        style="color:#ff6700"><b>Subject</b></label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputCompanyPhone" placeholder="Enter Subject"
                                                        name="subject" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar"
                                                        style="color:#ff6700"><b>Purpose</b></label>
                                                    <select name="purpose" class="form-control form-select select2"
                                                        data-bs-placeholder="Select Country" required>
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
                                                        style="color:#ff6700"><b>Describe</b></label>
                                                    <input class="form-control" placeholder="Textarea" name="message"
                                                        required>
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
                                                style="text-align:right">send</button>
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
    <?php include("./script.php"); ?>
</body>

</html>