<?php
if (isset($_COOKIE['trainer_username']) && isset($_COOKIE['trainer_password'])) {
    unset($_COOKIE['trainer_username']);
    unset($_COOKIE['trainer_password']);
    unset($_COOKIE['trainer_email']);
    unset($_COOKIE['trainer_id']);
    setcookie('trainer_username', '', time() - 3600, '/');
    setcookie('trainer_password', '', time() - 3600, '/');
    setcookie('trainer_email', '', time() - 3600, '/');
    setcookie('trainer_id', '', time() - 3600, '/');

    header("location: ../../trainer_login.php");
    exit();
}
