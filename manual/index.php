<?php
define('_INDEX_', true);
include_once('./_common.php');
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

define('MANUAL_URL', THEMA_URL.'/manual');
define('MANUAL_PATH', THEMA_PATH.'/manual');


// 테마설정값 불러오기
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

if($is_demo || $is_admin) {
	;
} else {
	alert('이용권한이 없습니다.');
}

if(!file_exists(MANUAL_PATH.'/index.php')) {
	alert('테마 사용매뉴얼이 설치되어 있지 않습니다.');
}

$page_title = 'Thema Manual';
$page_desc = '테마 사용매뉴얼';

// 매뉴얼 설정값 불러오기
@include_once (THEMA_PATH.'/manual/setting.php');

apms_script('code');
include_once('../head.php');

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>APMS가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 APMS를 설치해 주세요.</p></br>';
} else {
	include_once (MANUAL_PATH.'/index.php');
}

include_once('../tail.php');
?>
