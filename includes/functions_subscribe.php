<?php
function load_emails() {
	$emails = array();
	$json = @file_get_contents(storage_path('emails.json'));
	if (!empty($json)) {
		$emails = json_decode($json, true);
	}

	return $emails;
}

function save_emails($emails) {
	return file_put_contents(storage_path('emails.json'), json_encode($emails));
}

function ccvn_mail($to, $subject, $htmlBody) {
	$sender = sprintf(
		\google\appengine\runtime\Mail::DEFAULT_SENDER_ADDRESS_FORMAT,
		\google\appengine\api\app_identity\AppIdentityService::getApplicationId()
	);

	try {
		$message = new \google\appengine\api\mail\Message();
		$message->setSender($sender);
		$message->addTo($to);
		$message->setHtmlBody($htmlBody);
		$message->setReplyTo($GLOBALS['config']['contact_email']);
		$message->setSubject($subject);

		$message->send();

		return true;
	} catch (Exception $e) {
		if (!empty($GLOBALS['config']['debug'])) {
			throw $e;
		}

		syslog(LOG_ERR, $e->getMessage());
	}

	return false;
}

function ccvn_date($format, $timestamp = null) {
	if ($timestamp === null) $timestamp = time();
	$timestamp += 25200 - date('Z');
	return date($format,$timestamp);
}