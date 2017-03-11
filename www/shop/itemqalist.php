<?php
include_once('./_common.php');

// Page ID
$pid = ($pid) ? $pid : 'iqa';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$g5['title'] = '문의검색';
include_once('./_head.php');

$sfl = trim($_REQUEST['sfl']);
$stx = trim($_REQUEST['stx']);

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where (1) ";

if(!$sfl)
    $sfl = 'b.it_name';

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "a.it_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.iq_name" :
        case "a.mb_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

// 분류추가
if($ca_id) {
	$sql_search .= "and (b.ca_id like '{$ca_id}%' or b.ca_id2 like '{$ca_id}%' or b.ca_id3 like '{$ca_id}%')";
}

if (!$sst) {
    $sst  = "a.iq_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common
         $sql_search
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$list = array();

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.it_name
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$admin_photo = apms_photo_url($config['cf_admin']);
$iq_num = $total_count - ($page - 1) * $rows;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['iq_num'] = $iq_num;
	$list[$i]['secret'] = false;
	if($row['iq_secret']) {
		if($is_admin || $member['mb_id' ] == $row['mb_id']) {
			$list[$i]['iq_question'] = apms_content(conv_content($list[$i]['iq_question'], 1));
		} else {
			$list[$i]['iq_question'] = '비밀글로 보호된 문의입니다.';
			$list[$i]['secret'] = true;
		}
	} 

	$list[$i]['iq_time'] = strtotime($row['iq_time']);
	$list[$i]['it_href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['iq_photo'] = apms_photo_url($row['mb_id']);
	if($row['pt_id']) {
		$list[$i]['ans_photo'] = ($row['pt_id'] == $config['cf_admin']) ? $admin_photo : apms_photo_url($row['pt_id']);
	} else {
		$list[$i]['ans_photo'] = $admin_photo;
	}
	$list[$i]['answer'] = false;
	if(!$list[$i]['secret']) {
		if ($row['iq_answer']) {
			$list[$i]['iq_answer'] = apms_content(conv_content($list[$i]['iq_answer'], 1));
			$list[$i]['answer'] = true;
		}
	}

	$iq_num--;
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?';
if($ca_id) $list_page .= '&amp;ca_id='.$ca_id;
if($pid != 'iuse' && $pid) $list_page .= '&amp;pid='.$pid;
$list_page .= $qstr.'&amp;page=';

list($skin_path, $skin_url) = apms_skin_path('qalist.skin.php', '/shop/qalist');

include_once($skin_path.'/qalist.skin.php');
include_once('./_tail.php');

?>
