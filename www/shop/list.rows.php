<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$list = array();

$npg = apms_escape('npg', 0);
$type = apms_escape('type', 0);
$etype = apms_escape('etype', 0);
$ev_id = apms_escape('ev_id', 0);

// 페이지
$page = $page + $npg;
$page = ($page > 1) ? $page : 2;

if($lm == 'ev') { // 이벤트

	$ev = sql_fetch(" select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' and ev_use = 1 ");
	if (!$ev['ev_id'])
		exit;

	$order_by = ($sort != "") ? $sort.' '.$sortodr.' , b.it_order, b.pt_num desc, b.it_id desc' : 'b.it_order, b.pt_num desc, b.it_id desc'; // 상품 출력순서가 있다면
	$where = "a.ev_id = '{$ev_id}' and b.it_use = '1'";
	if($type) $where .= " and b.it_type{$type} = '1'";
	if($etype) $where .= " and a.ev_type = '{$etype}'";
	if($ca_id) $where .= " and (b.ca_id like '{$ca_id}%' or b.ca_id2 like '{$ca_id}%' or b.ca_id3 like '{$ca_id}%')";

	// 스킨값 정리
	$list_id = $ev['ev_id'];
	$thumb_w = $ev['ev_'.MOBILE_.'img_width'];
	$thumb_h = $ev['ev_'.MOBILE_.'img_height'];
	$list_mods = $ev['ev_'.MOBILE_.'list_mod'];
	$list_rows = $ev['ev_'.MOBILE_.'list_row'];
	if(!$list_mods) $list_mods = 3;
	if(!$list_rows) $list_rows = 1;

	// 총몇개 = 한줄에 몇개 * 몇줄
	$item_rows = $list_rows * $list_mods;

	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;

	// 시작 레코드 구함
	$from_record = ($page - 1) * $item_rows;

	// 전체 페이지 계산
	$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) where $where ");
	$total_count = $row2['cnt'];
	$total_page  = ceil($total_count / $item_rows);

	if($page > $total_page) exit;

	// 리스트
	$qstr = '';
	if($ca_id) $qstr .= '&amp;ca_id='.$ca_id;

	$result = sql_query(" select * from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$qstr;
	}

	// 스킨설정
	$wset = array();
	if($ev['ev_'.MOBILE_.'set']) {
		$wset = apms_unpack($ev['ev_'.MOBILE_.'set']);
	}
} else {

	// 분류
	$ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1' ");
	if (!$ca['ca_id'])
		exit;

	// 인증
	if(!$is_admin) {
	    $msg = shop_member_cert_check($ca_id, 'list');
	    if($msg)
	        exit;

		if($ca['as_partner'] && !IS_PARTNER) 
			exit;

		if(apms_auth($ca['as_grade'], $ca['as_equal'], $ca['as_min'], $ca['as_max']))
			exit;
	}

	$order_by = ($sort != "") ? $sort.' '.$sortodr.' , it_order, pt_num desc, it_id desc' : 'it_order, pt_num desc, it_id desc'; // 상품 출력순서가 있다면
	$where = "it_use = '1'";
	if($type) $where .= " and it_type{$type} = '1'";
	if($ca_id) $where .= " and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%')";

	$thumb_w = $ca['ca_'.MOBILE_.'img_width'];
	$thumb_h = $ca['ca_'.MOBILE_.'img_height'];
	$list_mods = $ca['ca_'.MOBILE_.'list_mod'];
	$list_rows = $ca['ca_'.MOBILE_.'list_row'];
	if(!$list_mods) $list_mods = 3;
	if(!$list_rows) $list_rows = 1;

	// 총몇개 = 한줄에 몇개 * 몇줄
	$item_rows = $list_rows * $list_mods;

	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;

	// 시작 레코드 구함
	$from_record = ($page - 1) * $item_rows;

	// 전체 페이지 계산
	$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_table']}` where $where ");
	$total_count = $row2['cnt'];
	$total_page  = ceil($total_count / $item_rows);

	if($page > $total_page) exit;

	// 리스트
	$qstr = '';
	if($ev_id) $qstr .= '&amp;ev_id='.$ev_id;
	if($ca_id) $qstr .= '&amp;ca_id='.$ca_id;
	if($type) $type .= '&amp;type='.$type;
	if($sort) $qstr .= '&amp;sort='.$sort;
	if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;
	if($page) $qstr .= '&amp;page='.$page;

	$num = $total_count - ($page - 1) * $item_rows;
	$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$qstr;
		$list[$i]['num'] = $num;
		$num--;
	}

	// 스킨설정
	$wset = array();
	if($ca['as_'.MOBILE_.'list_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'list_set']);
	}
}

?>
