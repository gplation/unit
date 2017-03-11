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
$list =  apms_item_rows($wset);
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
					<div class="label-tack"><?php echo item_icon($list[$i]);?></div>
					<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
						<a href="<?php echo $list[$i]['href'];?>">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
							<div class="figure-caption en font-11">
								<ul>
									<li><i class="fa fa-shopping-cart"></i> <?php echo $list[$i]['it_sum_qty']; //판매량 ?></li>
									<li><i class="fa fa-pencil"></i> <?php echo $list[$i]['it_use_cnt']; //후기수 ?></li>
									<li><i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['pt_good']; //추천수 ?></li>
									<li><?php echo apms_get_star($list[$i]['it_use_avg']); ?></li>
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
						<?php echo $list[$i]['it_name'];?>
					</a>
				</h2>
				<div class="item-info en font-14 text-muted">
					<span class="pull-left">
						<i class="fa fa-comment"></i> 
						<?php echo ($list[$i]['pt_comment']) ? '<span class="red">'.number_format($list[$i]['pt_comment']).'</span>' : 0;?>
						<?php if($list[$i]['it_point']) { ?>
							&nbsp;
							<i class="fa fa-gift"></i> 
							<?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i]));?>
						<?php } ?>
					</span>
					<span class="pull-right black">
						<b><?php echo ($list[$i]['it_tel_inq']) ? 'Call' : number_format($list[$i]['it_price']);?></b>
					</span>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php if($wset['sns']) { ?>
				<p class="text-center">
					<?php 
						$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it_id'];
						$sns_title = get_text($list[$i]['it_name']);
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
		<p class="text-muted text-center">아이템이 없습니다.</p>
	<?php } ?>
</div>
