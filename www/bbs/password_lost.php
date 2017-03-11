<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_member) {
    alert("이미 로그인중입니다.");
}

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('password_lost.skin.php', '/bbs/lost');

$action_url = G5_HTTPS_BBS_URL."/password_lost2.php";

$g5['title'] = '회원정보 찾기';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($skin_path.'/password_lost.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>