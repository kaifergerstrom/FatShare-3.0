<?php
include('./scripts/initialize.php');
include('./includes/home_header.php');
include_once('./classes/Post.php');
include_once('./classes/Upload.php');

//echo $error;

?>
<link rel="stylesheet" type="text/css" href="./css/upload.css">
<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />
<link rel="stylesheet" type="text/css" href="./css/post.css">
<div class='home-container'>
<?php
    $post_home = new Post();
	include('includes/upload_form.php');
    $post_home::display_posts($user_id, True);
?>
</div>
<script src="scripts/upload.js"></script>
