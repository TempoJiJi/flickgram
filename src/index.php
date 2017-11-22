<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="login_theme.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<div class = "bgimg">
<body>

<?php
$i = 0;
?>

<div class="login_container">
<center><img src = "logo.png" height=70% width=70%>
<div class="fancy">
<form action="login.php">
  Username:<br>
  <input type="text" name="user_name"><br>
  Password:<br>
  <input type="password" name="pass"><br>
  <br>
  <input type="submit" value="Login" name="submit">
  <a href ="loginblock.php">Didn't have an account?</a>
</form>   
</div>
</center>
</div>
</body>

</html>
