<?php
include('./scripts/initialize.php');
include('./includes/home_header.php');

//Post::upload_post(, $file_input_name, $desc);
//echo $error;

if (isset($_POST['update-profile'])) {
	$full_name = trim($_POST['input-full-name']);
	$desc = trim($_POST['input-description']);
	$privacy = $_POST['input-privacy'];
	list($first_name, $last_name) = explode(' ', $full_name);

	if ($privacy) {
		$locked = 1;
	} else {
		$locked = 0;
	}

	if (!$_FILES['profileimg']['name'] == "") {
			$image = base64_encode(file_get_contents($_FILES['profileimg']['tmp_name']));
				$options = array('http'=>array(
						'method'=>"POST",
						'header'=>"Authorization: Bearer 59cc0fc53ab08ce76813407753038e20044b76fb\n".
						"Content-Type: application/x-www-form-urlencoded",
						'content'=>$image
				));
				
			$context = stream_context_create($options);
			$imgurURL = "https://api.imgur.com/3/image";
			$response = file_get_contents($imgurURL, false, $context);
			$response = json_decode($response);
			$profile_img = $response->data->link;
	} else {
		$profile_img = 'default.png';
	}

	DB::query('UPDATE users SET firstname=:firstname, lastname=:lastname, profile_img=:profile_img, locked=:privacy, description=:profile_desc WHERE user_id=:user_id', array(':firstname'=>$first_name, ':lastname'=>$last_name, ':profile_img'=>$profile_img, ':privacy'=>$locked, ':profile_desc'=>$desc, ':user_id'=>$user::$user_id));
	DB::header('my_profile.php');
}

?>
<link rel="stylesheet" type="text/css" href="./css/upload.css">
<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/settings.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<div class='header-bar'>
	<div class='header-bar-title'>My profile</div>
</div>

<form method="post" enctype="multipart/form-data">
	<div class='settings-container'>
		<div class='settings-title'>Account Information</div>
		<div class='current-settings-info'>
			<img class='profile-img-settings' src='<?php echo $user::$profile_img;?>'>
			<input type="file" name="profileimg">
				<div class='settings-input-row'>
					<div class='settings-input-block'>
						<div class='settings-label'>Full name</div>
						<input type='text' name='input-full-name' class='settings-input' value='<?php echo $user::$full_name;?>'>
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
			<textarea class='settings-textarea' name='input-description'><?php echo $user::$description;?></textarea>
		</div>

		<div class='check-box-block'>
			<?php
			if ($user::$privacy == 1) {
				echo "<input type='checkbox' id='checkbox-privacy' name='input-privacy' checked>";
			} else {
				echo "<input type='checkbox' id='checkbox-privacy' name='input-privacy'>";
			}
			?>
			<label for='checkbox-privacy'>Private Profile</label>
		</div>

		<div>
			<button type='submit' name='update-profile' class='save-changes-btn'>Save Changes</button>
		</div>

	</div>
</form>