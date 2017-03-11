<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($at_set['thema'] != THEMA) { // 테마 설치 또는 변경시 초기값
	unset($at_set);
	$at_set['body_bgcolor'] = '#333333';
	$at_set['main'] = 13;
	$at_set['page'] = 9;
}

//Setup Column
if($is_main) {
	$col_content = ($at_set['main']) ? $at_set['main'] : 13;
} else {
	$col_content = ($at_set['page']) ? $at_set['page'] : 9;
}

$col_content = (int)$col_content;

$container = '';
if($col_content == 13) { // Full Wide
	$col_name = '';
	$container = 'container';
} else if($col_content == 12) { // One Column
	$col_name = 'one';
} else { // Two Column
	$col_name = 'two';
	$col_side = 12 - $col_content;
}

$at_set['background'] = ($at_set['background']) ? $at_set['background'] : 'none';

//Stylesheet
add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,900,400italic,700italic">',0);
add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/assets/bs3/css/bootstrap.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.COLORSET_URL.'/colorset.css" type="text/css" media="screen" class="thema-colorset">',0);
add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/widget/widget.css" type="text/css" media="screen">',0);
?>
<style> 
	body { background-color: <?php echo $at_set['body_bgcolor'];?>; background-image: <?php echo ($at_set['body_background'] && $at_set['body_background'] != 'none') ? "url('".$at_set['body_background']."')" : "none";?>; }
</style>
