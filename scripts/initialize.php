<?php

require_once('./classes/DB.php');
require_once('./classes/User.php');
date_default_timezone_set('EST'); 

$user = new User();

session_start();
error_reporting(1);

/*
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(1);
*/


$allowed_files = array('login.php', 'index.php', 'join.php');
$current_script = basename($_SERVER["SCRIPT_FILENAME"]);

if(isset($_SESSION['user_id'])) {
	if (in_array($current_script, $allowed_files)) {
		header('LOCATION: home.php');
	}
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = "";
	#Security
	if (!in_array($current_script, $allowed_files)) {
		header('LOCATION: index.php');
	}
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>