<?php
if (!defined('_GNUBOARD_')) exit;

// APMS Config
function apms_config() {
	global $g5;

	$row = sql_fetch(" select * from {$g5['apms']} ", false);

	return $row;
}

// Rows
function apms_rows($fields='*') {
	global $g5;

	$rows = sql_fetch(" select $fields from {$g5['apms_rows']} ", false);

	return $rows;
}

// Check Reserve
function apms_check_reserve_end() {
	global $default, $g5;

	$now = G5_SERVER_TIME;

	if($default['pt_reserve_cache'] > 0) {

		// 판매예약 체크
		if($default['pt_reserve_end'] > 0 && $default['pt_reserve_day'] > 0) {
			$cache = $default['pt_reserve_cache'] * 60;
			$second = $now - $default['pt_reserve'];
			if($cache < $second) {

				// 체크 업데이트
				sql_query(" update {$g5['g5_shop_default_table']} set pt_reserve = '{$now}' ", false);

				// 상품 업데이트
				$start = date("Y-m-d H:i:s", ($now - $default['pt_reserve_day'] * 24 * 60 * 60));
				$result = sql_query(" select it_id from {$g5['g5_shop_item_table']} where it_use = '0' and pt_reserve_use = '1' and pt_reserve > 0 and pt_reserve <= '{$now}' and it_time >= '{$start}' order by pt_reserve ", false);
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$num = time();
					sql_query(" update {$g5['g5_shop_item_table']} set pt_num = '{$num}', it_use = '1', pt_reserve_use = '0', pt_reserve = '0' where it_id = '{$row['it_id']}' ", false);
				}
			}
		}

		// 판매종료 체크
		$arr_end_it = array();
		$result = sql_query(" select it_id from {$g5['g5_shop_item_table']} where it_use = '1' and pt_end > 0 and pt_end <= '$now' ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$arr_end_it[] = $row['it_id'];		
		}

		if($i > 0) {
			$end_it = implode(",", $arr_end_it);
			sql_query(" update {$g5['g5_shop_item_table']} set it_use = '0' where find_in_set(it_id,'{$end_it}') ", false);
		}
	}

	if($default['pt_auto'] > 0 && $default['pt_auto_cache'] > 0) {
		$cache = $default['pt_auto_cache'] * 60 * 60;
		$second = $now - $default['pt_auto_time'];
		if($cache < $second) {

			// 체크 업데이트
			sql_query(" update {$g5['g5_shop_default_table']} set pt_auto_time = '{$now}' ", false);

			//상태변경
			$ct_status = '완료';
			$now2 = G5_TIME_YMDHIS;

			$start = date("Y-m-d H:i:s", ($now - $default['pt_auto'] * 24 * 60 * 60));
			$result = sql_query("select * from {$g5['g5_shop_cart_table']} where pt_datetime >= '{$start}' and ct_status = '배송' and ct_select = '1' ", false);
			for ($i=0; $row=sql_fetch_array($result); $i++) {

				$od_id = $row['od_id'];
				$it_id = $row['it_id'];

				// 장바구니 업데이트
				$query = '';

				// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
				if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use']) {
					$po_point = $row['ct_point'] * $row['ct_qty'];
					$po_content = "주문번호 {$od_id} ({$row['it_id']} : {$row['ct_id']}) 결제완료";
					insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
					$query .= ", ct_point_use = '1'";
				}

				// 정산일 반영
				$query .= ", pt_datetime = '$now2'";

				// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
				$ct_history="\n$ct_status|automation|$now2|";
				$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

				$sql = " update {$g5['g5_shop_cart_table']} 
							set ct_status = '$ct_status'
								$query 
								where od_id = '$od_id' and ct_id = '$ct_id'
							";
				sql_query($sql);

				// 판매량 반영
				$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
				sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");

				// 개별배송비 반영
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '$now2' where od_id = '$od_id' and it_id = '$it_id' ", false);
			}
		}
	}

	return;
}


// Vat
function apms_vat($price) {

	$is_minus = ($price > 0) ? false : true;

	$price = abs($price);
	$net = floor($price / 1.1);
	$vat = $price - $net;

	if($is_minus) {
		$net = $net * (-1);
		$vat = $vat * (-1);
	}
	
	$arr = array($net, $vat);

	return $arr;
}

// Item Type
function apms_pt_it($item, $txt='') {

	if($txt) {
		$arr = array("","일반", "컨텐츠");
		$str = $arr[$item];
	} else {
		$str = '<option value="1"'.get_selected('1', $item).'>일반상품(배송가능)</option>'.PHP_EOL;
		$str .= '<option value="2"'.get_selected('2', $item).'>컨텐츠상품(배송불가)</option>'.PHP_EOL;
	}

	return $str;
}

// Get Item
function apms_it($it_id, $opt='') {
	global $g5;

	if(!$it_id) return;

	if($opt)  {
		$sql = " select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' and a.ca_id = b.ca_id ";
	} else {
		$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
	}

	$it = sql_fetch($sql);

	return $it;
}

// 분류리스트
function apms_category($ca_id) {
	global $g5;

	$options = '';
	$result = sql_query(" select * from {$g5['g5_shop_category_table']} where ca_use = '1' order by ca_order, ca_id ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$len = strlen($row['ca_id']) / 2 - 1;

		$nbsp = "";
		for ($i=0; $i<$len; $i++)
			$nbsp .= "&nbsp;&nbsp;&nbsp;";

		$selected = ($ca_id == $row['ca_id']) ? ' selected' : '';
		$options .= '<option value="'.$row['ca_id'].'"'.$selected.'>'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
	}

	return $options;
}

// Payment Item
function apms_it_payment($it_id) {
	global $g5, $member, $is_guest;

	if(!$it_id || $is_guest) return;

    $row = sql_fetch(" select ct_qty, pt_datetime from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' and ct_status = '완료' order by pt_datetime desc, ct_qty desc ");

	return $row;
}

// Used Item
function apms_it_used($it_id) {
	global $g5, $member, $is_guest;

	if(!$it_id || $is_guest) return;

    $row = sql_fetch(" select id from {$g5['apms_use_log']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' ");
	if(!$row['id']) {
		$sql = " insert into {$g5['apms_use_log']} set mb_id = '{$member['mb_id']}', it_id = '{$it_id}', use_datetime = '".G5_TIME_YMDHIS."' ";
		sql_query($sql);
	}

	return;
}

