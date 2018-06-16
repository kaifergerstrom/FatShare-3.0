<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/404.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<?php
include('./includes/header.php');
include('./scripts/initialize.php');

if (!empty($user_id)) {
	$redirect = 'home.php';
} else {
	$redirect = 'index.php';
}
?>

<div class='not-found-container'>
	<div class='title-container'>404</div>
	<div class='title-desc'>Page Not Found</div>
	<p>The page you are looking for does not exist at this time</p>
	<a href='<?php echo $redirect; ?>'><button class='redirect-button'>Go Home</button></a>
</div>
