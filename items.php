<?php
require "button.php";
require_once 'connection.php';
$query = "SELECT * FROM Parts";

$result = $conn->query($query);
if(mysqli_num_rows($result) > 0): ?>
    <table border="1">
        <tr>
            <th>Part ID</th>
            <th>Part Name</th>
        <tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['PartID']; ?></td>
            <td><?php echo $row['PartName']; ?></td>
            <td><?php $button = new button($row['PartID']); print $button->html ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>