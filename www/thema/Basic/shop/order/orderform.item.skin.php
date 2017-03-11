<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="bg-black" style="padding:10px 15px">
	<b><i class="fa fa-shopping-cart"></i> 주문하실 아이템을 확인하세요.</b>
</div>

<div class="table-responsive order-item">
	<table id="sod_list" class="table bsk-tbl">
	<thead>
	<tr class="active">
		<th scope="col">이미지</th>
		<th scope="col">상품명</th>
		<th scope="col">총수량</th>
		<th scope="col">판매가</th>
		<th scope="col">쿠폰</th>
		<th scope="col">소계</th>
		<th scope="col">포인트</th>
		<th scope="col">배송비</th>
	</tr>
	</thead>
	<tbody>
	<?php for($i=0; $i < count($item); $i++) { ?>
		<tr>
			<td class="text-center">
				<div class="item-img">
					<?php echo get_it_image($item[$i]['it_id'], 70, 70); ?>
					<div class="item-type"><?php echo $item[$i]['pt_it']; ?></div>
				</div>
			</td>
			<td>
				<input type="hidden" name="it_id[<?php echo $i; ?>]"    value="<?php echo $item[$i]['hidden_it_id']; ?>">
				<input type="hidden" name="it_name[<?php echo $i; ?>]"  value="<?php echo $item[$i]['hidden_it_name']; ?>">
				<input type="hidden" name="it_price[<?php echo $i; ?>]" value="<?php echo $item[$i]['hidden_sell_price']; ?>">
				<input type="hidden" name="cp_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['hidden_cp_id']; ?>">
				<input type="hidden" name="cp_price[<?php echo $i; ?>]" value="<?php echo $item[$i]['hidden_cp_price']; ?>">
				<?php if($default['de_tax_flag_use']) { ?>
					<input type="hidden" name="it_notax[<?php echo $i; ?>]" value="<?php echo $item[$i]['hidden_it_notax']; ?>">
				<?php } ?>
				<b><?php echo $item[$i]['it_name']; ?></b>
				<?php if($item[$i]['it_options']) { ?>
					<div class="well well-sm"><?php echo $item[$i]['it_options'];?></div>
				<?php } ?>
			</td>
			<td class="text-center"><?php echo $item[$i]['qty']; ?></td>
			<td class="text-right"><?php echo $item[$i]['ct_price']; ?></td>
			<td class="text-center">
				<?php if($item[$i]['is_coupon']) { ?>
					<div class="btn-group">
						<button type="button" class="cp_btn btn btn-black btn-xs">적용</button>
					</div>
				<?php } ?>
			</td>
			<td class="text-right"><b><?php echo $item[$i]['total_price']; ?></b></td>
			<td class="text-right"><?php echo $item[$i]['point']; ?></td>
			<td class="text-center"><?php echo $item[$i]['ct_send_cost']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<?php if ($goods_count) $goods .= ' 외 '.$goods_count.'건'; ?>

<!-- 주문상품 합계 시작 { -->
<div class="well">
	<div class="row">
		<div class="col-xs-6">주문금액</div>
		<div class="col-xs-6 text-right">
			<strong><?php echo number_format($tot_sell_price); ?> 원</strong>
		</div>
		<?php if($it_cp_count > 0) { ?>
			<div class="col-xs-6">쿠폰할인</div>
			<div class="col-xs-6 text-right">
				<strong id="ct_tot_coupon">0 원</strong>
			</div>
		<?php } ?>
		<div class="col-xs-6">배송비</div>
		<div class="col-xs-6 text-right">
			<strong><?php echo number_format($send_cost); ?> 원</strong>
		</div>
	</div>

	<div class="row">
		<?php $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비 ?>
		<div class="col-xs-6 red"> <b>합계금액</b></div>
		<div class="col-xs-6 text-right red">
			<strong id="ct_tot_price"><?php echo number_format($tot_price); ?> 원</strong>
		</div>
	</div>

	<div class="row">	
		<div class="col-xs-6"> 포인트</div>
		<div class="col-xs-6 text-right">
			<strong><?php echo number_format($tot_point); ?> 점</strong>
		</div>
	</div>
</div>
