<?php
include_once('./_common.php');

if($is_guest) {
	alert('회원만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

$is_company = (isset($apms['apms_company']) && $apms['apms_company']) ? true : false;
$is_personal = (isset($apms['apms_personal']) && $apms['apms_personal']) ? true : false;

if(!$is_company && !$is_personal) {
	alert('지금은 파트너 등록을 받지 않습니다.', G5_URL);
}

$partner = array();
$partner = apms_partner($member['mb_id']);

if($partner['pt_id']) { //파트너 정보가 있으면

	if(!$partner['pt_register']) { // 등록심사중이면
		alert('회원님은 현재 등록심사 중입니다.', G5_URL);
	}

	if($partner['pt_leave']) { // 탈퇴한 회원이면
		alert('회원님은 파트너에서 탈퇴하셨습니다.\\n\\n재등록을 원하시면 관리자에게 문의바랍니다.', G5_URL);
	}

	alert('회원님은 파트너로 등록되신 분입니다.', APMS_PARTNER_URL);
}

// 파트너 등록
if(!$is_admin) {
	$register_no_msg = '';
	if($apms['apms_email_yes'] && !$member['mb_email_certify']) {
		$register_no_msg .= '이메일인증';
	}
	if($apms['apms_cert_yes'] && !$member['mb_certify']) {
		if($register_no_msg) $register_no_msg .= ', ';
		$register_no_msg .= '본인인증';
	}
	if($apms['apms_adult_yes'] && !$member['mb_adult']) {
		if($register_no_msg) $register_no_msg .= ', ';
		$register_no_msg .= '성인인증';
	}

	if($register_no_msg) {
		alert($register_no_msg.' 회원만 파트너 등록이 가능합니다.\\n\\n정보수정에서 인증 후 등록할 수 있습니다.', G5_BBS_URL.'/member_confirm.php?url=register_form.php');
	}
}

if (!isset($_POST['agree']) || !$_POST['agree']) {
	alert('가입약관의 내용에 동의하셔야 가입하실 수 있습니다.');
}

if (!isset($_POST['pt_type']) || !$_POST['pt_type']) {
	alert('등록할 유형을 선택하셔야 가입하실 수 있습니다.');
}

if (($_POST['pt_type'] != "1" && $_POST['pt_type'] != "2") || (!$is_company && $_POST['pt_type'] == "1") || (!$is_personal && $_POST['pt_type'] == "2")) {
	alert('잘못된 유형을 선택하셨습니다.');
}

$pt_type        = trim($_POST['pt_type']);
$pt_name        = trim($_POST['pt_name']);
$pt_hp		    = trim($_POST['pt_hp']);
$pt_email		= trim($_POST['pt_email']);

if(!$pt_name) {
	alert('이름을 입력하세요.');
}

if(!$pt_hp) {
	alert('연락처를 입력하세요.');
}

$pt_hp = preg_replace('/[^0-9\-]/', '', strip_tags($pt_hp));

$pt_email = get_email_address($pt_email);

if(!$pt_email) {
	alert('이메일을 입력하세요.');
}

if (!preg_match("/([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/", $pt_email)) {
	alert('이메일 주소가 형식에 맞지 않습니다.');
}

if (empty($_POST)) {
    alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=".ini_get('upload_max_filesize')."\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");
}

//파일등록
$file_upload_msg = apms_upload_file('partner', $member['mb_id']);

if ($file_upload_msg) {
    alert($file_upload_msg, G5_URL);
} else {

	//자동등록
	$pt_register = ($apms['apms_register']) ? date("Ymd") : '';

	//정보등록
	$sql = " insert into {$g5['apms_partner']}
				set pt_id = '{$member['mb_id']}',
					pt_type = '{$pt_type}',
					pt_register = '{$pt_register}',
					pt_datetime = '".G5_TIME_YMDHIS."',
					pt_name = '{$pt_name}',
					pt_hp = '{$pt_hp}',
					pt_email = '{$pt_email}' ";
	sql_query($sql);

	if($pt_register) {

		//회원정보변경
		sql_query(" update {$g5['member_table']} set as_partner = '1' where mb_id = '{$member['mb_id']}' ");

		alert('파트너 등록이 완료되었습니다.', APMS_PARTNER_URL);
	} else {
		alert('파트너 등록을 신청하셨습니다.\\n\\n신청내용에 대한 검토 후 등록이 완료됩니다.', G5_URL);
	}
}

?>
