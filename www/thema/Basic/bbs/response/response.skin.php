<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<div class="panel panel-default" style="padding-bottom:0px;">
	<div class="res-info bg-black">
		<i class="fa fa-microphone"></i> 내글반응 숫자와 목록수가 다르다면 리카운트를 실행해 주세요.
	</div>
	<div class="at-media">
		<?php for ($i=0; $i < count($list); $i++) { ?>
			<div class="media" style="padding:8px 8px 3px;">
				<div class="img-thumbnail photo pull-left">
					<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
				</div>
				<div class="media-body">
					<h5 class="media-heading">
						<a href="#" onclick="<?php echo $list[$i]['href'];?>">
							<?php echo $list[$i]['subject'];?>
						</a>
					</h5>
					<div class="media-item text-muted">
						<?php echo $list[$idx][$i]['content'] ?>
					</div>
					<div class="media-info en text-muted">
						<i class="fa fa-user"></i>
						<?php echo $list[$i]['name'];?> 외

						<?php if($list[$i]['reply_cnt']) { ?>
							<i class="fa fa-comments-o"></i> <?php echo $list[$i]['reply_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['comment_cnt']) { ?>
							<i class="fa fa-comment"></i> <?php echo $list[$i]['comment_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['comment_reply_cnt']) { ?>
							<i class="fa fa-comments"></i> <?php echo $list[$i]['comment_reply_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['good_cnt']) { ?>
							<i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['good_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['nogood_cnt']) { ?>
							<i class="fa fa-thumbs-down"></i> <?php echo $list[$i]['nogood_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['use_cnt']) { ?>
							<i class="fa fa-pencil"></i> <?php echo $list[$i]['use_cnt'];?>
						<?php } ?>
						<?php if($list[$i]['qa_cnt']) { ?>
							<i class="fa fa-question-circle"></i> <?php echo $list[$i]['qa_cnt'];?>
						<?php } ?>
						<i class="fa fa-clock-o"></i> <?php echo apms_datetime($list[$i]['date']);?>
					</div>
				</div>
			</div>		
		<?php } ?>
	</div>

	<?php if($i == 0) { ?>
		<div class="panel-body">
			<p class="text-center text-muted">등록된 내글반응이 없습니다.</p>
		</div>
	<?php } ?>
</div>

<div class="clearfix"></div>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en" style="margin-top:0;">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<p class="text-center">
	<a class="btn btn-color btn-sm" href="<?php echo $all_href;?>">일괄확인</a>
	<a class="btn btn-black btn-sm" href="<?php echo $recount_href;?>">리카운트</a>
	<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
</p>
