<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css">', 0);

?>
<div class="emoticon-box">
	<?php for($i=0; $i < count($emoticon); $i++) { ?>
		<img src="<?php echo $emoticon[$i]['url'];?>" onclick="emoticon_insert('<?php echo $emoticon[$i]['name'];?>');" class="emoticon-img" alt="">
	<?php } ?>
</div>

<script> 
	function emoticon_insert(emo){
		img = "{이모티콘:" + emo + ":50}";
		opener.document.getElementById("wr_content").value += img;
		self.close();
	}
</script>