<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" method="get" action="./itemqalist.php">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="ca_id" class="sound_only">분류</label>
					<select name="ca_id" id="ca_id" class="form-control input-sm">
						<option value="">카테고리</option>
						<?php echo apms_category($ca_id);?>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="sfl" class="sound_only">검색항목<strong class="sound_only"> 필수</strong></label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="">선택</option>
						<option value="b.it_name"    <?php echo get_selected($sfl, "b.it_name", true); ?>>상품명</option>
						<option value="a.it_id"      <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
						<option value="a.iq_subject" <?php echo get_selected($sfl, "a.is_subject"); ?>>문의제목</option>
						<option value="a.iq_question"<?php echo get_selected($sfl, "a.iq_question"); ?>>문의내용</option>
						<option value="a.iq_name"    <?php echo get_selected($sfl, "a.it_id"); ?>>작성자명</option>
						<option value="a.mb_id"      <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<div class="form-group">
						<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
						<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="form-control input-sm" placeholder="검색어">
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<a href="./itemqalist.php" class="btn btn-color btn-sm btn-block"><i class="fa fa-bars"></i> 전체</a>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="section-title" style="margin-bottom:10px;">
	Total <?php echo number_format($total_count);?> Questions
</div>

<div class="at-media">
<?php 
	for ($i=0; $i < count($list); $i++) { 
		// 이미지
		$img = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['iq_question'], 80, 80);
		$img['src'] = ($img['src']) ? $img['src'] : $list[$i]['iq_photo'];
?>
	<div class="media">
		<div class="img-thumbnail photo pull-left">
			<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
				<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-user"></i>'; ?>
			</a>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
				<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
					<span class="pull-right text-muted font-11 en">no.<?php echo $list[$i]['iq_num']; ?></span>
					<?php if($list[$i]['iq_secret']) { ?>
						<i class="fa fa-lock orange"></i>
					<?php } ?>					
					<?php echo $list[$i]['iq_subject']; ?>
				</a>
			</h5>
			<div class="media-item">
				<a href="<?php echo $list[$i]['it_href'];?>"><span class="text-muted"><?php echo $list[$i]['it_name']; ?></span></a>
			</div>
			<div class="media-info en text-muted">
				<?php if($list[$i]['iq_answer']) { ?>
					<span class="blue"><i></i> 답변완료</span>
				<?php } else { ?>
					<i></i> 답변대기
				<?php } ?>

				<i class="fa fa-user"></i>
				<?php echo $list[$i]['iq_name']; ?>

				<i class="fa fa-clock-o"></i>
				<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['iq_time']) ?>"><?php echo apms_datetime($list[$i]['iq_time'], 'Y.m.d H:i');?></time>
			</div>
			<div class="media-content media-resize" id="more_iq_<?php echo $i; ?>" style="display:none;">
				<?php echo ($list[$i]['secret']) ? $list[$i]['iq_question'] : get_view_thumbnail($list[$i]['iq_question'], $default['pt_img_width']); // 문의 내용 ?>
				<?php if($list[$i]['answer']) { ?>
					<div class="media media-reply">
						<div class="photo-ans pull-left">
							<?php echo ($list[$i]['ans_photo']) ? '<img src="'.$list[$i]['ans_photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
						</div>
						<div class="media-body">
							<?php echo get_view_thumbnail($list[$i]['iq_answer'], $default['pt_img_width']); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<?php if ($i == 0) echo '<p class="text-center text-muted">등록된 문의가 없습니다.</p>'; ?>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<script>
function more_iq(id) {
	$("#" + id).toggle();
}
</script>