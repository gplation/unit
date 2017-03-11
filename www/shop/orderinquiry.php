<?php
include_once('./_common.php');

define("_ORDERINQUIRY_", true);

$od_pwd = sql_password($od_pwd);

// 회원인 경우
if ($is_member)
{
    $sql_common = " from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' ";
}
else if ($od_id && $od_pwd) // 비회원인 경우 주문서번호와 비밀번호가 넘어왔다면
{
    $sql_common = " from {$g5['g5_shop_order_table']} where od_id = '$od_id' and od_pwd = '$od_pwd' ";
}
else // 그렇지 않다면 로그인으로 가기
{
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_SHOP_URL.'/orderinquiry.php'));
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 비회원 주문확인시 비회원의 모든 주문이 다 출력되는 오류 수정
// 조건에 맞는 주문서가 없다면
if ($total_count == 0)
{
    if ($is_member) // 회원일 경우는 메인으로 이동
        alert('주문이 존재하지 않습니다.', G5_SHOP_URL);
    else // 비회원일 경우는 이전 페이지로 이동
        alert('주문이 존재하지 않습니다.');
}

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


// 비회원 주문확인의 경우 바로 주문서 상세조회로 이동
if (!$is_member)
{
    $sql = " select od_id, od_time, od_ip from {$g5['g5_shop_order_table']} where od_id = '$od_id' and od_pwd = '$od_pwd' ";
    $row = sql_fetch($sql);
    if ($row['od_id']) {
        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
        set_session('ss_orderview_uid', $uid);
        goto_url(G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'].'&amp;uid='.$uid);
    }
}

$list = array();

$limit = " limit $from_record, $rows ";
$sql = " select *
		   from {$g5['g5_shop_order_table']}
		  where mb_id = '{$member['mb_id']}'
		  order by od_id desc
		  $limit ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

	switch($row['od_status']) {
		case '주문':
			$od_status = '입금확인중';
			break;
		case '입금':
			$od_status = '입금완료';
			break;
		case '준비':
			$od_status = '상품준비중';
			break;
		case '배송':
			$od_status = '상품배송';
			break;
		case '완료':
			$od_status = '배송완료';
			break;
		default:
			$od_status = '주문취소';
			break;
	}
	
	$list[$i] = $row;
	$list[$i]['od_href'] = G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'].'&amp;uid='.$uid;
	$list[$i]['od_total_price'] = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];
	$list[$i]['od_status'] = $od_status;
}

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=';

// Page ID
$pid = ($pid) ? $pid : 'inquiry';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('orderinquiry.skin.php', '/shop/inquiry');

$g5['title'] = '주문내역조회';
include_once('./_head.php');
include_once($skin_path.'/orderinquiry.skin.php');
include_once('./_tail.php');
?>
