<?php
include_once('./_common.php');

$is_main = false;

if(!$hid) alert('등록되지 않은 페이지입니다.');

$at = apms_page_thema($hid, 1);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$is_content = false;
if($at['co_id']) {
	$co_id = $at['co_id'];
	$co = sql_fetch(" select * from {$g5['content_table']} where co_id = '$co_id' ");
	if ($co['co_id']) 
		$is_content = true;
}

if($is_content) {
	$g5['title'] = $co['co_subject'];

	if ($co['co_include_head'])
		@include_once($co['co_include_head']);
	else
		include_once('./_head.php');

	$str = conv_content($co['co_content'], $co['co_html'], $co['co_tag_filter_use']);

	// $src 를 $dst 로 변환
	unset($src);
	unset($dst);
	$src[] = "/{{쇼핑몰명}}|{{홈페이지제목}}/";
	//$dst[] = $default[de_subject];
	$dst[] = $config['cf_title'];
	$src[] = "/{{회사명}}|{{상호}}/";
	$dst[] = $default['de_admin_company_name'];
	$src[] = "/{{대표자명}}/";
	$dst[] = $default['de_admin_company_owner'];
	$src[] = "/{{사업자등록번호}}/";
	$dst[] = $default['de_admin_company_saupja_no'];
	$src[] = "/{{대표전화번호}}/";
	$dst[] = $default['de_admin_company_tel'];
	$src[] = "/{{팩스번호}}/";
	$dst[] = $default['de_admin_company_fax'];
	$src[] = "/{{통신판매업신고번호}}/";
	$dst[] = $default['de_admin_company_tongsin_no'];
	$src[] = "/{{사업장우편번호}}/";
	$dst[] = $default['de_admin_company_zip'];
	$src[] = "/{{사업장주소}}/";
	$dst[] = $default['de_admin_company_addr'];
	$src[] = "/{{운영자명}}|{{관리자명}}/";
	$dst[] = $default['de_admin_name'];
	$src[] = "/{{운영자e-mail}}|{{관리자e-mail}}/i";
	$dst[] = $default['de_admin_email'];
	$src[] = "/{{정보관리책임자명}}/";
	$dst[] = $default['de_admin_info_name'];
	$src[] = "/{{정보관리책임자e-mail}}|{{정보책임자e-mail}}/i";
	$dst[] = $default['de_admin_info_email'];

	$str = preg_replace($src, $dst, $str);

	$himg = G5_DATA_PATH.'/content/'.$co_id.'_h';
	if (file_exists($himg)) // 상단 이미지
		echo '<div id="ctt_himg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_h" alt="" style="max-width:100%;"></div>';

	echo '<article id="ctt" class="ctt_'.$co_id.'">'.PHP_EOL;
	echo '<div id="ctt_con">'.PHP_EOL;
	echo $str.PHP_EOL;
	echo '</div>'.PHP_EOL;
	echo '</article>'.PHP_EOL;

	$timg = G5_DATA_PATH.'/content/'.$co_id.'_t';
	if (file_exists($timg)) // 하단 이미지
		echo '<div id="ctt_timg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_t" alt="" style="max-width:100%;"></div>';

	if ($is_admin)
		echo '<div class="ctt_admin"><a href="'.G5_ADMIN_URL.'/contentform.php?w=u&amp;co_id='.$co_id.'" class="btn_admin">내용 수정</a></div>';

	if ($co['co_include_tail'])
		@include_once($co['co_include_tail']);
	else
		include_once('./_tail.php');

} else {
	include_once('./_head.php');

	$doc_path = G5_DATA_PATH.'/apms/page';
	$doc_url = G5_DATA_URL.'/apms/page';
	@include_once($doc_path.'/'.$at['file'].'.php');

	include_once('./_tail.php');
}

?>