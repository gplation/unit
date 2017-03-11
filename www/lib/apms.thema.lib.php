<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 그룹아이디
$grid = ($at['gid']) ? $at['gid'] : $gr_id;

if($bo_table) { //Board
	$page_title = $board['as_title'];
	$page_desc = $board['as_desc'];
	$is_wide_layout = $board['as_wide'];
} else {
	$page_title = $at['title'];
	$page_desc = $at['desc'];
	$is_wide_layout = $at['wide'];
}

// 인덱스에서는 무조건 와이드로...
if($is_index) {
	$is_wide_layout = true;
}

// Shop Check
if(IS_YC) {
	if(!defined('IS_SHOP')) {
		if(isset($default['de_shop_layout_use']) && $default['de_shop_layout_use']) {
			define('IS_SHOP', true);
		} else {
			if($grid && $group['as_shop']) {
				define('IS_SHOP', true);
			} else if($at['shop']) {
				define('IS_SHOP', true);
			} else {
				define('IS_SHOP', false);
			}
		}
	}
} else {
	define('IS_SHOP', false);
}

//Link Href
$at_href['css'] = $chk_host['path'] ? $_SERVER['HTTP_HOST'].$chk_host['path'] : $_SERVER['HTTP_HOST'];
$at_href['reg'] = G5_BBS_URL.'/register.php';
$at_href['login'] = ($urlencode) ? G5_BBS_URL.'/login.php?url='.$urlencode : G5_BBS_URL.'/login.php';
$at_href['login_check'] = G5_HTTPS_BBS_URL.'/login_check.php';
$at_href['logout'] = G5_BBS_URL.'/logout.php';
$at_href['point'] = G5_BBS_URL.'/point.php';
$at_href['coupon'] = G5_SHOP_URL.'/coupon.php';
$at_href['memo'] = G5_BBS_URL.'/memo.php';
$at_href['scrap'] = G5_BBS_URL.'/scrap.php';
$at_href['edit'] = G5_BBS_URL.'/member_confirm.php?url=register_form.php';
$at_href['leave'] = G5_BBS_URL.'/member_confirm.php?url=member_leave.php';
$at_href['lost'] = G5_BBS_URL.'/password_lost.php';
$at_href['rss'] = (IS_YC && IS_SHOP) ? G5_URL.'/rss' : G5_URL.'/rss/rss.php';
$at_href['response'] = G5_BBS_URL.'/response.php';
$at_href['follow'] = G5_BBS_URL.'/follow.php';
$at_href['myphoto'] = G5_BBS_URL.'/myphoto.php';
$at_href['mypost'] = G5_BBS_URL.'/mypost.php';
$at_href['connect'] = G5_BBS_URL.'/current_connect.php';
$at_href['secret'] = G5_BBS_URL.'/qalist.php';
$at_href['switcher_submit'] = G5_BBS_URL.'/switcher.update.php';
$at_href['faq'] = G5_BBS_URL.'/faq.php';
$at_href['new'] = G5_BBS_URL.'/new.php';
$at_href['search'] = G5_BBS_URL.'/search.php';
$at_href['mypage'] = (IS_YC) ? G5_SHOP_URL.'/mypage.php' : G5_BBS_URL.'/mypage.php';
$at_href['tag'] = G5_BBS_URL.'/tag.php';
$at_href['example'] = G5_URL.'/example.php';

if(IS_YC) {
	$at_href['myshop'] = G5_SHOP_URL.'/myshop.php';
	$at_href['cart'] = G5_SHOP_URL.'/cart.php';
	$at_href['wishlist'] = G5_SHOP_URL.'/wishlist.php';
	$at_href['shopping'] = G5_SHOP_URL.'/shopping.php';
	$at_href['inquiry'] = G5_SHOP_URL.'/orderinquiry.php';
	$at_href['ppay'] = G5_SHOP_URL.'/personalpay.php';
	$at_href['event'] = G5_SHOP_URL.'/event.php';
	$at_href['itype'] = G5_SHOP_URL.'/listtype.php';
	$at_href['home_shop'] = G5_SHOP_URL;
	$at_href['isearch'] = G5_SHOP_URL.'/search.php';
	$at_href['iuse'] = G5_SHOP_URL.'/itemuselist.php';
	$at_href['iqa'] = G5_SHOP_URL.'/itemqalist.php';
	$at_href['partner'] = G5_SHOP_URL.'/partner';
}

