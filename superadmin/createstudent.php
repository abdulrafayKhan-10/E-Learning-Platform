<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

$college_query = mysqli_query($conn, "SELECT * FROM `college`");

if (isset($_POST["create"])) {

    $student_name = filter_var($_POST['student_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $date_of_birth = filter_var($_POST['date_of_birth'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $alternative_phone_number = filter_var($_POST['alternative_phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mail_id = filter_var($_POST['mail_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $district = filter_var($_POST['district'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pincode = filter_var($_POST['pincode'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $qualification = filter_var($_POST['qualification'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stream = filter_var($_POST['stream'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $semester = filter_var($_POST['semester'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $account_type = filter_var($_POST['account_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $institution_id = (int) filter_var($_POST['institution_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $student_username = filter_var($_POST['student_username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $intership_term = filter_var($_POST['intership_term'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $created_by = "Admin";

    $upload_cv =  $_FILES['upload_cv']['name'];

    $upload_cv_tmp = $_FILES['upload_cv']['tmp_name'];

    $cv = date('Y-m-d-H-s') . $upload_cv;

    $upload_cv_path = "./assets/docs/student/cv/" . $cv;

    $upload_cv_error = $_FILES['upload_cv']['error'];

    if ($upload_cv_error !== UPLOAD_ERR_OK) {
        echo "File upload failed with error code: $upload_cv_error";
        exit();
    }

    if ($institution_id != "None") {
        $college_query = mysqli_query($conn, "SELECT * FROM `college` WHERE `id` = $institution_id");
        $fetch = mysqli_fetch_assoc($college_query);
        $institution_name = $fetch['name'];
        $institution_id = $fetch['id'];
    }

    $query = mysqli_prepare($conn, "INSERT INTO `student`(`name`, `contact_number`, `email`, `username`, `internship`, `password`, `gender`, `address`, `alternate_contact_number`, `state`, `district`, `dob`, `pin_code`, `qualification`, `branch`, `semester`, `account_type`, `college_name`, `cv`, `created_by`, `college_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $query->bind_param("sssssssssssssssssssss", $student_name, $phone_number, $mail_id, $student_username, $intership_term, $password_hash, $gender, $address, $alternative_phone_number, $state, $district, $date_of_birth, $pincode, $qualification, $stream, $semester, $account_type, $institution_name, $cv, $created_by, $institution_id);

    if ($query->execute()) {
        if (move_uploaded_file($upload_cv_tmp, $upload_cv_path)) {
            echo "File successfully moved!";
        } else {
            echo "Failed to move the file.";
        }
        $_SESSION['success'] = "Student created successfully";
        header('location: createstudent.php');
    } else {
        echo "Error creating student: " . $query->error;
        $_SESSION['error'] = "Something went wrong";
        header('location: createstudent.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Student</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <?php include("./style.php"); ?>
    <script>
    function validateFile() {
        var fileInput = document.getElementById('cv');
        var fileName = fileInput.value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx)$/i;

        if (!allowedExtensions.exec(fileName)) {
            alert('Invalid file type. Please upload a PDF or DOC file.');
            fileInput.value = '';
            return false;
        } else {
            // File type is allowed, you can optionally display the file name or perform other actions
            // For example, you can display the file name in a div with id "fileInfo"
            document.getElementById('fileInfo').innerHTML = 'Selected File: ' + fileName;
            return true;
        }
    }
    </script>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php include("./switcher.php"); ?>
    <!-- Page -->
    <div class="page">

        <div>

            <div class="main-header side-header sticky nav nav-item">

                <?php include('./partials/navbar.php'); ?>

            </div>


            <!-- main-sidebar -->
            <div class="sticky">
                <?php include('./partials/sidebar.php') ?>
            </div>
            <!-- main-sidebar -->

        </div>
        <form method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create
                                Student</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Credentials</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Student</li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /breadcrumb -->
                    <?php if (isset($_SESSION['success'])) { ?>
                    <div class="container-sm w-50 d-flex justify-content-center">
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['success']; ?>
                        </div>

                    </div>
                    <?php unset($_SESSION['success']); ?>
                    <?php session_destroy();
                    } else if (isset($_SESSION['error'])) { ?>
                    <div class="container-sm w-50 d-flex justify-content-center">
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['error']; ?>
                        </div>

                    </div>
                    <?php unset($_SESSION['error']);
                        session_destroy();
                    } ?>
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row row-xs formgroup-wrapper">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName">Student Name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control" id="exampleInputName"
                                                    name="student_name" placeholder="Enter Student Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar">Gender <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="gender"
                                                    data-bs-placeholder="Select Country" required>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputDOB">Date of Birth <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input class="form-control" id="dateMask" name="date_of_birth"
                                                    placeholder="DD/MM/YYYY" type="date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPersonalPhone">Phone Number <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" name="phone_number"
                                                    placeholder="1234567890" required max="9999999999" min="1000000000"
                                                    id="exampleInputPersonalPhone" placeholder="1234567890" required
                                                    max="9999999999" min="1000000000" placeholder="Enter Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPersonalPhone">Alternative Phone Number
                                                    <span style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" placeholder="1234567890"
                                                    max="9999999999" min="1000000000" name="alternative_phone_number"
                                                    id="exampleInputPersonalPhone"
                                                    placeholder="Enter Alternative Contact Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Mail Id <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="email" class="form-control" name="mail_id"
                                                    id="exampleInputPerEmail" placeholder="Enter Mail ID" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Address <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control " name="address"
                                                    id="exampleInputPerEmail" rows="5" placeholder="Enter address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">District <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control" name="district"
                                                    id="exampleInputPerEmail" placeholder="Enter District">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">State <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control" name="state"
                                                    id="exampleInputPerEmail" placeholder="Enter State">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">PIN code <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="number" class="form-control" name="pincode"
                                                    id="exampleInputPerEmail" placeholder="enter Pincode">
                                            </div>
                                        </div>






                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputQualification">Qualification <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="qualification"
                                                    data-bs-placeholder="select qulification" required>
                                                    <option value="10th">10th</option>
                                                    <option value="+12">+12</option>
                                                    <option value="polytechnic">Polytechnic</option>
                                                    <option value="degree">Degree</option>
                                                    <option value="btech">B.Tech</option>
                                                    <option value="pg">Post Graduation</option>
                                                    <option value="ph.d">Ph.d</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPerEmail">Branch/Stream <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control " name="stream"
                                                    id="exampleInputPerEmail" placeholder="MPC/BCOM/CSE" required>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputAadhar"> Semester <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span> </label>
                                                <select class="form-control form-select select2" name="semester"
                                                    data-bs-placeholder="Select Country" required>
                                                    <option value="1stsem">1st sem</option>
                                                    <option value="2ndSem">2nd Sem</option>
                                                    <option value="3rdSem">3rd Sem</option>
                                                    <option value="4thSem">4th Sem</option>
                                                    <option value="5thSem">5th Sem</option>
                                                    <option value="6thSem">6th Sem</option>
                                                    <option value="7thSem">7th Sem</option>
                                                    <option value="8thSem">8th Sem</option>
                                                    <option value="Not Required">Not Required</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputQualification">Account type <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="account_type"
                                                    data-bs-placeholder="select qulification" required>
                                                    <option value="individual">Individual</option>
                                                    <option value="college">College</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputQualification">Insitution Name <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="institution_name"
                                                    data-bs-placeholder="select qulification">
                                                    <option value="None">None</option>
                                                    <?php if (mysqli_num_rows($college_query) > 0) {
                                                        while ($row = mysqli_fetch_assoc($college_query)) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Student Username <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="text" class="form-control" name="student_username"
                                                    id="exampleInputUserName" placeholder="Enter Username" minlength=8
                                                    maxlength=16 required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputUserName">Internship Term <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <select class="form-control form-select select2" name="intership_term"
                                                    data-bs-placeholder="select internship term">
                                                    <option value="None">None</option>
                                                    <option value="short_term">Short-Term</option>
                                                    <option value="long_term">Long-Term</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Password <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="password" class="form-control" name="password"
                                                    id='password' placeholder="Enter Password" minlength=8 maxlength=10
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputRe-EnterPassword">Re-Enter Password <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Mandatory</span>
                                                    <span style="color:red;font-size: 90%;">*</span><span
                                                        style="color:#D3D3D3;font-size: 90%;">)</span></label>
                                                <input type="password" class="form-control" name="password"
                                                    id='retypepassword' placeholder="Re-Enter Password" minlength=8
                                                    maxlength=10 required>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputcode">Upload CV <span
                                                        style="color:#D3D3D3;font-size: 90%;">(Optional)</span></label>
                                                <input type="file" class="form-control" name="upload_cv" id="cv"
                                                    placeholder="" onchange="validateFile()">
                                                <!-- Display file info if needed -->
                                                <div id="fileInfo"></div>
                                            </div>
                                        </div>


                                        <button type="submit" name="create" value="create" onclick="return check()"
                                            class="btn btn-primary mt-3 mb-0" style="text-align:right">Generate</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- Container closed -->
            </div>

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
        <!-- Footer opened -->


    </div>
    <!-- End Page -->



    <?php include("./scripts.php"); ?>

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