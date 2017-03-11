<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//전체알림
$notice = conv_content(trim($apms['apms_notice']), 0);

//개별알림
$message = conv_content(trim($partner['pt_memo']), 0);

// 오늘
$today = date("Y-m-d", G5_SERVER_TIME);

//오늘 매출
$row = sql_fetch(" select sum(pt_sale) as sale from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) = '$today' ");
$today_sales = $row['sale'];

//오늘 댓글
$row = sql_fetch(" select count(*) as cnt from {$g5['apms_comment']} where pt_id = '{$member['mb_id']}' and mb_id <> '{$member['mb_id']}' and SUBSTRING(wr_datetime,1,10) = '$today' ");
$today_comments = $row['cnt'];

//오늘 문의
$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_qa_table']} where pt_id = '{$member['mb_id']}' and mb_id <> '{$member['mb_id']}' and SUBSTRING(iq_time,1,10) = '$today' ");
$today_questions = $row['cnt'];

//오늘 후기
$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_use_table']} where pt_id = '{$member['mb_id']}' and SUBSTRING(is_time,1,10) = '$today' ");
$today_reviews = $row['cnt'];

//매출 추이
$list = array();
$pre_date = G5_SERVER_TIME - (30 * 86400); // 30일전까지
$preday = date("Y-m-d", $pre_date);

$sql = " select *, SUBSTRING(pt_datetime,1,10) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) between '$preday' and '$today' order by pt_datetime desc ";

$z = 0;
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

	if ($i == 0) {
		$save['date'] = $row['sale_date'];
	}

	if ($save['date'] != $row['sale_date']) {
		$list[$z] = $save;
		$z++;
		unset($save);
		$save['date'] = $row['sale_date'];
	}

	// 매출
	$netsale = $row['pt_sale'] - $row['pt_commission'] - $row['pt_point'] + $row['pt_incentive'];
	$save['count']++;
	$save['sale']    += $row['pt_sale'];
	$save['qty']    += $row['ct_qty'];
	$save['commission']   += $row['pt_commission'];
	$save['point']   += $row['pt_point'];
	$save['incentive']   += $row['pt_incentive'];
	$save['netsale']   += $netsale;
	$save['net']   += $row['pt_net'];
	$save['vat']   += ($netsale - $row['pt_net']);
}

// 기업정보
switch($partner['pt_type']) {
	case '1'	: $company_info = ($partner['pt_company_name']) ? $partner['pt_company_name'].' ('.$partner['pt_company_president'].', '.$partner['pt_company_saupja'].')' : '미등록'; break;
	case '2'	: $company_info = '개인 파트너'; break;
	default		: $company_info = '미등록'; break;
}

// 정산방법
switch($partner['pt_flag']) {
	case '1'	: $account_info = '신청금액'; break;
	case '2'	: $account_info = '신청금액 - 부가세'; break;
	case '3'	: $account_info = '신청금액 - 부가세 - 제세공제(원천징수 3.3% 등)'; break;
	case '4'	: $account_info = '기타'; break;
	default		: $account_info = '미등록'; break;
}

// 출금내역 - 최근 5건
$account = array();
$sql  = " select * from {$g5['apms_payment']} where mb_id = '{$member['mb_id']}' order by pp_id desc limit 0, 3";
$result = sql_query($sql);
for ($i=0; $row=mysql_fetch_array($result); $i++) {
	$account[$i] = $row;
	$account[$i]['pp_no'] = $row['pp_id'];
	$account[$i]['pp_date'] = date("Y/m/d", strtotime($row['pp_datetime']));

	switch($row['pp_means']) {
		case '1'	: $pp_means = AS_MP.'전환'; break;
		default		: $pp_means = '통장입금'; break;
	}
	$account[$i]['pp_means'] = $pp_means;

	switch($row['pp_confirm']) {
		case '1'	: $pp_confirm = '완료'; break;
		case '2'	: $pp_confirm = '취소'; break;
		default		: $pp_confirm = '신청'; break;
	}

	$account[$i]['pp_confirm'] = $pp_confirm;
}

include_once($skin_path.'/dashboard.skin.php');

?>
