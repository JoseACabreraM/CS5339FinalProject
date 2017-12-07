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
        <title> Add/Update Part </title>
    </head>
    <body style='background-color:lightgray;'>
";

if (isset($_POST['submission']) && isset($_SESSION['uName'])) {
    if (isset($_POST['pID']) && !empty($_POST['pID'])) {
        $pID = mysqli_real_escape_string($connection, $_POST['pID']);
        $pName = mysqli_real_escape_string($connection, $_POST['pName']);
        $pNumber = mysqli_real_escape_string($connection, $_POST['pNumber']);
        $pSupplier = mysqli_real_escape_string($connection, $_POST['pSupplier']);
        $pCategory = mysqli_real_escape_string($connection, $_POST['pCategory']);
        $pPrice = mysqli_real_escape_string($connection, $_POST['pPrice']);
        $pShipCost = mysqli_real_escape_string($connection, $_POST['pShipCost']);
        $pNotes = mysqli_real_escape_string($connection, $_POST['pNotes']);
        $pWeight = mysqli_real_escape_string($connection, $_POST['pWeight']);
        $des1 = mysqli_real_escape_string($connection, $_POST['des1']);
        $des2 = mysqli_real_escape_string($connection, $_POST['des2']);
        $des3 = mysqli_real_escape_string($connection, $_POST['des3']);
        $des4 = mysqli_real_escape_string($connection, $_POST['des4']);
        $des5 = mysqli_real_escape_string($connection, $_POST['des5']);
        $des6 = mysqli_real_escape_string($connection, $_POST['des6']);
        $aif1 = mysqli_real_escape_string($connection, $_POST['aif1']);
        $aif2 = mysqli_real_escape_string($connection, $_POST['aif2']);
        $aif3 = mysqli_real_escape_string($connection, $_POST['aif3']);
        $aif4 = mysqli_real_escape_string($connection, $_POST['aif4']);
        if (!existingPart($connection, $pID)) {
            print " 
                <div align='center'><h1> Successfully Added Part! </h1></div>
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
            addPart($connection, $pID, $pName, $pNumber, $pSupplier, $pPrice, $pCategory,
                $pShipCost, $pNotes, $des1, $des2, $des3, $des4, $des5,
                $des6, $aif1, $aif2, $aif3, $aif4, $pWeight);
        } else {
            print " 
                <div align='center'><h1> Successfully Updated Part! </h1></div>
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
            updatePart($connection, $pID, $pName, $pNumber, $pSupplier, $pPrice, $pCategory,
                $pShipCost, $pNotes, $des1, $des2, $des3, $des4, $des5,
                $des6, $aif1, $aif2, $aif3, $aif4, $pWeight);
        }
    } else {
        header("Location:addUpdatePart.php?error=1");
        exit();
    }
} else if (isset($_SESSION['uName'])) {
    print "
        <div align='center'><h1> Add/Update Part </h1></div>
    ";
    print " 
                <div align='center'>
                    <form action='addUpdatePart.php ' method='POST'>
                        Part ID <br>
                        <input type='text' name='pID'>
                        <br> Part Name <br>
                        <input type='text' name='pName'>
                        <br> Part Number <br>
                        <input type='text' name='pNumber'>
                        <br> Supplier <br>
                        <input type='text' name='pSupplier'>
                        <br> Category <br>
                        <input type='text' name='pCategory'>
                        <br> Price <br>
                        <input type='text' name='pPrice'>
                        <br> Estimated Shipping Cost <br>
                        <input type='text' name='pShipCost'>
                        <br> Shipping Weight <br>
                        <input type='text' name='pWeight'>
                        <br> Notes <br>
                        <input type='text' name='pNotes' size=\"40\"> <br>
                        <br><br>
                        <table align='center' style=\"width:75%\">
                        <tr style=\"text-align:center;\">
                            <th> Description 1 </th>
                            <th> Description 2 </th>
                            <th> Description 3 </th>
                            <th> Description 4 </th>
                            <th> Description 5 </th>
                            <th> Description 6 </th>
                        </tr>
                        <tr style=\"text-align:center;\">
                            <td><input type='text' name='des1' size=\"30\"></td>
                            <td><input type='text' name='des2' size=\"30\"></td>
                            <td><input type='text' name='des3' size=\"30\"></td>
                            <td><input type='text' name='des4' size=\"30\"></td>
                            <td><input type='text' name='des5' size=\"30\"></td>
                            <td><input type='text' name='des6' size=\"30\"></td>
                        </tr>
                        </table>
                        <br><br>
                        <table align='center' style=\"width:75%\">
                        <tr style=\"text-align:center;\">
                            <th> Associated image filename 1 </th>
                            <th> Associated image filename 2 </th>
                            <th> Associated image filename 3 </th>
                            <th> Associated image filename 4 </th>
                        </tr>
                        <tr style=\"text-align:center;\">
                            <td><input type='text' name='aif1' size=\"35\"></td>
                            <td><input type='text' name='aif2' size=\"35\"></td>
                            <td><input type='text' name='aif3' size=\"35\"></td>
                            <td><input type='text' name='aif4' size=\"35\"></td>
                        </tr>
                        </table>
                        <br>                 
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


function updatePart($connection, $pID, $pName, $pNumber, $pSupplier, $pPrice, $pCategory,
                    $pShipCost, $pNotes, $des1, $des2, $des3, $des4, $des5,
                    $des6, $aif1, $aif2, $aif3, $aif4, $pWeight)
{
    $query = "UPDATE Allparts SET PartName='$pName', PartNumber='$pNumber', Suppliers='$pSupplier', Category='$pCategory',Description01='$des1',
             Description02='$des2',Description03='$des3',Description04='$des4',Description05='$des5',Description06='$des6', Price='$pPrice', `Estimated Shipping Cost`='$pShipCost',
              `Associated image filename1`='$aif1', `Associated image filename2`='$aif2', `Associated image filename3`='$aif3', `Associated image filename4`='$aif4', Notes='$pNotes', `Shipping Weight`='$pWeight' 
              WHERE PartID='$pID'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function addPart($connection, $pID, $pName, $pNumber, $pSupplier, $pPrice, $pCategory,
                 $pShipCost, $pNotes, $des1, $des2, $des3, $des4, $des5,
                 $des6, $aif1, $aif2, $aif3, $aif4, $pWeight)
{
    $query = "INSERT INTO Allparts VALUES('$pID', '$pName', '$pNumber', '$pSupplier', '$pCategory','$des1',
             '$des2','$des3','$des4','$des5','$des6', '$pPrice', '$pShipCost', '$aif1', '$aif2', '$aif3', '$aif4', '$pNotes', '$pWeight')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function existingPart($connection, $pID)
{
    $query = "SELECT * FROM Allparts WHERE PartID= '$pID'";
    $result = $connection->query($query);
    return mysqli_fetch_row($result);
}

