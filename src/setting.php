<html>
<head>
</head>
<body class="body1">
<?php
	session_start();
    $username = $_SESSION["username"]; //Get username
    echo $username;
    $directory = $username . "/";

    $servername = "localhost";
    $password = "abc123";
    $dbname = "flickg";

	$conn = new mysqli($servername, "root", $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// user_info : the table u want to access
	$sql = "SELECT * FROM user_info";
	$result = $conn->query($sql);
echo "30";
    if ($result->num_rows > 0) {
    	echo "20";
    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	echo "10";
			if ($username == $row["name"]) {
				echo "0";
				if($row["style"] == 0){
					$sql = "UPDATE user_info SET style=1 WHERE name=\"". $username. "\";";
					$conn -> query($sql);
					header("Location:pageori.php?user=" . $username);
				}
				else if($row["style"] == 1){
					$sql = "UPDATE user_info SET style=0 WHERE name=\"". $username. "\";";
					$conn -> query($sql);
					header("Location:page.php?user=" . $username);
				}
			}
	    }
	}
	$conn -> close();
?>

</body>
</html>
