<?php
include('./scripts/initialize.php');
include('./includes/home_header.php');

if (empty($_GET)) {
    DB::header('profile.php?u=' . $user_id);
} else {

$profile_id = $_GET['u'];

include_once('./classes/Profile.php');
include_once('./classes/Post.php');

$profile = new Profile();
$post = new Post();
$profile::init($profile_id);

if (isset($_POST['banner-follow-user'])) {
	$profile::addfriend($profile_id);
}

?>

<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/profile.css">
<link rel="stylesheet" type="text/css" href="./css/post.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<div class="profile-banner-container" style="background-image: url(assets/banners/forest.jpg)">
	<div class="banner-user-info">
		<img src=" <?php echo $profile::$profile_img;?>" class="banner-profile-img">
		<div class="banner-full-name"><?php echo $profile::$full_name;?></div>
		<div class="banner-description"><?php echo $profile::$description;?></div>
	</div>
</div>
<div class="profile-stats-container">
	<div class="stats-options">
		<div class="profile-stats-group">

			<?php

			$count_friends_query = DB::query('SELECT * FROM friends WHERE sent_by=:profile_id AND status=1 OR sent_to=:profile_id AND status=1', array(':profile_id'=>$profile_id));
			$count_posts_query = DB::query('SELECT * FROM posts WHERE user_id=:profile_id', array(':profile_id'=>$profile_id));
			$friend_counter = 0;
			$post_counter = 0;
			foreach($count_friends_query as $f) {
				$friend_counter++;
			}
			foreach($count_posts_query as $s) {
				$post_counter++;
			}
			//echo mysqli_num_rows($count_friends_query);
			?>
			<ul>Friends: <span><?php echo $friend_counter;?></span></ul>
			<ul>Posts: <span><?php echo $post_counter;?></span></ul>
		</div>
		<div class='profile-stats-btns'>
			<?php

				if (DB::query('SELECT status FROM friends WHERE sent_by=:user_id AND sent_to=:profile_id', array(':user_id'=>$user_id, ':profile_id'=>$profile_id))) {

					$friend_status = DB::query('SELECT status FROM friends WHERE sent_by=:user_id AND sent_to=:profile_id', array(':user_id'=>$user_id, ':profile_id'=>$profile_id))[0]['status'];

					if ($friend_status == 0) {
						$follow_css = 'Pending';
					} 
					else if ($friend_status == 1) {
						$follow_css = 'Following';
					} else {
						$follow_css = '';
					}
				} else {
					$follow_css = 'Follow';
				}
				
				if ($profile_id == $user_id) {
					?>
					<a href='my_profile.php'>
						<button type="submit" class="profile-stats-follow-btn pending" name='banner-follow-user'>
							Settings
						</button>
					</a>
					<?php
				} else {
			?>
			<form method="POST">
				<button type="submit" class="profile-stats-follow-btn <?php echo $follow_css;?>" name='banner-follow-user'>
					<?php echo $follow_css;?>
				</button>
			</form>
			<?php } ?>
			<button class="profile-stats-pm-btn">
				Private Message
			</button>
		</div>
	</div>
</div>

<div class="profile-content-container">
	<?php

	$show_content = True;

	$friend_status = DB::query('SELECT status FROM friends WHERE sent_by=:user_id AND sent_to=:profile_id', array(':user_id'=>$user_id, ':profile_id'=>$profile_id))[0]['status'];

	if ($profile::$locked == 1) {
		if ($profile::isfriend()) {
			if ($friend_status == 1) {
				$show_content = True;
			} else {
				$show_content = False;
			}
		} else {
			$show_content = False;
		}
		if ($profile_id == $user_id) {
			$show_content = True;
		}
	}

	if (!$show_content) {
		//Not friends with person
		?>
			<div class="profile-locked-hud">
				<img src='assets/img/locked.png' class='profile-lock-icon'>
				<div class='profile-private-alert'>This Account is Private</div>
			</div>
		<?php
	} else {
		?>
		<div class='profile-widget-container'>
			<div class='profile-left-widgets'>
				<?php
				$profile::display_about($profile_id);
				$profile::display_friends($profile_id);
				?>
			</div>
			<div class="profile-posts-container">
				<?php
				$post::display_posts($profile_id);
				?>
			</div>
			<?php
				$profile::display_photos($profile_id);
			?>
		</div>
		<?php
	}
	?>
</div>


<?php
}
?>
