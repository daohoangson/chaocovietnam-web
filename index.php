<?php
require_once('./includes/config.php');
require(DIR . '/templates/header.php');

$displayVariables = compact('params');
foreach ($config['pages'] as $page) {
	if (isset($params[$page])) {
		display($page, $displayVariables);
	}
}
if (!displayed()) display('home', $displayVariables);

require(DIR . '/templates/footer.php');