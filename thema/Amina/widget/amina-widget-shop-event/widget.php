<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// 초기값
if(!$wset) {
	// 썸네일 크기	
	$wset['thumb_w'] = 400;
	$wset['thumb_h'] = 225;
	$wset['slide'] = 2;
	$wset['garo'] = 6; // Grid Col 값
	$wset['sero'] = 1;
	$wset['title'] = '타이틀 입력';
}

// 효과
switch($wset['effect']) {
	case 'fade'		: $effect = ' slide at-fade'; break;
	case 'up'		: $effect = ' slide at-vertical'; break;
	case 'slide'	: $effect = ' slide'; break;
	default			: $effect = ''; break;
}

// 효과시간
$interval = ($wset['interval']) ? $wset['interval'] : 'false';

// Random Ticker Id
$carousel_id = apms_id();

?>

<div class="amina-widget-shop-event">
	<div class="widget-head">
		<a<?php echo ($wset['tlink']) ? ' href="'.$wset['tlink'].'"' : '';?>>
			<?php echo $wset['title'];?>
		</a>
	</div>
	<div class="widget-body">
		<div class="carousel<?php echo $effect;?>" id="<?php echo $carousel_id;?>" data-ride="carousel" data-interval="<?php echo $interval;?>">
			<div class="carousel-nav">
				<a class="left" href="#<?php echo $carousel_id;?>" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
				<a class="right" href="#<?php echo $carousel_id;?>" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
			</div>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
				<?php 
					if($wset['cache'] > 0) { // 캐시적용시
						echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
					} else {
						include($widget_path.'/widget.rows.php');
					}
				?>
				</div>
			</div>
		</div>
	</div>

	<?php if($setup_href) { ?>
		<p class="btn-wset text-center">
			<a href="<?php echo $setup_href;?>" class="win_memo">
				<span class="text-muted font-12 en"><i class="fa fa-cog"></i> 위젯설정</span>
			</a>
		</p>
	<?php } ?>
</div>
