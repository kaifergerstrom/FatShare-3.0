<?php

require_once('./classes/DB.php');
require_once('./classes/User.php');
date_default_timezone_set('EST'); 

$user = new User();

session_start();

if(isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = "";
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>