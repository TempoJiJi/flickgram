<?php
session_start();
$username = $_SESSION["username"];
$target_dir = $username . "/";

$target_file = $target_dir . basename($_FILES["uploadf"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$text = $_POST["caption"];
$c_file = $target_dir . "caption.txt";

$caption_file = fopen($c_file, "a") or die ("Unable to open the file!");

$caption = basename($_FILES["uploadf"]["name"]) . " " . $text . "\n";

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

$check = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	if ($username == $row["name"])
	    break;
    }
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if($imageFileType != "jpg" && $imageFileType != "png" 
	&& $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
	if (move_uploaded_file($_FILES["uploadf"]["tmp_name"], $target_file)) {
	    fwrite($caption_file, $caption);
	    fclose($caption_file);
	    if ($row["style"] == 0) 
		header("Location:pageori.php?user=".$username);
	    if ($row["style"] == 1)
		header("Location:page.php?user=".$username);
	} else {
	    echo "Sorry, there was an error uploading your file.";
	}
    }
}
?>
