<link rel="stylesheet" type="text/css" href="./css/home_header.css">
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

<div class="header">
	<div class="header-container">
		<a href='home.php'>
			<div class="logo-container">
				<span>Fat</span>Share
			</div>
		</a>
		<div class="header-search-box">
			<input type='text' class="header-search-input">
			<i class="fas fa-search header-search-icon"></i>
		</div>
		<nav class="header-options">
			<a href="home.php">
				<ul>
					Home
				</ul>
			</a>
			<a href="friends.php">
				<ul>
					Friends
				</ul>
			</a>
			<a href="messenger.php">
				<ul>
					Messenger
				</ul>
			</a>
			<a href="profile.php">
				<ul>
					My Profile
				</ul>
			</a>
		</nav>
		<a href="profile.php?u=<?php echo $user_id;?>">
			<div class="header-profile-name">
				<img src="assets/profile_img/<?php echo $user::$profile_img;?>" class="profile-img-header">
				<div class="full-name-header"><?php echo $user::$full_name;?></div>
			</div>
		</a>
	</div>
</div>

<div style='height: 55px;'></div>