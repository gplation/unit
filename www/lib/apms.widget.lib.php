<?php
if (!defined('_GNUBOARD_')) exit;

// 입력 폼 안내문
if (!function_exists('help')) {
	function help($help="")	{
		global $g5;

		$str  = '<span class="frm_info">'.str_replace("\n", "<br>", $help).'</span>';

		return $str;
	}
}

function apms_carousel_options($value) {

	$options = '<option value="1"'.get_selected('1', $value).'>슬라이더</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>페이드</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>버티컬</option>'.PHP_EOL;
	$options .= '<option value=""'.get_selected('', $value).'>효과없음</option>'.PHP_EOL;

	return $options;
}

function apms_rank_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>최근순</option>'.PHP_EOL;
	$options .= '<option value="asc"'.get_selected('asc', $value).'>등록순</option>'.PHP_EOL;
	$options .= '<option value="date"'.get_selected('date', $value).'>날짜순</option>'.PHP_EOL;
	$options .= '<option value="hit"'.get_selected('hit', $value).'>조회순</option>'.PHP_EOL;
	$options .= '<option value="comment"'.get_selected('comment', $value).'>댓글순</option>'.PHP_EOL;
	$options .= '<option value="good"'.get_selected('good', $value).'>추천순</option>'.PHP_EOL;
	$options .= '<option value="nogood"'.get_selected('nogood', $value).'>비추천순</option>'.PHP_EOL;
	$options .= '<option value="like"'.get_selected('like', $value).'>추천-비추천순</option>'.PHP_EOL;
	$options .= '<option value="download"'.get_selected('download', $value).'>다운로드순</option>'.PHP_EOL;
	$options .= '<option value="link"'.get_selected('link', $value).'>링크방문순</option>'.PHP_EOL;
	$options .= '<option value="poll"'.get_selected('poll', $value).'>설문참여순</option>'.PHP_EOL;
	$options .= '<option value="lucky"'.get_selected('lucky', $value).'>럭키포인트순</option>'.PHP_EOL;
	$options .= '<option value="rdm"'.get_selected('rdm', $value).'>무작위(랜덤)</option>'.PHP_EOL;

	return $options;
}

function apms_item_rank_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>최근순</option>'.PHP_EOL;
	$options .= '<option value="qty"'.get_selected('qty', $value).'>판매순</option>'.PHP_EOL;
	$options .= '<option value="use"'.get_selected('use', $value).'>후기순</option>'.PHP_EOL;
	$options .= '<option value="hit"'.get_selected('hit', $value).'>조회순</option>'.PHP_EOL;
	$options .= '<option value="comment"'.get_selected('comment', $value).'>댓글순</option>'.PHP_EOL;
	$options .= '<option value="good"'.get_selected('good', $value).'>추천순</option>'.PHP_EOL;
	$options .= '<option value="nogood"'.get_selected('nogood', $value).'>비추천순</option>'.PHP_EOL;
	$options .= '<option value="like"'.get_selected('like', $value).'>추천-비추천순</option>'.PHP_EOL;
	$options .= '<option value="rdm"'.get_selected('rdm', $value).'>무작위(랜덤)</option>'.PHP_EOL;

	return $options;
}

function apms_item_type_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>전체아이템</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>히트아이템</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>추천아이템</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>신규아이템</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>인기아이템</option>'.PHP_EOL;
	$options .= '<option value="5"'.get_selected('5', $value).'>할인아이템</option>'.PHP_EOL;

	return $options;
}

