<?php
session_start();
if (isset($_COOKIE['superadmin_username']) && isset($_COOKIE['superadmin_password'])) {
    unset($_COOKIE['superadmin_username']);
    unset($_COOKIE['superadmin_password']);
    unset($_COOKIE['superadmin_email']);
    unset($_COOKIE['superadmin_id']);
    setcookie('superadmin_username', '', time() - 3600, '/');
    setcookie('superadmin_password', '', time() - 3600, '/');
    setcookie('superadmin_email', '', time() - 3600, '/');
    setcookie('superadmin_id', '', time() - 3600, '/');

    header("location: ../../super-admin_login.php");
    exit();
}
