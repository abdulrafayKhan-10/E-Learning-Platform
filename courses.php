<?php
include("./db_connection/connection.php");
$select_courses = mysqli_query($conn, "SELECT * FROM `course`");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <?php
    include("links.php")

    ?>
    <style>
    p {
        text-align: justify !important;
    }
    </style>
</head>

<body>
    <section>
        <?php include("./partials/navbar.php"); ?>
    </section>
    <div class="main">
        <section class="section  bg-soft"
            style="background: url('./assets/background/globe.png')no-repeat right bottom">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-sm-center">
                    <div class="col-md-6 col-lg-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="hero-slider-content">
                            <h1 class="display-2">Courses:<br> Learning Never Exhausts
                            </h1>
                            <p class="lead">The best way to start your Career</p>
                            <a href="#courses" class="btn btn-secondary mt-3">Available Courses</a>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./assets/media/city-committed-education-collage-concept.jpg" alt="modern desk">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-lg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="section-heading text-center mb-5">
                            <h2>Categories</h2>
                            <p class="lead">Avaialbe list of Categories that you can start your Learnings with
                            <p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/environment.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Information Technologies</h2>
                            <p class="mb-0">Not just basics, but every technology starts with these… C, C++ Java and
                                other latest emerging technologies are here with TriaRight, Know more…
                            </p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/non-conforming.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Non-IT</h2>
                            <p class="mb-0">Courses related to Voice, Non Voice, Transcription, Translations etc…</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/customer-service.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Management</h2>
                            <p class="mb-0">Leader doesn’t become overnight you need to be scaled so, pick your
                                certification course Today.</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/salary.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Finance</h2>
                            <p class="mb-0">US Taxation, Income Tax, Accounts executives are created with practice,
                                Learn to Practice here</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/pharmaceutical.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Pharmaceticals</h2>
                            <p class="mb-0">Medical coding is the transformation of medical diagnosis… Be a Medical
                                coder, be with TriaRight to learn at your ease.</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/online-education.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Professional Courses</h2>
                            <p class="mb-0">Would like to Upskill your profile with the Professional Courses here is the
                                Right platform for you</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>

                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 mb-md-0 text-center">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <img src="./assets/Icons/creative-brain.png" alt="icon" width="60" class="img-fluid">
                        </div>
                        <h2 class="h5 ">Creative Courses</h2>
                        <p class="mb-0">Photography, Videography, Cinematography, Fashion Designing, Interior
                        <div class="card-icon mb-4">
                            Designing and many more yet to come…</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>

                </div>
            </div>
        </section>

        <section class="m-5" id="courses">
            <div class="container text-center">
                <h1>Courses</h1>
                <p class="lead mb-5">These are the available courses</p>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <?php if (mysqli_num_rows($select_courses) > 0) { ?>
                        <div class="owl-carousel owl-theme">
                            <?php while ($fetch_courses = mysqli_fetch_assoc($select_courses)) {
                                    $title = $fetch_courses['course_name'];
                                    $description = $fetch_courses['topics_covered'];
                                    $requirements = $fetch_courses['pre_requirements'];
                                    $limited_title = substr($title, 0, 50); // Limit title to 50 characters
                                    $limited_description = substr($description, 0, 100); // Limit description to 100 characters
                                    $limited_requirements = substr($requirements, 0, 100); // Limit requirements to 100 characters
                                ?>
                            <div class="card">
                                <a href="./course_details.php?id=<?php echo $fetch_courses['id']; ?>">
                                    <img class="card-img-top"
                                        src="./superadmin/assets/img/course/<?php echo $fetch_courses['main_image']; ?>"
                                        alt="Course Image">
                                    <div class="card-body">
                                        <h4 class="card-title">Title: <br><?php echo $limited_title; ?></h4>
                                        <h5 class="card-title">Topics Covered: <br><?php echo $limited_description; ?>
                                        </h5>
                                        <h5 class="card-title">Slots: <?php echo $fetch_courses['slots']; ?></h5>
                                        <p class="card-text text-dark">Pre-Requirements:
                                            <br><?php echo $limited_requirements; ?></p>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } else {
                            echo "<h3>No Available Courses</h3>";
                        } ?>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include("./partials/footer.php");
    ?>

    <script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 100,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                400: {
                    items: 1,
                },
                800: {
                    items: 2,
                },
                1000: {
                    items: 3,
                }
            }
        });
    });
    </script>

</body>

</html>