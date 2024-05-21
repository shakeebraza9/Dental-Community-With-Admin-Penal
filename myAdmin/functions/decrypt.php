<?php 
global $e;
// when you update function or any thing in this file, go to
// http://atomiku.com/online-php-code-obfuscator/ (Able to decode but no Host says Virus)
// http://www.phpencode.org/#main (No decode able but some Host says Virus)
// and encrypt this file

function decrypt($e){
	global $l_key;

	$key = getProjectKeys($l_key);
	$secret_key = base64_decode($key['license_key']);
	$license_nonce = base64_decode($key['license_nonce']);
	$message = base64_decode($e);

	$d = sodium_crypto_secretbox_open($message, $license_nonce, $secret_key);
	eval('?>'.$d);
}

?>