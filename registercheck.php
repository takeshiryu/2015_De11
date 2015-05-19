<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'wd_ass');
define('DB_USER','root');
define('DB_PASSWORD','');

$conn=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
$db=mysql_select_db("wd_ass", $conn);
if (!$conn) {
    die("Connection failed: " . mysql_error($conn));
}
$error=''; 

function NewUser() {
	$userName = $_POST['user'];
	$password = $_POST['pass'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$adr = $_POST['address'];
	$dec = $_POST['desc'];
	$query = "INSERT INTO user VALUES ('$userName','$password','0','$email','$phone','$adr','$dec')";
	$data = mysql_query ($query) or die(mysql_error());
	if($data) {
		$error = "Your registration is completed!";
	}
}
function SignUp() {
	if(!empty($_POST['user'])) {
		$query = mysql_query("SELECT * FROM user WHERE username = '$_POST[user]' AND password = '$_POST[pass]'") or die(mysql_error());
		if(!$row = mysql_fetch_array($query) or die(mysql_error())) {
			NewUser();
		}
		else {
			$error = "You're already registered user!";
		}
	}
}
if(isset($_POST['submit'])) {
	if (empty($_POST['user'])) {
		$error = "Username can't be blank!";
	}
	else {
		if (empty($_POST['pass'])) {
			$error = "Password can't be blank!";
		}
		else {
			if ($_POST['cpass']!=$_POST['pass']) {
				$error = "Password confirm doesn't match!";
			}
			else {

				$query = mysql_query("SELECT * FROM user WHERE username = '$_POST[user]' AND password = '$_POST[pass]'", $conn);
				echo "SELECT * FROM user WHERE username = '$_POST[user]' AND password = '$_POST[pass]'";
				$rows = mysql_num_rows($query);
				if($rows==0) {
					$userName = $_POST['user'];
					$password = $_POST['pass'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$adr = $_POST['address'];
					$dec = $_POST['desc'];
					$query = "INSERT INTO user VALUES ('$userName','$password','0','$email','$phone','$adr','$dec')";
					$data = mysql_query($query);
					if ($data) {
						$error = "Your registration is completed!";
					}
					else {
						echo "Error: " . $query . "<br>" . mysql_error($conn);
					}
				}		
				else {
					$error = "You're already registered user!";
				}
				mysql_close($conn);
			}
		}
	}
}
?>