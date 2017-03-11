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
		<li>위젯명 : Title Carousel v1.0 by AMINA (http://amina.co.kr)</li>
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
		<td align="center">효과설정</td>
		<td>
			<?php echo help('효과간격은 5000ms가 기본값이며, false 입력시 효과가 작동안함');?>
			<select name="wset[effect]">
				<option value="slide"<?php echo get_selected('slide', $wset['effect']); ?>>슬라이드</option>
				<option value="fade"<?php echo get_selected('fade', $wset['effect']); ?>>페이드</option>
				<option value="up"<?php echo get_selected('up', $wset['effect']); ?>>버티컬</option>
				<option value=""<?php echo get_selected('', $wset['effect']); ?>>효과없음</option>
			</select>
			&nbsp;
			<input type="text" name="wset[interval]" value="<?php echo $wset['interval']; ?>" class="frm_input" size="5"> 밀리초(ms) 간격
		</td>
	</tr>
	<tr>
		<td align="center">첫번째배경</td>
		<td>
			<input type="text" name="wset[bg1]" value="<?php echo ($wset['bg1']);?>" id="bg1" size="46" class="bg frm_input" readonly> 
			<a href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=bg1" class="btn_frmline win_scrap">이미지선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">두번째배경</td>
		<td>
			<input type="text" name="wset[bg2]" value="<?php echo ($wset['bg2']);?>" id="bg2" size="46" class="bg frm_input" readonly> 
			<a href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=bg2" class="btn_frmline win_scrap">이미지선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">동영상주소</td>
		<td>
			<?php echo help('유튜브, 비메오 등의 공유 주소 등록');?>
			<input type="text" name="wset[video]" value="<?php echo $wset['video']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[auto]" value="1"<?php echo ($wset['auto']) ? ' checked' : '';?>> 자동실행</label>
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