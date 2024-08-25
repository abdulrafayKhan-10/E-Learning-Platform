<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['trainer_username']) && !isset($_COOKIE['trainer_password'])) {
    header('location: ../trainer_login.php');
    exit();
}

if (isset($_GET['task_id'])) {
    $id = filter_var($_GET['task_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $query = "SELECT * FROM `batches_tasks` WHERE `id` = '$id'";
    $run = mysqli_query($conn, $query);
    if (!$run) {
        if (isset($_SESSION['previous_url'])) {
            header('Location: ' . $_SESSION['previous_url']);
            exit();
        } else {
            // Fallback redirection if previous_url is not set
            header('Location: ./dashboard.php');
            exit();
        }
    }
    $tasks = mysqli_fetch_assoc($run);

    if (!$id) {
        echo "Tasks not found!";
        exit();
    }

    if (isset($_POST['UpdateBtn'])) {
        // Updated code here is similar to the createcourse.php file

        // Retrieve updated values
        $task_name = $_POST['task_name'];
        $allocated_students_type = $_POST['allocated_students_type'];
        $task_description = $_POST['task_description'];
        $task_end_date = $_POST['task_end_date'];
        $shared_documents_name = $_FILES['shared_documents']['name'];
        $shared_documents_tmp = $_FILES['shared_documents']['tmp_name'];
        $batch_id = $_POST['batch_id'];
        if (empty($shared_documents_name)) {
            $shared_documents_name = $tasks["shared_documents"];
        }
        $select_batch = mysqli_query($conn,"SELECT * FROM `batch` WHERE id = '$batch_id'");
        $fetch_batch = mysqli_fetch_assoc($select_batch);
        if($fetch_batch['id'] == $batch_id){
        $batch_name = $fetch_batch['batch_name'];
        // Update query
        $update_query = "UPDATE `batches_tasks` SET `task_name`=?,`allocated_students_type`=?,`task_description`=?,`task_end_date`=?,`shared_documents`=?,`batch_id`=?,`batch_name`=? WHERE id = '$id'";
        $update_stmt = mysqli_prepare($conn, $update_query);
        $update_stmt->bind_param(
            "sssssss",$task_name,$allocated_students_type,$task_description,$task_end_date,$shared_documents_name,$batch_id,$batch_name  
        );

        if (mysqli_stmt_execute($update_stmt)) {    
            session_destroy();
            move_uploaded_file($shared_documents_tmp, "./assets/docs/supportive_docs/".$shared_documents_name);
            header("location: managetask.php");
            exit();
        } else {
            echo mysqli_error($conn);
        }

        mysqli_stmt_close($update_stmt);
    }
}
} elseif (!isset($_GET["task_id"]) || empty($_GET["task_id"])) {
    echo "<script>alert('Error')</script>";
    if (isset($_SESSION['previous_url'])) {
        header('Location: ' . $_SESSION['previous_url']);
        exit();
    } else {
        // Fallback redirection if previous_url is not set
        header('Location: ./dashboard.php');
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
    <title>Update Tasks</title>

    <?php include("./style.php"); ?>
</head>

<body class="ltr main-body app sidebar-mini">

    <!-- Switcher -->
    <?php include("./switcher.php"); ?>
    <!-- End Switcher -->

    <!-- Page -->
    <div class="page">

        <div class="main-header side-header sticky nav nav-item">

            <?php include('./partials/navbar.php'); ?>

        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        <div class="sticky">
            <?php include('./partials/sidebar.php') ?>
        </div>
        <!-- main-sidebar -->


        <form method="POST" enctype="multipart/form-data">
            <!-- main-content -->
            <!-- main-content -->
            <div class="main-content app-content">

                <!-- container -->
                <div class="main-container container-fluid">


                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Update Task</span>
                        </div>
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Batches Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Task</li>
                                <li class="breadcrumb-item active" aria-current="page">Update</li>
                            </ol>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <select name="batch_id" required class="form-control form-select select2"
                            data-bs-placeholder="Select Batch">
                            <?php 
            if(isset($_GET['task_id'])){
                $id = $_GET['task_id'];
                $sql = mysqli_query($conn,"SELECT * FROM `batches_tasks` WHERE id = '$id'");
                $fetch_sql = mysqli_fetch_assoc($sql);
                $selected_batch_id = $fetch_sql['batch_id'];
          
        
      $trainer_id = $_COOKIE['trainer_id'];
      $batch = mysqli_query($conn, "SELECT * FROM `batch` WHERE trainer_id = '$trainer_id'");
      if (mysqli_num_rows($batch) > 0) {
          while ($row = mysqli_fetch_assoc($batch)) {         
?>
                            <option value="<?php echo $row['id'] ?>"
                                <?php if(isset($selected_batch_id) && $selected_batch_id == $row['id']) echo "selected"; ?>>
                                <?php echo $row['batch_name'] ?></option>
                            <?php
             
          }
      } 
    } ?>
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
                                                        type="text" value="<?php echo $tasks['task_name']?>"
                                                        name="task_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dropdown">allocated Students Type</label>
                                                    <select id="dropdown" onchange="showOptions1()"
                                                        class="form-control form-select select2"
                                                        data-bs-placeholder="Select Batch"
                                                        name="allocated_students_type" required>
                                                        <?php if($tasks['allocated_students_type'] == "All") {?>
                                                        <option value="All" selected>All</option>
                                                        <option value="Individual">Individual</option>
                                                        <?php } else {?>
                                                        <option value="All">All</option>
                                                        <option value="Individual" selected>Individual</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Task Description</label>
                                                    <input type="text" class="form-control" id="exampleInputcode"
                                                        placeholder="Task Description"
                                                        value="<?php echo $tasks['task_description']?>"
                                                        name="task_description" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUserName">Task End Date</label>
                                                    <input class="form-control" id="dateMask" placeholder="" type="date"
                                                        name="task_end_date"
                                                        value="<?php echo $tasks['task_end_date']?>" required>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode"> Shared Document</label>
                                                    <input type="file" class="form-control" id="exampleInputcode"
                                                        placeholder="" name="shared_documents">


                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputcode">Current Shared Document</label>
                                                    <br>
                                                    <a href="./assets/docs/supportive_docs/<?php echo $tasks['shared_documents']?>"
                                                        target="_blank" download=""
                                                        class="btn btn-primary mx-2">Download</a>


                                                </div>
                                            </div>





                                        </div>
                                        <button type="submit" name="UpdateBtn" class="btn btn-info mt-3 mb-0"
                                            style="text-align:right">Update Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- Container closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    </form>
    </div>


    <!-- JS -->
    <?php include('./script.php'); ?>


</body>

</html>