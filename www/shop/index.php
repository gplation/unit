<?php
define("_INDEX_", TRUE);
include_once('./_common.php');

if(!$page_id) {
	$page_id = 'index';
}

$is_index = true;
$is_main = true;

// 쇼핑몰 미지정시
if(!defined('IS_SHOP')) {
	define('_SHOP_', true);
	define('IS_SHOP', true);
	// 예약체크
	apms_check_reserve_end();
}

// 초기화면 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_index'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_index'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_index']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

include_once(G5_SHOP_PATH.'/shop.head.php');

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>APMS가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 APMS를 설치해 주세요.</p></br>';
} else {
	if(file_exists(THEMA_PATH.'/shop.index.php')) {
		include_once (THEMA_PATH.'/shop.index.php');
	} else {
		include_once (THEMA_PATH.'/index.php');
	}
}

include_once(G5_SHOP_PATH.'/shop.tail.php');
?>