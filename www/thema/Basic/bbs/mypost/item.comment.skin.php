<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div style="padding:15px;">
	<div class="input-group input-group-sm en">
		<span class="input-group-addon">Total <?php echo number_format($total_count);?></span>
		<select name="ca_id" onchange="location='./mypost.php?mode=<?php echo $mode; ?>&ca_id=' + encodeURIComponent(this.value);" class="form-control input-sm">
			<option value="">전체보기</option>
			<?php echo apms_category($ca_id);?>
		</select>
	</div>
</div>

<section class="comment-media">
	<?php
	$cmt_cnt = count($list);
	for ($i=0; $i<$cmt_cnt; $i++) {
		$list[$i]['img'] = apms_it_thumbnail($list[$i], 80, 80, false, true);

	 ?>
		<div class="media">
			<div class="img-thumbnail photo pull-left">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</div>
			<div class="media-body">
				<h5 class="media-heading">
					<a href="<?php echo $list[$i]['it_href'] ?>" target="_blank">
						<b class="font-13"><?php echo get_text($list[$i]['it_name']); ?></b>
						<?php if($list[$i]['it_comment']) { ?>
							<span class="cmt"><?php echo $list[$i]['it_comment'];?></span>
						<?php } ?>
					</a>
				</h5>
				<div class="text-muted en font-11">
					no.<?php echo $list[$i]['num']; ?> 
					/ 
					<?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i'); ?> 
					/ 
					<?php echo $list[$i]['ca_name']; ?>
				</div>
				<div class="media-content">
					<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><i class="fa fa-lock"></i><?php } ?>
					<?php echo $list[$i]['content']; ?>
				</div>
		  </div>
		</div>
	<?php } ?>
	<?php if($i == 0) { ?>
		<p class="text-center text-muted list-none">등록한 댓글이 없습니다.</p>
	<?php } ?>
</section>
