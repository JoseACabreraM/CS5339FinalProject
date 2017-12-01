<?php
include_once 'dbConnStore.php';

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="/path/to/jquery-latest.js"></script>
    <script type="text/javascript" src="/path/to/jquery.tablesorter.js"></script>
    <meta charset="UTF-8">
    <title>Car Part To Sell</title>
</head>
<body style='background-color:lightgray;'>


</body>
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
       <thead>
       <tr class="header">
           <th <strong>Part ID</strong></a></th>
           <th <strong>Part Name</strong></a></th>
           <th><strong>Image</strong></th>
           <th <strong>Price</strong></a></th>
       </tr>
       </thead>


<?php

$sql = "SELECT PartID, PartName, Associated_Image1, Price FROM parts";// ORDER BY Price";

  /*if($_POST['value'] == 'Part ID') {
    $sql .= "ORDER BY PartID";
}
elseif ($_GET['value'] == 'Part Name'){
    $sql.="ORDER BY PartName";
}
elseif ($_GET['value'] == 'Price'){
    $sql.="ORDER BY Price";
}*/
$result = $conn2->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
   //while($row = mysqli_fetch_array($result)){
        $image = $row["Associated_Image1"];
        ?>
        <tr>
           <td><?php echo $row['PartID'];?></td>
            <td><?php echo $row['PartName'];?></td>
            <td><?php echo "<img src='partimages/$image' style= width: ; height=\"90px\">";?></td>
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