function apms_color_options($value) {

	$options = '<option value="red"'.get_selected('red', $value).'>Red</option>'.PHP_EOL;
	$options .= '<option value="darkred"'.get_selected('darkred', $value).'>DarkRed</option>'.PHP_EOL;
	$options .= '<option value="crimson"'.get_selected('crimson', $value).'>Crimson</option>'.PHP_EOL;
	$options .= '<option value="orangered"'.get_selected('orangered', $value).'>OrangeRed</option>'.PHP_EOL;
	$options .= '<option value="orange"'.get_selected('orange', $value).'>Orange</option>'.PHP_EOL;
	$options .= '<option value="green"'.get_selected('green', $value).'>Green</option>'.PHP_EOL;
	$options .= '<option value="lightgreen"'.get_selected('lightgreen', $value).'>LightGreen</option>'.PHP_EOL;
	$options .= '<option value="deepblue"'.get_selected('deepblue', $value).'>DeepBlue</option>'.PHP_EOL;
	$options .= '<option value="skyblue"'.get_selected('skyblue', $value).'>SkyBlue</option>'.PHP_EOL;
	$options .= '<option value="blue"'.get_selected('blue', $value).'>Blue</option>'.PHP_EOL;
	$options .= '<option value="navy"'.get_selected('navy', $value).'>Navy</option>'.PHP_EOL;
	$options .= '<option value="violet"'.get_selected('violet', $value).'>Violet</option>'.PHP_EOL;
	$options .= '<option value="yellow"'.get_selected('yellow', $value).'>Yellow</option>'.PHP_EOL;
	$options .= '<option value="lightgray"'.get_selected('lightgray', $value).'>LightGray</option>'.PHP_EOL;
	$options .= '<option value="gray"'.get_selected('gray', $value).'>Gray</option>'.PHP_EOL;
	$options .= '<option value="darkgray"'.get_selected('darkgray', $value).'>DarkGray</option>'.PHP_EOL;
	$options .= '<option value="black"'.get_selected('black', $value).'>Black</option>'.PHP_EOL;
	$options .= '<option value="white"'.get_selected('white', $value).'>White</option>'.PHP_EOL;

	return $options;
}

function apms_tab_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>일반탭</option>'.PHP_EOL;
	$options .= '<option value="-box"'.get_selected('-box', $value).'>박스탭</option>'.PHP_EOL;
	$options .= '<option value="-top"'.get_selected('-top', $value).'>상단라인</option>'.PHP_EOL;
	$options .= '<option value="-bottom"'.get_selected('-bottom', $value).'>하단라인</option>'.PHP_EOL;

	return $options;
}

function apms_shadow_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>그림자 없음</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>그림자1</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>그림자2</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>그림자3</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>그림자4</option>'.PHP_EOL;

	return $options;
}

function apms_grade_options($value) {

	$options = '<option value="10"'.get_selected('10', $value).'>10</option>'.PHP_EOL;
	$options .= '<option value="9"'.get_selected('9', $value).'>9</option>'.PHP_EOL;
	$options .= '<option value="8"'.get_selected('8', $value).'>8</option>'.PHP_EOL;
	$options .= '<option value="7"'.get_selected('7', $value).'>7</option>'.PHP_EOL;
	$options .= '<option value="6"'.get_selected('6', $value).'>6</option>'.PHP_EOL;
	$options .= '<option value="5"'.get_selected('5', $value).'>5</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>4</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>3</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>2</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>1</option>'.PHP_EOL;
	return $options;
}

function apms_term_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>사용안함</option>'.PHP_EOL;
	$options .= '<option value="day"'.get_selected('day', $value).'>일자지정</option>'.PHP_EOL;
	$options .= '<option value="today"'.get_selected('today', $value).'>오늘</option>'.PHP_EOL;
	$options .= '<option value="yesterday"'.get_selected('yesterday', $value).'>어제</option>'.PHP_EOL;
	$options .= '<option value="month"'.get_selected('month', $value).'>이번달</option>'.PHP_EOL;
	$options .= '<option value="prev"'.get_selected('prev', $value).'>지난달</option>'.PHP_EOL;

	return $options;
}

function apms_cols_options($value, $opt='') {

	if(!$opt) $opt = '4,3,2,1,4,6,12';

	$cols = explode(",", $opt);

	$options = '';
	for($i=0; $i < count($cols); $i++) {

		$num = (int)$cols[$i];

		if(!$num) continue;

		$col = (int)(12 / $num);
		$options .= '<option value="'.$col.'"'.get_selected($col, $value).'>'.$num.'</option>'.PHP_EOL;
	}

	return $options;
}

?>