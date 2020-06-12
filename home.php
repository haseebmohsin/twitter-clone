<?php require_once ('include/db.php'); ?>
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title title="Home / Twitter">Home / Twitter</title>
	<link rel="stylesheet" type="text/css" href="CSS/home.css">
	<link rel="shortcut icon" type="image/png" href="images/icons/favicon.png">
</head>
<body>
	<div id="container">
		<div id="col-1">
			<nav>
				<div id="header-icon">
					<img src="images/icons/bird-icon.png">
				</div>

				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/home-icon.png">
						<span>Home</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/explore-icon.png">
						<span>Explore</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/notifications-icon.png">
						<span>Notifications</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/messages-icon.png">
						<span>Messages</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/bookmarks-icon.png">
						<span>Bookmarks</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/lists-icon.png">
						<span>Lists</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<?php 
							if (isset($_SESSION['id'])) {
								$profile_img = $_SESSION['profile_img'];
							
								echo "<img src='images/profile_pics/".$profile_img."'>";
							}
						?>
						<span>Profile</span>
					</div>
				</a>
				<a href="#">
					<div class="nav-icons-and-text">
						<img src="images/icons/more-icon.png">

						<div class="dropdown">
							<span onclick="myFunction()">More</span>
							<div id="myDropdown" class="dropdown-content">
								<a href="logout.php">Logout</a>
							</div>
						</div>

						<script type="text/javascript">
							function myFunction() {
								document.getElementById('myDropdown').classList.toggle("show");
							}
						</script>

					</div>
				</a>
			</nav>

			<input id="col-1-tweet-button" type="button" name="tweet" value="Tweet">

		</div>   <!-- col-1 ----- End -->

		<div id="col-2">
			<div id="col-2-container">
				<div id="col-2-header">
					<a href="#"><h1>Home</h1></a>
				</div><hr>
				<div id="tweet-area">
					<div id="tweet-area-profile-pic">
						<?php 
							if (isset($_SESSION['id'])) {
								$profile_img = $_SESSION['profile_img'];
							
								echo "<img id='profile_img' src='images/profile_pics/".$profile_img."'>";
							}
						?>
					</div>

					<?php

						if(isset($_POST['tweet_btn'])){
							$date = time();
							$post_text = mysqli_real_escape_string($conn, $_POST['post_text']);
							$author = $_SESSION['name'];
							$profile = $_SESSION['profile_img'];
							$image = $_FILES['img']['name'];
							$image_tmp = $_FILES['img']['tmp_name'];
												
							if(empty($post_text) or empty($author) ) {

								$error = "Please write Something to tweet";
							}
							else {
								$insert_query = " INSERT INTO `tweets` (`id`, `date`, `author`, `post_text`, `image`, `profile`) VALUES (NULL, '$date', '$author', '$post_text', '$image', '$profile') ";
								if (mysqli_query($conn, $insert_query)) {
									move_uploaded_file($image_tmp, "images/tweet_pics/$image");
									header('Location: home.php');
								}
								else {
									$error = "Something went wrong";
								}
							}
						}
					?>
					<form method="post" action="home.php" enctype="multipart/form-data">
						<div id="tweet-area-input-tweet">
							<textarea name="post_text" placeholder="What's happening?"></textarea>
						</div>
						<div id="tweet-area-footer">
							<label for="image_up">
								<img id="img_up" src="images/icons/image_up.png">
							</label>
							<img id="img_smilye" src="images/icons/smilye.png">
							<input id="image_up" type="file" name="img" style="display: none;">
							<img id="img_compose" src="images/icons/compose.png">
							<button id="col-2-tweet-button" name="tweet_btn">Tweet</button>
							<?php
							if (isset($error)){
								echo "<span style='color:red;'>$error</span>";
							}
							?>
						</div>
					</form>
				</div>

				<?php

					if(isset($_POST['search'])){
						$search = $_POST['search_title'];
						$all_post_query = " SELECT * FROM tweets WHERE author = '$search' ";
					}
					else{
						$all_post_query = "SELECT * FROM tweets ORDER BY id DESC";
					}

					$all_post_query_run = mysqli_query($conn, $all_post_query);
					if(mysqli_num_rows($all_post_query_run) > 0){
						while ($row = mysqli_fetch_array($all_post_query_run)) {
							$id = $row['id'];
							$date = getdate();
							$author = $row['author'];
							$post_text = $row['post_text'];
							$image = $row['image'];
							$profile = $row['profile'];
				?>

				<div id="tweets">
					<div id="tweets-profile-pic">
						<?php echo "<img src='images/profile_pics/".$profile."'>"; ?>
					</div>
					<div id="tweets-contents">
						<div id="tweets-contents-data">
							<div style="display: flex;">
								<a href="#"><h3><?php echo $author; ?></h3></a>
								<a href=""><h3 id="dif-h3"><?php echo "&nbsp;"."&nbsp;"."&nbsp;"."@".$author." ." ?></h3></a>
							</div>
							<p><?php echo $post_text;?></p>
							<?php
							if ($image != NULL) {
								echo " <img src='images/tweet_pics/".$image."'>";
							}
							else{
								echo "<div style='padding:25px;'></div>";
							}
								
							?>
						</div>
						<div id="tweets-content-footer">
							<div style="display: flex;">
								<div style="margin-right: 70px;">
									<a href="#"><div style="display: flex;"><img style="margin-left: 5px;" src="images/icons/comment-icon.png"><span id="comment-count">507</span></div></a>
								</div>
								<div style="margin-right: 70px; display: flex;">
									<a href="#"><div style="display: flex;"><img style="height: 15px; margin-top: 3px;" src="images/icons/retweet-icon.png"><span id="retweet-count">507</span></div></a>
								</div>
								<div style="display: flex;">
									<a href="#"><div style="display: flex;"><img src="images/icons/like-icon.png"><span id="like-count">507</span></div></a>
								</div>
								<a href="#"><img style="margin-left: 70px; height: 25px; width: 30px;" src="images/icons/upload-icon.png"></a>

							</div>
						</div>
					</div>
				</div>	<!-- col-2  tweets ----- End -->

					<?php

						}    //  ***** while loop closing braces *****

					}
					else {
						echo "<center><h2>No Posts Available</h2></center>";
					}

					?>

			</div>
		</div>   <!-- col-2 ----- End -->

		<div id="col-3">
			<div id="search">
				<form action="home.php" method="post">
					<div>
						<input id="search_field" type="text" name="search_title" placeholder=" Search Twitter">
						<button id="search_button" type="submit" value="" name="search"><img style="height: 13px; width: 18px;" src="images/icons/search_icon.png"></button>
					</div>
				</form>
			</div>
			<div id="trends">
				<header style="padding: 10px;">
					<h2 style="font-size: 19px;">Trends For You</h2>
				</header><hr>

				<?php
					$trend_query = "SELECT post_text FROM tweets LIMIT 5";
					$trend_run = mysqli_query($conn, $trend_query);
					if (mysqli_num_rows($trend_run) > 0){
						while ($trend_row = mysqli_fetch_array($trend_run)) {
							$post_text = $trend_row['post_text'];
				?>
				<div id="trends-body">
					<p>Trending in pakistan</p>
					<a href="#"><h2><?php echo "#".substr($post_text, 0, 11); ?></h2></a>
					<p style="font-size: 15px; margin-top: 0px; margin-bottom: 8px;">1,237 Tweets</p><hr>
				</div>
				<?php
						}
					}
					else{
						echo "No Trends Available";
					}

				?>

				<div id="trends-footer">
					<a href="#"><h2 style="padding: 10px 15px;">Show more</h2></a>
				</div>
				<a href="#"></a>
			</div>

			<div id="to-follow-list">
				<header>
					<h2 style="font-size: 19px;">Who to follow</h2>
				</header><hr>
				<?php

					$query = "SELECT * FROM users LIMIT 3";
					$run = mysqli_query($conn, $query);

					if (mysqli_num_rows($run) > 0){
						while ($row = mysqli_fetch_array($run)) {
							$name = $row['name'];
							$profile_img = $row['profile_img'];
				?>
				<div id="to-follow-list-body">
					<div id="to-follow-list-profile">
						<img src="images/profile_pics/<?php echo $profile_img; ?>">
					</div>
					<div id="to-follow-list-names">
						<a href="#"><h2><?php echo $name; ?><br><span style="color: #657786; font-weight: normal;"><?php echo "@".$name; ?></span></h2></a>
					</div>
					<div id="to-follow-list-button">
						<input id="col-3-follow-button" type="button" name="follow" value="Follow">
					</div>
				</div>
				<hr>
				<?php
					}
				}	
				else
					echo "No User Registerd yet!";

				?>
				<div id="to-follow-list-footer">
					<a href="#"><h2>Show more</h2></a>
				</div>
			</div>
			<footer>
				<div id="footer-menu">
					<ul>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Cookies</a></li>
						<li><a href="#">Ads info</a></li><br>
						<li><a href="#">More</a></li>
						<li>&copy; 2019 Twitter, Inc.</li>
					</ul>

				</div>
			
		</footer>
		</div>   <!-- col-3 ----- End -->

	</div>   

</body>
</html>