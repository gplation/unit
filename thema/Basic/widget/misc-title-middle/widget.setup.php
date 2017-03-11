<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

?>
<script>
$(function(){
	$.event.special.inputchange = {
		setup: function() {
			var self = this, val;
			$.data(this, 'timer', window.setInterval(function() {
				val = self.value;
				if ( $.data( self, 'cache') != val ) {
					$.data( self, 'cache', val );
					$( self ).trigger( 'inputchange' );
				}
			}, 20));
		},
		teardown: function() {
			window.clearInterval( $.data(this, 'timer') );
		},
		add: function() {
			$.data(this, 'cache', this.value);
		}
	};

	$('.bg').on('inputchange', function() {
		$("#" + this.id, opener.document).attr("style", "background-image:url('" + this.value + "')"); 
	});
});
</script>
<div class="local_desc01 local_desc">
	<ul>
		<li>위젯명 : Middle Title Carousel v1.0 by AMINA (http://amina.co.kr)</li>
		<li>캐러셀 타이틀 기본 위젯</li>
	</ul>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">배경이미지</td>
		<td>
			<input type="text" name="wset[bg]" value="<?php echo ($wset['bg']);?>" id="mbg" size="46" class="bg frm_input" readonly> 
			<a href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=mbg" class="btn_frmline win_scrap">이미지선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">글자색</td>
		<td>
			<select name="wset[color]">
				<option value="white"<?php echo get_selected('white', $wset['color']); ?>>흰색</option>
				<option value="black"<?php echo get_selected('black', $wset['color']); ?>>블랙</option>
				<option value="red"<?php echo get_selected('red', $wset['color']); ?>>레드</option>
				<option value="blue"<?php echo get_selected('blue', $wset['color']); ?>>블루</option>
				<option value="green"<?php echo get_selected('green', $wset['color']); ?>>그린</option>
				<option value="orange"<?php echo get_selected('orange', $wset['color']); ?>>오렌지</option>
				<option value="yellow"<?php echo get_selected('yellow', $wset['color']); ?>>옐로우</option>
				<option value="violet"<?php echo get_selected('violet', $wset['color']); ?>>바이올렛</option>
			</select>
			색
		</td>
	</tr>
	<tr>
		<td align="center">하단설정</td>
		<td>
			<select name="wset[banner]">
				<option value="color"<?php echo get_selected('color', $wset['banner']); ?>>기본</option>
				<option value="black"<?php echo get_selected('black', $wset['banner']); ?>>블랙</option>
				<option value="red"<?php echo get_selected('red', $wset['banner']); ?>>레드</option>
				<option value="blue"<?php echo get_selected('blue', $wset['banner']); ?>>블루</option>
				<option value="green"<?php echo get_selected('green', $wset['banner']); ?>>그린</option>
				<option value="orange"<?php echo get_selected('orange', $wset['banner']); ?>>오렌지</option>
				<option value="yellow"<?php echo get_selected('yellow', $wset['banner']); ?>>옐로우</option>
				<option value="violet"<?php echo get_selected('violet', $wset['banner']); ?>>바이올렛</option>
			</select>
			배경색
		</td>
	</tr>
	</tbody>
	</table>
</div>