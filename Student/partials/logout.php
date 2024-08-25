<?php
if (isset($_COOKIE['student_username']) && isset($_COOKIE['student_password'])) {
    unset($_COOKIE['student_username']);
    unset($_COOKIE['student_password']);
    unset($_COOKIE['student_id']);
    setcookie('student_username', '', time() - 3600, '/');
    setcookie('student_password', '', time() - 3600, '/');
    setcookie('student_id', '', time() - 3600, '/');

    header("location: ../../student_login.php");
    exit();
}
