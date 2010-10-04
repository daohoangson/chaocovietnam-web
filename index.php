<?php
require_once('./includes/config.php');
require(DIR . '/templates/header.php');

foreach ($config['pages'] as $page) {
	if (isset($params[$page])) {
		display($page);
	}
}
if (!displayed()) display('home');

require(DIR . '/templates/footer.php');