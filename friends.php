<?php
include('./scripts/initialize.php');
include('./includes/home_header.php');
include_once('./classes/Friends.php');

$friends = new Friends();
?>

<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/settings.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />
<link rel="stylesheet" type="text/css" href="./css/friends.css">

<div class='header-bar'>
	<div class='header-bar-title'>My friends</div>
</div>

<div class='all-friends-container'>
    <div class='friend-container-main'>
        <div class='current-friends-container'>
            <div class='friend-title'>Friends</div>
            <?php $friends::display_active_friends(); ?>
        </div>
        <div class='request-friends-container'>
            <div class='friend-title'>Friend invites</div>
            <?php $friends::display_friend_invites(); ?>
        </div>
        <div class='pending-friends-container'>
            <div class='friend-title'>Outgoing invites</div>
            <?php $friends::display_user_invites(); ?>
        </div>
    </div>
</div>