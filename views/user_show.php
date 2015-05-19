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

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     echo "<table><tr><th>Username</th><th>Role</th><th>Email</th><th>Phone</th><th>Address</th><th>Info Link</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["username"]. "</td><td>" . $row["role"]. "</td><td>" . $row["email"]. "</td>
		 <td>" . $row["phonenumber"]. "</td><td>" . $row["address"]. "</td><td>" . $row["thumnail_link"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$conn->close();
?>