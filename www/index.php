<?php
define('_INDEX_', true);
include_once('./_common.php');

// 초기화면 파일 경로 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($config['cf_include_index'] && is_file(G5_PATH.'/'.$config['cf_include_index'])) {
    include_once(G5_PATH.'/'.$config['cf_include_index']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

// 루트 index를 쇼핑몰 index 설정했을 때
if(isset($default['de_root_index_use']) && $default['de_root_index_use']) {
    require_once(G5_SHOP_PATH.'/index.php');
    return;
}

$is_index = true;
$is_main = true;

include_once('./_head.php');

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>APMS가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 APMS를 설치해 주세요.</p></br>';
} else {
	include_once (THEMA_PATH.'/index.php');
}

include_once('./_tail.php');
?>
