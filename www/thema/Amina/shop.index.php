<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<style>
	.msp-10 { margin:0; padding:0; height:10px; clear:both; }
	.msp-20 { margin:0; padding:0; height:20px; clear:both; }
	.msp-30 { margin:0; padding:0; height:30px; clear:both; }
</style>

<?php echo apms_widget('amina-widget-shop-event', 'amina-idx-shop-event'); // 쇼핑몰 이벤트 위젯 ?>

<div class="msp-10"></div>

<?php echo apms_widget('amina-widget-shop-item', 'amina-idx-shop-item1'); // 쇼핑몰 아이템 위젯 ?>

<div class="msp-10"></div>

<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-shop-post', 'amina-idx-shop-post1'); // 쇼핑몰 포스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-shop-post', 'amina-idx-shop-post2'); // 쇼핑몰 포스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-shop-post', 'amina-idx-shop-post3'); // 쇼핑몰 포스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>

<?php echo apms_widget('amina-widget-shop-banner', 'amina-idx-shop-banner'); // 쇼핑몰 배너 위젯 ?>

<div class="msp-10"></div>
