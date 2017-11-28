<?php

require_once 'credentials.php';
session_start();

print "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Admin</title>
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
        print "
            <div 
                align='center'><h1> Admin </h1></div>
            <div>
    
            <div align='center'>
                Logged in as: $uName
                <br> <br>
                <form action='logout.php' method='post' >   
                    <input type='submit' name='Logout' value='Logout'> 
                </form>               
            </div>
                         
            <div align='center'>
                <br>
                <form action='addUser.php' method='post' >   
                    <input type='submit' name='addUser' value='Add User'> 
                </form>
            </div>
            
            <div align='center'>
                <br>
                <form action='admin.php' method='post' >   
                    <input type='submit' name='sUsers' value='Show Registered Users'> 
                </form>
            </div>
            
            <div align='center'> 
                <br>
                <form action='user.php'>   
                    <button> User Page </button> 
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

if (isset($_POST['sUsers']) && $_POST['sUsers'] == 'Show Registered Users') {
    printAllUsers();
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
