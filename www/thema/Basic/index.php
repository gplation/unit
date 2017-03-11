<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(IS_YC && IS_SHOP) { // Shop Index
	@include_once (THEMA_PATH.'/shop.index.php');
	return;
} 

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
	<h3 class="section-title">Board Title</h3>
	<?php echo apms_widget('board-gallery', 'idx-post-gallery1'); // 갤러리 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<div class="row">
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-bug red"></i>
				</div>
				<h2>All Board</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-list', 'idx-board-list1'); // 목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-download blue"></i>
				</div>
				<h2>One Board</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-list', 'idx-board-list2'); // 목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-code green"></i>
				</div>
				<h2>Multi Board</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-list', 'idx-board-list3'); // 목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-comments violet"></i>
				</div>
				<h2>Except Some</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-list', 'idx-board-list4'); // 목록 위젯 ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="msp-30"></div>

<?php echo apms_widget('misc-title-middle','idx-title-middle1'); // 타이틀 위젯 ?>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<h3 class="section-title">Board Title</h3>
	<?php echo apms_widget('board-gallery', 'idx-board-gallery2'); // 갤러리 위젯 ?>
</div>

<div class="msp-30"></div>

<div class="<?php echo $container;?>">
	<div class="row">
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-pencil blue"></i>
				</div>
				<h2>New Post</h2>
				<p class="text-muted">
					새로 등록된 글
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-photo', 'idx-board-photo1'); // 포토목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-comment red"></i>
				</div>
				<h2>New Comment</h2>
				<p class="text-muted">
					새로 등록된 댓글
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-photo', 'idx-board-photo2'); // 포토목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-camera green"></i>
				</div>
				<h2>Multi Board</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-photo', 'idx-board-photo3'); // 포토목록 위젯 ?>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-6">
			<div class="mfa-box">
				<div class="mfa-fa hidden-xs">
					<i class="fa fa-users orange"></i>
				</div>
				<h2>Except Some</h2>
				<p class="text-muted">
					Board Description
				</p>
				<div class="mfa-list">
					<?php echo apms_widget('board-photo', 'idx-board-photo4'); // 포토목록 위젯 ?>
				</div>
			</div>
		</div>
	</div>
</div>