// Commission & Incentive
function apms_pt_rate($apms, $pt_it, $pt_id, $pt_commission, $pt_incentive) {
	global $g5;

	$commission = 0;
	$incentive = 0;

	// It
	$type = array("1", "2");
	if(!in_array($pt_it, $type)) {
		$bill = array($commission, $incentive);
		return $bill;
	}

	// Partner
	$pt = apms_partner($pt_id);
	if(!$pt['pt_id']) {
		$bill = array($commission, $incentive);
		return $bill;
	}

	// Fields
	$cc = 'apms_commission_'.$pt_it;
	$pc = 'pt_commission_'.$pt_it;
	$pi = 'pt_incentive_'.$pt_it;

	// Commission
	if($pt_commission) {
		$commission = $pt_commission;
	} else {
		$commission = ($pt[$pc]) ? $pt[$pc] : $apms[$cc];
	}

	// Incentive
	$incentive = ($pt_incentive) ? $pt_incentive : $pt[$pi];

	$bill = array($commission, $incentive);

	return $bill;
}

// 상품옵션별재고 또는 상품재고에서 빼기
function apms_stock($it_id, $ct_qty, $io_id="", $io_type=0) {
    global $g5;

    if($io_id) {
        $sql = " update {$g5['g5_shop_item_option_table']}
                    set io_stock_qty = io_stock_qty - '{$ct_qty}'
                    where it_id = '{$it_id}'
                      and io_id = '{$io_id}'
                      and io_type = '{$io_type}' ";
    } else {
        $sql = " update {$g5['g5_shop_item_table']}
                    set it_stock_qty = it_stock_qty - '{$ct_qty}'
                    where it_id = '{$it_id}' ";
    }
    return sql_query($sql);
}

// Calculate Account
function apms_account($row) {
	
	$account = array();
	
	// Sales
	if($row['io_type'] == "1") {
		$account['sale'] = $row['io_price'] * $row['ct_qty'];
	} else {
		$account['sale'] = (($row['ct_price'] + $row['io_price']) * $row['ct_qty']);
	}

	// Commission = Sale * Commission Rate
	$account['commission'] = round($account['sale'] * ($row['pt_commission_rate'] / 100));

	// Point
	$account['point'] = $row['ct_point'] * $row['ct_qty'];

	// Incentive = (Sale - Commission - Point) * Incentive Rate
	$account['incentive'] = round(($account['sale'] - $account['commission'] - $account['point']) * ($row['pt_incentive_rate'] / 100));

	// Net = Sale - Commission - Point + Incentive
	$account['amount'] = $account['sale'] - $account['commission'] - $account['point'] + $account['incentive'];

	if($row['ct_notax']) {
		$account['net'] = $account['amount'];
		$account['vat'] = 0;
	} else {

		list($net, $vat) = apms_vat($account['amount']);

		$account['net'] = $net;
		$account['vat'] = $vat;
	}

	return $account;
}

// Update Order
function apms_order($od_id, $od_status) {
	global $g5;

	if(!$od_id) return;

	$arr_it_id = array();
	$arr_no_auto = array();
	$account = array();

	$now = G5_TIME_YMDHIS;
	$od_ok = ($od_status == "입금") ? true : false;

	// APMS
	$apms = sql_fetch(" select apms_commission_1, apms_commission_2, apms_commission_3, apms_commission_4, apms_commission_5 from {$g5['apms']} ", false);

	// 장바구니에서 내역가져오기
	$result = sql_query("select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_select = '1' order by pt_id, it_id", false);
    while ($row = sql_fetch_array($result)) {

		$it = apms_it($row['it_id']); //상품정보

		//커미션, 인센티브
		list($commission, $incentive) = apms_pt_rate($apms, $it['pt_it'], $it['pt_id'], $it['pt_commission'], $it['pt_incentive']);

		$row['pt_commission_rate'] = ($commission) ? $commission : 0;
		$row['pt_incentive_rate'] = ($incentive) ? $incentive : 0;

		$query = "";
		if($od_ok && in_array($it['pt_it'], $g5['apms_automation'])) { //자동처리 상품일 때 입금상태이면 재고반영, 포인트반영, 결제완료 처리함

			//상태변경
			$ct_status = '완료';

			// 장바구니 업데이트
			$query .= ", ct_status = '$ct_status'";

			// 판매량 반영
			$arr_it_id[] = $row['it_id'];

			// 재고량 반영
			if(!$row['ct_stock_use']) {
				//YC5 관리자용 차용
				apms_stock($row['it_id'], $row['ct_qty'], $row['io_id'], $row['io_type']);
				$query .= ", ct_stock_use = '1'";
			}

			// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
			if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use']) {
				$po_point = $row['ct_point'] * $row['ct_qty'];
				$po_content = "주문번호 {$od_id} ({$row['it_id']} : {$row['ct_id']}) 결제완료";
				insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
				$query .= ", ct_point_use = '1'";
			}

			// 정산일 반영
			$query .= ", pt_datetime = '$now'";

			// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
			$ct_history="\n$ct_status|automation|$now|";
			$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

			// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
			if (function_exists('apms_membership_order')) {
				apms_membership_order($row, $ct_status, $now);
			}
		} else {
			// 자동처리 아닌 상품
			$arr_no_auto[] = $row['it_id'];
		}

		// 가정산
		$account = apms_account($row);

		$sql = " update {$g5['g5_shop_cart_table']} 
					set pt_it = '{$it['pt_it']}'
					, pt_id = '{$it['pt_id']}'
					, pt_commission_rate = '{$row['pt_commission_rate']}'
					, pt_incentive_rate = '{$row['pt_incentive_rate']}'
					, pt_sale = '{$account['sale']}'
					, pt_commission = '{$account['commission']}'
					, pt_point = '{$account['point']}'
					, pt_incentive = '{$account['incentive']}'
					, pt_net = '{$account['net']}'
					$query 
					where od_id = '$od_id' and ct_id = '{$row['ct_id']}'
				";
		sql_query($sql);
	}

	// 판매량 일괄반영
	if(is_array($arr_it_id) && !empty($arr_it_id)) {
		$unq_it_id = array_unique($arr_it_id);
		foreach($unq_it_id as $it_id) {
			$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
			sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");
		}
	}

	// 주문서가 자동처리 상품으로 되어 있으면 주문서도 완료처리
	$is_sendcost = true;
	if($od_ok && is_array($arr_no_auto) && empty($arr_no_auto)) {
		$info = get_order_info($od_id);
		if($info && $info['od_misu'] == 0) {
			sql_query(" update {$g5['g5_shop_order_table']} set od_status = '완료' where od_id = '$od_id' ");
			$is_sendcost = false;
		}
	}

	// 개별배송비처리 - 무료가 아니고 기본배송비가 있는 경우만 체크
	if($is_sendcost) {
		$where_sql = (!empty($g5['apms_automation'])) ? " and pt_it not in (".implode(', ', $g5['apms_automation']).") " : "";
		$sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_select = '1' $where_sql group by it_id order by ct_id ";
		$result = sql_query($sql);
		for ($i=0; $row=mysql_fetch_array($result); $i++) {

			// 합계금액 계산
			$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
							SUM(ct_point * ct_qty) as point,
							SUM(ct_qty) as qty
						from {$g5['g5_shop_cart_table']}
						where it_id = '{$row['it_id']}'
						  and od_id = '$od_id' ";
			$sum = sql_fetch($sql);

			// 배송비
			$sc_price = 0;
			switch($row['ct_send_cost']) {
				case 1:
					$sc_type = '착불';
					break;
				case 2:
					$sc_type = '무료';
					break;
				default:
					$sc_type = '선불';
					$sc_price = $row['it_sc_price'];
					break;
			}

			// 조건부무료
			if($sc_price && $row['it_sc_type'] == 2) {
				$sc_price = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

				if($sc_price == 0)
					$sc_type = '무료';
			}

			// 개별배송비 등록
			sql_query(" insert into {$g5['apms_sendcost']} set od_id = '$od_id', it_id = '{$row['it_id']}', pt_id = '{$row['pt_id']}', sc_price = '$sc_price', sc_type = '$sc_type', sc_datetime = '".G5_TIME_YMDHIS."' ", false);
		}
	}

	return;
}

