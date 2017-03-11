<?php
include_once('./_common.php');

// Escrow Info
function apms_escrow_info(){
	global $default;

	ob_start();
	if(G5_IS_MOBILE) {
		require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');
	} else {
		require_once('./'.$default['de_pg_service'].'/orderform.4.php');
	}
	$escrow = ob_get_contents();
    ob_end_clean();

	$escrow = trim($escrow);

	return $escrow;
}

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// 주문상품 재고체크 js 파일
add_javascript('<script src="'.G5_JS_URL.'/shop.order.js"></script>', 0);

set_session("ss_direct", $sw_direct);

// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}

if (get_cart_count($tmp_cart_id) == 0)
    alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');

// Page ID
$pid = 'orderform';
$at = apms_page_thema($pid);

if(G5_IS_MOBILE) {
	define('APMS_PGCHECK_PATH', G5_MSHOP_PATH);
} else {
	define('APMS_PGCHECK_PATH', G5_SHOP_PATH);
}

$g5['title'] = '주문서 작성';

// 모바일이 아니고 전자결제를 사용할 때만 실행
if(!G5_IS_MOBILE) { 
	if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
		switch($default['de_pg_service']) {
			case 'lg':
				$g5['body_script'] = 'onload="isActiveXOK();"';
				break;
			default:
				$g5['body_script'] = 'onload="CheckPayplusInstall();"';
				break;
		}
	}
}

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);

$s_cart_id = $tmp_cart_id;
$action_url = G5_HTTPS_SHOP_URL.'/orderformupdate.php';

