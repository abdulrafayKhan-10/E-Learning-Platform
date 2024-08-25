<?php
include('./db_connection/connection.php');
$select_jobs = mysqli_query($conn, "SELECT * FROM `placement`");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>

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
            style="background: url('https://triaright.com/assets/img/globe.png')no-repeat right bottom">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between justify-content-sm-center">
                    <div class="col-md-6 col-lg-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="hero-slider-content">
                            <h1 class="display-2">Jobs:<br> A Right path for your Career
                            </h1>
                            <p class="lead">Yourself required no at thoughts delicate landlord it be. Branched dashwood
                                do is whatever it.</p>
                            <a href="#jobs" class="btn btn-secondary mt-3">Available
                                jobs</a>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div>

                            <img class="fancy-radius img-fluid"
                                src="./assets/media/digital-cloud-data-storage-digital-concept-cloudscape-digital-online-service-global-network-database-backup-computer-infrastructure-technology-solution.jpg"
                                alt="modern desk">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--features section start-->
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
                                <img src="https://img.icons8.com/external-wanicon-flat-wanicon/64/external-construction-construction-wanicon-flat-wanicon.png"
                                    alt="icon" width="60" class="img-fluid">
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
                                <img src="https://img.icons8.com/external-flaticons-flat-flat-icons/64/external-pharmaceutical-bioengineering-flaticons-flat-flat-icons.png"
                                    alt="icon" width="60" class="img-fluid">
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
                                <img src="https://triaright.com/assets/img/icon/icon-3.svg" alt="icon" width="60"
                                    class="img-fluid">
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
                                <img src="https://img.icons8.com/nolan/64/circuit.png" alt="icon" width="60"
                                    class="img-fluid">
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
                                <img src="https://img.icons8.com/nolan/64/bbm-messenger.png" alt="icon" width="60"
                                    class="img-fluid">
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
                                <img src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-fashion-designer-modelling-agency-flaticons-lineal-color-flat-icons-6.png"
                                    alt="icon" width="60" class="img-fluid">
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
                                <img src="https://img.icons8.com/3d-fluency/94/money-bag.png" alt="icon" width="60"
                                    class="img-fluid">
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
                                <img src="https://img.icons8.com/fluency/48/around-the-globe.png" alt="icon" width="60"
                                    class="img-fluid">
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
                                <img src="https://img.icons8.com/external-bearicons-gradient-bearicons/64/external-ellipsis-essential-collection-bearicons-gradient-bearicons.png"
                                    alt="icon" width="60" class="img-fluid">
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

        <!--Process Steps section start-->

        <section id="jobs">
            <div class="container">
                <h2 class="text-center pt-5">Available Jobs</h2>
                <hr style="background-color:grey">
            </div>
            <main class="p-4 mb-5 mt-3">
                <div class="container">
                    <?php if (mysqli_num_rows($select_jobs) > 0) { ?>
                    <div class="owl-carousel owl-theme">
                        <?php while ($fetch_jobs = mysqli_fetch_assoc($select_jobs)) {
                                $title = $fetch_jobs['job_role'];
                                $requirements = $fetch_jobs['requirements'];
                                $company = $fetch_jobs['company_name'];
                                $title_words = str_word_count($title, 2);
                                $company_words = str_word_count($company, 2);
                                $requirements_words = str_word_count($requirements, 2);
                                $limit = 3;

                                if (count($requirements_words) > $limit) {
                                    $limited_requirements = implode(' ', array_slice($requirements_words, 0, $limit)) . '...';
                                } else {
                                    $limited_requirements = $requirements;
                                }

                                if (count($title_words) > $limit) {
                                    $limited_title = implode(' ', array_slice($title_words, 0, $limit)) . '...';
                                } else {
                                    $limited_title = $title;
                                }

                                if (count($company_words) > $limit) {
                                    $limited_company = implode(' ', array_slice($company_words, 0, $limit)) . '...';
                                } else {
                                    $limited_company = $company;
                                }
                            ?>
                        <div class="card" style="width: 20rem; border: 2px solid black;">
                            <a href="job_details.php?id=<?php echo $fetch_jobs['id']; ?>">
                                <img class="card-img-top"
                                    src="./superadmin/assets/img/placement/<?php echo $fetch_jobs['main_image']; ?>"
                                    alt="Job_main_image">
                                <div class="card-body">
                                    <h4 class="card-title">Job Role: <br><?php echo $limited_title; ?></h4>
                                    <h5 class="card-title">Company: <br><?php echo $limited_company; ?></h5>
                                    <h5 class="card-title">Need <?php echo $fetch_jobs['years_open_experience']; ?>
                                        Years of Experience</h5>
                                    <p class="card-text text-dark">Requirements:<br><?php echo $limited_requirements; ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } else { ?>
                    <h2 class="p-2 text-center">No Jobs Available Right Now</h2>
                    <?php } ?>

                </div>
            </main>
        </section>

        <!--Our posting section end-->


    </div>



    <?php include("./partials/footer.php");
    ?>

    <script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 20,
            autoplayHoverPause: true,
            autoplay: true,
            autoplayTimeout: 3000,
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