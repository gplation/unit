<?php
$sub_menu = '888004';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

if (get_session('pp_inquiry_id') != $member['mb_id']) {
	alert_close("직접 링크로는 수정이 불가합니다.\\n\\n출금관리 화면을 통하여 이용하시기 바랍니다.");
}

include_once(G5_LIB_PATH.'/apms.account.lib.php');

if(!$no) { 
	alert_close('값이 넘오지 않았습니다.');
}

$row = sql_fetch(" select * from {$g5['apms_payment']} where pp_id = '$no' ");
if(!$row['pp_id']) { 
	alert_close('존재하지 않는 출금신청서입니다.');
}

// 저장하기
if($mode == "save") {
	$pp_ans = substr(trim($pp_ans),0,65536);
	$pp_ans = preg_replace("#[\\\]+$#", "", $pp_ans);

	$sql = " update {$g5['apms_payment']}
				set pp_staff = '{$member['mb_id']}',
					 pp_tax = '$pp_tax',
					 pp_pay = '$pp_pay',
					 pp_shingo = '$pp_shingo',
					 pp_confirm = '$pp_confirm',
					 pp_confirmtime = '".G5_TIME_YMDHIS."',
					 pp_ans = '$pp_ans'
				 where pp_id = '$no' ";
	sql_query($sql);

	goto_url('./apms.inquiry.php?no='.$no);
}

$pp_no = $row['pp_id'];
$pp_date = date("Y/m/d H:i", strtotime($row['pp_datetime']));

switch($row['pp_means']) {
	case '1'	: $pp_means = AS_MP.'전환'; break;
	default		: $pp_means = '통장입금'; break;
}

$pp_amount = $row['pp_amount'];
$pp_net = ceil($row['pp_amount'] / 1.1);
$pp_vat = $row['pp_amount'] - $pp_net;

$row['pp_net'] = $pp_net;
$row['pp_vat'] = $pp_vat;

$pp_tax = $row['pp_tax'];
$pp_pay = $row['pp_pay'];

//유형
$pp_type = ($row['pp_type'] == "2") ? '개인' : '기업';
$pp_company = $row['pp_company'];

//방법
$pp_flag = apms_pay_flag($row['pp_flag']);

$pp_name = '탈퇴('.$row['mb_id'].')';
$pinfo = get_member($row['mb_id'], 'mb_nick, mb_email, mb_homepage');
if($pinfo['mb_nick']) {
	$pp_name = get_sideview($row['mb_id'], $pinfo['mb_nick'], $pinfo['mb_email'], $pinfo['wr_homepage']);
}

$pp_staff = '';
if($row['pp_staff']) {
	$sinfo = get_member($row['pp_staff'], 'mb_nick, mb_email, mb_homepage');
	if($sinfo['mb_nick']) {
		$pp_staff = get_sideview($row['pp_staff'], $sinfo['mb_nick'], $sinfo['mb_email'], $sinfo['wr_homepage']);
	}
}

$pinfo = array();
$pinfo = apms_partner($row['mb_id']);

//예상금액
$pp = array();
$pp = apms_pay_amount($row);

$g5['title'] = '출금신청서';
include_once(G5_PATH.'/head.sub.php');

?>

<div id="sch_target_frm" class="new_win scp_new_win">
    <h1>출금신청서 : <?php echo $pp_date; ?></h1>

    <form name="ftarget" method="post">
    <input type="hidden" name="mode" value="save">
	<input type="hidden" name="no" value="<?php echo $no; ?>">

    <div class="tbl_head02 tbl_wrap">
        <table>
        <colgroup>
            <col class="grid_2">
            <col>
		</colgroup>
        <caption>신청내역</caption>
        <thead>
        <tr>
            <th scope="col">구분</th>
            <th scope="col">주요내용</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td align="center">접수번호</td><td><?php echo $no; ?></td>
        </tr>
        <tr>
            <td align="center">출금방법</td><td><?php echo $pp_means; ?> / <?php echo $pp_name; ?></td>
        </tr>
		<?php if(!$row['pp_means']) { ?>
			<tr>
				<td align="center">입금계좌</td><td><?php echo ($pinfo['pt_bank_account']) ? $pinfo['pt_bank_name'].' '.$pinfo['pt_bank_account'].' '.$pinfo['pt_bank_holder'] : '미등록';?></td>
			</tr>
		<?php } ?>
		<tr>
            <td align="center">정산유형</td><td><?php echo $pp_company; ?></td>
        </tr>
		<tr>
            <td align="center">정산방법</td><td><?php echo $pp_flag; ?></td>
        </tr>
		<tr>
            <td align="center">신청금액</td><td><b><?php echo number_format($pp_amount); ?></b></td>
        </tr>
        <tr>
            <td align="center">공급가액</td><td><b><?php echo number_format($pp_net); ?></b></td>
        </tr>
        <tr>
            <td align="center">부가세</td><td><b><?php echo number_format($pp_vat); ?></b></td>
        </tr>
		<tr>
            <td align="center">제세공과</td><td><input type="text" name="pp_tax" value="<?php echo $row['pp_tax']; ?>" class="frm_input"> <?php echo number_format($pp['tax']);?>원 (원천징수 3.3% 등)</td>
        </tr>
        <tr>
            <td align="center">실지급액</td><td><input type="text" name="pp_pay" value="<?php echo $row['pp_pay']; ?>" class="frm_input"> <?php echo number_format($pp['pay']);?>원 (실입금/전환 금액)</td>
        </tr>
        <tr>
            <td align="center">신고금액</td><td><input type="text" name="pp_shingo" value="<?php echo $row['pp_shingo']; ?>" class="frm_input"> <?php echo number_format($pp['shingo']);?>원 (세무서 신고금액)</td>
        </tr>
		<tr>
            <td align="center">메모</td><td><?php echo conv_content(trim($row['pp_memo']), 0);?></td>
        </tr>
        <tr>
            <td align="center">비고</td><td><textarea name="pp_ans" rows="5"><?php echo $row['pp_ans'];?></textarea></td>
        </tr>
        <tr>
            <td align="center">상태</td><td>
				<label><input type="radio" name="pp_confirm" value="0"<?php echo (!$row['pp_confirm']) ? ' checked' : ''; ?>> 신청</label>
				&nbsp; &nbsp;
				<label><input type="radio" name="pp_confirm" value="1"<?php echo ($row['pp_confirm'] == "1") ? ' checked' : ''; ?>> 완료</label>
				&nbsp; &nbsp;
				<label><input type="radio" name="pp_confirm" value="2"<?php echo ($row['pp_confirm'] == "2") ? ' checked' : ''; ?>> 취소</label>
			</td>
        </tr>
		</tbody>
        </table>
    </div>

	<div class="btn_confirm01 btn_confirm">
		<input class="btn_submit" accesskey="s" type="submit" value="수정">
		<button type="button" onclick="window.close();">닫기</button>
    </div>

	</form>
</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>