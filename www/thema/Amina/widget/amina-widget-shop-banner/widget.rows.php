<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 변수정리
$slide = (int)$wset['slide'];
$slide = ($slide > 0) ? $slide : 1;
$item_sero = (int)$wset['sero'];
$item_cols = (int)$wset['garo'];
$item_cols = ($item_cols > 0) ? $item_cols : 4;
$item_rows = 12 / $item_cols;
$item_xs = (int)$wset['xs'];
$item_xs = ($item_xs && $item_xs < 12) ? ' col-xs-'.$item_xs : '';

// 총추출수
$slide_rows = $item_sero * $item_rows;
$wset['rows'] = $slide * $slide_rows;


// 글추출
$list = apms_banner_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 40;

?>

<div class="row">
	<?php for ($i=0; $i < $list_cnt; $i++) { 
		if($i > 0 && $i%$slide_rows == 0) { // 슬라이더
			echo '</div><!-- //row -->'.PHP_EOL;
			echo '</div>'.PHP_EOL;
			echo '<div class="item">'.PHP_EOL;
			echo '<div class="row">'.PHP_EOL;
		}
	?>
		<div class="col-sm-<?php echo $item_cols.$item_xs;?> col">
			<div class="item<?php echo (!$i) ? ' active' : '';?>">
				<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
					<a href="<?php echo $list[$i]['href'];?>"<?php echo $list[$i]['target'];?>>
						<img src="<?php echo $list[$i]['img'];?>" alt="<?php echo $list[$i]['alt'];?>">
					</a>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<p class="text-muted text-center">등록된 배너가 없습니다.</p>
	<?php } ?>
</div>
