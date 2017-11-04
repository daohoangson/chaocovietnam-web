<h2><?php p('Chào cờ ở Quảng trường Ba Đình'); ?></h2>
<div class="text nobar">
	<p>
		<?php p('Đoạn phim dưới đây được lấy từ báo Tuổi Trẻ (tuoitre.vn).'); ?>
		<?php p('Lễ chào cờ ở Quảng trường Ba Đình được thực hiện vào 6 giờ sáng hàng ngày.'); ?>
		<?php p('Trong tiếng Quốc ca hào hùng, lá cờ Tổ quốc được đội danh dự kéo lên, tung bay trước lăng Chủ tịch Hồ Chí Minh'); ?>
	</p>
	<div class="embed vimeo">
		<a name="vimeo"></a>
		<p>
			<?php p('Xem đoạn phim từ trang %s.','<a href="http://vimeo.com/15697539" class="goto" target="_blank">Vimeo.com</a>'); ?>
			<a href="<?php l('badinh') ?>#youtube" class="switch"><?php p('Chuyển sang trang khác.'); ?></a>
		</p>
		<div class="player-container">
			<iframe src="http://player.vimeo.com/video/15697539?byline=0&amp;portrait=0&amp;color=ff0000" frameborder="0" class="player"></iframe>
		</div>
	</div>
	<div class="embed youtube">
		<a name="youtube"></a>
		<p>
			<?php p('Xem đoạn phim từ trang %s.','<a href="http://www.youtube.com/watch?v=9W-cURHsp7E" class="goto" target="_blank">YouTube.com</a>'); ?>
			<a href="<?php l('badinh') ?>#dailymotion" class="switch"><?php p('Chuyển sang trang khác.'); ?></a>
		</p>
		<div class="player-container">
			<iframe src="http://www.youtube.com/embed/9W-cURHsp7E?rel=0" frameborder="0" class="player"></iframe>
		</div>
	</div>
	<div class="embed dailymotion">
		<a name="dailymotion"></a>
		<p>
			<?php p('Xem đoạn phim từ trang %s.','<a href="http://www.dailymotion.com/video/xf4ym2" class="goto" target="_blank">DailyMotion.com</a>'); ?>
			<a href="<?php l('badinh') ?>#vimeo" class="switch"><?php p('Chuyển sang trang khác.'); ?></a>
		</p>
		<div class="player-container">
			<iframe frameborder="0" src="http://www.dailymotion.com/embed/video/xf4ym2?width=480&theme=none&foreground=%23FF0000&highlight=%23FFFF00&background=%23000000&additionalInfos=1&hideInfos=1&start=&animatedTitle=&iframe=1&autoPlay=0" class="player"></iframe>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var sites = ['vimeo','youtube','dailymotion'];
	$('.embed').css('display','none').find('.switch').click(function(e){
		$parent = $(this).parent().parent();
		var list = $parent.attr('class').split(/\s+/);
		for (var i = 0; i < sites.length; i++) {
			for (var j = 0; j < list.length; j++) {
				if (sites[i] == list[j]) {
					var next = (i == sites.length - 1)?0:(i + 1);
					$parent.css('display','none');
					$('.' + sites[next]).css('display','');
				}
			}
		}
		return false;
	});
	$('.vimeo').css('display','');
});
</script>