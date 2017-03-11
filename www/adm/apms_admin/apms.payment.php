<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/apms.account.lib.php');

if($mode == "payment") {

	//goto_url($go_url.'&amp;'.$qstr);
}

//검색결과
$sql_common = " from {$g5['apms_payment']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
		case 'pp_id' :
		case 'mb_id' :
        case 'pp_staff' :
			$sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

$sql_order = " order by pp_confirm, pp_id desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$listall = '<a href="?ap=payment" class="ov_listall">전체목록</a>';

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 17;

//전체현황
$account = array();
$account = apms_balance_sheet("@all");

//세션등록
set_session('pp_inquiry_id', $member['mb_id']);

?>
<style>
	.tbl_head02 td { text-align:center; }
	.pt-request { color:orangered; }
</style>
<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    총 <?php echo number_format($total_count) ?> 건
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="ap" value="payment">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="pp_id"<?php echo get_selected($_GET['sfl'], "pp_id"); ?>>접수번호</option>
	<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>파트너아이디</option>
	<option value="pp_staff"<?php echo get_selected($_GET['sfl'], "pp_staff"); ?>>담당자아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<div class="tbl_head02 tbl_wrap">
    <table>
    <thead>
    <tr>
		<th scope="col">계정현황</th>
		<th scope="col">총판매액</th>
		<th scope="col">총수수료</th>
		<th scope="col">총포인트</th>
		<th scope="col">총인센티브</th>
		<th scope="col">총매출액</th>
		<th scope="col">총배송비</th>
		<th scope="col">총적립액</th>
		<th scope="col">총지급액</th>
		<th scope="col">지급요청</th>
		<th scope="col">현재잔액</th>
    </tr>
    </thead>
    <tbody>
	<tr>
		<td>금액(원)</td>
		<td><?php echo number_format($account['sale']);?></td>
		<td><?php echo number_format($account['commission']);?></td>
		<td><?php echo number_format($account['point']);?></td>
		<td><?php echo number_format($account['intensive']);?></td>
		<td><?php echo number_format($account['netsale']);?></td>
		<td><?php echo number_format($account['sendcost']);?></td>
		<td><b><?php echo number_format($account['netgross']);?></b></td>
		<td><?php echo number_format($account['payment']);?></td>
		<td><b><?php echo number_format($account['request']);?></b></td>
		<td><b><?php echo number_format($account['balance']);?></b></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="local_desc01 local_desc">
    <p>
        출금신청 목록은 신청/완료/취소 순으로 출력되며, 계정현황에는 회사 판매분과 츨금현황 제외회원의 내역은 포함되어 있지 않습니다.
    </p>
</div>

<div class="tbl_head02 tbl_wrap">
    <table>
    <thead>
    <tr>
		<th scope="col">번호</th>
		<th scope="col">상태</th>
		<th scope="col">접수번호</th>
		<th scope="col">신청일</th>
		<th scope="col">신청인</th>
		<th scope="col">출금방법</th>
		<th scope="col">정산유형</th>
		<th scope="col">신청금액</th>
		<th scope="col">공급가액</th>
		<th scope="col">부가세</th>
		<th scope="col">제세공과</th>
		<th scope="col">실지급액</th>
		<th scope="col">신고금액</th>
		<th scope="col">메모</th>
		<th scope="col">비고</th>
        <th scope="col">관리</th>
        <th scope="col">담당</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

		$pp_num = $total_count - ($page - 1) * $rows - $i;

		$pp_no = $row['pp_id'];
		$pp_date = date("Y/m/d H:i", strtotime($row['pp_datetime']));

		switch($row['pp_means']) {
			case '1'	: $pp_means = AS_MP.'전환'; break;
			default		: $pp_means = '통장입금'; break;
		}

		switch($row['pp_confirm']) {
			case '1'	: $pp_confirm = '완료'; break;
			case '2'	: $pp_confirm = '취소'; break;
			default		: $pp_confirm = '신청'; break;
		}

		$pp_memo = (trim($row['pp_memo'])) ? '■' : '';
		$pp_ans = (trim($row['pp_ans'])) ? '◎' : '';

		$pp_amount = $row['pp_amount'];
		$pp_net = ceil($row['pp_amount'] / 1.1);
		$pp_vat = $row['pp_amount'] - $pp_net;
		$pp_tax = $row['pp_tax'];
		$pp_pay = $row['pp_pay'];
		$pp_shingo = $row['pp_shingo'];

		//유형
		$pp_type = ($row['pp_type'] == "2") ? '개인' : '기업';
		$pp_company = $row['pp_company'];

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

		//수정
		$pp_mod = '<a href="./apms.inquiry.php?no='.$row['pp_id'].'" class="mod-inquiry">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td><?php echo $pp_num;?></td>
        <td><?php echo $pp_confirm;?></td>
        <td><?php echo $pp_no;?></td>
        <td><?php echo $pp_date;?></td>
        <td><?php echo $pp_name;?></td>
		<td><?php echo $pp_means;?></td>
		<td><?php echo $pp_company;?></td>
		<td><?php echo number_format($pp_amount);?></td>
        <td><?php echo number_format($pp_net);?></td>
        <td><?php echo number_format($pp_vat);?></td>
		<td><?php echo number_format($pp_tax);?></td>
        <td><?php echo number_format($pp_pay);?></td>
        <td><?php echo number_format($pp_shingo);?></td>
		<td><?php echo $pp_memo;?></td>
        <td><?php echo $pp_ans;?></td>
        <td><?php echo $pp_mod;?></td>
        <td><?php echo $pp_staff;?></td>
	</tr>

	<?php
    }
    if ($i == 0)
        echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>
$(function() {
    $(".mod-inquiry").click(function() {
        var opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var url = this.href;
        window.open(url, "win_inquiry", opt);
		return false;
	});
});
</script>
