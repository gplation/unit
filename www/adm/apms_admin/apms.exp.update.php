<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

if($act == 'ok') {
	// 자료가 많을 경우 대비 설정변경
	set_time_limit ( 0 );
	ini_set('memory_limit', '512M');

	$result = sql_query("select mb_id from {$g5['member_table']}");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		check_xp($row['mb_id']); // 경험치 레벨 업데이트
	}

	sql_free_result($result);

	// 레벨이 변경되거나, 레벨이 1이 아닌 회원만 추출
	$result = sql_query("select mb_id, as_level from {$g5['member_table']} where 1 and (as_msg > '0' or as_level > '1')");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		change_xp($row['mb_id'], $row['as_level']); // 변경된 레벨 반영
	}

?>	
    <script type='text/javascript'> 
		alert('경험치 및 레벨 업데이트를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 회원 경험치 및 레벨 업데이트</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li>경험치룰 변경시 실행해 주시면, 모든 회원의 경험치와 레벨이 변경된 룰로 재산정됩니다.</li>
				<li>수정된 회원레벨이 모든 회원정보와 전체 게시물에 자동으로 반영되므로 회원 및 게시물수에 따라 시간이 걸릴 수 있습니다.</li>
			</ul>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function update_submit(f) {
			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>