require_once(APMS_PGCHECK_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');

if(G5_IS_MOBILE) {
	// 결제등록 요청시 사용할 입금마감일
	$ipgm_date = date("Ymd", (G5_SERVER_TIME + 86400 * 5));
	$tablet_size = "1.0"; // 화면 사이즈 조정 - 기기화면에 맞게 수정(갤럭시탭,아이패드 - 1.85, 스마트폰 - 1.0)
}

// 상품처리 ----------------------
$tot_point = 0;
$tot_sell_price = 0;

$goods = $goods_it_id = "";
$goods_count = -1;

// $s_cart_id 로 현재 장바구니 자료 쿼리
$sql = " select a.ct_id,
				a.it_id,
				a.it_name,
				a.ct_price,
				a.ct_point,
				a.ct_qty,
				a.ct_status,
				a.ct_send_cost,
				a.it_sc_type,
				b.pt_it,
				b.ca_id,
				b.ca_id2,
				b.ca_id3,
				b.it_notax,
				b.pt_msg1,
				b.pt_msg2,
				b.pt_msg3
		   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
		  where a.od_id = '$s_cart_id'
			and a.ct_select = '1' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$good_info = '';
$it_send_cost = 0;
$it_cp_count = 0;

$comm_tax_mny = 0; // 과세금액
$comm_vat_mny = 0; // 부가세
$comm_free_mny = 0; // 면세금액
$tot_tax_mny = 0;

$item = array();
$arr_it_orderform = array();

for ($i=0; $row=mysql_fetch_array($result); $i++) {

	// APMS : 비회원은 컨텐츠상품 구매않되도록 처리
	if($is_guest && $row['pt_it'] == "2") {
		alert("회원만 구매가능한 아이템이 포함되어 있습니다.\\n\\n회원이시라면 로그인 후 진행해 주십시오.");
	}
	
	// 합계금액 계산
	$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_point * ct_qty) as point,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where it_id = '{$row['it_id']}'
				  and od_id = '$s_cart_id' ";
	$sum = sql_fetch($sql);

	if (!$goods) {
		//$goods = addslashes($row[it_name]);
		//$goods = get_text($row[it_name]);
		$goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
		$goods_it_id = $row['it_id'];
	}
	$goods_count++;

	// 에스크로 상품정보
	if($default['de_escrow_use']) {
		if ($i>0)
			$good_info .= chr(30);
		$good_info .= "seq=".($i+1).chr(31);
		$good_info .= "ordr_numb={$od_id}_".sprintf("%04d", $i).chr(31);
		$good_info .= "good_name=".addslashes($row['it_name']).chr(31);
		$good_info .= "good_cntx=".$row['ct_qty'].chr(31);
		$good_info .= "good_amtx=".$row['ct_price'].chr(31);
	}

	$it_name = stripslashes($row['it_name']);
	$it_options = print_item_options($row['it_id'], $s_cart_id, $row['pt_msg1'], $row['pt_msg2'], $row['pt_msg3']);

	// 복합과세금액
	if($default['de_tax_flag_use']) {
		if($row['it_notax']) {
			$comm_free_mny += $sum['price'];
		} else {
			$tot_tax_mny += $sum['price'];
		}
	}

	$point      = $sum['point'];
	$sell_price = $sum['price'];

	// 쿠폰
	$cp_button = false;
	if($is_member) {
		$cp_count = 0;

		$sql = " select cp_id
					from {$g5['g5_shop_coupon_table']}
					where mb_id IN ( '{$member['mb_id']}', '전체회원' )
					  and cp_start <= '".G5_TIME_YMD."'
					  and cp_end >= '".G5_TIME_YMD."'
					  and cp_minimum <= '$sell_price'
					  and (
							( cp_method = '0' and cp_target = '{$row['it_id']}' )
							OR
							( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
						  ) ";
		$res = sql_query($sql);

		for($k=0; $cp=sql_fetch_array($res); $k++) {
			if(is_used_coupon($member['mb_id'], $cp['cp_id']))
				continue;

			$cp_count++;
		}

		if($cp_count) {
			$cp_button = true;
			$it_cp_count++;
		}
	}

	// 배송비
	switch($row['ct_send_cost'])
	{
		case 1:
			$ct_send_cost = '착불';
			break;
		case 2:
			$ct_send_cost = '무료';
			break;
		default:
			$ct_send_cost = '선불';
			break;
	}

	// 조건부무료
	if($row['it_sc_type'] == 2) {
		$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

		if($sendcost == 0)
			$ct_send_cost = '무료';
	}

	// 배열화
	$item[$i] = $row;
	$item[$i]['hidden_it_id'] = $row['it_id'];
	$item[$i]['hidden_it_name'] = get_text($row['it_name']);
	$item[$i]['hidden_sell_price'] = $sell_price;
	$item[$i]['hidden_cp_id'] = '';
	$item[$i]['hidden_cp_price'] = 0;
	$item[$i]['hidden_it_notax'] = $row['it_notax'];
	$item[$i]['it_name'] = $it_name;
	$item[$i]['it_options'] = $it_options;
	$item[$i]['pt_it'] = apms_pt_it($row['pt_it'],1);
	$item[$i]['qty'] = number_format($sum['qty']);
	$item[$i]['ct_price'] = number_format($row['ct_price']);
	$item[$i]['is_coupon'] = $cp_button;
	$item[$i]['total_price'] = number_format($sell_price);
	$item[$i]['point'] = number_format($point);
	$item[$i]['ct_send_cost'] = $ct_send_cost;

	if(!in_array($row['pt_it'], $g5['apms_automation'])) {
		$arr_it_orderform[] = $row['it_id'];
	}

	$tot_point      += $point;
	$tot_sell_price += $sell_price;
} // for 끝

if ($i == 0) {
	alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');
} else {
	// 배송비 계산
	$send_cost = get_sendcost($s_cart_id);
}

// 복합과세처리
if($default['de_tax_flag_use']) {
	$comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
	$comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
}

// 자동처리 주문서인지 체크
$is_orderform = false;
if(is_array($arr_it_orderform) && !empty($arr_it_orderform)) {
	$is_orderform = true;
}

// 상품처리 끝 ----------------------
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('orderform.head.skin.php', '/shop/order');

include_once('./_head.php');

if ($default['de_hope_date_use']) {
    include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
}

if(G5_IS_MOBILE) {
	echo '<div id="sod_approval_frm">'."\n";
	ob_start();
	include_once($skin_path.'/orderform.item.skin.php');
	$content = ob_get_contents();
	ob_end_clean();
	// 결제대행사별 코드 include (스크립트 등)
	require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');
	echo '</div>'."\n";

	$form_submit_script = '';
} else {
	$form_submit_script = ' onsubmit="return forderform_check(this);" ';

	// 결제대행사별 코드 include (스크립트 등)
	require_once('./'.$default['de_pg_service'].'/orderform.1.php');
}

// 헤드 스킨
include_once($skin_path.'/orderform.head.skin.php');

// 상품 스킨
if(!G5_IS_MOBILE) include_once($skin_path.'/orderform.item.skin.php');

?>
	<input type="hidden" name="od_price"    value="<?php echo $tot_sell_price; ?>">
	<input type="hidden" name="org_od_price"    value="<?php echo $tot_sell_price; ?>">
	<input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
	<input type="hidden" name="od_send_cost2" value="0">
	<input type="hidden" name="item_coupon" value="0">
	<input type="hidden" name="od_coupon" value="0">
	<input type="hidden" name="od_send_coupon" value="0">

<?php

	if(G5_IS_MOBILE) {
		echo $content; //모바일 상품스킨
	} else {
		// 결제대행사별 코드 include (결제대행사 정보 필드)
		require_once('./'.$default['de_pg_service'].'/orderform.2.php');
	}

	//주문서 사용할 때
	$addr_sel = array();
	$addr_default = '';
	if($is_orderform) {
		$orderer_zip_href =	G5_BBS_URL.'/zip.php?frm_name=forderform&amp;frm_zip1=od_zip1&amp;frm_zip2=od_zip2&amp;frm_addr1=od_addr1&amp;frm_addr2=od_addr2&amp;frm_addr3=od_addr3&amp;frm_jibeon=od_addr_jibeon';
		$taker_zip_href = G5_BBS_URL.'/zip.php?frm_name=forderform&amp;frm_zip1=od_b_zip1&amp;frm_zip2=od_b_zip2&amp;frm_addr1=od_b_addr1&amp;frm_addr2=od_b_addr2&amp;frm_addr3=od_b_addr3&amp;frm_jibeon=od_b_addr_jibeon';

		if($is_member) {

			// 배송지 이력
			$sep = chr(30);

			// 기본배송지
			$sql = " select *
						from {$g5['g5_shop_order_address_table']}
						where mb_id = '{$member['mb_id']}'
						  and ad_default = '1' ";
			$row = sql_fetch($sql);
			if($row['ad_id']) {
				$addr_default = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
			}

			// 최근배송지
			$sql = " select *
						from {$g5['g5_shop_order_address_table']}
						where mb_id = '{$member['mb_id']}'
						  and ad_default = '0'
						order by ad_id desc
						limit 1 ";
			$result = sql_query($sql);
			for($i=0; $row=sql_fetch_array($result); $i++) {
				$addr_sel[$i]['addr'] = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
				$addr_sel[$i]['namme'] = ($row['ad_subject']) ? $row['ad_subject'] : $row['ad_name'];
			}
		} 
	}

	// 주문서 스킨
	include_once($skin_path.'/orderform.orderer.skin.php');

	// 쿠폰사용
	$oc_cnt = $sc_cnt = 0;
	if($is_member) {
		// 주문쿠폰
		$sql = " select cp_id
					from {$g5['g5_shop_coupon_table']}
					where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                      and cp_start <= '".G5_TIME_YMD."'
                      and cp_end >= '".G5_TIME_YMD."'
                      and cp_minimum <= '$tot_sell_price' ";
		$res = sql_query($sql);

		for($k=0; $cp=sql_fetch_array($res); $k++) {
			if(is_used_coupon($member['mb_id'], $cp['cp_id']))
				continue;

			$oc_cnt++;
		}

		if($send_cost > 0) {
			// 배송비쿠폰
			$sql = " select cp_id
						from {$g5['g5_shop_coupon_table']}
						where mb_id IN ( '{$member['mb_id']}', '전체회원' )
						  and cp_method = '3'
                          and cp_start <= '".G5_TIME_YMD."'
                          and cp_end >= '".G5_TIME_YMD."'
                          and cp_minimum <= '$tot_sell_price' ";
			$res = sql_query($sql);

			for($k=0; $cp=sql_fetch_array($res); $k++) {
				if(is_used_coupon($member['mb_id'], $cp['cp_id']))
					continue;

				$sc_cnt++;
			}
		}
	}

	// 결제방법
	$multi_settle == 0;
	$escrow_title = '';
	if ($default['de_escrow_use']) {
		$escrow_title = '에스크로 ';
	}

	// 무통장입금 사용
	$is_mu = false;
	if ($default['de_bank_use']) {
		$multi_settle++;
		$is_mu = true;
	}

	// 가상계좌 사용
	$is_vbank = false;
	if ($default['de_vbank_use']) {
		$multi_settle++;
		$is_vbank = true;
	}

	// 계좌이체 사용
	$is_iche = false;
	if ($default['de_iche_use']) {
		$multi_settle++;
		$is_iche = true;
	}

	// 휴대폰 사용
	$is_hp = false;
	if ($default['de_hp_use']) {
		$multi_settle++;
		$is_hp = true;
	}

	// 신용카드 사용
	$is_card = false;
	if ($default['de_card_use']) {
		$multi_settle++;
		$is_card = true;
	}

	$temp_point = 0;
	$is_point = false;
	if ($is_member && $config['cf_use_point']) { // 회원이면서 포인트사용이면

		// 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
		if ($member['mb_point'] >= $default['de_settle_min_point']) {
			$temp_point = (int)$default['de_settle_max_point'];

			if($temp_point > (int)$tot_sell_price)
				$temp_point = (int)$tot_sell_price;

			if($temp_point > (int)$member['mb_point'])
				$temp_point = (int)$member['mb_point'];

			$point_unit = (int)$default['de_settle_point_unit'];
			$temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);

			$multi_settle++;
			$is_point = true;
		}
	}

	$bank_account = '';
	if ($default['de_bank_use']) {
		// 은행계좌를 배열로 만든후
		$str = explode("\n", trim($default['de_bank_account']));
		for ($i=0; $i<count($str); $i++) {
			//$str[$i] = str_replace("\r", "", $str[$i]);
			$str[$i] = trim($str[$i]);
			$bank_account .= '<option value="'.$str[$i].'">'.$str[$i].'</option>'.PHP_EOL;
		}
	}

	$is_none = false;
	if ($multi_settle == 0) {
		$is_none = true;
	}

	// 결제정보 스킨
	include_once($skin_path.'/orderform.payment.skin.php');

	// 결제대행사별 코드 include (주문버튼)
	if(G5_IS_MOBILE) {
	    require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');
	} else {
		require_once('./'.$default['de_pg_service'].'/orderform.3.php');
	}

	$escrow_info = '';
	if ($default['de_escrow_use']) {
		// 결제대행사별 코드 include (에스크로 안내)
		$escrow_info = apms_escrow_info();
	}

	// 테일 스킨
	include_once($skin_path.'/orderform.tail.skin.php');
