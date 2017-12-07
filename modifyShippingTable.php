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
        <title> Add/Update Shipping </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_POST['submission']) && isset($_SESSION['uName'])) {
    if (isset($_POST['weight']) && !empty($_POST['weight']) && isset($_POST['zone2']) && !empty($_POST['zone2']) && isset($_POST['zone3']) && !empty($_POST['zone3'])
        && isset($_POST['zone4']) && !empty($_POST['zone4'])&& isset($_POST['zone5']) && !empty($_POST['zone5']) && isset($_POST['zone6']) && !empty($_POST['zone6'])
        && isset($_POST['zone7']) && !empty($_POST['zone7'])&& isset($_POST['zone8']) && !empty($_POST['zone8'])) {

        $weight = mysqli_real_escape_string($connection, $_POST['weight']);
        $zone2 = mysqli_real_escape_string($connection, $_POST['zone2']);
        $zone3 = mysqli_real_escape_string($connection, $_POST['zone3']);
        $zone4 = mysqli_real_escape_string($connection, $_POST['zone4']);
        $zone5 = mysqli_real_escape_string($connection, $_POST['zone5']);
        $zone6 = mysqli_real_escape_string($connection, $_POST['zone6']);
        $zone7 = mysqli_real_escape_string($connection, $_POST['zone7']);
        $zone8 = mysqli_real_escape_string($connection, $_POST['zone8']);


        if (!existingWeight($connection, $weight)) {
            print " 
                <div align='center'><h1> Successfully Added Shipping Info! </h1></div>
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
            addShipping($connection, $weight, $zone2, $zone3, $zone4, $zone5, $zone6, $zone7, $zone8);
        } else {
            print " 
                <div align='center'><h1> Successfully Updated Shipping Info! </h1></div>
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
            updateShipping($connection, $weight, $zone2, $zone3, $zone4, $zone5, $zone6, $zone7, $zone8);
        }
    } else {
        header("Location:modifyShippingTable.php?error=1");
        exit();
    }
} else if (isset($_SESSION['uName'])) {
    print "
        <div align='center'><h1> Add/Update Shipping </h1></div>
    ";
    print " 
                <div align='center'>
                    <form action='modifyShippingTable.php ' method='POST'>
                        <br> Weight <br>
                        <input type='text' name='weight' size=\"40\"> <br>
                        <br><br>
                        <table align='center' style=\"width:75%\">
                        <tr style=\"text-align:center;\">
                            <th> Zone 2 </th>
                            <th> Zone 3 </th>
                            <th> Zone 4 </th>
                            <th> Zone 5 </th>
                            <th> Zone 6 </th>
                            <th> Zone 7 </th>
                            <th> Zone 8 </th>
                        </tr>
                        <tr style=\"text-align:center;\">
                            <td><input type='text' name='zone2'</td>
                            <td><input type='text' name='zone3'</td>
                            <td><input type='text' name='zone4'</td>
                            <td><input type='text' name='zone5'</td>
                            <td><input type='text' name='zone6'</td>
                            <td><input type='text' name='zone7'</td>
                            <td><input type='text' name='zone8'</td>
                        </tr>
                        </table>
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
            <form action='index.php'>   
            <button> Main Page </button> 
            </form>
        </div>
        
        </form>
        </body>
        </html>
    ";


function updateShipping($connection, $weight, $zone2, $zone3, $zone4, $zone5, $zone6, $zone7, $zone8)
{
    $query = "UPDATE UPSGroundWeightZonePrice SET Zone2='$zone2', Zone3='$zone3', Zone4='$zone4', Zone5='$zone5', Zone6='$zone6', Zone7='$zone7', Zone8='$zone8' WHERE Weight='$weight' ";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function addShipping($connection, $weight, $zone2, $zone3, $zone4, $zone5, $zone6, $zone7, $zone8)
{

    $query = "INSERT INTO UPSGroundWeightZonePrice VALUES('$weight', '$zone2', '$zone3', '$zone4', '$zone5', '$zone6', '$zone7', '$zone8')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function existingWeight($connection, $weight)
{
    $query = "SELECT * FROM UPSGroundWeightZonePrice WHERE Weight= '$weight'";
    $result = $connection->query($query);
    return mysqli_fetch_row($result);
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
        echo '<td >' . $result->fetch_assoc()['username'] . '</td>';
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
    print "</table>";
}