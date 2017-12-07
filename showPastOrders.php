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
        <title> Order History </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_SESSION['uName'])) {
    print "
        <div align='center'><h1> Order History </h1></div>
    ";
    $uName = $_SESSION['uName'];
    printPastOrders($uName);
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
                            User not found!
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
            <form action='user.php'>   
            <button> User Page </button> 
            </form>
            <br>
            <form action='index.php'>   
            <button> Main Page </button> 
            </form>
        </div>
        
        </form>
        </body>
        </html>
    ";

function printPastOrders($uName)
{
    global $db_database, $db_hostname, $db_password, $db_username;
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "SELECT * FROM Orders WHERE Username='$uName'";
    $result = $connection->query($query);
    print " <table align='center' style=\"width:75%\">
            <tr>
                <th> Item Name </th>
                <th> Item Number </th>
                <th> Amount </th> 
                <th> Date  </th>
            </tr>
    ";
    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        print '<tr style="text-align:center;">';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['ItemName'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['ItemNumber'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['Amount'] . '</td>';
        $result->data_seek($j);
        echo '<td >' . $result->fetch_assoc()['Date'] . '</td>';
        print '</tr><br>';
    }
    print "</table>";
}

