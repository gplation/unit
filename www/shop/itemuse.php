<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');

	if(!defined('THEMA_PATH')) {
		if(!$ca_id) {
			$it = sql_fetch(" select it_id, ca_id, pt_id, pt_review_use from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");
			$ca_id = $it['ca_id'];
		}
		$at = apms_ca_thema($ca_id, $ca, 1);
		include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$at['item'];
		$item_skin_url = G5_SKIN_URL.'/apms/item/'.$at['item'];
	}

	// 출력수
	if(!$urows) $itemrows = apms_rows('iuse_'.MOBILE_.'rows');

	// 스킨설정
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$wset = array();
	if($ca['as_'.MOBILE_.'item_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
	}
} else {
	$page = 0;
}

// 후기권한 재설정
$is_free_write = ($it['pt_review_use'] || !$default['de_item_use_write']) ? true : false;

$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";

// 테이블의 전체 레코드수만 얻음
if($is_item) {
	$total_count = $item_use_count;
} else {
	$sql = " select COUNT(*) as cnt " . $sql_common;
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];
}

$urows = ($urows > 0) ? $urows : $itemrows['iuse_'.MOBILE_.'rows'];
$urows = ($urows > 0) ? $urows : 20;

$total_page  = ceil($total_count / $urows); // 전체 페이지 계산
if($page > 0) {
	;
} else {
	$page = 1; // 페이지가 없으면 1페이지
}

$from_record = ($page - 1) * $urows; // 시작 레코드 구함

if($from_record < 0)
	$from_record = 0;

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows;
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page='.$page;

$list = array();
$sql = "select * $sql_common order by is_id desc limit $from_record, $urows ";
$result = sql_query($sql);

$iuse_num = $total_count - ($page - 1) * $urows;
for ($i=0; $row=sql_fetch_array($result); $i++)	{
	$list[$i] = $row;
	$list[$i]['is_num'] = $iuse_num;
	$list[$i]['is_time'] = strtotime($row['is_time']);
	$list[$i]['is_star'] = apms_get_star($row['is_score']);
	$list[$i]['is_photo'] = apms_photo_url($row['mb_id']);
	$list[$i]['is_href'] = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
	$list[$i]['is_edit_href'] = $itemuse_form.'&amp;is_id='.$row['is_id'].'&amp;page='.$page.'&amp;w=u';
	$list[$i]['is_edit_self'] = $itemuse_form.'&amp;is_id='.$row['is_id'].'&amp;page='.$page.'&amp;w=u&amp;move=1';

	$list[$i]['is_content'] = apms_content(conv_content($list[$i]['is_content'], 1));

	$hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);
	$list[$i]['is_del_href'] = $itemuse_formupdate.'&amp;is_id='.$row['is_id'].'&amp;w=d&amp;hash='.$hash;
	$list[$i]['is_del_return'] = './itemuse.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page='.$page;
	$list[$i]['is_btn'] = ($is_admin || $row['mb_id'] == $member['mb_id']) ? true : false;
	$iuse_num--;
}

$admin_href = ($is_admin == 'super' || IS_PARTNER) ? './myshop.php?mode=uselist' : '';
$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemuse.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page=';

include_once($item_skin_path.'/itemuse.skin.php');

unset($list);
?>