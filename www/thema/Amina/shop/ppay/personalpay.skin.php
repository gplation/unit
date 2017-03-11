<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

//가로 아이템수에 따른 칼럼 계산
switch($list_mods) {
	case '1'	: $item_cols = 12; break;
	case '2'	: $item_cols = 6; break;
	case '3'	: $item_cols = 4; break;
	case '4'	: $item_cols = 3; break;
	case '6'	: $item_cols = 2; break;
	default		: $item_cols = 3; $list_mods = 4; break;
}

?>

<div class="row re-row">
<?php for($i=0; $i < count($list); $i++) { ?>
	<?php if($i > 0 && $i%$list_mods == 0) { ?>
		</div>
		<div class="row re-row">
	<?php } ?>
	<div class="col-sm-<?php echo $item_cols;?> col">
		<div class="ppay-box">
			<div class="ppay-fa">
				<a href="<?php echo $list[$i]['pp_href'];?>"><i class="fa fa-user"></i></a>
			</div>
			<h2><a href="<?php echo $list[$i]['pp_href'];?>"><?php echo display_price($list[$i]['pp_price']);?></a></h2>
			<p class="text-muted">
				<?php echo get_text($list[$i]['pp_name']);?>님 개인결제
			</p>
		</div>
	</div>
<?php } ?>
<?php if($i == 0) echo '<div class="col-sm-12"><div class="well text-center bg-colorset">등록된 개인결제가 없습니다.</div></div>'.PHP_EOL; ?>
</div>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>