$at_href['home'] = (IS_SHOP && !$default['de_root_index_use']) ? G5_SHOP_URL : G5_URL;
$at_href['shop'] = (IS_SHOP) ? G5_URL : G5_SHOP_URL;

//APMS THEMA
$sw_code = '';
$tmp_pv = '';
if($is_admin && $pv) {
	$thema = $pv;
	$colorset = $pvc;
} else {
	if($is_demo) { //데모에서 미리보기
		if($pv) set_session('thema', $pv);
		if($pvc) set_session('colorset', $pvc);

		$tmp_pv = get_session('thema');
		$tmp_pvc = get_session('colorset');
	}

	if($tmp_pv) {
		$thema = $tmp_pv;
		$colorset = $tmp_pvc;
	} else {
		if(IS_YC && IS_SHOP && !$at['group']) {
			if($at['thema']) {
				$thema = $at['thema'];
				$colorset = $at['colorset'];
				$sw_code = $at['id'];
				if(G5_IS_MOBILE) {
					$sw_type = 18;
					$sw_msg = '쇼핑몰 '.$at['name'].'('.$at['id'].')분류의 모바일테마';
				} else {
					$sw_type = 16;
					$sw_msg = '쇼핑몰 '.$at['name'].'('.$at['id'].')분류의 PC테마';
				}
			} else {
				$thema = $default['as_'.MOBILE_.'thema'];
				$colorset = $default['as_'.MOBILE_.'color'];
				if(G5_IS_MOBILE) {
					$sw_type = 17;
					$sw_msg = '쇼핑몰 기본 모바일테마';
				} else {
					$sw_type = 15;
					$sw_msg = '쇼핑몰 기본 PC테마';
				}
			}
		} else {
			if($at['thema']) {
				$thema = $at['thema'];
				$colorset = $at['colorset'];
				$sw_code = $at['id'];
				if(G5_IS_MOBILE) {
					$sw_type = 14;
					$sw_msg = '커뮤니티 '.$at['name'].'('.$at['id'].')그룹의 모바일테마';
				} else {
					$sw_type = 12;
					$sw_msg = '커뮤니티 '.$at['name'].'('.$at['id'].')그룹의 PC테마';
				}
			} else {
				$thema = $config['as_'.MOBILE_.'thema'];
				$colorset = $config['as_'.MOBILE_.'color'];
				if(G5_IS_MOBILE) {
					$sw_type = 13;
					$sw_msg = '커뮤니티 기본 모바일테마';
				} else {
					$sw_type = 11;
					$sw_msg = '커뮤니티 기본 PC테마';
				}
			}
		}
	}
}

// Thema Path & URL
if(!$thema) {
	$thema = 'Basic';
	$sw_type = 11;
	$sw_msg = '커뮤니티 기본 PC테마';
}
define('THEMA', $thema);
define('THEMA_PATH', G5_PATH.'/thema/'.$thema);
define('THEMA_URL', G5_URL.'/thema/'.$thema);

// Thema Setup
$at_set = array();
$at_set = thema_switcher_load($sw_type, $sw_code);

// Ex Href
$at_href['switcher'] = G5_BBS_URL.'/switcher.php?pv='.THEMA;

// Colorset Path & URL
if(!$colorset) {
	$colorset = (is_dir(THEMA_PATH.'/colorset/Basic')) ? 'Basic' : 'basic';
}
define('COLORSET', $colorset);
define('COLORSET_PATH', THEMA_PATH.'/colorset/'.COLORSET);
define('COLORSET_URL', THEMA_URL.'/colorset/'.COLORSET);

?>