<?php
include('./scripts/initialize.php');
include('./includes/header.php');
include_once('./classes/Verify.php');

$error = '';
$success = '';
$verify = new Verify();

if (isset($_POST['submit-join'])) {

	$firstname = strip_tags($_POST['firstname']);
	$lastname = strip_tags($_POST['lastname']);
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	$password_confirm = strip_tags($_POST['password-confirm']);
	$user_id = strip_tags($_POST['user_id']);

	if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
		if (strlen($firstname) > 2 && strlen($firstname) < 32 && strlen($lastname) > 2 && strlen($lastname) < 32) {
			if (ctype_alpha($firstname) || ctype_alpha($lastname)) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					if (strlen($password) > 6) {
						if ($password == $password_confirm) {
							$date = date("Y-m-d h:i:sa");
							$default_img = 'https://i.imgur.com/bGYeO8d.png';
							DB::query('INSERT INTO users VALUES (\'\', :user_id, :password, :firstname, :lastname, :email, :default_img, \'\', \'\', \'\', \'\', :dated)', array(':user_id'=>$user_id, ':password'=>md5($password), ':firstname'=>$firstname, ':lastname'=>$lastname, ':email'=>$email, ':default_img'=>$default_img, ':dated'=>$date));
								$user_id = substr($user_id, 0, 8);
								$success = "Please check your email to activate your account";
								$verify::send_verify_email($email, $user_id);
								//$_SESSION['user_id'] = $user_id;
	  							//DB::header("home.php");
						} else {
							$error = "Passwords do not match";
						}
					} else {
						$error = "Password must be at least 6 characters long";
					}
				} else {
					$error = "Email is invalid";
				}
			} else {
				$error = "Invalid firstname/lastname";
			}
		} else {
			$error = "Invalid firstname/lastname";
		}
	} else {
		$error = "Email already exists";
	}
}

?>

<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/join.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />


<div class="banner-container">
	<div class="banner-gradient">
		<div class="welcome-container">
			<form method="POST">
				<div class="join-error"><?php echo $error;?></div>
				<div class="join-success"><?php echo $success;?></div>
				<div class="join-form-container">
					<input type='text' name='firstname' placeholder="Firstname" class='join-small-input'>
					<input type='text' name='lastname' placeholder="Lastname" class='join-small-input'>
					<input type='text' name='email' placeholder="Email" class='join-big-input'>
					<input type='password' name='password' placeholder="Password" class='join-big-input'>
					<input type="hidden" name="user_id" value="<?php echo uniqid();?>">
					<input type='password' name='password-confirm' placeholder="Confirm Password" class='join-big-input'>
					<button name="submit-join" class='join-big-button'>Sign up</button>
				</div>
			</form>
			<div class='join-form-msg'>
				<div class='join-form-title'>
					Join the FatShare Community
				</div>
				<li>Sed ut perspiciatis unde omnis</li>
				<li>Sed ut perspiciatis unde omnis</li>
				<li>Sed ut perspiciatis unde omnis</li>
				<li>Sed ut perspiciatis unde omnis</li>
			</div>
		</div>
	</div>
</div>