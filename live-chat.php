<?php
require_once('./classes/LiveChat.php');
$livechat = new LiveChat();
?>
<div class='main-live-refresh-container' id='refresh-chat'>
	<?php
	$chat_id = isset($_GET['c']) ? $_GET['c'] : '';
	if (!empty($chat_id)) {
		$livechat::load_chat_info($chat_id);
	}
	?>
</div>