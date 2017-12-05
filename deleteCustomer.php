<?php

require_once 'credentials.php';
session_start();

print "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title> Delete Customer </title>
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
            removeUser($toRemove);
        }
        print " 
        <div 
            align='center'><h1> Delete User </h1></div>
        <div>
        <div 
            align='center'> List of Registered Users </div>
        <div>
        ";
        printAllUsers();
        print "

        <div align='center'>
            Logged in as: $uName
            <br> <br>
            <form action='deleteCustomer.php ' method='POST'>
            User to Remove (Provide Username) <br><br>
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

function removeUser($uName){
    global $db_database, $db_hostname, $db_password, $db_username;
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "DELETE FROM userData WHERE username='$uName'";
    $result = $connection->query($query);
}

function printAllUsers()
{
    global $db_database, $db_hostname, $db_password, $db_username;
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "SELECT * FROM userData";
    $result = $connection->query($query);
    print " <table  style=\"width:100%\">
            <tr>
                <th>First Name</th>
                <th>Last Name</th> 
                <th>Username</th>
                <th>Account Creation</th>
                <th>Last Login</th>
                <th>Account Type</th>
            </tr>
    ";
    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        print '<tr style="text-align:center;">';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['firstName'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['lastName'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['username'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['accTime'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['lastLogin'] . '</td>';
        $result->data_seek($j);
        if ($result->fetch_assoc()['userType']) {
            echo '<td > Normal </td>';
        } else {
            echo '<td > Administrator </td>';
        }
        print '</tr><br>';

    }
    print "</table>";
}
