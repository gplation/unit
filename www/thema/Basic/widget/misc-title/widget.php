<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

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
$interval = ($wset['interval']) ? $wset['interval'] : 5000;

// 배경색
$bgcolor = ($wset['banner']) ? $wset['banner'] : 'color';

// Random Ticker Id
$carousel_id = apms_id();

// 동영상
$video_url = ($wset['auto']) ? $wset['video'].'|auto=1' : $wset['video'];

?>

<div id="<?php echo $carousel_id;?>" class="carousel<?php echo $effect;?> widget-misc-title" data-ride="carousel" data-interval="<?php echo $interval;?>">
	 <!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#<?php echo $carousel_id;?>" data-slide-to="0" class="active"></li>
		<li data-target="#<?php echo $carousel_id;?>" data-slide-to="1"></li>
	</ol>

	<div class="carousel-inner">
		<div class="item active" id="bg1" style="background-image:url('<?php echo $wset['bg1'];?>');">
			<div class="container">
				<div class="description fluid-center">
					<span class="title" style="text-transform:uppercase"><b>APMS Basic Thema</b></span>
					<span class="subtitle">Created for APMS & Maximum Responsiveness.</span>
					<span class="features">
						<i class="fa fa-html5"></i>
						<i class="fa fa-css3"></i>
						<i class="fa fa-twitter"></i>
					</span>
				</div>
			</div>
		</div> 
		<div class="item" id="bg2" style="background-image:url('<?php echo $wset['bg2'];?>');">
			<div class="container">
				<div class="description">
					<span class="title" style="text-transform:uppercase"><b>APMS Basic Thema</b></span>
					<span class="subtitle">Create thema Based on Bootstrap3</span>
					<ul class="carousel-item-list">
						<li><i class="fa fa-check-square"></i> Support for G5/YC5 </li>
						<li><i class="fa fa-check-square"></i> Support for PC & Mobile</li>
						<li><i class="fa fa-check-square"></i> Support for IE8+, Chrome, Safari, Opera, Swing, etc</li>
						<li><i class="fa fa-check-square"></i> Maximum Responsiveness</li>
					</ul>
				</div>
				<div class="object">
					<?php thema_widget_video($video_url, 717, 320); ?>
				</div>
			</div>
		</div>       
	</div>
	
	<!-- Controls -->
	<a class="left carousel-control" href="#<?php echo $carousel_id;?>" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#<?php echo $carousel_id;?>" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>

	<?php if($setup_href) { ?>
		<p class="btn-wset text-center" style="position:absolute; bottom:12px; right:100px; z-index:9999;">
			<a href="<?php echo $setup_href;?>" class="win_memo"><span class="text-muted font-14 en"><i class="fa fa-cog"></i> 위젯설정</span></a>
		</p>
	<?php } ?>
</div>

<div class="widget-misc-title-banner bg-<?php echo $bgcolor;?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="ticker">
					<?php echo apms_widget('board-newsticker', $wid.'-newsticker'); // 뉴스티커 위젯(아이디 자동부여) ?>
				</div>
			</div>
			<div class="col-sm-4">
				<a class="btn btn-trans pull-right" href="http://amina.co.kr/shop/item.php?it_id=beer">
					<i class="fa fa-beer"></i> Buy me a beer
				</a>
			</div>
		</div>
	</div>
</div>
