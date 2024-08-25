<?php
session_start();
include("../db_connection/connection.php");

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
}


$trainer = "SELECT * FROM trainer WHERE username = '" . $_COOKIE['trainer_username'] . "' AND password = '" . $_COOKIE['trainer_password'] . "'";

$trainer_result = mysqli_query($conn, $trainer);

$trainer = mysqli_fetch_assoc($trainer_result);

if (isset($_POST["submit"])) {

	$sender_id = (int) $trainer["id"];
	$sender_email = $_COOKIE['trainer_email'];
	$sender_name = $_COOKIE['trainer_username'];
	$sender_type = "Trainer";

	if (isset($_POST["student"]) && !empty($_POST["student"])) {
		$student_email = $_POST["student"];
	}


	$recipient = $_POST["Recipient"];
	$subject = $_POST["Subject"];
	$purpose = $_POST["Purpose"];
	$message = $_POST["Describe"];

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
						$_SESSION["college_name"] = $trainer["name"];
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
			} else if ($_POST["Sending_format"] === "batches") {
				$format = $_POST["Sending_format"];
				$recipient_type = "Trainer";
				$batch_id = (int) $_POST["Select_batch"];
				$insert_query_college = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `batch_id`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
				$recipient_type = "Trainer";
				$insert_query_college->bind_param("sssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $format, $subject, $message, $add_attachments_with_date, $purpose, $batch_id, $recipient_type);
				if ($insert_query_college->execute()) {
					if (!empty($add_attachments)) {
						move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
						$_SESSION["attachment"] = $add_attachments_with_date;
					}
					$_SESSION["sender_email"] = $sender_email;
					$_SESSION["sender_name"] = $sender_name;
					$_SESSION["sending_format"] = $format;
					$_SESSION["batch_id"] = $batch_id;
					$_SESSION["subject"] = $subject;
					$_SESSION["message"] = $message;
					$_SESSION["purpose"] = $purpose;
					$_SESSION["recipient"] = $recipient;
					header('location: ./sendmail.php');
				}
			} else {
				$student_email_individual = $_POST["student"];
				$student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `email` = '{$student_email_individual}'");
				if (mysqli_num_rows($student_query) > 0) {

					$student = mysqli_fetch_assoc($student_query);

					$student_name = $student["name"];
					$student_id = (int) $student["id"];

					$insert_query = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `recipient_name`, `recipient_email`, `recipient_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$insert_query->bind_param("sssssssssssss", $sender_email, $sender_id, $student_name, $student_email_individual, $student_id, $sender_name, $sender_type, $recipient, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);

					if ($insert_query->execute()) {
						if (!empty($add_attachments)) {
							move_uploaded_file($add_attachments_tmp, "../superadmin/assets/docs/attachments/" . $add_attachments_with_date);
							$_SESSION["attachment"] = $add_attachments_with_date;
						}

						$_SESSION["recipient_name"] = $student_name;
						$_SESSION["recipient_email"] = $student_email_individual;

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

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <!-- Title -->
    <title>Compose</title>

    <?php
	include('./style.php');
	?>

</head>

<body class="ltr main-body app sidebar-mini">

    <?php
	include('./switcher.php');
	?>

    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">
                <?php include('./partials/navbar.php') ?>
            </div>

            <!-- /main-header -->
            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- main-content -->
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
                        <div class="form-group col-md-4">
                            <label for="dropdown">Recipient</label>
                            <select id="dropdown1" onchange="showOptions1()" name="Recipient" required
                                class="form-control form-select select2" data-bs-placeholder="Select Country">
                                <option value="Superadmin">Super Admin</option>
                                <option value="Student">Student</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dropdown">Sending format</label>
                            <select id="dropdown" onchange="showOptions1()" name="Sending_format" required
                                class="form-control form-select select2" data-bs-placeholder="Select Country">
                                <option value="All">All</option>
                                <option id="Individuals" style="display:none;" value="Individuals">Individuals</option>
                                <option id="batch" style="display:none;" value="batches">Batches</option>
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
                                document.getElementById("batch").style.display = "unset";
                                document.getElementById("Individuals").style.display = "unset";

                                var selectedOption = document.getElementById("dropdown").value;
                                if (selectedOption === "Individuals") {
                                    document.getElementById("optionsDiv").innerHTML = `

<label for="exampleInputAadhar">User ID</label>
<select name="student" required class="form-control form-select select2" data-bs-placeholder="Select Country">
<option value="All">All</option>
<?php
$id = $trainer["id"];

$student_allocate_query = mysqli_query($conn, "SELECT * FROM `student_allocate`");

while ($student_allocate = mysqli_fetch_assoc($student_allocate_query)) {
	$allocate_trainer_course_query = mysqli_query($conn, "SELECT * FROM `allocate_trainer_course` WHERE `id` = '{$student_allocate['allocate_id']}'");

	$allocate_trainer_course = mysqli_fetch_assoc($allocate_trainer_course_query);

	if ($allocate_trainer_course['trainer_id'] == $id) {

		$student_query = mysqli_query($conn, "SELECT * FROM `student` WHERE `id` = '{$student_allocate['student_id']}'");

		$student = mysqli_fetch_assoc($student_query);

		echo "<option value='{$student['email']}'>{$student['name']} | STID_{$student['id']} | Username : {$student['username']}</option>";
	}
}

?>
</select>

`;
                                } else if (selectedOption === "batches") {
                                    document.getElementById("optionsDiv").innerHTML = `
				<div class="form-group col-md-4">
											<label for="exampleInputAadhar">Select Batch</label>
										<select name="Select_batch" required class="form-control form-select select2" data-bs-placeholder="Select Batch">
											<?php
											$batch_query = mysqli_query($conn, "SELECT * FROM `batch` WHERE `trainer_id` = '$id'");
											$i = 1;
											if (mysqli_num_rows($batch_query) > 0) {
												while ($batch = mysqli_fetch_assoc($batch_query)) {
													echo "<option value='{$batch['id']}'>{$i}) {$batch['batch_name']} | Batch ID : BID_{$batch['id']}</option>";
													$i++;
												}
											}
											?>


										</select>
										</div>
										
										

                `;
                                } else {
                                    document.getElementById("optionsDiv").innerHTML = `
				<label for="exampleInputAadhar" hidden>Select batch</label>
										<select hidden name="Select_batch" required class="form-control form-select select2" data-bs-placeholder="Select Batch">
    										<option value="ALL"></option>
								
				`;
                                }
                            } else {
                                document.getElementById("batch").style.display = "none";
                                document.getElementById("Individuals").style.display = "none";

                                var selectedOption = document.getElementById("dropdown").value;
                                if (selectedOption === "Individuals") {

                                    document.getElementById("dropdown").innerHTML = `<select id="dropdown" onchange="showOptions1()" name="Sending_format" required class="form-control form-select select2" data-bs-placeholder="Select Country">
											<option value="All">All</option>
											<option id="Individuals" style="display:none;"  value="Individuals">Individuals</option>
											<option id="batch" style="display:none;" value="batches">batches</option>
											</select>`;
                                    document.getElementById("optionsDiv").innerHTML = `
				<label for="exampleInputAadhar" hidden>User ID</label>
				<select name="User_ID" hidden required class="form-control form-select select2" data-bs-placeholder="Select Country">
				<option value="ALL"></option>
				</select>
				`;
                                } else if (selectedOption === "batches") {
                                    document.getElementById("dropdown").innerHTML = `<select id="dropdown" onchange="showOptions1()" name="Sending_format" required class="form-control form-select select2" data-bs-placeholder="Select Country">
											<option value="All">All</option>
											<option id="Individuals" style="display:none;"  value="Individuals">Individuals</option>
											<option id="batch" style="display:none;" value="batches">batches</option>
											</select>`;
                                    document.getElementById("optionsDiv").innerHTML = `
				<label for="exampleInputAadhar" hidden>User ID</label>
				<select name="User_ID" hidden required class="form-control form-select select2" data-bs-placeholder="Select Country">
				<option value="ALL"></option>
				</select>
				`;
                                } else {
                                    document.getElementById("optionsDiv").innerHTML = `
				<label for="exampleInputAadhar" hidden>User ID</label>
				<select name="User_ID" hidden required class="form-control form-select select2" data-bs-placeholder="Select Country">
				<option value="ALL"></option>
				</select>
				`;
                                }
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
                                                        name="Subject" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputAadhar"
                                                        style="color:#ff6700"><b>Purpose</b></label>
                                                    <select name="Purpose" class="form-control form-select select2"
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
                                                    <input class="form-control" placeholder="Textarea" name="Describe"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">add attachments</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        placeholder="" name="add_attachments">
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-primary mt-3 mb-0"
                                                data-bs-target="#send" data-bs-toggle="modal"
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

    <?php
	include('./script.php');
	?>

</body>

</html>