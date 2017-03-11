<?php
include_once('../common.php');

// 특수문자 변환
function specialchars_replace($str, $len=0) {
    if ($len) {
        $str = substr($str, 0, $len);
    }

    $str = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $str);

    return $str;
}

function img_insert_content($matches){
	global $row;

	return view_image($row, $matches[1], $matches[2]);
}

// RSS 갯수
$rss_rows = $config['cf_page_rows'];

// 통합 RSS bo_table
$bo = array();
$result = sql_query(" select bo_table from {$g5['board_table']} where bo_use_rss_view = '1' and bo_read_level = '1' and bo_table <> '' ");
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$bo[$i] = $row['bo_table'];
}

if (!$i) {
    echo 'RSS 보기가 가능한 게시판이 없습니다.';
    exit;
}

header('Content-type: text/xml');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

echo '<?xml version="1.0" encoding="utf-8" ?>'."\n";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title><?php echo specialchars_replace($config['cf_title']); ?></title>
<link><?php echo specialchars_replace(G5_URL); ?></link>
<description>테스트 버전 0.2 (2004-04-26)</description>
<language>ko</language>

<?php
// 추출하기
$bo_list = ($i > 0) ? implode(',', $bo) : $bo[0];
$result = sql_query(" select * from {$g5['board_new_table']} where wr_id = wr_parent and find_in_set(bo_table, '{$bo_list}') and as_secret <> '1' order by bn_id desc limit 0, $rss_rows ", false);
for ($i=0; $post=sql_fetch_array($result); $i++) {

	$tmp_write_table = $g5['write_prefix'] . $post['bo_table']; 

	$row = sql_fetch(" select * from $tmp_write_table where wr_id = '{$post['wr_id']}' ", false);

    if(strstr($row['wr_option'], 'secret')) continue;

	if($row['as_shingo'] < 0) continue;

	$board = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table = '{$post['bo_table']}' ");

    if (strstr($row['wr_option'], 'html'))
        $html = 1;
    else
        $html = 0;

	$row['wr_content'] = conv_content($row['wr_content'], $html);

    $file = '';
	if($row['as_img'] == "2") { // 본문삽입
		$row['wr_content'] = preg_replace_callback("/{이미지\:([0-9]+)[:]?([^}]*)}/i", "img_insert_content", $row['wr_content']);
	} else {
		$tmp = get_file($post['bo_table'], $post['wr_id']);

		for ($j=0; $j<count($tmp); $j++) {
			if (isset($tmp[$j]['source']) && $tmp[$j]['source'] && $tmp[$j]['view']) {
				$file .='<p><img src="'.$tmp[$j]['path'].'/'.$tmp[$j]['file'].'"></p>';
			}
		}
	}
?>
<item>
<title><?php echo specialchars_replace('['.$board['bo_subject'].'] '.$row['wr_subject']) ?></title>
<link><?php echo specialchars_replace(G5_BBS_URL.'/board.php?bo_table='.$post['bo_table'].'&wr_id='.$post['wr_id']) ?></link>
<description><![CDATA[<?php echo $file; ?><?php echo $row['wr_content']; ?>]]></description>
<dc:creator><?php echo specialchars_replace($row['wr_name']) ?></dc:creator>
<?php
$date = $row['wr_datetime'];
// rss 리더 스킨으로 호출하면 날짜가 제대로 표시되지 않음
//$date = substr($date,0,10) . "T" . substr($date,11,8) . "+09:00";
$date = date('r', strtotime($date));
?>
<dc:date><?php echo $date ?></dc:date>
</item>

<?php
}

echo '</channel>'."\n";
echo '</rss>'."\n";
?>