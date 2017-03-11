<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_admin) $colspan++;

?>

<div class="well bg-colorset" style="padding-bottom:5px;">
	<form class="form" role="form" name="fnew" method="get">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="gr_id" class="sound_only">그룹</label>
					<select name="gr_id" id="gr_id" class="form-control input-sm">
						<option value="">전체그룹</option>
						<?php echo $group_select ?>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="view" class="sound_only">검색대상</label>
					<select name="view" id="view" class="form-control input-sm">
						<option value="">전체게시물
						<option value="w">원글만
						<option value="c">코멘트만
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<div class="form-group">
					    <label for="mb_id" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					    <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="form-control input-sm" placeholder="회원아이디">
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
					<a href="./new.php" class="btn btn-color btn-sm btn-block"><i class="fa fa-bars"></i> 전체</a>
				</div>
			</div>
		</div>
	</form>

    <script>
    /* 셀렉트 박스에서 자동 이동 해제
    function select_change()
    {
        document.fnew.submit();
    }
    */
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
</div>

<!-- 전체게시물 목록 시작 { -->
<form class="form" role="form" name="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
<input type="hidden" name="sw"       value="move">
<input type="hidden" name="view"     value="<?php echo $view; ?>">
<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
<input type="hidden" name="srows"    value="<?php echo $srows; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="page"     value="<?php echo $page; ?>">
<input type="hidden" name="pressed"  value="">

	<div class="table-responsive">
		<table class="table bg-white">
		<tbody>
		<tr class="bg-black">
			<?php if ($is_admin) { ?>
			<th class="text-center" scope="col">
				<label for="all_chk" class="sound_only">목록 전체</label>
				<input type="checkbox" id="all_chk">
			</th>
			<?php } ?>
			<th class="text-center" scope="col">그룹</th>
			<th class="text-center" scope="col">게시판</th>
			<th class="text-center" scope="col">제목</th>
			<th class="text-center" scope="col">이름</th>
			<th class="text-center" scope="col">일시</th>
		</tr>
		<?php
		for ($i=0; $i<count($list); $i++)
		{
			$num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
			$gr_subject = cut_str($list[$i]['gr_subject'], 20);
			$bo_subject = cut_str($list[$i]['bo_subject'], 20);
			$wr_subject = get_text(cut_str($list[$i]['wr_subject'], 30));
		?>
		<tr>
			<?php if ($is_admin) { ?>
			<td class="text-center">
				<label for="chk_bn_id_<?php echo $i; ?>" class="sound_only"><?php echo $num?>번</label>
				<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>">
				<input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
				<input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
			</td>
			<?php } ?>
			<td class="text-center font-11"><a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><span class="text-muted"><?php echo $gr_subject ?></span></a></td>
			<td class="text-center font-11"><a href="./board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a></td>
			<td><a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a></td>
			<td><?php echo $list[$i]['name'] ?></td>
			<td class="text-center font-11 en"><?php echo apms_datetime(strtotime($list[$i]['wr_datetime'])); ?></td>
		</tr>
		<?php }  ?>

		<?php if ($i == 0)
			echo '<tr><td colspan="'.$colspan.'" class="text-center text-muted" style="padding:50px 0px;">게시물이 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<div style="margin-bottom:20px;">
		<?php if ($is_admin) { ?>
			<div class="pull-left">
				<input type="submit" onclick="document.pressed=this.value" value="선택삭제" class="btn btn-black btn-sm">
			</div>
		<?php } ?>
		<?php if($total_count > 0) { ?>
			<div class="pull-right">
				<ul class="pagination pagination-sm en" style="margin-top:0; padding-top:0;">
					<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
				</ul>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>

</form>

<?php if ($is_admin) { ?>
	<script>
	$(function(){
		$('#all_chk').click(function(){
			$('[name="chk_bn_id[]"]').attr('checked', this.checked);
		});
	});

	function fnew_submit(f)
	{
		f.pressed.value = document.pressed;

		var cnt = 0;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
				cnt++;
		}

		if (!cnt) {
			alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		f.action = "./new_delete.php";

		return true;
	}
	</script>
<?php } ?>
