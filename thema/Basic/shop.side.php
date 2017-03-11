<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<h3 class="side-title">Categories</h3>
<div class="widget">
	<?php echo apms_widget('misc-category'); // 카테고리 위젯?>
</div>

<h3 class="side-title">Event</h3>
<div class="widget">
	<?php echo apms_widget('shop-event-banner', 'side-shop-event-banner1'); // 쇼핑몰 이벤트 배너 위젯 ?>
</div>

<h3 class="side-title">Cart</h3>
<div class="widget">
	<?php echo apms_widget('shop-cart', 'side-shop-cart'); // 쇼핑몰 카트 위젯 ?>
</div>

<h3 class="side-title">Search</h3>
<div class="widget widget-highlight">
	<?php echo apms_widget('misc-search'); // 검색폼 위젯 ?>
</div>

<h3 class="side-title">Tags</h3>
<div class="widget">
	<?php echo apms_widget('misc-tag', 'side-tag'); // 태그 위젯 ?>
</div>

<h3 class="side-title">Recently</h3>
<div class="widget">
	<div class="tabs">
		<ul class="nav nav-tabs en font-12">
			<li class="active"><a href="#shop-recently1" data-toggle="tab">댓글</a></li>
			<li><a href="#shop-recently2" data-toggle="tab">후기</a></li>
			<li><a href="#shop-recently3" data-toggle="tab">문의</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="shop-recently1">
				<?php echo apms_widget('shop-post', 'side-shop-post1'); // 아이템 관련글 위젯 ?>
			</div>
			<div class="tab-pane" id="shop-recently2">
				<?php echo apms_widget('shop-post', 'side-shop-post2'); // 아이템 관련글 위젯 ?>
			</div>
			<div class="tab-pane" id="shop-recently3">
				<?php echo apms_widget('shop-post', 'side-shop-post3'); // 아이템 관련글 위젯 ?>
			</div>
		</div>
	</div>
</div>

<h3 class="side-title">Banner</h3>
<div class="widget">
	<?php echo apms_widget('shop-banner', 'side-shop-banner'); // 쇼핑몰 배너 위젯 ?>
</div>