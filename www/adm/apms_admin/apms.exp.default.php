<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

if($act == 'ok') {
	//경험치
	if($chk_default) {
		$result = sql_query("select mb_id, mb_point from {$g5['member_table']} ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			//모든 포인트 내역 삭제
	        sql_query(" delete from {$g5['point_table']} where mb_id = '{$row['mb_id']}' ", false);

			if($chk_default == "2") {
				//경험치와 포인트 모두 초기화
				sql_query(" update {$g5['member_table']} set as_level = '1', as_exp = '0', mb_point = '0' where mb_id = '{$row['mb_id']}' ", false);
			} else {
				//경험치만 초기화
				sql_query(" update {$g5['member_table']} set as_level = '1', as_exp = '0' where mb_id = '{$row['mb_id']}' ", false);

				//기존 보유포인트 등록
				if($row['mb_point'] > 0) insert_point($row['mb_id'], $row['mb_point'], $content='경험치 초기화로 보유 포인트 이전');
			}

		}
	}

?>	
    <script type='text/javascript'> 
		alert('경험치 초기화를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return default_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 회원 경험치 및 포인트 초기화</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li>한번 실행하시면 복구가 안되니 꼭 DB 백업후 실행해 주세요.</li>
				<li>경험치 초기화는 회원의 현재 보유한 포인트만큼 새로운 기록을 남기고 기존 포인트 기록은 전부 삭제하기 때문에 포인트 내역에는 기존 보유 포인트 내역 1건만 남습니다.</li>
				<li>포인트 초기화는 회원의 모든 포인트 기록과 경험치 기록을 삭제하기 때문에 포인트 내역이 전혀 남지않습니다.</li>
			</ul>
			<br/>
			<p align="center">
				<b>
				<label><input type="radio" name="chk_default" value="1"> 경험치만 초기화</label>
				&nbsp; &nbsp;
				<label><input type="radio" name="chk_default" value="2"> 경험치와 포인트 모두 초기화</label>
				</b>
			</p>
			<br/>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function default_submit(f) {
			var $radios = $('#defaultform input:radio[name=chk_default]');
			if($radios.is(':checked') == false) {
				alert("실행할 항목을 선택해 주세요.");
				return false;
			}

			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>