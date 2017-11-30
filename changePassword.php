<?php
session_start();
require_once 'credentials.php';

print "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Change Password</title>
    </head>
    <body style='background-color:lightgray;'>
    <div align='center'><h1> Change Password </h1></div>
";

if (isset($_POST['pcReq']) && isset($_POST['oldPass']) && isset($_POST['newPass'])){
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    verifyUser($connection);
}

if (isset($_SESSION['uName'])) {
    print "
        <div align='center'>
        <form action='changePassword.php' method='POST'>
            <br> Old Password <br>
            <input type='password' name='oldPass'>
            <br> New Password <br>
            <input type='password' name='newPass'>
            <br><br>
            <input type='submit' name = 'pcReq' value='Submit'>
        </form>
    ";
    if (isset($_GET['error'])) {
        print "
            <br>
            <div align='center'>
                Invalid Username/Password
            </div>
         ";
    }
    if (isset($_GET['success'])) {
        print "
            <br>
            <div align='center'>
                Password Successfully Changed!
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
            <form action='index.php'>   
                <button> Home </button> 
            </form>
            <br>
        </div>
        </body>
        </html>
";

function verifyUser($connection)
{
    $uName = $_SESSION['uName'];
    $pWord = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
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
        $spWord = $row[3];
        if ($spWord == hash('ripemd128', "$salt$uName$pWord")) {
            $newPass = hash('ripemd128', "$salt$uName$newPass");
            $query = "UPDATE userData SET sPassword='$newPass' WHERE username= '$uName'";
            $result = $connection->query($query);
            if (!$result) die($connection->error);
            header("Location:changePassword.php?success=1");
            exit();
        } else {
            header("Location:changePassword.php?error=1");
            exit();        }
    }
    return false;
}