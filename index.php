<?php
include_once 'dbConnStore.php';

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Part To Sell</title>
</head>
<body style='background-color:lightgray;'>
<div align='center'><h1> AutoParts  </h1></div>
<style>
    th {
        cursor: pointer;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .link {
        margin: 10px 10px 10px 10px;
        padding: 10px 10px 10px 10px;
    }
</style>
<div align='center'>
    <h3> THESE ARE THE PARTS TO SELL <br></h3>
    <h4> To buy any part you must login first</h4>
    <a href="login.php" class="link"> Login </a>
    <a href="addUser.php" class="link">      Register </a>
    <div align='left'>


<form name='form1' method='post' action='searchResult.php'>
            <input name='search' type='text' size='40' maxlength='70'>
            <input name='submit' type='Submit' value='Search'>
        </form>

    <p><b>Order By</b> </p>
    <form action="orderBy.php" method="post">
        <select name='value'>
            <option value='Price'>Price</option>
            <option value='PartName'>Part Name</option>
            <option value='PartID'>Part ID</option>
        </select> <br>
        <input name="Order" type="submit" value="Order"><br>
    </form>


   <table id="myTable"> <!-- width="70%" cellpadding="5" cellspace="5"-->
       <tr>
           <th> <strong>Part ID</strong></th>
           <th> <strong> Part Name</strong></th>
           <th> <strong>Image</strong></th>
           <th> <strong>Price</strong></th>
       </tr>


<?php
//$sql = "SELECT PartID, PartName, Associated image filename1, Price FROM Allparts";
$sql = "SELECT PartID, PartName, Associated image filename1, Associated image filename2, Associated image filename3, Associated image filename4 Price FROM Allparts ORDER BY Price ASC";

$result = $conn2->query($sql);

if ($result->num_rows > 0 ){//&& $resultImage-> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image = $row["Associated image filename1"];?>
        <tr>
            <td><?php echo $row['PartID'];?></td>
            <td><?php echo $row['PartName'];?></td>
            <td><?php echo "<img src='partimages/$image' style= width: 80px; height=\"90px\">";?></td>
            <td><?php echo $row['Price'];?></td>
       </tr>

    <?php }
    }
    else {
        echo "NO PARTS TO SELL";
    }?>
     </table>
</div>
</div>

</html>
