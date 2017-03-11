<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($mode == 'thema') {

	if(!$_POST['as_thema']) alert("기본 테마를 설정해 주세요.");

	if(IS_YC && !$_POST['as_shop_thema']) alert("쇼핑몰 기본 테마를 설정해 주세요.");

	//config_table
	$sql = " update {$g5['config_table']}
				set as_thema					= '{$_POST['as_thema']}'
					, as_color					= '{$_POST['as_color']}'
					, as_mobile_thema			= '{$_POST['as_mobile_thema']}'
					, as_mobile_color			= '{$_POST['as_mobile_color']}'
					, as_xp						= '{$_POST['as_xp']}'
					, as_mp						= '{$_POST['as_mp']}'
					, as_admin					= '{$_POST['as_admin']}'
					";
	sql_query($sql);

	if(IS_YC) {
		//Shop
		$sql = " update {$g5['g5_shop_default_table']}
					set as_thema					= '{$_POST['as_shop_thema']}'
						, as_color					= '{$_POST['as_shop_color']}'
						, as_mobile_thema			= '{$_POST['as_shop_mobile_thema']}'
						, as_mobile_color			= '{$_POST['as_shop_mobile_color']}'
						, pt_shingo                 = '{$_POST['pt_shingo']}'
						, pt_lucky                  = '{$_POST['pt_lucky']}'
						, pt_code					= '{$_POST['pt_code']}'
						, pt_auto					= '{$_POST['pt_auto']}'
						, pt_auto_cache				= '{$_POST['pt_auto_cache']}'
						, pt_good_use               = '{$_POST['pt_good_use']}'
						, pt_good_point			    = '{$_POST['pt_good_point']}'
						, pt_review_use				= '{$_POST['pt_review_use']}'
						, pt_comment_use			= '{$_POST['pt_comment_use']}'
						, pt_comment_sns			= '{$_POST['pt_comment_sns']}'
						, pt_comment_point			= '{$_POST['pt_comment_point']}'
						, pt_reserve_use			= '{$_POST['pt_reserve_use']}'
						, pt_reserve_end			= '{$_POST['pt_reserve_end']}'
						, pt_reserve_day			= '{$_POST['pt_reserve_day']}'
						, pt_reserve_cache			= '{$_POST['pt_reserve_cache']}'
						, pt_reserve_none			= '{$_POST['pt_reserve_none']}'
						, pt_img_width				= '{$_POST['pt_img_width']}'
						, pt_upload_size			= '{$_POST['pt_upload_size']}'
						, de_search_list_mod		= '{$_POST['de_search_list_mod']}'
						, de_search_list_row		= '{$_POST['de_search_list_row']}'
						, de_search_img_width		= '{$_POST['de_search_img_width']}'
						, de_search_img_height		= '{$_POST['de_search_img_height']}'
						, de_mobile_search_list_mod	= '{$_POST['de_mobile_search_list_mod']}'
						, de_mobile_search_img_width		= '{$_POST['de_mobile_search_img_width']}'
						, de_mobile_search_img_height		= '{$_POST['de_mobile_search_img_height']}'
						, de_rel_img_width			= '{$_POST['de_rel_img_width']}'
						, de_rel_img_height			= '{$_POST['de_rel_img_height']}'
						, de_mobile_rel_img_width	= '{$_POST['de_mobile_rel_img_width']}'
						, de_mobile_rel_img_height	= '{$_POST['de_mobile_rel_img_height']}'
						, de_search_list_skin		= '{$_POST['de_search_list_skin']}'
						, de_mobile_search_list_skin	= '{$_POST['de_mobile_search_list_skin']}'
						";
		sql_query($sql);

		//Rows Table
		$sql = " update {$g5['apms_rows']}
					set icomment_rows				= '{$_POST['icomment_rows']}'
						, icomment_mobile_rows		= '{$_POST['icomment_mobile_rows']}'
						, iuse_rows					= '{$_POST['iuse_rows']}'
						, iuse_mobile_rows			= '{$_POST['iuse_mobile_rows']}'
						, iqa_rows					= '{$_POST['iqa_rows']}'
						, iqa_mobile_rows			= '{$_POST['iqa_mobile_rows']}'
						, irelation_mods			= '{$_POST['irelation_mods']}'
						, irelation_mobile_mods		= '{$_POST['irelation_mobile_mods']}'
						, irelation_rows			= '{$_POST['irelation_rows']}'
						, irelation_mobile_rows		= '{$_POST['irelation_mobile_rows']}'
						, type_mods					= '{$_POST['type_mods']}'
						, type_mobile_mods			= '{$_POST['type_mobile_mods']}'
						, type_rows					= '{$_POST['type_rows']}'
						, type_mobile_rows			= '{$_POST['type_mobile_rows']}'
						, event_mods				= '{$_POST['event_mods']}'
						, event_mobile_mods			= '{$_POST['event_mobile_mods']}'
						, event_rows				= '{$_POST['event_rows']}'
						, event_mobile_rows			= '{$_POST['event_mobile_rows']}'
						, myshop_mods				= '{$_POST['myshop_mods']}'
						, myshop_mobile_mods		= '{$_POST['myshop_mobile_mods']}'
						, myshop_rows				= '{$_POST['myshop_rows']}'
						, myshop_mobile_rows		= '{$_POST['myshop_mobile_rows']}'
						, ppay_mods					= '{$_POST['ppay_mods']}'
						, ppay_mobile_mods			= '{$_POST['ppay_mobile_mods']}'
						, ppay_rows					= '{$_POST['ppay_rows']}'
						, ppay_mobile_rows			= '{$_POST['ppay_mobile_rows']}'
						, type_img_width			= '{$_POST['type_img_width']}'
						, type_img_height			= '{$_POST['type_img_height']}'
						, type_mobile_img_width		= '{$_POST['type_mobile_img_width']}'
						, type_mobile_img_height	= '{$_POST['type_mobile_img_height']}'
						, myshop_img_width			= '{$_POST['myshop_img_width']}'
						, myshop_img_height			= '{$_POST['myshop_img_height']}'
						, myshop_mobile_img_width	= '{$_POST['myshop_mobile_img_width']}'
						, myshop_mobile_img_height	= '{$_POST['myshop_mobile_img_height']}'
						, type_skin					= '{$_POST['type_skin']}'
						, type_mobile_skin			= '{$_POST['type_mobile_skin']}'
						, myshop_skin				= '{$_POST['myshop_skin']}'
						, myshop_mobile_skin		= '{$_POST['myshop_mobile_skin']}'
						";
		sql_query($sql);
	}

	//XP Table
	$sql = " update {$g5['apms_xp']}
				set xp_now						= '{$_POST['xp_now']}'
					, xp_point					= '{$_POST['xp_point']}'
					, xp_rate					= '{$_POST['xp_rate']}'
					, xp_max					= '{$_POST['xp_max']}'
					, xp_icon					= '{$_POST['xp_icon']}'
					, xp_icon_skin				= '{$_POST['xp_icon_skin']}'
					, xp_icon_css				= '{$_POST['xp_icon_css']}'
					, xp_special				= '{$_POST['xp_special']}'
					, xp_photo					= '{$_POST['xp_photo']}'
					, xp_grade1					= '{$_POST['xp_grade1']}'
					, xp_grade2					= '{$_POST['xp_grade2']}'
					, xp_grade3					= '{$_POST['xp_grade3']}'
					, xp_grade4					= '{$_POST['xp_grade4']}'
					, xp_grade5					= '{$_POST['xp_grade5']}'
					, xp_grade6					= '{$_POST['xp_grade6']}'
					, xp_grade7					= '{$_POST['xp_grade7']}'
					, xp_grade8					= '{$_POST['xp_grade8']}'
					, xp_grade9					= '{$_POST['xp_grade9']}'
					, xp_grade10				= '{$_POST['xp_grade10']}'
					, xp_auto1					= '{$_POST['xp_auto1']}'
					, xp_auto2					= '{$_POST['xp_auto2']}'
					, xp_auto3					= '{$_POST['xp_auto3']}'
					, xp_auto4					= '{$_POST['xp_auto4']}'
					, xp_auto5					= '{$_POST['xp_auto5']}'
					, xp_auto6					= '{$_POST['xp_auto6']}'
					, xp_auto7					= '{$_POST['xp_auto7']}'
					, xp_from					= '{$_POST['xp_from']}'
					, xp_to						= '{$_POST['xp_to']}'
					, xp_except					= '{$_POST['xp_except']}'
					, exp_point					= '{$_POST['exp_point']}'
					, exp_login					= '{$_POST['exp_login']}'
					, exp_write					= '{$_POST['exp_write']}'
					, exp_comment				= '{$_POST['exp_comment']}'
					, exp_read					= '{$_POST['exp_read']}'
					, exp_good					= '{$_POST['exp_good']}'
					, exp_nogood				= '{$_POST['exp_nogood']}'
					, exp_chulsuk				= '{$_POST['exp_chulsuk']}'
					, exp_delivery				= '{$_POST['exp_delivery']}'
					";
	sql_query($sql);

	//Move
	goto_url($go_url);
}

