<?php require_once ('include/db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login on Twitter</title>
	<link rel="shortcut icon" type="image/png" href="images/icons/favicon.png">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">
</head>
<body style="background-color: #E6ECF0;">
	<header>
		<nav>
			<ul>
				<li><a href="#"><img id="logo" src="images/bird-icon.png"></a></li>
				<li><a href="#"><div>Home</div></a></li>
				<li><a href="#"><div id="about">About</div></a></li>
			</ul>
		</nav>
	</header><hr>
	
<!-- ********** body start ********** -->
	<?php			
		session_start();
		if(isset($_POST['login'])){
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			$check_query = "SELECT * FROM users WHERE name = '$name' ";
			$check_run = mysqli_query($conn, $check_query);
			if (mysqli_num_rows($check_run) > 0){
				$row = mysqli_fetch_array($check_run);

				$db_id = $row['id'];
				$db_name = $row['name'];
				$db_password = $row['password'];
				$db_contact = $row['contact'];
				$db_profile_img = $row['profile_img'];
				if($name == $db_name && $password == $db_password){
					$_SESSION['id'] = $db_id;
					$_SESSION['name'] = $db_name;
					$_SESSION['profile_img'] = $db_profile_img;
					header('Location: home.php');
				}
				else {
					$error = "User name and password miss matched";
				}
			}
			else {
				$error = "Invalid user name or password!";
			}
		}
	?>
	<div id="login">
		<div class="center">
			<form method="post" action="login.php">
				<h1>Log in to Twitter</h1>
			    <input type="text" placeholder="Phone, email or username" name="name" required style="width: 280px;">
			    <input type="password" placeholder="Password" name="password" required style="width: 280px;">
			    <?php
			    	if (isset($error)) {
			    		echo "<span style='color:red'>$error</span>";
			    	}?>
			    <div style="display: flex; margin-top: 26px;">
			    	<button name="login" id="login-button">Login</button>
			    	<input style="margin: 20px 0 0 15px;" type="checkbox" name="checkbox"><span>Remember me.<a href="#">Forgot password?</a></span>
			    </div>
			</form>
		</div>
		<div id="footer">
			<div id="footer-body">
				<div style="display: flex;">
					<p>New to Twitter?</p>
					<a href="#">Sign up Now »</a>
				</div>
				<div style="display: flex;">
					<p>Already using Twitter via text message?</p>
					<a href="#">Activate your account »</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>