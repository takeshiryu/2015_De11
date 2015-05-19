<style>
table, th, td {
     border: 1px solid black;
}
</style>
<?php
$dbserver = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'wd_ass';

$conn = new mysqli($dbserver,$dbuser,$dbpass,$dbname);
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM bill";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     echo "<table><tr><th>ID</th><th>Time</th><th>Username</th><th>Total</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["bill_id"]. "</td><td>" . $row["bill_time"]. "</td><td>" . $row["username"]. "</td><td>" . $row["Total"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$conn->close();
?>