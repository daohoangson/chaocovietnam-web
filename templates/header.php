<!DOCTYPE html>
<html>
<head>
	<title><?php p('Chao co Viet Nam'); ?></title>
	<base href="<?php echo $GLOBALS['config']['url']; ?>" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
	<meta name="google-site-verification" content="2t30n9d1dmTB_73CXhi9Fm1SKBAIe6M1pMGIJEG8-KQ" />
	<META NAME="keywords" content="Chao co, Viet Nam, Chào cờ, Việt Nam, Quốc kỳ, Quốc ca"> 
	<META NAME="description" CONTENT="Chào cờ Việt Nam"> 
	<META property="og:title" content="Chào cờ Việt Nam"/>
	<META property="og:description" content="2 phút mỗi tuần"/>
	<META property="og:type" content="activity"/>
	<META property="og:image" content="http://chaocovietnam.net/assets/Vietnam_Flag.gif"/>
	<META property="og:url" content="http://chaocovietnam.net/"/>
	<META property="og:site_name" content="Chao Co Viet Nam"/>
	<META property="fb:admins" content="2392950137,723610826"/>
	<?php if (empty($GLOBALS['config']['debug'])): ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<?php else: ?>
	<script type="text/javascript" src="assets/jquery.js"></script>
	<script type="text/javascript">
		var $ = jQuery;
	</script>
	<?php endif; ?>
	<script type="text/javascript" src="assets/chaocovietnam<?php if (empty($GLOBALS['config']['debug'])) echo '.min'; ?>.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/chaocovietnam<?php if (empty($GLOBALS['config']['debug'])) echo '.min'; ?>.css" /> 
</head>
<body>
<div id="above_content">
<?php if (!empty($GLOBALS['config']['debug'])): ?>
<div id="debug">WARNING: RUNNING IN DEBUG MODE. PLEASE DO NOT FORGET TO TURN IT OFF!!!!</div>
<?php endif; ?>
</div>
<div id="content">