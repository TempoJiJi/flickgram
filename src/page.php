<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="page_theme.css">
<style>
body {
    background: url("./background_1.jpg");
    background-position: center top;
    background-size: 100% auto;
}
</style>
</head>

<body>

<div class="rand">
<form id="random" action="random.php">
 <input type="submit" value="Random">
</form>
</div>

<?php
    $_SESSION["username"] = $username;
    echo "<div class=\"set\">";
    echo "<form action=\"setting.php?user=\">";
    echo "<input type=\"submit\" value=\"modal\" name=\"\">";
    echo "</form><br>";
    echo "</div>";
?>

<!-- Upload photo with caption here -->
<button id="UpBtn" class="upbtn">Upload</button>

<div id="UpModal" class="modal">
 <div class="upmodal-content">
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploadf"><br>
    <input type="text" name="caption" value="Write a caption..." style="color:#888;"
		onfocus="inputFocus(this)" onblur="inputBlur(this)"/><br>
    <input type="submit" value="Upload" name="submit">
  </form>
 </div>
</div>

<!-- Upload profile pic without caption -->
<div id="UpPModal" class="modal">
 <div class="upmodal-content">
  <form action="upload_profile.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploadf"><br>
    <input type="submit" value="Upload Profile Picture" name="submit">
  </form>
 </div>
</div>
<br>

<!-- Search other user -->
<form action="search.php">
 <div class=imgs><img src = "logo.png" height=30% width=30%></div>
  <div class=searchs>
    <input type="text" name="search_name" class="stest" placeholder="Search..">
    <input type="submit" value="search" name="submit">
  </div>
</form>

<br>

<!-- Show current page username -->
<div class="username">
<?php
    session_start();
    $username = $_SESSION["username"]; //Get username
    echo "<p>" . $username . "</p>";
?>
</div>

<!-- Show current page user profile pic -->
<div class="prof_pic" id="UpPBtn">
<?php
    /* Search profile picture from dir */
    session_start();
    $username = $_SESSION["username"]; //Get username
    $directory = $username . "/";
    $images = glob($directory . "*.*");
    foreach($images as $image) {
    $tmp_path = pathinfo($image);
    if ($tmp_path['filename'] == "profile_pic") {
        echo "<img src=". $image . " />";
    }
    }
?>
</div>
<br>

<!-- Show user photo -->
<div align="center">
 <div class="show">
    <?php 
	session_start();
	$username = $_SESSION["username"];  //Get username
	$directory = $username . "/";
	$images = glob($directory . "*.*");
	$x = 0;
	$i = 0;
	foreach($images as $image) {
	    $image = preg_replace("/\s+/", "%20", $image);
	    $tmp_path = pathinfo($image);
	    /* display all the image from dir except profile pic */
	    if ($tmp_path['filename'] != "profile_pic" && $tmp_path['filename'] != "caption") {
		//<img id="myImg_0" src=admin/123.jpg onclick="modal_show(0)"/>
		echo "<img id=\"myImg_" . $i . "\" src=". $image . 
			" onclick=\"modal_show(" . $i . ")\"/>";
		$x++;
		$i++;
		if ( ($x%4) == 0 )
		    echo "<br>";
	    }
	}
    ?>
 </div>
</div>


<div id="PicModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>

/*--- Image modal Here ---*/
var img_modal = document.getElementById("PicModal");
var captionText = document.getElementById("caption");
function modal_show(n) {
    // Get the image and insert it inside the modal
    var myImg = "myImg_" + n; //detect which img was clicked
    var img = document.getElementById(myImg);
    var modalImg = document.getElementById("img01");
    var str = String(img.src);	// Get img.src
    var a = str.split("/");	// Split str
    var tmp = a.length;
    var img_name = a[tmp-2];	// Get the img name for caption
    img_name += "/";    
    img_name += a[tmp-1];
    var xmlhttp = new XMLHttpRequest();
    /* Try to get caption from server by AJAX */
    xmlhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
	    img_modal.style.display = "block";	// Show image
	    modalImg.src = img.src;
	    captionText.innerHTML = a[tmp-2] + ":  " + this.responseText;	// Show caption below
	}
    };
    /* Send request to server */
    xmlhttp.open("GET", "getcaption.php?q=" + img_name, true);
    xmlhttp.send();
    // Get the <span> element that closes the modal
    var img_span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    img_span.onclick = function() { 
	img_modal.style.display = "none";
    }
}



/*--- Upload modal Here ---*/
// Get the modal
var modal = document.getElementById("UpModal");	// Normal pic
var modal_p = document.getElementById("UpPModal"); // Profile pic
// Get the button that opens the modal
var btn = document.getElementById("UpBtn"); // Nomral button
var btn_p = document.getElementById("UpPBtn"); // Profile pic button
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}
btn_p.onclick = function() {
    modal_p.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    modal_p.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    else if (event.target == modal_p) {
	modal_p.style.display = "none";
    }
    else if (event.target == img_modal) {
        img_modal.style.display = "none";
    }
}

function inputFocus(i){
    if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
}
function inputBlur(i){
    if(i.value==""){ i.value=i.defaultValue; i.style.color="#888"; }
}


</script>

</body>
</html>
