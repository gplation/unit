<?php
include_once('./_common.php');

$sql = "select * from {$g5['g5_shop_personalpay_table']} where pp_id = '$pp_id' ";
$pp = sql_fetch($sql);
if (!$pp['pp_id'] || (md5($pp['pp_id'].$pp['pp_time'].$_SERVER['REMOTE_ADDR']) != get_session('ss_personalpay_uid'))) {
    alert("조회하실 개인결제 내역이 없습니다.", G5_SHOP_URL);
}

// 결제방법
$settle_case = $pp['pp_settle_case'];

// LG 현금영수증 JS
if($pp['pp_pg'] == 'lg') {
    if($default['de_card_test']) {
    echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    } else {
        echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    }
}

$misu = true;

if ($pp['pp_price'] == $pp['pp_receipt_price']) {
	$wanbul = " (완불)";
	$misu = false; // 미수금 없음
} else {
	$wanbul = display_price($pp['pp_receipt_price']);
}

$misu_price = $pp['pp_price'] - $pp['pp_receipt_price'];

// 결제정보처리
if($pp['pp_receipt_price'] > 0)
	$pp_receipt_price = display_price($pp['pp_receipt_price']);
else
	$pp_receipt_price = '아직 입금되지 않았거나 입금정보를 입력하지 못하였습니다.';

$app_no_subj = '';
$disp_bank = true;
$disp_receipt = false;
if($pp['pp_settle_case'] == '신용카드') {
	$app_no_subj = '승인번호';
	$app_no = $pp['pp_app_no'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($pp['pp_settle_case'] == '휴대폰') {
	$app_no_subj = '휴대폰번호';
	$app_no = $pp['pp_bank_account'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($pp['pp_settle_case'] == '가상계좌' || $pp['pp_settle_case'] == '계좌이체') {
	$app_no_subj = '거래번호';
	$app_no = $pp['pp_tno'];
}

$hp_receipt_script = $card_receipt_script = $cash_receipt_script = '';

if($disp_receipt) {
	if($pp['pp_settle_case'] == '휴대폰') {
		if($pp['pp_pg'] == 'lg') {
			require_once G5_SHOP_PATH.'/settle_lg.inc.php';
			$LGD_TID      = $pp['pp_tno'];
			$LGD_MERTKEY  = $config['cf_lg_mert_key'];
			$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

			$hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
		} else {
			$hp_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'mcash_bill&tno='.$pp['pp_tno'].'&order_no='.$pp['pp_id'].'&trade_mony='.$pp['pp_receipt_price'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
		}
	}

	if($pp['pp_settle_case'] == '신용카드') {
		if($pp['pp_pg'] == 'lg') {
			require_once G5_SHOP_PATH.'/settle_lg.inc.php';
			$LGD_TID      = $pp['pp_tno'];
			$LGD_MERTKEY  = $config['cf_lg_mert_key'];
			$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

			$card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
		} else {
			$card_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'card_bill&tno='.$pp['pp_tno'].'&order_no='.$pp['pp_id'].'&trade_mony='.$pp['pp_receipt_price'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
		}
	}
}

// 현금영수증 발급을 사용하는 경우에만
$is_cash_receipt = false;
if ($default['de_taxsave_use']) {
	$is_cash_receipt = true;

	// 주문내역이 있으면 현금영수증 발급하지 않음
	if($pp['od_id']) {
		$sql = " select count(od_id) as cnt from {$g5['g5_shop_order_table']} where od_id = '{$pp['od_id']}' ";
		$row = sql_fetch($sql);

		if($row['cnt'] > 0)
			$is_cash_receipt = false;
	}

	// 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
	if ($is_cash_receipt && $misu_price == 0 && $pp['pp_receipt_price'] && ($pp['pp_settle_case'] == '계좌이체' || $pp['pp_settle_case'] == '가상계좌')) {
		if ($pp['pp_cash']) {
			if($pp['pp_pg'] == 'lg') {
				require_once G5_SHOP_PATH.'/settle_lg.inc.php';

				switch($pp['pp_settle_case']) {
					case '계좌이체':
						$trade_type = 'BANK';
						break;
					case '가상계좌':
						$trade_type = 'CAS';
						break;
					default:
						$trade_type = 'CR';
						break;
				}
				$cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$pp['pp_id'].'\',\''.$pp['pp_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
			} else {
				require_once G5_SHOP_PATH.'/settle_kcp.inc.php';

				$cash = unserialize($pp['pp_cash_info']);
				$cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$pp_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
			}

		}
	}
}

$is_account_test = false;
if ($pp['pp_settle_case'] == '가상계좌' && $pp['pp_receipt_price'] == 0 && $default['de_card_test'] && $is_admin && $pp['pp_pg'] == 'kcp') {
    preg_match("/\s{1}([^\s]+)\s?/", $pp['pp_bank_account'], $matchs);
    $deposit_no = trim($matchs[1]);
	$is_account_test = true;
}

$pid = ($pid) ? $pid : 'ppayresult';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('personalpayresult.skin.php', '/shop/ppayresult');

$g5['title'] = '개인결제상세내역';
include_once('./_head.php');
include_once($skin_path.'/personalpayresult.skin.php');
include_once('./_tail.php');
?>
