<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if(IS_YC && IS_SHOP) { // Shop Side
	@include_once (THEMA_PATH.'/shop.side.php');
	return;
} 

?>

<h3 class="side-title">Categories</h3>
<div class="widget">
	<?php echo apms_widget('misc-category'); // 카테고리 위젯?>
</div>

<h3 class="side-title">Search</h3>
<div class="widget widget-highlight">
	<?php echo apms_widget('misc-search'); // 검색폼 위젯 ?>
</div>

<h3 class="side-title">Tags</h3>
<div class="widget">
	<?php echo apms_widget('misc-tag', 'side-tag'); // 태그 위젯 ?>
</div>

<h3 class="side-title">Popular</h3>
<div class="widget">
	<?php echo apms_widget('misc-popular', 'side-popular'); // 인기검색어 위젯 ?>
</div>

<h3 class="side-title">Poll</h3>
<div class="widget">
	<?php echo apms_widget('misc-poll', 'side-poll'); // 설문조사 위젯 ?>
</div>

<h3 class="side-title">Recently</h3>
<div class="widget">
	<div class="tabs">
		<ul class="nav nav-tabs en font-12">
			<li class="active"><a href="#side-recently1" data-toggle="tab">포스트</a></li>
			<li><a href="#side-recently2" data-toggle="tab">코멘트</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="side-recently1">
				<?php echo apms_widget('board-photo', 'side-board-photo1'); // 포토목록 위젯 ?>
			</div>
			<div class="tab-pane" id="side-recently2">
				<?php echo apms_widget('board-photo', 'side-board-photo2'); // 포토목록 위젯 ?>
			</div>
		</div>
	</div>
</div>
