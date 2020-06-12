<?php require_once ('include/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="CSS/signup2.css">
</head>
<body>
	<?php 
		session_start();
		if (isset($_POST['submit'])) {
			$password = $_POST['pwd'];
			if(empty($password) ) {
				$error = "Please provide a password";
			}
			else{
				$_SESSION['pwd'] = $password;
				header("location: signup3.php");
			}
		}
	?>
	<form method="post">
	<div class="form">
	<header>
		<div class="head">
		<img  src="images/blue_bird.png">
		<input id="btn" name="submit" type="submit">
	</div>
	</header>
	
	<h1>You'll need a password</h1>
	<p>make sure it's 6 character or more.</p>
	<?php

    	if (isset($error)) {
    		echo "<span style='color:red; margin-left:25px;'>$error</span>";
    	}

    ?>
	<div class="textbox">
	
	<input type="password"  name="pwd" placeholder="password" width="200px"><br>
	</div>

	<a href="">Reveal password</a>
	</div>
</form>
</body>
</html>