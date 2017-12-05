<?php

require_once 'credentials.php';
session_start();

print "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title> Delete Address </title>
    </head>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th, td {
        padding: 15px;
        }
    </style>
    <body style='background-color:lightgray;'>
    
";

if (isset($_SESSION['uName'])) {
    $uName = $_SESSION['uName'];
    $uType = $_SESSION['uType'];
    if ($uType == 0) {
        if (isset($_POST['toRemove'])){
            $toRemove = $_POST['toRemove'];
            removeAddress($toRemove);
        }
        print " 
        <div 
            align='center'><h1> Delete User Address </h1></div>
        <div>
        <div align='center'>
        Logged in as: $uName <br> <br>
        List of Registered Addresses 
        </div>
        <div>
        ";
        printAllAddress();
        print "
        <div align='center'>
            <br>
            <form action='deleteAddress.php ' method='POST'>
            Address to Remove (Provide Username) <br><br>
            <input type='text' name='toRemove'>
            <input type='submit' name='toRemoveSub' value='Submit'> 
            </form>    
            <br>
            <form action='logout.php' method='post' >   
                <input type='submit' name='Logout' value='Logout'> 
            </form>               
        </div>    
        
            ";

    } else {
        print "
            <div align='center'>
                Not authorized to access this webpage!
            </div>
        ";
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
    </div>
    </body>
    </html>
";

function removeAddress($uName){
    global $db_database, $db_hostname, $db_password, $db_username;
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "DELETE FROM userAddress WHERE username='$uName'";
    $connection->query($query);
}

function printAllAddress()
{
    global $db_database, $db_hostname, $db_password, $db_username;
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "SELECT * FROM userAddress";
    $result = $connection->query($query);
    print " <table align='center' style=\"width:75%\">
            <tr>
                <th>User</th>
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
        echo '<td >'.$result->fetch_assoc()['username'] .'</td>';
        $result->data_seek($j);
        echo '<td >'.$result->fetch_assoc()['address'] .'</td>';
        $result->data_seek($j);
        echo '<td >'.$result->fetch_assoc()['city'] . '</td>';
        $result->data_seek($j);
        echo '<td >'.$result->fetch_assoc()['state'] . '</td>';
        $result->data_seek($j);
        echo '<td >'.$result->fetch_assoc()['country'] . '</td>';
        $result->data_seek($j);
        echo '<td >'.$result->fetch_assoc()['postal'] . '</td>';
        print '</tr><br>';
    }
    print "</table>";
}