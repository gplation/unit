<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 변수정리
$slide = (int)$wset['slide'];
$slide = ($slide > 0) ? $slide : 1;
$item_cols = (int)$wset['garo'];
$item_cols = ($item_cols > 0) ? $item_cols : 3;
$item_rows = 12 / $item_cols;
$item_xs = (int)$wset['xs'];
$item_xs = ($item_xs < 12) ? ' col-xs-'.$item_xs : '';

// 총추출수
$wset['rows'] = $slide * $item_rows;

// 노이미지 주소
$wset['no_img'] = $widget_url.'/img/no-img.jpg';

// 글추출
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 100;

// 새글라벨표시
$label = ($wset['new']) ? $wset['new'] : 'red';

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

?>

<div class="row">
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<?php if($i > 0 && $i%$item_rows == 0) { ?>
				</div>
			</div>
			<div class="item">
				<div class="row">
		<?php } ?>
		<div class="col-sm-<?php echo $item_cols.$item_xs;?>">
			<div class="carousel-item">
				<div class="figure">
					<?php if($list[$i]['new']) {?>
						<div class="label-band bg-<?php echo $label;?>">New</div>
					<?php } ?>
					<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
						<a href="<?php echo $list[$i]['href'];?>">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
							<div class="figure-caption font-11">
								<ul>
									<li><i class="fa fa-eye"></i> <?php echo $list[$i]['wr_hit']; //조회수 ?></li>
									<li><i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['wr_good']; //추천수 ?></li>
									<li><i class="fa fa-clock-o"></i> <?php echo apms_datetime($list[$i]['date']); //시간?></li>
								</ul>
							</div>
						</a>
					</div>
				</div>
				<h2>
					<a href="<?php echo $list[$i]['href'];?>">
						<?php if($wset['rank']) { ?>
							<span class="en rank-icon bg<?php echo $wset['rank'];?>"><?php echo $rank; $rank++; ?></span>
						<?php } ?>
						<?php echo $list[$i]['subject'];?>
					</a>
				</h2>
				<div class="item-info text-muted font-12">
					<div class="pull-left">
						<i class="fa fa-user"></i>
						<?php echo $list[$i]['name'];?>
					</div>
					<div class="pull-right font-14 en">
						<i class="fa fa-comment"></i>
						<?php echo ($list[$i]['comment']) ? '<span class="red">'.number_format($list[$i]['comment']).'</span>' : 0;?></b>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php if($wset['sns']) { ?>
				<p class="text-center">
					<?php 
						$sns_url  = $list[$i]['href'];
						$sns_title = get_text($list[$i]['subject']);
						$sns_img = THEMA_URL.'/assets/img';
						echo  get_sns_share_link('facebook', $sns_url, $sns_title, $sns_img.'/sns_fb_s.png').' ';
						echo  get_sns_share_link('twitter', $sns_url, $sns_title, $sns_img.'/sns_twt_s.png').' ';
						echo  get_sns_share_link('googleplus', $sns_url, $sns_title, $sns_img.'/sns_goo_s.png').' ';
						echo  get_sns_share_link('kakaostory', $sns_url, $sns_title, $sns_img.'/sns_kakaostory_s.png').' ';
						echo  get_sns_share_link('kakaotalk', $sns_url, $sns_title, $sns_img.'/sns_kakao_s.png', $list[$i]['img']['src']).' ';
						echo  get_sns_share_link('naverband', $sns_url, $sns_title, $sns_img.'/sns_naverband_s.png').' ';
					?>
				</p>
			<?php } ?>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<p class="text-muted text-center">글이 없습니다.</p>
	<?php } ?>
</div>
