<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

if($wset['cache'] > 0) { // 캐시적용시
	echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
} else {
	include($widget_path.'/widget.rows.php');
}

?>

<?php if($setup_href) { ?>
	<p class="text-center btn-wset" style="margin-top:-15px;">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted font-12 en"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
		<?php if($is_admin == 'super') { ?>
			&nbsp;
			<a href="<?php echo G5_ADMIN_URL; ?>/poll_list.php">
				<span class="text-muted font-12 en"><i class="fa fa-bar-chart"></i> 투표관리</span>				
			</a>
		<?php } ?>
	</p>
<?php } ?>

<script>
function fpoll_submit(f, lvl) {
	var mb_lvl = <?php echo ($member['mb_level']) ? $member['mb_level'] : 1;?>;

	if(mb_lvl < lvl) {
        alert('권한 ' + lvl + ' 이상의 회원만 투표에 참여하실 수 있습니다.'); 
		return false;
	} else {
		var chk = false;
		for (i=0; i<f.gb_poll.length;i ++) {
			if (f.gb_poll[i].checked == true) {
				chk = f.gb_poll[i].value;
				break;
			}
		}

		if (!chk) {
			alert("투표하실 설문항목을 선택하세요");
			return false;
		}

		var new_win = window.open("about:blank", "win_poll", "width=616,height=500,scrollbars=yes,resizable=yes"); 
		f.target = "win_poll"; 

		return true;
	}

	return false;
}

function poll_result(url, lvl) {
	var mb_lvl = <?php echo ($member['mb_level']) ? $member['mb_level'] : 1;?>;

	if(mb_lvl < lvl) {
		alert('권한 ' + lvl + ' 이상의 회원만 결과를 보실 수 있습니다.'); 
	} else {
		win_poll(url);
	}
	return false;
}
</script>
