<?php
include_once('./_common.php');
if(!defined('G5_IS_ADMIN')) {
	define('G5_IS_ADMIN', true);
}
$emo = array();
$handle = opendir(G5_PATH.'/img/emoticon');
while ($file = readdir($handle)) {
	if(preg_match("/\.(jpg|jpeg|gif|png)$/i", $file)) {
		$emo[] = $file;
	}
}
closedir($handle);
sort($emo);

$emoticon = array();
for($i=0; $i < count($emo); $i++) {
	$emoticon[$i]['name'] = $emo[$i];
	$emoticon[$i]['url'] = G5_URL.'/img/emoticon/'.$emo[$i];
}

$fid = ($fid) ? $fid : 'wr_content';

$g5['title'] = '이모티콘';
include_once(G5_PATH.'/head.sub.php');
?>
<style>
body { margin:0; padding:0 }
.emoticon-box { text-align:center; margin:10px; }
.emoticon-img { width:50px; height:50px; margin:10px 10px 0px 0px; cursor:pointer; border:1px solid #ddd; }
</style>
<div class="emoticon-box">
	<?php for($i=0; $i < count($emoticon); $i++) { ?>
		<img src="<?php echo $emoticon[$i]['url'];?>" onclick="emoticon_insert('<?php echo $emoticon[$i]['name'];?>');" class="emoticon-img" alt="">
	<?php } ?>
</div>

<br>

<div class="btn_confirm01 btn_confirm">
	<button onclick="window.close();" type="button">닫기</button>
</div>

<br>

<script> 
	function emoticon_insert(emo){
		img = "{이모티콘:" + emo + ":50}";
		<?php if($fid == 'wr_content') { ?>
			opener.document.getElementById("<?php echo $fid;?>").value += img;
		<?php } else { ?>
			opener.document.getElementById("<?php echo $fid;?>").value = img;
		<?php } ?>
		<?php if($sid) { ?>
			opener.document.getElementById("<?php echo $sid;?>").innerHTML = "<img src=\"<?php echo G5_URL;?>/img/emoticon/" + emo + "\">";
		<?php } ?>
		self.close();
	}
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>