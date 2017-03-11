<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

if(!$skin) {
    alert_close('값이 넘어오지 않았습니다.');
}

$skin_url = G5_SKIN_URL.'/apms/list/'.$skin;
$skin_path = G5_SKIN_PATH.'/apms/list/'.$skin;

if(!file_exists($skin_path.'/setup.skin.php')) {
    alert_close('설정을 할 수 없는 스킨입니다.');
}

if($mode == "save") {

	if ($is_admin != 'super') {
		alert("최고관리자만 가능합니다.");
	}

	$wconfig = apms_pack($_POST['wset']);
	$sql_wm = "";
	if($_POST['wmset']) {
		$wmconfig = apms_pack($_POST['wmset']);
		$sql_wm = ", data_1 = '{$wmconfig}'";
	}

	// 기존값 삭제
	sql_query(" delete from {$g5['apms_data']} where type = '99' and data_q = '{$skin}' ");

	// 신규등록
	sql_query(" insert {$g5['apms_data']} set type = '99', data_q = '{$skin}', data_set = '{$wconfig}' $sql_wm ");

	@include_once($skin_path.'/setupsave.skin.php');

	$goto_url = './list.setup.php?skin='.urlencode($skin);

	goto_url($goto_url);
}

if (!$wdemo && $is_admin != 'super') {
    alert_close("최고관리자만 가능합니다.");
}

// 입력 폼 안내문
if (!function_exists('help')) {
	function help($help="")	{
		global $g5;

		$str  = '<span class="frm_info">'.str_replace("\n", "<br>", $help).'</span>';

		return $str;
	}
}

// 불러오기
$row = sql_fetch("select data_set, data_1 from {$g5['apms_data']} where type = '99' and data_q = '{$skin}' limit 1 ");

if($row['data_set']) {
	$wset = apms_unpack($row['data_set']);
	$wmset = apms_unpack($row['data_1']);
} else if($opt) {
	$wset = apms_query($opt);
	$wmset = $wset;
}

$g5['title'] = '아이템 목록스킨 설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_list_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="skin" value="<?php echo $skin;?>">
	<input type="hidden" name="wdemo" value="<?php echo $wdemo;?>">

	<?php include_once($skin_path.'/setup.skin.php'); ?>

    <div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="window.close();">닫기</button>
    </div>
	</form>
	<br>
</div>
<script>
var win_h = parseInt($('#sch_list_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(640, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
