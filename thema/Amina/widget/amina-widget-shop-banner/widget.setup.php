<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

// 초기값
if(!$wset['thumb_w']) $wset['thumb_w'] = 400;
if(!$wset['thumb_h']) $wset['thumb_h'] = 160;
if(!$wset['garo']) $wset['garo'] = 4; // Grid Col 값
if(!$wmset['garo']) $wmset['garo'] = 4;
if(!$wset['sero']) $wset['sero'] = 1;
if(!$wmset['sero']) $wmset['sero'] = 1;

?>

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
		<td align="center">타이틀</td>
		<td>
			<input type="text" name="wset[title]" value="<?php echo $wset['title']; ?>" size="40" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">링크주소</td>
		<td>
			<?php echo help('설정에 따라 보드아이디, 분류코드, URL 직접 입력');?>
			<input type="text" name="wset[thid]" value="<?php echo $wset['thid']; ?>" size="40" class="frm_input">
			&nbsp;
			<select name="wset[tlink]">
				<option value="board"<?php echo get_selected('board', $wset['tlink']); ?>>보드아이디</option>
				<option value="shop"<?php echo get_selected('shop', $wset['tlink']); ?>>분류코드</option>
				<option value="link"<?php echo get_selected('link', $wset['tlink']); ?>>직접입력</option>
				<option value=""<?php echo get_selected('', $wset['tlink']); ?>>링크없음</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">슬라이더</td>
		<td>
			<select name="wset[slide]">
				<option value="1"<?php echo get_selected('1', $wset['slide']); ?>>1</option>
				<option value="2"<?php echo get_selected('2', $wset['slide']); ?>>2</option>
				<option value="3"<?php echo get_selected('3', $wset['slide']); ?>>3</option>
				<option value="4"<?php echo get_selected('4', $wset['slide']); ?>>4</option>
				<option value="5"<?php echo get_selected('5', $wset['slide']); ?>>5</option>
				<option value="6"<?php echo get_selected('6', $wset['slide']); ?>>6</option>
				<option value="7"<?php echo get_selected('7', $wset['slide']); ?>>7</option>
				<option value="8"<?php echo get_selected('8', $wset['slide']); ?>>8</option>
				<option value="9"<?php echo get_selected('9', $wset['slide']); ?>>9</option>
			</select>
			개 PC 출력
			&nbsp;
			<select name="wmset[slide]">
				<option value="1"<?php echo get_selected('1', $wmset['slide']); ?>>1</option>
				<option value="2"<?php echo get_selected('2', $wmset['slide']); ?>>2</option>
				<option value="3"<?php echo get_selected('3', $wmset['slide']); ?>>3</option>
				<option value="4"<?php echo get_selected('4', $wmset['slide']); ?>>4</option>
				<option value="5"<?php echo get_selected('5', $wmset['slide']); ?>>5</option>
				<option value="6"<?php echo get_selected('6', $wmset['slide']); ?>>6</option>
				<option value="7"<?php echo get_selected('7', $wmset['slide']); ?>>7</option>
				<option value="8"<?php echo get_selected('8', $wmset['slide']); ?>>8</option>
				<option value="9"<?php echo get_selected('9', $wmset['slide']); ?>>9</option>
			</select>
			개 모바일 출력
		</td>
	</tr>
	<tr>
		<td align="center">세로수</td>
		<td>
			<input type="text" name="wset[sero]" value="<?php echo $wset['sero']; ?>" class="frm_input" size="3"> 개 PC 출력
			&nbsp;
			<input type="text" name="wmset[sero]" value="<?php echo $wmset['sero']; ?>" class="frm_input" size="3"> 개 모바일 출력
		</td>
	</tr>
	<tr>
		<td align="center">가로수</td>
		<td>
			<select name="wset[garo]">
				<option value="3"<?php echo get_selected('3', $wset['garo']); ?>>4</option>
				<option value="4"<?php echo get_selected('4', $wset['garo']); ?>>3</option>
				<option value="6"<?php echo get_selected('6', $wset['garo']); ?>>2</option>
				<option value="12"<?php echo get_selected('12', $wset['garo']); ?>>1</option>
				<option value="2"<?php echo get_selected('2', $wset['garo']); ?>>6</option>
				<option value="1"<?php echo get_selected('1', $wset['garo']); ?>>12</option>
			</select>
			개 PC 출력
			&nbsp;
			<select name="wmset[garo]">
				<option value="3"<?php echo get_selected('3', $wmset['garo']); ?>>4</option>
				<option value="4"<?php echo get_selected('4', $wmset['garo']); ?>>3</option>
				<option value="6"<?php echo get_selected('6', $wmset['garo']); ?>>2</option>
				<option value="12"<?php echo get_selected('12', $wmset['garo']); ?>>1</option>
				<option value="2"<?php echo get_selected('2', $wmset['garo']); ?>>6</option>
				<option value="1"<?php echo get_selected('1', $wmset['garo']); ?>>12</option>
			</select>
			개 모바일 출력
		</td>
	</tr>
	<tr>
		<td align="center">가로최소</td>
		<td>
			<select name="wset[xs]">
				<option value="12"<?php echo get_selected('12', $wset['xs']); ?>>1</option>
				<option value="6"<?php echo get_selected('6', $wset['xs']); ?>>2</option>
				<option value="4"<?php echo get_selected('4', $wset['xs']); ?>>3</option>
				<option value="3"<?php echo get_selected('3', $wset['xs']); ?>>4</option>
				<option value="2"<?php echo get_selected('2', $wset['xs']); ?>>6</option>
				<option value="1"<?php echo get_selected('1', $wset['xs']); ?>>12</option>
			</select>
			개 PC 배치
			&nbsp;
			<select name="wmset[xs]">
				<option value="12"<?php echo get_selected('12', $wmset['xs']); ?>>1</option>
				<option value="6"<?php echo get_selected('6', $wmset['xs']); ?>>2</option>
				<option value="4"<?php echo get_selected('4', $wmset['xs']); ?>>3</option>
				<option value="3"<?php echo get_selected('3', $wmset['xs']); ?>>4</option>
				<option value="2"<?php echo get_selected('2', $wmset['xs']); ?>>6</option>
				<option value="1"<?php echo get_selected('1', $wmset['xs']); ?>>12</option>
			</select>
			개 모바일 최소 가로배치
		</td>
	</tr>
	<tr>
		<td align="center">썸네일</td>
		<td>
			<input type="text" required name="wset[thumb_w]" value="<?php echo $wset['thumb_w']; ?>" class="frm_input" size="3">
			x
			<input type="text" required name="wset[thumb_h]" value="<?php echo $wset['thumb_h']; ?>" class="frm_input" size="3">
			px - 썸네일 비율로 이미지 출력
		</td>
	</tr>
	<tr>
		<td align="center">효과설정</td>
		<td>
			<?php echo help('효과간격은 5000ms가 기본값이며, 0 입력시 효과가 작동안함');?>
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
		<td align="center">추출배너</td>
		<td>
			<select name="wset[loc]">
				<option value=""<?php echo get_selected('', $wset['loc']); ?>>전체 배너</option>
				<option value="왼쪽"<?php echo get_selected('왼쪽', $wset['loc']); ?>>왼쪽 배너</option>
				<option value="메인"<?php echo get_selected('메인', $wset['loc']); ?>>메인 배너</option>
			</select>
			를 추출합니다.
		</td>
	</tr>
	<tr>
		<td align="center">배너지정</td>
		<td>
			<?php echo help('배너아이디를 콤마(,)로 구분해서 복수 등록 가능, 미등록시 전체에서 추출');?>
			<input type="text" name="wset[bn_list]" value="<?php echo $wset['bn_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[except]" value="1"<?php echo ($wset['except']) ? ' checked' : '';?>> 제외하기</label>
		</td>
	</tr>
	<tr>
		<td align="center">정렬설정</td>
		<td>
			<select name="wset[sort]">
				<option value=""<?php echo get_selected('', $wset['sort']); ?>>최근순</option>
				<option value="asc"<?php echo get_selected('asc', $wset['sort']); ?>>등록순</option>
				<option value="rdm"<?php echo get_selected('rdm', $wset['sort']); ?>>무작위(랜덤)</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">캐시사용</td>
		<td>
			<input type="text" name="wset[cache]" value="<?php echo $wset['cache']; ?>" class="frm_input" size="4"> 초 간격으로 캐싱 - 본인자료 추출설정시 캐시사용하면 안됩니다.
		</td>
	</tr>
	</tbody>
	</table>
</div>