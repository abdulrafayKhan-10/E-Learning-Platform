<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
	header('location: ../super-admin_login.php');
	exit();
}


if (isset($_POST["submit"])) {
	$sender_email = $_COOKIE['superadmin_email'];
	$admin_query = mysqli_query($conn, "SELECT * FROM `superadmin` WHERE `email` = '$sender_email'");
	$admin = mysqli_fetch_assoc($admin_query);
	$sender_id = (int) $admin["id"];
	$sender_name = $admin["username"];
	$sender_type = "Admin";

	if (isset($_POST["student_id"]) && !empty($_POST["student_id"])) {
		$student_id = filter_var($_POST["student_id"], FILTER_SANITIZE_NUMBER_INT);
		$student_id = (int)$student_id;
	}

	if (isset($_POST["batch_id"]) && !empty($_POST["batch_id"])) {
		$batch_id = filter_var($_POST["batch_id"], FILTER_SANITIZE_NUMBER_INT);
		$batch_id = (int)$batch_id;
	}

	if (isset($_POST["trainer_id"]) && !empty($_POST["trainer_id"])) {
		$trainer_id = filter_var($_POST["trainer_id"], FILTER_SANITIZE_NUMBER_INT);
		$trainer_id = (int)$trainer_id;
	}
	if (isset($_POST["college_id"]) && !empty($_POST["college_id"])) {
		$college_id = filter_var($_POST["college_id"], FILTER_SANITIZE_NUMBER_INT);
		$college_id = (int)$college_id;
	}


	$recipient = $_POST["recipient"];
	$sending_format = $_POST["sending_format"];
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
		case "Student":

			if ($sending_format === "Individuals") {
				$student_query = mysqli_query($conn, "SELECT * FROM student WHERE id = $student_id");
				if (mysqli_num_rows($student_query) > 0) {
					$student = mysqli_fetch_assoc($student_query);
					$student_name = $student["name"];
					$recipient_id = (int) $student["id"];
					$student_email = $student["email"];
					$recipient = $student_email;
					$insert_query_student = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `recipient_email`, `recipient_id`, `recipient_name`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
					// var_dump($sender_email, $sender_id, $sender_name, $sender_type, $student_email, $recipient_id, $student_name, $sending_format, $subject, $message, $add_attachments_with_date, $purpose);

					// if ($insert_query_student === false) {
					// 	die('Error binding parameters: ' . mysqli_error($conn));
					// }
					$recipient_type = "Student";
					$insert_query_student->bind_param("sssssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $student_email, $recipient_id, $student_name, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);
					if ($insert_query_student->execute()) {
						if (!empty($add_attachments)) {
							move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
							$_SESSION["attachment"] = $add_attachments_with_date;
						}
						$_SESSION["recipient_name"] = $student_name;
						$_SESSION["recipient_email"] = $student_email;
						$_SESSION["sending_format"] = $sending_format;
						$_SESSION["subject"] = $subject;
						$_SESSION["message"] = $message;

						$_SESSION["purpose"] = $purpose;
						header('location: ./sendmail.php');
					} else {
						die('Error executing the query: ' . mysqli_error($conn));
					}
				}
			} else if ($sending_format === "Batches") {
				$insert_query_college = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `batch_id`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
				$recipient_type = "Trainer";
				$insert_query_college->bind_param("sssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $batch_id, $recipient_type);
				if ($insert_query_college->execute()) {
					if (!empty($add_attachments)) {
						move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
						$_SESSION["attachment"] = $add_attachments_with_date;
					}
					$_SESSION["sending_format"] = $sending_format;
					$_SESSION["batch_id"] = $batch_id;
					$_SESSION["subject"] = $subject;
					$_SESSION["message"] = $message;
					$_SESSION["purpose"] = $purpose;
					$_SESSION["recipient"] = $recipient;
					header('location: ./sendmail.php');
				}
			}
			break;
		case "College":
			if ($sending_format == "All") {
				$insert_query_college = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$recipient_type = "College";
				$insert_query_college->bind_param("ssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);
				if ($insert_query_college->execute()) {
					if (!empty($add_attachments)) {
						move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
						$_SESSION["attachment"] = $add_attachments_with_date;
					}
					$_SESSION["sending_format"] = $sending_format;
					$_SESSION["subject"] = $subject;
					$_SESSION["message"] = $message;
					$_SESSION["purpose"] = $purpose;
					$_SESSION["recipient"] = $recipient;
					header('location: ./sendmail.php');
				}
			} else if ($sending_format == "Individuals") {
				$college_query = mysqli_query($conn, "SELECT * FROM `college` WHERE `id` = $college_id");
				if (mysqli_num_rows($college_query) > 0) {
					$college = mysqli_fetch_assoc($college_query);
					$college_email = $college["email"];
					$college_name = $college["name"];

					$insert_query_college = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `recipient_email`, `recipient_id`, `recipient_name`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$recipient_type = "College";
					$insert_query_college->bind_param("sssssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $college_email, $college_id, $college_name, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);

					if ($insert_query_college->execute()) {
						if (!empty($add_attachments)) {
							move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
							$_SESSION["attachment"] = $add_attachments_with_date;
						}
						$_SESSION["recipient_name"] = $college_name;
						$_SESSION["recipient_email"] = $college_email;
						$_SESSION["sending_format"] = $sending_format;
						$_SESSION["subject"] = $subject;
						$_SESSION["message"] = $message;
						$_SESSION["purpose"] = $purpose;
						header('location: ./sendmail.php');
					}
				}
			}
			break;
		case "Trainer":
			if ($sending_format == "All") {

				$insert_query_college = mysqli_prepare($conn, "INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$recipient_type = "Trainer";
				$insert_query_college->bind_param("ssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);
				if ($insert_query_college->execute()) {
					if (!empty($add_attachments)) {
						move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
						$_SESSION["attachment"] = $add_attachments_with_date;
					}
					$_SESSION["sending_format"] = $sending_format;
					$_SESSION["subject"] = $subject;
					$_SESSION["message"] = $message;
					$_SESSION["purpose"] = $purpose;
					$_SESSION["recipient"] = $recipient;
					header('location: ./sendmail.php');
				}
			} else if ($sending_format == "Individuals") {
				$trainer_query = mysqli_query($conn, "SELECT * FROM `trainer` WHERE `id` = $trainer_id");
				if (mysqli_num_rows($trainer_query) > 0) {
					$trainer = mysqli_fetch_assoc($trainer_query);
					$trainer_email = $trainer["email"];
					$trainer_name = $trainer["name"];

					$insert_trainer = mysqli_prepare(
						$conn,
						"INSERT INTO `mail`(`sender_email`, `sender_id`, `sender_name`, `sender_type`, `recipient_email`, `recipient_id`, `recipient_name`, `sending_format`, `subject`, `message`, `attachment`, `purpose`, `recipient_type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)"
					);
					$recipient_type = "Trainer";
					$insert_trainer->bind_param("sssssssssssss", $sender_email, $sender_id, $sender_name, $sender_type, $trainer_email, $trainer_id, $trainer_name, $sending_format, $subject, $message, $add_attachments_with_date, $purpose, $recipient_type);
					if ($insert_trainer->execute()) {

						if (!empty($add_attachments)) {
							move_uploaded_file($add_attachments_tmp, "./assets/docs/attachments/" . $add_attachments_with_date);
							$_SESSION["attachment"] = $add_attachments_with_date;
						}
						$_SESSION["recipient_name"] = $trainer_name;
						$_SESSION["recipient_email"] = $trainer_email;
						$_SESSION["sending_format"] = $sending_format;
						$_SESSION["subject"] = $subject;
						$_SESSION["message"] = $message;
						$_SESSION["purpose"] = $purpose;
						header('location: ./sendmail.php');
					}
				}

				break;
			}
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

                    <div class="card">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="form-group col-md-6">
                                    <label for="dropdown">Recipient</label>
                                    <select id="dropdown1" onchange="showOptions1()" name="recipient" required
                                        class="form-control form-select select2" data-bs-placeholder="Select Country">
                                        <option value="College">College</option>
                                        <option value="Trainer">Trainer</option>
                                        <option value="Student">Student</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dropdown">Sending format</label>
                                    <select id="dropdown" onchange="showOptions1()" name="sending_format" required
                                        class="form-control form-select select2" data-bs-placeholder="Select Country">
                                        <option value="All">All</option>
                                        <option value="Individuals">Individuals</option>
                                        <option id="batch" style="display:none;" value="Batches">Batches</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" id="optionsDiv">
                                    <label for="exampleInputAadhar" hidden>User ID</label>
                                    <select name="User_ID" hidden required class="form-control form-select select2"
                                        data-bs-placeholder="Select Country">
                                        <option value="ALL"></option>
                                    </select>
                                </div>

                                <script>
                                function showOptions1() {
                                    var recipientValue = document.getElementById("dropdown1").value;
                                    var sendingFormatValue = document.getElementById("dropdown").value;

                                    if (recipientValue === "Student") {
                                        document.getElementById("batch").style.display = "unset";

                                        if (sendingFormatValue === "Individuals") {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <label for="exampleInputAadhar">User ID</label>
                                                <select name="student_id" required class="form-control form-select select2" data-bs-placeholder="Select Student">
                                                    <?php
													$student_query = mysqli_query($conn, "SELECT * FROM student");
													$i = 1;
													if (mysqli_num_rows($student_query) > 0) {
														while ($student = mysqli_fetch_assoc($student_query)) {
															echo "<option value='{$student['id']}'>{$i}) {$student['name']} | STID_{$student['id']} | Username : {$student['username']}</option>";
															$i++;
														}
													}
													?>
                                                </select>
                                            `;
                                        } else if (sendingFormatValue === "Batches") {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputAadhar">Select batch</label>
                                                    <select name="batch_id" required class="form-control form-select select2" data-bs-placeholder="Select Batch">
                                                      
                                                        <?php
														$batch_query = mysqli_query($conn, "SELECT * FROM batch");
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
                                            document.getElementById("optionsDiv").innerHTML = "";
                                        }
                                    } else if (recipientValue === "College") {
                                        document.getElementById("batch").style.display = "none";

                                        var selectedOption = document.getElementById("dropdown").value;
                                        if (selectedOption === "Individuals") {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <label for="exampleInputAadhar">College ID</label>
                                                <select name="college_id" required class="form-control form-select select2" data-bs-placeholder="Select Country">
                                                    <?php
													$college_query = mysqli_query($conn, "SELECT * FROM college");
													$i = 1;
													if (mysqli_num_rows($college_query) > 0) {
														while ($college = mysqli_fetch_assoc($college_query)) {
															echo "<option value='{$college['id']}'>{$i}) {$college['name']}</option>";
															$i++;
														}
													}
													?>
                                                </select>
                                            `;
                                        } else if (selectedOption === "batches") {
                                            document.getElementById("dropdown").innerHTML = `<select id="dropdown" onchange="showOptions1()" name="sending_format" required class="form-control form-select select2" data-bs-placeholder="Select Country">
                                                    <option value="All">All</option>
                                                    <option value="Individuals">Individuals</option>
                                                    <option id="batch" style="display:none;" value="Batches">batches</option>
                                                </select>`;
                                            document.getElementById("optionsDiv").innerHTML = "";
                                        } else {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <label for="exampleInputAadhar" hidden>User ID</label>
                                                <select name="User_ID" hidden required class="form-control form-select select2" data-bs-placeholder="Select Country">
                                                    <option value="ALL"></option>
                                                </select>
                                                `;
                                        }
                                    } else if (recipientValue === "Trainer") {
                                        document.getElementById("batch").style.display = "none";

                                        var selectedOption = document.getElementById("dropdown").value;
                                        if (selectedOption === "Individuals") {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <label for="exampleInputAadhar">User ID</label>
                                                <select name="trainer_id" required class="form-control form-select select2" data-bs-placeholder="Select Trainer">
                                                    <?php
													$trainer_query = mysqli_query($conn, "SELECT * FROM trainer");
													$i = 1;
													if (mysqli_num_rows($trainer_query) > 0) {
														while ($trainer = mysqli_fetch_assoc($trainer_query)) {
															echo "<option value='{$trainer['id']}'> {$trainer['name']}</option>";
															$i++;
														}
													}
													?>
                                                </select>
                                            `;
                                        } else if (selectedOption === "batches") {
                                            document.getElementById("dropdown").innerHTML = `<select id="dropdown" onchange="showOptions1()" name="sending_format" required class="form-control form-select select2" data-bs-placeholder="Select Country">                                           
                                                    <option value="All">All</option>
                                                    <option value="Individuals">Individuals</option>
                                                    <option id="batch" style="display:none;" value="batches">batches</option>
                                                </select>`;
                                            document.getElementById("optionsDiv").innerHTML = "";
                                        } else {
                                            document.getElementById("optionsDiv").innerHTML = `
                                                <label for="exampleInputAadhar" hidden>User ID</label>
                                                <select name="User_ID" hidden required class="form-control form-select select2" data-bs-placeholder="Select Country">
                                                    <option value="ALL"></option>
                                                </select>
                                                `;
                                        }
                                    } else {
                                        document.getElementById("batch").style.display = "none";
                                    }
                                }
                                </script>
                            </div>

                            <!-- row -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
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
                                                        style="color:#ff6700"><b>Message</b></label>
                                                    <input class="form-control" placeholder="Textarea" name="message"
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
                                                style="text-align:right">Send
                                            </button>
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

    <?php include("./scripts.php"); ?>

</body>

</html>