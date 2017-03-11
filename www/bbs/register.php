<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($is_member) {
    goto_url(G5_URL);
}

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

// Page ID
$pid = ($pid) ? $pid : 'reg';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('register.skin.php', '/bbs/reg');

$g5['title'] = '회원가입약관';
include_once('./_head.php');

$action_url = G5_BBS_URL.'/register_form.php';
include_once($skin_path.'/register.skin.php');

include_once('./_tail.php');
?>