?>

<script>
<?php if(G5_IS_MOBILE) { ?>
	$(function() {
		$("#od_settle_bank").on("click", function() {
			$("[name=od_deposit_name]").val( $("[name=od_name]").val() );
			$("#settle_bank").show();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
			$("#show_req_btn").css("display", "none");
			$("#show_pay_btn").css("display", "inline");
		});

		$("#od_settle_point").on("click", function() {
			$("#settle_bank").hide();
			$("#sod_frm_pt").hide();
			$("#show_req_btn").css("display", "none");
			$("#show_pay_btn").css("display", "inline");
		});

		$("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp").bind("click", function() {
			$("#settle_bank").hide();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
			$("#show_req_btn").css("display", "inline");
			$("#show_pay_btn").css("display", "none");
		});
	});

	/* 결제방법에 따른 처리 후 결제등록요청 실행 */
	var settle_method = "";
	var temp_point = 0;

	function pay_approval()
	{
		// 재고체크
		var stock_msg = order_stock_check();
		if(stock_msg != "") {
			alert(stock_msg);
			return false;
		}

		var f = document.sm_form;
		var pf = document.forderform;

		// 필드체크
		if(!orderfield_check(pf))
			return false;

		// 금액체크
		if(!payment_check(pf))
			return false;

		// pg 결제 금액에서 포인트 금액 차감
		if(settle_method != "무통장" && settle_method != "포인트") {
			var od_price = parseInt(pf.od_price.value);
			var send_cost = parseInt(pf.od_send_cost.value);
			var send_cost2 = parseInt(pf.od_send_cost2.value);
			var send_coupon = parseInt(pf.od_send_coupon.value);
			f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
		}

		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.buyr_name.value = pf.od_name.value;
		f.buyr_mail.value = pf.od_email.value;
		f.buyr_tel1.value = pf.od_tel.value;
		f.buyr_tel2.value = pf.od_hp.value;
		f.rcvr_name.value = pf.od_b_name.value;
		f.rcvr_tel1.value = pf.od_b_tel.value;
		f.rcvr_tel2.value = pf.od_b_hp.value;
		f.rcvr_mail.value = pf.od_email.value;
		f.rcvr_zipx.value = pf.od_b_zip1.value + pf.od_b_zip2.value;
		f.rcvr_add1.value = pf.od_b_addr1.value;
		f.rcvr_add2.value = pf.od_b_addr2.value;
		f.settle_method.value = settle_method;
		<?php } else if($default['de_pg_service'] == 'lg') { ?>
		var pay_method = "";
		switch(settle_method) {
			case "계좌이체":
				pay_method = "SC0030";
				break;
			case "가상계좌":
				pay_method = "SC0040";
				break;
			case "휴대폰":
				pay_method = "SC0060";
				break;
			case "신용카드":
				pay_method = "SC0010";
				break;
		}
		f.LGD_CUSTOM_FIRSTPAY.value = pay_method;
		f.LGD_BUYER.value = pf.od_name.value;
		f.LGD_BUYEREMAIL.value = pf.od_email.value;
		f.LGD_BUYERPHONE.value = pf.od_hp.value;
		f.LGD_AMOUNT.value = f.good_mny.value;
		<?php if($default['de_tax_flag_use']) { ?>
		f.LGD_TAXFREEAMOUNT.value = pf.comm_free_mny.value;
		<?php } ?>
		<?php } ?>

		var new_win = window.open("about:blank", "tar_opener", "scrollbars=yes,resizable=yes");
		f.target = "tar_opener";

		f.submit();
	}

	function forderform_check()
	{
		var f = document.forderform;

		// 필드체크
		if(!orderfield_check(f))
			return false;

		// 금액체크
		if(!payment_check(f))
			return false;

		if(settle_method != "포인트" && settle_method != "무통장" && f.res_cd.value != "0000") {
			alert("결제등록요청 후 주문해 주십시오.");
			return false;
		}

		document.getElementById("display_pay_button").style.display = "none";
		document.getElementById("show_progress").style.display = "block";

		setTimeout(function() {
			f.submit();
		}, 300);
	}

	// 주문폼 필드체크
	function orderfield_check(f)
	{
		errmsg = "";
		errfld = "";
		var deffld = "";

		check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
		check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
		<?php if($is_orderform) { ?>
		if (typeof(f.od_pwd) != 'undefined')
		{
			clear_field(f.od_pwd);
			if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
				error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
		}
		check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오.");
		//check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
		check_field(f.od_zip1, "");
		check_field(f.od_zip2, "");

		clear_field(f.od_email);
		if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
			error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

		if (typeof(f.od_hope_date) != "undefined")
		{
			clear_field(f.od_hope_date);
			if (!f.od_hope_date.value)
				error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
		}

		check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
		check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
		check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
		//check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
		check_field(f.od_b_zip1, "");
		check_field(f.od_b_zip2, "");
		<?php } ?>
		var od_settle_bank = document.getElementById("od_settle_bank");
		if (od_settle_bank) {
			if (od_settle_bank.checked) {
				check_field(f.od_bank_account, "계좌번호를 선택하세요.");
				check_field(f.od_deposit_name, "입금자명을 입력하세요.");
			}
		}

		// 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
		f.od_send_cost.value = parseInt(f.od_send_cost.value);

		if (errmsg)
		{
			alert(errmsg);
			errfld.focus();
			return false;
		}

		var settle_case = document.getElementsByName("od_settle_case");
		var settle_check = false;
		for (i=0; i<settle_case.length; i++)
		{
			if (settle_case[i].checked)
			{
				settle_check = true;
				settle_method = settle_case[i].value;
				break;
			}
		}
		if (!settle_check)
		{
			alert("결제방식을 선택하십시오.");
			return false;
		}

		return true;
	}

	// 결제체크
	function payment_check(f)
	{
		var max_point = 0;
		var od_price = parseInt(f.od_price.value);
		var send_cost = parseInt(f.od_send_cost.value);
		var send_cost2 = parseInt(f.od_send_cost2.value);
		var send_coupon = parseInt(f.od_send_coupon.value);

		if (typeof(f.max_temp_point) != "undefined")
			var max_point  = parseInt(f.max_temp_point.value);

		if (typeof(f.od_temp_point) != "undefined") {
			if (f.od_temp_point.value)
			{
				var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
				temp_point = parseInt(f.od_temp_point.value);

				if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
					alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
					f.od_temp_point.select();
					return false;
				}

				if (document.getElementById("od_settle_point") && document.getElementById("od_settle_point").checked) {
					;
				} else {
					if (temp_point < 0) {
						alert("포인트를 0 이상 입력하세요.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > od_price) {
						alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > max_point) {
						alert(max_point + "점 이상 결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
						alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
						f.od_temp_point.select();
						return false;
					}
				}
			}
		}

		if (document.getElementById("od_settle_point")) {
			if (document.getElementById("od_settle_point").checked) {
				var tmp_point = parseInt(f.od_temp_point.value);

				if (tmp_point > 0) {
					;
				} else {
					alert("포인트를 입력해 주세요.");
					f.od_temp_point.select();
					return false;
				}

				var tot_point = od_price + send_cost + send_cost2 - send_coupon;

				if (tot_point != tmp_point) {
					alert("결제하실 금액과 포인트가 일치하지 않습니다.");
					f.od_temp_point.select();
					return false;
				}
			}
		}

		var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

		if (document.getElementById("od_settle_iche")) {
			if (document.getElementById("od_settle_iche").checked) {
				if (tot_price - temp_point < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_card")) {
			if (document.getElementById("od_settle_card").checked) {
				if (tot_price - temp_point < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_hp")) {
			if (document.getElementById("od_settle_hp").checked) {
				if (tot_price - temp_point < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		<?php if($default['de_tax_flag_use']) { ?>
		calculate_tax();
		<?php } ?>

		return true;
	}
<?php } else { ?>
	$(function() {
		$("#od_settle_bank").on("click", function() {
			$("[name=od_deposit_name]").val( $("[name=od_name]").val() );
			$("#settle_bank").show();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
		});

		$("#od_settle_point").on("click", function() {
			$("#settle_bank").hide();
			$("#sod_frm_pt").hide();
		});

		$("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp").bind("click", function() {
			$("#settle_bank").hide();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
		});
	});

	function forderform_check(f) {

		// 재고체크
		var stock_msg = order_stock_check();
		if(stock_msg != "") {
			alert(stock_msg);
			return false;
		}
		
		errmsg = "";
		errfld = "";
		var deffld = "";

		check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
		check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
		<?php if($is_orderform) { ?>
			if (typeof(f.od_pwd) != 'undefined')
			{
				clear_field(f.od_pwd);
				if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
					error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
			}
			check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오.");
			//check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
			check_field(f.od_zip1, "");
			check_field(f.od_zip2, "");

			clear_field(f.od_email);
			if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
				error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

			if (typeof(f.od_hope_date) != "undefined")
			{
				clear_field(f.od_hope_date);
				if (!f.od_hope_date.value)
					error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
			}

			check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
			check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
			check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
			//check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
			check_field(f.od_b_zip1, "");
			check_field(f.od_b_zip2, "");
		<?php } ?>
		var od_settle_bank = document.getElementById("od_settle_bank");
		if (od_settle_bank) {
			if (od_settle_bank.checked) {
				check_field(f.od_bank_account, "계좌번호를 선택하세요.");
				check_field(f.od_deposit_name, "입금자명을 입력하세요.");
			}
		}

		// 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
		f.od_send_cost.value = parseInt(f.od_send_cost.value);

		if (errmsg) {
			alert(errmsg);
			errfld.focus();
			return false;
		}

		var settle_case = document.getElementsByName("od_settle_case");
		var settle_check = false;
		var settle_method = "";
		for (i=0; i<settle_case.length; i++) {
			if (settle_case[i].checked) {
				settle_check = true;
				settle_method = settle_case[i].value;
				break;
			}
		}
		if (!settle_check) {
			alert("결제방식을 선택하십시오.");
			return false;
		}

		var od_price = parseInt(f.od_price.value);
		var send_cost = parseInt(f.od_send_cost.value);
		var send_cost2 = parseInt(f.od_send_cost2.value);
		var send_coupon = parseInt(f.od_send_coupon.value);

		var max_point = 0;
		if (typeof(f.max_temp_point) != "undefined")
			max_point  = parseInt(f.max_temp_point.value);

		var temp_point = 0;
		if (typeof(f.od_temp_point) != "undefined") {
			if (f.od_temp_point.value) {
				var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
				temp_point = parseInt(f.od_temp_point.value);

				if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
					alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
					f.od_temp_point.select();
					return false;
				}

				if (settle_method == "포인트") {
					;
				} else {
					if (temp_point < 0) {
						alert("포인트를 0 이상 입력하세요.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > od_price) {
						alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > max_point) {
						alert(max_point + "점 이상 결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
						alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
						f.od_temp_point.select();
						return false;
					}
				}

				// pg 결제 금액에서 포인트 금액 차감
				if(settle_method != "무통장" && settle_method != "포인트") {
					f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
				}
			}
		}

		if (document.getElementById("od_settle_point")) {
			if (document.getElementById("od_settle_point").checked) {
				var tmp_point = parseInt(f.od_temp_point.value);

				if (tmp_point > 0) {
					;
				} else {
					alert("포인트를 입력해 주세요.");
					f.od_temp_point.select();
					return false;
				}

				var tot_point = od_price + send_cost + send_cost2 - send_coupon;

				if (tot_point != tmp_point) {
					alert("결제하실 금액과 포인트가 일치하지 않습니다.");
					f.od_temp_point.select();
					return false;
				}
			}

		}

		var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

		if (document.getElementById("od_settle_iche")) {
			if (document.getElementById("od_settle_iche").checked) {
				if (tot_price < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_card")) {
			if (document.getElementById("od_settle_card").checked) {
				if (tot_price < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_hp")) {
			if (document.getElementById("od_settle_hp").checked) {
				if (tot_price < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		<?php if($default['de_tax_flag_use']) { ?>
		calculate_tax();
		<?php } ?>

		// pay_method 설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		switch(settle_method) {
			case "계좌이체":
				f.pay_method.value = "010000000000";
				break;
			case "가상계좌":
				f.pay_method.value = "001000000000";
				break;
			case "휴대폰":
				f.pay_method.value = "000010000000";
				break;
			case "신용카드":
				f.pay_method.value = "100000000000";
				break;
			case "포인트":
				f.pay_method.value = "포인트";
				break;
			default:
				f.pay_method.value = "무통장";
				break;
		}
		<?php } else if($default['de_pg_service'] == 'lg') { ?>
		switch(settle_method) {
			case "계좌이체":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
				break;
			case "가상계좌":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
				break;
			case "휴대폰":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
				break;
			case "신용카드":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
				break;
			case "포인트":
				f.LGD_CUSTOM_FIRSTPAY.value = "포인트";
				break;
			default:
				f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
				break;
		}
		<?php } ?>

		// 결제정보설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.buyr_name.value = f.od_name.value;
		f.buyr_mail.value = f.od_email.value;
		f.buyr_tel1.value = f.od_tel.value;
		f.buyr_tel2.value = f.od_hp.value;
		f.rcvr_name.value = f.od_b_name.value;
		f.rcvr_tel1.value = f.od_b_tel.value;
		f.rcvr_tel2.value = f.od_b_hp.value;
		f.rcvr_mail.value = f.od_email.value;
		f.rcvr_zipx.value = f.od_b_zip1.value + f.od_b_zip2.value;
		f.rcvr_add1.value = f.od_b_addr1.value;
		f.rcvr_add2.value = f.od_b_addr2.value;

		if(f.pay_method.value != "무통장" && f.pay_method.value != "포인트") {
			if(jsf__pay( f )) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
		<?php } if($default['de_pg_service'] == 'lg') { ?>
		f.LGD_BUYER.value = f.od_name.value;
		f.LGD_BUYEREMAIL.value = f.od_email.value;
		f.LGD_BUYERPHONE.value = f.od_hp.value;
		f.LGD_AMOUNT.value = f.good_mny.value;
		f.LGD_RECEIVER.value = f.od_b_name.value;
		f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
		<?php if($default['de_escrow_use']) { ?>
		f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip1.value + f.od_b_zip2.value;
		f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
		f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
		f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
		<?php } ?>
		<?php if($default['de_tax_flag_use']) { ?>
		f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
		<?php } ?>

		if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장" && f.LGD_CUSTOM_FIRSTPAY.value != "포인트") {
			  Pay_Request("<?php echo $od_id; ?>", f.LGD_AMOUNT.value, f.LGD_TIMESTAMP.value);
		} else {
			f.submit();
		}
		<?php } ?>
	}
<?php } ?>

<?php if ($default['de_hope_date_use']) { ?>
$(function(){
	$("#od_hope_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", minDate: "+<?php echo (int)$default['de_hope_date_after']; ?>d;", maxDate: "+<?php echo (int)$default['de_hope_date_after'] + 6; ?>d;" });
});
<?php } ?>
</script>

<?php
include_once('./_tail.php');

if(!G5_IS_MOBILE) {
	// 결제대행사별 코드 include (스크립트 실행)
	require_once('./'.$default['de_pg_service'].'/orderform.5.php');
}
?>