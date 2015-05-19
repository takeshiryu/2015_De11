<?php
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="profile">
<b id="welcome">Welcome : <i><?php echo $login_session; ?></i></b>
<b id="logout"><a href="logout.php">Log Out</a></b>
<ul>
<li><a href='views/product_show.php'>List products</a></li>
<li><a href='views/bill_show.php'>List bills</a></li>
<li><a href='views/category_show.php'>List categories</a></li>
<li><a href='views/user_show.php'>List users</a></li>
</ul>
</div>
</body>
</html>