<?php
session_start();

if (isset($_POST['ip']) && !isset($_COOKIE['trainer_ip'])) {
    $ip = $_POST['ip'];
    $_SESSION['ip'] = $ip;
    setcookie("trainer_ip", $ip, time() + (86400 * 30), "/");
    echo 'IP address stored in session successfully';
} else {
    echo 'IP address not provided';
}
