


<?php
	session_start();
	header("Cache-Control: no-cache, no-store, must-revalidate");
	$username = "Dummy";
	
	if ( isset($_SESSION["user"])) {
		$username = $_SESSION["user"];
		include("login_header.php");
	}
    $id=$_GET['id'];
	$conn = mysqli_connect("localhost", "root", "");
	mysqli_select_db($conn, "ita");
	$sql = "SELECT * FROM orders WHERE username LIKE '$username' and pid='$id'";
	if (!$result = $conn->query($sql)) {
		echo '<br><font face="verdana" color="blue" size="6"><b>You have not purchased any product to write a review!!<b></font>';
		echo '<br><br><img src="images/sad.jpg" height="200px" width="200px" align="center"/><br><br>';
		echo '<h2><a href="sign-out.php"><font face="helvetica" color="red">LOGOUT</font></a></h2>';
	}
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<TITLE>Review Product</TITLE>
<link href="imageStyles.css" rel="stylesheet" type="text/css" />
<style>
div.box  {
	width: 500px;
	height: auto;
	border-style: solid;
	border-radius: 15px;
	border-color: grey;
	padding: 20px;
	margin: 5px;
	
	background-color: #d6ebd9;
}

div.box img {
	width: 200px;
	height: 200px;
	margin-right: 10px;
	-webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.5s;
    text-align: right;
    align-content: right;
    align-items: right;
}

div.box img:hover {
	transform: scale(1.2);
}

div.box h3 {
	text-align: center;
	font-family: arial;
	padding-top: 20px; 
}
div.box h4 {
	text-align: center;
	font-family: arial;
	padding-top: 20px; 
}

div.box input {
	margin-top: 10px;
	margin-bottom: 10px;
	background-color: #4CAF50;
	-webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

div.box input:hover {
	background-color: #367477; 
    color: white;	
}

div.box textarea {
	width: 420px;
}

.gallery {
	width: 200px;
	height: 200px;
	padding: 35px;
}

body {
	background-image: url(images/background1.jpg) ;
	text-align: center;
}

</style>
<style>
.rating {
    display: inline-block;
    direction: rtl; /* Add this line to set right-to-left direction */
}

.rating input[type="radio"] {
    display: none;
}

.rating label {
    font-size: 25px;
    color: gray;
    cursor: pointer;
    transition: color 0.2s;
}

.rating label:before {
    content: "★";
    padding: 5px;
}

.rating input[type="radio"]:checked ~ label {
    color: orange;
}

    </style>
</HEAD>
<BODY>
	<br><br>
	<div class="main">
		<table align="center">
			<?php
			
				$i = 0;
				if ($result = $conn->query($sql)) {
					while ($row = mysqli_fetch_assoc($result)) {
						$pid = $row['pid'];
						if ($i % 2 == 0) {
							echo "<tr>";
						}

						$prod = "SELECT * FROM products WHERE pid='$pid'";
						$res = mysqli_query($conn, $prod);
						$row1 = mysqli_fetch_array($res);

						$category = "";
			if($pid[0]==1)
				$category = "men";
			else if($pid[0]==2)
				$category = "women";
			else if($pid[0]==3)
				$category = "books";
			else if($pid[0]==4)
				$category = "gadgets";
			else if($pid[0]==5)
				$category = "sports";

						$pname = $row['pname'];
						$email = $row['email'];

						echo "<td><div class='box'><img src='images/{$category}/{$row1[4]}' alt='{$row['pid']}'>
						<h4><b>{$row['pname']}<b></h4>
						<br>
						<form action='review-submit.php?pid=$pid&pname=$pname&email=$email&username=$username' method='post'>
						<textarea name='comment' rows='5' cols='40'></textarea><br>";
						

						// Star rating section
						?>
						 <div class="rating">
            <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
        </div><br>

					<?php
					
						echo "<input type='submit' class='btn btn-primary' align='center' name='submit' value='Submit Review'></form></div></td>";
						if ($i % 2 == 1) {
							echo "</tr>";
						}
						$i++;
					}
				}
			?>
		</table>
	</div>
	<br><br><br><br><br><br><br>
</BODY>
</HTML>

<?php
	include("footer.php");
?>
