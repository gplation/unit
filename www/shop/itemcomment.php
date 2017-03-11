<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');
}

if(!$it['it_id']) {
	$it = sql_fetch(" select it_id, ca_id, pt_id, pt_comment_use from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");
	$is_comment = ($it['pt_comment_use']) ? true : false;
}

if(!$is_comment) return;

if(!$is_item) {
	if(!$ca_id) $ca_id = $it['ca_id'];
	if(!$item_skin_path) {
		$at = apms_ca_thema($ca_id, $ca, 1);
		include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$at['item'];
		$item_skin_url = G5_SKIN_URL.'/apms/item/'.$at['item'];
	}

	// 파트너 체크
	if(!$it['it_id']) {
		$it = sql_fetch(" select pt_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");
	}
	$is_auther = ($is_member && $it['pt_id'] && $it['pt_id'] == $member['mb_id']) ? true : false;
	$author_id = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin'];

	// 출력수
	if(!$crows) $itemrows = apms_rows('icomment_'.MOBILE_.'rows');

	// 스킨설정
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$wset = array();
	if($ca['as_'.MOBILE_.'item_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
	}
}

// 코멘트를 새창으로 여는 경우 세션값이 없으므로 생성한다.
if ($is_admin && !$token) {
    set_session("ss_delete_token", $token = uniqid(time()));
}

// 아이피
$is_ip_view = ($is_admin) ? true : false;

// SNS 동시등록
$board['bo_use_sns'] = ($default['pt_comment_sns']) ? true : false;

$is_shingo = ($default['pt_shingo'] > 0) ? true : false;

$list = array();

// 댓글권한
$is_comment_write = false;
if ($is_member && $it['pt_comment_use']) {
	if($is_admin != 'super' && $it['pt_comment_use'] == "2") {
	    $is_comment_write = ($is_author) ? true : false;
	} else {
	    $is_comment_write = true;
	}
}
$is_author_comment = ($it['pt_comment_use'] == "2") ? true : false;

// 댓글 출력
$sql_common = " from {$g5['apms_comment']} where it_id = '$it_id' ";

if($is_item) {
	$page = 0;
	$total_count = $it['pt_comment'];
} else {
	$sql = " select count(wr_id) as cnt " . $sql_common;
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];
}

// 댓글갯수
$crows = ($crows > 0) ? $crows : $itemrows['icomment_'.MOBILE_.'rows'];
$crows = ($crows > 0) ? $crows : 20;

$total_page  = ceil($total_count / $crows);  // 전체 페이지 계산
if($page > 0) {
	;
} else {
	$page = $total_page; // 페이지가 없으면 마지막 페이지
}
$from_record = ($page - 1) * $crows; // 시작 열을 구함
if($from_record < 0)
	$from_record = 0;

$sql = " select * $sql_common order by wr_comment, wr_comment_reply limit $from_record, $crows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['name'] = apms_sideview($row['mb_id'], $row['wr_name'], $row['wr_email'], $row['wr_homepage'], $row['wr_level']);

	$list[$i]['is_lock'] = ($row['wr_shingo'] < 0) ? true : false;

	$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['wr_re_name']) ? $row['wr_re_name'] : '';

	$is_content = false;
    $list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
    if (!strstr($row['wr_option'], 'secret') || $is_admin || ($it['pt_id']==$member['mb_id'] && $it['pt_id']) || ($row['mb_id']==$member['mb_id'] && $member['mb_id'])) {
        $list[$i]['content1'] = $row['wr_content'];
        $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');

		if($is_shingo && $row['wr_shingo'] < 0) {
			if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
				$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>'.$list[$i]['content'];
			} else {
				$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
			}

		}

		$is_content = true;
	} else {
		// 대댓글의 비밀글을 원댓글쓴이에게도 보이기
		$is_pre_commenter = false;
		if($row['wr_comment_reply']) {
			if($row['wr_re_mb']) {
				if($member['mb_id'] && $row['wr_re_mb'] == $member['mb_id']) {
					$is_pre_commenter = true;
				}
			} else {
				$pre_comment = sql_fetch(" select mb_id from {$g5['apms_comment']} where wr_id = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
				if($member['mb_id'] && $pre_comment['mb_id'] == $member['mb_id']) {
					$is_pre_commenter = true;
				}
			}
		}

        if($is_pre_commenter) {
            $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');

			if($is_shingo && $row['wr_shingo'] < 0) {
				if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
					$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>'.$list[$i]['content'];
				} else {
					$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
				}
			}

			$is_content = true;
		} 
    }

	if($is_content) { // 변환
		$list[$i]['content'] = preg_replace("/\[<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp).*<\/a>(\s\]|\]|)/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" class=\"item_image\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $list[$i]['content']);
		$list[$i]['content'] = apms_content($list[$i]['content']);
	}

	//럭키포인트
	if($row['wr_lucky']) {
		$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['wr_lucky']), APMS_LUCKY_TEXT);
	}

    $list[$i]['date'] = strtotime($list[$i]['wr_datetime']);

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

    $list[$i]['is_reply'] = false;
    $list[$i]['is_edit'] = false;
    $list[$i]['is_del']  = false;

    if ($is_comment_write || $is_admin) {
        if ($member['mb_id']) {
            if ($row['mb_id'] == $member['mb_id'] || $is_admin) {
                $list[$i]['del_href']  = './itemcommentdelete.php?it_id='.$it_id.'&comment_id='.$row['wr_id'].'&token='.$token;
                $list[$i]['del_return']  = './itemcomment.php?it_id='.$it_id.'&ca_id='.$ca_id.'&crows='.$crows.'&page='.$page;
				$list[$i]['is_edit']   = true;
                $list[$i]['is_del']    = true;
            }
        }
		if (strlen($row['wr_comment_reply']) < 5) {
            $list[$i]['is_reply'] = true;
            $list[$i]['reply_link'] = '';
		}
    }

    // 05.05.22
    // 답변있는 코멘트는 수정, 삭제 불가
    if ($i > 0 && !$is_admin) {
        if ($row['wr_comment_reply']) {
            $tmp_comment_reply = substr($row['wr_comment_reply'], 0, strlen($row['wr_comment_reply']) - 1);
            if ($tmp_comment_reply == $list[$i-1]['wr_comment_reply']) {
                $list[$i-1]['is_edit'] = false;
                $list[$i-1]['is_del'] = false;
            }
        }
    }
}

$itemcomment_url = './itemcomment.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;crows='.$crows;
$itemcomment_login_url = G5_BBS_URL.'/login.php?url='.$urlencode;
$itemcomment_action_url = './itemcommentupdate.php';
$is_comment_sns = ($default['pt_comment_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) ? true : false;

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemcomment.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;crows='.$crows.'&amp;page=';

if($w == '') $w = 'c';

include_once($item_skin_path.'/itemcomment.skin.php');

unset($list);

?>
