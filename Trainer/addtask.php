<?php
include('../db_connection/connection.php');
if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}
if (isset($_POST['submitBtn'])) {
    $task_name = $_POST['task_name'];
    $allocated_students_type = $_POST['allocated_students_type'];
    $task_description = $_POST['task_description'];
    $task_end_date = $_POST['task_end_date'];
    $shared_documents_name = $_FILES['shared_documents']['name'];
    $shared_documents_tmp = $_FILES['shared_documents']['tmp_name'];
    $batch_id = $_POST['batch_id'];

    $select_batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE id = '$batch_id'");
    $fetch_batch = mysqli_fetch_assoc($select_batch);
    if ($fetch_batch['id'] == $batch_id) {
        $batch_name = $fetch_batch['batch_name'];
        $insert_query = mysqli_prepare($conn, "INSERT INTO `batches_tasks`(`task_name`, `allocated_students_type`, `task_description`, `task_end_date`, `shared_documents`, `batch_id`, `batch_name`) VALUES (?,?,?,?,?,?,?)");
        $insert_query->bind_param('sssssss', $task_name, $allocated_students_type, $task_description, $task_end_date, $shared_documents_name, $batch_id, $batch_name);

        if ($insert_query->execute()) {
            move_uploaded_file($shared_documents_tmp, "./assets/docs/supportive_docs/" . $shared_documents_name);
            $_SESSION['success'] = "Task Created Successfully.";
            header("location:addtask.php");
            exit();
        } else {
            $_SESSION['error'] = "Unexpected Error.";
            header("location:addtask.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Something went wrong";
        header("location:addtask.php");
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

    <!-- Title -->
    <title>Add Task</title>


    <?php
    include('./style.php');
    ?>

</head>

<body class="ltr main-body app sidebar-mini">

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
        <form method="POST" enctype="multipart/form-data">


            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700"> Create Task</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Batches Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Task</li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <select name="batch_id" required class="form-control form-select select2"
                            data-bs-placeholder="Select Batch">
                            <?php
                            $trainer_id = $_COOKIE['trainer_id'];
                            $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE trainer_id = '$trainer_id'");
                            if (mysqli_num_rows($batch) > 0) {
                                while ($row = mysqli_fetch_assoc($batch)) {
                            ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['batch_name'] ?></option>
                            <?php
                                }
                            }

                            ?>
                        </select>
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
                                                    <label for="exampleInputDOB">Name of the Task</label>

                                                    <input class="form-control" id="dateMask" placeholder="Name"
                                                        type="text" name="task_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dropdown">allocated Students Type</label>
                                                    <select id="dropdown" onchange="showOptions1()"
                                                        class="form-control form-select select2"
                                                        data-bs-placeholder="Select Batch"
                                                        name="allocated_students_type" required>
                                                        <option value="All">All</option>
                                                        <option value="Individual">Indiviudal</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Task Description</label>
                                                    <input type="text" class="form-control" id="exampleInputcode"
                                                        placeholder="Task Description" name="task_description" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Task End Date</label>
                                                    <input class="form-control" id="dateMask" placeholder="" type="date"
                                                        name="task_end_date" required>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Shared Documents</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        placeholder="" name="shared_documents">
                                                </div>
                                            </div>





                                        </div>
                                        <button type="submit" name="submitBtn" class="btn btn-info mt-3 mb-0"
                                            style="text-align:right">Add Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </form>
    </div>

    <?php include('./script.php') ?>

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