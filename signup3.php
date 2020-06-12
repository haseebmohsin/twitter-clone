<?php require_once ('include/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="CSS/signup3.css">
</head>
<body>
	<?php
		session_start();
				
		if(isset($_POST['submit'])){
			$name = $_SESSION['name'];
			$contact = $_SESSION['contact'];
			$password = $_SESSION['pwd'];

			$image = $_FILES['image']['name'];
			$image_tmp = $_FILES['image']['tmp_name'];

			$check_query = "SELECT * FROM users WHERE contact = '$contact' ";
			$check_run = mysqli_query ($conn, $check_query);
				if(empty($name) or empty($contact) or empty($password) ) {

					$error = "Please fill the empty fields";
				}

				else if (mysqli_num_rows($check_run) > 0) {

					$error = "This number is already registered";
				}

				else {
					$insert_query = " INSERT INTO `users` (`id`, `name`, `contact`, `password`, `profile_img`) VALUES (NULL, '$name', '$contact', '$password', '$image') ";
				
				if (mysqli_query($conn, $insert_query)) {
					move_uploaded_file($image_tmp, "images/profile_pics/$image");
					
					session_unset();
					session_destroy();
					header('Location: login.php');
				}
				else {
					$error = "Something went wrong";
				}
			}
		}
	?>
	
	<form method="post" enctype="multipart/form-data">
	<div class="form">
		<header>
		
			<div class="head">
			<img  src="images/blue_bird.png">
			<input id="btn" name="submit" type="submit">
			</div>
		</header>
	<h1>Pick a profile picture</h1>
	<p style="margin-left: 25px;">Have a favorite selfie? Upload it now.</p>
	
		<div class="image-upload">
		  <img id="profile" src="images/profile.png"><br><br><br>
		  <?php

	    		if (isset($error)) {
	    			echo "<span style='color:red; margin-left:25px;'>$error</span>";
	    		}

	    	?>
		  <label for="file-input">
		    <img id="camera" src="images/camera.png" name="image">
		  </label>

		  <input id="file-input" type="file" name="image">
		</div>
	</form>
	
	</div>
</body>
</html>