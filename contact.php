<?php
include("./db_connection/connection.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("links.php"); ?>
    <style>
    #livechat_div {
        transition: 0.3s ease-in-out;
    }

    #livechat_div:hover {
        transform: scale(1.1);
    }
    </style>
</head>

<body>

    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>
    <?php
    if (isset($_SESSION['msg']) && $_SESSION['msg'] == true) {
        echo "<script>toastr.success('Message Sent Successfully!');</script>";
        session_destroy();
    } ?>

    <div class="main">
        <!--page header section start-->
        <section>
            <div class="section-lg1 bg-gradient-primary text-white ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-7">
                            <div class="page-header-content text-center pt-2">
                                <h1>Contact Us</h1>
                                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                                    <ol class="breadcrumb breadcrumb-transparent breadcrumb-text-light">
                                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                                        <li class="bi bi-arrow-right-short active" aria-current="page">Contact Us</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--page header section end-->

        <section class="mt-4">
            <div class="container">
                <form method="post" onsubmit="return validatecontactform()" action="./contact_backend.php">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" id="email">
                        <p id="email_msgerror" style="color:red;"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Enter your username" name="username"
                            id="username">
                        <p id="username_msgerror" style="color:red;"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea type="text" class="form-control" id="message_box" rows="4" col="50" name="message"
                            placeholder="Enter your Message"></textarea>
                        <p id="message_msgerror" style="color:red;"></p>
                    </div>
                    <button type="submit" name="sendBtn" class="btn btn-dark">Send Message</button>
                </form>
            </div>
        </section>

        <section class="section section-lg pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="rounded-custom text-center shadow-sm">
                            <div class="card-body py-4">
                                <div class="icon icon-md text-secondary">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="mt-3">
                                    <h5 class="h6">Call Us</h5>
                                    <p class="text-muted mb-0">+92 3362100225</p>
                                    <p class="text-muted mb-0">+92 03220275616</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="rounded-custom text-center shadow-sm">
                            <div class="card-body py-4">
                                <div class="icon icon-md text-secondary">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="mt-3">
                                    <h5 class="h6">Visit Us</h5>
                                    <p class="text-muted mb-0">Demo, Address - 12-3/45 AB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="rounded-custom text-center shadow-sm">
                            <div class="card-body py-4">
                                <div class="icon icon-md text-secondary">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="mt-3">
                                    <h5 class="h6">Mail Us</h5>
                                    <p class="text-muted mb-0">info@worldoftech.company</p>
                                    <p class="text-muted mb-0">info@mesum.online</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-4 mb-lg-0" id="livechat_div">
                        <?php if (isset($_COOKIE['lc_username']) && isset($_COOKIE['lc_email'])) { ?>
                        <a href="./partials/chatsystem/chat.php"
                            style="outline: none; border: none;background-color:transparent;">
                            <div class="rounded-custom text-center shadow-sm">
                                <div class="card-body py-4">
                                    <div class="icon icon-md text-secondary">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h5 class="h6">Live Chat</h5>
                                        <p class="text-muted mb-0">Support Available 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } else { ?>
                        <button data-toggle="modal" data-target="#exampleModal"
                            style="outline: none; border: none;background-color:transparent;">
                            <div class="rounded-custom text-center shadow-sm">
                                <div class="card-body py-4">
                                    <div class="icon icon-md text-secondary">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h5 class="h6">Live Chat</h5>
                                        <p class="text-muted mb-0">Support Available 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Modal -->
    <form onsubmit="return validate_lcmodel_form()" method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="">Username</label>
                        <input type="text" class="form-control mb-2" name="lc_username" id="lc_username">
                        <p id="lc_error_username" style="color: red;"></p>
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="lc_email" id="lc_email">
                        <p id="lc_error_email" style="color: red;"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="lc_modalBtn" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php include("./partials/footer.php"); ?>
    <script>
    var errorMessage = "";

    function validatecontactform() {
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var message_box = document.getElementById("message_box").value;
        if (username == "") {
            errorMessage = "Please Enter Username"
            document.getElementById("username_msgerror").innerHTML = errorMessage;
        } else {
            document.getElementById("username_msgerror").innerHTML = "";
        }
        if (email == "") {
            errorMessage = "Please Enter Email"
            document.getElementById("email_msgerror").innerHTML = errorMessage;
        } else {
            document.getElementById("email_msgerror").innerHTML = "";
        }
        if (message_box == "") {
            errorMessage = "Please Enter Message";
            document.getElementById("message_msgerror").innerHTML = errorMessage;
        } else {
            document.getElementById("message_msgerror").innerHTML = "";
        }

        if (errorMessage != "") {
            return false;
        } else {
            return true;
        }
    }
    var errorMessage2 = "";

    function validate_lcmodel_form() {
        var username = document.getElementById("lc_username").value;
        var email = document.getElementById("lc_email").value;

        if (username == "") {
            errorMessage2 = "Please Enter Username";
            document.getElementById("lc_error_username").innerHTML = errorMessage2;
        } else {
            document.getElementById("lc_error_username").innerHTML = "";
        }
        if (email == "") {
            errorMessage2 = "Please Enter Email";
            document.getElementById("lc_error_email").innerHTML = errorMessage2;
        } else {
            document.getElementById("lc_error_email").innerHTML = "";
        }
        if (errorMessage2 == "") {
            return true;
        } else {
            return false;
        }
    }
    </script>
</body>

</html>