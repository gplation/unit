<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

if($mode == "4") { //완료처리
	apms_order_it($ct, $member['mb_id']);
	goto_url('./shopping.php?mode=2&amp;page='.$page);
}

if(!$mode) $mode = 1;

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('shopping.skin.php', '/shop/shopping');

$g5['title'] = $member['mb_nick'].' 님의 쇼핑리스트';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');

$list = array();

$rows = $config['cf_'.MOBILE_.'page_rows'];

$sql_common = " from {$g5['g5_shop_cart_table']} a join {$g5['g5_shop_order_table']} b on (a.od_id=b.od_id) join {$g5['g5_shop_item_table']} c on (a.it_id=c.it_id) where a.mb_id = '{$member['mb_id']}' ";
if($ca_id) {
	$sql_common .= " and (c.ca_id like '{$ca_id}%' or c.ca_id2 like '{$ca_id}%' or c.ca_id3 like '{$ca_id}%')";
}
if($mode == "2") {
	$sql_common .= " and a.ct_status = '배송' ";
} else if($mode == "3") {
	$sql_common .= " and (a.ct_status = '입금' or a.ct_status = '준비') ";
} else {
	$sql_common .= " and a.ct_status = '완료' ";
}

$sql_order = " order by a.od_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.*, c.ca_id, c.ca_id2, c.ca_id3 {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
$num = $total_count - ($page - 1) * $rows;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['num'] = $num;
	$list[$i]['it_href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
	$list[$i]['od_date'] = strtotime($row['od_time']);
	$uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
	$list[$i]['od_href'] = G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'].'&amp;uid='.$uid;
	$opt_msg = $row['ct_option'];
	if($opt['pt_msg1']) {
		$opt_msg .= '<div class="text-muted">';
		if($row['pt_msg1']) $opt_msg .= $row['pt_msg1'].' : ';
		$opt_msg .= $opt['pt_msg1'].'</div>';

	}
	if($opt['pt_msg2']) {
		$opt_msg .= '<div class="text-muted">';
		if($row['pt_msg2']) $opt_msg .= $row['pt_msg2'].' : ';
		$opt_msg .= $opt['pt_msg2'].'</div>';

	}
	if($opt['pt_msg3']) {
		$opt_msg .= '<div class="text-muted">';
		if($row['pt_msg3']) $opt_msg .= $row['pt_msg3'].' : ';
		$opt_msg .= $opt['pt_msg3'].'</div>';

	}

	$list[$i]['option'] = $opt_msg;

	$list[$i]['delivery'] = '';
	$list[$i]['de_href'] = '';
	if($mode == "2") {
		if($row['pt_id']) {
			if($row['pt_send'] && $row['pt_send_num']) {
				$list[$i]['delivery'] = $row['pt_send'].' '.$row['pt_send_num'];
			} 
		} else {
			if($row['od_invoice'] && $row['od_delivery_company']) {
				$list[$i]['delivery'] = $row['od_delivery_company'].' '.$row['od_invoice'];
			}
		}
		
		if($list[$i]['delivery']) {
			$list[$i]['de_href'] = './shopping.php?mode=4&amp;ct='.$row['ct_id'].'&amp;page='.$page;
		}
	}

	$num--;
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?mode='.$mode;
if($ca_id) $list_page .= '&amp;ca_id='.$ca_id;
$list_page .= '&amp;page=';

include_once($skin_path.'/shopping.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>
