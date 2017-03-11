<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 상단 파일 경로 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($config['cf_include_head'] && is_file(G5_PATH.'/'.$config['cf_include_head'])) {
    include_once(G5_PATH.'/'.$config['cf_include_head']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// Page Iframe Modal
if(APMS_PIM) {
	include_once(G5_PATH.'/head.sub.php');
	@include_once(THEMA_PATH.'/head.sub.php');
	return;
}

//Change Mode
if(G5_DEVICE_BUTTON_DISPLAY) {
    $seq = 0;
    $p = parse_url(G5_URL);
    $pc_mobile_href = $p['scheme'].'://'.$p['host'];
    if(isset($p['port']) && $p['port'])
        $pc_mobile_href .= ':'.$p['port'];
    $pc_mobile_href .= $_SERVER['PHP_SELF'];
    if($_SERVER['QUERY_STRING']) {
        $sep = '?';
        foreach($_GET as $key=>$val) {
            if($key == 'device')
                continue;

            $pc_mobile_href .= $sep.$key.'='.strip_tags($val);
            $sep = '&amp;';
            $seq++;
        }
    }

	$pc_mobile_device = G5_IS_MOBILE ? 'pc' : 'mobile';

	if($seq) {
        $pc_mobile_href .= '&amp;device='.$pc_mobile_device;
    } else {
        $pc_mobile_href .= '?device='.$pc_mobile_device;
	}
} else {
    $pc_mobile_href = '';
}

$as_href['pc_mobile'] = $pc_mobile_href;

// Head Sub
include_once(G5_PATH.'/head.sub.php');

$page_title = apms_fa($page_title);
$page_desc = apms_fa($page_desc);
$menu = apms_auto_menu();
$menu = apms_multi_menu($menu, $at['id'], $at['multi']);

if($is_member) thema_member();

//Statistics
$stats = apms_stats();

if($is_main && !$hid && !$gid ) {
	$newwin_path = (G5_IS_MOBILE) ? G5_MOBILE_PATH : G5_BBS_PATH;
	@include_once ($newwin_path.'/newwin.inc.php'); // 팝업레이어
}

include_once(THEMA_PATH.'/head.php');

?>
