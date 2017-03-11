<?php
include_once('./_common.php');

check_demo();

//Default
$ap = $ap ? $ap : 'thema';

//Menu
switch($ap) {
	case 'thema'	: $sub_menu = '777001'; $g5['title'] = '기본설정'; break;
	case 'menu'		: $sub_menu = '777002'; $g5['title'] = '메뉴설정'; break;
	case 'bpage'	: $sub_menu = '777004'; $g5['title'] = '기본문서'; break;
	case 'npage'	: $sub_menu = '777005'; $g5['title'] = '일반문서'; break;
	case 'shingo'	: $sub_menu = '777006'; $g5['title'] = '잠금관리'; break;

	case 'basic'	: $sub_menu = '888001'; $g5['title'] = '기본설정'; break;
	case 'plist'	: $sub_menu = '888002'; $g5['title'] = '파트너목록'; break;
	case 'pform'	: $sub_menu = '888002'; $g5['title'] = '파트너정보'; break;
	case 'delivery'	: $sub_menu = '888003'; $g5['title'] = '배송관리'; break;
	case 'payment'	: $sub_menu = '888004'; $g5['title'] = '출금관리'; break;

	default			: $sub_menu = '777001'; $g5['title'] = '기본설정'; break;
}

//Install
$install_apms = false;
if(!isset($config['as_thema'])) { 
	$install_apms = true;
	$g5['title'] = "설치하기";
}

//Check
$chk_ap = array('install', 'update', 'thema', 'menu', 'bpage', 'npage', 'shingo', 'basic', 'plist', 'pform', 'delivery', 'payment');
if(!in_array($ap, $chk_ap)) alert("지원하지 않는 기능입니다.");

//Move
$go_url = './apms.admin.php?ap='.$ap;

//Mode
if($mode) {
	$chk_mode = array('install', 'thema', 'menu', 'bpage', 'npage', 'shingo', 'basic', 'plist', 'pform', 'delivery', 'payment');
	if(!in_array($mode, $chk_mode)) alert("지원하지 않는 모드입니다."); 

	auth_check($auth[$sub_menu], 'w'); //쓰기 권한

	switch($mode) {
		case 'install'	: $ap_file = './apms.install.php'; break;

		case 'thema'	: $ap_file = './apms.thema.php'; break;
		case 'menu'		: $ap_file = './apms.menu.php'; break;
		case 'bpage'	: $ap_file = './apms.page.basic.php'; break;
		case 'npage'	: $ap_file = './apms.page.normal.php'; break;
		case 'shingo'	: $ap_file = './apms.shingo.php'; break;

		case 'basic'	: $ap_file = './apms.basic.php'; break;
		case 'plist'	: $ap_file = './apms.plist.php'; break;
		case 'pform'	: $ap_file = './apms.pform.php'; break;
		case 'delivery'	: $ap_file = './apms.delivery.php'; break;
		case 'payment'	: $ap_file = './apms.payment.php'; break;
	}

	if(file_exists($ap_file)) {
		include($ap_file);
	} else {
		goto_url('./apms.admin.php?ap=thema');
	}
} else {
	auth_check($auth[$sub_menu], 'r'); //읽기 권한
}

include_once(G5_ADMIN_PATH.'/admin.head.php');

?>

<script src="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.js"></script>

<div id="amina_skin">
	<?php 
		//Install
		if($install_apms) { 
			include('./apms.install.php');
		} else { 
			switch($ap) {
				case 'thema'	: $ap_file = './apms.thema.php'; break;
				case 'menu'		: $ap_file = './apms.menu.php'; break;
				case 'bpage'	: $ap_file = './apms.page.basic.php'; break;
				case 'npage'	: $ap_file = './apms.page.normal.php'; break;
				case 'shingo'	: $ap_file = './apms.shingo.php'; break;

				case 'basic'	: $ap_file = './apms.basic.php'; break;
				case 'update'	: $ap_file = './apms.sql.php'; break;
				case 'plist'	: $ap_file = './apms.plist.php'; break;
				case 'pform'	: $ap_file = './apms.pform.php'; break;
				case 'delivery'	: $ap_file = './apms.delivery.php'; break;
				case 'payment'	: $ap_file = './apms.payment.php'; break;

				default			: $ap_file = './apms.thema.php'; break;
			} 

			if(file_exists($ap_file)) {
				include($ap_file);
			} else {
				if(!$msg) $msg = '추후 지원예정 메뉴입니다.';
				alert($msg, './apms.admin.php?ap=thema');
			}
		}
	?>
</div>

<div style="margin:30px 0px -21px; padding:10px; background:#333; border-top:1px solid #000; border-bottom:1px solid #000; text-align:center; font-weight:bold; color:gold; font-family:verdana; ">
	<?php echo APMS_VERSION;?>
</div>

<?php include_once(G5_ADMIN_PATH.'/admin.tail.php'); ?>