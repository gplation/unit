<?php
if (!defined('_GNUBOARD_')) exit;

// APMS Common ------------------------------------------------------------------------

function apms_pack($set) {

	if(!$set) return;

	$arr = array();
	$arr = addslashes(serialize($set));

	return $arr;
}

function apms_unpack($set) {

	if(!$set) return;

	$arr = array();
	$tmp = unserialize($set);
	if(!empty($tmp)) {
		foreach($tmp as $key=>$value) {
			$arr[$key] = str_replace("/r/n/","\r\n", stripslashes(str_replace("\\r\\n","/r/n/",$tmp[$key])));
		}
	}

	return $arr;
}

function apms_boset() {
	global $board;

	$boset = array();

	if($board['bo_skin'] == $board['bo_mobile_skin']) {
		$set = $board['as_set'];
	} else {
		if(G5_IS_MOBILE) {
			$set = ($board['as_mobile_set']) ? $board['as_mobile_set'] : $board['as_set'];
		} else {
			$set = $board['as_set'];
		}
	}

	$boset = apms_unpack($set);

	return $boset;
}

function apms_query($str) {

	$str = stripcslashes($str);

	preg_match_all('@(?P<attribute>[^\s\'\"]+)\s*=\s*(\'|\")?(?P<value>[^\s\'\"]+)(\'|\")?@i', $str, $match);
    if (function_exists('array_combine')) {
        $value = @array_change_key_case(array_combine($match['attribute'], $match['value']));
    } else {
        $value = @array_change_key_case(amina_array_combine4($match['attribute'], $match['value']));
    }
	return $value;
}

// Sort Array
function apms_sort($Ary, $field, $reverse=false) {

	if(!count($Ary)) return;

	foreach($Ary as $res)
		$sortArr[] = $res[$field];

	($reverse) ? array_multisort($sortArr, SORT_DESC, $Ary) : array_multisort($sortArr, SORT_ASC, $Ary);

	return $Ary;
}

// Skin Path
function apms_skin_path($skin, $dir='') {

	if(file_exists(COLORSET_PATH.$dir.'/'.$skin)) {
		$path = COLORSET_PATH.$dir;
		$url = COLORSET_URL.$dir;
	} else {
		$path = THEMA_PATH.$dir;
		$url = THEMA_URL.$dir;
	}

	$pathurl = array($path, $url);

	return $pathurl;
}

// Member Info
function apms_member($mb_id) {
	global $g5, $xp, $member, $is_admin;

	$info = array();

	if(!$mb_id) {
		$info = $member;
		$info['grade'] = $xp['xp_grade1'];
		$info['level'] = 1;
		$info['exp'] = 0;
		$info['exp_up'] = 0;
		$info['exp_per'] = 0;
		$info['exp_max'] = 0;
		$info['exp_min'] = 0;
		$info['mp'] = 0;
		$info['photo'] = '';
		$info['like'] = 0;
		$info['liked'] = 0;
		$info['follow'] = 0;
		$info['followed'] = 0;
		$info['response'] = 0;
		$info['partner'] = 0;
	} else {
		$info = ($member['mb_id'] == $mb_id) ? $member : sql_fetch(" select * from {$g5['member_table']} where mb_id = TRIM('$mb_id') ", false);
		$info['photo'] = apms_photo_url($mb_id);
		$ml = 'xp_grade'.$info['mb_level'];
		$info['grade'] = $xp[$ml];
        $info['name'] = apms_sideview($mb_id, $info['mb_nick'], $info['mb_email'], $info['mb_homepage'], $info['as_level']);
		$info['like'] = $info['as_like'];
		$info['liked'] = $info['as_liked'];
		$info['follow'] = $info['as_follow'];
		$info['followed'] = $info['as_followed'];
		$info['response'] = $info['as_response'];
		if($is_admin == 'super' && $member['mb_id'] == $mb_id) {
			$info['partner'] = 1;
		} else {
			$info['partner'] = $info['as_partner'];
		}

		$info['as_exp'] = ($xp['exp_point']) ? $info['mb_point'] : $info['as_exp'];

		list($info['level'], $info['exp'], $info['exp_min'], $info['exp_max']) = chk_xp_num($info['as_exp'], $xp['xp_point'], $xp['xp_max'], $xp['xp_rate']);

		if($info['level'] != $info['as_level']) list($info['level'], $info['exp'], $info['exp_min'], $info['exp_max']) = check_xp($mb_id);

		if($info['level'] >= $xp['xp_max']) {
			$info['exp_per'] = 100;
			$info['exp_up'] = 0;
		} else {
			$total_exp = $info['exp_max'] - $info['exp_min'];
			$now_exp = $info['exp'] - $info['exp_min'];
			$info['exp_per'] = ($total_exp > 0) ? round(($now_exp / $total_exp) * 100, 1) : 0;
			$info['exp_up'] = $total_exp - $now_exp;
		}	
	}

	//$info['level_icon'] = xp_icon($mb_id, $info['level']);

	return $info;
}

// Alert
function apms_alert($msg) {
    global $g5;

	echo $msg;
	exit;
}

// Alert
function apms_opener($id, $msg='', $url='', $opt='') {
    global $g5;

	$url = str_replace("&amp;", "&", $url);

    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
    echo "<script>";
    if($msg) echo "alert('".$msg."');";
    echo "opener.apms_page('".$id."', '".$url."', '".$opt."');";
    echo "self.close();";
    echo "</script>";
    exit;
}

// Get Text
function apms_get_text($str) {

	$str = strip_tags($str);
	$str = preg_replace("/{지도\:([^}]*)}/ie", "", $str);
	$str = preg_replace("/{이미지\:([^}]*)}/ie", "", $str);
	$str = preg_replace("/{동영상\:([^}]*)}/ie", "", $str);
	$str = preg_replace("/{아이콘\:([^}]*)}/ie", "", $str);
	$str = preg_replace("/{이모티콘\:([^}]*)}/ie", "", $str);
	$str = preg_replace("/\[soundcloud([^\]]*)\]/ie", "", $str);
	$str = preg_replace("/\[code=([^\]]*)\]/ie", "", $str);
	$str = str_replace(array("&nbsp;", "[code]", "[/code]", "[map]", "[/map]"), array("", "", "", "", ""), $str);
	$str = preg_replace('/\s\s+/', ' ', $str);
	$str = trim($str);

	return $str;
}

// Cut Text
function apms_cut_text($str, $len, $suffix="…") {
	$str = apms_get_text($str);
	$arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    $str_len = count($arr_str);

    if ($str_len >= $len) {
        $slice_str = array_slice($arr_str, 0, $len);
        $str = join("", $slice_str);
        return $str . ($str_len > $len ? $suffix : '');
    } else {
        $str = join("", $arr_str);
    }

	return $str;
}

// UTF-8 확장 커스텀 함수 - http://jmnote.com/wiki/Utf8_ord
function apms_utf8_ord($ch) {
	$len = strlen($ch);
	if($len <= 0) return false;
	$h = ord($ch{0});
	if($h <= 0x7F) return $h;
	if($h < 0xC2) return false;
	if($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
	if($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);
	if($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
	return false;
}

 // UTF-8 한글 초성 추출 - http://jmnote.com/wiki/UTF-8_%ED%95%9C%EA%B8%80_%EC%B4%88%EC%84%B1_%EB%B6%84%EB%A6%AC_(PHP)
function apms_chosung($str) {

	$result = array();

	//$cho = array("가","까","나","다","따","라","마","바","빠","사","싸","아","자","짜","차","카","타","파","하");
	//$cho = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
	//$cho = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18");

	$cho = array("가","가","나","다","다","라","마","바","바","사","사","아","자","자","차","카","타","파","하");
	$str = mb_substr($str,0,1,"UTF-8");
	$code = apms_utf8_ord($str) - 44032;
	if ($code > -1 && $code < 11172) {
		$cho_idx = $code / 588;
		$result[0] = 0; //한글
		$result[1] = $cho[$cho_idx];
	} else {
		$str = strtoupper($str); //대문자로 변경
		if(preg_match("/[0-9]+/i", $str)) {
			$result[0] = 2; //숫자
			$result[1] = $str;
		} else if(preg_match("/[A-Z]+/i", $str)) {
			$result[0] = 1; //영어
			$result[1] = $str;
		} else {
			$result[0] = 3; //특수문자
			$result[1] = addslashes($str);
		}
	}

	return $result;
}

// Check Tag
function apms_check_tag($tag) {

	$tag = str_replace(array("\"", "'"), array("", ""), $tag);

	if(!$tag) return;
	
	$list = array();
	$arr = explode(',', $tag);
	foreach($arr as $tmp) {
		$tmp = trim($tmp);
		if(!$tmp) continue;
		$list[] = $tmp;
	}

	if(count($list) == 0) return;

	$list = array_unique($list);

	$str = implode(',', $list);

	return $str;
}

// Delete Tag
function apms_delete_tag($it_id, $bo_table, $wr_id) {
    global $g5;

    $tag = array();
	if($it_id) {
	    $result = sql_query("select tag_id from {$g5['apms_tag_log']} where it_id = '{$it_id}' ");
	    while ($row = sql_fetch_array($result)) {
			sql_query("update {$g5['apms_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
	    }
		sql_query("delete from {$g5['apms_tag_log']} where it_id = '{$it_id}'");
	} else if($bo_table && $wr_id) {
	    $result = sql_query("select tag_id from {$g5['apms_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	    while ($row = sql_fetch_array($result)) {
			sql_query("update {$g5['apms_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
	    }
		sql_query("delete from {$g5['apms_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}'");
	}
	return;
}

// Add Tag
function apms_add_tag($it_id, $it_tag, $it_time, $bo_table='', $wr_id='') {
    global $g5;

	$arr = array();

	// 기존 태그 삭제
	apms_delete_tag($it_id, $bo_table, $wr_id);

	//카운팅이 0 또는 음수인 태그 삭제
	sql_query("delete from {$g5['apms_tag']} where cnt <= '0'");

	//태그정리
	$it_tag = apms_check_tag($it_tag);

	if(!$it_tag) return;

	//태그등록
	$tags = explode(',', $it_tag);
	foreach($tags as $tag) {
		$row = sql_fetch("select id from {$g5['apms_tag']} where tag = '{$tag}' ");
		if ($row['id']) {
			$tag_id = $row['id'];
			sql_query("update {$g5['apms_tag']} set cnt = cnt + 1, lastdate='".G5_TIME_YMDHIS."' where id='{$tag_id}'");
		} else {
			//색인 만들기
			list($type, $idx) = apms_chosung($tag);
			sql_query("insert into {$g5['apms_tag']} set type = '{$type}', idx = '{$idx}', tag='".addslashes($tag)."', cnt=1, regdate='".G5_TIME_YMDHIS."', lastdate='".G5_TIME_YMDHIS."'");
			$tag_id = mysql_insert_id();
		} 

		sql_query("insert into {$g5['apms_tag_log']} set it_id = '{$it_id}', bo_table = '{$bo_table}', wr_id = '{$wr_id}', tag_id = '{$tag_id}', tag = '".addslashes($tag)."', regdate = '".G5_TIME_YMDHIS."', it_time = '$it_time'");
	}
}

// Get Tag
function apms_get_tag($it_tag) {

	if(!$it_tag) return;

	$tag = array();
	$tag = explode(",", $it_tag);

	$sec = ', ';
	$list = '';
    foreach($tag as $val) {
		$val = trim($val);
		$list .= '<a href="'.G5_BBS_URL.'/tag.php?q='.urlencode($val).'" rel="tag">'.$val.'</a>'.$sec;
	}

	$list = substr($list, 0, strlen($list)-strlen($sec));

    return $list;
}

// Get Star
function apms_get_star($avg) {

	$star = '';
	list($star_s, $star_m) = explode(".", $avg);
	$star_e = ($star_m) ? 4 - $star_s : 5 - $star_s; 
	for($j=0; $j < $star_s; $j++) {
		$star .= '<i class="fa fa-star"></i>';
	}
	if($star_m) $star .= '<i class="fa fa-star-half-empty"></i>';
	for($j=0; $j < $star_e; $j++) {
		$star .= '<i class="fa fa-star-o"></i>';
	}

	return $star;
}

// Post Star
function apms_post_star($list) {

	$score = $cnt = 0;
	if($list['as_star_cnt'] > 0) {
		$cnt = $list['as_star_cnt'];
		$score = $list['as_star_score'] / $cnt;
	}

	$score = round($score, 1);
	$per = round($score) * 10;
	$star = apms_get_star($score);

	$arr = array("star"=>$star, "score"=>$score, "cnt"=>$cnt, "per"=>$per);

	return $arr;
}

// 확장자 파악하기
function apms_get_ext($str) {
	$f = explode(".", basename($str));
	$l = sizeof($f);
	if($l > 1) {
			return strtolower($f[$l-1]);
	} else {
			return '';
	}
}

function apms_get_filename($str) {

	$file = array();

	$f = explode(".", basename($str));
	$l = sizeof($f);
	if($l > 1) {
		$file['ext'] = strtolower($f[$l-1]);
		$file['name'] = str_replace($f[$l-1], "", $str);
	} else {
		$file['ext'] = '';
		$file['name'] = $str;
	}

	return $file;	
}

// 확장자 종류체크
function apms_check_ext($file) {

	if(!$file) return;

	$video = array("mp4", "m4v", "f4v", "mov", "flv", "webm");
	$caption = array("vtt", "srt", "ttml", "dfxp");
	$audio = array("acc", "m4a", "f4a", "mp3", "ogg", "oga");
	$image = array("jpg", "jpeg", "gif", "png");
	$pdf = array("pdf");
	$torrent = array("torrent");

	$ext = apms_get_ext($file);

	if(in_array($ext, $image)) {
		$chk = 1;
	} else if(in_array($ext, $video)) {
		$chk = 2;
	} else if(in_array($ext, $audio)) {
		$chk = 3;
	} else if(in_array($ext, $pdf)) {
		$chk = 4;
	} else if(in_array($ext, $caption)) {
		$chk = 5;
	} else if(in_array($ext, $torrent)) {
		$chk = 6;
	} else {
		$chk = 0;
	}

	return $chk;
}

// Get File
function apms_get_torrent($attach, $path='') {
    global $g5;

	$arr = array();
	$torrent = array();

	if($path) {
		$j = 0;
		for($i=0; $i < count($attach); $i++) {
			if (isset($attach[$i]['source']) && $attach[$i]['source'] && $attach[$i]['view']) continue;

			$ext = apms_get_ext($attach[$i]['source']);
			if($ext != 'torrent') continue;
			$arr[$j] = $path.'/'.$attach[$i]['file'];
			$j++;
		}
	} else {
		if(!$attach['torrent']) return;

		$j = 0;
		for($i=0; $i < count($attach); $i++) {
			if($attach[$i]['ext'] != "6") continue;
			$arr[$j] = G5_DATA_PATH.'/item/'.$attach[$i]['id'].'/'.$attach[$i]['file'];
			$j++;
		}
	}

	require_once (G5_LIB_PATH.'/apms.torrent.lib.php');

	for ($i=0; $i < count($arr); $i++) {
		$torrent_file = file_get_contents($arr[$i]);
		$torrent_array = BDecode($torrent_file);
		$torrent_hash=sha1(BEncode($torrent_array['info']));
		
		$torrent[$i]['name'] = $torrent_array['info']['name'];
		$torrent[$i]['magnet'] = 'magnet:?xt=urn:btih:'.$torrent_hash;
		for($k=0; $k < count($torrent_array['announce-list']); $k++) {
			$torrent[$i]['tracker'][$k] = $torrent_array['announce-list'][$k][0];
		}
		$torrent[$i]['comment'] = $torrent_array['comment'];
		$torrent[$i]['date'] = $torrent_array['creation date'];
		$torrent[$i]['is_size'] = ($torrent_array['info']['length']) ? true : false;
		if($torrent[$i]['is_size']) {
			$torrent[$i]['info']['name'] = $torrent_array['info']['name'];
			$torrent[$i]['info']['size'] = get_filesize($torrent_array['info']['length']);
		} else {
			$total_size = 0;
			for ($k=0;$k <  count($torrent_array['info']['files']);$k++) {
				for ($l=0;$l < count($torrent_array['info']['files'][$k]['path']); $l++) {
					$torrent[$i]['info']['file'][$k]['name'][$l] = $torrent_array['info']['files'][$k]['path'][$l];
				}
				$torrent[$i]['info']['file'][$k]['size'] = get_filesize($torrent_array['info']['files'][$k]['length']);
				$total_size = $total_size + $torrent_array['info']['files'][$k]['length'];
			}
			$torrent[$i]['info']['total_size'] = get_filesize($total_size);
		}
	}

    return $torrent;
}

// Sort Link
function apms_sort_link($col, $query_string='', $flag='asc') {
    global $ap, $sst, $sod, $sfl, $stx, $page;

    $q1 = ($ap) ? "ap=".$ap."&amp;sst=".$col : "sst=".$col;
    if ($flag == 'asc') {
        $q2 = 'sod=asc';
        if ($sst == $col) {
            if ($sod == 'asc') {
                $q2 = 'sod=desc';
            }
        }
    } else {
        $q2 = 'sod=desc';
        if ($sst == $col) {
            if ($sod == 'desc') {
                $q2 = 'sod=asc';
            }
        }
    }

    $arr_query = array();
    $arr_query[] = $query_string;
    $arr_query[] = $q1;
    $arr_query[] = $q2;
    $arr_query[] = 'sfl='.$sfl;
    $arr_query[] = 'stx='.$stx;
    $arr_query[] = 'page='.$page;
    $qstr = implode("&amp;", $arr_query);

    return "<a href=\"{$_SERVER['PHP_SELF']}?{$qstr}\">";
}

// BS3 Style
function apms_paging($write_pages, $cur_page, $total_page, $url, $add='', $first='<i class="fa fa-angle-double-left"></i>', $prev='<i class="fa fa-angle-left"></i>', $next='<i class="fa fa-angle-right"></i>', $last='<i class="fa fa-angle-double-right"></i>') {

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			$str .= '<li class="disabled"><a>'.$first.'</a></li>';
		} else {
			$str .= '<li><a href="'.$url.'1'.$add.'">'.$first.'</a></li>';
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li><a href="'.$url.($start_page-1).$add.'">'.$prev.'</a></li>';
	} else {
		$str .= '<li class="disabled"><a>'.$prev.'</a></li>'; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li><a href="'.$url.$k.$add.'">'.$k.'</a></li>';
			} else {
				$str .= '<li class="active"><a>'.$k.'</a></li>';
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li><a href="'.$url.($end_page+1).$add.'">'.$next.'</a></li>';
	} else {
		$str .= '<li class="disabled"><a>'.$next.'</a></li>';
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li><a href="'.$url.($total_page).$add.'">'.$last.'</a></li>';
		} else {
			$str .= '<li class="disabled"><a>'.$last.'</a></li>';
		}
	}

	return $str;
}

function apms_ajax_paging($id, $write_pages, $cur_page, $total_page, $url, $add='', $first='<i class="fa fa-angle-double-left"></i>', $prev='<i class="fa fa-angle-left"></i>', $next='<i class="fa fa-angle-right"></i>', $last='<i class="fa fa-angle-double-right"></i>') {

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$ajax = ($css) ? ' class="'.$css.'"' : ''; // Ajax용 클래스

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			$str .= '<li class="disabled"><a>'.$first.'</a></li>';
		} else {
			$str .= '<li><a onclick="apms_page(\''.$id.'\', \''.$url.'1'.$add.'\', \'1\');" style="cursor:pointer;">'.$first.'</a></li>';
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li><a onclick="apms_page(\''.$id.'\', \''.$url.($start_page-1).$add.'\', \'1\');" style="cursor:pointer;">'.$prev.'</a></li>';
	} else {
		$str .= '<li class="disabled"><a>'.$prev.'</a></li>'; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li><a onclick="apms_page(\''.$id.'\', \''.$url.$k.$add.'\', \'1\');" style="cursor:pointer;">'.$k.'</a></li>';
			} else {
				$str .= '<li class="active"><a>'.$k.'</a></li>';
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li><a onclick="apms_page(\''.$id.'\', \''.$url.($end_page+1).$add.'\', \'1\');" style="cursor:pointer;">'.$next.'</a></li>';
	} else {
		$str .= '<li class="disabled"><a>'.$next.'</a></li>';
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li><a onclick="apms_page(\''.$id.'\', \''.$url.($total_page).$add.'\', \'1\');" style="cursor:pointer;">'.$last.'</a></li>';
		} else {
			$str .= '<li class="disabled"><a>'.$last.'</a></li>';
		}
	}

	return $str;
}

