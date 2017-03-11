<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(IS_YC && IS_SHOP) { // Shop Index
	@include_once (THEMA_PATH.'/shop.index.php');
	return;
} 

?>
<style>
	.idx-10 { margin:0; padding:0; height:10px; clear:both; }
	.idx-20 { margin:0; padding:0; height:20px; clear:both; }
	.idx-30 { margin:0; padding:0; height:30px; clear:both; }
</style>

<?php //echo apms_widget('amina-widget-webzine', 'amina-idx-webzine1'); // 웹진 위젯 ?>

<div class="idx-10"></div>

<!-- 구글광고 배너 삽입 : 신재훈 20150905 -->
		<center>
		<?php if(G5_IS_MOBILE) { ?>
		<script type="text/javascript">
			google_ad_client = "ca-pub-2562502091444002";
			google_ad_slot = "8451916004";
			google_ad_width = 320;
			google_ad_height = 50;
		</script>
		<script type="text/javascript"
		src="//pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php } ?>
		</center>
<!-- 구글광고 배너 삽입 : 신재훈 20150905 / 여기까지 -->


<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list7'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list8'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list9'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>

<?php if(!G5_IS_MOBILE) { // 모바일에서 안보이도록 
?>

<?php }
?>

<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list1'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list2'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list3'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>

<? // 3개 추가 ?>

<div class="idx-10"></div>

<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list4'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list5'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list6'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>

<?php echo apms_widget('amina-widget-gallery', 'amina-idx-gallery1'); // 갤러리 위젯 ?>

<!-- 모바일용 배너 삭제 - 김용준 
				<?php if(G5_IS_MOBILE) { ?>
				<center>
		// ex - 초코블라썸 배너 
				<a href="http://unit.kr/bbs/board.php?bo_table=sponsor&wr_id=3" target=_blank><img src="http://unit.kr/img/choco_blossom.gif" style="max-width: 45%; height: auto;"></a>
				</center>
				<?php } ?>
-->

<!-- 모바일용 배너추가 - 김용준 -->

<!-- 구글광고 효과 체크용 배너 삽입 : 신재훈 20150905 -->
		<center>
		<?php if(G5_IS_MOBILE) { ?>
		<script type="text/javascript">
			google_ad_client = "ca-pub-2562502091444002";
			google_ad_slot = "8451916004";
			google_ad_width = 320;
			google_ad_height = 50;
		</script>
		<!-- unit.kr 모바일 320x50 -->
		<script type="text/javascript"
		src="//pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php } ?>
		</center>
<!-- 구글광고 효과 체크용 배너 삽입 : 신재훈 20150905 / 여기까지 -->

<?php // echo apms_widget('amina-widget-banner', 'amina-idx-banner1'); // 배너 위젯 ?>


<? // 소모임 추가 ?>

<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list10'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list11'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list12'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>

<div class="idx-10"></div>

<div class="row">
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list13'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list14'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
	<div class="col-sm-4">
		<?php echo apms_widget('amina-widget-list', 'amina-idx-list15'); // 리스트 위젯 ?>
		<div class="idx-10"></div>
	</div>
</div>