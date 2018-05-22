<?php
include('./scripts/initialize.php');
require_once('./classes/LiveChat.php');
require_once('./classes/Profile.php');
include('./includes/home_header.php');

$livechat = new LiveChat();

$chat_id = $_GET['c'];

if (isset($_POST['send-chat-msg'])) {
	$msg_send = strip_tags($_POST['chat-msg']);
	if (!empty($msg_send)) {
		$msg_send = htmlspecialchars($msg_send);
		$livechat::post_chat_info($msg_send);
	}
}

if (isset($_POST['submit-create-new-chat'])) {
	$add_user_array = $_POST['add-users'];

	foreach ($add_user_array as $u) {

		if (DB::query('SELECT * FROM users WHERE user_id=:userid', array(':userid'=>$u))) {
			$chat_id_insert = uniqid();
			$chat_id_insert = substr($chat_id_insert, 0, 8);
			$date = date("Y-m-d h:i:sa");
			DB::query('INSERT INTO chats VALUES (\'\', :user_id, :invite_id, :chat_id, :date_time)', array(':user_id'=>$user_id, ':invite_id'=>$u, ':chat_id'=>$chat_id_insert, ':date_time'=>$date));
			DB::header('messenger.php?c='.$chat_id_insert);
		}
	}
}

?>

<link rel="stylesheet" type="text/css" href="./css/all.css">
<link rel="stylesheet" type="text/css" href="./css/home.css">
<link rel="stylesheet" type="text/css" href="./css/livechat.css">
<link rel="stylesheet" type="text/css" href="./fonts/fonts.css" />

<div class='live-chat-container'>
	<div class='live-chat-header'></div>
	<div class='live-chat-side-header'>
		<div id='options_container'>
			<?php $livechat::get_open_chats($user_id) ?>
		</div>
		<div class='create-chat-form'>
			<form method='POST'>
				<div class='title-add-chat'></div>
				<?php $livechat::displayfriends($user_id) ?>
				<div class='new-chat-btn-block-after'>
					<button class='btn-submit-new-chat' name='submit-create-new-chat' type='submit'><i class="fas fa-check"></i></button>
					<button class='btn-submit-new-chat-remove' type='button' id='remove-chat-btn'><i class="fas fa-times"></i></button>
				</div>
			</form>
		</div>
		<div class='new-chat-btn-block'>
			<button class='add-chat-btn' id='add-new-chat-btn'><i class="fas fa-plus"></i></button>
		</div>
	</div>
	<div class='live-chat-right-side'>

		<div class='live-chat-name-container' name="live-chat-name-container" id="live-chat-name-container">
			<div class='name-live-chat'>
			<?php echo $livechat::get_users_in_chat($chat_id); ?>
			</div>
		</div>

		<div class='main-live-chat-container' id='main-chat'>
		<?php
		include('live-chat.php');
		?>
		</div>

		<?php 
		if (!empty($chat_id)) {
		?>
		<form method="POST" name="action">
			<div class='live-chat-input-container'>
				<i class="fas fa-camera live-chat-camera-icon"></i>
				<input type='text' class='live-chat-input' id="chat-msg" name='chat-msg' placeholder="Type something"> 
				<button class='live-chat-btn' type="submit" id='send-chat-msg' name='send-chat-msg'>Send</button>
			</div>
		</form>
		<?php } ?>
	</div>
</div>

<script src="scripts/livechat.js"></script>
<?php
if (!empty($chat_id)) {
?>
<script>

//Auto select div
var input = document.getElementById('chat-msg');
input.focus();
input.select();

//Auto refresh
var auto_refresh = setInterval(
function ()
{
	$('#refresh-chat').load('live-chat.php?c=<?php echo $chat_id;?>').fadeIn("slow");
}, 1000); // refresh every 5 seconds
</script>
<?php
}
?>