<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 변수정리
$item_sero = (int)$wset['sero'];
$item_cols = (int)$wset['garo'];
$item_cols = ($item_cols > 0) ? $item_cols : 6;
$item_rows = 12 / $item_cols;
$item_xs = (int)$wset['xs'];
$item_xs = ($item_xs && $item_xs < 12) ? ' col-xs-'.$item_xs : '';

// 총추출수
$wset['rows'] = $item_sero * $item_rows;

// 노이미지 주소
$wset['no_img'] = $widget_url.'/img/no-img.jpg';

// 글추출
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 65;

// 새글표시
$label = ($wset['new']) ? $wset['new'] : 'red';

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

// 내용길이
$wset['cut'] = 100;

// 방향
if(!$wset['arrow']) $wset['arrow'] = 'left';

?>

<div class="row">
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<div class="col-sm-<?php echo $item_cols.$item_xs;?> col">
			<div class="content" style="height:<?php echo $wset['thumb_h'];?>px;">
				<div class="pull-<?php echo $wset['arrow'];?> left img-box <?php echo $wset['arrow'];?>" style="width:<?php echo $wset['thumb_w'];?>px;">
					<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
						<a href="<?php echo $list[$i]['href'];?>">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						</a>
					</div>
				</div>
				<strong>
					<a href="<?php echo $list[$i]['href'];?>">
						<?php echo ($list[$i]['comment']) ? '<span class="pull-right cnt">'.$list[$i]['comment'].'</span>' : '';?>
						<?php if($wset['rank']) { ?>
							<span class="en rank-icon bg-<?php echo $wset['rank'];?>"><?php echo $rank; $rank++; ?></span>
						<?php } else if($list[$i]['new']) { ?>
							<span class="<?php echo $wset['new'];?>"><i class="fa fa-circle"></i></span>
						<?php } ?>
						<?php echo $list[$i]['subject'];?>
					</a>
				</strong>
				<p>
					<?php echo apms_cut_text($list[$i]['content'], $wset['cut']);?>
				</p>
			</div>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<p class="text-muted text-center">글이 없습니다.</p>
	<?php } ?>
</div>
