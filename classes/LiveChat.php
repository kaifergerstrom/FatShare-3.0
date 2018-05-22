<?php

require_once('./classes/Profile.php');
include_once('./scripts/initialize.php');

class LiveChat {


	public static $chat_id;

	public function get_open_chats($user_id) {

		global $user_id;
		global $chat_id;

		self::$chat_id = $chat_id;

		$open_chat_query = DB::query('SELECT DISTINCT chat_id FROM chats WHERE sent_by=:user_id OR sent_to=:user_id LIMIT 6', array(':user_id'=>$user_id));

		foreach($open_chat_query as $c) {
			$chat_id_array = $c['chat_id'];
			$active_css = '';

			if ($chat_id == $chat_id_array) {
				$active_css = 'active';
			}
			?>
			<a href="messenger.php?c=<?php echo $chat_id_array;?>">
				<div id='live-chat-option' class="live-chat-option-container <?php echo $active_css;?>">
					<div class='live-chat-option-block'>
					<?php
						$get_user_per_chat = DB::query('SELECT * FROM chats WHERE chat_id=:chat_id LIMIT 1', array(':chat_id'=>$chat_id_array));
						foreach($get_user_per_chat as $u) {
							$sent_by = $u['sent_by'];
		        			$sent_to = $u['sent_to'];

		        			$friend = '';

		        			if ($sent_by == $user_id) {
		        				$friend = $sent_to;
		        			} else {
		        				$friend = $sent_by;
		        			}

		        			$friend_info = new Profile();
		        			$friend_info::init($friend);

		        			?>
		        				<img class="live-chat-option-img" src="assets/profile_img/<?php echo $friend_info::$profile_img;?>">
		        				<div class='live-chat-name-title'><?php echo self::get_users_in_chat($chat_id_array, True);?></div>
		        			<?php
						}
					?>
					</div>
				</div>
			</a>
			<?php
		}

	}

	public function get_users_in_chat($chat_id, $side_bar=False) {

		global $user_id;

		$user_in_chat = array();

		$open_chat_query = DB::query('SELECT * FROM chats WHERE chat_id=:chat_id', array(':chat_id'=>$chat_id));

		foreach($open_chat_query as $c) {

			$sent_by = $c['sent_by'];
		    $sent_to = $c['sent_to'];

		    $friend = '';

		    if ($sent_by == $user_id) {
		    	$friend = $sent_to;
		    } else {
		    	$friend = $sent_by;
		    }
			array_push($user_in_chat, $friend);
		}

		$name_string = '';

		foreach ($user_in_chat as $name) {
			$friend_info = new Profile();
		    $friend_info::init($name);

		    if (end($user_in_chat) == $name) {
		    	$name_string = $name_string .' & '. $friend_info::$firstname;
		    } else {
		    	$name_string = $name_string .', '. $friend_info::$firstname;
		    }
		}
		$name_string  = substr($name_string, 2);

		if ($side_bar) {
			if (strlen($name_string) > 21) {
				$name_string  = substr($name_string, 0, 18);
				$name_string = $name_string.'...';
			}
		}
		
		return $name_string;
		

	}

	public function load_chat_info($chat_id) {
		global $user_id;

		$open_chat_query = DB::query('SELECT * FROM chats WHERE chat_id=:chat_id', array(':chat_id'=>$chat_id));

		$file_directory  = "assets/chat_log/".$chat_id.".log";
	
			if (file_exists($file_directory)) {
				$chat_log = fopen($file_directory, "r");
			} else {
				$chat_log = fopen($file_directory, "w");
			}

			$chat_log = new SplFileObject($file_directory);

			// Loop until we reach the end of the file.
			while (!$chat_log->eof()) {
			    // Echo one line from the file.
			    $line = $chat_log->fgets();

			    if (empty($line)) {
			    	continue;
			    }

				list($date, $poster_id, $msg) = explode(' | ', $line );

				$date = trim($date);
				$date = trim($poster_id);
				$date = trim($msg);

				$poster_info = new Profile();
			    $poster_info::init($poster_id);

			    $other_user_css = '';

			    if ($poster_id == $user_id) {
			    	$other_user_css = 'main';
			    } else {
			    	$other_user_css = '';
			    }

			     ?>
			    <div class='chat-comment-container' id='chat-comment'>
			    	<img class='live-chat-msg-pic<?php echo $other_user_css;?>' src='assets/profile_img/<?php echo $poster_info::$profile_img;?>'>
			    	<div class='chat-comment <?php echo $other_user_css;?>'>
			    		<?php echo htmlspecialchars($msg);?>
				    </div>
				</div>	    
			    <?php
			}

			// Unset the file to call __destruct(), closing the file handle.
			$file = null;
	}

	public function post_chat_info($msg) {
		global $chat_id;
		global $user_id;

		$file_directory  = "assets/chat_log/".$chat_id.".log";

		$msg = htmlspecialchars($msg);
		$date = '2018-04-10 00:00:00';

		$file_import_string = $date . ' | ' . $user_id . ' | '. $msg . PHP_EOL;

		$chat_log = fopen($file_directory, "a+");

		fwrite($chat_log, $file_import_string);

	}

	public function displayfriends() {
		global $user_id;

		$get_friend_info = DB::query('SELECT * FROM friends WHERE sent_by=:userid AND status=1 OR sent_to=:userid AND status=1', array(':userid'=>$user_id));

		foreach ($get_friend_info as $f) {
		?>
		<div id='live-chat-option' class="live-chat-option-container <?php echo $active_css;?>">
			<div class='live-chat-option-block'>
				<?php
					$sent_by = $f['sent_by'];
        			$sent_to = $f['sent_to'];

        			$friend = '';

        			if ($sent_by == $user_id) {
        				$friend = $sent_to;
        			} else {
        				$friend = $sent_by;
        			}

        			$friend_info = new Profile();
        			$friend_info::init($friend);

        			?>
        				<img class="live-chat-option-img" src="assets/profile_img/<?php echo $friend_info::$profile_img;?>">
        				<div class='live-chat-name-title'><?php echo $friend_info::$firstname;?></div>
        				<input type='checkbox' class='check-box-add-chat' name="add-users[]" value='<?php echo $friend_info::$profile_id;?>'>
			
			</div>
		</div>
		<?php
		}
	}

}

?>