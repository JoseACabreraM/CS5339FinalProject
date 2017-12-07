<?php

require_once 'credentials.php';
session_start();

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
print "                
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title> Delete Part </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_POST['submission']) && isset($_SESSION['uName'])) {
    if (isset($_POST['pID']) && !empty($_POST['pID'])) {
        $pID = mysqli_real_escape_string($connection, $_POST['pID']);

        if (existingPart($connection, $pID)) {
            print " 
                <div align='center'><h1> Successfully Deleted Part! </h1></div>
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
            deletePart($connection, $pID);
        } else {
            header("Location:deletePart.php?error=2");
            exit();
        }
    } else {
        header("Location:deletePart.php?error=1");
        exit();
    }
} else if (isset($_SESSION['uName'])) {
    print "
        <div align='center'><h1> Add/Update Part </h1></div>
    ";
    print " 
                <div align='center'>
                    <form action='deletePart.php ' method='POST'>
                        Part ID <br>
                        <input type='text' name='pID' required>
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
                            Part not found!
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
            <form action='index.php'>   
            <button> Main Page </button> 
            </form>
        </div>
        
        </form>
        </body>
        </html>
    ";


function deletePart($connection, $pID) {
    $query = "DELETE FROM Allparts WHERE PartID='$pID'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function existingPart($connection, $pID)
{
    $query = "SELECT * FROM Allparts WHERE PartID= '$pID'";
    $result = $connection->query($query);
    return mysqli_fetch_row($result);
}

