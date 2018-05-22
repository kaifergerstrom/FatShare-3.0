<?php

require_once('./classes/DB.php');
include('./scripts/initialize.php');

class User {

	public static $user_id;
	public static $email;
	public static $firstname;
	public static $lastname;
	public static $profile_img;
	public static $description;
	public static $full_name;
	public static $privacy;

	static function init() {
		global $user_id;

		self::$user_id = DB::query('SELECT user_id FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['user_id'];
		self::$email = DB::query('SELECT email FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['email'];
		self::$firstname = DB::query('SELECT firstname FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['firstname'];
		self::$lastname = DB::query('SELECT lastname FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['lastname'];
		self::$privacy = DB::query('SELECT locked FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['locked'];
		self::$profile_img = DB::query('SELECT profile_img FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['profile_img'];
		self::$description = DB::query('SELECT description FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['description'];
		self::$full_name = self::$firstname .' '. self::$lastname;
	}
	
	public function create_session() {
		session_start();
		$_SESSION["user_id"];
	}

}

User::init()

?>