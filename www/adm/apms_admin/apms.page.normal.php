<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($mode == 'npage') {

	if($opt == 'insert') {

		if(!$_POST['html_id']) alert("HTML ID를 입력해 주세요.");

		$row = sql_fetch("select html_id from {$g5['apms_page']} where html_id = '{$_POST['html_id']}' and as_html = '1' ", false);
		if($row['html_id']) {
			alert("이미 등록된 일반문서입니다.");
		} else {
			
			if($_POST['as_shop']) $_POST['html_gr_id'] = '';

			sql_query(" insert {$g5['apms_page']} set gr_id = '{$_POST['html_gr_id']}', co_id = '{$_POST['co_id']}', html_id = '{$_POST['html_id']}', as_file = '{$_POST['as_file']}', as_title = '{$_POST['as_title']}', as_desc = '{$_POST['as_desc']}', bo_subject = '{$_POST['bo_subject']}', as_wide = '{$_POST['as_wide']}', as_partner = '{$_POST['as_partner']}', as_html = '1' ", false);
		}
	} else if($opt == 'edit') {
		$cnt = count($_POST['id']);
		for($i=0; $i < $cnt; $i++) {

			if(!$_POST['id'][$i]) continue;
			
			if($_POST['as_shop'][$i]) $_POST['html_gr_id'][$i] = '';

			$sql = " update {$g5['apms_page']}
						set gr_id					= '{$_POST['html_gr_id'][$i]}'
							, co_id					= '{$_POST['co_id'][$i]}'
							, as_file				= '{$_POST['as_file'][$i]}'
							, as_title				= '{$_POST['as_title'][$i]}'
							, as_desc				= '{$_POST['as_desc'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							, bo_subject			= '{$_POST['bo_subject'][$i]}'
							where id = '{$_POST['id'][$i]}'
							";
			sql_query($sql);
		}
	} else if($opt == 'del') {
		$cn = $_POST['chk_id'];
		$cnt = count($cn);
		for($i=0; $i < $cnt; $i++) {
			$n = $cn[$i];
			$id = $_POST['id'][$n];
			if(!$id) continue;
			sql_query(" delete from {$g5['apms_page']} where id = '$id' ", false);
		}
	}

	//Move
	goto_url($go_url);
}

//Group List
$html_gr = array();
$result = sql_query("select gr_id, gr_subject from {$g5['group_table']} order by gr_order", false);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$html_gr[$i][0] = $row['gr_id'];
	$html_gr[$i][1] = $row['gr_subject'];
}

//Html List
$html_list = apms_file_list('data/apms/page', 'php');

$result = sql_query("select * from {$g5['apms_page']} where as_html = '1' order by gr_id desc, id ");
$row_cnt = @mysql_num_rows($result);

?>

<div class="local_ov01 local_ov">
	사이트 소개, 회원약관, 개인정보보호방침, 이용안내 등
</div>