// 불당님의 db_cache 함수 그대로 차용 - 파일캐쉬를 DB로 대신하는 것, $c_code = "latest(simple, gnu4_pack)"
function apms_cache($c_name, $seconds=300, $c_code) {

    global $g5;

    $result = sql_fetch(" select c_name, c_text, c_datetime from {$g5['apms_cache']} where c_name = '$c_name' ", false);
    if (!$result) {
        // 시간을 offset 해서 입력 (-1을 해줘야 처음 call에 캐쉬를 만듭니다)
        $new_time = date("Y-m-d H:i:s", G5_SERVER_TIME - $seconds - 1);
        $result['c_datetime'] = $new_time;
        sql_query(" insert into {$g5['apms_cache']} set c_name='$c_name', c_datetime='$new_time' ", false);
    }

    $sec_diff = G5_SERVER_TIME - strtotime($result['c_datetime']);
    if ($sec_diff > $seconds) {

        // $c_code () 안에 내용만 살림 
        $pattern = "/[()]/";
        $tmp_c_code = preg_split($pattern, $c_code);
        
        // 수행할 함수의 이름
        $func_name = $tmp_c_code[0];

        // 수행할 함수의 인자
		$tmp_array = explode(",", $tmp_c_code[1]);
        
        if ($func_name == "include_once" || $func_name == "include") {

            ob_start();
            @include($tmp_array[0]);
            $c_text = ob_get_contents();
            ob_end_clean();

        } else {
        
        // 수행할 함수의 인자를 담아둘 변수
        $func_args = array();

        for($i=0;$i < count($tmp_array); $i++) {
            // 기본 trim은 여백 등을 없앤다. $charlist = " \t\n\r\0\x0B"
            $tmp_args = trim($tmp_array[$i]);
            // 추가 trim으로 인자를 넘길 때 쓰는 '를 없앤다
            $tmp_args = trim($tmp_args, "'");
            // 추가 trim으로 인자를 넘길 때 쓰는 "를 없앤다
            $func_args[$i] = trim($tmp_args, '"');
        }
        // 새로운 캐쉬값을 만들고
        $c_text = call_user_func_array($func_name, $func_args);
        }

        // 값이 없으면 그냥 return
        if (trim($c_text) == "")
            return;

        // db에 넣기전에 slashes들을 앞에 싹 붙여 주시고
        $c_text1 = addslashes($c_text);
        
        // 새로운 캐쉬값을 업데이트 하고
        sql_query(" update {$g5['apms_cache']} set c_text = '$c_text1', c_datetime='".G5_TIME_YMDHIS."' where c_name = '$c_name' ", false);

        // 새로운 캐쉬값을 return (slashes가 없는거를 return 해야합니다)
        return $c_text;

    } else {

        // 캐쉬한 데이터를 그대로 return
        return $result['c_text'];

    }
}

// 회원 레이어
function apms_sideview($mb_id, $name='', $email='', $homepage='', $level='no', $opt='') {
    global $g5, $config, $bo_table, $sca, $is_admin, $member, $xp;

    $email = base64_encode($email);
	$homepage = set_http(clean_xss_tags($homepage));

	$name = get_text(cut_str($name, $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    $name = preg_replace("/\&#039;/", "", $name);
    $name = preg_replace("/\'/", "", $name);
    $name = preg_replace("/\"/", "&#034;", $name);
    $title_name = $name;

	//레벨아이콘
	if($opt) {
		$xp_icon = ($opt == 'no' || $level == 'no') ? '' : xp_icon($mb_id, $level).' ';
	} else {
		$xp_icon = ($xp['xp_now'] || $level == 'no') ? '' : xp_icon($mb_id, $level).' ';
	}

	$tmp_name = '';
    if ($mb_id) {
        if ($config['cf_use_member_icon']) {
            $mb_dir = substr($mb_id,0,2);
            $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.gif';

            if (file_exists($icon_file)) {
                $width = $config['cf_member_icon_width'];
                $height = $config['cf_member_icon_height'];
                $icon_file_url = G5_DATA_URL.'/member/'.$mb_dir.'/'.$mb_id.'.gif';
                $tmp_name .= '<img src="'.$icon_file_url.'" width="'.$width.'" height="'.$height.'" alt=""> ';

                if ($config['cf_use_member_icon'] == 2) // 회원아이콘+이름
                    $tmp_name = '<span class="member">'.$xp_icon.$tmp_name.$name.'</span>';
            } else {
		        $tmp_name = '<span class="member">'.$xp_icon.$name.'</span>';
			}
        } else {
	        $tmp_name = '<span class="member">'.$xp_icon.$name.'</span>';
		}
        $title_mb_id = '['.$mb_id.']';
    } else {
        if(!$bo_table)
            return $name;

        $tmp_name = '<span class="guest">'.$xp_icon.$name.'</span>';
        $title_mb_id = '[비회원]';
    }

    $name     = get_text($name);
    $email    = get_text($email);
    $homepage = get_text($homepage);

    return "<a href=\"javascript:;\" onClick=\"showSideView(this, '$mb_id', '$name', '$email', '$homepage');\" title=\"{$title_mb_id}{$title_name}\">$tmp_name</a>";
}

// Icon
function apms_icon($str){

	if(!$str || $str == 'none') return;

	list($icon, $opt) = explode(";", $str);
	switch($opt) {
		case 'c' : $str = "<i class='".$icon."'></i>"; break;
		case 't' : $str = $icon; break;
		default	 : $str = "<i class='fa fa-".$icon."'></i>"; break;
	}

	return $str;
}

// FA Icon
function apms_fa($str){
	$str = $str ? preg_replace("/{아이콘\:([^}]*)}/ie", "apms_icon('\\1')", $str) : $str;
	return $str;
}

// Emoticon
function apms_emoticon($str){

	if(!$str) return;

	list($emo, $width) = explode(":", $str);
	if(file_exists(G5_PATH.'/img/emoticon/'.$emo)) {
		$width = ($width > 0) ? $width : 50;
		$icon = '<img src="'.G5_URL.'/img/emoticon/'.$emo.'" width="'.$width.'" alt="" />';
	} else {
		$icon = '';
	}

	return $icon;
}

// Emoticon Icon
function apms_emo($str){
	$str = preg_replace("/{이모티콘\:([^}]*)}/ie", "apms_emoticon('\\1','')", $str); // Emoticon 
	return $str;
}

// 동영상 이미지 주소 가져오기
function apms_video_imgurl($url, $vid, $type) {

	$imgurl = '';
	if($type == "file") { //JWPLAYER
		;
	} else if($type == "vimeo") { //비메오
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/{$vid}.php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = unserialize(curl_exec($ch));
		curl_close($ch);

		$imgurl = $output[0]['thumbnail_large'];

	} else if($type == "youtube") { //유튜브

		$imgurl = 'http://img.youtube.com/vi/'.$vid.'/maxresdefault.jpg';

	} else if($type == "ted" || $type == "daum" || $type == "pandora" || $type == "nate" || $type == "tagstory" || $type == "dailymotion" || $type == "slidershare") {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);

		$direct = '';
		if($type == "slidershare") {
			preg_match('/<meta name=\"thumbnail\"[^\<\>]*\>/i', $output, $video);
		} else {
			preg_match("/<meta[^>]*content=[\'\"]?([^>\'\"]+[^>\'\"]+)[\'\"]?[^>]*property=\"og\:image\"/i", $output, $video);
			$direct = $video[1];
			if(!$direct) {
				preg_match('/property=\"og\:image\"[^\<\>]*\>/i', $output, $video);
			}
		}

		if($direct) {
			$imgurl = $direct;
		} else {
			if($video) {
				$video = apms_query($video[0]);
				$imgurl = $video['content'];
			}
		}

	} else if($type == "facebook"){ //라니안님 코드 반영
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.facebook.com/method/fql.query?query=select%20title,%20thumbnail_link%20from%20video%20where%20vid=".$vid);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);

		preg_match('/\<thumbnail_link\>(?P<img_url>[^\s\'\"]+)\<\/thumbnail_link\>/ie', $output, $video);

		$imgurl = $video['img_url'];

	} else if($type == "naver" || $type == "tvcast"){ //라니안님 코드 반영

		$info = parse_url($url);

		if($info['host'] == "tvcast.naver.com") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);

			preg_match('/property=\"og\:image\"[^\<\>]*\>/i', $output, $video);

			if($video) {
				$video = apms_query($video[0]);
				if($video['content']) $imgurl = str_replace("type=f240", "type=f640", $video['content']); //640 사이즈로 변경
			}
		} else {
			$url_type = ($type == "naver") ? "nmv" : "rmcnmv"; // 네이버 블로그 영상과 tvcast 영상 구분
			parse_str($info['query'], $query); 

			$vid .= "&outKey=".$query['outKey'];
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://serviceapi.{$url_type}.naver.com/flash/videoInfo.nhn?vid={$vid}");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);

			preg_match('/\<CoverImage\>\<\!\[CDATA\[(?P<img_url>[^\s\'\"]+)\]\]\>\<\/CoverImage\>/i', $output, $video);

			$imgurl = $video['img_url'];
		}
	}

	return $imgurl;
}

// 동영상 이미지 가져오기
function apms_video_img($url, $vid, $type) {

	if(!$url || !$vid || !$type) return;

	if($type == 'file') return;

	$no_image = G5_SHOP_PATH.'/img/no_image.gif';

	$video_path = G5_DATA_PATH.'/apms/video';
	$video_url = G5_DATA_URL.'/apms/video';
	$type_path = $video_path.'/'.$type;
	$type_url = $video_url.'/'.$type;

	$code_vid = urldecode($vid);

	$img = $type_path.'/'.$code_vid;
	$no_img = $type_path.'/'.$code_vid.'_none';

	if(file_exists($img)) {
		return $img;
	} else {
		//썸네일 저장폴더
		if(!is_dir($type_path)) {
	        @mkdir($type_path, G5_DIR_PERMISSION);
	        @chmod($type_path, G5_DIR_PERMISSION);
		}

		//동영상 이미지 주소 가져오기
		$imgurl = apms_video_imgurl($url, $vid, $type);

		if($imgurl) {
			$ch = curl_init ($imgurl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); 
			$err = curl_error($ch);
			if(!$err) $rawdata=curl_exec($ch);
			curl_close ($ch);
			if($rawdata) {
				$fp = fopen($img,'w'); 
				fwrite($fp, $rawdata); 
				fclose($fp); 

				@chmod($img, G5_FILE_PERMISSION);

				@unlink($no_img);

				return $img;
			} else {
				if(!file_exists($no_img)) {
					@copy($no_image, $no_img);
					@chmod($no_img, G5_FILE_PERMISSION);
				}

				return 'none';
			}
		} 

		if(!file_exists($no_img)) {
			@copy($no_image, $no_img);
			@chmod($no_img, G5_FILE_PERMISSION);
		}

		return 'none';
	} 

	return 'none';
}

// 동영상 실제 아이디 가져오기
function apms_video_id($url, $vid, $type) {

	$play = array();
	$info = array();
	$query = array();

	if (!$url || !$vid || !$type || ($type == 'file')) return;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);

	if($type == "daum") {
		preg_match('/\<meta property=\"og\:video\"([^\<\>])*\>/i', $output, $video);
		if($video) {
			$video = apms_query($video[0]);
			$$video['content'] = preg_replace("/&amp;/", "&", $video['content']);
			$info = parse_url($video['content']);
			parse_str($info['query'], $query); 
			$play['rid'] = $query['vid'];
		}
	} else if($type == "nate") {
		preg_match('/mov_id = \"([^\"]*)\"/i', $output, $video);
		$play['mov_id'] = $video[0];

		preg_match('/vs_keys = \"([^\"]*)\"/i', $output, $video);
		$play['vs_keys'] = $video[0];

		if($play) {
			$meta = "<meta {$play[mov_id]} {$play[vs_keys]} >";
			$video = apms_query($meta);
			$play['mov_id'] = $video['mov_id'];
			$play['vs_keys'] = $video['vs_keys'];
		}
	} else if($type == "tvcast"){ //라니안님 코드 반영
		preg_match('/nhn.rmcnmv.RMCVideoPlayer\("(?P<vid>[A-Z0-9]+)", "(?P<inKey>[a-z0-9]+)"/i', $output, $video);
		
		$play['vid'] = $video['vid'];
		$play['inkey'] = $video['inKey'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://serviceapi.rmcnmv.naver.com/flash/getExternSwfUrl.nhn?vid=".$video['vid'].'&inKey='.$video['inKey']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		preg_match('/&outKey=(?P<outKey>[a-zA-Z0-9]+)&/i', $output, $video);
		
		$play['outKey']= $video['outKey'];
	} else if($type == "slidershare") {
		preg_match('/\<meta class=\"twitter_player\"([^\<\>])*\>/i', $output, $video);
		if($video) {
			$video = apms_query($video[0]);
			$play['play_url'] = preg_replace("/&amp;/", "&", $video['value']);
			$info = parse_url($play['play_url']);
			$play['vid'] = trim(str_replace("/slideshow/embed_code/","",$info['path'])); 
		}
	}

	return $play;
}

// 동영상 종류 파악
function apms_video_info($video_url) {

	$video = array();
	$query = array();
	$option = array();

	$video_url = trim(strip_tags($video_url));

	list($url, $opt) = explode("|", $video_url);
	
	$url = trim($url);

	if($url) {
		if(!preg_match('/(http|https)\:\/\//i', $url)) {
			$url = 'http:'.$url;
		}
	} else {
		return;
	}

	$video['video'] = str_replace(array("&nbsp;", " "), array("", ""), $url);
	$video['video_url'] = str_replace(array("&nbsp;", "&amp;", " "), array("", "&", ""), $url);

	if($opt) $option = apms_query($opt);

	if($option['file']) { //jwplayer
		$video['type'] = 'file';
		$video['vid'] = 'file';
		$video['img'] = ($option['img']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['img']))) : '';
		$video['caption'] = ($option['caption']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['caption']))) : '';
	} else {
		$info = parse_url($video['video_url']); 
		if($info['query']) parse_str($info['query'], $query); 

		if($info['host'] == "youtu.be") { //유튜브
			$video['type'] = 'youtube';
			$video['vid'] = trim(str_replace("/","",$info['path']));
			$video['vid'] = substr($video['vid'], 0, 11);
			$video['vlist'] = $query['list'];
			$video['auto'] = ($option['auto']) ? $option['auto'] : $query['autoplay'];
		} else if($info['host'] == "www.youtube.com") { //유튜브
			$video['type'] = 'youtube';
			if(preg_match('/\/embed\//i', $video['video_url'])) {
				list($youtube_url, $youtube_opt) = explode("/embed/", $video['video_url']);
				$vids = explode("?", $youtube_opt);
				$video['vid'] = $vids[0];
			} else {
				$video['vid'] = $query['v'];;
				$video['vlist'] = $query['list'];
			}
		} else if($info['host'] == "vimeo.com") { //비메오
			$video['type'] = 'vimeo';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			list($video['vid']) = explode("#",$vquery[$num]);
		} else if($info['host'] == "www.ted.com") { //테드
			$video['type'] = 'ted';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			list($video['vid']) = explode(".", $vquery[$num]);
			$video['rid'] = trim($info['path']);
		} else if($info['host'] == "tvpot.daum.net") { //다음tv
			$video['type'] = 'daum';
			if($query['vid']) {
				$video['vid'] = $query['vid'];
				$video['rid'] = $video['vid'];
			} else {
				if($query['clipid']) {
					$video['vid'] = $query['clipid'];
				} else {
					$video['vid'] = trim(str_replace("/v/","",$info['path']));
				}
				$play = apms_video_id($video['video_url'], $video['vid'], $video['type']);
				$video['rid'] = $play['rid'];
			}
		} else if($info['host'] == "channel.pandora.tv") { //판도라tv
			$video['type'] = 'pandora';
			$video['ch_userid'] = $query['ch_userid'];
			$video['prgid'] = $query['prgid'];
			$video['vid'] = $video['ch_userid'].'_'.$video['prgid'];
		} else if($info['host'] == "pann.nate.com") { //네이트tv
			$video['type'] = 'nate';
			$video['vid'] = trim(str_replace("/video/","",$info['path'])); 
			$play = apms_video_id($video['video_url'], $video['vid'], $video['type']);
			$video['mov_id'] = $play['mov_id'];
			$video['vs_keys'] = $play['vs_keys'];
		} else if($info['host'] == "www.tagstory.com") { //Tagstory
			$video['type'] = 'tagstory';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			$video['vid'] = $vquery[$num];
		} else if($info['host'] == "www.dailymotion.com") { //Dailymotion
			$video['type'] = 'dailymotion';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			list($video['vid']) = explode("_", $vquery[$num]);
		} else if($info['host'] == "www.facebook.com") { //Facebook - 라니안님 코드 반영
			$video['type'] = 'facebook';
			if($query['video_id']){
				$video['vid'] = $query['video_id'];
			}else {
				$video['vid'] = $query['v'];
			}		
			if(!is_numeric($video['vid'])) $video = NULL;
		} else if($info['host'] == "serviceapi.nmv.naver.com") { // 네이버 - 라니안님 코드 반영
			$video['type'] = 'naver';
			$video['vid'] = $query['vid'];
			$video['outKey'] = $query['outKey'];
		} else if($info['host'] == "serviceapi.rmcnmv.naver.com") { // 네이버 - 라니안님 코드 반영
			$video['type'] = 'tvcast';
			$video['vid'] = $query['vid'];
			$video['outKey'] = $query['outKey'];
		} else if($info['host'] == "tvcast.naver.com") { // 네이버 tvcast 단축주소 - 라니안님 코드 반영
			$video['type'] = 'tvcast';
			$video['clipNo'] = trim(str_replace("/v/","",$info['path'])); 
			$play = apms_video_id($video['video_url'], $video['clipNo'], $video['type']);
			$video['vid'] = $play['vid'];
			$video['outKey'] = $play['outKey'];
		} else if($info['host'] == "www.slideshare.net") { // slidershare
			$video['type'] = 'slidershare';
			$play = apms_video_id($video['video_url'], 1, $video['type']);
			$video['play_url'] = $play['play_url'];
			$video['vid'] = $play['vid'];
		}
	}

	return $video;
}

