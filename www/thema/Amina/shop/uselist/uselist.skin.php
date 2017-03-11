<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

$list_cnt = count($list);

?>

<div class="well bg-colorset" style="padding-bottom:3px;">
	<form class="form" role="form" method="get" action="./itemuselist.php">
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
					<a href="./itemuselist.php" class="btn btn-color btn-sm btn-block"><i class="fa fa-bars"></i> 전체</a>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="section-title" style="margin-bottom:10px;">
	Total <?php echo number_format($total_count);?> Reviews
</div>

<?php if($list_cnt) { ?>
	<div class="at-media box-colorset">
	<?php 
		for ($i=0; $i < $list_cnt; $i++) { 
			// 이미지
			$img = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['is_content'], 80, 80);
			$img['src'] = ($img['src']) ? $img['src'] : $list[$i]['is_photo'];
	?>
		<div class="media">
			<div class="img-thumbnail photo pull-left">
				<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
					<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-user"></i>'; ?>
				</a>
			</div>
			<div class="media-body">
				<h5 class="media-heading">
					<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
						<span class="pull-right text-muted font-11 en">no.<?php echo $list[$i]['is_num']; ?></span>
						<?php echo $list[$i]['is_subject']; ?>
					</a>
				</h5>
				<div class="media-item">
					<a href="<?php echo $list[$i]['it_href'];?>"><span class="text-muted"><?php echo $list[$i]['it_name']; ?></span></a>
				</div>
				<div class="media-info en text-muted">
					<span class="is-star red font-12">
						<?php echo $list[$i]['is_star'];?>
					</span>

					<i class="fa fa-user"></i>
					<?php echo $list[$i]['is_name']; ?>

					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_datetime($list[$i]['is_time'], 'Y.m.d H:i');?></time>
				</div>
				<div class="media-content media-resize" id="more_is_<?php echo $i; ?>" style="display:none;">
					<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 문의 내용 ?>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
<?php } else { ?>
	<p class="well text-center text-muted bg-colorset" style="padding:50px 0px;">등록된 후기가 없습니다.</p>
<?php } ?>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<script>
function more_is(id) {
	$("#" + id).toggle();
}
</script>
