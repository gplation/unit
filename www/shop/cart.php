<?php
include_once('./_common.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

// Page ID
$pid = ($pid) ? $pid : 'cart';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('cart.skin.php', '/shop/cart');

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$action_url = G5_SHOP_URL.'/cartupdate.php';

$tot_point = 0;
$tot_sell_price = 0;

// $s_cart_id 로 현재 장바구니 자료 쿼리
$sql = " select a.ct_id,
				a.it_id,
				a.it_name,
				a.ct_price,
				a.ct_point,
				a.ct_qty,
				a.ct_status,
				a.ct_send_cost,
				a.it_sc_type,
				b.ca_id,
				b.ca_id2,
				b.ca_id3,
				b.pt_it,
				b.pt_msg1,
				b.pt_msg2,
				b.pt_msg3
		   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
		  where a.od_id = '$s_cart_id' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$cart_count = mysql_num_rows($result);

$it_send_cost = 0;

$item = array();

for ($i=0; $row=mysql_fetch_array($result); $i++)
{
	// 합계금액 계산
	$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_point * ct_qty) as point,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where it_id = '{$row['it_id']}'
				  and od_id = '$s_cart_id' ";
	$sum = sql_fetch($sql);

	$item[$i] = $row;

	$item[$i]['pt_it'] = apms_pt_it($row['pt_it'],1);

	if ($i==0) { // 계속쇼핑
		$continue_ca_id = $row['ca_id'];
	}

	$item[$i]['it_options'] = print_item_options($row['it_id'], $s_cart_id, $row['pt_msg1'], $row['pt_msg2'], $row['pt_msg3']);

	// 배송비
	switch($row['ct_send_cost'])
	{
		case 1:
			$ct_send_cost = '착불';
			break;
		case 2:
			$ct_send_cost = '무료';
			break;
		default:
			$ct_send_cost = '선불';
			break;
	}

	// 조건부무료
	if($row['it_sc_type'] == 2) {
		$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

		if($sendcost == 0)
			$ct_send_cost = '무료';
	}

	$point      = $sum['point'];
	$sell_price = $sum['price'];

	$item[$i]['sendcost'] = $sendcost;
	$item[$i]['ct_send_cost'] = $ct_send_cost;
	$item[$i]['point'] = $point;
	$item[$i]['sell_price'] = $sell_price;
	$item[$i]['qty'] = $sum['qty'];

	$tot_point      += $point;
	$tot_sell_price += $sell_price;

} // for 끝

// 배송비 계산
if ($i > 0) {
	$send_cost = get_sendcost($s_cart_id, 0);
}

// 총계 = 주문상품금액합계 + 배송비
$tot_price = $tot_sell_price + $send_cost; 

$g5['title'] = '장바구니';
include_once('./_head.php');
include_once($skin_path.'/cart.skin.php');
include_once('./_tail.php'); 
?>