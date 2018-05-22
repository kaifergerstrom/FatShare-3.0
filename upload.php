<?php
include('./scripts/initialize.php');
include_once('./classes/Post.php');

if (isset($_POST['submit_upload'])) {

	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);

	$valid_img_types = array('image/png', 'image/jpeg', 'image/gif', 'image/bmp');
	$valid_vid_types = array('video/quicktime', 'video/mp4', 'video/wmv', 'video/avi');	

	$file_name = basename($_FILES["fileToUpload"]["name"]);
	$file_type_upload = $_FILES["fileToUpload"]["type"];

	$desc = strip_tags($_POST['post_desc']);

	if(empty($_FILES['fileToUpload']['name'])) {
		if (empty($desc)) {
			//Please enter something (error)
		} else {
			$file_type = 't';
			$file_name = "";
			InsertIntoDatabase($file_name, $file_type, $desc);
		}
		
	}

	$upload_path = '';
	$file_type = '';
	$upload = False;

	if (in_array($file_type_upload, $valid_img_types)) {
		$upload_path = 'img';
		$file_type = 'p';
		$upload = True;
		$upload_cap = 25*MB;
	}
	else if (in_array($file_type_upload, $valid_vid_types)) {
		$upload_path = 'vid';
		$file_type = 'v';
		$upload = True;
		$upload_cap = 500*MB;
	} else {
		$error = "Invalid file type";
		DB::header('home.php');
		$upload = False;
	}

	

	// If upload valid and file size <5mb then good!
	if($upload) {
		if ($_FILES['fileToUpload']['size'] < $upload_cap) {
			MoveUploadedFile($upload_path, $file_type, $desc);   
		} else {
			$error = "Sorry, your file is too large.";
		}
	}

}

function MoveUploadedFile($upload_path, $file_type, $desc) {
	$temp = explode(".", $_FILES["fileToUpload"]["name"]);
	$newfilename = round(microtime(true)) . '.' . end($temp);

	$target_dir = "assets/posts/".$upload_path.'/'.$newfilename;


	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir)) {
		InsertIntoDatabase($newfilename, $file_type, $desc);
	} else {
		$error = "Upload failed";
		DB::header('home.php');
	}

}

function InsertIntoDatabase($file_name, $file_type, $desc) {
	global $user_id;

	$post_id = uniqid();
	$date = date("Y-m-d h:i:sa");

	DB::query('INSERT INTO posts VALUES (\'\', :user_id, :post_id, :file, :type, :description, :date_time, \'\', \'\')', array(':user_id'=>$user_id, ':file'=>$file_name, ':post_id'=>$post_id, ':type'=>$file_type, ':description'=>$desc, ':date_time'=>$date));
	DB::header('home.php');
}

?>