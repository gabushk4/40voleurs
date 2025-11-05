<?php
    $_SESSION['connecteA40V'] = false;
    $connecte = false;
    session_start();
    session_destroy();
    session_unset();
    setcookie("PHPSESSID", null, -1);
    header('Location: index.php');
    exit;
