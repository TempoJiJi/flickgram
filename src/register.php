<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="theme.css">
</head>

<body>

<?php
/* Change your database info here
    $username : database login user name
    $password : database login password
    $dbname : the database u want to access
*/
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "flickg";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// user_info : the table u want to access
$sql = "SELECT * FROM user_info";
$result = $conn->query($sql);

$check = 0;
$username = $_GET["user_name"];

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	if ($username == $row["name"])
	    $check = 1;
    }
}

if ($_GET["pass"] != $_GET["pass2"]){
    echo "<div class='login_container'><center><img src ='logo.png' height=70% width=70%><div class='fancy'>The password you type are not same!<form action='index.php'><input type='submit' value='Back' name='submit'></form></div></center></div>";
    $check = 2;
}

if ($check == 0) {
    $sql = "INSERT INTO `user_info` (`id`,`name`,`pass`, `style`) 
	    VALUES (NULL,\"" . $username. "\",\"" . $_GET["pass"] . "\", 0)";
    if ($conn->query($sql) === TRUE) {
	$dir = __DIR__ . "/" . $username;
	$profile_pic = "profile_pic.png";
	$oldmask = umask(0);
	mkdir($dir, 0777, true);
	umask($oldmask);
	copy($profile_pic, $dir . "/" . $profile_pic);
	echo "<div class='login_container'><center><img src ='logo.png' height=70% width=70%><div class='fancy'>Register successfully<form action='index.php'><input type='submit' value='Back' name='submit'></form></div></center></div>";
    } else {
	echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else if($check==1){
    echo "<div class='login_container'><center><img src ='logo.png' height=70% width=70%><div class='fancy'>". $username . " already exists<form action='index.php'><input type='submit' value='Back' name='submit'></form></div></center></div>";
}

$conn->close();

?>

</body>
</html>
