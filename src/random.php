<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="pageori_theme.css">
<style>
body {
    background: url("./background.jpg");
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

<br>

<!-- Search other user -->
<form action="search.php">
 <div class=imgs onclick="location.href='pageori.php';"><img src = "logo.png" height=30% width=30%></div>
  <div class=searchs>
    <input type="text" name="search_name" class="stest" placeholder="Search..">
    <input type="submit" value="search" name="submit">
  </div>
</form>

<br>

<!-- Show user photo -->
<div align="center">
 <div class="show">
    <?php 
	session_start();
	$username = $_SESSION["username"];  //Get username
	$servername = "localhost";
	$password = "abc123";
	$dbname = "flickg";

	$conn = new mysqli($servername, "root", $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM user_info";
	$result = $conn->query($sql);

	$r = rand() % $result->num_rows;
	$count = 0;
	$i = 0;
	$x = 0;
	while(1) {
	 if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
	    if ($count < $r) { 
		$count++;
		continue;
	    }
	    if ($username == $row["name"]) {
		continue;
	    }
		
	    $directory = $row["name"] . "/";
	    $images = glob($directory . "*.*");

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
		    break;
		}
		if($i > 15)
		    break;
	     }
	    }
	    if($i < 15) {
		$r = rand() % $result->num_rows;
		$count = 0;
		$result = $conn->query($sql);
	    }
	    else break;
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

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == img_modal) {
        img_modal.style.display = "none";
    }
}


</script>

</body>
</html>
