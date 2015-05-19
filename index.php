<?php
include('login.php');

if (isset($_SESSION['login_user'])) {
    header("location: user_profile.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ass</title>
        <link href="style/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="main">
            <div id="login">
                <h2>Login</h2>
                <form action="" method="post">
                    <label>UserName :</label>
                    <input id="name" name="username" type="text">
                    <br><br>
                    <label>Password :</label>
                    <input id="password" name="password" type="password">
                    <input name="submit" type="submit" value=" Submit ">
                    <span><?php echo $error; ?></span>
                    <br><br>
                    <div id="register"> Doesn't have account yet? Register <a href="register.php">here</a></div>
                </form>
            </div>
        </div>
    </body>
</html>