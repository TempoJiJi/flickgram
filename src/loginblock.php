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

<div class="login_container" id="reg">
<center><img src = "logo.png" height=70% width=70%>
<div class="fancy">
<form action="register.php">
  New Username:<br>
  <input type="text" name="user_name"><br>
  Password:<br>
  <input type="password" name="pass"><br>
  Re-enter Password:<br>
  <input type="password" name="pass2"><br>
  <br>
  <input type="submit" value="Register" name="submit">
</form>
</div>
</center>
</div>
</body>
</html>
