<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

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
		<td align="center">추출글수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="3"> 개 PC 출력
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="3"> 개 모바일 출력
		</td>
	</tr>
	<tr>
		<td align="center">추출유형</td>
		<td>
			<select name="wset[comment]">
				<option value=""<?php echo get_selected('', $wset['comment']); ?>>글</option>
				<option value="1"<?php echo get_selected('1', $wset['comment']); ?>>댓글</option>
			</select>
			추출
			&nbsp
			<select name="wset[main]">
				<option value=""<?php echo get_selected('', $wset['main']); ?>>모든글</option>
				<option value="1"<?php echo get_selected('1', $wset['main']); ?>>메인글</option>
			</select>
			추출
		</td>
	</tr>
	<tr>
		<td align="center">추출보드</td>
		<td>
			<?php echo help('보드아이디를 콤마(,)로 구분해서 복수 등록 가능, 미입력시 전체 게시판 적용');?>
			<input type="text" name="wset[bo_list]" value="<?php echo $wset['bo_list']; ?>" size="60" class="frm_input">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center">추출그룹</td>
		<td>
			<?php echo help('그룹아이디를 콤마(,)로 구분해서 복수 등록 가능, 설정시 추출보드는 적용안됨');?>
			<input type="text" name="wset[gr_list]" value="<?php echo $wset['gr_list']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">추출분류</td>
		<td>
			<?php echo help('분류를 콤마(,)로 구분해서 복수 등록 가능, 단일보드 추출시에만 적용됨');?>
			<input type="text" name="wset[ca_list]" value="<?php echo $wset['ca_list']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">제외설정</td>
		<td>
			<label><input type="checkbox" name="wset[except]" value="1"<?php echo ($wset['except']) ? ' checked' : '';?>> 지정한 보드/그룹 제외</label>
			&nbsp;
			<label><input type="checkbox" name="wset[ex_ca]" value="1"<?php echo ($wset['ex_ca']) ? ' checked' : '';?>> 지정한 분류제외</label>
		</td>
	</tr>
	<tr>
		<td align="center">글아이콘</td>
		<td>
			<input type="text" name="wset[icon]" id="fcon" value="<?php echo ($wset['icon']);?>" size="30" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/icon.php?fid=fcon" class="btn_frmline win_scrap">아이콘 선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">새글설정</td>
		<td>
			<input type="text" name="wset[newtime]" value="<?php echo ($wset['newtime']);?>" size="3" class="frm_input"> 시간 이내 등록 글
			&nbsp;
			새글아이콘색
			<select name="wset[new]">
				<option value="red"<?php echo get_selected('red', $wset['new']); ?>>레드</option>
				<option value="blue"<?php echo get_selected('blue', $wset['new']); ?>>블루</option>
				<option value="green"<?php echo get_selected('green', $wset['new']); ?>>그린</option>
				<option value="orange"<?php echo get_selected('orange', $wset['new']); ?>>오렌지</option>
				<option value="yellow"<?php echo get_selected('yellow', $wset['new']); ?>>옐로우</option>
				<option value="violet"<?php echo get_selected('violet', $wset['new']); ?>>바이올렛</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">정렬설정</td>
		<td>
			<select name="wset[sort]">
				<option value=""<?php echo get_selected('', $wset['sort']); ?>>최근순</option>
				<option value="asc"<?php echo get_selected('asc', $wset['sort']); ?>>등록순</option>
				<option value="date"<?php echo get_selected('date', $wset['sort']); ?>>날짜순</option>
				<option value="hit"<?php echo get_selected('hit', $wset['sort']); ?>>조회순</option>
				<option value="comment"<?php echo get_selected('comment', $wset['sort']); ?>>댓글순</option>
				<option value="good"<?php echo get_selected('good', $wset['sort']); ?>>추천순</option>
				<option value="nogood"<?php echo get_selected('nogood', $wset['sort']); ?>>비추천순</option>
				<option value="like"<?php echo get_selected('like', $wset['sort']); ?>>추천-비추천순</option>
				<option value="download"<?php echo get_selected('download', $wset['sort']); ?>>다운로드순</option>
				<option value="link"<?php echo get_selected('link', $wset['sort']); ?>>링크방문순</option>
				<option value="poll"<?php echo get_selected('poll', $wset['sort']); ?>>설문참여순</option>
				<option value="lucky"<?php echo get_selected('lucky', $wset['sort']); ?>>럭키포인트순</option>
				<option value="rdm"<?php echo get_selected('rdm', $wset['sort']); ?>>무작위(랜덤)</option>
			</select>
			&nbsp;
			랭크표시
			<select name="wset[rank]">
				<option value=""<?php echo get_selected('', $wset['rank']); ?>>표시안함</option>
				<option value="red"<?php echo get_selected('red', $wset['rank']); ?>>레드</option>
				<option value="blue"<?php echo get_selected('blue', $wset['rank']); ?>>블루</option>
				<option value="green"<?php echo get_selected('green', $wset['rank']); ?>>그린</option>
				<option value="orange"<?php echo get_selected('orange', $wset['rank']); ?>>오렌지</option>
				<option value="yellow"<?php echo get_selected('yellow', $wset['rank']); ?>>옐로우</option>
				<option value="violet"<?php echo get_selected('violet', $wset['rank']); ?>>바이올렛</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">기간설정</td>
		<td>
			<select name="wset[term]">
				<option value=""<?php echo get_selected('', $wset['term']); ?>>사용안함</option>
				<option value="day"<?php echo get_selected('day', $wset['term']); ?>>일자지정</option>
				<option value="today"<?php echo get_selected('today', $wset['term']); ?>>오늘</option>
				<option value="yesterday"<?php echo get_selected('yesterday', $wset['term']); ?>>어제</option>
				<option value="month"<?php echo get_selected('month', $wset['term']); ?>>이번달</option>
				<option value="prev"<?php echo get_selected('prev', $wset['term']); ?>>지난달</option>
			</select>
			&nbsp;
			<input type="text" name="wset[dayterm]" value="<?php echo $wset['dayterm'];?>" size="3" class="frm_input"> 일전까지 자료(일자지정 설정시 적용)
		</td>
	</tr>
	<tr>
		<td align="center">회원지정</td>
		<td>
			<?php echo help('회원아이디를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[mb_list]" value="<?php echo $wset['mb_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[ex_mb]" value="1"<?php echo ($wset['ex_mb']) ? ' checked' : '';?>> 제외하기</label>
		</td>
	</tr>
	<tr>
		<td align="center">본인자료</td>
		<td>
			<label><input type="checkbox" name="wset[mb]" value="1"<?php echo ($wset['mb']) ? ' checked' : '';?>> 로그인한 회원의 본인자료만 추출</label>
			&nbsp;
			<label><input type="checkbox" name="wset[mb_re]" value="1"<?php echo ($wset['mb_re']) ? ' checked' : '';?>> 받은 답글/대댓글도 추출</label>
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