<?php
include_once 'dbConnStore.php';

if(!isset($_POST['search'])){
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body style='background-color:lightgray;'>
<div align='center'><h1> Search Results </h1></div>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<table id="table" width="70%" cellpadding="5" cellspace="5">
       <tr>
           <td><strong>Part ID</strong></td>
           <td><strong>Part Name</strong></td>
           <td><strong>Image</strong></td>
           <td><strong>Price</strong></td>
       </tr>
    <?php
$search_sql="Select * FROM Allparts where PartName LIKE '%".$_POST['search']."%'  or Description01 LIKE '%".$_POST['search']."%' or Description02 LIKE '%".$_POST['search']."%' or Description03 LIKE '%".$_POST['search']."%'
or Description04 LIKE '%".$_POST['search']."%' or Description05 LIKE '%".$_POST['search']."%' or Description06 LIKE '%".$_POST['search']."%'";
$result = $conn2->query($search_sql);
$sql = "SELECT Associated image filename1, Associated image filename2, Associated image filename3, Associated image filename4 Price FROM Allparts ORDER BY Price ASC";
$resultImage = $conn2->query($sql);
echo '<a href="index.php"> New Search </a>'."<br>";
?>
    <?php
if ($result->num_rows > 0 ){//&& $resultImage-> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
         $image = $row["Associated image filename1"];?>
    <tr>
        <td><?php echo $row['PartID'];?></td>
        <td><?php echo $row['PartName'];?></td>
        <td><?php echo "<img src='partimages/$image' style= width: 80px; height=\"90px\">";?></td>
        <td><?php echo $row['Price'];?></td>
    </tr>
     <?php
    }
}
else{
    print"<h2> NO RESULT FOUND</h2>";
}