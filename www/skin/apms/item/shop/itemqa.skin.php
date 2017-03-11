<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="item-media">
<?php for ($i=0; $i < count($list); $i++) { ?>
	<div class="media">
		<div class="img-thumbnail photo pull-left">
			<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
				<?php echo ($list[$i]['iq_photo']) ? '<img src="'.$list[$i]['iq_photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
			</a>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
				<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
					<span class="pull-right text-muted font-11 en">
						no.<?php echo $list[$i]['iq_num']; ?>
					</span>
					<?php if($list[$i]['iq_secret']) { ?>
						<i class="fa fa-lock orange"></i>
					<?php } ?>					
					<?php echo $list[$i]['iq_subject']; ?>
				</a>
			</h5>
			<div class="font-11 en text-muted">
				<?php if($list[$i]['iq_answer']) { ?>
					<span class="blue"><i></i> 답변완료</span> &nbsp;
				<?php } else { ?>
					<i></i> 답변대기 &nbsp;
				<?php } ?>
				<i class="fa fa-user"></i>
				<?php echo $list[$i]['iq_name']; ?>

				<span class="hidden-xs media-info">
					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['iq_time']) ?>"><?php echo apms_datetime($list[$i]['iq_time'], 'Y.m.d H:i');?></time>
				</span>

				<?php if ($list[$i]['iq_btn']) { ?>
					<a href="#" onclick="apms_form('itemqa_form', '<?php echo $list[$i]['iq_edit_href'];?>'); return false; ">
						<span class="media-info text-muted"><i class="fa fa-pencil"></i> 수정</span>
					</a>
					<a href="#" onclick="apms_delete('itemqa', '<?php echo $list[$i]['iq_del_href'];?>', '<?php echo $list[$i]['iq_del_return'];?>'); return false; ">
						<span class="media-info text-muted"><i class="fa fa-times"></i> 삭제</span>
					</a>
					<?php if(!$list[$i]['iq_answer']) { ?>
						<a href="#" onclick="apms_form('itemans_form', '<?php echo $list[$i]['iq_ans_href'];?>'); return false; ">
							<span class="media-info text-muted"><i class="fa fa-comments"></i> 답변등록</span>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="img-resize media-content" id="more_iq_<?php echo $i; ?>" style="display:none;">
				<?php echo ($list[$i]['secret']) ? $list[$i]['iq_question'] : get_view_thumbnail($list[$i]['iq_question'], $default['pt_img_width']); // 문의 내용 ?>
				<?php if($list[$i]['answer']) { ?>
					<div class="media media-reply">
						<div class="img-thumbnail photo pull-left">
							<?php echo ($list[$i]['ans_photo']) ? '<img src="'.$list[$i]['ans_photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
						</div>
						<div class="media-body">
							<?php echo get_view_thumbnail($list[$i]['iq_answer'], $default['pt_img_width']); ?>
							<?php if($list[$i]['iq_btn'] && $list[$i]['iq_answer']) { ?>
								<p style="margin-top:10px;">
									<a href="#" onclick="apms_form('itemans_form', '<?php echo $list[$i]['iq_ans_href'];?>'); return false; ">
										<span class="text-muted font-11"><i class="fa fa-pencil"></i> 답변수정</span>
									</a>
								</p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<?php if ($i == 0) echo '<div class="well text-center">등록된 문의가 없습니다.</div>'; ?>

<div class="row">
	<div class="col-sm-8">
		<?php if($total_count > 0) { ?>
			<ul class="pagination pagination-sm en" style="margin-top:0;">
				<?php echo apms_ajax_paging('itemqa', $write_pages, $page, $total_page, $list_page); ?>
			</ul>
		<?php } ?>
	</div>
	<div class="col-sm-4 text-right">
		<button type="button" class="btn btn-color btn-sm" onclick="apms_form('itemqa_form', '<?php echo $itemqa_form; ?>');">문의쓰기<span class="sound_only"> 새 창</span></button>
		<a class="btn btn-black btn-sm" href="<?php echo $itemqa_list; ?>">더보기</a>
		<?php if($admin_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $admin_href; ?>">관리</a>
		<?php } ?>
	</div>
</div>

<script>
function more_iq(id) {
	$("#" + id).toggle();
}
</script>