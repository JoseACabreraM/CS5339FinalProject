<?php

require_once 'credentials.php';
date_default_timezone_set('America/Denver');

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if (isset($_POST['uName']) && isset($_POST['pWord'])) {
    $uName = mysqli_real_escape_string($connection, $_POST['uName']);
    $pWord = mysqli_real_escape_string($connection, $_POST['pWord']);
    if (existingUser($connection, $uName) && verifyUser($connection, $uName, $pWord)) {
        header("Location:mainpage.php");
        exit();
    } else {
        header("Location:login.php?error=1");
        exit();
    }
} else {
    header("Location:login.php?error=1");
    exit();
}

function existingUser($connection, $uName)
{
    $query = "SELECT * FROM userData WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if ($row[2] == $uName) return true;
        else return false;
    }
    return false;
}

function verifyUser($connection, $uName, $pWord)
{
    $time = date("Y-m-d H:i:s");
    $query = "SELECT * FROM userData WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $salt = "e4djuki9";
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $spWord = $row[3];
        if ($spWord == hash('ripemd128', "$salt$uName$pWord")) {
            $query = "UPDATE userData SET lastLogin='$time' WHERE username= '$uName'";
            $result = $connection->query($query);
            if (!$result) die($connection->error);
            session_start();
            $_SESSION['uName'] = $uName;
            $_SESSION['fName'] = $row[0];
            $_SESSION['lName'] = $row[1];
            $_SESSION['aTime'] = $row[4];
            $_SESSION['lTime'] = $row[5];
            $_SESSION['uType'] = $row[6];
            return true;
        } else {
            return false;
        }
    }
    return false;
}
