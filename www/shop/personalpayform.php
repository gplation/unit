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

$sql = " select * from {$g5['g5_shop_personalpay_table']} where pp_id = '$pp_id' and pp_use = '1' and pp_price > 0 ";
$pp = sql_fetch($sql);

if(!$pp['pp_id'])
    alert('개인결제 정보가 존재하지 않습니다.');

if($pp['pp_tno'])
    alert('이미 결제하신 개인결제 내역입니다.');


if(G5_IS_MOBILE) {
	define('APMS_PGCHECK_PATH', G5_MSHOP_PATH);
} else {
	define('APMS_PGCHECK_PATH', G5_SHOP_PATH);
}

if(!G5_IS_MOBILE) { 
	// 전자결제를 사용할 때만 실행
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

// Page ID
$pid = ($pid) ? $pid : 'ppayform';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}
list($skin_path, $skin_url) = apms_skin_path('ppayform.head.skin.php', '/shop/ppayform');

$g5['title'] = $pp['pp_name'].'님 개인결제';

include_once('./_head.php');

$action_url = G5_HTTPS_SHOP_URL.'/personalpayformupdate.php';

if(G5_IS_MOBILE) {
	require_once(G5_MSHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');

	// 결제등록 요청시 사용할 입금마감일
	$ipgm_date = date("Ymd", (G5_SERVER_TIME + 86400 * 5));
	$tablet_size = "1.0"; // 화면 사이즈 조정 - 기기화면에 맞게 수정(갤럭시탭,아이패드 - 1.85, 스마트폰 - 1.0)
}

// 개인결제 체크를 위한 hash
$hash_data = md5($pp['pp_id'].$pp['pp_price'].$pp['pp_time']);
set_session('ss_personalpay_id', $pp['pp_id']);
set_session('ss_personalpay_hash', $hash_data);

// 에스크로 상품정보
if($default['de_escrow_use']) {
    $good_info .= "seq=1".chr(31);
    $good_info .= "ordr_numb={$pp_id}_".sprintf("%04d", 1).chr(31);
    $good_info .= "good_name=".addslashes($pp['pp_name'].'님 개인결제').chr(31);
    $good_info .= "good_cntx=1".chr(31);
    $good_info .= "good_amtx=".$pp['pp_price'].chr(31);
}

// 주문폼과 공통 사용을 위해 추가
$od_id = $pp_id;
$tot_price = $pp['pp_price'];
$goods = $pp['pp_name'].'님 개인결제';

if(G5_IS_MOBILE) {
	echo '<div id="sod_approval_frm">'.PHP_EOL;
    // 결제대행사별 코드 include (결제등록 필드)
    require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');
	echo '</div>'.PHP_EOL;

	$form_submit_script = '';
} else {
	require_once('./settle_'.$default['de_pg_service'].'.inc.php');

	// 결제대행사별 코드 include (스크립트 등)
	require_once('./'.$default['de_pg_service'].'/orderform.1.php');
	
	$form_submit_script = ' onsubmit="return forderform_check(this);"';
}

include_once($skin_path.'/ppayform.head.skin.php');
?>
<input type="hidden" name="pp_id" value="<?php echo $pp['pp_id']; ?>">
<?php 
	// 결제대행사별 코드 include (결제대행사 정보 필드)
	if(!G5_IS_MOBILE) {
		require_once('./'.$default['de_pg_service'].'/orderform.2.php');
	}

	//결제방법
	$multi_settle == 0;
	$checked = '';

	$escrow_title = "";
	if ($default['de_escrow_use']) {
		$escrow_title = "에스크로 ";
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

	$is_none = false;
	if ($multi_settle == 0) {
		$is_none = true;
	}

	// 결제스킨
	include_once($skin_path.'/ppayform.skin.php');

	if(G5_IS_MOBILE) {
		// 결제대행사별 코드 include (결제대행사 정보 필드 및 주분버튼)
		require_once(APMS_PGCHECK_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');
	} else {
		// 결제대행사별 코드 include (주문버튼)
		require_once(APMS_PGCHECK_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');
	}

	$escrow_info = '';
	if ($default['de_escrow_use']) {
		// 결제대행사별 코드 include (에스크로 안내)
		$escrow_info = apms_escrow_info();
	}

	// 테일 스킨
	include_once($skin_path.'/ppayform.tail.skin.php');
?>

<script>
<?php if(G5_IS_MOBILE) { ?>
	/* 결제방법에 따른 처리 후 결제등록요청 실행 */
	var settle_method = "";

	function pay_approval()
	{
		var f = document.sm_form;
		var pf = document.forderform;

		// 필드체크
		if(!payfield_check(pf))
			return false;

		// 금액체크
		if(!payment_check(pf))
			return false;

		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.buyr_name.value = pf.pp_name.value;
		f.buyr_mail.value = pf.pp_email.value;
		f.buyr_tel1.value = pf.pp_hp.value;
		f.buyr_tel2.value = pf.pp_hp.value;
		f.rcvr_name.value = pf.pp_name.value;
		f.rcvr_tel1.value = pf.pp_hp.value;
		f.rcvr_tel2.value = pf.pp_hp.value;
		f.rcvr_mail.value = pf.pp_email.value;
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
		f.LGD_BUYER.value = pf.pp_name.value;
		f.LGD_BUYEREMAIL.value = pf.pp_email.value;
		f.LGD_BUYERPHONE.value = pf.pp_hp.value;
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
		if(!payfield_check(f))
			return false;

		// 금액체크
		if(!payment_check(f))
			return false;

		if(f.res_cd.value != "0000") {
			alert("결제등록요청 후 결제해 주십시오.");
			return false;
		}

		document.getElementById("display_pay_button").style.display = "none";
		document.getElementById("show_progress").style.display = "block";

		setTimeout(function() {
			f.submit();
		}, 300);
	}

	// 결제폼 필드체크
	function payfield_check(f)
	{
		var settle_case = document.getElementsByName("pp_settle_case");
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
		var tot_price = <?php echo (int)$pp['pp_price']; ?>;

		if (document.getElementById("pp_settle_iche")) {
			if (document.getElementById("pp_settle_iche").checked) {
				if (tot_price < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("pp_settle_card")) {
			if (document.getElementById("pp_settle_card").checked) {
				if (tot_price < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("pp_settle_hp")) {
			if (document.getElementById("pp_settle_hp").checked) {
				if (tot_price < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		return true;
	}
<?php } else { ?>
	function forderform_check(f) {
		var settle_case = document.getElementsByName("pp_settle_case");
		var settle_check = false;
		var settle_method = "";
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

		var tot_price = <?php echo (int)$pp['pp_price']; ?>;

		if (document.getElementById("pp_settle_iche")) {
			if (document.getElementById("pp_settle_iche").checked) {
				if (tot_price < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("pp_settle_card")) {
			if (document.getElementById("pp_settle_card").checked) {
				if (tot_price < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("pp_settle_hp")) {
			if (document.getElementById("pp_settle_hp").checked) {
				if (tot_price < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		// pay_method 설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		switch(settle_method)
		{
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
			default:
				f.pay_method.value = "무통장";
				break;
		}
		<?php } else if($default['de_pg_service'] == 'lg') { ?>
		switch(settle_method)
		{
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
			default:
				f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
				break;
		}
		<?php } ?>

		// 결제정보설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.buyr_name.value = f.pp_name.value;
		f.buyr_mail.value = f.pp_email.value;
		f.buyr_tel1.value = f.pp_hp.value;
		f.buyr_tel2.value = f.pp_hp.value;
		f.rcvr_name.value = f.pp_name.value;
		f.rcvr_tel1.value = f.pp_hp.value;
		f.rcvr_tel2.value = f.pp_hp.value;
		f.rcvr_mail.value = f.pp_email.value;

		if(f.pay_method.value != "무통장") {
			if(jsf__pay( f )) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
		<?php } if($default['de_pg_service'] == 'lg') { ?>
		f.LGD_BUYER.value = f.pp_name.value;
		f.LGD_BUYEREMAIL.value = f.pp_email.value;
		f.LGD_BUYERPHONE.value = f.pp_hp.value;
		f.LGD_AMOUNT.value = f.good_mny.value;
		f.LGD_TAXFREEAMOUNT.value = 0;

		if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장") {
			  Pay_Request("<?php echo $pp_id; ?>", f.LGD_AMOUNT.value, f.LGD_TIMESTAMP.value);
		} else {
			f.submit();
		}
		<?php } ?>
	}
<?php } ?>
</script>

<?php
include_once('./_tail.php');

if(!G5_IS_MOBILE) { 
	// 결제대행사별 코드 include (스크립트 실행)
	require_once('./'.$default['de_pg_service'].'/orderform.5.php');
}
?>