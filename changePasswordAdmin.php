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
        <title> Change User Password </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_POST['submission']) && isset($_SESSION['uName'])) {
    if (isset($_POST['toRUname']) && !empty($_POST['toRUname']) && isset($_POST['nPassword']) && !empty($_POST['nPassword'])) {
        $uName = mysqli_real_escape_string($connection, $_POST['toRUname']);
        $newPass = mysqli_real_escape_string($connection, $_POST['nPassword']);
        if (existingUser($connection, $uName)) {
            print " 
                <div align='center'><h1> Successfully Updated User Password! </h1></div>
                <div align='center'> 
                    <br> 
                    <form action='admin.php'>
                    <button> Admin </button> 
                    </form> 
                    <br>
                    <form action='user.php'> 
                    <button> User Page </button> 
                    </form> 
                </div> 
            ";
            updatePassword($connection, $uName, $newPass);
        } else {
            header("Location:changePasswordAdmin.php?error=2");
            exit();
        }
    } else {
        header("Location:changePasswordAdmin.php?error=1");
        exit();
    }
} else if (isset($_SESSION['uName'])){
    print "
        <div align='center'><h1> Change User Password </h1></div>
        <div align='center'>
            Registered Users
        </div>
    ";
    $uName = $_SESSION['uName'];
    printAllUsers();
    print " 
                <div align='center'>
                    <form action='changePasswordAdmin.php ' method='POST'>
                        Username <br>
                        <input type='text' name='toRUname'>  
                        <br> New Password <br>
                        <input type='text' name='nPassword'>                                  
                        <br><br><input type='submit' value='Submit'>
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
            <form action='mainpage.php'>   
            <button> Main Page </button> 
            </form>
        </div>
        
        </form>
        </body>
        </html>
    ";

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

function updatePassword($connection, $uName, $newPass)
{
    $query = "SELECT * FROM userData WHERE username= '$uName'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $salt = "e4djuki9";
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if ($row[2] != $uName) {
            header("Location:changePassword.php?error=1");
            exit();
        }
        $newPass = hash('ripemd128', "$salt$uName$newPass");
        $query = "UPDATE userData SET sPassword='$newPass' WHERE username= '$uName'";
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        return true;  
    }
    return false;
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