//Show Video Player
function apms_autosize() {
	if(!defined('APMS_AUTOSIZE')) {
		define('APMS_AUTOSIZE', true);
		echo '<style>'.PHP_EOL;
		echo '.apms-autowrap { margin:0 auto 15px; max-width:'.APMS_SIZE.'; }'.PHP_EOL;
		echo '.apms-autosize { position:relative; height: 0; padding-bottom: 56.25%; overflow: hidden; margin:0; }'.PHP_EOL;
		echo '.apms-autosize iframe, .apms-autosize object, .apms-autosize embed { position: absolute; top: 0; left: 0; width: 100%; height:100%; }'.PHP_EOL;
		echo '</style>'.PHP_EOL;
	}
}

// Caption Check
function apms_get_caption($attach, $filename, $num) {

	if(!$filename) return;

	$c_arr = array();
	$i_arr = array();
	$e_arr = array();

	$caption = array("vtt", "srt", "ttml", "dfxp");
	$image = array("jpg", "jpeg", "gif", "png");

	for ($i=0; $i < $attach['count']; $i++) {

		if($i == $num) continue;

		$file = apms_get_filename($attach[$i]['source']);

		if($filename == $file['name']) {
			$fileurl = $attach[$i]['path'].'/'.$attach[$i]['file'];
			if(in_array($file['ext'], $caption)) {
				$c_arr[] = $fileurl;
			} else if(in_array($file['ext'], $image)) {
				$i_arr[] = $fileurl;
				$e_arr[] = $i;
			}
		}
	}

	// 제외번호는 배열로 다 넘김
	$arr = array($i_arr[0], $c_arr[0], $e_arr);

	return $arr;
}

// JWPlayer List
function apms_jwplayer_list($url) {

	if(!$url) return;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$xml = trim(curl_exec($ch));
	curl_close($ch);

	if(!$xml) return;

	preg_match_all("/<item>(.*)<\/item>/iUs", $xml, $matchs);

	return count($matchs[1]);
}

// JWPlayer
function apms_jwplayer($file, $img='', $caption=''){
	
	if(!$file) return;

	$video = array("mp4", "m4v", "f4v", "mov", "flv", "webm");
	$audio = array("acc", "m4a", "f4a", "mp3", "ogg", "oga");
	$ext = apms_get_ext($file);
	if($ext == "rss") {
		$is_type = 'plist';
		$cnt = apms_jwplayer_list($file);
		if($cnt > 0) {
			;
		} else {
			return;
		}
	} else if(in_array($ext, $audio)) {
		$is_type = 'audio';
	} else if(in_array($ext, $video)) {
		$is_type = 'video';
	} else {
		return;
	}

	if($img == 'check') return $is_type;

	$jw_id = apms_id();
	$jwplayer_script = '';	
	if($is_type == 'audio' && !$img && !$caption) {
		$jwplayer_script .= '<script type="text/javascript">
					    jwplayer("'.$jw_id.'").setup({
							file: "'.$file.'",
							width: "100%",
							height: "40",
							repeat: "file"
						});
					 </script>'.PHP_EOL;
	} else if($is_type == 'plist') {
		$plist_set = 'aspectratio: "16:9"';
		if($cnt > 1) {
			$plist_set = G5_IS_MOBILE ? 'aspectratio: "16:9", listbar: { position: "right", size:150 }' : 'aspectratio: "16:9", listbar: { position: "right", size:200 }';
		}
		$jwplayer_script .= '<script type="text/javascript">
						jwplayer("'.$jw_id.'").setup({
							playlist: "'.$file.'",
							width: "100%",
							'.$plist_set.'
						});
					 </script>'.PHP_EOL;
	} else {
		$img = $img ? 'image: "'.$img.'",' : '';
		$caption = $caption ? 'tracks: [{file: "'.$caption.'"}],' : '';
		$jwplayer_script .= '<script type="text/javascript">
						jwplayer("'.$jw_id.'").setup({
							file: "'.$file.'",
							'.$img.'
							'.$caption.'
							aspectratio: "16:9",
							width: "100%"
						});
					 </script>'.PHP_EOL;
	}

	$jwplayer = '';
	if($jwplayer_script) {
		if(!defined('APMS_JWPLAYER6')) {
			define('APMS_JWPLAYER6', true);
			$jwplayer .= '<script type="text/javascript" src="'.G5_PLUGIN_URL.'/jwplayer/jwplayer.js"></script>'.PHP_EOL;
			$jwplayer .= '<script type="text/javascript">jwplayer.key="'.APMS_JWPLAYER6_KEY.'";</script>'.PHP_EOL;
		}
		$jwplayer .= '<div id="'.$jw_id.'">Loading the player...</div>'.PHP_EOL;
		$jwplayer .= $jwplayer_script;
		$jwplayer .= '<div class="h15"></div>'.PHP_EOL;
	}

	return $jwplayer;
}

//Show Video Player
function apms_video($vid) {
	global $autoplayvideo;

	$video = array();
	$vid = str_replace("&nbsp;", " ", $vid);
	$video = apms_video_info($vid);

	switch($video['type']) {
		case 'vimeo'		: $video['width'] = 717; $video['height'] = 403; break;
		case 'nate'			: $video['width'] = 640; $video['height'] = 384; break;
		case 'tagstory'		: $video['width'] = 720; $video['height'] = 480; break;
		case 'tvcast'		: $video['width'] = 720; $video['height'] = 410; break;
		case 'naver'		: $video['width'] = 720; $video['height'] = 438; break;
		case 'slidershare'	: $video['width'] = 425; $video['height'] = 355; break;
		default				: $video['width'] = 640; $video['height'] = 360; break;
	}

	$ratio = round(($video['height'] / $video['width']), 4) * 100;

	$video_show = '';

	if($video['type'] == "file") { //JWPLAYER
		$show = apms_jwplayer($video['video'], $video['img'], $video['caption']);

		if($show) return $show;

	} else {
		if($video['type'] == "youtube") { //유튜브
			$vlist = $video['vlist'] ? '&list='.$video['vlist'] : '';
			$autoplay = ($autoplayvideo || $video['auto']) ? '&autoplay=1' : '';
			$show = '<iframe width="'.$video['width'].'" height="'.$video['height'].'" src="//www.youtube.com/embed/'.$video['vid'].'?autohide=1&vq=hd720&wmode=opaque'.$vlist.$autoplay.'" frameborder="0" allowfullscreen></iframe>';
		} else if($video['type'] == "vimeo") { //비메오
			$autoplay = ($autoplayvideo || $video['auto']) ? '&amp;autoplay=1' : '';
			$show = '<iframe src="http://player.vimeo.com/video/'.$video['vid'].'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff'.$autoplay.'&amp;wmode=opaque" width="'.$video['width'].'" height="'.$video['height'].'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		} else if($video['type'] == "ted") { //테드
			$show = '<iframe src="http://embed.ted.com'.$video['rid'].'?&wmode=opaque" width="'.$video['width'].'" height="'.$video['height'].'" frameborder="0" scrolling="no" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		} else if($video['type'] == "daum") { //다음TV
			$autoplay = ($autoplayvideo || $video['auto']) ? '&autoPlay=1' : '';
			$show = '<iframe width="'.$video['width'].'" height="'.$video['height'].'" src="http://videofarm.daum.net/controller/video/viewer/Video.html?vid='.$video['rid'].'&play_loc=undefined'.$autoplay.'&wmode=opaque" frameborder="0" scrolling="no"></iframe>';
		} else if($video['type'] == "dailymotion") { //Dailymotion
			$show = '<iframe frameborder="0" width="'.$video['width'].'" height="'.$video['height'].'" src="http://www.dailymotion.com/embed/video/'.$video['vid'].'?&wmode=opaque"></iframe>';
		} else if($video['type'] == "pandora") { //판도라TV
			if($video['auto']) $auto = "&amp;autoPlay=true";
			$show = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'.$video['width'].'" height="'.$video['height'].'" id="movie" align="middle">';
			$show .= '<param name="quality" value="high" /><param name="movie" value="http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid='.$video['ch_userid'].'&amp;prgid='.$video['prgid'].'&amp;skin=1'.$auto.'&amp;share=on&countryChk=ko" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="wmode" value="transparent" />';
			$show .= '<embed src="http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid='.$video['ch_userid'].'&amp;prgid='.$video['prgid'].'&amp;skin=1'.$auto.'&amp;share=on&countryChk=ko" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" width="'.$video['width'].'" height="'.$video['height'].'" /></embed></object>';
		} else if($video['type'] == "nate") { //네이트TV
			$autoplay = ($autoplayvideo || $video['auto']) ? '&autoPlay=1' : '';
			$show = '<object id="skplayer" name="skplayer" width="'.$video['width'].'" height="'.$video['height'].'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9.0.115.00">';
			$show .= '<param name="movie" value="http://v.nate.com/v.sk/movie/'.$video[vs_keys].'/'.$video[mov_id].$autoplay.'" /><param name="allowFullscreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="transparent" />';
			$show .= '<embed src="http://v.nate.com/v.sk/movie/'.$video['vs_keys'].'/'.$video['mov_id'].'" wmode="transparent" allowScriptAccess="always" allowFullscreen="true" name="skplayer" width="'.$video['width'].'" height="'.$video['height'].'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
		} else if($video['type'] == "tagstory") { //Tagstory
			$show = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,16,0" width="'.$video['width'].'" height="'.$video['height'].'" id="ScrapPlayer" >';
			$show .= '<param name="movie" value="http://www.tagstory.com/player/basic/'.$video['vid'].'" /><param name="wmode" value="transparent" /><param name="quality" value="high" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="allowFullScreen" value="true" />';
			$show .= '<embed src="http://www.tagstory.com/player/basic/'.$video[vid].'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,16,0" id="ScrapPlayer" name="ScrapPlayer" width="'.$video['width'].'" height="'.$video['height'].'" wmode="transparent" quality="high" allowScriptAccess="always" allowNetworking="all" allowFullScreen="true" /></object>';
		} else if($video['type'] == "slidershare"){ // SliderShare
			$show = '<iframe src="'.$video['play_url'].'" width="'.$video['width'].'" height="'.$video['height'].'" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" allowfullscreen></iframe>';
		} else if($video['type'] == "facebook"){ // Facebook - 라니안님 코드 반영
			$show = '<iframe src="https://www.facebook.com/video/embed?video_id='.urlencode($video['vid']).'" width="'.$video['width'].'" height="'.$video['height'].'" frameborder="0"></iframe>';
		} else if($video['type'] == "naver"){ // Naver - 라니안님 코드 반영
			$autoplay = ($autoplayvideo || $video['auto']) ? '&isp=1' : '';
			$show = '<iframe width="'.$video['width'].'" height="'.$video['height'].'" src="http://serviceapi.nmv.naver.com/flash/convertIframeTag.nhn?vid='.$video['vid'].'&outKey='.$video['outKey'].$autoplay.'" frameborder="no" scrolling="no"></iframe>';
		} else if($video['type'] == "tvcast"){ // Naver Tvcast - 라니안님 코드 반영
			$autoplay = ($autoplayvideo || $video['auto']) ? '&isp=1' : '';
			$show = '<iframe width="'.$video['width'].'" height="'.$video['height'].'" src="http://serviceapi.rmcnmv.naver.com/flash/outKeyPlayer.nhn?vid='.$video['vid'].'&outKey='.$video['outKey'].'&controlBarMovable=true&jsCallable=true&skinName=tvcast_black'.$autoplay.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
		}

		if($show) {
			apms_autosize();
			$video_show .= '<div class="apms-autowrap"><div class="apms-autosize" style="padding-bottom: '.$ratio.'%;">'.PHP_EOL;
			$video_show .= $show.PHP_EOL;
			$video_show .= '</div></div>'.PHP_EOL;
		}
	}

	return $video_show;
}

//Show SoundCloud
function apms_soundcloud($str) {

	$str = strip_tags($str);
	$str = str_replace('\"', '', $str);

	if(!$str) return;

	$cloud = array();
	$cloud = apms_query($str);
	$cloud['params'] = $cloud['params'] ? '&'.str_replace("&amp;", "&", $cloud['params']) : '';
	$show_sound = '';
	if(preg_match('/api.soundcloud.com/i', $cloud['url'])) {
		$show_sound = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($cloud['url']).$cloud['params'].'"></iframe>'.PHP_EOL;
	}

	return $show_sound;
}

//Syntaxhighlighter
function apms_syntaxhighlighter($m) {

	$str = $m[3];

	if(!$str) return;

	$str = str_replace(array("<br>", "<br/>", "<br />", "<div>", "</div>", "<p>", "</p>", "&nbsp;"), array("\n", "\n", "\n", "", "", "\n", "", "\t"), $str);
	$str = apms_get_html(stripslashes($str), 1);

	if(!$str) return;

	$brush = strtolower(trim($m[2]));
	$brush_arr = array('css', 'js', 'jscript', 'javascript', 'php', 'xml', 'xhtml', 'xslt', 'html');
	$brush = ($brush && in_array($brush, $brush_arr)) ? $brush : 'html';

	apms_script('code');

	return '<pre class="brush: '.$brush.';">'.$str.'</pre>'.PHP_EOL;
}

//Google Map
function apms_google_map($geo_data) {

	$geo_data = stripslashes($geo_data);

	if(!$geo_data) return;
	
	$map = array();
	$map = apms_query($geo_data);

	if($map['loc']) {
		list($lat, $lng) = explode(",", $map['loc']);
		$zoom = $map['z'];
	} else {
		list($lat, $lng, $zoom) = explode(",", $map['geo']);
	}
	
	if(!$lat || !$lng) return;

	//Map
	$map['geo'] = $lat.','.$lng.','.$zoom;

	//Marker
	preg_match("/m=\"([^\"]*)\"/ie", $geo_data, $marker);
	$map['m'] = $marker[1];

	$google_map = '<div style="width:100%; margin:0 auto 15px; max-width:'.APMS_SIZE.';">'.PHP_EOL;
	$google_map .= '<iframe width="100%" height="480" src="'.G5_BBS_URL.'/google.map.php?geo='.urlencode($map['geo']).'&marker='.urlencode($map['m']).'" frameborder="0" scrolling="no"></iframe>'.PHP_EOL;
	$google_map .= '</div>'.PHP_EOL;

	return $google_map;
}

// Date & Time
function apms_datetime($date, $type='m.d') {

	$diff = G5_SERVER_TIME - $date;

	$s = 60; //1분 = 60초
	$h = $s * 60; //1시간 = 60분
	$d = $h * 24; //1일 = 24시간
	$y = $d * 10; //1년 = 1일 * 10일

	$time = date($type, $date);
	

	return $time;
}

//Show Contents
function apms_content($explan) {

	$explan = preg_replace("/{지도\:([^}]*)}/ie", "apms_google_map('\\1')", $explan); // Google Map
	$explan = preg_replace("/{동영상\:([^}]*)}/ie", "apms_video('\\1')", $explan); // Video
	$explan = preg_replace("/\[soundcloud([^\]]*)\]/ie", "apms_soundcloud('\\1')", $explan); // SoundCloud
	$explan = preg_replace("/{아이콘\:([^}]*)}/ie", "apms_icon('\\1')", $explan); // FA Icon
	$explan = preg_replace("/{이모티콘\:([^}]*)}/ie", "apms_emoticon('\\1','')", $explan); // Emoticon 
	$explan = preg_replace_callback("/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs", "apms_syntaxhighlighter", $explan); // SyntaxHighlighter

	return $explan;
}


// Load Member Photo
function apms_photo_url($mb_id) {

	if(!$mb_id) return;
	
	$mb_dir = substr($mb_id,0,2);

	$photo_url = G5_DATA_URL.'/apms/photo/'.$mb_dir.'/'.$mb_id.'.jpg';
	$photo_file = G5_DATA_PATH.'/apms/photo/'.$mb_dir.'/'.$mb_id.'.jpg';

	if(!file_exists($photo_file)) return;

	return $photo_url;
}

// Upload Member Photo
function apms_photo_upload($mb_id, $del_photo, $file) {
	global $g5, $xp;

	if(!$mb_id) return;

	//Photo Size
	$photo_w = $xp['xp_photo'] ? $xp['xp_photo'] : 80;
	$photo_h = $photo_w;

	$photo_dir = G5_DATA_PATH.'/apms/photo/'.substr($mb_id,0,2);
	$temp_dir = G5_DATA_PATH.'/apms/photo/temp';

	if(!is_dir($photo_dir)) {
        @mkdir($photo_dir, G5_DIR_PERMISSION);
        @chmod($photo_dir, G5_DIR_PERMISSION);
	}

	if(!is_dir($temp_dir)) {
        @mkdir($temp_dir, G5_DIR_PERMISSION);
        @chmod($temp_dir, G5_DIR_PERMISSION);
	}

	//Delete Photo
	if ($del_photo == "1") {
		@unlink($photo_dir.'/'.$mb_id.'.jpg');
		sql_query(" update {$g5['member_table']} set as_photo = '0' where mb_id = '$mb_id' ", false);
	}
    
	//Upload Photo
	if (is_uploaded_file($file['mb_icon2']['tmp_name'])) {
		if (!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $file['mb_icon2']['name'])) {
			alert($file['mb_icon2']['name'].'은(는) 이미지(gif/jpg/png) 파일이 아닙니다.');
		} else {
			$filename  = $file['mb_icon2']['name'];
			$filename  = preg_replace('/(<|>|=)/', '', $filename);
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
			shuffle($chars_array);
			$shuffle = implode('', $chars_array);
			$filename = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

			$org_photo = $photo_dir.'/'.$mb_id.'.jpg';
			$temp_photo = $temp_dir.'/'.$filename;

			move_uploaded_file($file['mb_icon2']['tmp_name'], $temp_photo) or die($file['mb_icon2']['error']);
			chmod($temp_photo, G5_FILE_PERMISSION);
			if(file_exists($temp_photo)) {
			    $size = @getimagesize($temp_photo);

			    //Non Image
				if (!$size[0]) {
					@unlink($temp_photo);
					alert('회원사진 등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.');
				}			

				//Animated GIF
	            $is_animated = false;
	            if($size[2] == 1) {
	                $is_animated = is_animated_gif($temp_photo);
		        }

				if($is_animated) {
					@unlink($temp_photo);
					alert('움직이는 GIF 파일은 회원사진으로 등록할 수 없습니다.');
				} else {
					$thumb = thumbnail($filename, $temp_dir, $temp_dir, $photo_w, $photo_h, false, true, 'center', true, $um_value='80/0.5/3');
					if($thumb) {
						copy($temp_dir.'/'.$thumb, $org_photo);
						chmod($org_photo, G5_FILE_PERMISSION);
						@unlink($temp_dir.'/'.$thumb);
						@unlink($temp_photo);
						sql_query(" update {$g5['member_table']} set as_photo = '1' where mb_id = '$mb_id' ", false);
					} else {
						@unlink($temp_photo);
						alert('회원사진 등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.', AMINA_URL.'/mb.photo.php');
					}
				}
			}
		}
	}
}

