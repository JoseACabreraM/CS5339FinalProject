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
                <div align='center'><h1> Successfully Updated User Address! </h1></div>
                <div align='center'> 
                    <br> 
                    <form action='user.php'> 
                    <button> User Page </button> 
                    </form> 
                </div> 
            ";
            updateAddress($connection, $uName, $addLine, $city, $state, $country, $postal);
        } else {
            header("Location:changeAddress.php?error=2");
            exit();
        }
    } else {
        header("Location:changeAddress.php?error=1");
        exit();
    }
} else if (isset($_SESSION['uName'])){
    print "
        <div align='center'><h1> Update Address </h1></div>
        <div align='center'>
            Current Address
        </div>
    ";
    $uName = $_SESSION['uName'];
    printUserAddress($uName);
    print " 
                <div align='center'>
                    <form action='changeAddress.php ' method='POST'>
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
                            Username already in use!
                        </div>
                    ";
        }
    }
} else {
    print "
        <div align='center'>
            Not authorized to access this webpage!
        </div>
    ";
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

function updateAddress($connection, $uName, $addLine, $city, $state, $country, $postal)
{
    $query = "UPDATE userAddress SET address='$addLine', city='$city', state='$state', country='$country', postal='$postal' WHERE username= '$uName'";
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
        if ($row[2] == $uName) return true;
        else return false;
    }
    return false;
}

function printUserAddress($uName)
{
    global $connection;
    $query = "SELECT * FROM userAddress WHERE username= '$uName'";
    $result = $connection->query($query);
    print " <table  style=\"width:75%\">
            <tr>
                <th>Address Line</th>
                <th>City</th> 
                <th>State</th>
                <th>Country</th>
                <th>Postal</th>
            </tr>
    ";
    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        print '<tr style="text-align:center;">';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['address'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['city'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['state'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['country'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['postal'] . '</td>';
        print '</tr><br>';

    }
    print "</table><br>";
}