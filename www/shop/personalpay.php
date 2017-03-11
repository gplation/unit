<?php
include_once('./_common.php');

// Rows
$listrows = array();
$rows_filter = 'ppay_'.MOBILE_.'mods, ppay_'.MOBILE_.'rows';
$listrows = apms_rows($rows_filter);

$list_mods = $listrows['ppay_'.MOBILE_.'mods'];
$list_rows = $listrows['ppay_'.MOBILE_.'rows'];
if(!$list_mods) $list_mods = 1;
if(!$list_rows) $list_rows = 3;

$sql_common = " from {$g5['g5_shop_personalpay_table']}	where pp_use = '1' and pp_tno = '' ";

// 리스트
$list = array();

// 총몇개 = 한줄에 몇개 * 몇줄
$items = $list_mods * $list_rows;

$sql = "select COUNT(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 전체 페이지 계산
$total_page  = ceil($total_count / $items);

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;

// 시작 레코드 구함
$from_record = ($page - 1) * $items;

$num = $total_count - ($page - 1) * $items;
$result = sql_query(" select * $sql_common order by pp_id desc limit $from_record, $items");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['pp_href'] = G5_SHOP_URL.'/personalpayform.php?pp_id='.$row['pp_id'].'&amp;page='.$page;
	$list[$i]['pp_num'] = $num;
	$num--;
}

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=';

$pid = ($pid) ? $pid : 'ppay';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('personalpay.skin.php', '/shop/ppay');

$g5['title'] = '개인결제 리스트';
include_once('./_head.php');
include_once($skin_path.'/personalpay.skin.php');
include_once('./_tail.php');
?>
