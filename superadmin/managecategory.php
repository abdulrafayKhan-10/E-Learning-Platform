<?php
session_start();

include('../db_connection/connection.php');

if (!isset($_COOKIE['superadmin_username']) && !isset($_COOKIE['superadmin_password'])) {
    header('location: ../super-admin_login.php');
    exit();
}

if (isset($_POST["update"])) {
    $category_id = $_POST["id"];
    $category_name = $_POST["category_name"];
    $sql = "UPDATE `course_category` SET `category_name` = '$category_name' WHERE `id` = $category_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['success'] = "Category updated successfully";
        header('location: managecategory.php');
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong";
        header('location: managecategory.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Placement List</title>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <?php include("./style.php"); ?>
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
                        <span class="main-content-title mg-b-0 mg-b-lg-1" style="color:#ff6700">Placement List </span>
                    </div>

                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item tx-14"><a href="javascript:void(0);">Placement</a></li>
                            <li class="breadcrumb-item ">View</li>
                            <li class="breadcrumb-item ">List</li>
                        </ol>
                    </div>

                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row row-sm">
                        <div class="form-group col-md-3">
                            <b> <label>Added Date</label> </b>

                            <select name="date" class="form-control form-select" data-bs-placeholder="Select Filter">

                                <option value="" selected="selected">ALL</option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT DISTINCT added_date FROM `course_category`");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        echo '<option value="' . $row['added_date'] . '">' . $row['added_date'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="height:40px;width:100px;margin-top:35px">Search</button>

                    </div>
                </form>
                <br>
                <br>
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">

                                <div class="table-responsive export-table">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">S.no</th>
                                                <th class="border-bottom-0">Date Of Adding</th>
                                                <th class="border-bottom-0">Category Name</th>
                                                <th class="border-bottom-0">Category Id</th>
                                                <th class="border-bottom-0">Edit</th>
                                                <th class="border-bottom-0">Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $query = "SELECT * FROM `course_category` WHERE 1=1";

                                            if (isset($_POST['date']) && !empty($_POST['date'])) {
                                                $query .= " AND added_date = '" . $_POST['date'] . "'";
                                            }

                                            $run_query = mysqli_query($conn, $query);

                                            if (mysqli_num_rows($run_query) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($run_query)) {
                                                    echo "<tr><td>" . $i++ . "</td><td>" . $row['added_date'] . "</td><td>" . $row['category_name'] . "</td> <td>" . $row['id'] . "</td> <td><button class='btn btn-info' type='button' data-bs-toggle='modal' data-bs-target='#edit_{$row['id']}'>Edit</button></td>";
                                            ?>

                                            <div class="modal fade" id="edit_<?php echo $row['id']; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal
                                                                title</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                            method="post">

                                                            <div class="modal-body">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $row['id']; ?>">
                                                                <div class="form-group">
                                                                    <label class="form-label">Category Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['category_name'] ?>"
                                                                        placeholder="Enter Category Name"
                                                                        name="category_name" required>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" name="update"
                                                                        class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php


                                                    echo "<td><a href='./delete.php?id=" . $row['id'] . "&type=course_category' class='btn btn-danger'>Delete</a></td>";

                                                    echo "</tr>";
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
    <!-- Container closed -->

    <?php include("./scripts.php"); ?>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#file-datatable').DataTable();
    });
    </script>

    <?php
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        echo "<script>toastr.success('$_SESSION[success]')</script>";
    } else if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo "<script>toastr.error('$_SESSION[error]')</script>";
    }
    session_destroy();
    ?>

</body>

</html>