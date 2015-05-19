<?php
include('registercheck.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<title>Register</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<div id="Signup">
<fieldset><legend><h2>Registration Form</h2></legend>
<div id="required">* required field</div>
<br><br>
<form method="POST" action="">
<label>Username*: </label>
<input type="text" name="user">
<br><br>
<label>Password*: </label> 
<input type="password" name="pass">
<br><br>
<label>Confirm Password*: </label> 
<input type="password" name="cpass">
<br><br>
<label>Email: </label> 
<input type="text" name="email">
<br><br>
<label>Phone: </label> 
<input type="text" name="phone">
<br><br>
<label>Address: </label>
<input type="text" name="address">
<br><br>
<label>Description: </label>
<input type="text" name="desc">
<br><br>
<span><?php echo $error; ?></span>
<br><br>
<input class="regsubmit" id="button" type="submit" name="submit" value="Submit">
</form>
</fieldset>
</div>
</body>
</html>