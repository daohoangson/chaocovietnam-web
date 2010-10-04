
</div><!-- #content -->
<div id="below_content">
<ul class="menu page_<?php echo $GLOBALS['displayed']; ?>">
	<?php
		foreach ($GLOBALS['config']['langs'] AS $lang => $lang_name) {
			if ($lang == $GLOBALS['runtime']['lang']) continue;
			echo '<li class="language"><a href="' . l('this',true,$lang) . '">' . $lang_name . '</a></li>';
		}
	?>
	<?php if (!empty($GLOBALS['config']['debug']) AND $GLOBALS['runtime']['lang'] != $GLOBALS['config']['lang']): ?>
	<li><a id="goto_translate" href="<?php l('translate'); ?>"><?php p('Dịch thuật'); ?></a></li>
	<?php endif; ?>
	<li><a id="goto_coa" href="<?php l('coa'); ?>"><?php p('Quốc huy'); ?></a></li>
	<li><a id="goto_anthem" href="<?php l('anthem'); ?>"><?php p('Quốc ca'); ?></a></li>
	<li><a id="goto_flag" href="<?php l('flag'); ?>"><?php p('Quốc kỳ'); ?></a></li>
	<li><a id="goto_home" href="<?php l('home'); ?>"><?php p('Chào cờ'); ?></a></li>
</ul>
<div id="footer">
	<div><?php p('Chào Cờ Việt Nam'); ?><sup><?php echo $GLOBALS['config']['version']; ?></sup> <?php echo date('Y'); ?></div>
	<div>
		<a href="<?php l('home'); ?>"><?php p('Trang chủ'); ?></a>
		<a href="<?php l('subscribe'); ?>"><?php p('Chào cờ hàng tuần'); ?></a>
		<a href="<?php l('copyright'); ?>"><?php p('Bản quyền'); ?></a>
		<a href="<?php l('aboutus'); ?>"><?php p('Thông tin'); ?></a>
		<a href="<?php l('contact'); ?>"><?php p('Liên hệ'); ?></a>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(fitContent);
</script>
<?php if (empty($GLOBALS['config']['debug'])) : ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18365237-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php endif; ?>
</body>
</html>