<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inbox</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">

    <?php include("./style.php"); ?>


    <style>
    /* Custom Pagination Styles */
    .dataTables_paginate {
        text-align: center;
        margin-top: 20px;
    }

    .paginate_button {
        cursor: pointer;
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        background-color: #fff;
        color: #333;
        border-radius: 3px;
        transition: background-color 0.3s ease;
    }

    .paginate_button:hover {
        background-color: #eee;
    }

    .paginate_button.current {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
    }
    </style>
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
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Inbox</a></li>
                            <li class="breadcrumb-item">Chats</li>
                            <li class="breadcrumb-item">Inbox</li>
                        </ol>
                    </div>
                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="table-responsive export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Login type</th>
                                                <th>Sender id</th>
                                                <th>Username</th>
                                                <th>Subject</th>
                                                <th>Purpose</th>
                                                <th>Recipient Type</th>
                                                <th>Sending Format</th>
                                                <th>Description</th>
                                                <th>Attachment</th>
                                                <th>Reply</th>
                                                <th>Date and time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM `mail`");
                                            if (mysqli_num_rows($query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['sender_type']; ?></td>
                                                <td><?php echo $row['sender_id']; ?></td>
                                                <td><?php echo $row['sender_name']; ?></td>
                                                <td><?php echo $row['subject']; ?></td>
                                                <td><?php echo $row['purpose']; ?></td>
                                                <td><?php echo $row['recipient_type']; ?></td>
                                                <td><?php echo $row['sending_format']; ?></td>
                                                <td><?php echo $row['message']; ?></td>
                                                <td><?php
                                                            if (!empty($row['attachment'])) {
                                                                echo '<a download="" target="_blank" href="./assets/docs/attachments/' . $row['attachment'] . '" class="btn btn-info">Download</a>';
                                                            } else {
                                                                echo "No Attachment";
                                                            }
                                                            ?>

                                                </td>
                                                <?php
                                                        if ($row["sender_type"] === "Admin") {
                                                        ?>
                                                <td><button class="btn btn-info" disabled>You Are The Sender</button>
                                                </td>
                                                <?php
                                                        } else {
                                                            if (empty($row["reply_staus"]) || $row["reply_status"] !== "Replied") {
                                                            ?>
                                                <td><a class="btn btn-success text-light" data-bs-toggle="modal"
                                                        data-bs-target="#reply_<?php echo $i; ?>">Reply</a></td>
                                                <!-- Modal -->
                                                <div class="modal fade" id="reply_<?php echo $i; ?>"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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

                                                                    <input type="hidden" name="subject"
                                                                        value="<?php echo $row['subject']; ?>">
                                                                    <input type="hidden" name="sender_id"
                                                                        value="<?php echo $_COOKIE['superadmin_id']; ?>">
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
                                                <td>
                                                    <button class="btn btn-info" disabled>Replied</button>
                                                </td>
                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                <td><?php echo $row['sending_date']; ?></td>
                                            </tr>
                                            <?php
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

    <?php include("./scripts.php"); ?>
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