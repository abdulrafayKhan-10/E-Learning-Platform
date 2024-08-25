<?php
session_start();

include("db_connection/connection.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;

    $select_internships = mysqli_query($conn, "SELECT * FROM `internship` WHERE `id` = '$id'");

    if ($select_internships) {
        $fetch_internships = mysqli_fetch_assoc($select_internships);
        $_SESSION["fetch_internships"] = $fetch_internships;
    } else {
        header('location: internships.php');
        exit();
    }
} else {
    header('location: internships.php');
    exit();
}
$fetch_internships = $_SESSION["fetch_internships"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internships</title>
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
                            <h4><span class="text-muted">Title:</span> <?php echo $fetch_internships['internship']; ?>
                            </h4>
                            <h5><span class="text-muted">Company:</span>
                                <?php echo $fetch_internships['company_name']; ?></h5>
                            <h6><span class="text-muted">Industry:</span>
                                <?php echo $fetch_internships['industry']; ?></h6>
                            <h6><span class="text-muted">Internship Duration:</span>
                                <?php echo $fetch_internships['duration_days']; ?> days</h6>
                            <h6><span class="text-muted">Eligibity Criteria:</span>
                                <?php echo $fetch_internships['eligibility']; ?></h6>
                            <h6><span class="text-muted">Job Type:</span>
                                <?php echo $fetch_internships['internship_category']; ?></h6>
                            <h6><span class="text-muted">Preferred For (Gender):</span>
                                <?php echo $fetch_internships['gender']; ?></h6>
                            <h6><span class="text-muted">Vacancies:</span>
                                <?php echo $fetch_internships['vacancies']; ?></h6>
                            <h6><span class="text-muted">Last Date To Apply:</span>
                                <?php echo $fetch_internships['last_date_to_apply']; ?></h6>
                            <h6><span class="text-muted">Certification Criteria:</span>
                                <?php

                                if ($fetch_internships['certification'] == "yes") {
                                    echo "Required";
                                } else {
                                    echo "Not Required";
                                }

                                ?></h6>
                            <h6><span class="text-muted">Full Description:</span>
                                <?php echo $fetch_internships['full-description']; ?></h6>
                            <h6><span class="text-muted">Pre-Requirements:</span>
                                <?php echo $fetch_internships['pre-requirements']; ?></h6>
                            <h6><span class="text-muted">Additional Information:</span>
                                <?php echo $fetch_internships['additional_info']; ?></h6>
                            <h6><span class="text-muted">Internship Type:</span>
                                <?php echo $fetch_internships['internship_type']; ?></h6>
                            <h6><span class="text-muted">Expected Salary:</span>
                                <?php echo $fetch_internships['salary']; ?></h6>
                            <h6><span class="text-muted">Stifend:</span>
                                <?php echo $fetch_internships['stifund'] ?? "No Stifund"; ?></h6>
                            <h6><span class="text-muted">Food Allowances:</span>
                                <?php echo $fetch_internships['food_allowances']; ?></h6>
                            <h6><span class="text-muted">Transport Allowances:</span>
                                <?php echo $fetch_internships['transport_allowances']; ?></h6>


                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./superadmin/assets/img/internship/<?php echo $fetch_internships['main_image']; ?>"
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