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
$wset['rows'] = $slide * $item_sero * $item_rows;

// 슬라이더 체크
$slide_rows = $item_rows * $item_sero;

// 노이미지 주소
$wset['no_img'] = $widget_url.'/img/no-img.jpg';

// 글추출
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 40;

// 새글표시
$label = ($wset['new']) ? $wset['new'] : 'red';

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

?>

<div class="row">
	<?php for ($i=0; $i < $list_cnt; $i++) { 
		// 링크#1
		$target = '';
		if($wset['link'] && $list[$i]['wr_link1']) {
			$list[$i]['href'] = $list[$i]['link_href'][1];
			$target = ' target="_blank"';
		}
	?>
		<?php if($i > 0 && $i%$slide_rows == 0) { // 슬라이더?>
				</div> <!-- //row -->
			</div>
			<div class="item">
				<div class="row">
		<?php } ?>
		<div class="col-sm-<?php echo $item_cols.$item_xs;?> col">
			<div class="content">
				<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
					<a href="<?php echo $list[$i]['href'];?>"<?php echo $target;?>>
						<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						<div class="caption">
							<?php if($list[$i]['comment']) { ?>
								<span class="pull-right cnt"><?php echo number_format($list[$i]['comment']);?></span>
							<?php } ?>

							<?php if($wset['rank']) { ?>
								<span class="en rank-icon bg-<?php echo $wset['rank'];?>"><?php echo $rank; $rank++; ?></span>
							<?php } else if($wset['icon']) { ?>
								<span class="icon">
									<?php if($list[$i]['new']) { ?>
										<span class="<?php echo $wset['new'];?>"><?php echo $icon;?></span>
									<?php } else { ?>
										<?php echo $icon;?>
									<?php } ?>
								</span>
							<?php } ?>
							<?php echo $list[$i]['subject'];?>
						</div>
					</a>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<p class="text-muted text-center">글이 없습니다.</p>
	<?php } ?>
</div>