<form id="htmlgrouplistform" name="htmlgrouplistform" method="post">
<input type="hidden" name="ap" value="npage">
<input type="hidden" name="mode" value="npage">
<input type="hidden" name="opt" value="edit">
<div class="tbl_head01 tbl_wrap">
	<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
		<li>일반문서를 등록하기 전에 먼저 사용할 php 파일을 <b>파일등록</b> 버튼을 클릭한 후 등록하셔야 문서파일목록에 나타납니다.</li>
		<li>HTML ID($hid)값으로 체크를 하며, 내용관리 ID 입력시 내용관리에서 해당 ID로 등록한 컨텐츠가 출력됩니다.</li>
		<li><b>메뉴등록시 선택한 보드그룹의 서브메뉴로 출력되며, 등록 후 메뉴설정 > 그룹/분류 > 서브메뉴설정에서 메뉴보임을 체크하셔야 화면에 출력</b>됩니다.</b></li>
	</ul>
	<table>
	<thead>
	<th width=40><input type="checkbox" class="htmlgroup_chk"></th>
	<th width=100>메뉴등록</th>
	<th width=120>HTML ID</th>
	<th width=100>문서파일</th>
	<th width=120>내용관리 ID</th>
	<th width=180>메뉴명</th>
	<th width=250>타이틀</th>
	<th>설명글</th>
	<th width=80>접근레벨</th>
	<th width=100>접근등급</th>
	<th width=60>와이드</th>
	<th width=60>파트너</th>
	<th width=40>보기</th>
	</tr>
	</thead>
	<tbody>
	<?php for ($z=0; $row=sql_fetch_array($result); $z++) {	
			$bg = ($z%2 == 0) ? '' : ' bgcolor="#fafafa"';				
	?>
		<tr<?php echo $bg; ?>>
		<td align="center">
			<input type="checkbox" name="chk_id[]" value="<?php echo $z;?>">
			<input type="hidden" name="id[<?php echo $z;?>]" value="<?php echo $row['id'];?>">
		</td>
		<td align="center">
			<?php echo apms_select_arr($html_gr, 'html_gr_id['.$z.']', $row['gr_id'], '미등록', 100); ?>
		</td>
		<td align="center">
			<nobr><a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($row['html_id']);?>" target="_blank"><?php echo $row['html_id'];?></a></nobr>
		</td>
		<td>
			<?php echo apms_select_list($html_list, 'as_file['.$z.']', $row['as_file'], '미지정', 100);?>
		</td>
		<td>
			<input type="text" name="co_id[<?php echo $z;?>]" size="15" value="<?php echo $row['co_id'];?>" placeholder="내용관리 ID" class="frm_input">
		</td>
		<td>
			<input type="text" name="bo_subject[<?php echo $z;?>]" size="23" value="<?php echo $row['bo_subject'];?>" placeholder="메뉴명" class="frm_input">
		</td>
		<td>
			<input type="text" name="as_title[<?php echo $z;?>]" size="25" value="<?php echo $row['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;">
		</td>
		<td>
			<input type="text" name="as_desc[<?php echo $z;?>]" size="25" value="<?php echo $row['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;">
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
			<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($row['as_wide'] ? " checked" : ""); ?>>
		</td>
		<td align="center">
			<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($row['as_partner'] ? " checked" : ""); ?>>
		</td>
		<td align="center">
			<?php if($row['as_file']) { ?>
				<a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($row['html_id']);?>" target="_blank"><i class="fa fa-file-text-o fa-lg"></i></a>
			<?php } else { ?>
				-
			<?php } ?>
		</td>
		</tr>
	<?php } ?>
	<?php
    if (!$z)
        echo '<tr><td colspan="13" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="btn_list01 btn_list" style="text-align:center;">
	<button type="button" onclick="chk_del('htmlgrouplistform', '자료를');">선택삭제</button>
	<a href="./apms.file.php?type=page" class="win_memo">파일등록</a>
	<a href="<?php echo G5_BBS_URL;?>/icon.php" class="win_memo">아이콘 검색</a>
	<input type="submit" value="일괄저장">
</div>

</form>

<script>
	function chk_del(fid, msg) {
		var frm = document.getElementById(fid); 
		var cnt = $('#' + fid + ' input:checkbox[name="chk_id[]"]:checked').length;
		if (!cnt) {
			alert("삭제할 " + msg + " 하나 이상 선택해 주세요.");
			return false;
		}

		if (!confirm("선택한 " + msg + " 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		frm.opt.value = 'del';
		frm.submit();
		return true;
	}

	$(function(){
		$('.htmlgroup_chk').click(function(){
			$('#htmlgrouplistform input[name="chk_id[]"]').attr('checked', this.checked);
		});
	});
</script>

<br>
<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
	<li><b>문서등록하기</b> - 파일등록 버튼을 클릭하셔서 먼저 사용할 php 파일을 등록해 주세요.</li>
</ul>
<form id="htmlform" name="htmlform" method="post">
<input type="hidden" name="ap" value="npage">
<input type="hidden" name="mode" value="npage">
<input type="hidden" name="opt" value="insert">
<div class="tbl_head01 tbl_wrap">
	<table>
	<thead>
	<tr>
	<th width=100>메뉴등록</th>
	<th width=120>HTML ID</th>
	<th width=100>문서파일</th>
	<th width=120>내용관리 ID</th>
	<th width=180>메뉴명</th>
	<th width=250>타이틀</th>
	<th>설명글</th>
	<th width=60>와이드</th>
	<th width=60>파트너</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td align="center"><?php echo apms_select_arr($html_gr, 'html_gr_id','', '미등록', 100); ?></td>
	<td><input type="text" name="html_id" size="15" value="" class="frm_input"></td>
	<td><?php echo apms_select_list($html_list, 'as_file','', '미지정', 100);?></td>
	<td><input type="text" name="co_id" size="15" value="" class="frm_input"></td>
	<td><input type="text" name="bo_subject" size="23" value="" class="frm_input"></td>
	<td><input type="text" name="as_title" size="40" value="" class="frm_input" style="width:98%;"></td>
	<td><input type="text" name="as_desc" size="40" value="" class="frm_input" style="width:98%;"></td>
	<td align="center"><input type="checkbox" name="as_wide" value="1"></td>
	<td align="center"><input type="checkbox" name="as_partner" value="1"></td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_list01 btn_list" style="text-align:center;">
	<a href="./apms.file.php?type=page" class="win_memo">파일등록</a>
	<input type="submit" value="등록하기">
</div>
</form>