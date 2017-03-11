<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="item-media">
<?php for ($i=0; $i < count($list); $i++) { ?>
	<div class="media">
		<div class="img-thumbnail photo pull-left">
			<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
				<?php echo ($list[$i]['is_photo']) ? '<img src="'.$list[$i]['is_photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
			</a>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
				<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
					<span class="pull-right text-muted font-11 en">
						no.<?php echo $list[$i]['is_num']; ?>
					</span>
					<?php echo $list[$i]['is_subject']; ?>
				</a>
			</h5>
			<div class="font-11 en text-muted">
				<span class="font-12 red"><?php echo $list[$i]['is_star'];; ?></span>

				<span class="media-info">
					<i class="fa fa-user"></i>
					<?php echo $list[$i]['is_name']; ?>
				</span>
				
				<span class="hidden-xs media-info">
					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_datetime($list[$i]['is_time'], 'Y.m.d H:i');?></time>
				</span>

				<?php if ($list[$i]['is_btn']) { ?>
					<a href="#" onclick="apms_form('itemuse_form', '<?php echo $list[$i]['is_edit_href'];?>'); return false; ">
						<span class="media-info text-muted"><i class="fa fa-pencil"></i> 수정</span>
					</a>
					<a href="#" onclick="apms_delete('itemuse', '<?php echo $list[$i]['is_del_href'];?>', '<?php echo $list[$i]['is_del_return'];?>'); return false; ">
						<span class="media-info text-muted"><i class="fa fa-times"></i> 삭제</span>
					</a>
				<?php } ?>
			</div>
			<div class="img-resize media-content" id="more_is_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 후기 내용 ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<div class="well text-center">
	<?php if ($is_free_write) { ?>
		구매와 상관없이 후기를 등록할 수 있습니다.
	<?php } else { ?>
		구매하신 분만 후기를 등록할 수 있습니다.
	<?php } ?>
</div>

<div class="row">
	<div class="col-sm-8">
		<?php if($total_count > 0) { ?>
			<ul class="pagination pagination-sm en" style="margin-top:0;">
				<?php echo apms_ajax_paging('itemuse', $write_pages, $page, $total_page, $list_page); ?>
			</ul>
		<?php } ?>	
	</div>
	<div class="col-sm-4 text-right">
		<button type="button" class="btn btn-color btn-sm" onclick="apms_form('itemuse_form', '<?php echo $itemuse_form; ?>');">후기쓰기<span class="sound_only"> 새 창</span></button>
		<a class="btn btn-black btn-sm" href="<?php echo $itemuse_list; ?>">더보기</a>
		<?php if($admin_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $admin_href; ?>">관리</a>
		<?php } ?>
	</div>
</div>

<script>
function more_is(id) {
	$("#" + id).toggle();
}
</script>