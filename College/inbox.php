<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['college_username']) && !isset($_COOKIE['college_password'])) {
    header('location: ../college_login.php');
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
    <?php include("./style.php") ?>
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

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
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">


                <div class="breadcrumb-header justify-content-between">
                    <div class="right-content">
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Inbox</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Internship management</a>
                            </li>
                            <li class="breadcrumb-item ">Chats</li>
                            <li class="breadcrumb-item ">Inbox</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <?php
                    if (isset($_SESSION["mail_sent"]) && !empty($_SESSION["mail_sent"])) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . $_SESSION['mail_sent'] . "</div> ";
                        unset($_SESSION["mail_sent"]);
                    }
                    ?>

                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="table-responsive export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>

                                                <th>Sender id</th>
                                                <th>Sender Name</th>
                                                <th>Subject</th>
                                                <th>Purpose</th>
                                                <th>Recipient</th>
                                                <th>Recipient Type</th>
                                                <th>Sending Format</th>
                                                <th>Message</th>
                                                <th>Attachment</th>
                                                <th>Reply</th>
                                                <th>Date and time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $college_name = $_COOKIE["college_username"];
                                            $college_password = $_COOKIE["college_password"];

                                            $college_query = "SELECT * FROM `college` WHERE `username` = '$college_name' AND `password` = '$college_password'";
                                            $college_result = mysqli_query($conn, $college_query);
                                            $fetch = mysqli_fetch_assoc($college_result);

                                            $sql = "SELECT * FROM `mail` WHERE (`sender_type` = 'College' OR `sender_type` = 'Admin' OR `sender_type`='Student') AND (`sender_email`='" . $fetch["email"] . "' OR `recipient_email`='" . $fetch["email"] . "') OR (`sender_type` = 'College' AND `recipient_email`='" . $fetch["email"] . "')";

                                            $query = mysqli_query($conn, $sql);
                                            // if (!$conn) {
                                            //     die("Connection failed: " . mysqli_connect_error());
                                            // }

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

                                                    if ($row["sender_type"] === "College") {
                                            ?>
                                            <td><button class="btn btn-info" disabled>You Are The Sender</button></td>
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
                                                                <input type="hidden" name="college_id"
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
                                            <td><button class="btn btn-info text-light" disabled>Replied</button></td>
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
    <?php include("./script.php"); ?>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#file-datatable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
        });
    });
    </script>
</body>

</html>