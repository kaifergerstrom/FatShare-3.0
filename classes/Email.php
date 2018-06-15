<?php

class Email {
	public function confirmation_email($email, $token) {
		mail($email, "My subject", 'Wassup my bro');
	}
}