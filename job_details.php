<?php
session_start();

include("db_connection/connection.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;

    $select_jobs = mysqli_query($conn, "SELECT * FROM `placement` WHERE `id` = '$id'");

    if ($select_jobs) {
        $fetch_jobs = mysqli_fetch_assoc($select_jobs);
        $_SESSION["fetch_jobs"] = $fetch_jobs;
    } else {
        header('location: jobs.php');
        exit();
    }
} else {
    header('location: jobs.php');
    exit();
}
$fetch_jobs = $_SESSION["fetch_jobs"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job - <?php echo $fetch_jobs['job_role']; ?></title>
    <?php
    include("links.php")

    ?>
</head>

<body>
    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>

    <div class="main">

        <section class="section bg-soft" style="background: url('./assets/background/globe.png')no-repeat right bottom">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-sm-center">
                    <div class="col-md-6 col-lg-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="hero-slider-content">
                            <h4><span class="text-muted">Title:</span> <?php echo $fetch_jobs['job_role']; ?>
                            </h4>
                            <h5><span class="text-muted">Company:</span>
                                <?php echo $fetch_jobs['company_name']; ?></h5>
                            <h6><span class="text-muted">Industry:</span>
                                <?php echo $fetch_jobs['industry']; ?></h6>
                            <h6><span class="text-muted">Candidate Experience:</span>
                                <?php if ($fetch_jobs['experience'] == "Fresher") {
                                    echo "Fresher";
                                } elseif ($fetch_jobs['experience'] == "Experience") {
                                    echo "Experienced";
                                } elseif ($fetch_jobs['experience'] == "Both") {
                                    echo "Experienced & Fresher";
                                } else {
                                    echo "Not Mentioned";
                                } ?></h6>
                            <h6><span class="text-muted">Experience Required:</span>
                                <?php echo $fetch_jobs['years_open_experience']; ?> years</h6>
                            <h6><span class="text-muted">Eligibity Criteria:</span>
                                <?php echo $fetch_jobs['eligibility']; ?></h6>
                            <h6><span class="text-muted">Job Role:</span>
                                <?php echo $fetch_jobs['job_role']; ?></h6>
                            <h6><span class="text-muted">Preferred For (Gender):</span>
                                <?php echo $fetch_jobs['gender']; ?></h6>
                            <h6><span class="text-muted">Vacancies:</span>
                                <?php echo $fetch_jobs['vacancies']; ?></h6>
                            <h6><span class="text-muted">Location:</span>
                                <?php echo $fetch_jobs['location']; ?></h6>
                            <h6><span class="text-muted">Last Date To Apply:</span>
                                <?php echo $fetch_jobs['last_date_to_apply']; ?></h6>
                            <h6><span class="text-muted">Full Description:</span>
                                <?php echo $fetch_jobs['full_description']; ?></h6>
                            <h6><span class="text-muted">Additional Details:</span>
                                <?php echo $fetch_jobs['additional_info']; ?></h6>
                            <h6><span class="text-muted">Requirements:</span>
                                <?php echo $fetch_jobs['requirements']; ?></h6>
                            <h6><span class="text-muted">Work Mode:</span>
                                <?php

                                if ($fetch_jobs['work_mode'] == "WorkFromoffice") {
                                    echo "Work From Office";
                                } elseif ($fetch_jobs['work_mode'] == "WorkfromHome") {
                                    echo "Work From Home";
                                } elseif ($fetch_jobs['work_mode'] == "Hybrid") {
                                    echo "Hybrid";
                                } else {
                                    echo "Not Mentioned";
                                }

                                ?></h6>
                            <h6><span class="text-muted">Job Type:</span>
                                <?php echo $fetch_jobs['job_type']; ?></h6>
                            <h6><span class="text-muted">Expected Salary:</span>
                                <?php echo $fetch_jobs['salary']; ?></h6>
                            <h6><span class="text-muted">ESI:</span>
                                <?php echo $fetch_jobs['esi'] ?? "No Stifund"; ?></h6>
                            <h6><span class="text-muted">Food Allowances:</span>
                                <?php echo $fetch_jobs['food_allowances']; ?></h6>
                            <h6><span class="text-muted">Transport Allowances:</span>
                                <?php echo $fetch_jobs['transport_allowances']; ?></h6>


                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./superadmin/assets/img/placement/<?php echo $fetch_jobs['main_image']; ?>"
                                alt="modern desk">
                            <?php session_destroy(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include("./partials/footer.php");

    ?>

</body>

</html>