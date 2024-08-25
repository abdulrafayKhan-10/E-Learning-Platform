<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}
if (isset($_POST['sendBtn'])) {
    $msg_username = $_POST['msg_username'];
    $msg_email = $_POST['msg_email'];
    $msg_type = $_POST['msg_type'];
    $msg_user_type = $_POST['msg_user_type'];
    $msg_messages = $_POST['msg_messages'];
    $insert_query = mysqli_prepare($conn, "INSERT INTO `messages`( `receiver_id`, `message`, `user_type`, `username`, `email`, `message_type`) VALUES (0,?,?,?,?,?)");
    $insert_query->bind_param("sssss", $msg_messages, $msg_user_type, $msg_username, $msg_email, $msg_type);
    if ($insert_query->execute()) {
        $_SESSION['success'] = "Message Sent";
        header("location:contactformmsgs.php");
        exit();
    } else {
        $_SESSION["error"] = "Unsuccessful. Please try again.";
        header("location:contactformmsgs.php");
        exit();
    }
}
if (isset($_POST['DeleteBtn'])) {
    $del_hidden_id = $_POST['del_hidden_id'];
    $del_hidden_username = $_POST['del_hidden_username'];
    $del_hidden_email = $_POST['del_hidden_email'];
    $delete_query = mysqli_query($conn, "DELETE FROM `messages` WHERE id = '$del_hidden_id'");
    if ($delete_query) {
        mysqli_query($conn, "DELETE FROM `messages` WHERE username = '$del_hidden_username' && email = '$del_hidden_email'");

        $_SESSION['success'] = "Deleted Successfully";
        header("location:contactformmsgs.php");
        exit();
    } else {

        $_SESSION['error'] = "Unable to Delete";
        header("location:contactformmsgs.php");
        exit();
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
    <title>Contact Form Messages</title>

    <?php include("./style.php"); ?>

</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Switcher -->
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Contact Form</span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Contact</a>
                            </li>

                            <li class="breadcrumb-item ">Contact Form</li>
                        </ol>
                    </div>

                </div>

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive  export-table">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">username</th>
                                                <th class="border-bottom-0">email</th>
                                                <th class="border-bottom-0">message</th>
                                                <th class="border-bottom-0">date and time</th>
                                                <th class="border-bottom-0">Actions</th>

                                            </tr>
                                        </thead>
                                        <?php
                                        $select_query = mysqli_query($conn, "SELECT * FROM `messages` WHERE (sender_id = 0) && (message_type = 'contact_form') && (user_type = 'Anonymous') ORDER BY id DESC");
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($select_query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['message'] ?></td>
                                                <td></td>
                                                <td>
                                                    <?php
                                                    $un = $row['username'];
                                                    $em = $row['email'];
                                                    $select_msgs = mysqli_query($conn, "SELECT * FROM `messages` WHERE (message_type = 'contact_form') && (user_type = 'Admin') && (username = '$un') && (email = '$em')");
                                                    if (mysqli_num_rows($select_msgs) > 0) {
                                                    ?>

                                                        <button disabled class="btn btn-success mt-3 mb-0 " style="text-align:right">Replied</button>
                                                        <form action="" method="post">
                                                            <button type="submit" name="DeleteBtn" class="btn btn-info mt-3 mb-0 " style="text-align:right">Delete</button>
                                                            <input type="hidden" value="<?php echo $row['id'] ?>" name="del_hidden_id">
                                                            <input type="hidden" value="<?php echo $un ?>" name="del_hidden_username">
                                                            <input type="hidden" value="<?php echo $em ?>" name="del_hidden_email">
                                                        </form>
                                                    <?php } else { ?>

                                                        <button type="submit" name="submit" class="btn btn-info mt-3 mb-0 replyBtn" data-bs-target="#send" data-username="<?php echo $row['username'] ?>" data-email="<?php echo $row['email'] ?>" data-bs-toggle="modal" style="text-align:right">Reply</button>

                                                    <?php } ?>

                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!-- Sidebar-right-->



    </div>
    <form action="" onsubmit="return Validate_contactform()" method="post">
        <!-- End Page -->
        <div class="modal fade" id="send">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Reply with the Message</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="msg_username" class="form-control mb-2" id="msg_username">
                        <input type="hidden" name="msg_email" class="form-control mb-2" id="msg_email">
                        <input type="hidden" name="msg_type" class="form-control mb-2" value="contact_form">
                        <input type="hidden" name="msg_user_type" class="form-control mb-2" value="Admin">
                        <label for="">Message</label>
                        <textarea name="msg_messages" id="msg_messages" class="form-control" rows="3" placeholder="Enter Your Messages Here ..."></textarea>
                        <p id="msg_messages_error" style="color: red;"></p>


                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-info" data-bs-dismiss="modal" type="button">Close</button>
                        <input type="submit" value="Send Message" data-bs-dismiss="modal" name="sendBtn" class="btn ripple btn-success" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    </div>
    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
    <?php include("./scripts.php"); ?>
    <script>
        // Add event listener to all reply buttons
        document.querySelectorAll('.replyBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Retrieve user information associated with this message
                var username = this.getAttribute('data-username');
                var email = this.getAttribute('data-email');

                // Set the fetched data in the modal input fields
                document.getElementById('msg_username').value = username;
                document.getElementById('msg_email').value = email;

            });
        });


        var errorMessage = "";

        function Validate_contactform() {
            var messages = document.getElementById("msg_messages").value;

            if (messages == "") {
                errorMessage = "Please Enter Username";
                document.getElementById("msg_messages_error").innerHTML = errorMessage;
            } else {
                document.getElementById("msg_messages_error").innerHTML = "";

            }
            if (errorMessage == "") {
                return true;
            } else {
                return false;
            }

        }
    </script>

    <?php
    if (isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
        echo "<script>toastr.success('" . $_SESSION["success"] . "')</script>";
    } else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        echo "<script>toastr.error('" . $_SESSION["error"] . "')</script>";
    }
    session_destroy();
    // session_start();
    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    // echo "<script>toastr.success('" . $_SESSION["previous_url"] . "')</script>"
    ?>

</body>

</html>