// Update Order
function apms_order_it($ct_id, $mb_id='') {
	global $g5;

	if(!$ct_id) return;

	$mb_sql = ($mb_id) ? " and mb_id = '$mb_id' " : '';

	// 장바구니에서 내역가져오기
	$row = sql_fetch("select * from {$g5['g5_shop_cart_table']} where ct_id = '$ct_id' and ct_status = '배송' and ct_select = '1' $mb_sql ", false);

	if(!$row['ct_id']) return;

	$od_id = $row['od_id'];
	$it_id = $row['it_id'];

	//상태변경
	$ct_status = '완료';
	$now = G5_TIME_YMDHIS;

	// 장바구니 업데이트
	$query = '';

	// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
	if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use']) {
		$po_point = $row['ct_point'] * $row['ct_qty'];
		$po_content = "주문번호 {$od_id} ({$row['it_id']} : {$row['ct_id']}) 결제완료";
		insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
		$query .= ", ct_point_use = '1'";
	}

	// 정산일 반영
	$query .= ", pt_datetime = '$now'";

	// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
	if(!$mb_id) $mb_id = 'automation';
	$ct_history="\n$ct_status|$mb_id|$now|";
	$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

	$sql = " update {$g5['g5_shop_cart_table']} 
				set ct_status = '$ct_status'
					$query 
					where od_id = '$od_id' and ct_id = '$ct_id'
				";
	sql_query($sql);

	// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
	if (function_exists('apms_membership_order')) {
		apms_membership_order($row, $ct_status, $now);
	}

	// 판매량 반영
	$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
	sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");

	// 개별배송비 반영
	sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '$now' where od_id = '$od_id' and it_id = '$it_id' ", false);

	return;
}

// Auto Account
function apms_account_auto($od_id, $ct_id, $od_status) {
	global $g5;

	if(!$od_id || !$ct_id) return;

	$row = sql_fetch("select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_id = '$ct_id' ", false);

	$query = '';
	if($od_status == '완료') {
		if(in_array($row['pt_it'], $g5['apms_automation']) && $row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use']) { 
			$po_point = $row['ct_point'] * $row['ct_qty'];
			$po_content = "주문번호 {$od_id} ({$row['it_id']} : {$ct_id}) 결제완료";
			insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$ct_id}");
			$query .= ", ct_point_use = '1'";
		}
		$query .= ", pt_datetime = '".G5_TIME_YMDHIS."'";
	} else if($od_status == '배송') { //배송일 때는 배송일괄처리를 위해 정산일만 업데이트함
		$query .= ", pt_datetime = '".G5_TIME_YMDHIS."'";
	}

	// 가정산
	$account = apms_account($row);

	$sql = " update {$g5['g5_shop_cart_table']} 
				set pt_sale = '{$account['sale']}'
					, pt_commission = '{$account['commission']}'
					, pt_point = '{$account['point']}'
					, pt_incentive = '{$account['incentive']}'
					, pt_net = '{$account['net']}'
					$query 
				where od_id = '$od_id' and ct_id = '{$ct_id}'
			";
	sql_query($sql);

	// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
	if (function_exists('apms_membership_order')) {
		apms_membership_order($row, $od_status, G5_TIME_YMDHIS);
	}

	// 개별배송비
	if($row['ct_send_cost'] != "2" && $row['it_sc_price'] > 0) {
		if($od_status == '완료') {
			sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '".G5_TIME_YMDHIS."' where od_id = '$od_id' and it_id = '{$row['it_id']}'", false);
		} else {
			$row1 = sql_fetch("select ct_id from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and it_id = '{$row['it_id']}' and ct_status = '완료' ", false);
			if($row1['ct_id']) { //완료상품이 있으면
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '".G5_TIME_YMDHIS."' where od_id = '$od_id' and it_id = '{$row['it_id']}' ", false);
			} else {
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '0', pt_datetime = '' where od_id = '$od_id' and it_id = '{$row['it_id']}' ", false);
			}
		}
	}

	return;
}

// Partner Info
function apms_partner($mb_id, $fields='*') {
	global $g5;

	if(!$mb_id) return;

	$row = sql_fetch(" select $fields from {$g5['apms_partner']} where pt_id = TRIM('$mb_id') ", false);

	return $row;
}

