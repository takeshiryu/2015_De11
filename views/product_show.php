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

$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     echo "<table><tr><th>ID</th><th>Name</th><th>Price</th><th>Sale Rate</th><th>Image</th><th>Info</th><th>URL</th><th>Time</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["product_id"]. "</td><td>" . $row["product_name"]. "</td><td>" . $row["price"]. "</td><td>" . $row["sale_rate"]. "</td>
		 <td>" . $row["image_link"]. "</td><td>" . $row["product_info"]. "</td><td>" . $row["url_name"]. "</td><td>" . $row["time_insert"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$conn->close();
?>