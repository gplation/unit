<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

?>

<div class="local_desc01 local_desc">
	<ul>
		<li>위젯명 : Shop Post v1.0 by AMINA (http://amina.co.kr)</li>
		<li>쇼핑몰 아이템의 댓글,후기,문의 추출 기본 위젯</li>
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
		<td align="center">추출글수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="3"> 개 PC 출력
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="3"> 개 모바일 출력
			&nbsp;
			<input type="text" name="wset[page]" value="<?php echo $wset['page'];?>" size="3" class="frm_input"> 페이지 자료 추출
		</td>
	</tr>
	<tr>
		<td align="center">추출모드</td>
		<td>
			<select name="wset[mode]">
				<option value="comment"<?php echo get_selected('comment', $wset['mode']); ?>>아이템 댓글</option>
				<option value="use"<?php echo get_selected('use', $wset['mode']); ?>>아이템 후기</option>
				<option value="qa"<?php echo get_selected('qa', $wset['mode']); ?>>아이템 문의</option>
			</select>
			를 추출합니다.
		</td>
	</tr>

	<tr>
		<td align="center">아이템유형</td>
		<td>
			<select name="wset[type]">
				<option value=""<?php echo get_selected('', $wset['type']); ?>>전체아이템</option>
				<option value="1"<?php echo get_selected('1', $wset['type']); ?>>히트아이템</option>
				<option value="2"<?php echo get_selected('2', $wset['type']); ?>>추천아이템</option>
				<option value="3"<?php echo get_selected('3', $wset['type']); ?>>신규아이템</option>
				<option value="4"<?php echo get_selected('4', $wset['type']); ?>>인기아이템</option>
				<option value="5"<?php echo get_selected('5', $wset['type']); ?>>할인아이템</option>
			</select>
			을 추출합니다.
		</td>
	</tr>
	<tr>
		<td align="center">분류지정</td>
		<td>
			<input type="text" name="wset[ca_id]" value="<?php echo $wset['ca_id']; ?>" size="20" class="frm_input">
			(분류는 1개만 지정가능, 분류코드 입력)
		</td>
	</tr>
	<tr>
		<td align="center">제외분류</td>
		<td>
			<input type="text" name="wset[ex_ca]" value="<?php echo $wset['ex_ca']; ?>" size="20" class="frm_input">
			(제외분류는 1개만 지정가능, 분류코드 입력)
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
		<td align="center">제목길이</td>
		<td>
			<input type="text" name="wset[cut]" value="<?php echo ($wset['cut']);?>" size="3" class="frm_input"> 자 출력
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
				<option value="qty"<?php echo get_selected('qty', $wset['sort']); ?>>판매순</option>
				<option value="use"<?php echo get_selected('use', $wset['sort']); ?>>후기순</option>
				<option value="hit"<?php echo get_selected('hit', $wset['sort']); ?>>조회순</option>
				<option value="comment"<?php echo get_selected('comment', $wset['sort']); ?>>댓글순</option>
				<option value="good"<?php echo get_selected('good', $wset['sort']); ?>>추천순</option>
				<option value="nogood"<?php echo get_selected('nogood', $wset['sort']); ?>>비추천순</option>
				<option value="like"<?php echo get_selected('like', $wset['sort']); ?>>추천-비추천순</option>
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
		<td align="center">파트너지정</td>
		<td>
			<?php echo help('파트너아이디를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[pt_list]" value="<?php echo $wset['pt_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[ex_pt]" value="1"<?php echo ($wset['ex_pt']) ? ' checked' : '';?>> 제외하기</label>
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