// Check XP 
function check_xp($mb_id) {
	global $g5, $xp;

	$info = array();

	if(!$mb_id) return;

	//Member Info
	$row = sql_fetch(" select mb_point, as_level from {$g5['member_table']} where mb_id = '$mb_id' ", false);
	$point = $row['mb_point'];
	$now_level = $row['as_level'];

	if($xp['exp_point']) { //현재 포인트
		;
	} else {
		$rule_table = "";
		if($xp['exp_login']) $rule_table .= "'@login',";
		if($xp['exp_chulsuk']) $rule_table .= "'@chulsuk',";
		if($xp['exp_delivery']) $rule_table .= "'@delivery',";
		if($rule_table) $rule_table = " or po_rel_table in (".substr($rule_table,0,-1).")";

		$rule_action = "";
		if($xp['exp_write']) $rule_action .= "'쓰기',";
		if($xp['exp_comment']) $rule_action .= "'댓글',";
		if($xp['exp_read']) $rule_action .= "'읽기',";
		if($xp['exp_good']) $rule_action .= "'@good',";
		if($xp['exp_nogood']) $rule_action .= "'@nogood',";
		if($rule_action) $rule_action = " or po_rel_action in (".substr($rule_action,0,-1).")";

		$row = sql_fetch(" select SUM(po_point) as point from {$g5['point_table']} where mb_id = '$mb_id' and ( po_content like '%\[exp\]%'{$rule_table}{$rule_action}) ", false);
		$point = $row['point'];
	}

	//Caculate Level
	list($level, $point, $min_xp, $max_xp) = chk_xp_num($point, $xp['xp_point'], $xp['xp_max'], $xp['xp_rate']);

	//Is_member_level
	$level_msg = 0;
	if($now_level != $level) {
		//Level Gap
		$level_gap = $level - $now_level;
		if($level_gap > 0) { //Level Up
			$level_msg = 1;
		} else if($level_gap < 0) { //Level Down
			$level_msg = 2;
		}
	}

	//Update Member Info
	sql_query(" update {$g5['member_table']} set as_msg = '$level_msg', as_level = '$level', as_exp = '$point' where mb_id = '$mb_id' ", false);

	$info = array($level, $point, $min_xp, $max_xp);

	return $info;
}

// Change XP 
function change_xp($mb_id, $level) {
	global $g5, $xp;

	if(!$mb_id || !is_numeric($level)) return;

	// 보드
    $result = sql_query(" select bo_table from `{$g5['board_table']}` ");
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		sql_query(" update `{$g5['write_prefix']}{$row['bo_table']}` set as_level = '$level' where mb_id = '$mb_id' and as_level <> '$level' ", false); // 게시물
    }

	if(IS_YC) {	
		// 상품댓글
		sql_query(" update `{$g5['apms_comment']}` set wr_level = '$level' where mb_id = '$mb_id' and wr_level <> '$level' ", false); // 상품댓글
	}

	return;
}

// Calculate Level
function xp_level($mb_id='') {
	global $member, $xp;

	$mb_id = $mb_id ? $mb_id : $member['mb_id'];
	if($mb_id) {
		$level = $member['as_level'];
		if($level > 0) {
			list($chk_level) = chk_xp_num($member['as_exp'], $xp['xp_point'], $xp['xp_max'], $xp['xp_rate']);
			if($level != $chk_level) list($level) = check_xp($mb_id);
		} else {
			list($level) = check_xp($mb_id);
		}
	} else {
		$level = 1;
	}

	return $level;
}

// XP Level Icon
function xp_icon($xp_id, $xp_level, $opt='') {
	global $g5, $xp;

	$xp_icon = '';
	if($xp_id == "@member") {
		$xp_icon = $xp_level;
	} else {
		if(!$xp_id) {
			$xp_icon = 'guest';
		} else {
			$mb_admin = true;
			$no_admin = explode(",", trim($xp['xp_except'])); //관리자 제외 아이디
			for($i = 0; $i < count($no_admin); $i++) {
				if($xp_id == $no_admin[$i]) {
					$mb_admin = false;
					break;
				}
			}

			$chk_admin = $mb_admin ? is_admin($xp_id) : '';

			if($chk_admin || $xp_id == "@admin") {
				$xp_icon = 'admin';
			} else if($xp_id == "@special") {
				$xp_icon = 'special';
			} else {
				$xp_mb = explode(",", trim($xp['xp_special']));
				for($i = 0; $i < count($xp_mb); $i++) {
					if($xp_id == $xp_mb[$i]) {
						$xp_icon = 'special';
						break;
					}
				}
			}
		}

		if(!$xp_icon) {
			$xp_icon = $xp_level ? $xp_level : 1;
		}
	}

	if($xp['xp_icon'] == 'img') {
		$xp_icon = '<img src="'.G5_URL.'/img/level/'.$xp['xp_icon_skin'].'/'.$xp_icon.'.gif" alt="Level '.$xp_icon.'" />';
	} else {
		switch ($xp_icon) {
			case 'guest'	: $xp_icon = '<span class="lv-icon lv-guest">'.XP_ICON_GUEST.'</span>'; break;
			case 'admin'	: $xp_icon = '<span class="lv-icon lv-admin">'.XP_ICON_ADMIN.'</span>'; break;
			case 'special'	: $xp_icon = '<span class="lv-icon lv-special">'.XP_ICON_SPECIAL.'</span>'; break;
			default			: $xp_icon = '<span class="lv-icon lv-'.$xp_icon.'">'.XP_ICON_LEVEL.$xp_icon.'</span>'; break;
		}
	}

	return $xp_icon;
}

// 접근권한체크
function apms_auth($auth_grade, $auth_equal, $auth_min, $auth_max, $opt='') {
	global $member, $xp;

	$auth = '';

	//Grade
	if($auth_grade > 1) {
		$mg = 'xp_grade'.$auth_grade;
		switch($auth_equal) {
			case '1'	: if($member['mb_level'] != $auth_grade) $auth = $xp[$mg].'등급만 접근가능합니다.'; break;
			default		: if($member['mb_level'] < $auth_grade) $auth = $xp[$mg].'등급이상 접근가능합니다.'; break;
		}
	}

	//Level
	if(!$auth && ($auth_min > 0 || $auth_max > 0)) {
		if($auth_min > 0 && $auth_max > 0) {
			if($member['as_level'] >= $auth_min && $member['as_level'] <= $auth_max) {
				;
			} else {
				$auth = ($auth_min == $auth_max) ? $auth_min.'레벨 회원만 접근가능합니다.' : $auth_min.'레벨부터 '.$auth_max.'레벨까지 회원만 접근가능합니다.';
			}
		} else if($auth_max > 0) {
			if($member['as_level'] > $auth_max) $auth = $auth_max.'레벨이하 회원만 접근가능합니다.';
		} else if($auth_min > 0) {
			if($member['as_level'] < $auth_min) $auth = $auth_min.'레벨이상 회원만 접근가능합니다.';
		}
	}

	//Result
	if($opt) {
		return $auth ? true : false;
	} else {
		if($auth) alert($auth, G5_URL);
	}
}

// Page Auth
function apms_page_thema($id, $type=0) {
	global $g5, $gr_id, $group, $member, $is_guest;

	if(!$id) return;

	$at = array();

	$row = sql_fetch(" select * from {$g5['apms_page']} where html_id = '{$id}' and as_html = '{$type}' ", false);

	$at['title'] = $row['as_title'];
	$at['desc'] = $row['as_desc'];
	$at['shop'] = $row['as_shop'];
	$at['wide'] = $row['as_wide'];
	$at['multi'] = $group['as_multi'];

	if($row['gr_id']) {
		if($gr_id != $row['gr_id']) {
			$group = sql_fetch(" select * from {$g5['group_table']} where gr_id = '{$row['gr_id']}' ", false);
			if($is_admin != 'super' && !$is_guest) {
				$is_admin = (chk_multiple_admin($member['mb_id'], $group['gr_admin'])) ? 'group' : '';
			}
		}
		$at['shop'] = $group['as_shop'];
	}

	if($is_admin == "super" || $is_admin == "group") {
		;
	} else {
		if($row['gr_id']) {

			if($group['as_partner'] && !IS_PARTNER) {
				alert("파트너만 이용가능합니다.", G5_URL);
			}

			if($group['gr_use_access']) {
				if($is_guest) {
					alert("비회원은 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", G5_URL);
				}

				$chk = sql_fetch(" select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$row['gr_id']}' and mb_id = '{$member['mb_id']}' ");
				if (!$chk['cnt']) {
					alert("접근 권한이 없습니다.", G5_URL);
				}
			}

			apms_auth($group['as_grade'], $group['as_equal'], $group['as_min'], $group['as_max']);
		}

		apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max']);
	}

	$at['group'] = ($group['as_'.MOBILE_.'thema']) ? true : false;
	$at['id'] = $group['gr_id'];
	$at['gid'] = ($group['gr_id']) ? $group['gr_id'] : $gr_id;
	$at['name'] = $group['gr_subject'];
	$at['thema'] = $group['as_'.MOBILE_.'thema'];
	$at['colorset'] = $group['as_'.MOBILE_.'color'];
	$at['file'] = $row['as_file'];
	$at['co_id'] = $row['co_id'];

	return $at;
}

// Group Thema
function apms_gr_thema($gr_id='') {
	global $g5, $group;

	if($gr_id) {
		$group = sql_fetch(" select * from {$g5['group_table']} where gr_id = '{$gr_id}' ", false);
	}

	if($group['as_partner'] && !IS_PARTNER) {
		alert("파트너만 이용가능합니다.", G5_URL);
	}

	$at = array();

	$at['title'] = $group['as_title'];
	$at['desc'] = $group['as_desc'];
	$at['shop'] = $group['as_shop'];
	$at['wide'] = $group['as_wide'];
	$at['multi'] = $group['as_multi'];
	$at['group'] = ($group['as_'.MOBILE_.'thema']) ? true : false;
	$at['id'] = $group['gr_id'];
	$at['gid'] = $group['gr_id'];
	$at['name'] = $group['gr_subject'];
	$at['thema'] = $group['as_'.MOBILE_.'thema'];
	$at['colorset'] = $group['as_'.MOBILE_.'color'];

	return $at;
}

// Response
function apms_response($use, $flag, $it_id, $bo_table, $wr_id, $subject, $mb_id, $my_id, $my_name) {
    global $g5;

    if (!$use || !$flag || !$mb_id || ($mb_id && $mb_id == $my_id)) return;

	switch($flag) {
		case 'reply'			: $field = 'reply'; break;
		case 'comment'			: $field = 'comment'; break;
		case 'comment_reply'	: $field = 'comment_reply'; break;
		case 'good'				: $field = 'good'; break;	
		case 'nogood'			: $field = 'nogood'; break;
		case 'use'				: $field = 'use'; break;	
		case 'qa'				: $field = 'qa'; break;
		default					: return; break;
	}

	if($use == 'it') { // 상품
		if(!$it_id) return;
		$where = " mb_id = '$mb_id' and it_id = '$it_id' ";
		$set = "it_id = '$it_id', type = '1', ";
	} else if($use == 'wr') { // 게시물
		if(!$bo_table || !$wr_id) return;
		$where = " mb_id = '$mb_id' and bo_table = '$bo_table' and wr_id = '$wr_id' ";
		$set = "bo_table = '$bo_table', wr_id = '$wr_id', type = '2', ";
	} else if($use == 'qa') { // 1vs1 qa
		if(!$wr_id) return;
		$where = " mb_id = '$mb_id' and wr_id = '$wr_id' ";
		$set = "wr_id = '$wr_id', type = '3', ";
	} else {
		return;
	}
	
	$row = sql_fetch(" select id from {$g5['apms_response']} where $where and confirm <> '1' order by id desc ", false);
	$is_update = ($row['id']) ? true : false;

	if($is_update) {
		$my_sql = ($my_id && $my_name) ? ", my_id = '$my_id', my_name = '$my_name'" : ""; //아이디와 이름도 업데이트
		sql_query(" update {$g5['apms_response']} set {$field}_cnt = {$field}_cnt + 1, regdate = '".G5_TIME_YMDHIS."' $my_sql where id = '{$row['id']}' ", false);
	} else {
		$set .= " mb_id = '$mb_id', my_id = '$my_id', my_name = '$my_name', subject = '".addslashes($subject)."',"; 
		sql_query(" insert into {$g5['apms_response']} set $set {$field}_cnt = '1', regdate = '".G5_TIME_YMDHIS."' ", false);

		if($mb_id) { //내글반응수 업데이트
			sql_query(" update {$g5['member_table']} set as_response = as_response + 1 where mb_id = '{$mb_id}' ", false);
		}
	}

    return;
}

// Response Act
function apms_response_act($id) {
    global $g5;

	if(!$id) return;

	$url = '';
	$row = sql_fetch(" select * from {$g5['apms_response']} where id = '{$id}' ", false);
	if($row['id']) {
		sql_query(" update {$g5['apms_response']} set confirm = '1', regdate = '".G5_TIME_YMDHIS."' where id = '{$id}' ", false);

		if($row['mb_id']) { //내글반응수 업데이트
			sql_query(" update {$g5['member_table']} set as_response = as_response - 1 where mb_id = '{$row['mb_id']}' ", false);
		}

		switch($row['type']) {
			case '1'	: $url = G5_SHOP_URL.'/item.php?it_id='.$row['it_id']; break;
			case '2'	: $url = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id']; break;
			case '3'	: $url = G5_BBS_URL.'/qaview.php?qa_id='.$row['wr_id']; break;
		}
	}

    return $url;
}

// Response Row
function apms_response_row($row, $win='') {
	global $member;

	$list = array();

	$list = $row;

	if($win) {
		$list['href'] = "apms_response('{$member['mb_id']}','{$row['id']}','1'); return false;";
	} else {
		$list['href'] = "apms_response('{$member['mb_id']}','{$row['id']}'); return false;";
	}

	$list['name'] = $row['my_name'];
	$list['date'] = strtotime($row['regdate']);
	$list['photo'] = apms_photo_url($row['my_id']);
	$list['subject'] = get_text($row['subject']);

    return $list;
}

// Load Data Table
function apms_data_row($type, $query='', $opt='') {
	global $g5;

	$list = array();

	switch($type) {
		case 'rss'			: $data = 1; break;
		case 'video'		: $data = 2; break;
		case 'keyword'		: $data = 3; break;
		case 'tag'			: $data = 4; break;
		case 'widget'		: $data = 100; break;
		default				: $data = 0; break;
	}

	if(!$data) return;

	if($opt) {
		$list = $query ? sql_fetch("select * from {$g5['apms_data']} where type = '$data' and data_q = '$query' limit 1 ", false) : '';
	} else {
		$query = $query ? 'order by '.$query : '';
		$result = sql_query("select * from {$g5['apms_data']} where type = '$data' $query ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
		}
	}

	return $list;
}

// APMS 썸네일 생성
function apms_thumbnail($url, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3') {

	if(!$url) return;

	$thumb = array();

	$srcfile = str_replace(G5_URL, G5_PATH, $url);

	if(is_file($srcfile)) {

		$size = @getimagesize($srcfile);
		if(empty($size))
			return;

		// jpg 이면 exif 체크
		if($size[2] == 2 && function_exists('exif_read_data')) {
			$degree = 0;
			$exif = @exif_read_data($srcfile);
			if(!empty($exif['Orientation'])) {
				switch($exif['Orientation']) {
					case 8:
						$degree = 90;
						break;
					case 3:
						$degree = 180;
						break;
					case 6:
						$degree = -90;
						break;
				}

				// 세로사진의 경우 가로, 세로 값 바꿈
				if($degree == 90 || $degree == -90) {
					$tmp = $size;
					$size[0] = $tmp[1];
					$size[1] = $tmp[0];
				}
			}
		}

		// 원본 width가 thumb_width보다 작다면
		if($size[0] <= $thumb_width) {
			$thumb['src'] = $url;
			$thumb['height'] = $size[1];
			return $thumb;
		}

		// Animated GIF 체크
		$is_animated = false;
		if($size[2] == 1) {
			$is_animated = is_animated_gif($srcfile);
		}

        // 이미지 높이
		$img_height = round(($thumb_width * $size[1]) / $size[0]);

		$filename = basename($srcfile);
		$filepath = dirname($srcfile);

		// 썸네일 생성
		if(!$is_animated)
			$thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
		else
			$thumb_file = $filename;

		if(!$thumb_file) {
			$thumb['src'] = $url;
			$thumb['height'] = $size[1];
			return $thumb;
		}

		list($file_url, $file_path) = explode(G5_URL, $url);

		$url = G5_URL . str_replace($filename, $thumb_file, $file_path);
	}

	$thumb['src'] = $url;
	$thumb['height'] = $img_height;

	return $thumb;
}

