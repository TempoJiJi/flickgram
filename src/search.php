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
$username = $_GET["search_name"];

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	if ($username == $row["name"])
	    $check = 1;
    }
}

if ($check == 1) {
    $conn->close();
    session_start();
    $_SESSION["username"] = $username;
    header("Location:page.php?user=".$username);
} else {
    echo $username . " does not exists!<br>";
}

?>

</body>
</html>
