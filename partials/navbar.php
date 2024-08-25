<header class="header position-relative z-9">
    <nav class="navbar navbar-expand-lg navbar-light navbar-theme-white fixed-top headroom">
        <div class="container position-relative">
            <a class="navbar-brand mr-lg-3" href="./index.php">

                <?php
                $select = mysqli_query($conn, "SELECT * FROM `home_section_one`");
                if (mysqli_num_rows($select) > 0) {
                    $row = mysqli_fetch_assoc($select);
                    echo ' <img class="navbar-brand-dark img-fluid" src="./superadmin/assets/img/home/' . $row['nav_logo'] . '" alt="Logo">';
                    echo ' <img class="navbar-brand-light img-fluid" src="./superadmin/assets/img/home/' . $row['nav_logo'] . '" alt="Logo">';
                } else {

                ?>
                <img class="navbar-brand-dark img-fluid" src="./assets/media/Invictus.png/" alt="Logo">
                <img class="navbar-brand-light img-fluid" src="./assets/media/Invictus.png/" alt="Logo">

                <?php } ?>


            </a>
            <div class="navbar-toggler d-lg-none d-flex align-items-center ml-2" type="button" data-toggle="collapse"
                data-target="#navbar-default-primary" aria-controls="navbar-default-primary" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </div>
            <div class="navbar-collapse collapse" id="navbar-default-primary">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="./index.php">
                                <?php
                                $select = mysqli_query($conn, "SELECT * FROM `home_section_one`");
                                if (mysqli_num_rows($select) > 0) {
                                    $row = mysqli_fetch_assoc($select);
                                    echo ' <img src="./superadmin/assets/img/home/' . $row['nav_logo'] . '" alt="Logo">';
                                } else {

                                ?>
                                <img src="./assets/media/Invictus.png/" alt="Logo">

                                <?php } ?>
                            </a>
                        </div>
                        <div class="col-6 collapse-close d-lg-none">
                            <!-- Hide on large screens -->
                            <i class="bi bi-list d-lg-none" data-toggle="collapse" role="button"
                                data-target="#navbar-default-primary" aria-controls="navbar-default-primary"
                                aria-expanded="false" aria-label="Toggle navigation"></i>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./aboutus.php">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./jobs.php">Jobs</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./internships.php">Internships</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./courses.php">Courses</a>

                    </li>


                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                            <span class="nav-link-inner-text ">Login/Register </span>
                            <i class="bi bi-caret-down-fill nav-link-arrow"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a href="#"
                                    class="dropdown-toggle dropdown-item d-flex justify-content-between align-items-center"
                                    aria-haspopup="true" aria-expanded="false">Login <i
                                        class="bi bi-caret-right-fill nav-link-arrow"></i></a>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item" href="./super-admin_login.php">Super-Admin</a>
                                    </li>
                                    <li><a class="dropdown-item" href="./student_login.php">Student</a>
                                    </li>
                                    <li><a class="dropdown-item" href="./college_login.php">College</a>
                                    </li>
                                    <li><a class="dropdown-item" href="./trainer_login.php">Trainer</a>
                                    </li>

                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="index.html#"
                                    class="dropdown-toggle dropdown-item d-flex justify-content-between align-items-center"
                                    aria-haspopup="true" aria-expanded="false">Register<i
                                        class="bi bi-caret-right-fill nav-link-arrow"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="./studentregister.php">Student</a></li>
                                    <li><a class="dropdown-item" href="./collegeregister.php">College</a></li>
                                    <li><a class="dropdown-item" href="./trainerregister.php">Trainer</a></li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact Us</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>