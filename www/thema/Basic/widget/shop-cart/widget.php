<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// 초기값
if(!$wset) {
	// 썸네일 크기	
	$wset['thumb_w'] = 100;
	$wset['thumb_h'] = 100;
}

// 효과
switch($wset['effect']) {
	case 'fade'		: $effect = ' slide at-fade'; break;
	case 'up'		: $effect = ' slide at-vertical'; break;
	case 'slide'	: $effect = ' slide'; break;
	default			: $effect = ''; break;
}

// 효과시간
$interval = ($wset['interval']) ? $wset['interval'] : 5000;

// Random Ticker Id
$carousel_id = apms_id();

// 변수정리
$item_cols = (int)$wset['garo'];
$item_cols = ($item_cols > 0) ? $item_cols : 3;
$item_rows = 12 / $item_cols;
$item_xs = (int)$wset['xs'];
$item_xs = ($item_xs < 12) ? ' col-xs-'.$item_xs : '';

// 글추출
$list = apms_cart_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 100;

?>
<div class="carousel<?php echo $effect;?> widget-shop-cart" id="<?php echo $carousel_id;?>" data-ride="carousel" data-interval="<?php echo $interval;?>">

	<div class="carousel-nav">
		<a class="left" href="#<?php echo $carousel_id;?>" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
		<a class="right" href="#<?php echo $carousel_id;?>" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
	</div>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active">
			<div class="row">
				<?php for($i=0; $i < $list_cnt; $i++) { ?>
					<?php if($i > 0 && $i%$item_rows == 0) { ?>
							</div>
						</div>
						<div class="item">
							<div class="row">
					<?php } ?>
						<div class="col-sm-<?php echo $item_cols.$item_xs;?> col">
							<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
								<a href="<?php echo $list[$i]['href'];?>" title="<?php echo $list[$i]['alt'];?>">
									<img src="<?php echo $list[$i]['img'];?>" alt="<?php echo $list[$i]['alt'];?>">
								</a>
							</div>
						</div>
				<?php } ?>
				<?php if(!$list_cnt) { ?>
					<p class="text-muted text-center">장바구니가 비어 있었습니다.</p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php if($setup_href) { ?>
	<p class="btn-wset text-center" style="margin-top:15px;">
		<a href="<?php echo $setup_href;?>" class="win_memo"><span class="text-muted font-12 en"><i class="fa fa-cog"></i> 위젯설정</span></a>
	</p>
<?php } ?>