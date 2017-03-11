<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

if (!$is_member) {
    alert_close("회원만 작성 가능합니다.");
}

$w     = trim($_REQUEST['w']);
$it_id = trim($_REQUEST['it_id']);
$is_id = trim($_REQUEST['is_id']);

// 상품정보체크
$sql = " select it_id, ca_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id'])
    alert_close('자료가 존재하지 않습니다.');

$ca_id = ($ca_id) ? $ca_id : $row['ca_id'];
if(!defined('THEMA_PATH')) {
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$at['item'];
	$item_skin_url = G5_SKIN_URL.'/apms/item/'.$at['item'];
}

if ($w == "") {
    $is_score = 5;

	if($row['pt_review_use']) $default['de_item_use_write'] = ''; // 후기권한 재설정

	check_itemuse_write($it_id, $member['mb_id']); // 사용후기 작성 설정에 따른 체크

} else if ($w == "u") {
    $use = sql_fetch(" select * from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ");
    if (!$use) {
        alert_close("자료가 없습니다.");
    }

    $it_id    = $use['it_id'];
    $is_score = $use['is_score'];

    if (!$is_admin && $use['mb_id'] != $member['mb_id']) {
        alert_close("자신의 글만 수정이 가능합니다.");
    }
}

include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');

$is_dhtml_editor = false;
// 모바일에서는 DHTML 에디터 사용불가
if ($config['cf_editor'] && !G5_IS_MOBILE) {
    $is_dhtml_editor = true;
}
$editor_html = editor_html('is_content', get_text($use['is_content'], 0), $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('is_content', $is_dhtml_editor);
$editor_js .= chk_editor_js('is_content', $is_dhtml_editor);

include_once($item_skin_path.'/itemuseform.skin.php');

@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>