<?php
include('./scripts/initialize.php');
include('./includes/header.php');

$error = '';

if (isset($_POST['submit-login'])) {
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

	if (DB::query('SELECT email, password FROM users WHERE email=:email AND password=:password', array(':email'=>$email, ':password'=>md5($password)))) {

		$user_id = DB::query('SELECT user_id FROM users WHERE email=:email', array(':email'=>$email))[0]['user_id'];
  		$_SESSION['user_id'] = $user_id;
  		DB::header("home.php");

	} else {
		$error = "Invalid Email/Password Combination";
	}
}

?>

<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/join.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<div class="banner-container">
	<div class="banner-gradient">
		<div class="welcome-container">
			<div class="login-container">
				<div class="login-msg">
					<div>Log into FatShare</div>
				</div>
				<form method="POST">
					<div class="join-error"><?php echo $error;?></div>
					<div class="login-form">
						<input type="text" class="login-input" placeholder="Email" name="email">
						<input type="password" class="login-input" placeholder="Password" name="password">
						<button name="submit-login" class='join-big-button'>Sign in</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>