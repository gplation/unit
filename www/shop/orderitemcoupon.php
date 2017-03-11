<?php
include_once('./_common.php');

if($is_guest)
    exit;

// 상품정보
$it_id = $_POST['it_id'];
$sw_direct = $_POST['sw_direct'];
$sql = " select it_id, ca_id, ca_id2, ca_id3 from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$it = sql_fetch($sql);

// 상품 총 금액
if($sw_direct)
    $cart_id = get_session('ss_cart_direct');
else
    $cart_id = get_session('ss_cart_id');

$sql = " select SUM( IF(io_type = '1', io_price * ct_qty, (ct_price + io_price) * ct_qty)) as sum_price
            from {$g5['g5_shop_cart_table']}
            where od_id = '$cart_id'
              and it_id = '$it_id' ";
$ct = sql_fetch($sql);
$item_price = $ct['sum_price'];

$list = array();

// 쿠폰정보
$sql = " select *
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
              and cp_minimum <= '$item_price'
              and (
                    ( cp_method = '0' and cp_target = '{$it['it_id']}' )
                    OR
                    ( cp_method = '1' and ( cp_target IN ( '{$it['ca_id']}', '{$it['ca_id2']}', '{$it['ca_id3']}' ) ) )
                  ) ";
$result = sql_query($sql);
$count = mysql_num_rows($result);
$z = 0;
for($i=0; $row=sql_fetch_array($result); $i++) {
	// 사용한 쿠폰인지 체크
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;

	$list[$z] = $row;

	$dc = 0;
	if($row['cp_type']) {
		$dc = floor(($item_price * ($row['cp_price'] / 100)) / $row['cp_trunc']) * $row['cp_trunc'];
	} else {
		$dc = $row['cp_price'];
	}

	if($row['cp_maximum'] && $dc > $row['cp_maximum'])
		$dc = $row['cp_maximum'];

	$list[$z]['dc'] = $dc;

	$z++;
}

$is_coupon = ($z > 0) ? true : false;

$pid = ($pid) ? $pid : ''; // Page ID
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('ordercoupon.item.skin.php', '/shop/order');

include_once($skin_path.'/ordercoupon.item.skin.php');

?>