<?php
require_once('./classes/DB.php');

class Verify {

    public static $token;

    public function verify_user($token) {
        $user_id = DB::query('SELECT user_id FROM users WHERE user_id=:user_id', array(':user_id'=>$token))[0]['user_id'];
        $verified = DB::query('SELECT verified FROM users WHERE user_id=:user_id', array(':user_id'=>$user_id))[0]['verified'];
    
        if (!empty($token)) {
            if (!empty($user_id)) {
                if ($verified == 0) {
                    DB::query('UPDATE users SET verified=1 WHERE user_id=:user_id',array(':user_id'=>$user_id));
                    self::$token = $token;
                } else {
                    DB::header('index.php'); 
                }
            } else {
                DB::header('index.php');
            }
        } else {
            DB::header('index.php');
        }
    }

    public function send_verify_email($to, $token) {
        $link = "www.thefatshare.com/login?token=".$token."";
        $subject = 'FatShare Verification';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@fatshare.com>' . "\r\n";

        $msg = "
        Thank you for registering with FatShare! In order to activate your account please click here:<br>\n<a href='".$link."'>Activate</a><br>\n<br><br>\n
        ";
        mail($to, $subject, $msg, $headers);
    }
}

?>