// Get File
function apms_get_file($dir, $pf_id) {
    global $g5;

	if(!$pf_id) return;

	//파일타입 설정
	switch($dir) {
		case 'item'		: $pf_dir = 1; $dir = 'item'; $pf_url = G5_SHOP_URL; $pf_path = G5_DATA_URL.'/item/'.$pf_id; break;
		case 'partner'	: $pf_dir = 2; $dir = 'partner'; $pf_url = G5_ADMIN_URL.'/apms_admin'; $pf_path = G5_DATA_URL.'/apms/'.$dir; break;
		default			: return;
	}

	$file['count'] = 0;
	$file['torrent'] = 0;
    $sql = " select * from {$g5['apms_file']} where pf_id = '$pf_id' and pf_dir = '$pf_dir' order by pf_no ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        $no = $row['pf_no'];
        $file[$no]['id'] = $pf_id;
		$file[$no]['href'] = $pf_url."/download.php?pf_id=$pf_id&amp;pf=$pf_dir&amp;no=$no";
        $file[$no]['href_view'] = $pf_url."/view.php?pf_id=$pf_id&amp;pf=$pf_dir&amp;no=$no";
		$file[$no]['path'] = $pf_path;
		$file[$no]['guest_use'] = $row['pf_guest_use'];
		$file[$no]['purchase_use'] = $row['pf_purchase_use'];
		$file[$no]['download'] = $row['pf_download'];
		$file[$no]['download_use'] = $row['pf_download_use'];
		$file[$no]['view'] = $row['pf_view'];
		$file[$no]['view_use'] = $row['pf_view_use'];
        $file[$no]['size'] = get_filesize($row['pf_filesize']);
        $file[$no]['datetime'] = $row['pf_datetime'];
        $file[$no]['source'] = addslashes($row['pf_source']);
        $file[$no]['file'] = $row['pf_file'];
        $file[$no]['image_width'] = $row['pf_width'] ? $row['pf_width'] : 640;
        $file[$no]['image_height'] = $row['pf_height'] ? $row['pf_height'] : 480;
        $file[$no]['image_type'] = $row['pf_type'];
		$file[$no]['ext'] = $row['pf_ext'];
		if($row['pf_ext'] == "6") $file['torrent']++;
		$file['count']++;
    }

    return $file;
}

// Delete File
function apms_delete_file($dir, $pf_id) {
	global $g5;

	if(!$pf_id) return;

	//파일타입 설정
	switch($dir) {
		case 'item'		: $pf_dir = 1; $pf_file = G5_DATA_PATH.'/item/'.$pf_id; break;
		case 'partner'	: $pf_dir = 2; $pf_file = G5_DATA_PATH.'/apms/'.$dir; break;
		default			: return;
	}

	// 업로드된 파일이 있다면
	$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' ");
	while ($row = sql_fetch_array($result)) {
		// 파일 삭제
		@unlink($pf_file.'/'.$row['pf_file']);
	}

	// 파일테이블 행 삭제
	sql_query(" delete from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' ");
}

// 아이템 관련글 썸네일 생성
function apms_it_write_thumbnail($it_id, $wr_content, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config;

	$filename = $alt = "";
	$matches = get_editor_image($wr_content, false);
	$edt = true;

	$limg = array();
	$lalt = array();
	for($i=0; $i<count($matches[1]); $i++) {
		// 이미지 path 구함
		$p = parse_url($matches[1][$i]);
		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
			$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else
			$data_path = $p['path'];

		$srcfile = G5_PATH.$data_path;

		//if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile)) {
			if(is_file($srcfile)) {
				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

				$filename = basename($srcfile);
				$filepath = dirname($srcfile);

				preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
				$alt = get_text($malt[1]);

				break;
			} else {
				$limg[] = $matches[1][$i];
				preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
				$lalt[] = get_text($malt[1]);
			}
		//}
	}
	
	if(!$filename) { //본문동영상 이미지 체크
		if(preg_match_all("/{동영상\:([^}]*)}/ie", $it['it_explan'], $match)) {
			$match_cnt = count($match[1]);
			for ($i=0; $i < $match_cnt; $i++) {
				$video = apms_video_info(trim(strip_tags($match[1][$i])));

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

				$filename = basename($srcfile);
				$filepath = dirname($srcfile);							
				$data_path = str_replace(G5_PATH, '', $srcfile);

				break;
			}
		}
	}

	if(!$filename) { //그래도 이미지가 없으면 상품이미지에서 찾음
		$edt = false;
		$it = apms_it($it_id);
		for($i=1; $i<=10; $i++) {
			$it_img = $it['it_img'.$i];
			$file = G5_DATA_PATH.'/item/'.$it_img;
			if(!is_file($file))
				continue;

			$size = @getimagesize($file);
			if($size[2] < 1 || $size[2] > 3)
				continue;

			$filename = basename($file);
			$filepath = dirname($file);
			$alt = get_text($it['it_name']);

			break;
		}
	}

	if(!$filename) { //그래도 이미지가 없으면 상품이미지에서 찾음
		$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '{$it['it_id']}' and pf_dir = '1' and pf_ext = '1' and pf_purchase_use <> '1' and pf_view_use = '1' order by pf_no ", false);
		while ($row = sql_fetch_array($result)) {
			$file = G5_DATA_PATH.'/item/'.$it['it_id'].'/'.$row['pf_file'];
			if(!is_file($file))
				continue;

			$size = @getimagesize($file);
			if($size[2] < 1 || $size[2] > 3)
				continue;

			$filename = basename($file);
			$filepath = dirname($file);
			$alt = get_text($it['it_name']);

			break;
		}
	}

	if(!$filename) { // 링크동영상 체크
		for($i=1; $i < 3; $i++) {
			if($it['pt_link'.$i]) {

				list($link_video) = explode("|", $it['pt_link'.$i]);

				$video = apms_video_info($link_video);

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

				$edt = true;
				$filename = basename($srcfile);
				$filepath = dirname($srcfile);							
				$data_path = str_replace(G5_PATH, '', $srcfile);

				break;
			}
		}
	}

	if(!$filename) { //링크 이미지
		if(count($limg) > 0) {
			$thumb = array("is_thumb"=>false, "src"=>$limg[0], "alt"=>$lalt[0]);
			return $thumb;
		}
	}

    if(!$filename)
        return false;

    $tname = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

    if($tname) {
        if($edt) {
            $src = G5_URL.str_replace($filename, $tname, $data_path);
        } else {
            $src = G5_DATA_URL.'/item/'.$it['it_id'].'/'.$tname;
        }
    } else {
        return false;
    }

    $thumb = array("is_thumb"=>true, "src"=>$src, "alt"=>$alt);

    return $thumb;
}

function apms_explan_image($num) {
	global $it;

	$img = $it['it_img'.$num];
    $file = G5_DATA_PATH.'/item/'.$img;
    $imgurl = G5_DATA_URL.'/item/'.$img;
    if (file_exists($file) && $img != '') {
		$str = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode(str_replace(G5_URL, "", $imgurl)).'" target="_blank" class="item_image"><img src="'.$imgurl.'" alt=""></a>';
    } else {
		$str = '';
	}

	return $str;
}

