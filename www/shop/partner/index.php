<?php
include_once('./_common.php');

if($is_guest) {
	alert('회원만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

// 회원정보가공
thema_member();

$is_auth = ($is_admin == 'super') ? true : false;
$is_partner = (IS_PARTNER) ? true : false;

if($is_auth || $is_partner) {
	; // 통과
} else {
	alert('파트너만 이용가능합니다.', APMS_PARTNER_URL.'/register.php');
}

define('G5_IS_ADMIN', true);

$mb_id = $member['mb_id'];

//파트너 정보
$partner = array();
$partner = apms_partner($mb_id);

// 파일체크
switch($ap) {
	case 'salelist'		: $skin_file = 'salelist.php'; break;
	case 'saleitem'		: $skin_file = 'saleitem.php'; break;
	case 'cancelitem'	: $skin_file = 'cancelitem.php'; break;
	case 'delivery'		: $skin_file = 'delivery.php'; break;
	case 'sendcost'		: $skin_file = 'sendcost.php'; break;
	case 'paylist'		: $skin_file = 'paylist.php'; break;
	case 'list'			: $skin_file = 'itemlist.php'; break;
	case 'item'			: $skin_file = 'itemform.php'; break;
	case 'comment'		: $skin_file = 'comment.php'; break;
	case 'qalist'		: $skin_file = 'qalist.php'; break;
	case 'qaform'		: $skin_file = 'qaform.php'; break;
	case 'uselist'		: $skin_file = 'uselist.php'; break;
	default				: $skin_file = 'dashboard.php'; break;
}

include_once(G5_PATH.'/head.sub.php'); 
include_once($skin_path.'/_head.php');
include_once('./'.$skin_file);
include_once($skin_path.'/_tail.php');
include_once(G5_PATH.'/tail.sub.php'); 

?>
