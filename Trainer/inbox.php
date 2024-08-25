<?php
session_start();

include("../db_connection/connection.php");

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
	header('location: ../trainer_login.php');
	exit();
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
    <title>Inbox</title>
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
        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Inbox</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">batches management</a></li>
                            <li class="breadcrumb-item ">Chats</li>
                            <li class="breadcrumb-item ">Inbox</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">login type</th>
                                                <th class="border-bottom-0">user id</th>
                                                <th class="border-bottom-0">username</th>
                                                <th class="border-bottom-0">Subject</th>
                                                <th class="border-bottom-0">purpose</th>
                                                <th class="border-bottom-0">description</th>
                                                <th class="border-bottom-0">Attachment</th>
                                                <th class="border-bottom-0">Reply</th>
                                                <th class="border-bottom-0">date and time</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
											$student_name = $_COOKIE["trainer_username"];
											$student_password = $_COOKIE["trainer_password"];

											$student_query = "SELECT * FROM `trainer` WHERE `username` = '$student_name' AND `password` = '$student_password'";
											$student_result = mysqli_query($conn, $student_query);
											$fetch = mysqli_fetch_assoc($student_result);

											$sql = "SELECT * FROM `mail` WHERE (`sender_type` = 'Student' OR `sender_type` = 'Admin' OR `sender_type`='College') AND (`sender_email`='" . $fetch["email"] . "' OR `recipient_email`='" . $fetch["email"] . "') OR (`sender_type` = 'Trainer' AND `recipient_email`='" . $fetch["email"] . "')";
											$query = mysqli_query($conn, $sql);
											if (mysqli_num_rows($query) > 0) {
												$i = 1;
												while ($row = mysqli_fetch_assoc($query)) {
													echo "<tr>";
													echo "<td>{$i}</td>";
													echo "<td>SEID_{$row['sender_id']}</td>";
													echo "<td>{$row['sender_name']}</td>";
													echo "<td>{$row['subject']}</td>";
													echo "<td>{$row['purpose']}</td>";
													echo "<td>{$row['recipient_name']}</td>";
													echo "<td>{$row['recipient_type']}</td>";
													echo "<td>{$row['sending_format']}</td>";
													echo "<td>{$row['message']}</td>";
													echo "<td><a href='../superadmin/assets/docs/attachments/{$row['attachment']}' class='btn btn-primary' download=''>Download</a></td>";

													if ($row["sender_type"] === "Trainer") {
											?>
                                            <td><button class="btn btn-info" disabled>You Are The Sender</button>
                                            </td>
                                            <?php
													} else {
														if (empty($row["reply_status"]) || $row["reply_status"] !== "Replied") {
														?>
                                            <td><a class="btn btn-success text-light" data-bs-toggle="modal"
                                                    data-bs-target="#reply_<?php echo $i; ?>">Reply</a></td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="reply_<?php echo $i; ?>"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                Reply</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="reply.php" method="POST">
                                                                <input type="hidden" name="recipient_id"
                                                                    value="<?php echo $row['sender_id']; ?>">
                                                                <input type="hidden" name="recipient_name"
                                                                    value="<?php echo $row['sender_name']; ?>">
                                                                <input type="hidden" name="sender_email"
                                                                    value="<?php echo $row['sender_email']; ?>">
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo $fetch["id"]; ?>">
                                                                <input type="hidden" name="subject"
                                                                    value="<?php echo $row['subject']; ?>">
                                                                <input type="hidden" name="sender_id"
                                                                    value="<?php echo $fetch["id"]; ?>">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $row['id']; ?>">
                                                                <input type="hidden" name="recipient_type"
                                                                    value="<?php echo $row['recipient_type']; ?>">
                                                                <div class="mb-3">

                                                                    <label class="form-label">Message</label>
                                                                    <textarea class="form-control" name="message"
                                                                        required></textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Reply</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
														} else {
														?>
                                            <td><button class="btn btn-info text-light" disabled>Replied</button>
                                            </td>
                                            <?php
														}
													}

													echo "<td>{$row['sending_date']}</td>";
													echo "</tr>";
													$i++;
												}
											}
											?>

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


    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

    <?php
	include('./script.php');
	?>

    <?php
	if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
		echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
	}
	if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
		echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
	}
	if (session_unset()) {
		$_SESSION["previous_url"] = $_SERVER['REQUEST_URI'];
	}
	?>

</body>

</html>