//Show Contents
function apms_explan($explan, $filter=true) {
	global $it;

	if(!$explan) return;

	$explan = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "apms_explan_image('\\1')", $explan); //Image
	$explan = apms_content(conv_content($explan, 1, $filter));

	return $explan;
}

// 아이템 썸네일 생성
function apms_it_thumbnail($it, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config;

	$img = array();
	$limg = array();
	$lalt = array();
	$rows = ($it['img_rows'] > 1) ? $it['img_rows'] : 1;
	$is_thumb_no = $it['is_thumb_no'];
	$no_img = $it['no_img'];

	$z = 0;
	for($i=1; $i<=10; $i++) {
        $it_img = $it['it_img'.$i];
        $file = G5_DATA_PATH.'/item/'.$it_img;
        if(!is_file($file))
            continue;

        $size = @getimagesize($file);
        if($size[2] < 1 || $size[2] > 3)
            continue;

	    $img[$z]['edit'] = false;
	    $img[$z]['is_thumb'] = true;
		$img[$z]['filename'] = basename($file);
	    $img[$z]['filepath'] = dirname($file);
        $img[$z]['alt'] = get_text($it['it_name']);
		$img[$z]['img'] = G5_DATA_URL.'/item/'.$it_img;
		
		$z++;
		if($z == $rows) break;
    }

	if($z != $rows) {
		$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '{$it['it_id']}' and pf_dir = '1' and pf_ext = '1' and pf_purchase_use <> '1' and pf_view_use = '1' order by pf_no ", false);
		while ($row = sql_fetch_array($result)) {
	        $file = G5_DATA_PATH.'/item/'.$it['it_id'].'/'.$row['pf_file'];
			if(!is_file($file))
				continue;

			$size = @getimagesize($file);
			if($size[2] < 1 || $size[2] > 3)
				continue;

		    $img[$z]['edit'] = false;
		    $img[$z]['is_thumb'] = true;
			$img[$z]['filename'] = basename($file);
		    $img[$z]['filepath'] = dirname($file);
	        $img[$z]['alt'] = get_text($it['it_name']);
			$img[$z]['img'] = G5_DATA_URL.'/item/'.$it['it_id'].'/'.$row['pf_file'];
		
			$z++;
			if($z == $rows) break;
		}
	}

	if($z != $rows) { //첨부이미지 체크
		$wr_content = $it['it_explan'];
		$matches = get_editor_image($wr_content, false);

		for($i=0; $i<count($matches[1]); $i++) {
			// 이미지 path 구함
			$p = parse_url($matches[1][$i]);
			if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
				$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
			else
				$data_path = $p['path'];

			$srcfile = G5_PATH.$data_path;

			//if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile)) {
				if(is_file($srcfile)) {
					$size = @getimagesize($srcfile);
					if(empty($size)) {
						continue;
					}

				    $img[$z]['edit'] = true;
				    $img[$z]['is_thumb'] = true;
					$img[$z]['filename'] = basename($srcfile);
				    $img[$z]['filepath'] = dirname($srcfile);
				    $img[$z]['datapath'] = $data_path;
				    $img[$z]['img'] = $matches[1][$i];

					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
			        $img[$z]['alt'] = get_text($malt[1]);

					$z++;
					if($z == $rows) break;

				} else {
					$limg[] = $matches[1][$i];
					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
					$lalt[] = get_text($malt[1]);
				}
			//}
		}
	}

	if($z != $rows) { // 링크동영상 체크
		for($i=1; $i < 3; $i++) {
			if($it['pt_link'.$i]) {

				list($link_video) = explode("|", $it['pt_link'.$i]);

				$video = apms_video_info($link_video);

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

			    $img[$z]['edit'] = true;
			    $img[$z]['is_thumb'] = true;
			    $img[$z]['filename'] = basename($srcfile);
			    $img[$z]['filepath'] = dirname($srcfile);
			    $img[$z]['datapath'] = str_replace(G5_PATH, '', $srcfile);
			    $img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

				$z++;
				if($z == $rows) break;
			}
		}
	}

	if($z != $rows) { //본문동영상 이미지 체크
		if(preg_match_all("/{동영상\:([^}]*)}/ie", $it['it_explan'], $match)) {
			$match_cnt = count($match[1]);
			for ($i=0; $i < $match_cnt; $i++) {
				$video = apms_video_info(trim(strip_tags($match[1][$i])));

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

			    $img[$z]['edit'] = true;
			    $img[$z]['is_thumb'] = true;
			    $img[$z]['filename'] = basename($srcfile);
			    $img[$z]['filepath'] = dirname($srcfile);
			    $img[$z]['datapath'] = str_replace(G5_PATH, '', $srcfile);
			    $img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

				$z++;
				if($z == $rows) break;
			}
		}
	}

	if($z != $rows) { //링크 이미지
		for($i=0; $i < count($limg); $i++) {
		    $img[$z]['edit'] = true;
		    $img[$z]['is_thumb'] = false;
			$img[$z]['img'] = $limg[$i];
	        $img[$z]['alt'] = $lalt[$i];

			$z++;
			if($z == $rows) break;
		}
	}

    if($z == 0) {
		if($no_img) {
		    $img[$z]['edit'] = false;
		    $img[$z]['is_thumb'] = true;
			$img[$z]['img'] = $no_img;
	        $img[$z]['alt'] = '';
		} else {
			return;
		}
	}

	// 썸네일
	$tmp = array();
	$j = 0;
	for($i = 0; $i < count($img); $i++) {
		if($img[$i]['is_thumb'] && $thumb_width > 0 && !$is_thumb_no) {

			$tmpimg = apms_thumbnail($img[$i]['img'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

			if(!$tmpimg['src']) continue;

			$tmp[$j]['is_thumb'] = true;
            $tmp[$j]['src'] = $tmpimg['src'];
            $tmp[$j]['height'] = $tmpimg['height'];
		} else {
			$tmp[$j]['is_thumb'] = false;
            $tmp[$j]['src'] = $img[$i]['img'];
		}

		$tmp[$j]['alt'] = $img[$i]['alt'];
		$j++;
	}

	if($j == 0)
		return;

	$thumb = array();
	$thumb = ($rows > 1) ? $tmp : $tmp[0];

    return $thumb;
}

//----------------------------------------------------------------//
// 태마 관련 함수들
//----------------------------------------------------------------//

// Category Auth
function apms_ca_thema($ca_id, $ca, $opt='') {
	global $g5, $is_admin;

	if(!$ca_id) return;

	$at = array();

	if($opt) {
		$ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	}

	if($is_admin != 'super') {

		if($ca['as_partner'] && !IS_PARTNER) {
			alert("파트너만 이용가능합니다.", G5_URL);
		}

		apms_auth($ca['as_grade'], $ca['as_equal'], $ca['as_min'], $ca['as_max']);
	}

	$title = $ca['as_title'];
	$desc = $ca['as_desc'];
	$list = $ca['ca_'.MOBILE_.'skin'];
	$item = $ca['ca_'.MOBILE_.'skin_dir'];

	$ca_code = substr($ca_id,0,2);
	if($ca_id != $ca_code) {
		$sql = "ca_name, as_thema, as_color, as_mobile_thema, as_mobile_color, as_wide, as_multi, ca_img_width, ca_mobile_img_width, ca_img_height, ca_mobile_img_height, ca_list_mod, ca_mobile_list_mod, ca_list_row";
		$ca = sql_fetch(" select $sql from {$g5['g5_shop_category_table']} where ca_id = '{$ca_code}' ", false);
	} 

	$at = $ca;
	$at['group'] = false;
	$at['id'] = $ca_code;
	$at['title'] = $title;
	$at['desc'] = $desc;
	$at['name'] = $ca['ca_name'];
	$at['wide'] = $ca['as_wide'];
	$at['multi'] = $ca['as_multi'];
	$at['thema'] = $ca['as_'.MOBILE_.'thema'];
	$at['colorset'] = $ca['as_'.MOBILE_.'color'];
	$at['list'] = $list;
	$at['item'] = $item;
	$at['img_width'] = $ca['ca_'.MOBILE_.'img_width'];
	$at['img_height'] = $ca['ca_'.MOBILE_.'img_height'];
	$at['list_mods'] = $ca['ca_'.MOBILE_.'list_mod'];
	$at['list_rows'] = $ca['ca_'.MOBILE_.'list_row'];

	return $at;
}

//Get Thema Widget Item List
function thema_widget_item_list($type, $ca_id, $it, $new=24, $thumb_width=0, $thumb_height=0, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config, $is_admin;

	// 배열전체를 복사
	$list = $it;
	unset($it);

	$list['href'] = G5_SHOP_URL.'/item.php?it_id='.$list['it_id'];
	if($ca_id) $list['href'] .= '&amp;ca_id='.$ca_id;

	if($type == "item") {
		$mb_id = ($list['pt_id']) ? $list['pt_id'] : $config['cf_admin'];
		$list['new'] = ($list['pt_num'] >= (G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['date'] = $list['pt_num'];
		$list['photo'] = apms_photo_url($mb_id); //회원사진
		$list['content'] = $list['it_explan'];
        $list['category'] = $list['ca_name'];
        $list['hit'] = $list['it_hit'];
        $list['good'] = $list['pt_good'];
        $list['nogood'] = $list['pt_nogood'];
		if($thumb_width > 0) $list['img'] = apms_it_thumbnail($list, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

	} else if($type == "itemcomment") {
		$list['reply_name'] = ($list['wr_comment_reply'] && $list['wr_re_name']) ? $list['wr_re_name'] : '';
		$list['new'] = ($list['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['wr_name'];
		$list['date'] = strtotime($list['wr_datetime']);
		$list['secret'] = (strstr($list['wr_option'], "secret")) ? true : false;
		if($list['secret']) {
			$list['subject'] = $list['wr_subject'] = $list['wr_content'] = '비밀댓글입니다.';
		} else {
			$list['subject'] = apms_cut_text($list['wr_content'], 60);
		}
		$list['content'] = $list['wr_content'];
		$list['wr_content'] = '';
		if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['wr_content'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
		$list['href'] .= '#icv';

	} else if($type == "itemqa") {
		$list['new'] = ($list['iq_time'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['iq_name'];
		$list['date'] = strtotime($list['iq_time']);
		$list['secret'] = ($list['iq_secret']) ? true : false;
		if($list['secret']) {
			$list['subject'] = $list['iq_subject'] = $list['iq_question'] = '비밀글로 보호된 문의입니다.';
			if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['iq_question'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
		} else {
			$list['subject'] = $list['iq_subject'];
		}
		$list['content'] = $list['iq_question'];
		$list['iq_question'] = '';
		$list['answer'] = ($list['iq_answer']) ? true : false;
		$list['href'] .= '#iqv';

	} else if($type == "itemuse") {
		$list['new'] = ($list['is_time'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['is_name'];
		$list['date'] = strtotime($list['is_time']);
		$list['subject'] = $list['is_subject'];
		$list['content'] = $list['is_content'];
		$list['is_content'] = '';
		$list['star'] = apms_get_star($list['is_score']);
		if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['is_content'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
		$list['href'] .= '#iuv';
	}

    return $list;
}

// 신상품 목록
function apms_chk_new_item($s='') {
	global $g5;

	if($g5['cache_newpost_time'] > 0) {
		$chk_date = G5_SERVER_TIME - ($g5['cache_newpost_time'] * 3600);
		$new = "(it_type3 = '1' or pt_num >= '$chk_date')";
	} else {
		$new = "it_type3 = '1'";
	}

	$ca = array();
	$arr = array();
	$list = array();

	//신상품 및 신규 등록 자료 체크
	$field = array("ca_id", "ca_id2", "ca_id3");
	for($j = 0; $j < 3; $j++) {
	    $result = sql_query(" select distinct {$field[$j]} from {$g5['g5_shop_item_table']} where it_use = '1' and ca_id <> '' and $new", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$ca = substr($row['ca_id'],0,2);
			if($ca) array_push($arr, $ca);

			$ca = substr($row['ca_id'],0,4);
			if($ca)	array_push($arr, $ca);

			$ca = substr($row['ca_id'],0,6);
			if($ca)	array_push($arr, $ca);
		}
	}

	if(count($arr) > 0) {
		$arr = array_unique($arr);
		$arr = implode("|",$arr);
		$arr = explode("|",$arr);
		$arr_cnt = count($arr);
		for($i = 0; $i < $arr_cnt; $i++) {
			$key = $arr[$i];
			$list[$key] = true;
		}
	} 

	return $list;
}

//----------------------------------------------------------------//
// 추출 관련 함수들
//----------------------------------------------------------------//

// 장바구니
function apms_cart_rows($arr) {
	global $g5;

	$list = array();

	// 정리
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;

	$sql  = " select it_id, it_name from {$g5['g5_shop_cart_table']} where od_id = '".get_session('ss_cart_id')."' group by it_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;
		$list[$i]['href'] = G5_SHOP_URL.'/cart.php';
		$list[$i]['alt'] = get_text($row['it_name']);
		$img = apms_it_thumbnail(apms_it($row['it_id']), $thumb_w, $thumb_h, false, true);
		if(!$img['src'] && $arr['no_img']) {
			$img = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
		}
		$list[$i]['img'] = $img['src'];
	}

	return $list;
}

// 아이템 기준 - 등록일
function apms_item_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and it_type{$type} = '1'" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(pt_id, '{$ex_pt}')=0" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (ca_id not like '$ex_ca%' and ca_id2 not like '$ex_ca%' and ca_id3 not like '$ex_ca%')" : "";

	// 정렬
	switch($arr['sort']) { 
		case 'qty'			: $orderby = 'it_sum_qty desc'; break;
		case 'use'			: $orderby = 'it_use_cnt desc'; break;
		case 'hit'			: $orderby = 'it_hit desc'; break;
		case 'comment'		: $orderby = 'pt_comment desc'; break;
		case 'good'			: $orderby = 'pt_good desc'; break;
		case 'nogood'		: $orderby = 'pt_nogood desc'; break;
		case 'like'			: $orderby = '(pt_good - pt_nogood) desc'; break;
		case 'rdm'			: $orderby = 'rand()'; $page = 1; break;
		default				: $orderby = 'it_order, pt_num desc'; break;
	}

	// 기간(일수,today,yesterday,month,prev)
	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'it_datetime'); 

	$sql_common = "from {$g5['g5_shop_item_table']} where it_use = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term";
	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select *  $sql_common order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $new, $thumb_w, $thumb_h, false, true);
		if($thumb_w) {
			if(empty($list[$i]['img']) && $arr['no_img']) {
				$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
			}
		}
	}

	return $list;
}

// 파트너 기준 - 아이템 등록일
function apms_item_partner_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and it_type{$type} = '1'" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(pt_id, '{$ex_pt}')=0" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (ca_id not like '$ex_ca%' and ca_id2 not like '$ex_ca%' and ca_id3 not like '$ex_ca%')" : "";

	// 정렬
	switch($arr['sort']) { 
		case 'cnt'			: $orderby = 'cnt desc'; break;
		case 'use'			: $orderby = 'use desc'; break;
		case 'hit'			: $orderby = 'hit desc'; break;
		case 'comment'		: $orderby = 'comment desc'; break;
		case 'good'			: $orderby = 'good desc'; break;
		case 'nogood'		: $orderby = 'nogood desc'; break;
		case 'like'			: $orderby = '(good - nogood) desc'; break;
		case 'rdm'			: $orderby = 'rand()'; $page = 1; break;
		default				: $orderby = 'qty desc'; break;
	}

	// 기간(일수,today,yesterday,month,prev)
	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'it_datetime'); 

	$sql_common = "from {$g5['g5_shop_item_table']} where it_use = '1' and pt_id <> '' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term";
	if($page > 1) {
		//$total = sql_query("select count(*) as cnt $sql_common ", false);
		//$total_count = @mysql_num_rows($total);
		$row = sql_fetch(" SELECT COUNT(DISTINCT `pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select pt_id, count(*) as cnt, sum(it_sum_qty) as qty, sum(it_use_cnt) as use, sum(it_hit) as hit, sum(pt_comment) as comment, sum(pt_good) as good, sum(pt_nogood) as nogood $sql_common group by pt_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = get_member($row['pt_id']);
		$list[$i]['photo'] = apms_photo_url($lsit[$i]['mb_id']);
		if(!$list[$i]['photo'] && $arr['no_photo']) {
			$list[$i]['photo'] = $arr['no_photo']; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage']);
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['qty'] = $row['qty'];
		$list[$i]['use'] = $row['use'];
		$list[$i]['hit'] = $row['hit'];
		$list[$i]['comment'] = $row['comment'];
		$list[$i]['good'] = $row['good'];
		$list[$i]['nogood'] = $row['nogood'];
	}

	return $list;
}

// 판매기준 - 판매일
function apms_sale_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($arr['sort']) { 
		case 'cnt'			: $orderby = 'cnt desc'; break;
		case 'qty'			: $orderby = 'qty desc'; break;
		default				: $orderby = 'sale desc'; break;
	}

	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'a.ct_select_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) 
					where b.it_use = '1' and a.ct_status = '완료' and a.ct_select = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		//$row = sql_query("select count(*) as cnt $sql_common ", false);
		//$total_count = @mysql_num_rows($row);
		$row = sql_fetch(" SELECT COUNT(DISTINCT `a.pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select b.*, count(*) as cnt, sum(a.pt_sale) as sale, sum(a.ct_qty) as qty $sql_common group by a.it_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $new, $thumb_w, $thumb_h, false, true);
		if($thumb_w) {
			if(empty($list[$i]['img']) && $arr['no_img']) {
				$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
			}
		}
	}
	return $list;
}

// 파트너 기준 - 판매일
function apms_sale_partner_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($arr['sort']) { 
		case 'cnt'			: $orderby = 'cnt desc'; break;
		case 'qty'			: $orderby = 'qty desc'; break;
		default				: $orderby = 'sale desc'; break;
	}

	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'a.ct_select_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) 
					where a.pt_id <> '' and b.it_use = '1' and a.ct_status = '완료' and a.ct_select = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		//$row = sql_query("select count(*) as cnt $sql_common ", false);
		//$total_count = @mysql_num_rows($row);

		$row = sql_fetch(" SELECT COUNT(DISTINCT `a.pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select a.pt_id, count(*) as cnt, sum(a.pt_sale) as sale, sum(a.ct_qty) as qty $sql_common group by a.pt_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = get_member($row['pt_id']);
		$list[$i]['photo'] = apms_photo_url($lsit[$i]['mb_id']);
		if(!$list[$i]['photo'] && $arr['no_photo']) {
			$list[$i]['photo'] = $arr['no_photo']; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage']);
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['sale'] = $row['sale'];
		$list[$i]['qty'] = $row['qty'];
	}
	return $list;
}

// 이벤트 기준 - 아이템
function apms_item_event_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$ev_id = apms_escape_string($arr['ev_id']);

	if(!$ev_id) return;

	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($arr['sort']) { 
		case 'qty'			: $orderby = 'b.it_sum_qty desc'; break;
		case 'use'			: $orderby = 'b.it_use_cnt desc'; break;
		case 'hit'			: $orderby = 'b.it_hit desc'; break;
		case 'comment'		: $orderby = 'b.pt_comment desc'; break;
		case 'good'			: $orderby = 'b.pt_good desc'; break;
		case 'nogood'		: $orderby = 'b.pt_nogood desc'; break;
		case 'like'			: $orderby = '(b.pt_good - b.pt_nogood) desc'; break;
		case 'rdm'			: $orderby = 'rand()'; $page = 1; break;
		default				: $orderby = 'b.it_order, b.pt_num desc'; break;
	}

	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'b.it_datetime'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) 
					where a.ev_id = '{$ev_id}' and b.it_use = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select * $sql_common order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $new, $thumb_w, $thumb_h, false, true);
		if($thumb_w) {
			if(empty($list[$i]['img']) && $arr['no_img']) {
				$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
			}
		}
	}

	return $list;
}

// 포스트 기준 - 아이템
function apms_item_post_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = apms_escape_string($arr['type']);
	$pt_list = apms_escape_string($arr['pt_list']);
	$ex_pt = apms_escape_string($arr['ex_pt']);
	$ca_id = apms_escape_string($arr['ca_id']);
	$ex_ca = apms_escape_string($arr['ex_ca']);
	$mode = ($arr['mode']) ? $arr['mode'] : 'comment';
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 5;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	$orderby = '';
	switch($arr['sort']) { 
		case 'qty'			: $orderby = 'b.it_sum_qty desc, '; break;
		case 'use'			: $orderby = 'b.it_use_cnt desc, '; break;
		case 'hit'			: $orderby = 'b.it_hit desc, '; break;
		case 'comment'		: $orderby = 'b.pt_comment desc, '; break;
		case 'good'			: $orderby = 'b.pt_good desc, '; break;
		case 'nogood'		: $orderby = 'b.pt_nogood desc, '; break;
		case 'like'			: $orderby = '(b.pt_good - b.pt_nogood) desc, '; break;
	}

	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'b.it_datetime'); // 기간(일수,today,yesterday,month,prev)

	if($mode == 'comment') {
		$orderby .= "a.wr_id desc";
		$sql_common = "from `{$g5['apms_comment']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where b.it_use = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else if($mode == 'use') {
		$orderby .= "a.is_id desc";
		$sql_common = "from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where a.is_confirm = '1' and b.it_use = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else if($mode == 'qa') {
		$orderby .= "a.iq_id desc";
		$sql_common = "from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where b.it_use = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else {
		return;
	}

	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select a.*, b.it_name $sql_common order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = thema_widget_item_list('item'.$mode, $ca_id, $row, $new, $thumb_w, $thumb_h, false, true);

		if(!$list[$i]['img']['src'] && $arr['no_img']) {
			$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
		}
	}

	return $list;
}

// 이벤트 배너
function apms_banner_event_rows($arr) {
	global $g5;

	$list = array();

	$ev_id = apms_escape_string($arr['ev_id']);
	$except = apms_escape_string($arr['except']);
	$type = apms_escape_string($arr['type']);

	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 8;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$banner = ($arr['banner']) ? 's' : 'm';

	// 이벤트
	if($ev_id) {
		$sql_ev = ($except) ? "and find_in_set(ev_id, '{$ev_id}')=0" : "and find_in_set(ev_id, '{$ev_id}')";
	} else {
		$sql_ev = '';
	}

	// 타입
	$sql_type = ($type) ? "and ev_type = '{$type}'" : "";

	// 정렬
	switch($arr['sort']) {
		case 'rdm'	: $orderby = 'rand()'; break;
		case 'asc'	: $orderby = 'ev_id'; break;
		default		: $orderby = 'ev_id desc'; break;
	}

	$sql = " select * from `{$g5['g5_shop_event_table']}` where ev_use = '1' $sql_ev $sql_ex_ev $sql_type order by $orderby limit 0, $rows ";
	$result = sql_query($sql, false);
	$j = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) { 

		if(!file_exists(G5_DATA_PATH.'/event/'.$row['ev_id'].'_'.$banner)) continue;

		$list[$j] = $row;
		$list[$j]['href'] = G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'];
		$list[$j]['subject'] = get_text($row['ev_subject']);
		$img = apms_thumbnail(G5_DATA_URL.'/event/'.$row['ev_id'].'_'.$banner, $thumb_w, $thumb_h, false, true);
		$list[$j]['img'] = $img['src'];
		$list[$j]['alt'] = $list[$j]['subject'];
		$j++;
	}

	return $list;
}

