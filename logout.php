<?php
session_start();
if (isset($_SESSION['uName']) && isset($_POST['Logout'])) {
    if ($_POST['Logout'] == "Logout") {
        $_SESSION = array();
        session_destroy();
    }
    header("Location:mainpage.php");
    exit();
}
