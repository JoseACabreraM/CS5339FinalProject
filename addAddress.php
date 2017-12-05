<?php

require_once 'credentials.php';
date_default_timezone_set('America/Denver');
session_start();

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
print "                
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title> Register User Address </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_POST['submission']) && isset($_SESSION['uName'])) {
    if (isset($_POST['addLine']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['country']) && isset($_POST['postal'])) {
        $uName = $_SESSION['uName'];
        $addLine = mysqli_real_escape_string($connection, $_POST['addLine']);
        $city = mysqli_real_escape_string($connection, $_POST['city']);
        $state = mysqli_real_escape_string($connection, $_POST['state']);
        $country = mysqli_real_escape_string($connection, $_POST['country']);
        $postal = mysqli_real_escape_string($connection, $_POST['postal']);
        if (existingUser($connection, $uName)) {
            print " 
                <div align='center'><h1> Successfully Added User Address! </h1></div>
                <div align='center'>
                    <br>
                    <form action='changeAddress.php'>   
                    <button> Change Address </button> 
                    </form>
                </div>
                <div align='center'> 
                    <br> 
                    <form action='user.php'> 
                    <button> User Page </button> 
                    </form> 
                </div> 
            ";
            addAddress($connection, $uName, $addLine, $city, $state, $country, $postal);
        } else {
            header("Location:addAddress.php?error=2");
            exit();
        }
    } else {
        header("Location:addAddress.php?error=1");
        exit();
    }
} else {
    print " 
                <div align='center'><h1> Register User Adresses </h1></div>
                <div align='center'>
                    <form action='addAddress.php ' method='POST'>
                        Address Line <br>
                        <input type='text' name='addLine'>
                        <br> City <br>
                        <input type='text' name='city'>
                        <br> State <br>
                        <input type='text' name='state'>
                        <br> Country <br>
                        <input type='text' name='country'>
                        <br> Postal <br>
                        <input type='text' name='postal'> <br><br>                 
                        <input type='submit' value='Submit'>
                        <input type='hidden' name='submission' value='sA'>
                    </form>
                </div>
            ";

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1) {
            print "
                        <br>
                        <div align='center'>
                            Missing fields!
                        </div>
                    ";
        } else {
            print "
                        <br>
                        <div align='center'>
                            User has already registered an address!
                        </div>
                    ";
        }
    }
}

print "
        <div align='center'>
            <br>
            <form action='mainpage.php'>   
            <button> Main Page </button> 
            </form>
        </div>
        </form>
        </body>
        </html>
    ";

function addAddress($connection, $uName, $addLine, $city, $state, $country, $postal)
{
    $query = "INSERT INTO userAddress VALUES('$uName', '$addLine', '$city', '$state','$country','$postal')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}

function existingUser($connection, $uName)
{
    $query = "SELECT * FROM userData WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if ($row[2] == $uName) {
            $query = "SELECT * FROM userAddress WHERE username= '$uName'";
            $result = $connection->query($query);
            return $result->num_rows === 0;
        } else return false;
    }
    return false;
}