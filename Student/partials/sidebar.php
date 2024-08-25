<div class="main-header side-header sticky nav nav-item">
    <div class=" main-container container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="dashboard.php" class="header-logo">
                    <!-- <img src="assets/img/WordPress_blue_logo.svg-min.webp" class="mobile-logo logo-1" alt="logo"> -->
                    <img src="../assets/media/Invictus.png" class="mobile-logo dark-logo-1" alt="logo">
                </a>
            </div>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
            </div>
            <div class="logo-horizontal">
                <a href="dashboard.php" class="header-logo">
                    <img src="../assets/media/Invictus.png" class="mobile-logo logo-1" alt="logo">
                    <img src="../assets/media/Invictus.png" class="mobile-logo dark-logo-1" alt="logo">
                </a>
            </div>

        </div>
        <?php
        include('./partials/navbar.php');
        ?>

    </div>
    <!-- /main-header -->

    <!-- main-sidebar -->
    <div class="sticky">
        <aside class="app-sidebar">
            <div class="main-sidebar-header active">
                <a class="header-logo active" href="dashboard.php">
                    <img src="../assets/media/Invictus.png" class="main-logo  desktop-logo" alt="logo">
                    <img src="../assets/media/Invictus.png" class="main-logo  desktop-dark" alt="logo">
                    <img src="../assets/media/Invictus.png" class="main-logo  mobile-logo" alt="logo">
                    <img src="../assets/media/Invictus.png" class="main-logo  mobile-dark" alt="logo">
                </a>
            </div>
            <div class="main-sidemenu">
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg></div>
                <ul class="side-menu">

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="dashboard.php"><i class="si si-event"
                                width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Dashboard</span></a>

                    </li>


                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="si si-book-open" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Courses</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">Courses</a></li>
                            <li><a class="slide-item" href="courseregister.php">List</a></li>
                            <li><a class="slide-item" href="courseregistration.php">Registrations</a></li>
                            <!-- <li><a class="slide-item" href="coursetransactions.php">Transactactions</a></li>
                            <li><a class="slide-item" href="coursepayments.php">Payments</a></li> -->
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="fe fe-feather" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Internships</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">Internships</a></li>
                            <li><a class="slide-item" href="internshipregister.php">List</a></li>
                            <li><a class="slide-item" href="intershipregistration.php">Registrations</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="fe fe-file-text" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Placements</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">Placements</a></li>
                            <li><a class="slide-item" href="placementsregister.php">List</a></li>
                            <li><a class="slide-item" href="placementsregistration.php">Registrations</a>
                            </li>
                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="fe fe-users" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">My Accounts</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">My account</a></li>
                            <li><a class="slide-item" href="mycourses.php">My Courses</a></li>
                            <li><a class="slide-item" href="myinternships.php">My Internships</a></li>
                            <li><a class="slide-item" href="myplacements.php">My Placements</a></li>
                        </ul>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="fe fe-mail" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Chats</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">Chat</a></li>
                            <li><a class="slide-item" href="compose.php">Compose</a></li>
                            <li><a class="slide-item" href="inbox.php">Inbox</a></li>

                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><i
                                class="fe fe-upload" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">File Manager</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">File Manager</a>
                            </li>
                            <li><a class="slide-item" href="documentation.php">Documentations</a></li>
                            <li><a class="slide-item" href="certifications.php">Certifications</a></li>
                        </ul>
                    </li>



                    <li class="slide">

                        <a class="side-menu__item" data-bs-toggle="slide" href="profile.php"><i class="fe fe-user"
                                width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Profile</span></a>
                    </li>
                    <li class="slide">

                        <a class="side-menu__item" data-bs-toggle="slide" href="batch.php"><i class="fe fe-layers"
                                width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">My Batches</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="changepassword.php"><i
                                class="fe fe-lock" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Change Password</span></a>

                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="./partials/logout.php"><i
                                class="fe fe-log-out" width="24" height="24" viewBox="0 0 24 24"></i>&nbsp
                            &nbsp <span class="side-menu__label">Logout</span></a>

                    </li>



                </ul>
                <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                    </svg></div>
            </div>
        </aside>
    </div>
    <!-- main-sidebar -->

</div>