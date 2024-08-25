<?php
include("db_connection/connection.php");
$select_internships = mysqli_query($conn, "SELECT * FROM `internship`");
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

        <section class="section bg-soft" style="background: url('./assets/background/globe.png')no-repeat right bottom">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-sm-center">
                    <div class="col-md-6 col-lg-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="hero-slider-content">
                            <h1 class="display-2">Internships :<br> The Right place to start your Career
                            </h1>
                            <p class="lead">Your Successful Career is now sorted with our Internship Programs</p>
                            <a href="#internships" class="btn btn-secondary mt-3">Available Internships</a>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./assets/media/business-people-board-room-meeting.jpg" alt="modern desk">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--hero section start-->
        <section class="section section-lg  ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="section-heading text-center mb-5">
                            <h2>Categories</h2>
                            <p class="lead">We Provide Jobs in the following Industries
                            <p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/maintenance.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Automobile Manufacturing</h2>
                            <p class="mb-0">If its your dream to be an Mechanical Engineer try our path to reach your
                                destination</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/wrench-tool.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Constructions</h2>
                            <p class="mb-0">Our way of building techniques are with the top notch construction companies
                            </p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/pharmaceutical.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Pharmaceutical</h2>
                            <p class="mb-0">Pharmacy now is following a high technology in their own ways - Try
                                TriaRight</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/environment.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Information Technology</h2>
                            <p class="mb-0">We provide you the latest IT job postings from our clients, pick what’s your
                                Right Job</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/communication.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Tele Communications</h2>
                            <p class="mb-0">Here you will have the latest updates Non IT job postings by our clients.
                                Voice, Non Voice, Back Office, Admins, MIS etc..</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/textile.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Textiles</h2>
                            <p class="mb-0">Fashion Designers this is your place to get be creative - Find your Right
                                Company here</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/budget.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Finance</h2>
                            <p class="mb-0">Finance and funds makes it all with the company. If you are looking for the
                                same Apply today</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/travel.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Transportation/Tourism</h2>
                            <p class="mb-0">Are you a Travel freak and wanted to earn being in your passion this is the
                                Right place, pick your Job</p>
                        </div>
                        <!-- End of Icon box -->
                    </div>
                    <div class="col-md-6 col-lg-4 mb-lg-0 mb-md-0">
                        <!-- Icon box -->
                        <div class="icon-box text-center">
                            <div class="card-icon mb-4">
                                <img src="./assets/Icons/expand.png" alt="icon" width="60" class="img-fluid">
                            </div>
                            <h2 class="h5">Others</h2>
                            <p class="mb-0">There are many more Industries whom we provide Jobs from </p>
                        </div>
                        <!-- End of Icon box -->
                    </div>

                </div>
            </div>
        </section>
        <!--features section end-->



        <section class="m-5" id="internships">
            <div class="container text-center">
                <h1>Internships</h1>
                <p class="lead mb-5">These are the available internships
                <p>
                <div class="row d-flex justify-content-center">
                    <div class="col-12"><?php if (mysqli_num_rows($select_internships) > 0) { ?>
                        <div class="owl-carousel owl-theme">
                            <?php while ($fetch_courses = mysqli_fetch_assoc($select_internships)) {
                                                $internship_name_words = str_word_count($fetch_courses['internship'], 2);
                                                $limit = 3;

                                                // Internship Name
                                                if (count($internship_name_words) > $limit) {
                                                    $limited_internship_name = implode(' ', array_slice($internship_name_words, 0, $limit)) . '...';
                                                } else {
                                                    $limited_internship_name = implode(' ', $internship_name_words);
                                                }
                                ?>
                            <a href="./internship_details.php?id=<?php echo $fetch_courses['id']; ?>" target="_blank">
                                <div class="card" style="width: 20rem; border: 2px solid black;">
                                    <img class="card-img-top"
                                        src="./superadmin/assets/img/internship/<?php echo $fetch_courses['main_image']; ?>"
                                        alt="Course Image">
                                    <div class="card-body">
                                        <h4 class="card-title"><span class="text-muted">Internship Name:</span> <br>
                                            <?php echo $limited_internship_name; ?>
                                        </h4>
                                        <h5 class="card-title"><span class="text-muted">Vacancies:</span><br>
                                            <?php echo $fetch_courses['vacancies']; ?></h5>
                                        <h5 class="card-title"><span class="text-muted">Last Day To Apply:</span><br>
                                            <?php echo $fetch_courses['last_date_to_apply']; ?>
                                        </h5>
                                        <p class="card-text text-danger"><span class="text-muted">Salary:</span>
                                            <b><?php echo $fetch_courses['salary']; ?>₹
                                            </b>
                                        <p>
                                    </div>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                        <?php } else {
                                            echo "<h3>No Available Internships</h3>";
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
            margin: 20,
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