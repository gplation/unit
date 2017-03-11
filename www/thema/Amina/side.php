<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<style>
	.side-10 { margin:0; padding:0; height:10px; clear:both; }
	.side-20 { margin:0; padding:0; height:20px; clear:both; }
	.side-30 { margin:0; padding:0; height:30px; clear:both; }
</style>

<!-- 모바일용 배너추가 - 신재훈 -->
<!-- 모바일용 배너삭제 - 김용준 -->
<!--
				<?php if(G5_IS_MOBILE) { ?>
				<center>
		// --명동커피 배너
				<a href="http://unit.kr/bbs/board.php?bo_table=sponsor&wr_id=6" target=_blank><img src="http://unit.kr/img/myungdong-cafe.gif" style="max-width: 45%; height: auto;"></a>
		// -초코블라썸 배너
				<a href="http://unit.kr/bbs/board.php?bo_table=sponsor&wr_id=3" target=_blank><img src="http://unit.kr/img/choco_blossom.gif" style="max-width: 45%; height: auto;"></a>
				</center>
				<?php } ?>
-->

<!-- 모바일용 배너추가 - 김용준 -->


<!--소스코드 수정 : 모바일에는 외부로그인 안보이도록-->
<?php if(!G5_IS_MOBILE) { ?>

<?php echo apms_widget('amina-widget-outlogin'); // 외부로그인 위젯 ?>

<?php echo apms_widget('amina-widget-notice', 'amina-notice1'); // 공지사항 위젯 ?>

<?php echo apms_widget('amina-widget-category'); // 카테고리(서브메뉴) 위젯 ?>

<div class="side-10"></div>

<?php } ?>

<?php echo apms_widget('amina-widget-list', 'amina-side-list1'); // 리스트 위젯 ?>

<div class="side-10"></div>

<?php echo apms_widget('amina-widget-list', 'amina-side-list2'); // 리스트 위젯 ?>

<div class="side-10"></div>

<?php echo apms_widget('amina-widget-stats'); // 사이트 통계 ?>

<div class="side-10"></div>

<div class="text-center">
	<?php // 소셜 보내기
		$sns_url  = G5_URL;
		$sns_title = get_text($config['cf_title']);
		$sns_img = THEMA_URL.'/assets/img';
		echo  get_sns_share_link('facebook', $sns_url, $sns_title, $sns_img.'/sns_fb_s.png').' ';
		echo  get_sns_share_link('twitter', $sns_url, $sns_title, $sns_img.'/sns_twt_s.png').' ';
		echo  get_sns_share_link('googleplus', $sns_url, $sns_title, $sns_img.'/sns_goo_s.png').' ';
		echo  get_sns_share_link('kakaostory', $sns_url, $sns_title, $sns_img.'/sns_kakaostory_s.png').' ';
		echo  get_sns_share_link('kakaotalk', $sns_url, $sns_title, $sns_img.'/sns_kakao_s.png').' ';
		echo  get_sns_share_link('naverband', $sns_url, $sns_title, $sns_img.'/sns_naverband_s.png').' ';
	?>
</div>

<div class="side-30"></div>


<!-- 구글 광고 PC버전용 -->
	<!--소스코드 수정 : PC용 -->
		<?php if(!G5_IS_MOBILE) { ?>
		<center>
		<script type="text/javascript">
			google_ad_client = "ca-pub-2562502091444002";
			google_ad_slot = "5858376405";
			google_ad_width = 250;
			google_ad_height = 250;
		</script>
		<!-- unit.kr 250x250 -->
		<script type="text/javascript"
		src="//pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</center>
		<?php } ?>
	<!--소스코드 수정 : 모바일용 -->
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
		</center>
		<?php } ?>
