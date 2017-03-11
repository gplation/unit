<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($mode == 'menu') {

	//config_table
	sql_query(" update {$g5['config_table']} set cf_10_subj = '{$_POST['cf_10_subj']}', cf_10 = '{$_POST['cf_10']}', cf_9 = '{$_POST['cf_9']}' ", false);

	$cnt = count($_POST['type']);

	for($i=0; $i < $cnt; $i++) {

		if(!$_POST['type'][$i]) continue;

		if($_POST['type'][$i] == "group") {

			if(!$_POST['id_group'][$i]) continue;

			//group_table
			$sql = " update {$g5['group_table']}
						set gr_order				= '{$_POST['gr_order'][$i]}'
							, gr_subject			= '{$_POST['gr_subject'][$i]}'
							, gr_device				= '{$_POST['gr_device'][$i]}'
							, as_icon				= '{$_POST['as_icon'][$i]}'
							, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
							, as_main				= '{$_POST['as_main'][$i]}'
							, as_link				= '{$_POST['as_link'][$i]}'
							, as_target				= '{$_POST['as_target'][$i]}'
							, as_show				= '{$_POST['as_show'][$i]}'
							, as_menu				= '{$_POST['as_menu'][$i]}'
							, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_multi				= '{$_POST['as_multi'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							, as_thema				= '{$_POST['as_thema'][$i]}'
							, as_color				= '{$_POST['as_color'][$i]}'
							, as_mobile_thema		= '{$_POST['as_mobile_thema'][$i]}'
							, as_mobile_color		= '{$_POST['as_mobile_color'][$i]}'
							where gr_id = '{$_POST['id_group'][$i]}'
							";
			sql_query($sql);

		} else if($_POST['type'][$i] == "shop") {
			
			if(!$_POST['ca_id'][$i]) continue;

			$sql = " update {$g5['g5_shop_category_table']}
						set ca_name             = '{$_POST['ca_name'][$i]}'
							, ca_order          = '{$_POST['ca_order'][$i]}'
							, as_icon			= '{$_POST['as_icon'][$i]}'
							, as_mobile_icon	= '{$_POST['as_mobile_icon'][$i]}'
							, as_link			= '{$_POST['as_link'][$i]}'
							, as_target			= '{$_POST['as_target'][$i]}'
							, as_show			= '{$_POST['as_show'][$i]}'
							, as_menu			= '{$_POST['as_menu'][$i]}'
							, as_menu_show		= '{$_POST['as_menu_show'][$i]}'
							, as_grade			= '{$_POST['as_grade'][$i]}'
							, as_equal			= '{$_POST['as_equal'][$i]}'
							, as_wide			= '{$_POST['as_wide'][$i]}'
							, as_multi			= '{$_POST['as_multi'][$i]}'
							, as_partner		= '{$_POST['as_partner'][$i]}'
							, as_min			= '{$_POST['as_min'][$i]}'
							, as_max			= '{$_POST['as_max'][$i]}'
							, as_title			= '{$_POST['as_title'][$i]}'
							, as_desc			= '{$_POST['as_desc'][$i]}'
							, as_thema			= '{$_POST['as_thema'][$i]}'
							, as_color			= '{$_POST['as_color'][$i]}'
							, as_mobile_thema	= '{$_POST['as_mobile_thema'][$i]}'
							, as_mobile_color	= '{$_POST['as_mobile_color'][$i]}'
					  where ca_id = '{$_POST['ca_id'][$i]}' ";
			sql_query($sql);
		}
	}

	//자동메뉴 캐시
	if(IS_YC) {
		apms_cache('apms_mobile_shop_menu', 0, "apms_chk_auto_menu(1,1,1)");
		apms_cache('apms_pc_shop_menu', 0, "apms_chk_auto_menu(1,0,1)");
	}
	apms_cache('apms_mobile_bbs_menu', 0, "apms_chk_auto_menu(1,1)");
	apms_cache('apms_pc_bbs_menu', 0, "apms_chk_auto_menu(1)");

	//Move
	goto_url($go_url);
}

