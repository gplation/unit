<?php
include_once('./_common.php');

if($is_guest)
    exit;

$price = $_POST['price'];
$send_cost = $_POST['send_cost'];

$list = array();

// 쿠폰정보
$sql = " select *
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_method = '3'
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
              and cp_minimum <= '$price' ";
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
		$dc = floor(($send_cost * ($row['cp_price'] / 100)) / $row['cp_trunc']) * $row['cp_trunc'];
	} else {
		$dc = $row['cp_price'];
	}

	if($row['cp_maximum'] && $dc > $row['cp_maximum'])
		$dc = $row['cp_maximum'];

	if($dc > $send_cost)
		$dc = $send_cost;

	$list[$z]['dc'] = $dc;

	$z++;
}

$is_coupon = ($z > 0) ? true : false;

$pid = ($pid) ? $pid : ''; // Page ID
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('ordercoupon.sendcost.skin.php', '/shop/order');

include_once($skin_path.'/ordercoupon.sendcost.skin.php');

?>
