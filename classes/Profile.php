<?php

class Profile {

	public static $profile_id;
	public static $email;
	public static $firstname;
	public static $lastname;
	public static $profile_img;
	public static $description;
	public static $locked;
	public static $full_name;

	static function init($profile_id) {

		self::$profile_id = DB::query('SELECT user_id FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['user_id'];
		self::$email = DB::query('SELECT email FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['email'];
		self::$firstname = DB::query('SELECT firstname FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['firstname'];
		self::$lastname = DB::query('SELECT lastname FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['lastname'];
		self::$profile_img = DB::query('SELECT profile_img FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['profile_img'];
		self::$description = DB::query('SELECT description FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['description'];
		self::$locked = DB::query('SELECT locked FROM users WHERE user_id=:user_id', array(':user_id'=>$profile_id))[0]['locked'];
		self::$full_name = self::$firstname .' '. self::$lastname;

	}

	public function display_friends($user_id) {

		$friend_counter = 0; //To count for table rows

		//Find friends and display pictures (Crap)
		$dbfriends = DB::query('SELECT * FROM friends WHERE sent_by=:user_id AND status=1 OR sent_to=:user_id AND status=1 LIMIT 9', array(':user_id'=>$user_id));

		?>
		<div class='profile-friend-container'>
			<div class='profile-friends-title'><img class="friend-icon" src="assets/icon/friends.png"><div class='friend-text-title'>Friends</div></div>
			<table rows="3" class="table-profile-friends">
				<?php

        		foreach($dbfriends as $f) {

        			if ($friend_counter >= 3) {
        				echo '<tr>';
        				$friend_counter = 0;
        			}

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
	        			<td>
	        				<a href="profile.php?u=<?php echo $friend;?>">
	        				<img  class='profile-friend-img' src=" <?php echo $friend_info::$profile_img;?>">
	        				</a>
	        			</td>
        			<?php

        			$friend_counter++;

        			if ($friend_counter == 0) {
        				echo '</tr>';
        			}

        		}
				?>
			</table>
		</div>
		<?php
	}

	public function display_about() {
		?>
		<div class='profile-about-container'>
			<div class='profile-about-title'><img class="friend-icon" src="assets/icon/about.png"><div class='friend-text-title'>About</div></div>
			<div class='profile-about-desc'><?php echo self::$description;?></div>
		</div>
		<?php
	}

	public function display_photos($user_id) {

		$friend_counter = 0; //To count for table rows
		$type_lookup = 'p';

		//Find friends and display pictures (Crap)
		$dbposts = DB::query('SELECT * FROM posts WHERE user_id=:user_id AND type=:type_lookup ORDER BY id DESC LIMIT 9', array(':user_id'=>$user_id, ':type_lookup'=>$type_lookup));
		?>
		<div class='profile-photos-container'>
			<div class='profile-photo-title'><img class="friend-icon" src="assets/icon/photos.png"><div class='friend-text-title'>Photos</div></div>
			<table rows="3" class="table-profile-friends">
				<?php

        		foreach($dbposts as $p) {

        			if ($friend_counter >= 3) {
        				echo '<tr>';
        				$friend_counter = 0;
        			}

        			$post_img = $p['file'];

        			?>
        			<a href="profile.php?u=<?php echo $friend;?>">
	        			<td>
	        				<img  class='profile-friend-img' src="assets/posts/img/<?php echo $post_img;?>">
	        			</td>
	        		</a>
        			<?php

        			$friend_counter++;

        			if ($friend_counter == 0) {
        				echo '</tr>';
        			}

        		}
				?>
			</table>
		</div>
		<?php
	}

	public function isfriend() {
		global $profile_id;
		global $user_id;

		if (DB::query('SELECT sent_by, sent_to FROM friends WHERE sent_by=:user_id AND sent_to=:profile_id', array(':user_id'=>$user_id, ':profile_id'=>$profile_id))) {
				return True;
		}
		if (DB::query('SELECT sent_by, sent_to FROM friends WHERE sent_by=:profile_id AND sent_to=:user_id', array(':user_id'=>$user_id, ':profile_id'=>$profile_id))) {
				return True;
		} else {
			return False;
		}
	}

	public function addfriend($user_to) {
		global $user_id;

		$sent_type = '0';

		if (self::$locked == 0) {
			$sent_type = '1';
		} else {
			$sent_type = '0';
		}
		DB::query('INSERT INTO friends VALUES (\'\', :userid, :profile_id, :send_type, \'\')', array (':userid'=>$user_id, ':profile_id'=>$user_to, ':send_type'=>$sent_type));

	}

}

?>