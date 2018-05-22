<?php

require_once('./classes/DB.php');
require_once('./classes/Profile.php');
include('./scripts/initialize.php');

class Post {

	public function display_posts($profile_id, $allfriends=False) {
		global $user;
		
		if ($allfriends) {
			$dbfriends = DB::query('SELECT * FROM friends WHERE sent_by=:userid AND status=1 OR sent_to=:userid AND status=1', array(':userid'=>$profile_id));

			if (empty($dbfriends)) {
				$dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$profile_id));
			} else {

				$friend_ids = array();
				
				foreach($dbfriends as $f) {
					$sent_by = $f['sent_by'];
					$sent_to = $f['sent_to'];
					
					array_push($friend_ids, $sent_by);
					array_push($friend_ids, $sent_to);
					
				}
				
				$friend_implode = "'" . implode("', '", $friend_ids) . "'";
				
				$dbposts = DB::query("SELECT * FROM posts WHERE user_id IN ($friend_implode) ORDER BY id DESC");
			}
			
		} else {
			$dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$profile_id));
		}

		if (!$dbposts) {
			echo '<div class="profile-no-posts">No posts yet.</div>';
		}

		foreach($dbposts as $p) {
			
			$poster_id = $p['user_id'];
			$post_id = $p['post_id'];
			$file = $p['file'];
			$post_type = $p['type'];
			$desc = $p['description'];
			$date = $p['date'];
			
			$post_profile = new Profile();
			$post_profile::init($poster_id);

			list($day, $time) = explode(' ', $date);
			list($hour, $minute, $seconds) = explode(':', $time);
			list($year, $monthNum, $day) = explode('-', $day);

			$monthName = date("F", mktime(0, 0, 0, (int)$monthNum, 10));
			$monthName = substr($monthName,0,3);

			$month_string = $monthName.' '.(int)$day.' at '.(int)$hour.':'.$minute;

			if ($post_type == 'p') {
				$post_addon = '<span class="post-header-shared-a">shared a</span> photo';
			} else if ($post_type == 'v') {
				$post_addon = '<span class="post-header-shared-a">shared a</span> video';
			} else {
				$post_addon = '';
			}

			$comment_string = '<span>'.$post_profile::$full_name.'</span> '.$desc;

			?>
			<div class="post-container">
				<div class="post-header-info">
					<div class="post-header-block">
						<img class="post-profile-img" src="assets/profile_img/<?php echo $post_profile::$profile_img;?>">
						<div class='post-header-name'><?php echo $post_profile::$full_name;?> <?php echo $post_addon;?><br><span class='post-header-date'><?php echo $month_string; ?></span></div>
					</div>
				</div>
				<div class="post-content-container">
					<?php
					if ($post_type == 'p') {
						?>
						<img class='post-file' src="assets/posts/img/<?php echo $file;?>">
						<?php
					} else if ($post_type == 'v') {
						?>
						<video class='post-file' controls>
							<source src="assets/posts/vid/<?php echo $file;?>">
						</video>
						<?php
					} else {
						$comment_string = $desc;
					}
					?>
				</div>
				<div class="post-sub-info">
					<div class="post-desc-sub">
						<?php echo $comment_string;?>
					</div>
					<div class='post-comment-sub'>
						
						<?php
						$dbcomments = DB::query('SELECT * FROM comments WHERE post_id=:post_id ORDER BY id DESC LIMIT 2', array(':post_id'=>$post_id));
						foreach($dbcomments as $c) {

							$commenter_id = $c['user_id'];
							$comment = $c['comment'];

							$comment_profile = new Profile();
							$comment_profile::init($commenter_id);

							?>
							<div class='comment-container'>
								<div class='comment-block'>
									<img class='post-comment-img' src="assets/profile_img/<?php echo $comment_profile::$profile_img?>">
									<div class='post-comment'><div class='post-comment-name'><?php echo $comment_profile::$full_name;?></div><?php echo $comment;?></div>
								</div>
							</div>
							<?php
						}
						?>

						<div class='post-sub-comment-bar'>
							<img class="comment-input-picture" src="assets/profile_img/<?php echo $user::$profile_img;?>"><input type='text' class='comment-search-bar' placeholder="Write a comment..">
						</div>
					</div>
				</div>
			</div>
			<br>
			<?php
		}
	}

}

?>
