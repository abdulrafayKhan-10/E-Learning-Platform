<?php
session_start();

include("db_connection/connection.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;

    $select_internships = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$id'");

    if ($select_internships) {
        $fetch_internships = mysqli_fetch_assoc($select_internships);
        $_SESSION["fetch_internships"] = $fetch_internships;
    } else {
        header('location: courses.php');
        exit();
    }
} else {
    header('location: courses.php');
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
                            <h4><span class="text-muted">Title:</span> <?php echo $fetch_internships['course_name']; ?>
                            </h4>
                            <h5><span class="text-muted">Stream Name:</span>
                                <?php echo $fetch_internships['stream_name']; ?></h5>
                            <h6><span class="text-muted">Course Provider/Association:</span>
                                <?php echo $fetch_internships['provider_name_company']; ?></h6>
                            <h6><span class="text-muted">Description:</span>
                                <?php echo $fetch_internships['course_description']; ?></h6>
                            <h6><span class="text-muted">Offline Address:</span>
                                <?php echo $fetch_internships['offline_address']; ?></h6>
                            <h6><span class="text-muted">Course Duration (Days):</span>
                                <?php echo $fetch_internships['duration_days']; ?> days</h6>
                            <h6><span class="text-muted">Last Day To Apply:</span>
                                <?php echo $fetch_internships['last_date_to_apply']; ?></h6>
                            <h6><span class="text-muted">Hours Per Day:</span>
                                <?php echo $fetch_internships['hours_per_day']; ?>hr</h6>
                            <h6><span class="text-muted">Certification:</span>
                                <?php echo $fetch_internships['certification']; ?></h6>
                            <h6><span class="text-muted">Training Type:</span>
                                <?php

                                if ($fetch_internships['training_type'] == "VirtualLiveSession") {
                                    echo "Virtual Live Session";
                                } elseif ($fetch_internships['training_type'] == "Offline") {
                                    echo "Offline";
                                } elseif ($fetch_internships['training_type'] == "VirtualRecordedSessions") {
                                    echo "Virtual Recorded Sessions";
                                } else {
                                    echo "Hybrid";
                                }

                                ?></h6>
                            <h6><span class="text-muted">Slots:</span>
                                <?php echo $fetch_internships['slots']; ?></h6>
                            <h6><span class="text-muted">Topics Covered:</span>
                                <?php echo $fetch_internships['topics_covered']; ?></h6>
                            <h6><span class="text-muted">Benefits Of Course:</span>
                                <?php echo $fetch_internships['benefits_of_course']; ?></h6>
                            <h6><span class="text-muted">Course - Pre-Requirements:</span>
                                <?php echo $fetch_internships['pre_requirements']; ?></h6>
                            <h6><span class="text-muted">Aditional Information:</span>
                                <?php echo $fetch_internships['additional_info']; ?></h6>
                            <h6><span class="text-muted">Course Type:</span>
                                <?php echo $fetch_internships['course_type'] ?? "No Stifund"; ?></h6>
                            <h6><span class="text-muted">Original Fee:</span>
                                <?php echo $fetch_internships['original_cost']; ?></h6>
                            <h6><span class="text-muted">Current Discount:</span>
                                <?php echo $fetch_internships['discount_percentage']; ?>%</h6>
                            <h6><span class="text-muted">Final Course Fee:</span>
                                <?php echo $fetch_internships['final_cost']; ?></h6>


                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./superadmin/assets/img/course/<?php echo $fetch_internships['main_image']; ?>"
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