// Thema
$thema_list = apms_dir_list('thema');

?>

<div class="local_ov01 local_ov">
	<b>자동메뉴와 그룹/분류별 테마설정</b> - 그룹/분류별로 테마 미설정시 그룹은 커뮤니티 기본 테마가 분류는 쇼핑몰 기본 테마가 자동 적용됩니다.
</div>

<form id="menulistform" name="menulistform" method="post" style="border-bottom:0px;">
<input type="hidden" name="ap" value="menu">
<input type="hidden" name="mode" value="menu">
<div class="tbl_head01 tbl_wrap">
	<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
		<li>접근레벨은 최소레벨(위)과 최대레벨(아래)을 각각 입력하시면 됩니다. 단, 관리자는 접근등급과 레벨이 적용안됩니다.</li>
		<li>새글 표시 시간 : <input type="text" name="cf_10" size="4" value="<?php echo ((int)$config['cf_10'] > 0) ? $config['cf_10'] : 24; ?>" class="frm_input"> 시간 이내 등록된 자료가 있는 메뉴는 새글 표시합니다.</li>
		<li>자동 메뉴 캐시 : <input type="text" name="cf_9" size="4" value="<?php echo ((int)$config['cf_9'] > 0) ? $config['cf_9'] : 0; ?>" class="frm_input"> 초 단위로 자동 메뉴 새로고침('0' 입력시 실시간 출력 - 느림)</li>
		<li>통계 현황 캐시 : <input type="text" name="cf_10_subj" size="4" value="<?php echo ((int)$config['cf_10_subj'] > 0) ? $config['cf_10_subj'] : 0; ?>" class="frm_input"> 초 단위로 통계를 새로고침('0' 입력시 실시간 출력 - 느림)</li>
	</ul>

	<table>
	<thead>
	<tr>
	<th width=90>서브메뉴</th>
	<th width=60>그룹메뉴</th>
	<th width=60>출력기기</th>
	<th width=40>순서</th>
	<th width=120>그룹(메뉴)명</th>
	<th width=120>PC 아이콘</th>
	<th width=120>모바일 아이콘</th>
	<th>링크</th>
	<th width=80> 타켓</th>
	<th width=100>메인</th>
	<th width=80>접근레벨</th>
	<th width=100>접근등급</th>
	<th width=60>출력</th>
	<th width=60>제한</th>
	<th width=60>와이드</th>
	<th width=60>멀티</th>
	<th width=60>파트너</th>
	<th width=140>PC</th>
	<th width=140>모바일</th>
	<th width=40>보기</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$z = 0;
		$main_list = apms_file_list('data/apms/main', 'php');
		$result = sql_query("select * from {$g5['group_table']} order by gr_order");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
	?>
		<tr>
		<td align="center"><a href="./apms.groupmenu.php?gr_id=<?php echo $row['gr_id'];?>" class="btn_frmline win_point"><nobr>서브메뉴설정</nobr></a></td>
		<td align="center">
			<select name="as_show[<?php echo $z; ?>]">
				<option value="0">메뉴숨김</option>
				<option value="1"<?php if($row['as_show'] == '1') echo ' selected';?>>모두보임</option>
				<?php if(IS_YC) { ?>
					<option value="2"<?php if($row['as_show'] == '2') echo ' selected';?>>커뮤니티</option>
					<option value="3"<?php if($row['as_show'] == '3') echo ' selected';?>>쇼핑몰</option>
				<?php } ?>
			</select>
		</td>
		<td>
			<select name="gr_device[<?php echo $z; ?>]">
				<option value="both"<?php if($row['gr_device'] == 'both') echo ' selected';?>>모두</option>
				<option value="pc"<?php if($row['gr_device'] == 'pc') echo ' selected';?>>PC</option>
				<option value="mobile"<?php if($row['gr_device'] == 'mobile') echo ' selected';?>>모바일</option>
			</select>
		</td>
		<td align="center">
			<input type="hidden" name="type[<?php echo $z;?>]" value="group">
			<input type="hidden" name="id_group[<?php echo $z;?>]" value="<?php echo $row['gr_id'];?>">
			<input type="text" name="gr_order[<?php echo $z; ?>]" size="2" value="<?php echo $row['gr_order']; ?>" class="frm_input">
		</td>
		<td>
			<input type="text" name="gr_subject[<?php echo $z;?>]" size="15" value="<?php echo $row['gr_subject'];?>" placeholder="PC/모바일 메뉴명" class="frm_input">
		</td>
		<td>
			<input type="text" name="as_icon[<?php echo $z;?>]" size="15" value="<?php echo $row['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
		</td>
		<td>
			<input type="text" name="as_mobile_icon[<?php echo $z;?>]" size="15" value="<?php echo $row['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
		</td>
		<td>
			<input type="text" name="as_link[<?php echo $z;?>]" size="15" value="<?php echo $row['as_link'];?>" placeholder="http://..." class="frm_input" style="width:98%;min-width:200px;">
		</td>
		<td>
			<input type="text" name="as_target[<?php echo $z;?>]" size="10" value="<?php echo $row['as_target'];?>" placeholder="target" class="frm_input">
		</td>
		<td align="center">
			<?php echo apms_select_list($main_list, 'as_main['.$z.']', $row['as_main'], '메인없음', 90, 1);?>
		</td>
		<td align="center">
			<nobr>
			<input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $row['as_min'];?>" placeholder="From" class="frm_input">
			~
			<input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $row['as_max'];?>" placeholder="To" class="frm_input">
			</nobr>
		</td>
		<td align="center">
			<nobr>
			<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $row['as_grade']); ?>
			<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
				<option value="0">≥</option>
				<option value="1"<?php if($row['as_equal'] == "1") echo " selected";?>>＝</option>
			</select>
			</nobr>
		</td>
		<td align="center">
			<select name="as_menu[<?php echo $z; ?>]" style="width:50px;">
				<option value="0">YES - 항상 메인메뉴에 그룹명 출력</option>
				<option value="1"<?php if($row['as_menu'] == "1") echo " selected";?>>NO - 보드 1개일 때 메인메뉴에 보드명 출력</option>
			</select>
		</td>
		<td align="center">
			<select name="as_menu_show[<?php echo $z; ?>]" style="width:50px;">
				<option value="0">NO - 항상 메뉴 출력</option>
				<option value="1"<?php if($row['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
			</select>
		</td>
		<td align="center">
			<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($row['as_wide'] ? " checked" : ""); ?>>
		</td>
		<td align="center">
			<select name="as_multi[<?php echo $z; ?>]" style="width:50px;">
				<option value="0">NO - 사용안함</option>
				<option value="1"<?php if($row['as_multi'] == "1") echo " selected";?>>YES - 전체메뉴 제외</option>
				<option value="2"<?php if($row['as_multi'] == "2") echo " selected";?>>YES - 전체메뉴 포함</option>
			</select>
		</td>
		<td align="center">
			<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($row['as_partner'] ? " checked" : ""); ?>>
		</td>
		<td align="center">
			<nobr>
			<?php echo apms_thema_skin($thema_list, 'as_thema['.$i.']', $row['as_thema'], 'as_color_'.$i, 'as_color['.$i.']', '기본테마', 50);?>
			<span id="as_color_<?php echo $i;?>" style="display:inline;">
				<?php echo apms_colorset_skin($row['as_thema'], 'as_color['.$i.']', $row['as_color'], '기본컬러셋', 60);?>
			</span>	
			</nobr>
		</td>
		<td align="center">
			<nobr>
			<?php echo apms_thema_skin($thema_list, 'as_mobile_thema['.$i.']', $row['as_mobile_thema'], 'as_mobile_color_'.$i, 'as_mobile_color['.$i.']','기본테마', 50);?>
			<span id="as_mobile_color_<?php echo $i;?>" style="display:inline;">
				<?php echo apms_colorset_skin($row['as_mobile_thema'], 'as_mobile_color['.$i.']', $row['as_mobile_color'], '기본컬러셋', 60);?>
			</span>	
			</nobr>
		</td>
		<td align="center">
			<?php if($row['as_main']) { ?>
				<a href="<?php echo G5_BBS_URL;?>/main.php?gid=<?php echo $row['gr_id'];?>"><i class="fa fa-file-text-o fa-lg"></i></a>
			<?php } ?>
		</td>		
		</tr>
	<?php $z++; } ?>
	<?php
    if (!$i)
        echo '<tr><td colspan="20" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
	?>
	</tbody>
	</table>
</div>

<div class="btn_list01 btn_list" style="text-align:center;">
	<a href="./apms.file.php?type=main" class="win_memo">메인등록</a>
	<a href="<?php echo G5_BBS_URL;?>/icon.php" class="win_memo">아이콘 검색</a>
	<input type="submit" value="일괄저장">
    <a href="<?php echo G5_ADMIN_URL;?>/boardgroup_list.php">그룹관리</a>
</div>

<br><br>

<?php if(IS_YC) { ?>
	<?php
	// 출력할 레코드를 얻음
	$sql  = " select * from {$g5['g5_shop_category_table']} where length(ca_id) = '2' order by ca_order asc, ca_id asc ";
	$result = sql_query($sql);
	?>
	<div class="tbl_head01 tbl_wrap">
		<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
			<li>접근레벨은 최소레벨(위)과 최대레벨(아래)을 각각 입력하시면 됩니다. 단, 관리자는 접근등급과 레벨이 적용안됩니다.</li>
		</ul>

		<table>
		<thead>
		<tr>
		<th width=150 colspan="2">서브메뉴</th>
		<th width=40><nobr>분류메뉴</nobr></th>
		<th width=50><nobr>코드</nobr></th>
		<th width=50><nobr>순서</nobr></th>
		<th width=120>분류(메뉴명)</th>
		<th width=120>PC 아이콘</th>
		<th width=120>모바일 아이콘</th>
		<th width=140>타이틀</th>
		<th>설명글</th>
		<th width=120>링크</th>
		<th width=80> 타켓</th>
		<th width=80>접근레벨</th>
		<th width=100>접근등급</th>
		<th width=60>제한</th>
		<th width=60>와이드</th>
		<th width=60>멀티</th>
		<th width=60>파트너</th>
		<th width=140>PC</th>
		<th width=140>모바일</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
			<tr<?php echo $bg; ?>>
			<td align="center"><a href="./apms.shopmenu.php?cid=<?php echo $row['ca_id'];?>" class="btn_frmline win_point"><nobr>서브메뉴설정</nobr></a></td>
			<td align="center">
				<select name="as_menu[<?php echo $z; ?>]" style="width:50px;">
					<option value="0">YES - 하위 분류 출력</option>
					<option value="1"<?php if($row['as_menu'] == "1") echo " selected";?>>하위 분류 출력안함</option>
					<option value="2"<?php if($row['as_menu'] == "2") echo " selected";?>>PC만 하위 분류 출력</option>
				</select>
			</td>
			<td align="center">
				<select name="as_show[<?php echo $z; ?>]">
					<option value="0">메뉴숨김</option>
					<option value="1"<?php if($row['as_show'] == '1') echo ' selected';?>>모두보임</option>
					<option value="2"<?php if($row['as_show'] == '2') echo ' selected';?>>커뮤니티</option>
					<option value="3"<?php if($row['as_show'] == '3') echo ' selected';?>>쇼핑몰</option>
				</select>
			</td>
			<td align=center>
				<input type="hidden" name="ca_id[<?php echo $z; ?>]" value="<?php echo $row['ca_id']; ?>">
				<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>"><?php echo $row['ca_id']; ?></a>
			</td>
			<td align=center>
				<input type="hidden" name="type[<?php echo $z;?>]" value="shop">
				<input type="text" name="ca_order[<?php echo $z; ?>]" value='<?php echo $row['ca_order']; ?>' size="3" class="frm_input">
			</td>
			<td align=center>
				<input type="text" name="ca_name[<?php echo $z; ?>]" size="15" value="<?php echo get_text($row['ca_name']); ?>" required placeholder="분류명" class="frm_input">
			</td>
			<td align=center>
				<input type="text" name="as_icon[<?php echo $z;?>]" size="15" value="<?php echo $row['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
			</td>
			<td align=center>
				<input type="text" name="as_mobile_icon[<?php echo $z;?>]" size="15" value="<?php echo $row['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
			</td>
			<td align=center>
				<input type="text" name="as_title[<?php echo $z;?>]" size="15" value="<?php echo $row['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;min-width:140px;">
			</td>
			<td align=center>
				<input type="text" name="as_desc[<?php echo $z;?>]" size="15" value="<?php echo $row['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;min-width:140px;">
			</td>
			<td align=center>
				<input type="text" name="as_link[<?php echo $z;?>]" size="15" value="<?php echo $row['as_link'];?>" placeholder="http://..." class="frm_input">
			</td>
			<td align=center>
				<input type="text" name="as_target[<?php echo $z;?>]" size="10" value="<?php echo $row['as_target'];?>" placeholder="target" class="frm_input">
			</td>
			<td align=center>
				<nobr>
				<input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $row['as_min'];?>" placeholder="From" class="frm_input">
				~
				<input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $row['as_max'];?>" placeholder="To" class="frm_input">
				</nobr>

			</td>
			<td align=center>
				<nobr>
					<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $row['as_grade']); ?>
					<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
						<option value="0">≥</option>
						<option value="1"<?php if($row['as_equal'] == "1") echo " selected";?>>＝</option>
					</select>
				</nobr>
			</td>
			<td align=center>
				<select name="as_menu_show[<?php echo $z; ?>]" style="width:50px;">
					<option value="0">NO - 항상 메뉴 출력</option>
					<option value="1"<?php if($row['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
				</select>
			</td>
			<td align="center">
				<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($row['as_wide'] ? " checked" : ""); ?>>
			</td>
			<td align="center">
				<select name="as_multi[<?php echo $z; ?>]" style="width:50px;">
					<option value="0">NO - 사용안함</option>
					<option value="1"<?php if($row['as_multi'] == "1") echo " selected";?>>YES - 전체메뉴 제외</option>
					<option value="2"<?php if($row['as_multi'] == "2") echo " selected";?>>YES - 전체메뉴 포함</option>
				</select>
			</td>
			<td align="center">
				<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($row['as_partner'] ? " checked" : ""); ?>>
			</td>
			<td align=center>
				<nobr>
					<?php echo apms_thema_skin($thema_list, 'as_thema['.$z.']', $row['as_thema'], 'as_color_'.$z, 'as_color['.$z.']', '기본테마', 50);?>
					<span id="as_color_<?php echo $z;?>">
						<?php echo apms_colorset_skin($row['as_thema'], 'as_color['.$z.']', $row['as_color'], '기본컬러셋', 60);?>
					</span>	
				</nobr>
			</td>
			<td align=center>
				<nobr>
					<?php echo apms_thema_skin($thema_list, 'as_mobile_thema['.$z.']', $row['as_mobile_thema'], 'as_mobile_color_'.$z, 'as_mobile_color['.$z.']','기본테마', 50);?>
					<span id="as_mobile_color_<?php echo $z;?>">
						<?php echo apms_colorset_skin($row['as_mobile_thema'], 'as_mobile_color['.$z.']', $row['as_mobile_color'], '기본컬러셋', 60);?>
					</span>	
				</nobr>
			</td>	
			</tr>
		<?php $z++; } ?>
		<?php
		if (!$i)
			echo '<tr><td colspan="20" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<div class="btn_list01 btn_list" style="text-align:center;">
		<a href="<?php echo G5_BBS_URL;?>/icon.php" class="win_memo">아이콘 검색</a>
		<input type="submit" value="일괄저장">
		<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/categorylist.php">분류관리</a>
	</div>
<?php } ?>
</form>
