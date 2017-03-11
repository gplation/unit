<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

$gid = $gr_id;
$is_main = true;

// 테마설정
$at = array();
$at = apms_gr_thema();
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$skin_path = THEMA_PATH.'/bbs/group';
$skin_url  = THEMA_URL.'/bbs/group';

// 스킨함수
function apms_group_list($bo_table, $rows=10, $subject_len=40, $cache_time=1, $options='') {
    global $g5, $skin_path, $skin_url;

    $cache_fwrite = false;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/group-{$bo_table}-{$rows}-{$subject_len}.php";

        if(!file_exists($cache_file)) {
            $cache_fwrite = true;
        } else {
            if($cache_time > 0) {
                $filetime = filemtime($cache_file);
                if($filetime && $filetime < (G5_SERVER_TIME - 300 * $cache_time)) {
                    @unlink($cache_file);
                    $cache_fwrite = true;
                }
            }

            if(!$cache_fwrite)
                include($cache_file);
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num limit 0, {$rows} ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $skin_url, $subject_len);
        }

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject='".$bo_subject."';\n\$list=".var_export($list, true)."?>";
            fwrite($handle, $cache_content);
            fclose($handle);
        }
    }

    ob_start();
    @include $skin_path.'/group.list.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

$doc_path = G5_DATA_PATH.'/apms/main';
$doc_url = G5_DATA_URL.'/apms/main';

$g5['title'] = $group['gr_subject'];
include_once('./_head.php');

if(!$group['as_main'] || $group['as_main'] == "#") { // 기본메인
	@include($skin_path.'/group.skin.php');
} else if($group['as_main'] && file_exists($doc_path.'/'.$group['as_main'].'.php')) { // 메인지정시
	@include($doc_path.'/'.$group['as_main'].'.php');
} else {
	echo '<p class="text-center text-muted">테마관리 > 메뉴설정에서 사용할 그룹메인을 지정해 주세요.</p>';
}

include_once('./_tail.php');
?>