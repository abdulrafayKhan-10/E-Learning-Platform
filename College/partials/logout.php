<?php
if (isset($_COOKIE['college_username']) && isset($_COOKIE['college_password'])) {
    unset($_COOKIE['college_username']);
    unset($_COOKIE['college_password']);
    unset($_COOKIE['college_email']);
    setcookie('college_username', '', time() - 3600, '/');
    setcookie('college_password', '', time() - 3600, '/');
    setcookie('college_email', '', time() - 3600, '/');

    header("location: ../../college_login.php");
    exit();
}
