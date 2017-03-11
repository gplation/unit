<?php
include_once('./_common.php');

// 상품정보
$sql = " select it_id, ca_id, it_name, it_soldout, it_stock_sms
            from {$g5['g5_shop_item_table']}
            where it_id = '$it_id' ";
$it = sql_fetch($sql);

if(!$it['it_id'])
    alert_close('자료가 없습니다.');

if(!$it['it_soldout'] || !$it['it_stock_sms'])
    alert_close('재입고SMS 알림을 신청할 수 없는 자료입니다.');

$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
if(!defined('THEMA_PATH')) {
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$at['item'];
	$item_skin_url = G5_SKIN_URL.'/apms/item/'.$at['item'];
}

$g5['title'] = '재입고 알림 (SMS)';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($item_skin_path.'/itemstocksms.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');

?>