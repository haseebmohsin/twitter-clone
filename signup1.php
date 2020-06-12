<?php require_once ('include/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="CSS/signup2.css">
	<title></title>
</head>
<body>

	<?php 
		if (isset($_POST['submit'])) {
			session_start();

			$name = $_POST['name'];
			$contact = $_POST['phone'];
			if(empty($name) or empty($contact) ) {
				$error = "Please fill the empty fields";
			}
			else{
				$_SESSION['name'] = $name;
				$_SESSION['contact'] = $contact;
				header("location: signup2.php");
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

	<h1>Create your account</h1>

	<?php

    	if (isset($error)) {
    		echo "<span style='color:red; margin-left:25px;'>$error</span>";
    	}

    ?>

	<div class="textbox">

	<input type="text"  name="name" placeholder="Name" width="200px"><br>
	</div>
<div class="textbox">
	<input type="text" name="phone" placeholder="Phone"><br>
</div>

<a href="">Use email instead</a>
</form>
	</div>

</body>
</html>