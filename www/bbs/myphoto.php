<?php
include_once('./_common.php');

if($is_guest) {
	alert_close('회원만 이용하실 수 있습니다.');
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// 설정 저장-------------------------------------------------------
if ($mode == "u") apms_photo_upload($member['mb_id'], $del_mb_icon2, $_FILES); //Save
//--------------------------------------------------------------------

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('myphoto.skin.php', '/bbs/myphoto');

$mb_dir = substr($member['mb_id'],0,2);

$is_photo = (file_exists(G5_DATA_PATH.'/apms/photo/'.$mb_dir.'/'.$member['mb_id'].'.jpg')) ? true : false;

$photo_size = $xp['xp_photo'];

$myphoto = apms_photo_url($member['mb_id']);

$g5['title'] = '내사진 등록/수정';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($skin_path.'/myphoto.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>