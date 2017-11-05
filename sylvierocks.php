<?php
	define('MAX_IGNORED',2); // 2 ignored and bye
	define('MAX_SENT',5); // keeps logs of 5 last mails
	define('MIN_INTERVAL', 6 * 86400); // 6 days
	define('DAY_OF_WEEK', 1); // ISO-8601 Monday
?>
Hi. I'm the subscriber's email script...<br/>
<?php require('./includes/config.php'); ?>
Loaded configuration<br/>
<?php require_once(DIR . '/includes/functions_subscribe.php'); ?>
Loaded subscribe functions<br/>
<?php
	if (ccvn_date('N') != DAY_OF_WEEK) {
		die('Halting, reason: DAY_OF_WEEK');
	}
?>
<?php $emails = load_emails(); ?>
<?php $totalSent = isset($emails['total_sent']) ? $emails['total_sent'] : 0; ?>
Loaded emails<br/>
<?php 
	$i = 0;
	foreach ($emails as $email => &$conf):
		if (substr_count($email,'@') != 1) continue;
?>
(<?php echo ++$i; ?>) Processing <?php echo $email; ?><br/>
<?php
	$ignored = 0;
	$lastSent = 0;
	foreach ($conf['sent'] as $hash => $sent) {
		if (empty($sent['clicked'])) $ignored++; else $ignored = 0; // only checks for continuous ignores
		$lastSent = $sent['datetime'];
	}
	$interval = time() - $lastSent;
	if (MIN_INTERVAL > 0 AND $interval < MIN_INTERVAL):
?>
<div style="color: red">Just sent recently (<?php echo $interval; ?> seconds ago), skipped sending for now...</div>
<?php
		continue;
	endif;
	if (MAX_IGNORED > 0 AND $ignored >= MAX_IGNORED):
?>
<div style="color: red">Ignored <?php echo $ignored; ?>, skipped sending more...</div>
<?php
		continue;
	endif;
	// sending mails
	$hash = md5($email . $conf['total_sent']);
	$lang = $conf['lang'];
	$link = l('home',true,$lang,array('full' => true,'params' => array('email' => $email, 'h' => $hash)));
	$subject = t('Chao co buoi sang ngay %1$s',$lang,ccvn_date('d/m'));
	
	$name = t('Chào Cờ Việt Nam',$lang);
	$staff = t('Ban quản trị %1$s',$lang,$name);
	$mp = array( //message phrases
		'greeting' => t('Xin chào bạn thân mến,',$lang),
		'intro' => t('Đây là thư mời gửi đến bạn từ trang mạng %1$s mà bạn đã tham gia vào ngày %2$s.'
			,$lang
			,'<a href="' . $link . '">' . $name . '</a>'
			,ccvn_date('d-m-Y',$conf['subscribed'])),
		'wish' => t('%1$s mong muốn được gửi tới bạn lời chúc tốt lành cho một ngày mới.',$lang,$staff),
		'invite' => t('Tất nhiên, đừng quên ghé thăm chúng tôi và tiếp tục chào cờ hàng tuần tại đây: ',$lang),
		'invite2' => t('Nếu bạn không ấn được vào đường dẫn ở trên, xin vui lòng sao chép đường dẫn dưới đây'
			. ' và đưa vào khung địa chỉ trong trình duyệt của bạn: ',$lang),
		'wish2' => t('Một lần nữa, chúc bạn có một ngày tràn đầy thành công.',$lang),
		'signature' => $staff,
		'exclaimer' => t('Thư điện tử này được gửi tự động từ máy chủ của %1$s dựa trên yêu cầu tham gia từ IP %2$s '
			. 'được gửi vào thời điểm %3$s. Nếu bạn không muốn tiếp tục nhận thư mời này, xin vui lòng bỏ qua và hệ thống '
			. 'sẽ tự động ngừng gửi cho bạn sau %4$d lần. Nếu bạn cần liên lạc với chúng tôi, xin vui lòng gửi thư điện tử '
			. 'về địa chỉ %5$s'
			,$lang
			,$name
			,$conf['IP']
			,ccvn_date('H:i:s d-m-Y',$conf['subscribed'])
			,MAX_IGNORED
			,$GLOBALS['config']['contact_email']),
	);
	
	$message = <<<EOF
<html>
<body style="font-family: Verdana, Arial, Georgia; text-align: justify">
<p>$mp[greeting]</p>
<p style="font-size: 0.8em">$mp[intro]</p>
<p>$mp[wish] $mp[invite]</p>
<p style="text-align: center"><a href="$link">$name</a></p>
<p>$mp[invite2]</p>
<p style="text-align: center">$link</p>
<p>$mp[wish2]</p>
<p style="text-align: right; font-size: 0.8em">$mp[signature]</p>
<p style="font-size: 0.6em; color: #767676; border-top: 1px solid #767676;">$mp[exclaimer]</p>
</body>
</html>
EOF;
	if (ccvn_mail($email,$subject,$message) === true) {
?>
Email was sent successfully.<br/>
<?php
		$conf['sent'][$hash] = array(
			'datetime' => time(),
		);
		$conf['total_sent']++;
		if (!isset($emails['total_sent'])) {
			$emails['total_sent'] = 0;
		}
		$emails['total_sent']++;
	} else {
?>
<div style="color: red">Email couldn't be sent.</div>
<?php
	}
	if (count($conf['sent']) > MAX_SENT) {
		$conf['sent'] = array_slice($conf['sent'],-1 * MAX_SENT);
	}
?>
<?php endforeach; ?>
<?php
	if (isset($emails['total_sent']) && $emails['total_sent'] > $totalSent) {
		save_emails($emails);
	}
?>
Finished. Cya!