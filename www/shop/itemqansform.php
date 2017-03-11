<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

if (!$is_member) {
    alert_close("회원만 작성 가능합니다.");
}

$w     = trim($_REQUEST['w']);
$it_id = trim($_REQUEST['it_id']);
$iq_id = trim($_REQUEST['iq_id']);

// 상품정보체크
$sql = " select it_id, ca_id, pt_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id'])
    alert_close('자료가 존재하지 않습니다.');

$ca_id = ($ca_id) ? $ca_id : $row['ca_id'];
if(!defined('APMS_SHOP_ITEM_PATH')) {
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$at['item'];
	$item_skin_url = G5_SKIN_URL.'/apms/item/'.$at['item'];
}

if (!$is_admin && $row['pt_id'] != $member['mb_id']) {
	alert_close("자신이 등록한 상품의 문의글에 대한 답글만 가능합니다.");
}

$sql = " select *
           from {$g5['g5_shop_item_qa_table']} a
           left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
          where iq_id = '$iq_id' $qa_sql ";
$qa = sql_fetch($sql);

if (!$qa['iq_id']) alert_close('등록된 자료가 없습니다.');

$qa['iq_question'] = apms_content(conv_content($qa['iq_question'], 1));
$qa['name'] = apms_sideview($qa['mb_id'], get_text($qa['iq_name']), $qa['mb_email'], $qa['mb_homepage']);
$qa['photo'] = apms_photo_url($qa['mb_id']);

include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');

$is_dhtml_editor = false;
// 모바일에서는 DHTML 에디터 사용불가
if ($config['cf_editor'] && !G5_IS_MOBILE) {
    $is_dhtml_editor = true;
}
$editor_html = editor_html('iq_answer', get_text($qa['iq_answer'], 0), $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('iq_answer', $is_dhtml_editor);
$editor_js .= chk_editor_js('iq_answer', $is_dhtml_editor);

include_once($item_skin_path.'/itemqansform.skin.php');

@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>