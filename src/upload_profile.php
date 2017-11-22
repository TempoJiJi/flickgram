<?php
session_start();
$username = $_SESSION["username"];
$target_dir = $username . "/";

$target_file = $target_dir . basename($_FILES["uploadf"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Set upload filename to "profile_pic"
$target_file = $target_dir . "profile_pic." . $imageFileType;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if($imageFileType != "jpg" && $imageFileType != "png" 
	&& $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	echo $imageFileType."<br>";
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
	session_start();
	$username = $_SESSION["username"]; //Get username
	$directory = $username . "/";
	$images = glob($directory . "*.*");
	$profile_pic = "";
	// Get the old profile picture and delele it 
	foreach($images as $image) {
	    $tmp_path = pathinfo($image);
	    if ($tmp_path['filename'] == "profile_pic") {
		$profile_pic = $image;	// found profile pic
	    }
	}
	unlink($profile_pic);	//Delete old profile pic
	if (move_uploaded_file($_FILES["uploadf"]["tmp_name"], $target_file)) {	    
	    header("Location:page.php?user=".$username);
	} else {
	    echo "Sorry, there was an error uploading your file.";
	}
    }
}
?>
