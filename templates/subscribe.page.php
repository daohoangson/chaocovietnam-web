<?php
	if (empty($simple)) {
		require_once(DIR . '/includes/functions_subscribe.php');
		$emails = load_emails();
	}
?>
<h2><?php p('Chào cờ hàng tuần'); ?></h2>
<?php if (empty($simple) AND !empty($_POST['email'])): ?>
<?php
	$email = $_POST['email'];
	$invalid = false;
	// doing basic email syntax check
	if (!preg_match('/^[' . chr(32) . '-' . chr(126) . ']+$/', $email)){
		// detected non-ANSII characters, hmm...
		$invalid = 'ansii';
	} else if (substr_count($email,'@') != 1) {
		// having more than one @ is simply inacceptable
		$invalid = '@';
	} else {
		$parts = explode('@',$email);
		$local = $parts[0];
		$domain = $parts[1]; // $parts should only have 2 elements due to previous substr_count
		if (strlen($local) > 64) {
			// too many characters for local part
			$invalid = '64_chars';
		} else {
			if (substr($local,0,1) == '.' OR substr($local,-1) == '.' OR strpos($local,'..') !== false) {
				// bad position of dot(s)
				$invalid = 'dots';
			} else {
				if (strlen($domain) > 255) {
					// too long domain
					$invalid = '255_chars';
				} else {
					// open a connection to the domain to validate it
					$hh = @fsockopen($domain,80,$errno,$errstr,10);
					if (empty($hh)) {
						// bad domain name
						$invalid = 'bad_domain';
					} else {
						fclose($hh);
					}
				}
			}
		}
	}
	
	if ($invalid !== false) {
		ccvn_mail($GLOBALS['config']['admin_email'],'Bad email',$email . ' - ' . $invalid);
	} else {
		if (isset($emails[$email])) {
			// subscribe again?
		} else {
			$emails[$email] = array(
				'subscribed' => time(),
				'IP' => $_SERVER['REMOTE_ADDR'],
				'lang' => $GLOBALS['runtime']['lang'],
				'total_sent' => 0,
				'sent' => array(),
			);
			save_emails($emails);
		}
	}
?>
<div class="message">
<?php if ($invalid === false): ?>
<?php p('Cám ơn bạn đã tham gia với chúng tôi. Chúc bạn một ngày vui vẻ.'); ?>
<?php else: ?>
<?php p('Địa chỉ thư điện tử của bạn đã được ghi nhận. Có lỗi trong quá trình xác thực địa chỉ email của bạn vì vậy Ban quản trị sẽ kiểm tra và thông báo lại cho bạn sau. Chúc bạn một ngày vui vẻ.'); ?>
<?php endif; ?>
</div>
<?php else: ?>
<div class="text nobar">
	<p><?php p('Điền địa chỉ thư điện tử của bạn vào đây và chúng tôi sẽ gửi thư mời cho bạn vào sáng thứ Hai hàng tuần.'); ?>
	<?php p('Chúng tôi cam đoan không sử dụng địa chỉ thư điện tử của bạn vào bất cứ mục đích nào khác.'); ?>
	<?php p('Thêm vào đó, hệ thống sẽ tự động ngừng gửi thư mời nếu bạn bỏ qua 02 thư liên tiếp của chúng tôi.'); ?></p>
	<form id="subscribe_form" action="<?php l('subscribe'); ?>" method="POST">
		<input type="text" name="email"/>
		<input type="submit" value="<?php p('Tham gia'); ?>"/>
	</form>
	<?php if (empty($simple) AND count($emails) > 1): ?>
	<p><?php p('Hãy tham gia chào cờ hàng tuần cùng với chúng tôi!'); ?></p>
	<ol>
		<?php foreach (array_keys($emails) AS $email): ?>
		<?php $parts = explode('@',$email); if (count($parts) != 2) continue; $username = $parts[0]; $domain = $parts[1]; $censored = substr($username,0,max(0,min(3,strlen($username) - 4))) . '...@' . $domain; ?>
		<li><?php echo $censored; ?></li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>
</div>
<?php endif; ?>