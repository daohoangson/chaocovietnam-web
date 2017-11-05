<?php
define('DIR',dirname(dirname(__FILE__)));

$config = array(
	'version' => '2.0',
	'url' => 'https://chaocovietnam.net/',
	'langs' => array(
		'vi' => 'Tiếng Việt',
		'en' => 'English',
	),
	'lang' => 'vi',
	'pages' => array(),
	'debug' => $_SERVER['SERVER_SOFTWARE'] === 'Development/2.0',
	'rewrite' => true,
	'contact_email' => 'lienhe@chaocovietnam.net',
	'admin_email' => 'chaocovietnam@daohoangson.com',
);
$runtime = array(
	'lang' => $config['lang'],
);

// gets list of pages
$dh = opendir(DIR . '/templates');
$page_suffix = '.page.php';
while ($file = readdir($dh)) {
	if (substr($file,-1 * strlen($page_suffix)) == $page_suffix) {
		$config['pages'][] = substr($file,0,-1 * strlen($page_suffix));
	}
}

// processes our parametters
$params = array();
if (!empty($_SERVER['REQUEST_URI']) &&
	$_SERVER['REQUEST_URI'][0] === '/' &&
	substr($_SERVER['REQUEST_URI'], -4) === '.htm'
) {
	$parts = explode('/', preg_replace('#\.htm$#', '', $_SERVER['REQUEST_URI']), 3);
	array_shift($parts);
	if (isset($config['langs'][$parts[0]])) {
		$runtime['lang'] = $parts[0];
		array_shift($parts);
	}
	$params[implode('/', $parts)] = '';
}
foreach ($_GET as $key => $value) {
	$params[$key] = $value;
}

// loads languages
require_once(DIR . '/includes/functions_language.php');
load_language();

// loads functions
require_once(DIR . '/includes/functions.php');