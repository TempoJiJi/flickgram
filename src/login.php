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
	if ($username == $row["name"]) {
	    if ($_GET["pass"] == $row["pass"]) {
		session_start();
		$_SESSION["username"] = $username;
		if ($row["style"]==0) {
		    header("Location:pageori.php?user=" . $username);
		}
		else if($row["style"]==1) {
		    header("Location:page.php?user=" . $username);
		}
	    }
	}
    }
}

echo "Username or Password incorrect!<br>";

$conn->close();

?>

</body>
</html>