// 게시물 썸네일 생성
function apms_wr_thumbnail($bo_table, $write, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config;

	$img = array();
	$limg = array();
	$lalt = array();
	$link = array();

	$wr_id = $write['wr_id'];
	$wr_content = $write['wr_content'];
	$is_thumb_no = $write['is_thumb_no'];
	$no_img = $write['no_img'];

	// 링크
    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
		$link[$i] = get_text($write["wr_link{$i}"]);
    }

	$rows = ($write['img_rows'] > 1) ? $write['img_rows'] : 1;

	unset($write);

    $result = sql_query(" select bf_file, bf_content from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_type between '1' and '3' order by bf_no", false);
	$z = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		if($row['bf_file']) {
		    $img[$z]['edit'] = false;
		    $img[$z]['is_thumb'] = true;
			$img[$z]['filename'] = $row['bf_file'];
			$img[$z]['filepath'] = G5_DATA_PATH.'/file/'.$bo_table;
			$img[$z]['alt'] = get_text($row['bf_content']);
			$img[$z]['img'] = G5_DATA_URL.'/file/'.$bo_table.'/'.$row['bf_file'];
		
			$z++;
			if($z == $rows) break;
		} 
	}

	if($z != $rows) {
		if(!$wr_content) {
			$write_table = $g5['write_prefix'].$bo_table;
			$sql = " select wr_content from $write_table where wr_id = '$wr_id' ";
			$write = sql_fetch($sql);
			$wr_content = $write['wr_content'];
		}
		$matches = get_editor_image($wr_content, false);
		$edt = true;

		for($i=0; $i<count($matches[1]); $i++) {
			// 이미지 path 구함
			$p = parse_url($matches[1][$i]);
			if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
				$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
			else
				$data_path = $p['path'];

			$srcfile = G5_PATH.$data_path;

			//if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile)) {
				if(is_file($srcfile)) {
					$size = @getimagesize($srcfile);
					if(empty($size)) {
						continue;
					}

				    $img[$z]['edit'] = true;
				    $img[$z]['is_thumb'] = true;
					$img[$z]['filename'] = basename($srcfile);
				    $img[$z]['filepath'] = dirname($srcfile);
				    $img[$z]['datapath'] = $data_path;
				    $img[$z]['img'] = $matches[1][$i];

					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
			        $img[$z]['alt'] = get_text($malt[1]);

					$z++;
					if($z == $rows) break;

				} else {
					$limg[] = $matches[1][$i];
					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
					$lalt[] = get_text($malt[1]);
				}
			//}
		}
	}

	if($z != $rows) { // 링크동영상 체크
		for ($i=1; $i <= count($link); $i++) {

			$video = apms_video_info($link[$i]);

			if(!$video['type']) continue;

			$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

			if(!$srcfile || $srcfile == 'none') continue;

			$size = @getimagesize($srcfile);
			if(empty($size)) {
				continue;
			}

			$img[$z]['edit'] = true;
			$img[$z]['is_thumb'] = true;
			$img[$z]['filename'] = basename($srcfile);
			$img[$z]['filepath'] = dirname($srcfile);
			$img[$z]['datapath'] = str_replace(G5_PATH, '', $srcfile);
			$img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

			$z++;
			if($z == $rows) break;
		}
	}

	if($z != $rows) { //본문동영상 이미지 체크
		if(preg_match_all("/{동영상\:([^}]*)}/ie", $wr_content, $match)) {
			$match_cnt = count($match[1]);
			for ($i=0; $i < $match_cnt; $i++) {
				$video = apms_video_info(trim(strip_tags($match[1][$i])));

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

			    $img[$z]['edit'] = true;
			    $img[$z]['is_thumb'] = true;
			    $img[$z]['filename'] = basename($srcfile);
			    $img[$z]['filepath'] = dirname($srcfile);
			    $img[$z]['datapath'] = str_replace(G5_PATH, '', $srcfile);
			    $img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

				$z++;
				if($z == $rows) break;
			}
		}
	}

	if($z != $rows) { //링크 이미지
		for($i=0; $i < count($limg); $i++) {
		    $img[$z]['edit'] = true;
		    $img[$z]['is_thumb'] = false;
			$img[$z]['img'] = $limg[$i];
	        $img[$z]['alt'] = $lalt[$i];

			$z++;
			if($z == $rows) break;
		}
	}

    if($z == 0) {
		if($no_img) {
		    $img[$z]['edit'] = false;
		    $img[$z]['is_thumb'] = true;
			$img[$z]['img'] = $no_img;
	        $img[$z]['alt'] = '';
		} else {
			return;
		}
	}

	// 썸네일
	$tmp = array();
	$j = 0;
	for($i = 0; $i < count($img); $i++) {
		if($img[$i]['is_thumb'] && $thumb_width > 0 && !$is_thumb_no) {

			$tmpimg = apms_thumbnail($img[$i]['img'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

			if(!$tmpimg['src']) continue;

			$tmp[$j]['is_thumb'] = true;
            $tmp[$j]['src'] = $tmpimg['src'];
            $tmp[$j]['height'] = $tmpimg['height'];
		} else {
			$tmp[$j]['is_thumb'] = false;
            $tmp[$j]['src'] = $img[$i]['img'];
		}

		$tmp[$j]['alt'] = $img[$i]['alt'];
		$j++;
	}

	if($j == 0)
		return;

	$thumb = array();
	$thumb = ($rows > 1) ? $tmp : $tmp[0];

    return $thumb;
}

// 링크 동영상 출력
function apms_link_video($link, $one=false) {

	$video = '';
	for ($i=1; $i<=count($link); $i++) {
		if ($link[$i]) {
			list($link_video) = explode("|", $link[$i]);
			$video .= apms_video($link_video);
			if($one && $video) return $video;
		}
	}

	return $video;
}

//----------------------------------------------------------------//
// 태마 관련 함수들
//----------------------------------------------------------------//

// 사이트 새글 아이콘
function new_menu($bo_list, $list) {

	$arr_bo = explode("|", trim($bo_list));

	$new_icon = "new";
	$list_cnt = count($list);
	$arr_bo_cnt = count($arr_bo);

	for ($i=0; $i < $list_cnt; $i++) { 
		for ($j=0; $j < $arr_bo_cnt; $j++) {
			if ($list[$i] == $arr_bo[$j]) return $new_icon;
		}
	}

	$new_icon = "old";

	return $new_icon;
}

// 선택 메뉴 아이콘
function sel_menu($bo_list='', $page_list='', $gr_list='') {
	global $gr_id, $bo_table, $gid, $pid, $hid, $page_id;

	$sel_icon = ' class=on ';

	if($gr_id && $gr_list) {
		$chk_gr = explode("|", trim($gr_list));
		$chk_cnt = count($chk_gr);
		for ($i=0; $i < $chk_cnt; $i++) { 
			if ($gr_id == $chk_gr[$i]) return $sel_icon;
		}
	}

	if($page_id && $page_list) {
		$chk_page = explode("|", trim($page_list));
		$chk_cnt = count($chk_page);
		for ($i=0; $i < $chk_cnt; $i++) { 
			if ($page_id == $chk_page[$i]) return $sel_icon;
		}
	}

	if($bo_table && $bo_list) {
		$chk_bo = explode("|", trim($bo_list));
		$chk_cnt = count($chk_bo);
		for ($i=0; $i < $chk_cnt; $i++) { 
			if ($bo_table == $chk_bo[$i]) return $sel_icon;
		}
	}

	$sel_icon = '';

	return $sel_icon;

}

// 새글 갯수 체크
function new_cnt($bo_list, $ca_name='', $head='', $tail='') {
    global $g5;

	$bo = explode(";", trim($bo_list));
	$num = count($bo);

	$ca_name = $ca_name ? "and ca_name = '{$ca_name}'" : "";

	//새글 체크하기
	$cnt = 0;
	for ($i=0; $i < $num; $i++) {
		$bo_table = trim($bo[$i]);

		if(!$bo_table) continue;

		$board = sql_fetch("select * from {$g5['board_table']} where bo_table = '{$bo_table}'", false);

		if(!$board) continue;

		$row = sql_fetch("select count(wr_id) as cnt from ".$g5['write_prefix'].$bo_table." where wr_is_comment=0 $ca_name and wr_datetime >= '".date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600))."'", false);
		$cnt = $cnt + $row['cnt'];
	}

	$new_post = ($cnt > 0) ? $head.$cnt.$tail : '';

	return $new_post;
}

// 새글 목록 출력
function new_post($update='24', $bo_table='') {
	global $g5;

	if($update > 0) {
		;	
	} else {
		return;
	}

	$list = array();

	$chk_date = date("Y-m-d H:i:s", G5_SERVER_TIME - ($update * 3600));

	if($bo_table) {
	    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
	    $result = sql_query(" select distinct ca_name from $tmp_write_table where wr_datetime >= '$chk_date' and wr_is_comment = 0 ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row['ca_name'];
		}
	} else {
		$result = sql_query(" select distinct bo_table from {$g5['board_new_table']} where bn_datetime >= '$chk_date' and wr_id = wr_parent ", false); //새글 : 댓글은 wr_id <> wr_parent
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row['bo_table'];
		}
	}

	return $list;
}

// 사이트 통계 - 방문자수 출력
function apms_chk_stats($s='') {
    global $g5, $config;

	$lnb = array();

    // visit 배열변수에 $visit[1] = 오늘, $visit[2] = 어제, $visit[3] = 최대, $visit[4] = 전체 숫자가 들어감
    preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);
    settype($visit[0], "integer");
    settype($visit[1], "integer");
    settype($visit[2], "integer");
    settype($visit[3], "integer");

	$lnb['visit_today'] = $visit[1];
	$lnb['visit_yesterday'] = $visit[2];
	$lnb['visit_max'] = $visit[3];
	$lnb['visit_total'] = $visit[4];

	//현재 접속자
	$sql_find = ($config['as_admin']) ? "and find_in_set(mb_id, '{$config['as_admin']}')=0" : "";
    $row = sql_fetch(" select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from {$g5['login_table']} where mb_id <> '{$config['cf_admin']}' $sql_find ", false);
	if(!$row['mb_cnt']) $row['mb_cnt'] = 0;

	$lnb['now_total'] = $row['total_cnt'];
	$lnb['now_mb'] = $row['mb_cnt'];

	//오늘 가입자
	$row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where left(mb_datetime,10) = '".date("Y-m-d", G5_SERVER_TIME)."' ", false); 
	$lnb['join_today'] = $row['cnt'];

	//어제 가입자
	$row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where left(mb_datetime,10) = '".date("Y-m-d", G5_SERVER_TIME - 86400)."' ", false); 
	$lnb['join_yesterday'] = $row['cnt'];

	//전체회원
	$row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} ", false); 
	$lnb['join_total'] = $row['cnt'];

	if($s) $lnb = serialize($lnb);

    return $lnb;
}

function apms_stats() {
	global $g5, $config;

	if($g5['cache_stats_time'] < 0) return;

	$stats = ($g5['cache_stats_time'] > 0) ? unserialize(apms_cache('as_stats_cache', $g5['cache_stats_time'], "apms_chk_stats(1)")) : apms_chk_stats();

	return $stats;
}

// Check Memo
function apms_memo_cnt() {	
	global $g5, $member;

	$cnt = 0;
    if ($member['mb_id']) {
        $sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ";
        $row = sql_fetch($sql);
        $cnt = $row['cnt'];
    }

	return $cnt;
}

//Theama Member Info
function thema_member(){
	global $g5, $member, $is_admin;

	//Admin Auth
	$member['admin'] = false;
	if($is_admin) {
		$member['admin'] = $is_admin;
	} else {
		$auth = sql_fetch(" select count(*) as cnt from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ", false);
		if($auth['cnt']) 
			$member['admin'] = true;
	}

	//Check Memo
	$member['memo'] = 0;
	$memo = sql_fetch(" select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ");
	if($memo['cnt'])
		$member['memo'] = $memo['cnt'];

	return;
}

// html 형식으로 변환
function apms_get_html($str, $char='') {

    $target[] = "/</";
    $source[] = "&lt;";
    $target[] = "/>/";
    $source[] = "&gt;";
    $target[] = "/\"/";
    $source[] = "&#034;";
    $target[] = "/\'/";
    $source[] = "&#039;";

	if($char) {
	    return preg_replace($target, $source, $str);
	} else {
	    return preg_replace($source, $target, $str);
	}
}

function thema_widget_video($url, $width='', $height='') {

	list($href, $auto) = explode("|", $url);

	if(!$href) $url = 'http://youtu.be/Rz-9ThFyhdg|'.$auto;

	echo apms_video($url);

	return;
}

