<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 분류
$cate = array();
if ($category_option) {
    $category_href = G5_BBS_URL.'/qalist.php';
    $categories = explode('|', $qaconfig['qa_category']); // 구분자가 | 로 되어 있음
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if ($category=='') continue;
        $cate[$i]['ca_href'] = $category_href."?sca=".urlencode($category);
        $cate[$i]['ca_name'] = $category;
        $cate[$i]['ca_on'] = false;
        if ($category==$sca) { // 현재 선택된 카테고리라면
	        $cate[$i]['ca_on'] = true;
        }
    }
}

$category_cnt = count($categories);

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;
if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<?php if($category_option) { ?>
	<aside class="list-category-select">
		<div class="form-group input-group input-group-sm">
			<span class="input-group-addon"><i class="fa fa-tag"></i></span>
			<select name="sca" onchange="location='./qalist.php?sca=' + encodeURIComponent(this.value);" class="form-control input-sm">
				<option value="">전체보기<?php if(!$sca) echo '('.number_format($total_count).')';?></option>
				<?php for ($i=0; $i < $category_cnt; $i++) { ?>
					<option value="<?php echo $categories[$i];?>"<?php if($categories[$i] == $sca) echo ' selected';?>>
						<?php echo $categories[$i];?><?php if($categories[$i] == $sca) echo '('.number_format($total_count).')';?>
					</option>
				<?php } ?>
			</select>
		</div>
	</aside>

	<nav class="list-category">
		<div class="tabs">
			<ul class="nav nav-tabs font-12">
				<li<?php echo (!$sca) ? ' class="active"' : '';?>>
					<a href="./qalist.php">전체<?php echo (!$sca) ? '('.number_format($total_count).')' : '';?></a>
				</li>
				<?php for ($i=0; $i < $category_cnt; $i++) { ?>
					<li<?php echo ($categories[$i] == $sca) ? ' class="active"' : '';?>>
						<a href="./qalist.php?sca=<?php echo urlencode($categories[$i]);?>">
							<?php echo $categories[$i];?><?php echo ($sca && $categories[$i] == $sca) ? '('.number_format($total_count).')' : '';?>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
<?php } ?>

<div class="list-wrap">

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post" role="form" class="form">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

	<?php if(G5_IS_MOBILE) { // 모바일?>
		<div class="list-media bg-white">
			<?php for ($i=0; $i<count($list); $i++) { 
				$list_img_url = apms_photo_url($list[$i]['mb_id']); // 회원사진
				$list_img = ($list_img_url) ? '<img src="'.$list_img_url.'" alt="" class="media-object">' : '<div class="media-object"><i class="fa fa-comment"></i></div>';
				$list_date = strtotime($list[$i]['qa_datetime']);	
			?>
				<div class="media">
					<div class="m-photo img-thumbnail pull-left">
						<a href="<?php echo $list[$i]['href'] ?>">
							<?php echo $list_img;?>
						</a>
					</div>
					<div class="media-body">
						<h5 class="media-heading">
							<?php if($list[$i]['qa_status']) { ?>
								<span class="pull-right font-11">
									<i class="fa fa-comments-o fa-lg"></i> 답변
								</span>
							<?php } ?>
							<a href="<?php echo $list[$i]['view_href'] ?>">
								<img src="<?php echo $skin_url;?>/img/icon_<?php echo ($list[$i]['qa_status'] ? 'a' : 'q'); ?>.gif" alt="">
								<?php echo $list[$i]['subject'] ?>
							</a>
						</h5>
						<?php if ($is_checkbox) { ?>
							<label class="pull-right">
								<input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
							</label>
						<?php } ?>
						<div class="font-11 en text-muted media-info">
							<i class="fa fa-user"></i>
							<?php echo $list[$i]['name'] ?>

							<i class="fa fa-tags"></i>
							<?php echo $list[$i]['category']; ?>

							<i class="fa fa-clock-o hidden-xs"></i>
							<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list_date) ?>" class="hidden-xs"><?php echo apms_datetime($list_date);?></time>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if ($i == 0) { echo '<div class="text-center text-muted list-none">게시물이 없습니다.</div>'; } ?>
		</div>
	<?php } else { ?>
		<div class="table-responsive">
			<table class="table list-tbl bg-white">
			<thead>
			<tr class="list-head">
			<?php if ($is_checkbox) { ?>
				<th scope="col">
					<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
					<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
				</th>
			<?php } ?>
			<th scope="col">번호</th>
			<th scope="col">분류</th>
			<th scope="col">제목</th>
			<th scope="col">글쓴이</th>
			<th scope="col">상태</th>
			<th scope="col">등록일</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $i<count($list); $i++) {
			?>
			<tr>
				<?php if ($is_checkbox) { ?>
					<td class="text-center">
						<label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
						<input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
					</td>
				<?php } ?>
				<td class="text-center font-11"><?php echo $list[$i]['num']; ?></td>
				<td class="text-center text-muted font-11"><?php echo $list[$i]['category']; ?></td>
				<td class="list-subject">
					<a href="<?php echo $list[$i]['view_href']; ?>">
						<img src="<?php echo $skin_url;?>/img/icon_<?php echo ($list[$i]['qa_status'] ? 'a' : 'q'); ?>.gif" alt="">
						<?php echo $list[$i]['subject']; ?>
						<?php echo $list[$i]['icon_file']; ?>
					</a>
				</td>
				<td><b><?php echo $list[$i]['name']; ?></b></td>
				<td class="text-center font-11 <?php echo ($list[$i]['qa_status'] ? 'red' : 'text-muted'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></td>
				<td class="text-right en font-11"><?php echo apms_datetime(strtotime($list[$i]['qa_datetime'])); ?></td>
			</tr>
			<?php } ?>

			<?php if ($i == 0) { echo '<tr><td colspan="'.$colspan.'" class="text-center text-muted list-none">게시물이 없습니다.</td></tr>'; } ?>
			</tbody>
			</table>
	    </div>
	<?php } ?>

	<div class="list-btn-box">
		<?php if ($list_href || $write_href) { ?>
			<div class="form-group pull-right list-btn">
				<div class="btn-group">
					<?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn btn-black btn-sm">목록</a><?php } ?>
		            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn btn-color btn-sm">글쓰기</a><?php } ?>
				</div>
			</div>
		<?php } ?>
		<div class="form-group list-btn">
			<div class="btn-group font-12">
				<a href="#" class="btn btn-black btn-sm" data-toggle="modal" data-target="#searchModal" onclick="return false;"><i class="fa fa-search big-fa"></i></a>
				<?php if ($is_checkbox) { ?><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-color btn-sm"><?php } ?>
				<?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn btn-black btn-sm"><i class="fa fa-cog big-fa"></i></a><?php } ?>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
    </form>
</div>

<?php if($is_checkbox) { ?>
	<noscript>
	<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
	</noscript>
<?php } ?>

<?php if($total_count > 0) { ?>
	<div class="list-page text-center">
		<ul class="pagination pagination-sm en">
			<?php echo preg_replace('/(\.php)(&amp;|&)/i', '$1?', apms_paging(G5_IS_MOBILE ? $qaconfig['qa_mobile_page_rows'] : $qaconfig['qa_page_rows'], $page, $total_page, './qalist.php'.$qstr.'&amp;page='));?>
		</ul>
	</div>
<?php } ?>

<div class="clearfix"></div>

<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">문의 검색</h4>
			</div>
			<div class="modal-body">
				<form name="fsearch" method="get" role="form" class="form" style="max-width:200px; margin:0px auto;">
					<input type="hidden" name="sca" value="<?php echo $sca ?>">
					<div class="form-group">
						<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
						<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="15" placeholder="검색어">
					</div>
					<p class="text-center">
						<button type="submit" class="btn btn-color btn-block"><i class="fa fa-search fa-lg"></i></button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
