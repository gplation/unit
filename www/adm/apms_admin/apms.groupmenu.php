<?php
$sub_menu = '777002';
include_once('./_common.php');

if(!$gr_id) {
	alert_close('값이 넘어오지 않았습니다.');
}

check_demo();

if($mode == 'menu') {

	auth_check($auth[$sub_menu], 'w'); //쓰기 권한

	$cnt = count($_POST['type']);

	for($i=0; $i < $cnt; $i++) {

		if($_POST['type'][$i] == "board") {

			if(!$_POST['id_board'][$i]) continue;

			//board_table
			$sql = " update {$g5['board_table']}
						set as_order				= '{$_POST['as_order'][$i]}'
							, bo_subject			= '{$_POST['bo_subject'][$i]}'
							, bo_mobile_subject		= '{$_POST['bo_mobile_subject'][$i]}'
							, bo_device				= '{$_POST['bo_device'][$i]}'
							, as_icon				= '{$_POST['as_icon'][$i]}'
							, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
							, as_title				= '{$_POST['as_title'][$i]}'
							, as_desc				= '{$_POST['as_desc'][$i]}'
							, as_link				= '{$_POST['as_link'][$i]}'
							, as_target				= '{$_POST['as_target'][$i]}'
							, as_line				= '{$_POST['as_line'][$i]}'
							, as_show				= '{$_POST['as_show'][$i]}'
							, as_menu				= '{$_POST['as_menu'][$i]}'
							, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							where bo_table = '{$_POST['id_board'][$i]}'
							";
			sql_query($sql);

		} else if($_POST['type'][$i] == "html") {

			if(!$_POST['id'][$i]) continue;

			//html_table
			$sql = " update {$g5['apms_page']}
						set as_order				= '{$_POST['as_order'][$i]}'
							, bo_subject			= '{$_POST['bo_subject'][$i]}'
							, bo_mobile_subject		= '{$_POST['bo_mobile_subject'][$i]}'
							, bo_device				= '{$_POST['bo_device'][$i]}'
							, as_icon				= '{$_POST['as_icon'][$i]}'
							, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
							, as_title				= '{$_POST['as_title'][$i]}'
							, as_desc				= '{$_POST['as_desc'][$i]}'
							, as_link				= '{$_POST['as_link'][$i]}'
							, as_target				= '{$_POST['as_target'][$i]}'
							, as_line				= '{$_POST['as_line'][$i]}'
							, as_show				= '{$_POST['as_show'][$i]}'
							, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							where id = '{$_POST['id'][$i]}'
							";
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
	goto_url('./apms.groupmenu.php?gr_id='.$gr_id);
}

auth_check($auth[$sub_menu], 'r'); //읽기 권한

$result2 = sql_query("select * from {$g5['board_table']} where gr_id = '{$gr_id}' ");
for ($k=0; $row2=sql_fetch_array($result2); $k++) {
	$bo[$k] = $row2;
}
$result3 = sql_query("select * from {$g5['apms_page']} where gr_id = '{$gr_id}' ");
for ($k=$k; $row3=sql_fetch_array($result3); $k++) {
	$bo[$k] = $row3;
}

$bo_cnt = count($bo);

if(!$bo_cnt) {
	alert_close('등록된 서브메뉴가 없습니다.');
}

if($bo_cnt > 0) $bo = apms_sort($bo, 'as_order');

include_once(G5_PATH.'/head.sub.php');

?>

<div id="wrapper">
    <div id="container">

		<h1><b><?php echo $group['gr_subject'];?></b> 그룹 서브메뉴 설정</h1>

		<div class="local_ov01 local_ov">
			보임이 체크되지 않은 보드나 문서는 메뉴에 출력되지 않습니다. 
		</div>

		<form id="menuform" name="menuform" method="post">
		<input type="hidden" name="mode" value="menu">
		<input type="hidden" name="gr_id" value="<?php echo $gr_id;?>">

		<div class="tbl_head01 tbl_wrap">
			<table>
			<thead>
			<tr>
			<th width=60>보임</th>
			<th width=60>출력기기</th>
			<th width=60>서브메뉴</th>
			<th width=40>순서</th>
			<th width=100>PC 아이콘</th>
			<th width=100>PC 메뉴명</th>
			<th width=100>모바일 아이콘</th>
			<th width=100>모바일 메뉴명</th>
			<th width=160>타이틀</th>
			<th>설명글</th>
			<th width=120>링크</th>
			<th width=60> 타켓</th>
			<th width=120> 상단라인</th>
			<th width=80>접근레벨</th>
			<th width=100>접근등급</th>
			<th width=60>제한</th>
			<th width=60>와이드</th>
			<th width=60>파트너</th>
			<th width=40>보기</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$z = 0;
				for ($k=0; $k < $bo_cnt; $k++) {
					$chk_asr = false;
					$is_html = $bo[$k]['html_id'] ? true : false;
			?>
				<tr>
				<td align="center">
					<input type="checkbox" class="chk_show" name="as_show[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_show'] ? " checked" : ""); ?>>
				</td>
				<td align="center">
					<select name="bo_device[<?php echo $z; ?>]">
						<option value="both"<?php if($bo[$k]['bo_device'] == 'both') echo ' selected';?>>모두</option>
						<option value="pc"<?php if($bo[$k]['bo_device'] == 'pc') echo ' selected';?>>PC</option>
						<option value="mobile"<?php if($bo[$k]['bo_device'] == 'mobile') echo ' selected';?>>모바일</option>
					</select>
				</td>
				<td align="center" style="color:#888;">
					<?php if($is_html) { ?>
						<?php echo $bo[$k]['as_html'] ? '일반' : '기본'; ?>
					<?php } else { ?>
						<select name="as_menu[<?php echo $z; ?>]" style="width:50px;">
							<option value="0">YES - 분류 출력</option>
							<option value="1"<?php if($bo[$k]['as_menu'] == "1") echo " selected";?>>NO - 출력 안함</option>
							<option value="2"<?php if($bo[$k]['as_menu'] == "2") echo " selected";?>>PC만 분류출력</option>
						</select>
					<?php } ?>
				</td>

				<td align="center">
					<input type="text" name="as_order[<?php echo $z; ?>]" size="2" value="<?php echo $bo[$k]['as_order']; ?>" class="frm_input">
				</td>
				<td>
					<input type="text" name="as_icon[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="bo_subject[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['bo_subject'];?>" placeholder="PC 메뉴명" class="frm_input">
				</td>
				<td>
					<input type="text" name="as_mobile_icon[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="bo_mobile_subject[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['bo_mobile_subject'];?>" placeholder="모바일 메뉴명" class="frm_input">
				</td>
				<td>
					<input type="text" name="as_title[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;min-width:200px;">
				</td>
				<td>
					<input type="text" name="as_desc[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;min-width:200px;">
				</td>
				<td>
					<input type="text" name="as_link[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_link'];?>" placeholder="http://..." class="frm_input">
				</td>
				<td align="center">
					<input type="text" name="as_target[<?php echo $z;?>]" size="10" value="<?php echo $bo[$k]['as_target'];?>" placeholder="target" class="frm_input">
				</td>
				<td align="center">
					<input type="text" name="as_line[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_line'];?>" class="frm_input">
				</td>
				<td align="center">
					<nobr>
					<input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $bo[$k]['as_min'];?>" placeholder="From" class="frm_input">
					~
					<input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $bo[$k]['as_max'];?>" placeholder="To" class="frm_input">
					</nobr>
				</td>
				<td align="center">
					<nobr>
					<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $bo[$k]['as_grade']); ?>
					<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
						<option value="0">≥</option>
						<option value="1"<?php if($bo[$k]['as_equal'] == "1") echo " selected";?>>＝</option>
					</select>
					</nobr>
				</td>
				<td align="center">
					<select name="as_menu_show[<?php echo $z; ?>]" style="width:50px;">
						<option value="0">NO - 항상 메뉴 출력</option>
						<option value="1"<?php if($bo[$k]['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
					</select>
				</td>
				<td align="center">
					<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_wide'] ? " checked" : ""); ?>>
				</td>
				<td align="center">
					<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_partner'] ? " checked" : ""); ?>>
				</td>
				<td align="center">
					<?php if($is_html) { ?>
						<input type="hidden" name="id[<?php echo $z;?>]" value="<?php echo $bo[$k]['id'];?>">
							<?php if($bo[$k]['as_html']) { ?>
								<a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($bo[$k]['html_id']);?>" target="_blank">보기</a>
							<?php } else { ?>
								<a href="<?php echo G5_URL;?>/<?php echo $bo[$k]['as_file'];?>" target="_blank">보기</a>
							<?php } ?>
						<input type="hidden" name="type[<?php echo $z;?>]" value="html">
					<?php } else { ?>
						<input type="hidden" name="id_board[<?php echo $z;?>]" value="<?php echo $bo[$k]['bo_table'];?>"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo[$k]['bo_table'];?>" target="_blank"><i class="fa fa-file-text-o fa-lg"></i></a>
						<input type="hidden" name="type[<?php echo $z;?>]" value="board">
					<?php } ?>
				</td>
				</tr>
			<?php $z++; } ?>
			<?php
			if (!$k)
				echo '<tr><td colspan="19" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
			?>
			</tbody>
			</table>
		</div>

		<div class="btn_list01 btn_list" style="text-align:center;">
			<button type="button" class="chk_all">모두보임</button>
			<a href="<?php echo G5_BBS_URL;?>/icon.php" class="win_memo">아이콘 검색</a>
			<input type="submit" value="일괄저장">
			<button type="button" onclick="self.close();">창닫기</button>
		</div>

		</form>
	</div>
</div>
<script>
	var win_w = screen.width;
	var win_h = screen.height - 40;
	window.moveTo(0, 0);
	window.resizeTo(win_w, win_h);

	$(function(){
		$('.chk_all').click(function(){
			$('#menuform .chk_show').attr('checked', true);
		});
	});
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>