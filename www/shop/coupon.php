<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

$pid = ($pid) ? $pid : ''; // Page ID
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('coupon.skin.php', '/shop/coupon');

$sql = " select cp_id, cp_subject, cp_method, cp_target, cp_start, cp_end, cp_type, cp_price
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
            order by cp_no ";
$result = sql_query($sql);

$cp = array();

$k = 0;
for($i=0; $row=sql_fetch_array($result); $i++) {
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;

	if($row['cp_method'] == 1) {
		$sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
		$ca = sql_fetch($sql);
		$cp_target = $ca['ca_name'].'의 상품할인';
	} else if($row['cp_method'] == 2) {
		$cp_target = '결제금액 할인';
	} else if($row['cp_method'] == 3) {
		$cp_target = '배송비 할인';
	} else {
		$sql = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
		$it = sql_fetch($sql);
		$cp_target = $it['it_name'].' 상품할인';
	}

	if($row['cp_type'])
		$cp_price = $row['cp_price'].'%';
	else
		$cp_price = number_format($row['cp_price']).'원';

	$cp[$k] = $row;
	$cp[$k]['cp_target'] = $cp_target;
	$cp[$k]['cp_price'] = $cp_price;

	$k++;
}

$g5['title'] = $member['mb_nick'].' 님의 쿠폰 내역';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($skin_path.'/coupon.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>