<?php
include_once('./_common.php');

$id = apms_escape_string(trim($id));

if(!$id) {
	goto_url(G5_SHOP_URL.'/partner');
}

$author = array();
$mb_id = $id;
$author = apms_member($mb_id);

$is_auth = false;
if($is_admin == 'super') {
	$is_auth = true;
} else {
	if(!$author['partner']) {
		alert('등록된 마이샵이 없습니다.', G5_URL);
	}
}

// RSS
$rss_href = G5_URL.'/rss/?id='.$id;

// Partner
$myshop_href = ($mb_id == $member['mb_id']) ? G5_SHOP_URL.'/partner' : '';

$author_homepage = set_http(clean_xss_tags($author['mb_homepage']));
$author_profile = ($author['mb_profile']) ? conv_content($author['mb_profile'],0) : '';
$author_signature = ($author['mb_signature']) ? apms_content(conv_content($author['mb_signature'], 1)) : '';

// where
if($is_auth) { // 최고관리자는 자기꺼와 파트너아이디 없는 것 다 보여줌
	$sql_where = " and (pt_id = '' or pt_id = '{$mb_id}')";
} else { // 파트너는 자기꺼만 보여줌
	$sql_where = " and pt_id = '{$mb_id}'";
}

// 분류
$category = array();
$category_options  = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if (!$is_auth)
    $sql .= " where pt_use = '1' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$c = $row['ca_id'];
	$category[$c] = $row['ca_name'];

	$len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }
	$selected = ($ca_id == $row['ca_id']) ? ' selected' : '';
	$category_options .= '<option value="'.$row['ca_id'].'"'.$selected.'>'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
}

$order_by = ($sort != "") ? $sort.' '.$sortodr.' , pt_show, pt_num desc, it_id desc' : 'pt_show, pt_num desc, it_id desc'; // 상품 출력순서가 있다면
$where = "it_use = '1'";
$where .= $sql_where;
if($type) $where .= " and it_type{$type} = '1'";
if($ca_id) $where .= " and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%')";

// 상품리스트
$list = array();
$rows_filter = 'myshop_'.MOBILE_.'mods, myshop_'.MOBILE_.'rows, myshop_'.MOBILE_.'img_width, myshop_'.MOBILE_.'img_height, myshop_'.MOBILE_.'skin';
$listrows = apms_rows($rows_filter);
$list_mods = $listrows['myshop_'.MOBILE_.'mods'];
$list_rows = $listrows['myshop_'.MOBILE_.'rows'];
$thumb_w = $listrows['myshop_'.MOBILE_.'img_width'];
$thumb_h = $listrows['myshop_'.MOBILE_.'img_height'];
if(!$list_mods) $list_mods = 3;
if(!$list_rows) $list_rows = 1;
$rows = $list_mods * $list_rows;

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $rows;

// 전체 페이지 계산
$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_table']}` where $where ");
$total_count = $row2['cnt'];
$total_page  = ceil($total_count / $rows);

// 리스트
$num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['num'] = $num;
	$num--;
}

// 정렬
$list_sort_href = $_SERVER['PHP_SELF'].'?id='.$id;
if($ca_id) $list_sort_href .= '&amp;ca_id='.$ca_id;
$list_sort_href .= '&amp;sort=';

// 페이징
if($qstr) $qstr .= '&amp;';
$qstr .= 'id='.$id.'&amp;ca_id='.$ca_id.'&amp;sort='.$sort.'&amp;sortodr='.$sortodr;

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=';

$list_all = './myshop.php?id='.$id;

// Page ID
$pid = ($pid) ? $pid : 'myshop';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('myshop.skin.php', '/shop/myshop');

$lm = 'myshop'; // 리스트 모드
$ls = $listrows['myshop_'.MOBILE_.'skin']; // 리스트 스킨
$list_skin_path = G5_SKIN_PATH.'/apms/list/'.$ls;
$list_skin_url = G5_SKIN_URL.'/apms/list/'.$ls;

// 셋업
$setup_href = '';
if ($is_demo || $is_admin == 'super') {
    $setup_href = './list.setup.php?skin='.urlencode($ls);
}

// 목록설정
$wset = apms_widget_config($ls, '', 99);

include_once('./_head.php');
if($skin_path.'/myshop.head.skin.php') {
	@include_once($skin_path.'/myshop.head.skin.php');
	include_once($list_skin_path.'/list.skin.php');
	@include_once($skin_path.'/myshop.tail.skin.php');
} else {
	include_once($skin_path.'/myshop.skin.php');
}
include_once('./_tail.php'); 
?>