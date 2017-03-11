<?php
$sub_menu = "300100";
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

auth_check($auth[$sub_menu], 'w');

if(!$bo_table) {
    alert_close('값이 넘어오지 않았습니다.');
}

$skin_file = $board_skin_path.'/setup.skin.php';

if(!file_exists($skin_file)) {
    alert_close('설정을 할 수 없는 보드입니다.');
}

if($mode == "save") {

	$boset = apms_pack($_POST['boset']);
	if($board['bo_skin'] == $board['bo_mobile_skin']) { //스킨이 같으면 동일값 적용
		sql_query(" update {$g5['board_table']} set as_set = '{$boset}', as_mobile_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
	} else {
		if(G5_IS_MOBILE) {
			sql_query(" update {$g5['board_table']} set as_mobile_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
		} else {
			sql_query(" update {$g5['board_table']} set as_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
		}
	}

	@include_once($board_skin_path.'/setupsave.skin.php');

	goto_url('./board.setup.php?bo_table='.$bo_table);
}

$boset = apms_unpack($board['as_'.MOBILE_.'set']);

$g5['title'] = $board['bo_subject'].' 보드설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_board_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table;?>">

	<?php include_once($skin_file); ?>

    <div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="window.close();">닫기</button>
    </div>
	</form>
	<br>
</div>
<script>
var win_h = parseInt($('#sch_board_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(640, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
