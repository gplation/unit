<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<style>
	.msp-10 { margin:0; padding:0; height:10px; clear:both; }
	.msp-20 { margin:0; padding:0; height:20px; clear:both; }
	.msp-30 { margin:0; padding:0; height:30px; clear:both; }
	.mfa-box { text-align:center; margin: 0px 0px 15px; border: 1px solid rgb(231, 231, 231); transition:0.3s linear; border-image: none; overflow: hidden; position: relative; cursor: default; -webkit-transition: all 0.3s linear; }
	.mfa-box::before { display: table; content: ""; }
	.mfa-box::after { display: table; content: ""; }
	.mfa-box::after { clear: both; }
	.mfa-box h2 { margin: 0px; padding: 12px 15px 0px; color: rgb(51, 51, 51); font-size: 16px; font-weight: 500; text-align:center; }
	.mfa-box p { margin:0px; padding:10px; }
	.mfa-box .mfa-fa { padding: 20px 0px 10px; }
	.mfa-box .mfa-fa i { font-size: 64px; }
	.mfa-box .mfa-list { margin:0px 15px 10px; padding-top:10px; border-top:1px solid rgb(231, 231, 231); text-align:left; }
</style>

<div class="msp-10"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Event</h3>
	<?php echo apms_widget('shop-event-banner', 'idx-shop-event-banner1'); // 쇼핑몰 이벤트 배너 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Hit Item</h3>
	<?php echo apms_widget('shop-item', 'idx-shop-item1'); // 쇼핑몰 아이템 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Recommand Item</h3>
	<?php echo apms_widget('shop-item', 'idx-shop-item2'); // 쇼핑몰 아이템 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Popular Item</h3>
	<?php echo apms_widget('shop-item', 'idx-shop-item3'); // 쇼핑몰 아이템 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Discount Item</h3>
	<?php echo apms_widget('shop-item', 'idx-shop-item4'); // 쇼핑몰 아이템 위젯 ?>
</div>

<div class="msp-30"></div>

<?php echo apms_widget('misc-title-middle','idx-shop-title-middle1'); // 타이틀 위젯 ?>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">New Arrival Item</h3>
	<?php echo apms_widget('shop-item', 'idx-shop-item5'); // 쇼핑몰 아이템 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<div class="row">
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-bell red"></i>
				</div>
				<h2>Notice</h2>
				<p class="text-muted">
					공지사항
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-photo', 'idx-shop-board-photo1'); // 포토목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-comments blue"></i>
				</div>
				<h2>Comments</h2>
				<p class="text-muted">
					상품 댓글
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('shop-post', 'idx-shop-post1'); // 아이템 관련글 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-pencil green"></i>
				</div>
				<h2>Review</h2>
				<p class="text-muted">
					상품구매후기
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('shop-post', 'idx-shop-post2'); // 아이템 관련글 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-question-circle violet"></i>
				</div>
				<h2>Question</h2>
				<p class="text-muted">
					상품문의
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('shop-post', 'idx-shop-post3'); // 아이템 관련글 위젯 ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="msp-20"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Banner</h3>
	<?php echo apms_widget('shop-banner', 'idx-shop-banner'); // 쇼핑몰 배너 위젯 ?>
</div>