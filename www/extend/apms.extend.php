<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/apms.lib.php');
@include_once(G5_EXTEND_PATH.'/shop.extend.php');

// APMS Version
define('APMS_VERSION', 'APMS 1.1.9 - G5/YC5.0.31');

// USE YC5
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) {
	define('IS_YC', false);
	@include_once(G5_LIB_PATH.'/thumbnail.lib.php');
} else {
	define('IS_YC', true);
	@include_once(G5_LIB_PATH.'/apms.shop.lib.php');
}

// APMS DB Table
if(IS_YC) {
	$g5['apms'] = G5_TABLE_PREFIX.'apms';
	$g5['apms_partner'] = G5_TABLE_PREFIX.'apms_partner';
	$g5['apms_payment'] = G5_TABLE_PREFIX.'apms_payment';
	$g5['apms_file'] = G5_TABLE_PREFIX.'apms_file';
	$g5['apms_form'] = G5_TABLE_PREFIX.'apms_form';
	$g5['apms_comment'] = G5_TABLE_PREFIX.'apms_comment';
	$g5['apms_use_log'] = G5_TABLE_PREFIX.'apms_use_log';
	$g5['apms_rows'] = G5_TABLE_PREFIX.'apms_rows';
	$g5['apms_sendcost'] = G5_TABLE_PREFIX.'apms_sendcost';
	$g5['apms_good'] = G5_TABLE_PREFIX.'apms_good';
}
$g5['apms_tag'] = G5_TABLE_PREFIX.'apms_tag';
$g5['apms_tag_log'] = G5_TABLE_PREFIX.'apms_tag_log';
$g5['apms_like'] = G5_TABLE_PREFIX.'apms_like';
$g5['apms_xp'] = G5_TABLE_PREFIX.'apms_xp';
$g5['apms_page'] = G5_TABLE_PREFIX.'apms_page';
$g5['apms_data'] = G5_TABLE_PREFIX.'apms_data';
$g5['apms_cache'] = G5_TABLE_PREFIX.'apms_cache';
$g5['apms_shingo'] = G5_TABLE_PREFIX.'apms_shingo';
$g5['apms_response'] = G5_TABLE_PREFIX.'apms_response';
$g5['apms_event'] = G5_TABLE_PREFIX.'apms_event';
$g5['apms_playlist'] = G5_TABLE_PREFIX.'apms_playlist';
$g5['cache_auto_menu'] = (int)$config['cf_9']; //메뉴
$g5['cache_stats_time'] = (int)$config['cf_10_subj']; //통계
$g5['cache_newpost_time'] = (int)$config['cf_10']; //새글

if(G5_IS_MOBILE) {
	define('MOBILE_', 'mobile_');
    $board_skin_path    = G5_SKIN_PATH.'/board/'.$board['bo_mobile_skin'];
    $board_skin_url     = G5_SKIN_URL .'/board/'.$board['bo_mobile_skin'];
} else {
	define('MOBILE_', '');
}

// APMS Common ---------------------------------------------------------------------------
$as_href = array();
$at = array();
$xp = array();

// Load XP
$xp = sql_fetch("select * from {$g5['apms_xp']} ", false);

// Define Term
define('AS_XP', $config['as_xp']);
define('AS_MP', $config['as_mp']);

define('APMS_PLUGIN_PATH', G5_PLUGIN_PATH.'/apms');
define('APMS_PLUGIN_URL', G5_PLUGIN_URL.'/apms');

$mode = apms_escape('mode', 0);
$pid = apms_escape('pid', 0);
$pim = apms_escape('pim', 0);

define('APMS_PIM', $pim);

// Member
$member = apms_member($member['mb_id']);

if($member['as_partner']) {
	define('IS_PARTNER', true);
} else {
	define('IS_PARTNER', false);
}

// Auth
if($is_admin == 'super' || $is_admin == 'group') {
	;
} else {
	if($gr_id) {
		if($group['as_partner'] && !IS_PARTNER) {
			alert("파트너만 이용가능합니다.", G5_URL);
		}
		apms_auth($group['as_grade'], $group['as_equal'], $group['as_min'], $group['as_max']);
	}
	if(!$is_admin && $bo_table) {
		if($board['as_partner'] && !IS_PARTNER) {
			alert("파트너만 이용가능합니다.", G5_URL);
		}
		apms_auth($board['as_grade'], $board['as_equal'], $board['as_min'], $board['as_max']);
	}
}

// 태그검색
if (isset($_REQUEST['stag']))  { // 태그 검색어
    $stag = get_search_string(trim($_REQUEST['stag']));
    if ($stag)
        $qstr .= '&amp;stag=' . urlencode($stag);
} else {
    $stag = '';
}

// 인덱스
$is_index = false;

// Cross Domain jQuery Error
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
if(array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', $_SERVER)) {
    header('Access-Control-Allow-Headers: '
           . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
} else {
    header('Access-Control-Allow-Headers: *');
}
 
if("OPTIonS" == $_SERVER['REQUEST_METHOD']) {
    exit(0);
}

?>