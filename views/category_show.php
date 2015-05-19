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

$sql = "SELECT * FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     echo "<table><tr><th>Name</th><th>ID</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["category_name"]. "</td><td>" . $row["category_id"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$conn->close();
?>