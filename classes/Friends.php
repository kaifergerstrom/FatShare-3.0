<?php
include('./scripts/initialize.php');
include_once('./classes/Profile.php');

class Friends {

    public function display_active_friends() {
        global $user;
        $get_active_friends = DB::query('SELECT * FROM friends WHERE sent_by=:user_id AND status=1 OR sent_to=:user_id AND status=1', array(':user_id'=>$user::$user_id));
        
        foreach($get_active_friends as $f) {
            $sent_by = $f['sent_by'];
            $sent_to = $f['sent_to'];

            if ($user::$user_id == $sent_by) {
                $friend = $sent_to;
            } else {
                $friend = $sent_by;
            }

            //Get friends info
            $friend_info = new Profile();
            $friend_info::init($friend);
            
            echo "
            <div class='friend-option-container'>
                <img src='".$friend_info::$profile_img."' class='friend-profile-pic'>
                <div class='friend-full-name'>".$friend_info::$full_name."</div>
                <button type='submit' class='remove-friend-btn'><i class='fas fa-times'></i></button>
            </div>
            ";
        }
    }

    public function display_friend_invites() {
        global $user;
        $get_friend_invites = DB::query('SELECT * FROM friends WHERE sent_to=:user_id AND status=0', array(':user_id'=>$user::$user_id));
        foreach($get_friend_invites as $f) {

            $sent_by = $f['sent_by'];
            
            //Get inviter info
            $friend_info = new Profile();
            $friend_info::init($sent_by);

            echo "
            <div class='friend-option-container'>
                <img src='".$friend_info::$profile_img."' class='friend-profile-pic'>
                <div class='friend-full-name'>".$friend_info::$full_name."</div>
                <button type='submit' class='add-friend-btn'><i class='fas fa-check'></i></button>
                <button type='submit' class='decline-friend-btn'><i class='fas fa-times'></i></button>
            </div>
            ";

        }
    }

    public function display_user_invites() {
        global $user;
        $get_user_invites = DB::query('SELECT * FROM friends WHERE sent_by=:user_id AND status=0', array(':user_id'=>$user::$user_id));
        foreach($get_user_invites as $f) {
            $sent_by = $f['sent_to'];
        
            //Get invitee info
            $friend_info = new Profile();
            $friend_info::init($sent_by);

            echo "
            <div class='friend-option-container'>
                <img src='".$friend_info::$profile_img."' class='friend-profile-pic'>
                <div class='friend-full-name'>".$friend_info::$full_name."</div>
                <button type='submit' class='remove-friend-btn'><i class='fas fa-times'></i></button>
            </div>
            ";
        }
    }

}


?>