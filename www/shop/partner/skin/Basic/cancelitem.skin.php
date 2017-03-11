<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
	.it-options ul { padding:0; margin:0; list-style:none;}
</style>

<h1><i class="fa fa-cart-arrow-down"></i> My Cancel Items</h1>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="frm_saleitem" method="get">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>">
	<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="sca" class="sr-only">분류선택</label>
					<select name="sca" id="sca" class="form-control input-sm">
						<option value="">카테고리</option>
						<?php echo $category_options;?>
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<label for="fr_date" class="sr-only">시작일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-3">
				<label for="to_date" class="sr-only">종료일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-shopping-cart"></i> 확인</button>
				</div>
			</div>
		</div>
	</form>
	<script>
	$(function() {
		$("#fr_date, #to_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yymmdd",
			showButtonPanel: true,
			yearRange: "c-99:c+99",
			maxDate: "+0d"
		});
	});

	document.getElementById("sca").value = "<?php echo $sca; ?>";
	</script>
</div>

<h3><i class="fa fa-cubes fa-lg"></i> <?php echo number_format($total_count); ?> Items</h3>

<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">번호</th>
		<th class="text-center" scope="col">판매일</th>
		<th width="60" class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">아이템/옵션</th>
		<th class="text-center" scope="col">판매량</th>
		<th class="text-center" scope="col">판매액</th>
		<th class="text-center" scope="col">수수료</th>
		<th class="text-center" scope="col">포인트</th>
		<th class="text-center" scope="col">인센티브</th>
		<th class="text-center" scope="col">매출액</th>
		<th class="text-center" scope="col">공급가</th>
		<th class="text-center" scope="col">부가세</th>
		<th class="text-center" scope="col">주문서</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { 
		$list[$i]['img'] = apms_it_thumbnail(apms_it($list[$i]['it_id']), 40, 40, false, true);
	?>
	<tr>
		<td class="text-center">
			<?php echo $list[$i]['num'];?>
		</td>
		<td class="text-center">
			<?php echo str_replace("-", "/", $list[$i]['date']);?>
			<div class="text-muted" style="margin-top:4px;">
				<?php echo $list[$i]['buyer']; ?>
			</div>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['href']; ?>">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</a>
		</td>
		<td>
			<a href="<?php echo $list[$i]['href']; ?>"><b><?php echo $list[$i]['it_name'];?></b></a>
			<div class="text-muted font-11 it-options" style="margin-top:4px;">
				<?php echo $list[$i]['options'];?>
			</div>
		</td>
		<td class="text-center">
			<?php echo number_format($list[$i]['qty']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['sale']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['commission']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['point']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['incentive']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['netsale']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['net']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['vat']); ?>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
				<i class="fa fa-file-text-o fa-lg"></i>
			</a>
		</td>
	</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="13" class="text-center">등록된 자료가 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<div class="clearfix"></div>
