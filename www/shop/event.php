<?php
include_once('./_common.php');

$pid = ($pid) ? $pid : 'event'; // Page ID
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// 페이징
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

if($ev_id) { //아이디가 있을 때는 상품리스트
	$sql = " select * from {$g5['g5_shop_event_table']}
			  where ev_id = '$ev_id'
				and ev_use = 1 ";
	$ev = sql_fetch($sql);
	if (!$ev['ev_id'])
		alert('등록된 이벤트가 없습니다.');

	// 상품 리스트
	$list = array();

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
	if(!$list_rows) $list_rows = 5;

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

	// 리스트
	$qstr = '';
	if($ca_id) $qstr .= '&amp;ca_id='.$ca_id;

	$result = sql_query(" select * from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$qstr;
	}

	// 정렬
	$list_sort_href = $_SERVER['PHP_SELF'].'?ev_id='.$ev_id;
	if($ca_id) $list_sort_href .= '&amp;ca_id='.$ca_id;
	if($etype) $list_sort_href .= '&amp;etype='.$etype;
	if($eimg) $list_sort_href .= '&amp;eimg='.$eimg;
	$list_sort_href .= '&amp;sort=';

	// 페이징
	$qstr = 'ev_id='.$ev_id;
	if($ca_id) $qstr .= '&amp;ca_id='.$ca_id;
	if($type) $type .= '&amp;type='.$type;
	if($sort) $qstr .= '&amp;sort='.$sort;
	if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;
	if($etype) $qstr .= '&amp;etype='.$etype;
	if($eimg) $qstr .= '&amp;eimg='.$eimg;

	$list_page = $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=';

	// Button
	$admin_href = $config_href = $write_href = $rss_href = '';
	if($is_admin) {
		$admin_href = G5_ADMIN_URL.'/shop_admin/itemevent.php';
		$config_href = G5_ADMIN_URL.'/shop_admin/itemeventform.php?w=u&amp;ev_id='.$ev['ev_id'];
	}

	$is_event = true;

	// List
	$list_skin_path = G5_SKIN_PATH.'/apms/list/'.$ev['ev_'.MOBILE_.'skin'];
	$list_skin_url = G5_SKIN_URL.'/apms/list/'.$ev['ev_'.MOBILE_.'skin'];

	$lm = 'ev'; // 리스트 모드
	$ls = $ev['ev_'.MOBILE_.'skin']; // 리스트 스킨

	// 셋업
	$setup_href = '';
	if ($is_demo || $is_admin == 'super') {
		$setup_href = './skin.setup.php?skin=ev&amp;ev_id='.urlencode($ev['ev_id']);
	}

	$g5['title'] = $ev['ev_subject'];
	include_once('./_head.php');

	// 스킨설정
	$wset = array();
	if($ev['ev_'.MOBILE_.'set']) {
		$wset = apms_unpack($ev['ev_'.MOBILE_.'set']);
	}

	$himg = G5_DATA_PATH.'/event/'.$ev_id.'_h';
	if (file_exists($himg))
		echo '<div id="sev_himg" class="sev_himg"><img src="'.G5_DATA_URL.'/event/'.$ev_id.'_h" alt="" style="max-width:100%;height:auto;"></div>';

	// 상단 HTML
	echo '<div id="sev_hhtml">'.conv_content($ev['ev_head_html'], 1).'</div>';

	$list_skin_file = $list_skin_path.'/list.skin.php';
	if(file_exists($list_skin_file)) {
		include_once($list_skin_file);
	} else {
		echo '<p>'.str_replace(G5_PATH.'/', '', $list_skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
	}

	// 하단 HTML
	echo '<div id="sev_thtml">'.conv_content($ev['ev_tail_html'], 1).'</div>';

	$timg = G5_DATA_PATH.'/event/'.$ev_id.'_t';
	if (file_exists($timg))
		echo '<div id="sev_timg" class="sev_timg"><img src="'.G5_DATA_URL.'/event/'.$ev_id.'_t" alt="" style="max-width:100%;height:auto;"></div>';

	include_once('./_tail.php');

	echo "\n<!-- {$ev['ev_'.MOBILE_.'skin']} -->\n";
} else {

	$event = array();

	$where = '';
	if($etype) $where .= " and ev_type = '{$etype}'";

	if($etype) $qstr .= '&amp;etype='.$etype;
	if($eimg) $qstr .= '&amp;eimg='.$eimg;

	// 배너이미지
	if($eimg != 's') $eimg = 'm';

	list($skin_path, $skin_url) = apms_skin_path('event.skin.php', '/shop/event');

	/* 추후 해제
	$skin_row = array();
	$skin_row = apms_rows('order_'.MOBILE_.'mods, order_'.MOBILE_.'rows, event_'.MOBILE_.'skin, event_'.MOBILE_.'set');
	$skin_path = G5_SKIN_PATH.'/apms/event/'.$skin_row['event_'.MOBILE_.'skin'];
	$skin_url = G5_SKIN_URL.'/apms/event/'.$skin_row['event_'.MOBILE_.'skin'];
	*/

	// 셋업
	$setup_href = '';
	if ($is_demo || $is_admin == 'super') {
		$setup_href = './skin.setup.php?skin=event';
	}

	$list_mods = $skin_row['event_'.MOBILE_.'mods'];
	$list_rows = $skin_row['event_'.MOBILE_.'rows'];
	if(!$list_mods) $list_mods = 1;
	if(!$list_rows) $list_rows = 5;

	// 총몇개 = 한줄에 몇개 * 몇줄
	$item_rows = $list_rows * $list_mods;

	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;
	// 시작 레코드 구함
	$from_record = ($page - 1) * $item_rows;

	// 전체 페이지 계산
	$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_event_table']}` where ev_use = '1' $where ");
	$total_count = $row2['cnt'];
	$total_page  = ceil($total_count / $item_rows);

	// 리스트
	$i = 0;
	$result = sql_query(" select * from `{$g5['g5_shop_event_table']}` where ev_use = '1' $where order by ev_id desc limit $from_record, $item_rows ");
	while($row=sql_fetch_array($result)) { 
		$event[$i] = $row;
		$event[$i]['ev_banner'] = G5_DATA_URL.'/event/'.$row['ev_id'].'_'.$eimg;
		$event[$i]['ev_href'] = './event.php?ev_id='.$row['ev_id'].$qstr;

		$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_event_item_table']}` where ev_id = '{$row['ev_id']}' ");
		$event[$i]['ev_cnt'] = $row2['cnt'];
		$i++;
	}

	// Button
	$admin_href = '';
	if($is_admin) {
		$admin_href = G5_ADMIN_URL.'/shop_admin/itemevent.php';
	}

	include_once('./_head.php');

	// 스킨설정
	$wset = array();
	if($skin_row['event_'.MOBILE_.'set']) {
		$wset = apms_unpack($skin_row['event_'.MOBILE_.'set']);
	}

	include_once($skin_path.'/event.skin.php');
	include_once('./_tail.php');
}
?>
