<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	주문서번호 링크를 누르시면 주문상세내역을 조회하실 수 있습니다.
</div>

<div class="table-responsive">
    <table class="table">
    <tbody>
    <tr class="bg-black">
        <th class="text-center" scope="col">주문서번호</th>
        <th class="text-center" scope="col">주문일시</th>
        <th class="text-center" scope="col">상품수</th>
        <th class="text-center" scope="col">주문금액</th>
        <th class="text-center" scope="col">입금액</th>
        <th class="text-center" scope="col">미입금액</th>
        <th class="text-center" scope="col">상태</th>
    </tr>
    <?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
			<td class="text-center">
				<input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['ct_id']; ?>">
				<a href="<?php echo $list[$i]['od_href']; ?>"><?php echo $list[$i]['od_id']; ?></a>
			</td>
			<td class="text-center"><?php echo substr($list[$i]['od_time'],2,14); ?> (<?php echo get_yoil($list[$i]['od_time']); ?>)</td>
			<td class="text-center"><?php echo $list[$i]['od_cart_count']; ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_total_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_receipt_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_misu']); ?></td>
			<td class="text-center"><?php echo $list[$i]['od_status']; ?></td>
		</tr>
    <?php } ?>
	<?php if ($i == 0) { ?>
        <tr><td colspan="7" class="text-center">주문 내역이 없습니다.</td></tr>
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
