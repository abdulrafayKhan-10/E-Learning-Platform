<?php
include("./db_connection/connection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <title>About Us</title>


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
        <section>
            <div class="section-lg1 bg-gradient-primary text-white ">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-7">
                            <div class="page-header-content text-center">
                                <h1>About Us</h1>
                                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                                    <ol class="breadcrumb breadcrumb-transparent breadcrumb-text-light">
                                        <li class="breadcrumb-item"><a href="./index.php">Home</a>
                                        </li>

                                        <li class="bi bi-arrow-right-short active" aria-current="page">About Us</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-lg">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-md-6 col-lg-6 mb-4 mb-md-4 mb-lg-0">
                        <div class="feature-widget-wrap">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="card card-body shadow mt-4">
                                        <div class="d-flex">
                                            <div class="mr-3 mr-md-4">
                                                <div
                                                    class="mb-4 p-3 p-md-4 icon icon-shape icon-md rounded-circle bg-default-alt text-default">
                                                    <i class="bi bi-trophy-fill"></i>
                                                </div>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Our Mission</h5>
                                                <p class="mb-0">No depending be convinced in unfeeling he. Excellence
                                                    she
                                                    unaffected and too sentiments her. Rooms he doors there ye aware in
                                                    by
                                                    shall. Education remainder in so cordially. His remainder and own
                                                    dejection daughters sportsmen. Is easy took he shed to kind.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card card-body shadow mt-4">
                                        <div class="d-flex">
                                            <div class="mr-3 mr-md-4">
                                                <div
                                                    class="mb-4 p-3 p-md-4 icon icon-shape icon-md rounded-circle bg-secondary-alt text-secondary">
                                                    <i class="bi bi-stack"></i>
                                                </div>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Our Vision</h5>
                                                <p class="mb-0">Or neglected agreeable of discovery concluded oh it
                                                    sportsman. Week to time in john. Son elegance use weddings separate.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card card-body shadow mt-4">
                                        <div class="d-flex">
                                            <div class="mr-3 mr-md-4">
                                                <div
                                                    class="mb-4 p-3 p-md-4 icon icon-shape icon-md rounded-circle bg-success-alt text-success">
                                                    <i class="bi bi-sign-turn-slight-right"></i>
                                                </div>
                                            </div>
                                            <div class="feature-content">
                                                <h5>Our Uniqueness</h5>
                                                <p class="mb-0">Its sometimes her behaviour are contented. Do listening
                                                    am
                                                    eagerness oh objection collected. Together gay feelings continue
                                                    juvenile had off one. Unknown may service subject her letters one
                                                    bed.
                                                    Child years noise ye in forty. Loud in this in both hold. My
                                                    entrance me
                                                    is disposal bachelor remember relation.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <h2>Invictus: The New Era of Learning</h2>
                        <p class="lead">Invictus Solutions is the only platform where you can make learn, be an Intern
                            and
                            Become an Employee.</p>

                        <ul class="list-unstyled tech-feature-list">
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>Courses
                                    at
                                    very Low Price</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>Recordings
                                    of every session</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>Doubt
                                    Clearance during sesion and post session</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>12//7
                                    Technical, Theoritical and Conceptual Support</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>Personality
                                    Development</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i
                                        class="bi bi-fast-forward"></i></i>Internship
                                    Appplication</li>
                            <li class="py-1"><span class="icon icon-xs mr-2 "> <i class="bi bi-fast-forward"></i></i>Job
                                    Application</li>

                        </ul>


                    </div>
                </div>
            </div>
        </section>

    </div>


    <?php include("./partials/footer.php");
    ?>

</body>

</html>