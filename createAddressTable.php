<?php
require_once 'credentials.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);
$query = "CREATE TABLE IF NOT EXISTS userAddress (
    username VARCHAR(255) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,  
    city VARCHAR(255)NOT NULL,
    state VARCHAR(255)NOT NULL, 
    country VARCHAR(255)NOT NULL,
    postal INT(5) NOT NULL
    )";

$result = $connection->query($query);
if (!$result) die($connection->error);