// 배너
function apms_banner_rows($arr) {
	global $g5;

	$list = array();

	$bn_list = apms_escape_string($arr['bn_list']);
	$except = apms_escape_string($arr['except']);
	$position = apms_escape_string($arr['loc']);

	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 4;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;

	// 배너
	if($bn_list) {
		$sql_bn = ($except) ? "and find_in_set(bn_id, '{$bn_list}')=0" : "and find_in_set(bn_id, '{$bn_list}')";
	} else {
		$sql_bn = '';
	}

	//위치
	$sql_loc = ($position) ? "and bn_position = '$position'" : "";

	// 정렬
	switch($arr['sort']) {
		case 'rdm'	: $orderby = 'rand()'; break;
		case 'asc'	: $orderby = 'bn_order desc, bn_id'; break;
		default		: $orderby = 'bn_order, bn_id desc'; break;
	}

	$sql = " select * from {$g5['g5_shop_banner_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time $sql_po $sql_bn order by $orderby ";
	$result = sql_query($sql);
	$j = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) { 

		if(!file_exists(G5_DATA_PATH.'/banner/'.$row['bn_id'])) continue;

		$list[$j] = $row;
		$img = apms_thumbnail(G5_DATA_URL.'/banner/'.$row['bn_id'], $thumb_w, $thumb_h, false, true);
		$list[$j]['img'] = $img['src'];
		$list[$j]['alt'] = $row['bn_alt'];
		$list[$j]['target'] = ($row['bn_new_win']) ? ' target="_blank"' : '';
        if ($row['bn_url'][0] == '#')
			$list[$j]['href'] = $row['bn_url'];
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
			$list[$j]['href'] = G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row['bn_url']);
        }
		$j++;
	}

	return $list;

}

// 분류명 리스트
function apms_shop_category_name($opt='') {
	global $g5;

	$list = array();
	$result = sql_query(" select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$c = $row['ca_id'];
		$list[$c] = $row['ca_name'];
	}

	return $list;

}

?>