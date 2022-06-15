<?php
    session_start();
    unset($_SESSION['email']);
    setcookie('email', null, -1, '/');
    setcookie('password', null, -1, '/');
    header('Location: ./login.php');
?>