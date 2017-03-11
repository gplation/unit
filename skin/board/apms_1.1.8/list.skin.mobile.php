<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$reply_depth = (G5_IS_MOBILE) ? 30 : 60;

?>

<div class="list-media">
	<?php for ($i=0; $i<count($list); $i++) { 
        $list_depth = strlen($list[$i]['wr_reply']) * $reply_depth;

		$img = apms_wr_thumbnail($bo_table, $list[$i], 50, 50, false, true); // 썸네일
		if(!$img['src']) $img['src'] = apms_photo_url($list[$i]['mb_id']); // 회원사진
		if(!$img['src']) $img = apms_thumbnail($board_skin_url.'/img/no-img.jpg', 50, 50, false, true); // no-image

		if ($wr_id == $list[$i]['wr_id']) {
			$num = "<span class=\"red\">[열람중]</span> ";
			$div_css = ' list-now';
			$subject_css = ' now';
		} else if ($list[$i]['is_notice']) { // 공지사항
			$num = '<img src="'.$board_skin_url.'/img/icon_notice.gif" alt=""><strong class="sound_only">공지</strong> ';
			$div_css = ' list-notice';
			$subject_css = ' notice';
		} else {
			$num = (isset($list[$i]['icon_new']) && $list[$i]['icon_new']) ? '<i class="fa fa-circle red"></i>' : '';
			$div_css = $subject_css = '';
		}
	 ?>
		<div class="media<?php echo $div_css;?>"<?php echo ($list_depth) ? ' style="padding-left:'.$list_depth.'px;"' : ''; ?>>
			<div class="m-photo img-thumbnail pull-left">
				<a href="<?php echo $list[$i]['href'] ?>">
					<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>" class="media-object">
				</a>
			</div>
			<div class="media-body">
				<h5 class="media-heading<?php echo $subject_css;?>">
					<?php if ($list[$i]['comment_cnt']) { ?>
						<span class="pull-right">
							<span class="sound_only">댓글</span>
							<i class="fa fa-comments-o"></i><span class="font-12<?php echo ($list[$i]['wr_comment']) ? ' red' : '';?>">
							<?php echo $list[$i]['wr_comment']; ?></span>
							<span class="sound_only">개</span>
						</span>
					<?php } ?>
					<a href="<?php echo $list[$i]['href'] ?>">
						<?php if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'].PHP_EOL; ?>
						<?php echo $num; ?>
						<?php echo $list[$i]['subject'] ?>
					</a>
				</h5>
				<?php if ($is_checkbox) { ?>
					<label class="pull-right">
						<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
					</label>
				<?php } ?>
				<div class="font-11 en text-muted media-info">
					<i class="fa fa-user"></i>
					<?php echo $list[$i]['name'] ?>

					<?php if ($is_category && $list[$i]['ca_name']) { ?>
						<i class="fa fa-tags"></i>
						<a href="<?php echo $list[$i]['ca_name_href'] ?>"><span class="text-muted font-11"><?php echo $list[$i]['ca_name'] ?></span></a>
					<?php } ?>

					<i class="fa fa-eye"></i>
					<?php echo $list[$i]['wr_hit'] ?>

					<?php if ($is_good) { ?>
						<i class="fa fa-thumbs-up"></i>
						<?php echo $list[$i]['wr_good'] ?>
					<?php } ?>

					<i class="fa fa-clock-o hidden-xs"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['date']) ?>" class="hidden-xs"><?php echo apms_datetime($list[$i]['date'], 'Y.m.d');?></time>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if (count($list) == 0) { echo '<div class="text-center text-muted list-none">게시물이 없습니다.</div>'; } ?>
</div>

