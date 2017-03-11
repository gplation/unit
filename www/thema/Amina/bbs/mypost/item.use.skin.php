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

<div class="at-media">
<?php 
	for ($i=0; $i < count($list); $i++) { 
		// 이미지
		$list[$i]['img'] = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['is_content'], 80, 80);
?>
	<div class="media">
		<div class="img-thumbnail photo pull-left">
			<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</a>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
				<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
					<?php echo $list[$i]['is_subject']; ?>
				</a>
			</h5>
			<div class="media-item">
				<a href="<?php echo $list[$i]['it_href'];?>"><span class="text-muted"><?php echo $list[$i]['it_name']; ?></span></a>
			</div>
			<div class="font-11 en text-muted">
				<span class="red"><?php echo $list[$i]['star'];?></span> 
				/ 
				no.<?php echo $list[$i]['num']; ?> 
				/ 
				<?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i');?> 
				/ 
				<?php echo $list[$i]['ca_name']; ?>
			</div>
			<div class="media-content media-resize" id="more_is_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 문의 내용 ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<?php if ($i == 0) echo '<p class="text-center text-muted list-none">등록한 후기가 없습니다.</p>'; ?>

<script>
function more_is(id) {
	$("#" + id).toggle();
}
</script>
