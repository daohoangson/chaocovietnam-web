<?php
function &load_language($lang = null, $sync = true) {
	if ($lang === null) $lang = $GLOBALS['runtime']['lang'];
	
	static $phrases_sets = array();
	
	if (!isset($phrases_sets[$lang])) {
		$phrases = array();	
		@include(DIR . '/includes/language_' . $lang . '.php');
		$phrases_sets[$lang] = $phrases;
		$GLOBALS['phrases_sets'] = array_keys($phrases_sets);
	}
	$ref =& $phrases_sets[$lang];
	
	if ($sync) {
		$GLOBALS['phrases'] =& $phrases_sets[$lang];
		register_shutdown_function('save_language');
	} else {
		
		return $ref;
	}
	
	return $ref;
}

function save_language() {
	if (empty($GLOBALS['config']['debug'])) return; // do nothing in production mode
	foreach ($GLOBALS['phrases_sets'] as $lang) {
		if ($lang == $GLOBALS['config']['lang']) continue; // skip first language
		$phrases =& load_language($lang, false);
		$sorted = $phrases;
		ksort($sorted);
		file_put_contents(DIR . '/includes/language_' . $lang . '.php','<?php $phrases = ' . var_export($sorted, true) . ';');
	}
}

function t($text, $lang = null) {
	// translates
	if ($lang === null) {
		global $phrases;
	} else {
		$phrases =& load_language($lang, false);
	}
	
	if (!isset($phrases[$text])) $phrases[$text] = $text;
	$translated = $phrases[$text];
	
	$args = func_get_args();
	if (count($args) > 1) {
		array_shift($args); //remove $text
		array_shift($args); //remove $lang
		array_unshift($args,$translated);
		$translated = call_user_func_array('sprintf',$args);
	}
	
	return $translated;
}

function p($text) {
	// translates and output use the active language
	$args = func_get_args();
	$text = array_shift($args); // temporary get the text out
	array_unshift($args,null); // to use active language
	array_unshift($args,$text); // bring back the text
	$translated = call_user_func_array('t',$args); // call our translator
	echo $translated;
}