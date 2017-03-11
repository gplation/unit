<?php
include_once('./_common.php');

if (isset($_SESSION['ss_mb_reg']))
    $mb = get_member($_SESSION['ss_mb_reg']);

// 회원정보가 없다면 초기 페이지로 이동
if (!$mb['mb_id'])
    goto_url(G5_URL);

// Page ID
$pid = ($pid) ? $pid : 'regresult';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

list($skin_path, $skin_url) = apms_skin_path('register_result.skin.php', '/bbs/regresult');

$mb['mb_name'] = get_text($mb['mb_name']); 

$g5['title'] = '회원가입이 완료되었습니다.';
include_once('./_head.php');
include_once($skin_path.'/register_result.skin.php');
include_once('./_tail.php');
?>