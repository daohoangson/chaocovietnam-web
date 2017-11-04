<h2><?php p('Dịch thuật'); ?></h2>
<?php if ($GLOBALS['runtime']['lang'] == $GLOBALS['config']['lang'] OR empty($GLOBALS['config']['debug'])): ?>
<div class="warning">
	<?php p('Bạn không thể dịch ngôn ngữ này'); ?>
</div>
<?php elseif (!empty($_POST)): ?>
<?php
	// process translated phrases
	$updated = array();
	$hashes = array();

	$phrases =& load_language(null,false);
	foreach (array_keys($phrases) AS $original) {
		$hashes[md5($original)] = $original;
	}
	foreach ($_POST['translated'] AS $hash => $translated) {
		$original = $hashes[$hash];
		if ($phrases[$original] != $translated) {
			// this phrase was updated
			$updated[$original] = $translated;
		}
	}
	if (count($updated) > 0) {
		foreach ($updated as $original => $translated) {
			$phrases[$original] = $translated;
		}

		save_language($GLOBALS['runtime']['lang']);
	}
?>
<div class="message">
<?php p('Cám ơn bạn. Đã cập nhật %1$d bản dịch.',count($updated)); ?> 
<a href="<?php l('translate'); ?>"><?php p('Tiếp tục...'); ?></a>
</div>
<?php else: ?>
<div class="translating">
	<form action="<?php l('translate'); ?>" method="POST">
	<?php
		$phrases = load_language(null,false);
		foreach ($phrases as $original => $translated):
	?>
	<div class="phrase<?php if ($original == $translated): ?> needtranslation<?php endif; ?>">
		<div class="original"><?php p('Chuỗi ký tự gốc'); ?>: "<em><?php echo htmlspecialchars($original); ?></em>"</div>
		<div class="translated"><textarea name="translated[<?php echo md5($original); ?>]"><?php echo htmlspecialchars($translated); ?></textarea></div>
	</div>
	<?php endforeach; ?>
	<input type="submit" value="<?php p('Lưu bản dịch'); ?>" class="button"/>
	</form>
</div>
<script type="text/javascript">
function textareaResize(e) {
	$t = $(e.target);
	var sH = $t.attr('scrollHeight');
	var h = $t.attr('clientHeight');
	if (typeof e.target.oH == 'undefined') {
		e.target.oH = h;
		var oH = h;
	} else {
		var oH = e.target.oH;
	}
	if (sH > h) $t.animate({height:sH});
}

function setupTextareaAutoResize() {
	$('.translated textarea').change(textareaResize).change();
}

$(document).ready(setupTextareaAutoResize);
</script>
<?php endif; ?>