//Get Thema Widget Write List
function thema_widget_write_list($type, $bo_table, $row, $new=24, $thumb_width=0, $thumb_height=0, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $is_admin;

	// 배열전체를 복사
	$list = $row;
	unset($row);

	$list['bo_table'] = $bo_table;

	if($type == 'tag') {
		$list['new'] = ($list['lastdate'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['date'] = strtotime($list['lastdate']);
		$list['name'] = $list['tag'];
		$list['href'] = G5_BBS_URL.'/tag.php?q='.urlencode($list['tag']);
		$list['comment'] = $list['cnt'];

	} else if($type == 'response') {
		$list['subject'] = get_text($list['wr_subject']);
		$list['new'] = ($list['regdate'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['date'] = strtotime($list['regdate']);
		$list['name'] = $list['my_name'];
		$list['href'] = G5_BBS_URL.'/response.php?id='.$list['id'];
		$list['photo'] = apms_photo_url($list['my_id']); //회원사진
		$list['comment'] = $list['reply_cnt'] + $list['comment_cnt'] + $list['comment_reply_cnt'] + $list['use_cnt'] + $list['qa_cnt'] + $list['good_cnt'] + $list['nogood_cnt'];
	} else if($type == 'qa') {
		$list['subject'] = get_text($list['qa_subject']);
		$list['new'] = ($list['qa_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['date'] = strtotime($list['qa_datetime']);
		$list['name'] = $list['qa_name'];
		$list['href'] = G5_BBS_URL.'/qaview.php?qa_id='.$list['qa_id'];
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
        $list['category'] = $list['qa_category'];
		$list['comment'] = ($list['qa_status']) ? 1 : 0;
	} else {
		$list['new'] = ($list['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['secret'] = (strstr($list['wr_option'], "secret")) ? true : false;
		$list['date'] = strtotime($list['wr_datetime']);
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['wr_name'];
        $list['category'] = $list['ca_name'];
        $list['hit'] = $list['wr_hit'];
        $list['good'] = $list['wr_good'];
        $list['nogood'] = $list['wr_nogood'];

		if($type == 'comment') {
			$list['reply_name'] = ($list['wr_comment_reply'] && $list['as_re_name']) ? $list['as_re_name'] : '';
			$list['comment'] = $list['wr_comment'] = 0;
			if(!$list['secret']) {
				$tmp_write_table = $g5['write_prefix'] . $bo_table;
				$post = sql_fetch(" select wr_option from $tmp_write_table where wr_id = '{$list['wr_parent']}' ", false); //원글 글옵션
				$list['secret'] = (strstr($post['wr_option'], "secret")) ? true : false;
			}
			if($list['secret']) {
				$list['subject'] = $list['wr_subject'] = $list['wr_content'] = '비밀댓글입니다.';
			} else {
				$list['subject'] = apms_cut_text($list['wr_content'], 60);
			}
			$list['href'] = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$list['wr_parent'].'#c_'.$list['wr_id'];

		} else if($type == 'post') {
			$list['subject'] = get_text($list['wr_subject']);
			$list['reply'] = strlen($list['wr_reply']);
			$list['reply_name'] = ($list['reply'] && $list['as_re_name']) ? $list['as_re_name'] : '';
			$list['href'] = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$list['wr_parent'];
			$list['comment'] = $list['wr_comment'];

			// 링크
			for ($i=1; $i<=G5_LINK_COUNT; $i++) {
				$list['link'][$i] = set_http(get_text($list["wr_link{$i}"]));
				$list['link_href'][$i] = G5_BBS_URL."/link.php?bo_table=".$bo_table."&amp;wr_id=".$list['wr_id']."&amp;no=".$i;
				$list['link_hit'][$i] = (int)$list["wr_link{$i}_hit"];
			}

			if($list['secret']) {
				$list['wr_content'] = '비밀글입니다.';
			}

			if(!$list['secret'] && $thumb_width > 0) {
				$list['img'] = apms_wr_thumbnail($bo_table, $list, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
			}
		}

		$list['content'] = $list['wr_content'];
		$list['wr_content'] = '';
	}

    return $list;
}

//Thema Widget
function thema_widget($widget_dir, $widget_file, $options='', $m_options=''){

	$widget_url = THEMA_URL.'/widget';
	$widget_path = THEMA_PATH.'/widget';

	if($widget_dir) {
		$widget_url .= '/'.$widget_dir;
		$widget_path .= '/'.$widget_dir;
	}

	if(!$widget_file || !file_exists($widget_path.'/'.$widget_file)) return;

	include ($widget_path.'/'.$widget_file);

	return;
}

//Thema Switcher
function thema_switcher($type, $path, $val, $ext='') {

	if(!$path) return;

	$arr = array();
	$set = array();

	if($type == 'thema') $path = THEMA_PATH.'/'.$path;

	if(!is_dir($path)) return;

	$handle = opendir($path);
	while ($file = readdir($handle)) {
		if($file == "."||$file == "..") continue;
		if($ext) {
			if(!preg_match("/\.(".$ext.")$/i", $file)) continue;
		} else {
			if(!is_dir($path.'/'.$file)) continue;
		}
		$arr[] = $file;
	}
	closedir($handle);
	sort($arr);

	$i = 0;
	foreach($arr as $key=>$value) {
		$set[$i]['name'] = $arr[$key];
		$set[$i]['value'] = $arr[$key];
		if($ext) {
			$set[$i]['value'] = str_replace(".".apms_get_ext($set[$i]['value']), "", $set[$i]['value']);
		}
		$set[$i]['selected'] = ($set[$i]['value'] == $val) ? true : false;
		$i++;
	}

	return $set;
}

// Load Data Tabble
function thema_switcher_load($type, $code) {
	global $g5;

	if(!$type) return;

	$set = array();

	// Check Set
	$data = sql_fetch(" select * from {$g5['apms_data']} where type = '$type' and data_q = '$code' ", false);

	if($data['data_1'] != THEMA) return;

	$set = apms_unpack($data['data_set']);

	return $set;
}

// sns 공유하기
function apms_sns($sns, $url, $title) {
	return;
}

// Load Script
function apms_script($name){

	if($name == 'code') {
		if(!defined('APMS_CODE')) {
			define('APMS_CODE', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/syntaxhighlighter/styles/shCoreDefault.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/syntaxhighlighter/scripts/shCore.js"></script>', 99);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/syntaxhighlighter/scripts/shBrushJScript.js"></script>', 99);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/syntaxhighlighter/scripts/shBrushPhp.js"></script>', 99);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/syntaxhighlighter/scripts/shBrushCss.js"></script>', 99);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/syntaxhighlighter/scripts/shBrushXml.js"></script>', 99);
			add_javascript('<script type="text/javascript">var is_SyntaxHighlighter = true; SyntaxHighlighter.all(); </script>', 99);
		}
	} else if($name == 'imagesloaded') {
		if(!defined('APMS_IMAGESLOADED')) {
			define('APMS_IMAGESLOADED', true);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/js/imagesloaded.pkgd.min.js"></script>', 0);
		}
	} else if($name == 'infinite') {
		if(!defined('APMS_INFINITESCROLL')) {
			define('APMS_INFINITESCROLL', true);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/js/jquery.infinitescroll.min.js"></script>', 0);
		}
	} else if($name == 'masonry') {
		if(!defined('APMS_MASONRY')) {
			define('APMS_MASONRY', true);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/js/masonry.pkgd.min.js"></script>', 0);
		}
	} else if($name == 'swipe') {
		if(!defined('APMS_SWIPE')) {
			define('APMS_SWIPE', true);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/js/jquery.mobile.swipe.min.js"></script>', 0);
		}
	} else if($name == 'scrollbar') {
		if(!defined('APMS_SCROLLBAR')) {
			define('APMS_SCROLLBAR', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/perfect-scrollbar/perfect-scrollbar.min.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/perfect-scrollbar/perfect-scrollbar.jquery.min.js"></script>', 0);
		}
	} else if($name == 'lightbox') {
		if(!defined('APMS_LIGHTBOX')) {
			define('APMS_LIGHTBOX', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/lightbox2/css/lightbox.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/lightbox2/js/lightbox.min.js"></script>', 0);
		}
	} else if($name == 'timeline') {
		if(!defined('APMS_TIMELINE')) {
			define('APMS_TIMELINE', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/timeline/timeline.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/timeline/timeline.js"></script>', 0);
		}
	} else if($name == 'flexslider') {
		if(!defined('APMS_FLEXSLIDER')) {
			define('APMS_FLEXSLIDER', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/FlexSlider/flexslider.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/FlexSlider/jquery.flexslider-min.js"></script>', 0);
		}
	} else if($name == 'coinslider') {
		if(!defined('APMS_COINSLIDER')) {
			define('APMS_COINSLIDER', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/coin-slider/coin-slider-styles.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/coin-slider/coin-slider.min.js"></script>', 0);
		}
	} else if($name == 'mosaic') {
		if(!defined('APMS_MOSAIC')) {
			define('APMS_MOSAIC', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/jMosaic/jquery.jMosaic.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/jMosaic/jquery.jMosaic.min.js"></script>', 0);
		}
	} else if($name == 'owlcarousel') {
		if(!defined('APMS_OWLCAROUSEL')) {
			define('APMS_OWL', true);
			add_stylesheet('<link rel="stylesheet" href="'.APMS_PLUGIN_URL.'/owlcarousel/owl.carousel.css">', -1);
			add_javascript('<script type="text/javascript" src="'.APMS_PLUGIN_URL.'/owlcarousel/owl.carousel.min.js"></script>', 0);
		}
	}
	return;
}

// Random ID
function apms_id(){

	$start = range('a','f');
	shuffle($start);

	$end = range('u','z');
	shuffle($end);

	$chars_array = range($start[0], $end[0]);
	shuffle($chars_array);

	$id = implode('', $chars_array);

	return $id;
}

// Auto Menu
function apms_chk_auto_menu($s='', $mobile='', $type='') {
	global $g5, $xp;

	// Group
	$ca = array();
	$bo = array();
	$gr = array();
	$pg = array();
	$list = array();

	$mobile = ($mobile) ? 'mobile_' : ''; // 모바일 접두어로 전환..ㅠㅠ
	$device = ($mobile) ? 'pc' : 'mobile';

	$stype = ($type) ? 3 : 2;

	$newpost = ($g5['cache_newpost_time'] > 0) ? new_post($g5['cache_newpost_time']) : '';

	$sql_select = 'gr_id, as_icon, as_mobile_icon, as_menu_show, as_grade, as_equal, as_min, as_max, as_link, as_target';

	//그룹
	$n = 0;
	$gr_in = '';
	$result = sql_query(" select gr_subject, as_main, as_menu, as_multi, gr_order, $sql_select from {$g5['group_table']} where gr_device <> '$device' and (as_show = '1' or as_show = '$stype') order by gr_order ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		if(!trim($row['gr_id'])) continue;
		$gr[$n] = $row;
		$gr_in .= ($n > 0) ? ",".$row['gr_id'] : $row['gr_id'];
		$n++;
	}

	$gr_cnt = count($gr);

	if($gr_in) $gr_in = "and find_in_set(gr_id,'{$gr_in}')";

	//보드
	$n = 0;
	$result = sql_query("select bo_table, bo_subject, bo_mobile_subject, bo_category_list, bo_count_write, bo_count_comment, as_order, as_menu, as_line, $sql_select from {$g5['board_table']} where as_show = '1' and bo_device <> '$device' $gr_in ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		if(!trim($row['bo_table'])) continue;
		$pg[$row['gr_id']][$n] = $row;
		$n++;
	}

	//문서
	$result = sql_query("select html_id, bo_subject, bo_mobile_subject, as_file, as_html, as_order, as_line, $sql_select from {$g5['apms_page']} where gr_id <> '' and as_show = '1' and bo_device <> '$device' $gr_in ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$pg[$row['gr_id']][$n] = $row;
		$n++;
	}

	//첫번째 배열(0번)은 전체통계로 사용
	$z = 1;
	$count_write = 0;
	$count_comment = 0;
	$cnt_new = 0;
	for ($i=0; $i < $gr_cnt; $i++) {

		$gr_new = 0;
		$gr_count_write = 0;
		$gr_count_comment = 0;

		//row로 변경
		$row = $gr[$i];

		$list[$z]['gr_id'] = $row['gr_id'];
		$list[$z]['as_menu_show'] = $row['as_menu_show'];
		$list[$z]['as_grade'] = $row['as_grade'];
		$list[$z]['as_equal'] = $row['as_equal'];
		$list[$z]['as_min'] = $row['as_min'];
		$list[$z]['as_max'] = $row['as_max'];
		$list[$z]['order'] = $row['gr_order'];
		$list[$z]['sg'] = 1;

		//게시판과 문서 정리
		$bo = $pg[$row['gr_id']];
		$bo_cnt = count($bo);

		if($bo_cnt > 0) $bo = apms_sort($bo, 'as_order');

		$n = 0;
		$is_on = false;
		for ($k=0; $k < $bo_cnt; $k++) {

			$list[$z]['sub'][$k]['as_menu_show'] = $bo[$k]['as_menu_show'];
			$list[$z]['sub'][$k]['as_grade'] = $bo[$k]['as_grade'];
			$list[$z]['sub'][$k]['as_equal'] = $bo[$k]['as_equal'];
			$list[$z]['sub'][$k]['as_min'] = $bo[$k]['as_min'];
			$list[$z]['sub'][$k]['as_max'] = $bo[$k]['as_max'];

			$list[$z]['sub'][$k]['gr_id'] = $row['gr_id']; //그룹 아이디
			$list[$z]['sub'][$k]['bo_table'] = $bo[$k]['bo_table']; //게시판 아이디
			$list[$z]['sub'][$k]['hid'] = $bo[$k]['html_id']; //문서아이디

			$bo_subject = ($bo[$k]['bo_'.$mobile.'subject']) ? $bo[$k]['bo_'.$mobile.'subject'] : $bo[$k]['bo_subject'];
			$list[$z]['sub'][$k]['name'] = ($bo[$k]['as_'.$mobile.'icon']) ? apms_fa($bo[$k]['as_'.$mobile.'icon']).' '.$bo_subject : $bo_subject;
			$list[$z]['sub'][$k]['target'] = ($bo[$k]['as_target']) ? ' target="'.$bo[$k]['as_target'].'"' : ''; //타켓
			$list[$z]['sub'][$k]['line'] = ($bo[$k]['as_line']) ? apms_fa($bo[$k]['as_line']) : ''; //라인

			if($bo[$k]['html_id']) {
				$list[$z]['sub'][$k]['is_page'] = true;
				$list[$z]['sub'][$k]['count_write'] = 0; //글갯수
				$list[$z]['sub'][$k]['count_comment'] = 0; //댓글갯수
				$list[$z]['sub'][$k]['hid'] = $bo[$k]['html_id'];
				if($bo[$k]['as_html']) {
					$list[$z]['sub'][$k]['href'] = ($bo[$k]['as_link']) ? $bo[$k]['as_link'] : G5_BBS_URL.'/page.php?hid='.urlencode($bo[$k]['html_id']);
				} else {
					$list[$z]['sub'][$k]['href'] = ($bo[$k]['as_link']) ? $bo[$k]['as_link'] : G5_URL.'/'.$bo[$k]['as_file']; //링크
				}
				$list[$z]['sub'][$k]['new'] = 'old';
				$list[$z]['sub'][$k]['is_sub'] = false;
			} else {
				$list[$z]['sub'][$k]['is_page'] = false;
				$list[$z]['sub'][$k]['hid'] = $bo[$k]['bo_table'];
				$list[$z]['sub'][$k]['count_write'] = $bo[$k]['bo_count_write']; //글갯수
				$list[$z]['sub'][$k]['count_comment'] = $bo[$k]['bo_count_comment']; //댓글갯수
				$list[$z]['sub'][$k]['href'] = ($bo[$k]['as_link']) ? $bo[$k]['as_link'] : G5_BBS_URL.'/board.php?bo_table='.$bo[$k]['bo_table']; //링크
				$list[$z]['sub'][$k]['new'] = new_menu($bo[$k]['bo_table'], $newpost);
				if($list[$z]['sub'][$k]['new'] == 'new') $gr_new++; //새글이 있는지 체크
				$list[$z]['sub'][$k]['is_sub'] = false;
				$is_submenu = (!$bo[$k]['as_menu'] || (!$mobile && $bo[$k]['as_menu'] == "2")) ? true : false; // 분류출력
				if($is_submenu && $bo[$k]['bo_category_list']) { //분류출력
					$cate = explode("|", $bo[$k]['bo_category_list']);
					for ($j=0; $j<count($cate); $j++) {
						$list[$z]['sub'][$k]['sub'][$j]['gr_id'] = $row['gr_id'];
						$list[$z]['sub'][$k]['sub'][$j]['name'] = $cate[$j];
						$list[$z]['sub'][$k]['sub'][$j]['href'] = G5_BBS_URL.'/board.php?bo_table='.$bo[$k]['bo_table'].'&sca='.urlencode($cate[$j]);
						$list[$z]['sub'][$k]['sub'][$j]['target'] = ''; // 타켓
						$list[$z]['sub'][$k]['sub'][$j]['new'] = 'old';
					}
					$ca[$z]['sub'][$k] = $list[$z]['sub'][$k]['sub'];
					$list[$z]['sub'][$k]['cnt'] = $j;
					$list[$z]['sub'][$k]['is_sub'] = ($j > 0) ? true : false;
				}
			}	
			$gr_count_write = $gr_count_write + $bo[$k]['bo_count_write'];
			$gr_count_comment = $gr_count_comment + $bo[$k]['bo_count_comment'];
			$n++;
		}

		//그룹정리
		$list[$z]['gr_id'] = $row['gr_id']; //그룹 아이디
		$list[$z]['count_write'] = $gr_count_write; //글갯수
		$list[$z]['count_comment'] = $gr_count_comment; //댓글갯수
		$list[$z]['cnt'] = $n; //게시판 갯수

		if($list[$z]['cnt'] == 1 && $row['as_menu']) { //게시판이 하나뿐일 때
			$list[$z]['name'] = $list[$z]['sub'][0]['name'];
			$list[$z]['href'] = $list[$z]['sub'][0]['href'];
			$list[$z]['new'] = $list[$z]['sub'][0]['new'];
			$list[$z]['target'] = $list[$z]['sub'][0]['target']; // 타켓
			$list[$z]['cnt'] = $list[$z]['sub'][0]['cnt'];
			$list[$z]['sub'] = $list[$z]['sub'][0]['sub'];
			$list[$z]['one'] = 1;
		} else {
			$list[$z]['cnt'] = ($list[$z]['cnt'] == 1) ? 2 : $list[$z]['cnt'];
			$list[$z]['name'] = ($row['as_'.$mobile.'icon']) ? apms_fa($row['as_'.$mobile.'icon']).' '.$row['gr_subject'] : $row['gr_subject']; //그룹 제목
			if($row['as_link']) {
				$list[$z]['href'] = $row['as_link'];
				$list[$z]['target'] = $row['as_target'] ? ' target="'.$row['as_target'].'"' : ''; // 타켓
			} else if($row['as_main']) {
				$list[$z]['href'] = G5_BBS_URL.'/main.php?gid='.$row['gr_id'];
				$list[$z]['target'] = $row['as_target'] ? ' target="'.$row['as_target'].'"' : ''; // 타켓
			} else {
				$list[$z]['href'] = $list[$z]['sub'][0]['href']; // 링크가 없으면 첫번째 게시판 링크로 이동
				$list[$z]['target'] = $list[$z]['sub'][0]['target']; // 타켓
			}
			$list[$z]['new'] = ($gr_new > 0) ? 'new' : 'old'; //새글이 있는지 체크
			$list[$z]['multi'] = $row['as_multi'];
		}

		$list[$z]['is_sub'] = $list[$z]['cnt'] > 1 ? true : false;

		if($list[$z]['new'] == "new") $cnt_new++;

		$count_write = $count_write + $gr_count_write;
		$count_comment = $count_comment + $gr_count_comment;

		$z++;

		unset($bo);
		unset($ca);
	}

	// Shop
	if(IS_YC) {
		$new = array();
		$new = apms_chk_new_item();

		$sql_select = 'ca_id, ca_name, as_icon, as_mobile_icon, as_menu, as_menu_show, as_grade, as_equal, as_min, as_max, as_link, as_target, as_line, as_multi, ca_order';

		// 1단계 분류 판매 가능한 것만
		$result = sql_query(" select $sql_select from {$g5['g5_shop_category_table']} where length(ca_id) = '2' and ca_use = '1' and (as_show = '1' or as_show = '$stype') order by ca_order, ca_id ", false);
		$cnt_new = 0;

		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$list[$z]['as_menu_show'] = $row['as_menu_show'];
			$list[$z]['as_grade'] = $row['as_grade'];
			$list[$z]['as_equal'] = $row['as_equal'];
			$list[$z]['as_min'] = $row['as_min'];
			$list[$z]['as_max'] = $row['as_max'];
			$list[$z]['multi'] = $row['as_multi'];
			$list[$z]['order'] = $row['ca_order'];

			$is_on = false;

			// 2단계 분류 판매 가능한 것만
			$j = 0;
			$is_submenu = (!$row['as_menu'] || (!$mobile && $row['as_menu'] == "2")) ? true : false; // 2차 출력
			if($is_submenu) { 
				$result2 = sql_query(" select $sql_select from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '4' and SUBSTRING(ca_id,1,2) = '{$row['ca_id']}' and ca_use = '1' and as_show <> '0' order by ca_order, ca_id ", false);
				for ($j=0; $row2=sql_fetch_array($result2); $j++) {

					$list[$z]['sub'][$j]['as_menu_show'] = $row2['as_menu_show'];
					$list[$z]['sub'][$j]['as_grade'] = $row2['as_grade'];
					$list[$z]['sub'][$j]['as_equal'] = $row2['as_equal'];
					$list[$z]['sub'][$j]['as_min'] = $row2['as_min'];
					$list[$z]['sub'][$j]['as_max'] = $row2['as_max'];

					$list[$z]['sub'][$j]['gr_id'] = $row['ca_id']; //그룹 아이디
					$list[$z]['sub'][$j]['hid'] = $row2['ca_id']; //게시판 아이디
					$list[$z]['sub'][$j]['name'] = ($row2['as_'.$mobile.'icon']) ? apms_fa($row2['as_'.$mobile.'icon']).' '.$row2['ca_name'] : $row2['ca_name'];
					$list[$z]['sub'][$j]['target'] = ($row2['as_target']) ? ' target="'.$row2['as_target'].'"' : ''; //타켓
					$list[$z]['sub'][$j]['line'] = ($row2['as_line']) ? apms_fa($row2['as_line']) : ''; //라인
					$list[$z]['sub'][$j]['is_page'] = false;
					$list[$z]['sub'][$j]['href'] = ($row2['as_link']) ? $row2['as_link'] : G5_SHOP_URL.'/list.php?ca_id='.$row2['ca_id']; //링크

					$c = $row2['ca_id'];
					$list[$z]['sub'][$j]['new'] = (isset($new[$c]) && $new[$c]) ? 'new' : 'old';

					$k = 0;
					$is_submenu2 = (!$row2['as_menu'] || (!$mobile && $row2['as_menu'] == "2")) ? true : false; // 3차 출력
					if($is_submenu2) { 
						// 3단계 분류 판매 가능한 것만
						$result3 = sql_query(" select $sql_select from {$g5['g5_shop_category_table']} where LENGTH(ca_id) = '6' and SUBSTRING(ca_id,1,4) = '{$row2['ca_id']}' and ca_use = '1' and as_show <> '0' order by ca_order, ca_id ", false);
						for ($k=0; $row3=sql_fetch_array($result3); $k++) {

							$list[$z]['sub'][$j]['sub'][$k]['as_menu_show'] = $row3['as_menu_show'];
							$list[$z]['sub'][$j]['sub'][$k]['as_grade'] = $row3['as_grade'];
							$list[$z]['sub'][$j]['sub'][$k]['as_equal'] = $row3['as_equal'];
							$list[$z]['sub'][$j]['sub'][$k]['as_min'] = $row3['as_min'];
							$list[$z]['sub'][$j]['sub'][$k]['as_max'] = $row3['as_max'];

							$list[$z]['sub'][$j]['sub'][$k]['ca_id'] = $row3['ca_id'];
							$list[$z]['sub'][$j]['sub'][$k]['name'] = ($row3['as_'.$mobile.'icon']) ? apms_fa($row3['as_'.$mobile.'icon']).' '.$row3['ca_name'] : $row3['ca_name'];
							$list[$z]['sub'][$j]['sub'][$k]['href'] = ($row3['as_link']) ? $row3['as_link'] : G5_SHOP_URL.'/list.php?ca_id='.$row3['ca_id']; //링크
							$list[$z]['sub'][$j]['sub'][$k]['target'] = ($row3['as_target']) ? ' target="'.$row3['as_target'].'"' : ''; // 타켓
							$list[$z]['sub'][$j]['sub'][$k]['line'] = ($row3['as_line']) ? apms_fa($row3['as_line']) : ''; //라인

							$c = $row3['ca_id'];
							$list[$z]['sub'][$j]['sub'][$k]['new'] = (isset($new[$c]) && $new[$c]) ? 'new' : 'old';
						}
					}

					$list[$z]['sub'][$j]['is_sub'] = ($k > 0) ? true : false;
				}
			}

			// 1단계 분류
			$list[$z]['gr_id'] = $row['ca_id']; //그룹 아이디
			$list[$z]['is_sub'] = ($j > 0) ? true : false;

			$c = $row['ca_id'];
			$list[$z]['new'] = (isset($new[$c]) && $new[$c]) ? 'new' : 'old';

			$list[$z]['name'] = ($row['as_'.$mobile.'icon']) ? apms_fa($row['as_'.$mobile.'icon']).' '.$row['ca_name'] : $row['ca_name']; //그룹 제목
			$list[$z]['href'] = $row['as_link'] ? $row['as_link'] : G5_SHOP_URL.'/list.php?ca_id='.$row['ca_id']; //링크
			$list[$z]['target'] = $row['as_target'] ? ' target="'.$row['as_target'].'"' : ''; // 타켓

			if($list[$z]['new'] == "new") $cnt_new++;

			$z++;
		}
	}

	//재정렬
	$list = apms_sort($list, 'order');

	//전체 통계
	$tot = array();
	$tot['count_write'] = $count_write; //글갯수
	$tot['count_comment'] = $count_comment; //댓글갯수

	@array_unshift($list, $tot);

	if($s) $list = serialize($list);

	return $list;
}

function apms_auto_menu() {
	global $g5, $xp, $member, $is_admin, $ca_id, $sca, $gid, $hid, $pid, $grid, $bo_table;

	if($g5['cache_auto_menu'] < 0) return;

	$tmp = array();
	$sub = array();
	$sub2 = array();

	if(IS_YC && IS_SHOP) { // 쇼핑몰
		if(G5_IS_MOBILE) { // 모바일
			$tmp = ($g5['cache_auto_menu'] > 0) ? unserialize(apms_cache('apms_mobile_shop_menu', $g5['cache_auto_menu'], "apms_chk_auto_menu(1,1,1)")) : apms_chk_auto_menu(0,1,1);
		} else { // PC
			$tmp = ($g5['cache_auto_menu'] > 0) ? unserialize(apms_cache('apms_pc_shop_menu', $g5['cache_auto_menu'], "apms_chk_auto_menu(1,0,1)")) : apms_chk_auto_menu(0,0,1);
		}
	} else { // 커뮤니티
		if(G5_IS_MOBILE) { // 모바일
			$tmp = ($g5['cache_auto_menu'] > 0) ? unserialize(apms_cache('apms_mobile_bbs_menu', $g5['cache_auto_menu'], "apms_chk_auto_menu(1,1,0)")) : apms_chk_auto_menu(0,1,0);
		} else { // PC
			$tmp = ($g5['cache_auto_menu'] > 0) ? unserialize(apms_cache('apms_pc_bbs_menu', $g5['cache_auto_menu'], "apms_chk_auto_menu(1)")) : apms_chk_auto_menu(0,0,0);
		}
	}

	$cnt = count($tmp);

	$it_ca = $it_ca2 = $it_ca3 = '';
	if($ca_id) {
		$it_ca = substr($ca_id,0,2);
		$it_ca2 = substr($ca_id,0,4);
		$it_ca3 = substr($ca_id,0,6);
	}

	$l = 1;
	for($i=1; $i < $cnt; $i++) {

		if(!$is_admin && $tmp[$i]['as_menu_show']) {
			if(apms_auth($tmp[$i]['as_grade'], $tmp[$i]['as_equal'], $tmp[$i]['as_min'], $tmp[$i]['as_max'], 1)) continue;
		}

		if($tmp[$i]['sg']) {

			$tmp[$i]['on'] = ($grid && $tmp[$i]['gr_id'] == $grid) ? 'on' : 'off';

			if($tmp[$i]['is_sub']) {
				$m = 0;
				for($j=0; $j < count($tmp[$i]['sub']); $j++) {

					if(!$is_admin && $tmp[$i]['sub'][$j]['as_menu_show']) {
						if(apms_auth($tmp[$i]['sub'][$j]['as_grade'], $tmp[$i]['sub'][$j]['as_equal'], $tmp[$i]['sub'][$j]['as_min'], $tmp[$i]['sub'][$j]['as_max'], 1)) continue;
					}

					if($tmp[$i]['sub'][$j]['is_page']) {
						$tmp[$i]['sub'][$j]['on'] = (($hid && $tmp[$i]['sub'][$j]['hid'] == $hid) || ($pid && $tmp[$i]['sub'][$j]['hid'] == $pid)) ? 'on' : 'off';
					} else {
						if($tmp[$i]['one']) { // 보드를 메인으로 올렸을 경우
							$tmp[$i]['sub'][$j]['on'] = ($tmp[$i]['on'] && $sca && $sca == $tmp[$i]['sub'][$j]['name']) ? 'on' : 'off';
						} else {
							$tmp[$i]['sub'][$j]['on'] = ($bo_table && $tmp[$i]['sub'][$j]['hid'] == $bo_table) ? 'on' : 'off';
						}
					}

					if($tmp[$i]['sub'][$j]['is_sub']) {
						for($k=0; $k < count($tmp[$i]['sub'][$j]['sub']); $k++) {
							$tmp[$i]['sub'][$j]['sub'][$k]['on'] = ($tmp[$i]['sub'][$j]['on'] && $sca && $tmp[$i]['sub'][$j]['sub'][$k]['name'] == $sca) ? 'on' : 'off';
						}
					}
					$sub[$m] = $tmp[$i]['sub'][$j];
					$m++;
				}

				$tmp[$i]['sub'] = $sub;
				unset($sub);
			}
		} else {
			$tmp[$i]['on'] = ($it_ca && $tmp[$i]['gr_id'] == $it_ca) ? 'on' : 'off';

			if($tmp[$i]['is_sub']) { 
				$m = 0;
				for($j=0; $j < count($tmp[$i]['sub']); $j++) {

					if(!trim($tmp[$i]['sub'][$j]['gr_id'])) continue;

					if(!$is_admin && $tmp[$i]['sub'][$j]['as_menu_show']) {
						if(apms_auth($tmp[$i]['sub'][$j]['as_grade'], $tmp[$i]['sub'][$j]['as_equal'], $tmp[$i]['sub'][$j]['as_min'], $tmp[$i]['sub'][$j]['as_max'], 1)) continue;
					}

					$tmp[$i]['sub'][$j]['on'] = ($it_ca2 && $tmp[$i]['sub'][$j]['hid'] == $it_ca2) ? 'on' : 'off';

					if($tmp[$i]['sub'][$j]['is_sub']) {
						$n = 0;
						for($k=0; $k < count($tmp[$i]['sub'][$j]['sub']); $k++) {

							if(!$is_admin && $tmp[$i]['sub'][$j]['subj'][$k]['as_menu_show']) {
								if(apms_auth($tmp[$i]['sub'][$j]['subj'][$k]['as_grade'], $tmp[$i]['sub'][$j]['subj'][$k]['as_equal'], $tmp[$i]['sub'][$j]['subj'][$k]['as_min'], $tmp[$i]['sub'][$j]['subj'][$k]['as_max'], 1)) continue;
							}

							$tmp[$i]['sub'][$j]['sub'][$k]['on'] = ($it_ca3 && $tmp[$i]['sub'][$j]['on'] && $tmp[$i]['sub'][$j]['sub'][$k]['ca_id'] == $it_ca3) ? 'on' : 'off';
							$sub2[$n] = $tmp[$i]['sub'][$j]['sub'][$k];
							$n++;
						}

						$tmp[$i]['sub'][$j]['sub'] = $sub2;
						unset($sub2);
					}

					$sub[$m] = $tmp[$i]['sub'][$j];
					$m++;
				}

				$tmp[$i]['sub'] = $sub;
				unset($sub);
			} 
		}
		$menu[$l] = $tmp[$i];
		$l++;
	}

	$menu[0] = $tmp[0];

	return $menu;
}

// Group Multi Menu
function apms_multi_menu($menu, $id, $multi){
	global $is_main, $gid;

	$cnt = count($menu);

	$tmp = array();
	if($id && $multi) {
		$tmp[0] = $menu[0];
		$z = 1;
		for ($i=1; $i < $cnt; $i++) {
			if($menu[$i]['gr_id'] == $id) {
				$sub_cnt = count($menu[$i]['sub']);
				for($j=0; $j < $sub_cnt;$j++) {
					$tmp[$z] = $menu[$i]['sub'][$j];
					$z++;
				}
				break;
			}
		}

		if($is_main) $gid = ''; //메인에서 gid 날림

	} else {
		$z = 0;
		for ($i=0; $i < $cnt; $i++) {
			if($menu[$i]['multi'] == "1") continue; //멀티그룹은 제외함
			$tmp[$z] = $menu[$i];
			$z++;
		}
	}

	return $tmp;
}

function apms_like(){
	if(!defined('APMS_LIKE')) {
		define('APMS_LIKE', true);
		echo '<div id="fb-root"></div>'.PHP_EOL;
		echo '<script type="text/javascript" src="'.G5_JS_URL.'/apms.like.js"></script>'.PHP_EOL;
	}

	return;
}

// 럭키포인트
function apms_lucky($it_id, $bo_table, $wr_id){
	global $g5, $member, $is_member, $board;

	$point = 0;
	if($is_member && APMS_LUCKY_POINT > 0 && APMS_LUCKY_DICE > 0) {
		$dice1 = rand(1, APMS_LUCKY_DICE);
		$dice2 = rand(1, APMS_LUCKY_DICE);
		if($dice1 == $dice2) {
			$point = rand(1, APMS_LUCKY_POINT);

			//포인트 등록
			if($it_id) { //상품댓글
				$tmp_point = insert_point($member['mb_id'], (int)$point, "아이템({$it_id}) 럭키".AS_MP."!", $it_id, '1', '@lucky');
			} else {
				$tmp_point = insert_point($member['mb_id'], (int)$point, "{$board['bo_subject']} {$wr_id} 럭키".AS_MP."!", $bo_table, $wr_id, '@lucky');
			}

			$point = ($tmp_point > 0) ? $point : 0; // 럭키포인트는 글/아이템당 1번만 등록
		}
	}

	return $point;
}

// 외부이미지 저장
function apms_save_image($url, $path) {

	if(!$url) return;

	$ch = curl_init ($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); 
	$err = curl_error($ch);
	if(!$err) $rawdata=curl_exec($ch);
	curl_close ($ch);
	if($rawdata) {
		$ext = apms_get_ext($path);
		$ext = ($ext) ? '.'.$ext : '';

		$ym = date('ym', G5_SERVER_TIME);
		$data_dir = G5_DATA_PATH.'/editor/'.$ym;
		$data_url = G5_DATA_URL.'/editor/'.$ym;

		if(!is_dir($data_dir)) {
			@mkdir($data_dir, G5_DIR_PERMISSION);
			@chmod($data_dir, G5_DIR_PERMISSION);
		}

		$file_name = sprintf('%u', ip2long($_SERVER['REMOTE_ADDR'])).'_'.uniqid().'_'.get_microtime().$ext;
		$save_dir = sprintf('%s/%s', $data_dir, $file_name);
        $save_url = sprintf('%s/%s', $data_url, $file_name);

		$fp = fopen($save_dir,'w'); 
		fwrite($fp, $rawdata); 
		fclose($fp); 
		
		if(file_exists($save_dir)) {
			@chmod($save_dir, G5_FILE_PERMISSION);
			return $save_url;
		}
	} 
	
	return;
}

function apms_content_image($content) {

	if(!$content) return;

	$content = stripslashes($content);
	$patten = "/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i";

	preg_match_all($patten, $content, $match);

	if ($match[1]) {
		foreach ($match[1] as $link) {
			$url = parse_url($link);
			if ($url['host'] && $url['host'] != $_SERVER['HTTP_HOST']) {
				$image = apms_save_image($link, $url['path']);
				if ($image)	{
					$content = str_replace($link, $image, $content);
				}
			}
		}
	}

	$content = addslashes($content);

	return $content;
}

// SQL Injection 대응 문자열 필터링
function apms_escape($s, $opt='0') {
	global $qstr;

	if (isset($_REQUEST[$s])) {
		$str = trim($_REQUEST[$s]);
		$str = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", $str);
		if($opt && $str) 
			$qstr .= '&amp;'.$s.'='.urlencode($str);
	} else {
		$str = '';
	}

	return $str;
}

function apms_escape_string($str) {
	$str = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", trim($str));
	return $str;
}

// sns 공유하기
function get_sns_share_link($sns, $url, $title, $img='', $thumb_url='')
{
    global $config;

    if(!$sns)
        return '';

	$sns_url = $url;
	$sns_msg = str_replace('\"', '"', strip_tags($title));
	$sns_msg = str_replace('\'', '', $sns_msg);
	$sns_send  = G5_BBS_URL.'/sns_send.php?longurl='.urlencode($sns_url).'&amp;title='.urlencode($sns_msg);

    switch($sns) {
        case 'facebook':
			$facebook_url = $sns_send.'&amp;sns=facebook';
			$str = 'apms_sns(\'facebook\', \''.$facebook_url.'\'); return false;';
			if($img) $str = '<a href="'.$facebook_url.'" onclick="'.$str.'" target="_blank"><img src="'.$img.'" alt="페이스북에 공유"></a>';
            break;
        case 'twitter':
			$twitter_url = $sns_send.'&amp;sns=twitter';
			$str = 'apms_sns(\'twitter\', \''.$twitter_url.'\'); return false;';
			if($img) $str = '<a href="'.$twitter_url.'" onclick="'.$str.'" target="_blank"><img src="'.$img.'" alt="트위터에 공유"></a>';
			break;
        case 'googleplus':
			$gplus_url = $sns_send.'&amp;sns=gplus';
            $str = 'apms_sns(\'googleplus\', \''.$gplus_url.'\'); return false;';
			if($img) $str = '<a href="'.$gplus_url.'" onclick="'.$str.'" target="_blank"><img src="'.$img.'" alt="구글플러스에 공유"></a>';
            break;
        case 'naverband':
			$naverband_url = $sns_send.'&amp;sns=naverband';
			$str = 'apms_sns(\'naverband\', \''.$naverband_url.'\'); return false;';
			if($img) $str = '<a href="'.$naverband_url.'" onclick="'.$str.'" target="_blank"><img src="'.$img.'" alt="네이버밴드에 공유"></a>';
            break;
        case 'kakaostory':
			$kakaostory_url = $sns_send.'&amp;sns=kakaostory';
            $str = 'apms_sns(\'kakaostory\', \''.$kakaostory_url.'\'); return false;';
			if($img) $str = '<a href="'.$kakaostory_url.'" onclick="'.$str.'" target="_blank"><img src="'.$img.'" alt="카카오스토리에 공유"></a>';
            break;
		case 'kakaotalk':
            if($config['cf_kakao_js_apikey'] && G5_IS_MOBILE) {
				if(!defined('APMS_KAKAO')) {
					define('APMS_KAKAO', true);
					echo '<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>'.PHP_EOL;
					echo '<script src="'.G5_JS_URL.'/kakaolink.js"></script>'.PHP_EOL;
					echo '<script>Kakao.init("'.$config['cf_kakao_js_apikey'].'");</script>'.PHP_EOL;
				}
				$kakaothumb = ($thumb_url) ? apms_thumbnail($thumb_url, 300, 0) : '';
				$str = 'javascript:kakaolink_send(\''.$sns_msg.'\', \''.$sns_url.'\',\''.$kakaothumb['src'].'\', \'300\', \''.$kakaothumb['height'].'\'); return false;';
				if($img) $str = '<a href="'.$str.'"><img src="'.$img.'" alt="카카오톡으로 보내기"></a>';
			}
			break;
    }

    return $str;
}

//----------------------------------------------------------------//
// 추출 관련 함수들
//----------------------------------------------------------------//

// 옵션
function apms_options($pc, $mobile=''){

	$wos = apms_query($pc);
	if(G5_IS_MOBILE) {
		$mobile = apms_query($mobile);
		if($wos && $mobile) {
			$wos = array_merge($wos, $mobile);
		}
	}

	if($wos['slide']) 
		list($wos['slide'], $wos['slide_garo'], $wos['slide_sero']) = explode(",", $wos['slide']);

	if($wos['carousel'])
		list($wos['carousel'], $wos['interval']) = explode(",", $wos['carousel']);

	if($wos['thumb'])
		list($wos['thumb_w'], $wos['thumb_h']) = explode("x", $wos['thumb']);

	return $wos;
}

// 위젯 캐시
function apms_widget_cache($widget_file, $wname, $wid, $wset, $add=''){
	global $g5, $is_wdir;

	if($is_wdir) {
		$widget_url = G5_URL.$is_wdir.'/'.$wname;
		$widget_path = G5_PATH.$is_wdir.'/'.$wname;
	} else {
		if($add) { // 애드온
			$widget_url = G5_SKIN_URL.'/addon/'.$wname;
			$widget_path = G5_SKIN_PATH.'/addon/'.$wname;
		} else {
			$widget_url = THEMA_URL.'/widget/'.$wname;
			$widget_path = THEMA_PATH.'/widget/'.$wname;
		}
	}

	if(!file_exists($widget_file)) return;

	if($wset['cache'] > 0) { //캐시 적용시
		if($add) {
			$c_name = (G5_IS_MOBILE) ? 'aid_'.$wid.'_m' : 'aid_'.$wid; //애드온 캐시아이디
		} else {
			$c_name = (G5_IS_MOBILE) ? 'wid_'.$wid.'_m' : 'wid_'.$wid; //위젯 캐시아이디
		}
		$result = sql_fetch(" select c_name, c_text, c_datetime from {$g5['apms_cache']} where c_name = '$c_name' ", false);
		if (!$result) {
			// 시간을 offset 해서 입력 (-1을 해줘야 처음 call에 캐쉬를 만듭니다)
			$new_cachetime = date("Y-m-d H:i:s", G5_SERVER_TIME - $wset['cache'] - 1);
			$result['c_datetime'] = $new_cachetime;
			sql_query(" insert into {$g5['apms_cache']} set c_name='$c_name', c_datetime='$new_cachetime' ", false);
		}

		$sec_diff = G5_SERVER_TIME - strtotime($result['c_datetime']);
		if ($sec_diff > $wset['cache']) {
			ob_start();
			@include($widget_file);
			$widget = ob_get_contents();
			ob_end_clean();

			if (trim($widget) == "")
				return;

			sql_query(" update {$g5['apms_cache']} set c_text = '".addslashes($widget)."', c_datetime='".G5_TIME_YMDHIS."' where c_name = '$c_name' ", false);

		} else {
			$widget = $result['c_text'];
		}
	} else {
	    ob_start();
		@include ($widget_file);
	    $widget = ob_get_contents();
		ob_end_clean();
	}

	return $widget;
}

// 위젯타이틀링크
function apms_widget_title_link($wset){

	if(!$wset['thid']) return;

	switch($wset['tlink']) {
		case 'board'	: $href = G5_BBS_URL.'/board.php?bo_table='.urlencode($wset['thid']); break;
		case 'shop'		: $href = G5_SHOP_URL.'/list.php?ca_id='.urlencode($wset['thid']); break;
		case 'link'		: $href = $wset['thid']; break;
		default			: $href = ''; break;
	}

	return $href;
}

// 위젯타이틀링크
function apms_widget_config($wid, $opt='', $add=''){
	global $g5;

	switch($add) {
		case '1'	: $type = 101; break; // 애드온
		case '99'	: $type = 99; break; // 아이템 목록
		default		: $type = 100; break;
	}

	$row = sql_fetch("select data_set, data_1 from {$g5['apms_data']} where type = '$type' and data_q = '$wid' limit 1 ", false);

	if($row['data_set']) { 
		$wset = apms_unpack($row['data_set']);
		if(G5_IS_MOBILE && $wset && $row['data_1']) {
			$wset = array_merge($wset, apms_unpack($row['data_1']));
		}
	} else if($opt) {
		$wset = apms_query($opt);
	}

	if($wset['title'] && $wset['tlink'] && $wset['thid']) { // 타이틀 링크
		$wset['tlink'] = apms_widget_title_link($wset);
	}

	return $wset;
}

// 위젯
function apms_widget($wname, $wid='', $opt='', $add=''){
	global $is_admin, $is_demo, $is_wdir;

	if($is_wdir) {
		$widget_url = G5_URL.$is_wdir.'/'.$wname;
		$widget_path = G5_PATH.$is_wdir.'/'.$wname;
	} else {
		if($add) { // 애드온
			$widget_url = G5_SKIN_URL.'/addon/'.$wname;
			$widget_path = G5_SKIN_PATH.'/addon/'.$wname;
		} else {
			$widget_url = THEMA_URL.'/widget/'.$wname;
			$widget_path = THEMA_PATH.'/widget/'.$wname;
		}
	}

	if(!file_exists($widget_path.'/widget.php')) return;

	$wid = apms_escape_string($wid);

	if($wid) {
		$wset = apms_widget_config($wid, $opt, $add);
		$setup_href = '';
		if($is_demo || $is_wdir || $is_admin == 'super') {
			$setup_href = G5_BBS_URL.'/widget.setup.php?wid='.urlencode($wid).'&amp;wname='.urlencode($wname).'&amp;thema='.urlencode(THEMA);
			if($add) $setup_href .= '&amp;add=1';
			if($opt) $setup_href .= '&amp;opt='.urlencode($opt);
			if($is_demo) $setup_href .= '&amp;wdemo=1';
			if($is_wdir) $setup_href .= '&amp;wdir='.urlencode($is_wdir);
		}
	}

    ob_start();
	@include ($widget_path.'/widget.php');
    $widget = ob_get_contents();
	ob_end_clean();

	return $widget;
}

// 애드온
function apms_addon($wname, $wid='', $opt=''){

	return apms_widget($wname, $wid, $opt='', 1);

}

// 기간
function apms_sql_term($term, $field) {

	$sql_term = '';

	if($term && $field) {
		if($term > 0) {
			$chk_term = date("Y-m-d H:i:s", G5_SERVER_TIME - ($term * 86400));
			$sql_term = " and $field >= '{$chk_term}' ";
		} else {
			$day = getdate();
			$today = $day['year'].'-'.sprintf("%02d",$day['mon']).'-'.sprintf("%02d",$day['mday']).' 00:00:01';	// 오늘
			$yesterday = date("Y-m-d", (G5_SERVER_TIME - 86400)).' 00:00:01'; // 어제
			$nowmonth = $day['year'].'-'.sprintf("%02d",$day['mon']).'-01 00:00:01'; // 이번달

			// 지난달
			if($day['mon'] == "1") { //1월이면
				$prevyear = $day['year'] - 1;
				$prevmonth = $prevyear.'-12-01 00:00:01';
			} else {
				$prev = $day['mon'] - 1;
				$prevmonth = $day['year'].'-'.sprintf("%02d",$prev).'-01 00:00:01';
			}

			switch($term) {
				case 'today'		: $sql_term = " and $field >= '{$today}'"; break;
				case 'yesterday'	: $sql_term = " and $field >= '{$yesterday}' and $field < '{$today}'"; break;
				case 'month'		: $sql_term = " and $field >= '{$nowmonth}'"; break;
				case 'prev'			: $sql_term = " and $field >= '{$prevmonth}' and $field < '{$nowmonth}'"; break;
			}
		}
	}

	return $sql_term;
}

// 그룹보드 추출
function apms_group_board($gr_list) {
	global $g5;

	if(!$gr_list) return;

	$bo_list = '';
	$result = sql_query(" select bo_table from {$g5['board_table']} where find_in_set(gr_id, '{$gr_list}') ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		if($i > 0) $bo_list .= ',';
		$bo_list .= $row['bo_table'];
	}

	return $bo_list;
}

// 글추출
function apms_board_rows($arr) {
	global $g5, $member;

	$list = array();

	//정리
	$mode = 'post';
	$sql_mode1 = 0;
	$sql_mode2 = "wr_parent = wr_id";
	if($arr['comment']) {
		$mode = 'comment';
		$sql_mode1 = 1;
		$sql_mode2 = "wr_parent <> wr_id";
	}
	$except = ($arr['except']) ? 1 : 0;
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 7;
	$page = ($arr['page'] > 1) ? $arr['page'] : 1;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = ($arr['thumb_no']) ? true : false;
	$bo_list = ($arr['gr_list']) ? apms_escape_string($arr['gr_list']) : apms_escape_string($arr['bo_list']);
	$main = apms_escape_string($arr['main']);
	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_main = ($main) ? "and as_type = '$main'" : "";
	$start_rows = 0;

	//그룹추출
	$bo_table = ($arr['gr_list']) ? apms_group_board($bo_list) : $bo_list;

	// 회원글
	$sql_mb = "";
	if($arr['mb_list']) {
		$sql_mb = ($arr['ex_mb']) ? "and find_in_set(mb_id, '{$arr['mb_list']}')=0" : "and find_in_set(mb_id, '{$arr['mb_list']}')";
	} else {
		if($arr['mb'] && $arr['mb_re']) {
			$sql_mb = "and (mb_id = '{$member['mb_id']}' or as_re_mb = '{$member['mb_id']}')";
		} else if(!$arr['mb'] && $arr['mb_re']) {
			$sql_mb = "and as_re_mb = '{$member['mb_id']}'";
		} else if($arr['mb'] && !$arr['mb_re']) {
			$sql_mb = "and mb_id = '{$member['mb_id']}'";
		}
	}

	// 정렬(asc,hit,comment,good,nogood,poll,download,lucky,rdm)
	switch($arr['sort']) { 
		case 'asc'			: $orderby1 = 'bn_id'; $orderby2 = 'wr_id'; break;
		case 'date'			: $orderby1 = 'bn_datetime desc'; $orderby2 = 'wr_datetime desc'; break;
		case 'hit'			: $orderby1 = 'as_hit desc'; $orderby2 = 'wr_hit desc'; break;
		case 'comment'		: $orderby1 = 'as_comment desc'; $orderby2 = 'wr_comment desc'; break;
		case 'good'			: $orderby1 = 'as_good desc'; $orderby2 = 'wr_good desc'; break;
		case 'nogood'		: $orderby1 = 'as_nogood desc'; $orderby2 = 'wr_nogood desc'; break;
		case 'like'			: $orderby1 = '(as_good - as_nogood) desc'; $orderby2 = '(wr_good - wr_nogood) desc'; break;
		case 'download'		: $orderby1 = 'as_download desc'; $orderby2 = 'as_download desc'; break;
		case 'link'			: $orderby1 = 'as_link desc'; $orderby2 = '(wr_link1_hit + wr_link2_hit) desc'; break;
		case 'poll'			: $orderby1 = 'as_poll desc'; $orderby2 = 'as_poll desc'; break;
		case 'lucky'		: $orderby1 = 'as_lucky desc'; $orderby2 = 'as_lucky desc'; break;
		case 'rdm'			: $orderby1 = 'rand()'; $orderby2 = 'rand()'; $page = 1; break;
		default				: $orderby1 = 'bn_id desc'; $orderby2 = 'wr_id desc'; break;
	}

	// 게시판아이디 체크
	$board_cnt = explode(",", $bo_table);

	if(!$bo_table || count($board_cnt) > 1 || $except) { //복수
		$sql_term = apms_sql_term($term, 'bn_datetime'); // 기간(일수,today,yesterday,month,prev)
		$sql_find = '';
		if($bo_table) {
			$sql_find = ($except) ? "and find_in_set(bo_table, '{$bo_table}')=0" : "and find_in_set(bo_table, '{$bo_table}')";
		}

		$sql_common = "from {$g5['board_new_table']} where $sql_mode2 $sql_find $sql_term $sql_main $sql_mb";
		if($page > 1) {
			$total = sql_fetch("select count(*) as cnt $sql_common ", false);
			$total_count = $total['cnt'];
			$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
			$start_rows = ($page - 1) * $rows; // 시작 열을 구함
		}
		$result = sql_query(" select *  $sql_common order by $orderby1 limit $start_rows, $rows ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

			$post = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ", false);
			$post['img_row'] = $arr['img_rows'];
			$post['is_thumb_no'] = $thumb_no;
			$list[$i] = thema_widget_write_list($mode, $row['bo_table'], $post, $new, $thumb_w, $thumb_h, false, true);
			if($thumb_w) {
				if(!$list[$i]['img']['src'] && $arr['no_img']) {
					if($thumb_no) {
						$list[$i]['img']['src'] = $arr['no_img'];
					} else {
						$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
					}
				}
			}
		}
	} else { //단수
		$sql_term = apms_sql_term($term, 'wr_datetime'); // 기간(일수,today,yesterday,month,prev)
		$sca_query = "";
		if($arr['ca_list']) {
			$sca_query = ($arr['ex_ca']) ? "and find_in_set(ca_name, '{$arr['ca_list']}')=0" : "and find_in_set(ca_name, '{$arr['ca_list']}')";
		}
		$tmp_write_table = $g5['write_prefix'] . $bo_table;
		$sql_common = "from $tmp_write_table where wr_is_comment = '{$sql_mode1}' $sca_query $sql_term $sql_main $sql_mb";
		if($page > 1) {
			$total = sql_fetch("select count(*) as cnt $sql_common ", false);
			$total_count = $total['cnt'];
			$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
			$start_rows = ($page - 1) * $rows; // 시작 열을 구함
		}
		$result = sql_query(" select * $sql_common order by $orderby2 limit $start_rows, $rows ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) { 
			$post['img_row'] = $arr['img_rows'];
			$post['is_thumb_no'] = $thumb_no;
			$list[$i] = thema_widget_write_list($mode, $bo_table, $row, $new, $thumb_w, $thumb_h, false, true); //글가공
			if($thumb_w) {
				if(!$list[$i]['img']['src'] && $arr['no_img']) {
					if($thumb_no) {
						$list[$i]['img']['src'] = $arr['no_img'];
					} else {
						$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
					}
				}
			}
		}
	}

	return $list;
}

// 회원추출
function apms_member_rows($arr) {
	global $g5, $config, $xp;

	$list = array();

	//정리
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 5;
	$field = $mb_cnt = '';
	switch($arr['mode']) {
		case 'point'	: $orderby = 'mb_point desc'; $mb_cnt = 'mb_point'; $field = 'po_datetime'; break;
		case 'level'	: $orderby = 'as_exp desc';  $mb_cnt = 'as_exp'; break;
		case 'follow'	: $orderby = 'as_followed desc, as_exp desc';  $mb_cnt = 'as_followed'; break;
		case 'like'		: $orderby = 'as_liked desc, as_exp desc';  $mb_cnt = 'mb_liked'; break;
		case 'new'		: $orderby = 'mb_datetime desc'; break; 
		case 'recent'	: $orderby = 'mb_today_login desc'; break; 
		case 'post'		: $field = 'bn_datetime'; break; 
		case 'comment'	: $field = 'bn_datetime'; break; 
		case 'chulsuk'	: $field = 'wr_datetime'; break;
		case 'connect'	: break; 
		default			: return; break;
	}

	$sql_ex = "and mb_leave_date = '' and mb_intercept_date = ''";

	//제외회원
	$ex_mb = $config['cf_admin'];
	if($arr['ex_mb']) $ex_mb .= ','.apms_escape_string($arr['ex_mb']);

	$sql_board = ''; //보드체크
	if($arr['mode'] == 'connect') { //현재접속회원
		$sql_photo = ($arr['photo']) ? "and b.as_photo = '1'" : "";
		$sql = " select a.mb_id, b.mb_level, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, b.as_level, b.as_photo, a.lo_ip, a.lo_location, a.lo_url
					from {$g5['login_table']} a left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
					where a.mb_id <> '' and find_in_set(a.mb_id, '{$ex_mb}')=0 $sql_photo
					order by a.lo_datetime desc ";

	} else if($arr['mode'] == 'post' || $arr['mode'] == 'comment') { //글,댓글
		if($arr['gr_list'] || $arr['bo_list']) {
			$bo_list = ($arr['gr_list']) ? apms_escape_string($arr['gr_list']) : apms_escape_string($arr['bo_list']);
			$bo_table = ($arr['gr_list']) ? apms_group_board($bo_list) : $bo_list;
			$sql_board = ($arr['except']) ? "and find_in_set(bo_table, '{$bo_table}')=0" : "and find_in_set(bo_table, '{$bo_table}')";
		}
		$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
		$sql_term = apms_sql_term($term, $field); // 기간(일수,today,yesterday,month,prev)
		$sql_mode = ($arr['mode'] == 'comment') ? "and wr_parent <> wr_id" : "and wr_parent = wr_id";
		$sql = " select mb_id, count(mb_id) as cnt 
					from {$g5['board_new_table']} 
					where mb_id <> '' and find_in_set(mb_id, '{$ex_mb}')=0 $sql_mode $sql_term $sql_board group by mb_id 
					order by cnt desc limit 0, $rows ";

	} else if($arr['mode'] == 'point' && $arr['term']) { //포인트(기간)
		if($arr['gr_list'] || $arr['bo_list']) {
			$bo_list = ($arr['gr_list']) ? apms_escape_string($arr['gr_list']) : apms_escape_string($arr['bo_list']);
			$bo_table = ($arr['gr_list']) ? apms_group_board($bo_list) : $bo_list;
			$sql_board = ($arr['except']) ? "and find_in_set(bo_table, '{$bo_table}')=0" : "and find_in_set(bo_table, '{$bo_table}')";
		}
		$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
		$sql_term = apms_sql_term($term, $field); // 기간(일수,today,yesterday,month,prev)
		$sql = " select mb_id, sum(po_point) as cnt from {$g5['point_table']} 
					where find_in_set(mb_id, '{$ex_mb}')=0 and po_point > 0 $sql_term $sql_board
					group by mb_id order by cnt desc limit 0, $rows ";

	} else if($arr['mode'] == 'chulsuk') { //출석
		$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
		$sql_term = apms_sql_term($term, $field); // 기간(일수,today,yesterday,month,prev)
		$sql = " select mb_id, count(mb_id) as cnt from {$g5['write_prefix']}{$arr['bo_table']} 
					where wr_is_comment = '0' and mb_id <> '' and find_in_set(mb_id, '{$ex_mb}')=0 $sql_term group by mb_id 
					order by cnt desc limit 0, $rows ";

	} else if($arr['mode'] == 'recent') { //최근 접속회원
		$sql_photo = ($arr['photo']) ? "and as_photo = '1'" : "";
		$sql = "select * from {$g5['member_table']} 
					where find_in_set(mb_id, '{$ex_mb}')=0 $sql_photo $sql_ex
					order by $orderby limit 0, $rows ";

	} else {
		$sql_photo = ($arr['photo']) ? "and as_photo = '1'" : "";
		$sql = " select *, $mb_cnt as cnt from {$g5['member_table']} 
					where find_in_set(mb_id, '{$ex_mb}')=0 $sql_ex $sql_photo 
					order by $orderby limit 0, $rows ";
	}

	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = ($row['mb_id'] && $row['mb_name']) ? $row : get_member($row['mb_id']);
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['photo'] = apms_photo_url($list[$i]['mb_id']);
		if(!$list[$i]['photo'] && $arr['no_photo']) {
			$list[$i]['photo'] = $arr['no_photo']; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage'], $list[$i]['as_level']);
	}
	return $list;
}

// 태그추출
function apms_tag_rows($arr) {
	global $g5;

	$list = array();
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 10;
	$orderby = ($arr['new']) ? "lastdate desc," : "";
	$sql = " select * from {$g5['apms_tag']} where cnt > 0 order by $orderby cnt desc, type, idx, tag limit 0, $rows ";
	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = thema_widget_write_list('tag', 'tag', $row);
	}
	return $list;
}

// 태그 관련글 추출
function apms_tag_post_rows($arr) {
	global $g5;

	$list = array();
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 7;
	$new = ($arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = ($arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = ($arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = ($arr['thumb_no']) ? true : false;

	if($arr['gr_list'] || $arr['bo_list']) {
		$bo_list = ($arr['gr_list']) ? apms_escape_string($arr['gr_list']) : apms_escape_string($arr['bo_list']);
		$bo_table = ($arr['gr_list']) ? apms_group_board($bo_list) : $bo_list;
		$sql_board = ($arr['except']) ? "and find_in_set(bo_table, '{$bo_table}')=0" : "and find_in_set(bo_table, '{$bo_table}')";
	}

	$result = sql_query(" select bo_table, wr_id from {$g5['apms_tag_log']} where bo_table <> '' $sql_board group by bo_table, wr_id order by regdate desc limit 0, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

		$post = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ", false);
		$post['img_row'] = $arr['img_rows'];
		$list[$i] = thema_widget_write_list('post', $row['bo_table'], $post, $new, $thumb_w, $thumb_h, false, true);
		if($thumb_w) {
			if(!$list[$i]['img']['src'] && $arr['no_img']) {
				if($thumb_no) {
					$list[$i]['img']['src'] = $arr['no_img'];
				} else {
					$list[$i]['img'] = apms_thumbnail($arr['no_img'], $thumb_w, $thumb_h, false, true); // no-image
				}
			}
		}
	}

	return $list;
}

// 인기검색어추출
function apms_popular_rows($arr) {
	global $g5;

	$list = array();
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 10;
	$term = ($arr['term'] == 'day' && $arr['dayterm'] > 0) ? $arr['dayterm'] : $arr['term'];
	$sql_term = apms_sql_term($term, 'pp_date'); // 기간(일수,today,yesterday,month,prev)
	$sql = " select pp_word, count(pp_word) as cnt from {$g5['popular_table']} 
				where 1 $sql_term group by pp_word 
				order by cnt desc limit 0, $rows ";
	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['word'] = get_text($row['pp_word']);
		$list[$i]['href'] = G5_BBS_URL.'/search.php?stx='.urlencode($list[$i]['word']);
	}
	return $list;
}

// 설문조사추출
function apms_poll_rows($arr) {
	global $g5;

	$list = array();
	$rows = ($arr['rows'] > 0) ? $arr['rows'] : 1;
	$sql_po = '';
	if($arr['po_list']) {
		$sql_po = ($arr['except']) ? "and find_in_set(po_id, '{$arr['po_list']}')=0" : "and find_in_set(po_id, '{$arr['po_list']}')";
	} 

	$result = sql_query(" select * from {$g5['poll_table']} where 1 $sql_po order by po_id desc limit 0, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
	}

	return $list;
}

//라벨리스트
function apms_label_list($set) {

	$label = array();
	$labels = ($set['demo']) ? explode(";", $set['label_list']) : explode("\n", $set['label_list']);
	$label_num = count($labels);
	$z = 0;
	for($i=0; $i < $label_num; $i++) {
		list($name, $color, $text) = explode("|", $labels[$i]);

		if(!$name) continue;

		$label[$z]['name'] = explode(",", trim($name));
		$label[$z]['cnt'] = count($label[$z]['name']);
		$label[$z]['color'] = trim($color);
		$label[$z]['txt'] = trim($text);
		$z++;
	}

	return $label;
}

// 라벨아이콘
function apms_label_icon($label, $labels, $cnt, $name, $color) {

	if(!$cnt) return;

	$is_label = false;
	for ($i=0; $i < $cnt; $i++) {

		if(!$labels[$i]['cnt']) continue;
		
		if($label && in_array($label, $labels[$i]['name'])) {
			$sel_name = $labels[$i]['txt'];
			$sel_color = $labels[$i]['color'];
			$is_label = true;
			break;
		}
	}

	if($is_label) {
		$arr = array($sel_name, $sel_color);
	} else {
		$name = ($name) ? $name : $label;
		$arr = array($name, $color);
	}

	return $arr;
}

// Shadw
function apms_shadow($name='') {

	switch($name) {
		case '2'	: break;
		case '3'	: break;
		case '4'	: break;
		default		: $name = '1'; break;
	}

	$line = '<div class="shadow-line"><img src="'.G5_IMG_URL.'/shadow'.$name.'.png"></div>'.PHP_EOL;

	return $line;
}

// Line
function apms_line($type='', $name='fa-chevron-down', $color='') {

	if($type == 'fa') {
		$line = '<div class="div-separator"><span class="div-sep-icon"><i class="fa '.$name.'"></i></span></div>'.PHP_EOL;
		$line .= '<div class="div-sep-line"></div>'.PHP_EOL;
	} else if($type == 'shadow') {
		$line = '<div class="div-separator sep-shadow"></div>'.PHP_EOL;
	}

	return $line;
}

// Image Height
function apms_img_height($thumb_w, $thumb_h, $height='56.25') {

	$height = ($thumb_w > 0 && $thumb_h > 0) ? round(($thumb_h / $thumb_w) * 100, 2) : $height;

	return $height;
}

// Image Width
function apms_img_width($cols) {

	$width = ($cols > 0) ? $cols : 3;
	$width = (int)((100 / $width) * 100);
	$width = $width / 100;

	return $width;
}

// Rank Start Num
function apms_rank_offset($rows, $page) {

	$rank = ($rows > 0 && $page > 1) ?  (($page - 1) * $rows + 1) : 1;

	return $rank;
}

// Carousel Effect
function apms_carousel_effect($effect='') {

	switch($effect) {
		case 'fade'		: $effect = ' slide at-fade'; break;
		case 'up'		: $effect = ' slide at-vertical'; break;
		case 'slide'	: $effect = ' slide'; break;
		default			: $effect = ''; break;
	}

	return $effect;
}

// Carousel Interval
function apms_carousel_interval($interval='0') {

	$interval = ($interval > 0) ? $interval : 'false';

	return $interval;
}

// Color
function apms_color($color) {

	switch($color) {
		case 'red'			: $color = 'rgb(233, 27, 35)'; break;
		case 'darkred'		: $color = 'rgb(170, 60, 63)'; break;
		case 'crimson'		: $color = 'rgb(220, 20, 60)'; break;
		case 'orangered'	: $color = 'orangered'; break;
		case 'orange'		: $color = 'rgb(243, 156, 18)'; break;
		case 'green'		: $color = 'rgb(142, 196, 73)'; break;
		case 'lightgreen'	: $color = 'rgb(160, 206, 78)'; break;
		case 'deepblue'		: $color = 'rgb(26, 128, 182)'; break;
		case 'skyblue'		: $color = 'rgb(108, 197, 244)'; break;
		case 'blue'			: $color = 'rgb(52, 152, 219)'; break;
		case 'navy'			: $color = 'rgb(52, 61, 70)'; break;
		case 'violet'		: $color = 'rgb(86, 61, 124)'; break;
		case 'yellow'		: $color = 'rgb(241, 196, 15)'; break;
		case 'darkgray'		: $color = 'rgb(102, 98, 98)'; break;
		case 'gray'			: $color = 'rgb(136, 136, 136)'; break;
		case 'lightgray'	: $color = 'rgb(208, 208, 208)'; break;
		case 'white'		: $color = 'rgb(255, 255, 255)'; break;
		case 'light'		: $color = '#f5f5f5'; break;
		default				: $color = 'rgb(51, 51, 51)'; break;
	}

	return $color;
}

// Category Divider
function apms_bunhal($cnt, $num, $opt='') {

	if(!$cnt || !$num) return;

	$w1 = floor((100 / $cnt) * 100) / 100;
	$w2 = floor((100 / $num) * 100) / 100;
	$width = ($w1 < $w2) ? $w2 : $w1;
	$width = ($opt) ? 'width:'.$width.'%;' : ' style="width:'.$width.'%;"';

	return $width;

}

?>