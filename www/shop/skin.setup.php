<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

if($skin == 'list') { //상품목록
	if(!$ca_id) 
		alert_close('값이 넘어오지 않았습니다.');

	$row = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id'");
	if (!$row['ca_id'])
		alert_close('값이 넘어오지 않았습니다.');

	$skin_set = $row['as_'.MOBILE_.'set'];
	$skin_pc = $row['ca_skin'];
	$skin_mobile = $row['ca_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/list/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/list/'.$skin_name;
	$title = '상품목록';
} else if($skin == 'ev') { //이벤트 상품
	if(!$ev_id) 
		alert_close('값이 넘어오지 않았습니다.');

	$row = sql_fetch(" select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' ");
	if (!$row['ev_id'])
		alert_close('값이 넘어오지 않았습니다.');

	$skin_set = $row['ev_'.MOBILE_.'set'];
	$skin_pc = $row['ev_skin'];
	$skin_mobile = $row['ev_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/list/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/list/'.$skin_name;
	$title = '이벤트 상품목록';
} else if($skin == 'event') { //이벤트
	$row = apms_rows();
	$skin_set = $row['event_'.MOBILE_.'set'];
	$skin_pc = $row['event_skin'];
	$skin_mobile = $row['event_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/event/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/event/'.$skin_name;
	$title = '이벤트';
} else if($skin == 'type') { //상품유형
	$row = apms_rows();
	$skin_set = $row['type_'.MOBILE_.'set'];
	$skin_pc = $row['type_skin'];
	$skin_mobile = $row['type_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/type/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/type/'.$skin_name;
	$title = '상품유형';
} else if($skin == 'myshop') { //마이샵
	$row = apms_rows();
	$skin_set = $row['myshop_'.MOBILE_.'set'];
	$skin_pc = $row['myshop_skin'];
	$skin_mobile = $row['myshop_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/myshop/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/myshop/'.$skin_name;
	$title = '마이샵';
} else if($skin == 'search') { //상품검색
	$row = apms_rows();
	$skin_set = $row['search_'.MOBILE_.'set'];
	$skin_pc = $default['de_search_list_skin'];
	$skin_mobile = $default['de_mobile_search_list_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/search/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/search/'.$skin_name;
	$title = '상품검색';
} else if($skin == 'qa') { //상품문의
	$row = apms_rows();
	$skin_set = $row['qa_'.MOBILE_.'set'];
	$skin_pc = $row['qa_skin'];
	$skin_mobile = $row['qa_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/qa/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/qa/'.$skin_name;
	$title = '상품문의';
} else if($skin == 'use') { //상품후기
	$row = apms_rows();
	$skin_set = $row['use_'.MOBILE_.'set'];
	$skin_pc = $row['use_skin'];
	$skin_mobile = $row['use_mobile_skin'];
	$skin_name = (G5_IS_MOBILE) ? $skin_mobile : $skin_pc;
	$skin_path = G5_SKIN_PATH.'/apms/use/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/use/'.$skin_name;
	$title = '상품후기';
} else {
   alert_close('값이 넘어오지 않았습니다.');
}

$skin_file = $skin_path.'/setup.skin.php';

if(!file_exists($skin_file)) {
    alert_close('설정을 할 수 없는 스킨입니다.');
}

if($mode == "save") {

	$wset = apms_pack($_POST['wset']);
	if($skin_pc == $skin_mobile) { //스킨이 같으면 동일값 적용
		if($skin == 'list') {
			sql_query(" update {$g5['g5_shop_category_table']} set as_set = '{$wset}', as_mobile_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
		} else if($skin == 'ev') {
			sql_query(" update {$g5['g5_shop_event_table']} set ev_set = '{$wset}', ev_mobile_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
		} else {
			sql_query(" update {$g5['apms_rows']} set {$skin}_set = '{$wset}', {$skin}_mobile_set = '{$wset}' ", false);
		}
	} else {
		if(G5_IS_MOBILE) {
			if($skin == 'list') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_mobile_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'ev') {
				sql_query(" update {$g5['g5_shop_event_table']} set ev_mobile_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
			} else {
				sql_query(" update {$g5['apms_rows']} set {$skin}_mobile_set = '{$wset}' ", false);
			}
		} else {
			if($skin == 'list') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'ev') {
				sql_query(" update {$g5['g5_shop_event_table']} set ev_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
			} else {
				sql_query(" update {$g5['apms_rows']} set {$skin}_set = '{$wset}' ", false);
			}
		}
	}

	$goto_url = './shop.setup.php?skin='.urlencode($skin);
	if($ca_id) $goto_url .= '&amp;ca_id='.urlencode($ca_id);
	if($ev_id) $goto_url .= '&amp;ev_id='.urlencode($ev_id);

	goto_url($goto_url);
}

$wset = apms_unpack($skin_set);

$g5['title'] = $title.' 스킨설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_shop_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="skin" value="<?php echo $skin;?>">
	<input type="hidden" name="ca_id" value="<?php echo $ca_id;?>">
	<input type="hidden" name="ev_id" value="<?php echo $ev_id;?>">

	<?php include_once($skin_file); ?>

    <div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="window.close();">닫기</button>
    </div>
	</form>
	<br>
</div>
<script>
var win_h = parseInt($('#sch_shop_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(640, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
