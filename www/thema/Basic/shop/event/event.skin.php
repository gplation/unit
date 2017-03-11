<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<?php for($i=0; $i < count($event); $i++) { // 배너만 출력함 ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="<?php echo $event[$i]['ev_href'];?>">
					<span class="badge bg-red pull-right"><?php echo $event[$i]['ev_cnt'];?></span>
					<?php echo $event[$i]['ev_subject'];?>
				</a>
			</h3>
		</div>
		<div>
			<a href="<?php echo $event[$i]['ev_href'];?>">
				<img src="<?php echo $event[$i]['ev_banner'];?>" alt="<?php echo $event[$i]['ev_subject'];?>" class="img-responsive img-center">
			</a>
		</div>
	</div>
<?php } ?>

<?php if($i == 0) { ?>
	<div class="well text-center">현재 진행 중인 이벤트가 없습니다.</div>
<?php } ?>

<div style="margin-bottom:20px;">
	<div class="pull-left">
		<ul class="pagination pagination-sm en" style="margin-top:0; padding-top:0;">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
	<div class="pull-right">
		<?php if ($admin_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $admin_href;?>">관리</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>
