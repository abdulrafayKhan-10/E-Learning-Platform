<?php

$l_query = mysqli_query($conn, "SELECT * FROM `latest_course`");
?>

<!--footer section start-->
<footer class="footer-wrap">
    <div class="footer footer-top section section-md text-white" style="background-color: black !important;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4 mb-4">
                    <a class="footer-brand mr-lg-5 d-flex" href="./index.php">
                        <img src="./assets/media/Invictus.png" class="mr-3" alt="Footer logo">
                    </a>
                    <p class="my-4">
                    <h5>Our Online Presence</h5>
                    </p>
                    <div class="btn-wrapper mt-4">

                        <a href="#">
                            <button class="btn btn-icon-only btn-pill btn-twitter mr-2 icon icon-xs icon-shape">
                                <i class="bi bi-twitter-x"></i>
                            </button>
                        </a>

                        <a href="#">
                            <button class="btn btn-icon-only btn-pill btn-facebook mr-2 icon icon-xs icon-shape"
                                type="button" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="">
                                <i class="bi bi-facebook"></i>
                            </button> </a>
                        <a href="#">
                            <button class="btn btn-icon-only btn-pill btn-youtube mr-2 icon icon-xs icon-shape" href=""
                                type="button" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="">
                                <i class="bi bi-twitter-x"></i>
                            </button> </a>
                        <a href="#">
                            <button class="btn btn-icon-only btn-pill btn-dribbble icon icon-xs icon-shape"
                                type="button" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="">
                                <i class="bi bi-instagram"></i>
                            </button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                    <h5 class="mb-4">General</h5>
                    <ul class="links-vertical">
                        <li><a target="_blank" href="./index.php">Home</a></li>
                        <li><a target="_blank" href="./aboutus.php">About Us</a></li>
                        <li><a target="_blank" href="#">Services</a></li>
                        <li><a target="_blank" href="./careers.php">Career</a></li>
                        <li><a target="_blank" href="./contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                    <h5 class="mb-4">Latest Courses</h5>
                    <ul class="links-vertical">
                        <?php if (mysqli_num_rows($l_query) > 0) {
                            while ($row = mysqli_fetch_assoc($l_query)) {
                                $course_one = $row['course_one'];
                                $course_two = $row['course_two'];
                                $course_three = $row['course_three'];

                                $courseOne = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$course_one'");
                                $courseTwo = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$course_two'");
                                $courseThree = mysqli_query($conn, "SELECT * FROM `course` WHERE `id` = '$course_three'");
                                if (
                                    mysqli_num_rows($courseOne) > 0 && mysqli_num_rows($courseTwo) > 0 && mysqli_num_rows($courseThree) > 0
                                ) {
                                    $fetch_course_one = mysqli_fetch_assoc($courseOne);
                                    $fetch_course_two = mysqli_fetch_assoc($courseTwo);
                                    $fetch_course_three = mysqli_fetch_assoc($courseThree);

                                    echo '<li><a target="_blank" href="./course_details.php?id=' . $course_one . '">' . $fetch_course_one['course_name'] . '</a></li>';
                                    echo '<li><a target="_blank" href="./course_details.php?id=' . $course_two . '">' . $fetch_course_two['course_name'] . '</a></li>';
                                    echo '<li><a target="_blank" href="./course_details.php?id=' . $course_three . '">' . $fetch_course_three['course_name'] . '</a></li>';
                                }
                            }
                        } ?>


                    </ul>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h5 class="mb-4">Get Started!</h5>
                    <ul class="links-vertical">

                        <li>
                            <a href="./studentregister.php" target="_blank">Student Register</a>
                        </li>
                        <li>
                            <a href="./collegeregister.php" target="_blank">College Register</a>
                        </li>
                        <li class="mb-lg-2">
                            <a href="./trainerregister.php" target="_blank">Trainer Register</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer py-3 text-white border-top border-variant-light" style="background-color: black !important;">
        <div class="container">
            <div class="row">
                <div class="col p-3">
                    <div class="d-flex text-center justify-content-center align-items-center">
                        <p class="copyright pb-0 mb-0">Copyrights ©E-Learning 2024. All
                            Rights Reserved By
                            <a href="#" target="_blank">Invictus</a> &nbsp
                        </p>
                        <!-- <p class="copyright pb-0 mb-0"> Developed By <a href="#"
                                target="_blank">World Of Tech</a> </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer section end-->