$frm_submit = '<div class="btn_confirm01 btn_confirm">'.PHP_EOL;
$frm_submit .= '<input type="submit" value="확인" class="btn_submit" accesskey="s">'.PHP_EOL;
$frm_submit .= '<a href="./apms.admin.php?ap=update" class="btn_frmline">DB 업데이트</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.new.update.php" class="btn_frmline win_memo">새글 업데이트</a>'.PHP_EOL;
$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.exp.update.php" class="btn_frmline win_memo">레벨 업데이트</a>'.PHP_EOL;
if(IS_YC) {
	// 상품목록
	$listskin = get_skin_dir('list', G5_SKIN_PATH.'/apms');

	$frm_submit .= '<a href="'.G5_ADMIN_URL.'/apms_admin/apms.net.update.php" class="btn_frmline win_memo">파트너 업데이트</a>'.PHP_EOL;
}
$frm_submit .= '</div>';

?>

<div class="local_ov01 local_ov">
	<b>안내</b> 기본테마와 별도로 보드그룹/아이템 분류별 개별테마 설정은 메뉴설정에서 하실 수 있습니다.
</div>

<form name="basicform" id="basicform" method="post">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="mode" value="<?php echo $ap;?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">구분</th>
		<th scope="col">PC 테마</th>
        <th scope="col">PC 컬러셋</th>
        <th scope="col">모바일 테마</th>
        <th scope="col">모바일 컬러셋</th>
    </tr>
    </thead>
    <tbody>
	<?php $thema_list = apms_dir_list('thema'); ?>
	<tr>
	<td align="center"><b>커뮤니티</b></td>
	<td align="center"><?php echo apms_thema_skin($thema_list, 'as_thema', $config['as_thema'], 'basic_thema', 'as_color', '테마 선택', 120);?></td>
	<td align="center">
		<div id="basic_thema">
			<?php echo apms_colorset_skin($config['as_thema'], 'as_color', $config['as_color'], '', 120);?>
		</div>	
	</td>
	<td align="center"><?php echo apms_thema_skin($thema_list, 'as_mobile_thema', $config['as_mobile_thema'], 'basic_mobile_thema', 'as_mobile_color', '테마 선택', 120);?></td>
	<td align="center">
		<div id="basic_mobile_thema">
			<?php echo apms_colorset_skin($config['as_mobile_thema'], 'as_mobile_color', $config['as_mobile_color'], '', 120);?>
		</div>	
	</td>
    </tr>
	<?php if(IS_YC) { ?>
		<tr>
		<td align="center"><b>쇼핑몰</b></td>
		<td align="center"><?php echo apms_thema_skin($thema_list, 'as_shop_thema', $default['as_thema'], 'basic_shop_thema', 'as_shop_color', '테마 선택', 120);?></td>
		<td align="center">
			<div id="basic_shop_thema">
				<?php echo apms_colorset_skin($default['as_thema'], 'as_shop_color', $default['as_color'], '', 120);?>
			</div>	
		</td>
		<td align="center"><?php echo apms_thema_skin($thema_list, 'as_shop_mobile_thema', $default['as_mobile_thema'], 'basic_shop_mobile_thema', 'as_shop_mobile_color', '테마 선택', 120);?></td>
		<td align="center">
			<div id="basic_shop_mobile_thema">
				<?php echo apms_colorset_skin($default['as_mobile_thema'], 'as_shop_mobile_color', $default['as_mobile_color'], '', 120);?>
			</div>	
		</td>
		</tr>
	<?php } ?>
	</tbody>
    </table>
