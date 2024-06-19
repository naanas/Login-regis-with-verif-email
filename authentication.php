<?php
session_start();

if (!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Harap login terlebih dahulu untuk mengakses dashboard!";
    header("Location: login.php");
    exit();
}
