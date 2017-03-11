<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// 효과
switch($wset['effect']) {
	case 'fade'		: $effect = ' slide at-fade'; break;
	case 'up'		: $effect = ' slide at-vertical'; break;
	case 'slide'	: $effect = ' slide'; break;
	default			: $effect = ''; break;
}

// 효과시간
$interval = ($wset['interval'] > 0) ? $wset['interval'] : 'false';

// Random Ticker Id
$carousel_id = apms_id();
?>

<div class="carousel<?php echo $effect;?> amina-widget-newsticker" id="<?php echo $carousel_id;?>" data-ride="carousel" data-interval="<?php echo $interval;?>">
	<div class="carousel-inner">
	<?php if($setup_href) { ?>
		<span class="btn-wset pull-left" style="position:relative;z-index:9999;">
			<a href="<?php echo $setup_href;?>" class="win_memo"><i class="fa fa-cog"></i> 위젯설정 &nbsp;</a>
		</span>
	<?php } ?>
	<?php 
		if($wset['cache'] > 0) { // 캐시적용시
			echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
		} else {
			include($widget_path.'/widget.rows.php');
		}
	?>
	</div>
</div>
