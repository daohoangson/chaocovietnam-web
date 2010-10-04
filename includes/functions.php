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

function display($page,$variables = array()) {
	extract($variables);
	require(DIR . '/templates/' . $page . '.page.php');
	$GLOBALS['displayed'] = $page;
}
function displayed() {
	return isset($GLOBALS['displayed']);
}