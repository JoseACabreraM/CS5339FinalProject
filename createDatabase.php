<?php

require_once 'credentials.php';
date_default_timezone_set('America/Denver');

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

$query = "SHOW DATABASES LIKE 'dbname'";

if ($connection->connect_error) die($connection->connect_error);
$query = "CREATE TABLE IF NOT EXISTS userData (
    firstName VARCHAR(32) NOT NULL,
    lastName VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    sPassword VARCHAR(32) NOT NULL UNIQUE,
    accTime DATETIME NOT NULL,
    lastLogin DATETIME NOT NULL, 
    userType TINYINT(1) NOT NULL
    )";

$result = $connection->query($query);
if (!$result) die($connection->error);

addUser($connection, "Jose", "Cabrera", "admin", "nimda339", 0, "e4djuki9");
addUser($connection, "Thomas", "Anderson", "Neo", "noSpoon", 1, "e4djuki9");

function addUser($connection, $fName, $lName, $uName, $pWord, $uType, $salt)
{
    $time = date("Y-m-d H:i:s");
    $spWord = hash('ripemd128', "$salt$uName$pWord");
    $query = "INSERT INTO userData VALUES('$fName', '$lName', '$uName', '$spWord','$time','$time', '$uType')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}
