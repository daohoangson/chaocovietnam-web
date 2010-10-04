<?php
function load_emails() {
	$emails = array();
	@include(DIR . '/datastore/emails.php');
	return $emails;
}

function save_emails($emails) {
	file_put_contents(DIR . '/datastore/emails.php','<?php $emails = ' . var_export($emails, true) . ';');
}

function ccvn_mail($to, $subject, $message) {
	file_put_contents(DIR . '/datastore/emails.log', date('r') . "\t$to\t$subject\n",FILE_APPEND);
	
	$headers = '';
	$headers = "From: {$GLOBALS['config']['system_email']}\r\n";
	if (!empty($GLOBALS['config']['cc_email'])) {
		$headers .= "CC: {$GLOBALS['config']['cc_email']}\r\n";
	}
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	return mail($to, '[CHAOCOVIETNAM] ' . $subject, $message, $headers);
}

function ccvn_date($format, $timestamp = null) {
	if ($timestamp === null) $timestamp = time();
	$timestamp += 25200 - date('Z');
	return date($format,$timestamp);
}