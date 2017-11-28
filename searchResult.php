<?php
include_once 'includes/dbconnectStore.php';

if(!isset($_POST['search'])){
    header("Location:index.php");
}

$search_sql="Select * FROM parts where PartName LIKE '%".$_POST['search']."%' or Description01 LIKE '%".$_POST['search']."$'";
$result = $conn2->query($search_sql);
$sql = "SELECT Associated_Image1, Price FROM parts";
$resultImage = $conn2->query($sql);
echo "THESE ARE THE PARTS TO SELL <br><br>";
echo '<a href="utep.php"> New Search </a>'."<br>";
// echo $result."heloo <br>";
if ($result->num_rows > 0 && $resultImage-> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo " - PART#: " . $row["PartID"] . " PART NAME: " . $row["PartName"];
        $image = $row["Associated_Image1"];
        echo " Imagen of the item: <img src= 'partimages/$image' style=\"width:80px;height:80px;\">";
        echo "PRICE $" . $row["Price"] . "<br>"; // . "<br>"
    }
}