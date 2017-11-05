<?php
function l($page, $return = false, $lang = null, $options = array()) {
	// builds uri
	if ($page === 'this') $page = $GLOBALS['displayed'];
	if ($lang === null) $lang = $GLOBALS['runtime']['lang'];
	if (empty($GLOBALS['config']['rewrite'])) {
		$param_d1 = '?';
		$param_d2 = '&';
	} else {
		$param_d1 = '';
		$param_d2 = '?';
	}
	
	$uri = '';
	if (!empty($options['full'])) $uri .= $GLOBALS['config']['url'];
	$uri .= $param_d1;
	if ($lang != $GLOBALS['config']['lang']) $uri .= $lang . '/';
	$uri .= $page . '.htm';
	if (!empty($options['params']) AND is_array($options['params'])) {
		$i = 0;
		foreach ($options['params'] as $pkey => $pval) {
			if (0 == $i++) $uri .= $param_d2; else $uri .= '&';
			$uri .= "$pkey=" . urlencode($pval);
		}
	}
	
	if ($return) {
		return $uri;
	} else {
		echo $uri;
	}
}

function ccvn_date($format, $timestamp = null) {
	if ($timestamp === null) $timestamp = time();
	$timestamp += 25200;
	return gmdate($format,$timestamp);
}

function storage_path($relativePath = '') {
	return sprintf(
		'gs://%s/%s',
		\google\appengine\api\cloud_storage\CloudStorageTools::getDefaultGoogleStorageBucketName(),
		$relativePath
	);
}

function version_hash() {
	return substr(md5($_SERVER['CURRENT_VERSION_ID']), 0, 6);
}

function display($page,$variables = array()) {
	extract($variables);
	require(DIR . '/templates/' . $page . '.page.php');
	$GLOBALS['displayed'] = $page;
}
function displayed() {
	return isset($GLOBALS['displayed']);
}