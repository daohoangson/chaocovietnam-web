<?php
$roots = array(
	'assets/' => 300,
	// 'http://ponology.com/chaocovietnam/assets/' => 300,
	// 'http://yega.game4v.vn/mrpaint/' => 30,
	// 'http://halongvip.com/chaocovietnam/' => 15,
);

/* Determines $root */
$roots_raw = array();
$ms = -1;
foreach ($roots as $_root => $_ms) {
	$ms = max($ms,$_ms);
}
foreach ($roots as $_root => $_ms) {
	for ($i = 0; $i < ceil($ms/$_ms); $i++) {
		$roots_raw[] = $_root;
	}
}
$root = $roots_raw[rand(0,count($roots_raw)-1)];
/* $root is found */

$flag = array(
	'link' => $root . 'Vietnam_Flag.gif',
	'width' => 900,
	'height' => 600,
);
$anthem = array();
$anthem['mp3'] = $root . 'Vietnam_National_Anthem_-_Tien_Quan_Ca.mp3';
$anthem['ogg'] = $root . 'Vietnam_National_Anthem_-_Tien_Quan_Ca.ogg';
$anthem['flash'] = $root . 'player.swf?file=' . urlencode($anthem['mp3']) . '&as=0';
?>
	<div id="primary">
		<img id="flag" src="<?php echo $flag['link']; ?>" width="<?php echo $flag['width']; ?>" height="<?php echo $flag['height']; ?>" alt="<?php p('Quốc kỳ nước Cộng hòa Xã hội Chủ nghĩa Việt Nam'); ?>" title="<?php p('Quốc kỳ'); ?>"/>
	</div>
	<div id="secondary">
		<div id="anthem_lyrics">
			<h3><?php p('Tiến Quân Ca'); ?></h3>
			<h4><?php p('Nhạc và lời: Văn Cao.'); ?></h4>
<?php
	$lyrics = array(
		'0.1' => '&nbsp;',
		'8.0' => 'Đoàn quân Việt Nam đi',
		'11.5' => 'Chung lòng cứu quốc',
		'14.5' => 'Bước chân dồn vang trên đường gập ghềnh xa',
		'20.0' => 'Cờ in máu chiến thắng mang hồn nước,',
		'26.0' => 'Súng ngoài xa chen khúc quân hành ca.',
		'32.0' => 'Đường vinh quang xây xác quân thù,',
		'37.0' => 'Thắng gian lao cùng nhau lập chiến khu.',
		'43.5' => 'Vì nhân dân chiến đấu không ngừng,',
		'48.5' => 'Tiến mau ra sa trường,',
		'52.5' => 'Tiến lên, cùng tiến lên.',
		'60.0' => 'Nước non Việt Nam ta vững bền.',
		'<br/>',
		'67.0' => 'Đoàn quân Việt Nam đi',
		'70.0' => 'Sao vàng phấp phới',
		'72.5' => 'Dắt giống nòi quê hương qua nơi lầm than',
		'77.5' => 'Cùng chung sức phấn đấu xây đời mới,',
		'84.0' => 'Đứng đều lên gông xích ta đập tan.',
		'89.0' => 'Từ bao lâu ta nuốt căm hờn,',
		'94.0' => 'Quyết hy sinh đời ta tươi thắm hơn.',
		'100.5' => 'Vì nhân dân chiến đấu không ngừng,',
		'106.5' => 'Tiến mau ra sa trường,',
		'109.5' => 'Tiến lên, cùng tiến lên.',
		'117.5' => 'Nước non Việt Nam ta vững bền.',
		'127.5' => '&nbsp;',
	);
	foreach ($lyrics as $second => $text) {
		if (is_string($second)) {
			$text = t($text);
			echo "\t\t\t<div id=\"al$second\">$text</div>\n";
		} else {
			echo $text;
		}
	}
?>
		</div>
	</div>
	<div id="subscribe_simple">
	<div id="subscribe_inner">
	<?php display('subscribe',array('simple' => true)); ?>
	</div>
	</div>
	<script type="text/javascript">
	var anthem = {
		"mp3": "<?php echo $anthem['mp3']; ?>",
		"ogg": "<?php echo $anthem['ogg']; ?>",
		"flash": "<?php echo $anthem['flash']; ?>",
		"alt": "<?php p('Quốc ca nước Cộng hòa Xã hội Chủ nghĩa Việt Nam'); ?>",
		"title": "<?php p('Quốc ca'); ?>"
	};
	function setup() {
		setupAnthem();
		scaleFlag(150);
		setupSubscribe();
	}
	$(document).ready(setup);
	</script>
	<?php if (empty($GLOBALS['config']['debug'])): ?>
	<div id="social">
		<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://chaocovietnam.net" data-text="Chào cờ Việt Nam!" data-count="horizontal" data-via="mrpaint">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
		<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fchaocovietnam.net&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=recommend&amp;font=verdana&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
	</div>
	<?php endif; ?>