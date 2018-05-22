<?php
include('./scripts/initialize.php');
include('./includes/home_header.php');

//Post::upload_post(, $file_input_name, $desc);
//echo $error;

?>
<link rel="stylesheet" type="text/css" href="./css/upload.css">
<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/settings.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<div class='header-bar'>
	<div class='header-bar-title'>My profile</div>
</div>

<div class='settings-container'>
	<div class='settings-title'>Account Information</div>
	<div class='current-settings-info'>
		<img class='profile-img-settings' src='assets/profile_img/<?php echo $user::$profile_img;?>'>
			<div class='settings-input-row'>
				<div class='settings-input-block'>
					<div class='settings-label'>Full name</div>
					<input type='text' class='settings-input' value='<?php echo $user::$full_name;?>'>
				</div>
				<div class='settings-input-block'>
					<div class='settings-label'>Email</div>
					<input type='text' class='settings-input' value='<?php echo $user::$email;?>'>
				</div>
				<br><br><br>
				<?php
				$private_label = '';
				if ($user::$privacy == 1) {
					$private_label = 'Private';
				} else {
					$private_label = 'Public';
				}
				?>
				<div class='settings-private-label'>(<?php echo $private_label;?>)</div>
			</div>
	</div>
	<br><br>
	<div class='settings-input-row'>
		<div class='settings-label'>Description</div>
		<textarea class='settings-textarea'><?php echo $user::$description;?></textarea>
	</div>

	<div class='check-box-block'>
		<input type='checkbox' id='checkbox-privacy'>
		<label for='checkbox-privacy'>Private Profile</label>
	</div>

	<div>
		<button class='save-changes-btn'>Save Changes</button>
	</div>

</div>