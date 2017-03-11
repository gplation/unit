<?php
if (!defined('_GNUBOARD_')) exit;

if($mode == "plist") {
	if (!count($_POST['chk'])) {
		alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
	}

	if ($_POST['act_button'] == "선택승인") {
		$pt_register = date("Ymd"); //등록일
		for ($i=0; $i<count($_POST['chk']); $i++) {
			$k = $_POST['chk'][$i]; // 실제 번호를 넘김
			sql_query(" update {$g5['apms_partner']} set pt_register = '{$pt_register}' where pt_id = '{$_POST['pt_id'][$k]}' ");

			//회원정보변경
			sql_query(" update {$g5['member_table']} set as_partner = '1' where mb_id = '{$_POST['pt_id'][$k]}' ", false);
		}
	}
	goto_url($go_url.'&amp;'.$qstr);
}

//검색결과
$sql_common = " from {$g5['apms_partner']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'pt_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "pt_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴 파트너수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and pt_leave <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

$listall = '<a href="?ap=plist" class="ov_listall">전체목록</a>';

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 10;

?>
<style>
	.tbl_head02 td { text-align:center; }
	.pt-request { color:orangered; }
</style>
<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    총 파트너수 <?php echo number_format($total_count) ?>명 중,
    <a href="?ap=plist&amp;sst=pt_leave&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>">탈퇴 <?php echo number_format($leave_count) ?></a>명
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="ap" value="plist">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="pt_id"<?php echo get_selected($_GET['sfl'], "pt_id"); ?>>회원아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<div class="local_desc01 local_desc">
    <p>
        파트너를 탈퇴하더라도 기존 거래내역 보존을 위해 파트너 정보(거래처정보)는 삭제하지 않고 영구 보관합니다.
    </p>
</div>

<form name="fmemberlist" id="fmemberlist" action="./apms.admin.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="ap" value="plist">
<input type="hidden" name="mode" value="plist">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<div class="tbl_head02 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">회원 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo apms_sort_link('pt_register') ?>구분</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_type') ?>파트너</a></th>
		<th scope="col"><?php echo apms_sort_link('pt_id') ?>아이디</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_name') ?>담당자</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_hp') ?>연락처</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_email') ?>이메일</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_company') ?>정산</a></th>
        <th scope="col"><?php echo apms_sort_link('pt_bank_limit') ?>출금</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

		//구분
		$is_check = false;
		if($row['pt_leave']) { //탈퇴
			$p_status = '<span class="mb_leave_msg"><strike>'.$row['pt_leave'].'</strike></span>';
		} else if($row['pt_register']) { //등록
			$p_status = $row['pt_register'];
		} else { //신청
			$p_status = '<span class="pt-request">신청</span>';
			$is_check = true;
		}

		//유형
		$p_type = ($row['pt_type'] == "2") ? '개인' : '기업';

        $p_id = get_sideview($row['pt_id'], $row['pt_id'], $row['pt_email'], '');

		//수정
		$p_mod = '<a href="./apms.admin.php?ap=pform&amp'.$qstr.'&amp;pt_id='.$row['pt_id'].'">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="mb_list_chk" class="td_chk">
            <input type="hidden" name="pt_id[<?php echo $i ?>]" value="<?php echo $row['pt_id'] ?>" id="pt_id_<?php echo $i ?>">
			<?php if($is_check) { ?>
	            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			<?php } else { ?>
				*
			<?php } ?>
        </td>
        <td><?php echo $p_status;?></td>
		<td><?php echo $p_type;?></td>
		<td><?php echo $p_id;?></td>
		<td><?php echo $row['pt_name'];?></td>
		<td><?php echo $row['pt_hp'];?></td>
		<td><?php echo $row['pt_email'];?></td>
		<td><?php echo $row['pt_company'];?></td>
		<td><?php echo ($row['pt_bank_limit']) ? '불가' : '가능';?></td>
		<td><?php echo $p_mod;?></td>
    </tr>

	<?php
    }
    if ($i == 0)
        echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택승인" onclick="document.pressed=this.value">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;ap=plist&amp;page='); ?>

<script>
function fmemberlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택승인") {
        if(!confirm("선택한 파트너를 정말 등록승인하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
