<?php
include_once('./_common.php');

if(!$type) exit;

switch($type) {
	case 'main'	: $filepath = G5_DATA_PATH.'/apms/main/'; $title = '메인'; break;
	case 'page'	: $filepath = G5_DATA_PATH.'/apms/page/'; $title = '문서'; break;
	default		: exit; break;
}

if($mode) {
	if($mode == "del") {
		chmod($filepath.$filename, G5_FILE_PERMISSION);
		@unlink($filepath.$filename);

	} else {

		if(!$_FILES['upload_file']['tmp_name']) alert("파일을 등록해 주세요.");

		if(is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
			$dest_file = $filepath.$_FILES['upload_file']['name'];

			//있으면 삭제합니다.
			chmod($dest_file, G5_FILE_PERMISSION);
			@unlink($dest_file);

			// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest_file) or die($_FILES['upload_file']['error'][$i]);

			// 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, G5_FILE_PERMISSION);
		}
	}

	goto_url('./apms.file.php?type='.$type);

}

include_once(G5_PATH.'/head.sub.php');

$file_list = apms_file_list('data/apms/'.$type, '');
$file_cnt = count($file_list);

?>

<script src="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.js"></script>

<div id="wrapper" style="min-width:300px !important;">
    <div id="container">

		<h1 style="min-width:300px !important;"><?php echo $title;?>파일</h1>

		<form id="fileForm" name="fileForm" method="post" enctype="multipart/form-data" class="local_sch01 local_sch" style="min-width:300px !important;">
		<input type="hidden" name="ap" value="file">
		<input type="hidden" name="mode" value="file">
		<input type="hidden" name="type" value="<?php echo $type;?>">
		<input type="file" name="upload_file" size="30" value="" class="frm_input">
		<input type="submit" value="등록하기" class="btn_submit">
		</form>
		<?php if($file_cnt) { ?>
			<div class="tbl_head01 tbl_wrap">
				<table>
				<tr>
				<th>파일명</th>
				<th width=60>다운</th>
				<th width=60>삭제</th>
				</tr>
				<?php for($i = 0; $i < $file_cnt; $i++) { ?>
					<tr>
					<td><?php echo $file_list[$i];?></td>
					<td align="center"><a href="./apms.down.php?type=<?php echo $type;?>&filename=<?php echo urlencode($file_list[$i]);?>">다운</a></td>
					<td align="center"><a href="./apms.file.php?mode=del&type=<?php echo $type;?>&filename=<?php echo urlencode($file_list[$i]);?>" class="apms-del">삭제</a></td>
					</tr>
				<?php } ?>
				</table>
			</div>	
		<?php } ?>
	</div>
</div>
<div class="btn_list01 btn_list" style="text-align:center;">
	<button type="button" onclick="self.close();">창닫기</button>
</div>
<br>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>