</div>

<?php echo $frm_submit; ?>

<br>

<?php if(IS_YC) { ?>
	<div class="local_desc01 local_desc">
		<p><b>● Shop 설정</b> - 쇼핑몰 관련 추가설정입니다.</p>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
	    <thead>
		<tr>
		<th width=80>구분</th>
		<th width=80>항목</th>
		<th>설정</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td rowspan="2"><b>상품추천</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_good_use" id="pt_good_use">
				<option value="0"<?php echo get_selected('0', $default['pt_good_use']); ?>>사용안함</option>
				<option value="1"<?php echo get_selected('1', $default['pt_good_use']); ?>>회원만 가능</option>
				<option value="2"<?php echo get_selected('2', $default['pt_good_use']); ?>>구매회원만 가능</option>
			</select>
		</td>
		</tr>
		<tr>
		<td>추천점수</td>
		<td>
			<input type="text" name="pt_good_point" value="<?php echo $default['pt_good_point'] ?>" id="pt_good_point" class="frm_input" size="7"> 포인트
		</td>
		</tr>
		<tr>
		<td rowspan=3><b>상품댓글</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_comment_use" id="pt_comment_use">
				<option value="0"<?php echo get_selected('0', $default['pt_comment_use']); ?>>우리만 사용</option>
				<option value="1"<?php echo get_selected('1', $default['pt_comment_use']); ?>>파트너도(안함포함)</option>
				<option value="2"<?php echo get_selected('2', $default['pt_comment_use']); ?>>파트너도(안함제외)</option>
			</select>
			&nbsp;
			<label>
			<input type="checkbox" name="pt_comment_sns" value="1"<?php echo $default['pt_comment_sns']?' checked':''; ?> id="pt_comment_sns">
			SNS 동시등록 사용
			</label>
		</td>
		</tr>
		<tr>
		<td>댓글점수</td>
		<td>
			<input type="text" name="pt_comment_point" value="<?php echo $default['pt_comment_point'] ?>" id="pt_comment_point" class="frm_input" size="7"> 포인트
			&nbsp;
			<label>
			<input type="checkbox" name="pt_lucky" value="1"<?php echo $default['pt_lucky']?' checked':''; ?> id="pt_lucky">
			럭키포인트 사용
			</label>
		</td>
		</tr>
		<tr>
		<td>블라인드</td>
		<td>
			<input type="text" name="pt_shingo" value="<?php echo $default['pt_shingo'] ?>" id="pt_shingo" class="frm_input" size="4"> 개 이상 신고가 접수되면 블라인드처리합니다. (최고 120개)
		</td>
		</tr>
		<tr>
		<td><b>상품후기</b></td>
		<td>등록권한</td>
		<td>
			<label>
			<input type="checkbox" name="pt_review_use" value="1"<?php echo $default['pt_review_use']?' checked':''; ?> id="pt_review_use">
			파트너도 아이템별로 후기 등록권한 설정이 가능하도록 합니다.
			</label>
		</td>
		</tr>
		<tr>
		<td rowspan=3><b>예약기능</b></td>
		<td>사용여부</td>
		<td>
			<select name="pt_reserve_use" id="pt_reserve_use">
				<option value="0"<?php echo get_selected('0', $default['pt_reserve_use']); ?>>우리만 사용</option>
				<option value="1"<?php echo get_selected('1', $default['pt_reserve_use']); ?>>파트너도 사용</option>
			</select>
			&nbsp;
			<input type="text" name="pt_reserve_end" value="<?php echo $default['pt_reserve_end'] ?>" id="pt_reserve_end" class="numeric frm_input" size="4"> 일 이후까지 예약가능
		</td>
		</tr>
		<tr>
		<td>예약불가</td>
		<td>
			<input type="text" name="pt_reserve_none" value="<?php echo $default['pt_reserve_none'] ?>" id="pt_reserve_none" class="numeric frm_input" size="7"> 시간 지난 상품(파트너)은 예약불가
		</td>
		</tr>
		<tr>
		<td>예약체크</td>
		<td>
			<input type="text" name="pt_reserve_day" value="<?php echo $default['pt_reserve_day'] ?>" id="pt_reserve_day" class="numeric frm_input" size="7"> 일 이내 등록상품에 대해 
			<input type="text" name="pt_reserve_cache" value="<?php echo $default['pt_reserve_cache'] ?>" id="pt_reserve_cache" class="numeric frm_input" size="7"> 분 간격으로 체크
		</td>
		</tr>
		<tr>
		<td><b>자동기능</b></td>
		<td>구매완료</td>
		<td>
			<input type="text" name="pt_auto" value="<?php echo $default['pt_auto'] ?>" id="pt_auto" class="frm_input" size="7"> 일 경과된 파트너 배송상품에 대해
			<input type="text" name="pt_auto_cache" value="<?php echo $default['pt_auto_cache'] ?>" id="pt_auto_cache" class="numeric frm_input" size="7"> 시간 간격으로 체크
			(포인트 적립)
		</td>
		</tr>
		<tr>
		<td><b>첨부기능</b></td>
		<td>파일용량</td>
		<td>
			<?php echo help('최대 '.ini_get("upload_max_filesize").' 이하 업로드 가능, 1 MB = 1,048,576 bytes') ?>
			업로드 파일 한개당 <input type="text" name="pt_upload_size" value="<?php echo $default['pt_upload_size'] ?>" id="pt_upload_size" class="required numeric frm_input"  size="10"> bytes 이하 가능
		</td>
		</tr>
		<tr>
		<td><b>내용사진</b></td>
		<td>썸네일너비</td>
		<td>
			<?php echo help('후기, 문의 등 내용의 이미지 썸네일 기본 너비값입니다.') ?>
			<input type="text" name="pt_img_width" value="<?php echo $default['pt_img_width'] ?>" id="pt_img_width" class="required numeric frm_input"  size="10"> px
		</td>
		</tr>
		<tr>
		<td><b>기타설정</b></td>
		<td>코드출력</td>
		<td>
		<label><input type="checkbox" name="pt_code" value="1"<?php if($default['pt_code']) echo ' checked';?>> 상품설명페이지에 SyntaxHighlighter 를 적용합니다.</label>
		</td>
		</tr>
		</tbody>
		</table>
	</div>

	<?php echo $frm_submit; ?>

	<br>

	<div class="local_desc01 local_desc">
		<p><b>● 기본 목록수 설정</b> - 한 페이지당 기본 출력 목록수입니다.</p>
	</div>

	<?php $rows = apms_rows(); ?>
	<div class="tbl_head01 tbl_wrap">
		<table>
	    <thead>
		<tr>
		<th width=80 rowspan=2>구분</th>
		<th width=80 rowspan=2>항목</th>
		<th colspan=2>PC</th>
		<th colspan=2>모바일</th>
		<th colspan=2>PC 썸네일</th>
		<th colspan=2>모바일 썸네일</th>
		<th colspan=2>목록스킨</th>
		<th rowspan=2>설명</th>
		</tr>
		<tr>
		<th width=80>가로수</th>
		<th width=80>세로수</th>
		<th width=80>가로수</th>
		<th width=80>세로수</th>
		<th width=80>가로너비</th>
		<th width=80>세로너비</th>
		<th width=80>가로너비</th>
		<th width=80>세로너비</th>
		<th width=80>PC목록</th>
		<th width=80>모바일목록</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td rowspan=4><b>상세설명</b></td>
		<td>상품댓글</td>
		<td></td>
		<td><input type="text" name="icomment_rows" value="<?php echo $rows['icomment_rows'] ?>" id="icomment_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="icomment_mobile_rows" value="<?php echo $rows['icomment_mobile_rows'] ?>" id="icomment_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>상품후기</td>
		<td></td>
		<td><input type="text" name="iuse_rows" value="<?php echo $rows['iuse_rows'] ?>" id="iuse_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="iuse_mobile_rows" value="<?php echo $rows['iuse_mobile_rows'] ?>" id="iuse_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>상품문의</td>
		<td></td>
		<td><input type="text" name="iqa_rows" value="<?php echo $rows['iqa_rows'] ?>" id="iqa_rows" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="iqa_mobile_rows" value="<?php echo $rows['iqa_mobile_rows'] ?>" id="iuse_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>관련상품</td>
		<td><input type="text" name="irelation_mods" value="<?php echo $rows['irelation_mods'] ?>" id="irelation_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_rows" value="<?php echo $rows['irelation_rows'] ?>" id="irelation_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_mobile_mods" value="<?php echo $rows['irelation_mobile_mods'] ?>" id="irelation_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="irelation_mobile_rows" value="<?php echo $rows['irelation_mobile_rows'] ?>" id="irelation_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="de_rel_img_width" value="<?php echo $default['de_rel_img_width']; ?>" id="de_rel_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_rel_img_height" value="<?php echo $default['de_rel_img_height']; ?>" id="de_rel_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_rel_img_width" value="<?php echo $default['de_mobile_rel_img_width']; ?>" id="de_mobile_rel_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_rel_img_height" value="<?php echo $default['de_mobile_rel_img_height']; ?>" id="de_mobile_rel_img_height" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td rowspan=5><b>그밖에</b></td>
		<td>상품검색</td>
		<td><input type="text" name="de_search_list_mod" value="<?php echo $default['de_search_list_mod']; ?>" id="de_search_list_mod" class="frm_input" size="8"></td>
		<td><input type="text" name="de_search_list_row" value="<?php echo $default['de_search_list_row']; ?>" id="de_search_list_row" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_list_mod" value="<?php echo $default['de_mobile_search_list_mod']; ?>" id="de_mobile_search_list_mod" class="frm_input" size="8"></td>
		<td></td>
		<td><input type="text" name="de_search_img_width" value="<?php echo $default['de_search_img_width']; ?>" id="de_search_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_search_img_height" value="<?php echo $default['de_search_img_height']; ?>" id="de_search_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_img_width" value="<?php echo $default['de_mobile_search_img_width']; ?>" id="de_mobile_search_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="de_mobile_search_img_height" value="<?php echo $default['de_mobile_search_img_height']; ?>" id="de_mobile_search_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="de_search_list_skin" id="de_search_list_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($default['de_search_list_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>
		</td>
		<td>
			<select name="de_mobile_search_list_skin" id="de_mobile_search_list_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($default['de_mobile_search_list_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>		
		</td>
		<td></td>
		</tr>	

		<tr>
		<td>상품유형</td>
		<td><input type="text" name="type_mods" value="<?php echo $rows['type_mods'] ?>" id="type_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="type_rows" value="<?php echo $rows['type_rows'] ?>" id="type_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_mods" value="<?php echo $rows['type_mobile_mods'] ?>" id="type_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_rows" value="<?php echo $rows['type_mobile_rows'] ?>" id="type_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="type_img_width" value="<?php echo $rows['type_img_width'] ?>" id="type_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="type_img_height" value="<?php echo $rows['type_img_height'] ?>" id="type_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_img_width" value="<?php echo $rows['type_mobile_img_width'] ?>" id="type_mobile_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="type_mobile_img_height" value="<?php echo $rows['type_mobile_img_height'] ?>" id="type_mobile_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="type_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['type_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>
		</td>
		<td>
			<select name="type_mobile_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['type_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>		
		</td>
		<td></td>
		</tr>	
		<tr>
		<td>마이샵</td>
		<td><input type="text" name="myshop_mods" value="<?php echo $rows['myshop_mods'] ?>" id="myshop_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_rows" value="<?php echo $rows['myshop_rows'] ?>" id="myshop_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_mods" value="<?php echo $rows['myshop_mobile_mods'] ?>" id="myshop_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_rows" value="<?php echo $rows['myshop_mobile_rows'] ?>" id="myshop_mobile_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_img_width" value="<?php echo $rows['myshop_img_width'] ?>" id="myshop_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_img_height" value="<?php echo $rows['myshop_img_height'] ?>" id="myshop_img_height" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_img_width" value="<?php echo $rows['myshop_mobile_img_width'] ?>" id="myshop_mobile_img_width" class="frm_input" size="8"></td>
		<td><input type="text" name="myshop_mobile_img_height" value="<?php echo $rows['myshop_mobile_img_height'] ?>" id="myshop_mobile_img_height" class="frm_input" size="8"></td>
		<td>
			<select name="myshop_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['myshop_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>
		</td>
		<td>
			<select name="myshop_mobile_skin">
			<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($rows['myshop_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
			} ?>
			</select>		
		</td>
		<td></td>
		</tr>	
		<tr>
		<td>이벤트</td>
		<td><input type="text" name="event_mods" value="<?php echo $rows['event_mods'] ?>" id="event_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="event_rows" value="<?php echo $rows['event_rows'] ?>" id="event_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="event_mobile_mods" value="<?php echo $rows['event_mobile_mods'] ?>" id="event_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="event_mobile_rows" value="<?php echo $rows['event_mobile_rows'] ?>" id="event_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>	
		<tr>
		<td>개인결제</td>
		<td><input type="text" name="ppay_mods" value="<?php echo $rows['ppay_mods'] ?>" id="ppay_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_rows" value="<?php echo $rows['ppay_rows'] ?>" id="ppay_rows" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_mobile_mods" value="<?php echo $rows['ppay_mobile_mods'] ?>" id="ppay_mobile_mods" class="frm_input" size="8"></td>
		<td><input type="text" name="ppay_mobile_rows" value="<?php echo $rows['ppay_mobile_rows'] ?>" id="ppay_mobile_rows" class="frm_input" size="8"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>	
		</tbody>
		</table>
	</div>

	<?php echo $frm_submit; ?>

	<br>

<?php } ?>

<div class="local_desc01 local_desc">
	<p><b>● XP 설정</b> - 처음 설정 저장 후 또는 설정 변경시 <b>'업데이트'</b>를 실행해야 모든 회원에게 일괄적용됩니다.</p>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
    <thead>
	<tr>
	<th width=80>구분</th>
	<th width=80>항목</th>
	<th>설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td rowspan="5"><b>XP 설정</b></td>
	<td>경험치룰</td>
	<td>
		<label><input type="checkbox" name="exp_point" value="1"<?php if($xp['exp_point']) echo ' checked';?>> 현재 회원 포인트(<?php echo AS_MP;?>) - 설정시 다른 룰은 무시되며, 포인트 사용에 따라 경험치와 레벨 등락 발생</label>

		<div style="height:1px; border-top:1px solid #ececec; margin:8px 0px;"></div>
		<style>
			.exp-rule label { display:inline-block; width:120px;}
		</style>
		<div class="exp-rule">
			<label><input type="checkbox" name="exp_login" value="1"<?php if($xp['exp_login']) echo ' checked';?>> 로그인 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_write" value="1"<?php if($xp['exp_write']) echo ' checked';?>> 쓰기 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_comment" value="1"<?php if($xp['exp_comment']) echo ' checked';?>> 댓글 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_read" value="1"<?php if($xp['exp_read']) echo ' checked';?>> 읽기 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_good" value="1"<?php if($xp['exp_good']) echo ' checked';?>> 추천 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_nogood" value="1"<?php if($xp['exp_nogood']) echo ' checked';?>> 비추천 <?php echo AS_MP;?></label>
			<label><input type="checkbox" name="exp_chulsuk" value="1"<?php if($xp['exp_chulsuk']) echo ' checked';?>> 출석 <?php echo AS_MP;?></label>
			<?php if(IS_YC) { ?>
				<label><input type="checkbox" name="exp_delivery" value="1"<?php if($xp['exp_delivery']) echo ' checked';?>> 구매 <?php echo AS_MP;?></label>
			<?php } ?>
		</div>
	</td>
	</tr>
	<tr>
	<td>레벨업룰</td>
	<td>
		<?php 
			//Default
			$xp['xp_point'] = ($xp['xp_point'] > 0) ? $xp['xp_point'] : 1000;
			$xp['xp_rate'] = ($xp['xp_rate'] > 0) ? $xp['xp_rate'] : 0.0;
			$xp['xp_max'] = ($xp['xp_max'] > 0) ? $xp['xp_max'] : 99; 
		?>
		<input type="text" id="xp_point" name="xp_point" size="6" value="<?php echo $xp['xp_point'];?>" class="frm_input"> <?php echo AS_MP;?>를 기준으로
		레벨당 기준 <?php echo AS_MP;?>의 <input type="text" id="xp_rate" name="xp_rate" size="4" value="<?php echo $xp['xp_rate'];?>" class="frm_input"> 배 추가 <?php echo AS_MP;?> 증가 
		(최고 <input type="text" id="xp_max" name="xp_max" size="4" value="<?php echo $xp['xp_max'];?>" class="frm_input"> 레벨)

		<div class="btn_confirm01 btn_confirm" style="text-align:left; padding:0; margin:0; margin-top:8px;">
			<a class="win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.php">경험치 시뮬레이터</a>
			<a class="win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.update.php">경험치 업데이트</a>
			<a class="win_memo" href="<?php echo G5_ADMIN_URL; ?>/apms_admin/apms.exp.default.php">경험치 초기화</a>
		</div>

	</td>
	</tr>
	<tr>
	<td>레벨표시</td>
	<td>
		<select name="xp_icon">
			<option value="txt">텍스트 표시</option>
			<option value="img"<?php if($xp['xp_icon'] == 'img') echo ' selected'; ?>>아이콘 표시</option>
		</select>
		&nbsp; &nbsp;
		텍스트 스킨
		<?php $xp_icon_css = apms_file_list('css/level', 'css');?>
		<select name="xp_icon_css" id="xp_icon_css">
			<?php for($i=0; $i < count($xp_icon_css); $i++) { ?>
				<option value="<?php echo $xp_icon_css[$i];?>"<?php echo get_selected($xp_icon_css[$i], $xp['xp_icon_css']); ?>><?php echo $xp_icon_css[$i];?></option>
			<?php } ?>
		</select>
		&nbsp; &nbsp;
		아이콘 스킨
		<?php $xp_icon_list = apms_dir_list('img/level');?>
		<select name="xp_icon_skin" id="xp_icon_skin">
			<?php for($i=0; $i < count($xp_icon_list); $i++) { ?>
				<option value="<?php echo $xp_icon_list[$i];?>"<?php echo get_selected($xp_icon_list[$i], $xp['xp_icon_skin']); ?>><?php echo $xp_icon_list[$i];?></option>
			<?php } ?>
		</select>
		&nbsp; &nbsp;
		<label><input type="checkbox" name="xp_now" value="1"<?php if($xp['xp_now']) echo ' checked';?>> 이름 앞에 회원레벨 표시 안함(보드는 개별설정)</label>
	</td>
	</tr>
	<tr>
	<td>자동등업</td>
	<td>
		<?php echo help("등업구간은 지정한 각 등급의 최고레벨을 차례대로 입력해 주세요."); ?>
		<select name="xp_from">
			<option value="0">등급</option>
			<option value="2"<?php if($xp['xp_from'] == "2") echo ' selected';?>>2등급</option>
			<option value="3"<?php if($xp['xp_from'] == "3") echo ' selected';?>>3등급</option>
			<option value="4"<?php if($xp['xp_from'] == "4") echo ' selected';?>>4등급</option>
			<option value="5"<?php if($xp['xp_from'] == "5") echo ' selected';?>>5등급</option>
			<option value="6"<?php if($xp['xp_from'] == "6") echo ' selected';?>>6등급</option>
			<option value="7"<?php if($xp['xp_from'] == "7") echo ' selected';?>>7등급</option>
			<option value="8"<?php if($xp['xp_from'] == "8") echo ' selected';?>>8등급</option>
			<option value="9"<?php if($xp['xp_from'] == "9") echo ' selected';?>>9등급</option>
		</select>
		부터
		<select name="xp_to">
			<option value="0">등급</option>
			<option value="9"<?php if($xp['xp_to'] == "9") echo ' selected';?>>9등급</option>
			<option value="8"<?php if($xp['xp_to'] == "8") echo ' selected';?>>8등급</option>
			<option value="7"<?php if($xp['xp_to'] == "7") echo ' selected';?>>7등급</option>
			<option value="6"<?php if($xp['xp_to'] == "6") echo ' selected';?>>6등급</option>
			<option value="5"<?php if($xp['xp_to'] == "5") echo ' selected';?>>5등급</option>
			<option value="4"<?php if($xp['xp_to'] == "4") echo ' selected';?>>4등급</option>
			<option value="3"<?php if($xp['xp_to'] == "3") echo ' selected';?>>3등급</option>
			<option value="2"<?php if($xp['xp_to'] == "2") echo ' selected';?>>2등급</option>
		</select>
		까지 회원은 레벨에 따른 자동등업 적용

		<div style="height:8px;"></div>

		<i class="fa fa-arrow-circle-up"></i>
		1레벨
		>
		<input type="text" name="xp_auto1" size="3" value="<?php echo $xp['xp_auto1'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto2" size="3" value="<?php echo $xp['xp_auto2'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto3" size="3" value="<?php echo $xp['xp_auto3'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto4" size="3" value="<?php echo $xp['xp_auto4'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto5" size="3" value="<?php echo $xp['xp_auto5'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto6" size="3" value="<?php echo $xp['xp_auto6'];?>" class="frm_input"> 
		>
		<input type="text" name="xp_auto7" size="3" value="<?php echo $xp['xp_auto7'];?>" class="frm_input">
		레벨 
	</td>
	</tr>
	<tr>
	<td>스페셜회원</td>
	<td>
		<?php echo help("회원아이디를 콤마(,)로 구분해서 등록해 주세요."); ?>
		<input type="text" name="xp_special" value="<?php echo $xp['xp_special'];?>" class="frm_input" style="width:98%">
	</td>
	</tr>
	<tr>
	<td rowspan=2><b>용어설정</b></td>
	<td>경험치</td>
	<td><input type="text" name="as_xp" size="10" value="<?php echo $config['as_xp'];?>" class="frm_input"> 표현코드 : &lt;?php echo AS_XP;?></td>
	</tr>
	<tr>
	<td>포인트</td>
	<td><input type="text" name="as_mp" size="10" value="<?php echo $config['as_mp'];?>" class="frm_input"> 표현코드 : &lt;?php echo AS_MP;?></td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>

<br>

<div class="local_desc01 local_desc">
	<p><b>● 회원 설정</b> - 회원등급은 그누보드의 회원레벨을 말합니다.</p>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
	<thead>
	<tr>
	<th align="center" width=80>구분</th>
	<th width=80>항목</th>
	<th>설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><b>회원사진</b></td>
	<td>사진크기</td>
	<td>
		<input type="text" name="xp_photo" size="4" value="<?php echo $xp['xp_photo'];?>" class="frm_input"> px
	</td>
	</tr>
	<tr class="tr-bg">
	<td><b>회원등급</b></td>
	<td>표시문구</td>
	<td>
		<style>
			.grade-txt span { display:inline-block; width:280px; margin:3px 0px;}
		</style>
		<div class="grade-txt">
			<span><input type="text" name="xp_grade1" size="15" value="<?php echo $xp['xp_grade1'];?>" class="frm_input"> 1등급 - 예) 비회원</span>
			<span><input type="text" name="xp_grade2" size="15" value="<?php echo $xp['xp_grade2'];?>" class="frm_input"> 2등급 - 예) 실버회원</span>
			<span><input type="text" name="xp_grade3" size="15" value="<?php echo $xp['xp_grade3'];?>" class="frm_input"> 3등급 - 예) 골드회원</span>
			<span><input type="text" name="xp_grade4" size="15" value="<?php echo $xp['xp_grade4'];?>" class="frm_input"> 4등급 - 예) 로열회원</span>
			<span><input type="text" name="xp_grade5" size="15" value="<?php echo $xp['xp_grade5'];?>" class="frm_input"> 5등급 - 예) 프렌드회원</span>
			<span><input type="text" name="xp_grade6" size="15" value="<?php echo $xp['xp_grade6'];?>" class="frm_input"> 6등급 - 예) 패밀리회원</span>
			<span><input type="text" name="xp_grade7" size="15" value="<?php echo $xp['xp_grade7'];?>" class="frm_input"> 7등급 - 예) 스페셜회원</span>
			<span><input type="text" name="xp_grade8" size="15" value="<?php echo $xp['xp_grade8'];?>" class="frm_input"> 8등급 - 예) 운영자</span>
			<span><input type="text" name="xp_grade9" size="15" value="<?php echo $xp['xp_grade9'];?>" class="frm_input"> 9등급 - 예) 관리자</span>
			<span><input type="text" name="xp_grade10" size="15" value="<?php echo $xp['xp_grade10'];?>" class="frm_input"> 10등급 - 예) 최고관리자</span>
		</div>
	</td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>

<br>

<div class="local_desc01 local_desc">
	<p><b>● 복수관리자 설정</b> - 최고관리자만 설정이 가능하고, 회원아이디는 콤마(,)로 구분해서 등록합니다.</p>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
	<thead>
	<tr>
	<th align="center" width=80>구분</th>
	<th width=80>항목</th>
	<th>회원아이디</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td rowspan=2><b>최고관리자</b></td>
	<td>등록회원</td>
	<td>
		<input type="text" name="as_admin" size="45" value="<?php echo $config['as_admin'];?>" class="frm_input" style="width:98%;">
	</td>
	</tr>
	<tr>
	<td>일반레벨</td>
	<td>
		<?php echo help("최고관리자 레벨표시를 하지 않고 일반레벨로 표시할 회원아이디를 등록해 주세요."); ?>
		<input type="text" name="xp_except" size="45" value="<?php echo $xp['xp_except'];?>" class="frm_input" style="width:98%;">	
	</td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>

</form>
