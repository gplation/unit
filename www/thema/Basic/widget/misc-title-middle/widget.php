<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// 배경색
$bgcolor = ($wset['banner']) ? $wset['banner'] : 'color';

?>
<div class="widget-misc-title-middle<?php echo (G5_IS_MOBILE) ? '' : ' bg-fixed';?><?php echo ($wset['bg']) ? ' bg-'.$wset['color'] : ' bg-black';?>" id="mbg" style="background-image: url('<?php echo $wset['bg'];?>');">
	<div class="container text-center <?php echo $wset['color'];?>">
		<h4><i class="fa fa-paper-plane fa-4x"></i></h4>
		<h2>Created for APMS &amp; Maximum Responsiveness</h2>
		<p>
			Support for G5 &amp; YC5 / PC &amp; Mobile / IE9+, Chrome, Safari, Opera, Swing, etc
			<br>
			Maximum Responsiveness
		</p>

	</div>

	<?php if($setup_href) { ?>
		<p class="btn-wset text-center">
			<a href="<?php echo $setup_href;?>" class="win_memo"><span class="text-muted font-14 en"><i class="fa fa-cog"></i> 위젯설정</span></a>
		</p>
		<br>
	<?php } ?>
</div>

<div class="widget-misc-title-middle-banner bg-<?php echo $bgcolor;?>">
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
