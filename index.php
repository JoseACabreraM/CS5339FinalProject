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

<p><b>Filtering</b> </p> <select name='value'>
    <option value='Tire'>Tire</option>
    <option value='Piston'>Piston</option>
    <option value='Alternator'>Alternator</option>
</select> <br><br>


   <table id="myTable"> <!-- width="70%" cellpadding="5" cellspace="5"-->
       <tr>
           <th onclick="sortTable(0)"><strong>Part ID</strong></th>
           <th onclick="sortTable(1)"><strong>Part Name</strong></th>
           <th><strong>Image</strong></th>
           <th onclick="sortTable(2)"><strong>Price</strong></th>
       </tr>


<?php
$sql = "SELECT PartID, PartName, Associated_Image1, Price FROM parts";
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

   <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y,shouldSwitch,dir, switchCount =0;
            table = document.getElementById("myTable");
            switching = true;
            dir = "asc";
            while (switching){
                switching = false;
                rows = table.getElementsByTagName("TR");
                for(i=1; i< (rows.length -1); i++){
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i+1].getElementsByTagName("TD")[n];
                    if(dir == "asc"){
                        if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                            shouldSwitch = true;
                            break;
                        }
                    }
                    else if (dir =="desc"){
                        if(x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()){
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if(shouldSwitch){
                    rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
                    switching = true;
                    switchCount ++;
                }
                else{
                    if(switchCount == 0 && dir =="asc"){
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>

