<?php
$s = $_REQUEST["q"];
$user_name = strtok($s, "/");
$img_name = strtok("/");

$file_dir = $user_name . "/caption.txt";
$file = fopen($file_dir, "r") or die ("Unable to open caption.txt");

if ($file) {
    while (($line = fgets($file)) != false) {
        $u = strtok($line, " ");
        $caption = strtok(" ");
	if ($u == $img_name) {
	    echo $caption;
	    break;
	}
    } 
}
fclose($file);
?>
