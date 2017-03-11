<?php
define('G5_IS_ADMIN', true);
include_once('./_common.php');

if (($mode == 'del' || $mode == 'up') && !$is_designer) {
    alert("관리자만 가능합니다.");
}

switch($type) {
	case 'body'		: $filedir = '/apms/background/body/'; $title = 'Body Background';break;
	case 'title'	: $filedir = '/apms/background/title/'; $title = 'Title Background'; break;
	case 'banner'	: $filedir = '/apms/background/banner/'; $title = 'Banner Background'; break;
	case 'page'		: $filedir = '/apms/background/page/'; $title = 'Page Title Background'; break;
	default			: $filedir = '/apms/background/'; $title = 'Background Image'; break;
}

if($mode == "del") {
	@unlink(G5_DATA_PATH.$filedir.$filename);
	if($type == 'body') {
		@unlink(G5_DATA_PATH.$filedir.$filecss.'.css');
	}

} else if ($mode == "up") {
	if(!$_FILES['upload_file']['tmp_name']) alert("파일을 등록해 주세요.");

	if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
		$dest_file = G5_DATA_PATH.$filedir.$_FILES['upload_file']['name'];

		//있으면 삭제합니다.
		@unlink($dest_file);

		// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
		move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest_file) or die($_FILES['upload_file']['error'][$i]);

		// 올라간 파일의 퍼미션을 변경합니다.
		chmod($dest_file, G5_FILE_PERMISSION);
	}

	goto_url(G5_BBS_URL.'/switcher.php?type='.$type.'&fid='.$fid.'&cid='.$cid);
}

include_once(G5_PATH.'/head.sub.php');
?>
<style>
	body { margin:0 0 30px; padding:0; font:normal 12px dotum; -webkit-text-size-adjust:100%; background:#fafafa;}
	a, a:hover { text-decoration:none; }
	h2 { padding:15px; text-align:center; color:#fff; background:#000; font-size:18px; font-family:tahoma; font-weight:bold; margin:0; }
	ul { padding:0px; margin:15px; list-style:none; }
	ul li { float:left; padding:10px; margin:0px; position:relative; }
	ul li img { display:block; cursor:pointer; border:4px solid #efefef; width:80px; height:80px; }
	ul li img:hover { border:4px solid #000; }
	p.del { color:#ccc !important; margin:0px; padding:5px 0px 0px; text-align:center; }
	p.del a { color:#ccc !important; }
	p.del a:hover { color:orangered !important; }
	.uploader { background:#eee; text-align:center; padding:15px; }
	.upload-css { position:absolute; top:45px; line-height:20px; font-size:10px; font-family:verdana; text-align:center; background:#000; font-weight:bold; color:#fff; width:88px; }
	.bg-none { display:block; width:80px; height:80px; line-height:80px; text-align:center; cursor:pointer; background:#ddd; color:#fff; font-size:60px; border:4px solid #efefef; }
	.left { float:left; }
</style>
<h2><?php echo $title;?></h2>

<form id="switcherForm" name="switcherForm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="type" value="<?php echo $type;?>">
	<input type="hidden" name="fid" value="<?php echo $fid;?>">
	<input type="hidden" name="cid" value="<?php echo $cid;?>">
	<input type="hidden" name="mode" value="up">
	<div class="uploader">
		<input type="file" name="upload_file" value="">
		<button type="submit" class="btn_frmline">등록하기</button>
	</div>
</form>

<ul class="switcher-wrap">
	<li>
		<span class="switcher-select" title="none"><b class="bg-none"><i class="fa fa-times"></i></b></span>
		<p class="del"></p>
	</li>
	<?php //Background
		$srow = thema_switcher('file', G5_DATA_PATH.$filedir, '', "jpg|png|gif");
		for($i=0; $i < count($srow); $i++) {
			$filename = ($type == 'body') ? $srow[$i]['value'].'.css' : $srow[$i]['name'];
	?>
	<li>
		<?php if($type == 'body') { ?>
			<?php if (!is_file(G5_DATA_PATH.$filedir.$filename)) { ?>
				<div class="upload-css">Upload CSS</div>
			<?php } ?>
		<?php } ?>
		<img src="<?php echo G5_DATA_URL.$filedir.$srow[$i]['name'];?>" alt="<?php echo $srow[$i]['name'];?>" class="switcher-select" title="<?php echo G5_DATA_URL.$filedir.$filename;?>">
		<p class="del">
			<a href="<?php echo G5_BBS_URL;?>/switcher.php?type=<?php echo $type;?>&amp;mode=del&amp;fid=<?php echo $fid;?>&amp;cid=<?php echo $cid;?>&amp;filename=<?php echo $srow[$i]['name'];?>&amp;filecss=<?php echo $srow[$i]['value'];?>" title="삭제" class="del-file">
				<i class="fa fa-times"></i>
			</a>
		</p>
	</li>
	<?php } ?>
</ul>
<div style="clear:both;"></div>
<p align="center">
	<button type="button" onclick="self.close();" class="btn_frmline">창닫기</button>
</p>
<script>
	jQuery(document).ready(function($) {
		$('.del-file').click(function() {
			if(confirm("삭제하시겠습니까?")) {
				location.href = this.href;
			}
			return false;
		});

		$('.switcher-select').click(function() {
			opener.switcher_background('<?php echo $type;?>', '<?php echo $fid;?>', '<?php echo $cid;?>', this.title);
			return false;
		});
	});
</script>
<?php include_once(G5_PATH."/tail.sub.php"); ?>