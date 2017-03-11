<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

$colspan = 4;
if($mode == "2") $colspan++;

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

<div class="btn-group btn-group-justified">
	<a href="./shopping.php?mode=1" class="btn btn-sm btn-black<?php echo ($mode == "1") ? ' active' : '';?>">구매</a>
	<a href="./shopping.php?mode=2" class="btn btn-sm btn-black<?php echo ($mode == "2") ? ' active' : '';?>">배송</a>
	<a href="./shopping.php?mode=3" class="btn btn-sm btn-black<?php echo ($mode == "3") ? ' active' : '';?>">준비</a>
</div>

<div style="padding:15px;">
	<div class="input-group input-group-sm en">
		<span class="input-group-addon">Total <?php echo number_format($total_count);?></span>
		<select name="ca_id" onchange="location='./shopping.php?mode=<?php echo $mode; ?>&ca_id=' + encodeURIComponent(this.value);" class="form-control input-sm">
			<option value="">전체보기</option>
			<?php echo apms_category($ca_id);?>
		</select>
	</div>
</div>

<table class="table">
<tbody>
<tr class="active">
	<th class="text-center" scope="col">번호</th>
	<th class="text-center" scope="col">이미지</th>
	<th class="text-center" scope="col">아이템명</th>
	<th class="text-center" scope="col">주문번호</th>
	<?php if($mode == "2") { ?>
		<th class="text-center" scope="col">구매</th>
	<?php } ?>
</tr>
<?php for ($i=0; $i<count($list); $i++)	{ 
	$list[$i]['img'] = apms_it_thumbnail(apms_it($list[$i]['it_id']), 40, 40, false, true);
?>
	<tr>
		<td class="text-center font-11 en">
			<?php echo $list[$i]['num']; ?>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
			<?php if($list[$i]['img']['src']) {?>
				<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
			<?php } else { ?>
				<i class="fa fa-camera img-fa"></i>
			<?php } ?>
			</a>
		</td>
		<td>
			<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
				<b><?php echo $list[$i]['it_name']; ?></b>
				<?php if($list[$i]['option']) { ?>
					<br>
					<span class="font-11 text-muted"><?php echo $list[$i]['option'];?></span>
				<?php } ?>
			</a>
		</td>
		<td class="text-center font-11">
			<a href="<?php echo $list[$i]['od_href'];?>" target="_blank">
				<?php echo $list[$i]['od_id']; ?>
				<br>
				(<?php echo ($list[$i]['delivery']) ? $list[$i]['delivery'] : apms_datetime($list[$i]['od_date'], 'Y.m.d'); ?>)
			</a>
		</td>
		<?php if($mode == "2") { ?>
			<td class="text-center font-11">
				<?php if($list[$i]['de_href']) { ?>
					<a href="<?php echo $list[$i]['de_href'];?>" class="de-href">완료</a>
				<?php } ?>
			</td>
		<?php } ?>
	</tr>
<?php }  ?>
<?php if ($i == 0) echo '<tr><td colspan="'.$colspan.'" class="text-center text-muted" height="150">자료가 없습니다.</td></tr>'; ?>
</tbody>
<tfoot>
<tr class="active">
	<td colspan="<?php echo $colspan;?>" class="text-center">
		<?php if($mode == "2") { ?>
			완료처리된 아이템에 한해 포인트 등이 적립됩니다.
		<?php } else if($mode == "3") { ?>
			주문서 기준으로 현재 입금 및 배송 준비 중인 아이템 내역입니다.
		<?php } else { ?>
			주문서 기준으로 구매가 최종완료된 아이템 내역입니다.
		<?php } ?>
	</td>
</tr>
</tfoot>
</table>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm" style="margin-top:10px;">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<p class="text-center">
	<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
</p>

<script>
$(function() {
	$("a.de-href").click(function() {
		if(confirm("구매완료 처리를 하시겠습니까?")) {
			return true;
		} else {
			return false;
		}
	});
});
</script>
