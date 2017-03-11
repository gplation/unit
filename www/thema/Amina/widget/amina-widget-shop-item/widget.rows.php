<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 변수정리
$item_sero = (int)$wset['sero'];
$item_cols = (int)$wset['garo'];
$item_cols = ($item_cols > 0) ? $item_cols : 4;
$item_rows = 12 / $item_cols;
$item_xs = (int)$wset['xs'];
$item_xs = ($item_xs && $item_xs < 12) ? ' col-xs-'.$item_xs : '';

// 총추출수
$wset['rows'] = $item_sero * $item_rows;

// 노이미지 주소
$wset['no_img'] = $widget_url.'/img/no-img.jpg';

// 글추출
$list = apms_item_rows($wset);
$list_cnt = count($list);

// 이미지 비율
$img_height = ($wset['thumb_w'] > 0 && $wset['thumb_h'] > 0) ? round(($wset['thumb_h'] / $wset['thumb_w']) * 100, 2) : 100;

// 새상품표시
$label = ($wset['new']) ? $wset['new'] : 'red';

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

?>

<div class="row">
	<?php for ($i=0; $i < $list_cnt; $i++) { 
		
		// 시중가, 할인율
		$cur_price = $dc = '';
		if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
			$dc = round((($list[$i]['it_cust_price'] - $list[$i]['it_price']) / $list[$i]['it_cust_price']) * 100);
			if($wset['cur']) $cur_price = '<div class="cur-price"><strike>&nbsp;'.number_format($list[$i]['it_cust_price']).'</strike></div>';
		}		

		// 아이콘
		$item_icon = item_icon($list[$i]);

	?>
		<div class="col-sm-<?php echo $item_cols.$item_xs;?> col">
			<div class="item-box">
				<div class="item-content">
					<?php if($item_icon) { ?>
						<div class="label-tack"><?php echo $item_icon; ?></div>
					<?php } ?>
					<div class="img" style="padding-bottom:<?php echo $img_height;?>%;">
						<?php if($wset['rank']) { ?>
							<?php if($rank > 6) {?>
								<div class="label-band bg-green"><?php echo $rank;?>th</div>
							<?php } else if($rank > 3) {?>
								<div class="label-band bg-blue"><?php echo $rank;?>th</div>
							<?php } else {?>
								<div class="label-band bg-red">Top<?php echo $rank;?></div>
							<?php } $rank++; ?>
						<?php } else { ?>
							<?php if($dc) {?>
								<div class="label-band bg-red">DC</div>
							<?php } else if($list[$i]['it_type3'] || $list[$i]['new']) {?>
								<div class="label-band bg-blue">New</div>
							<?php } ?>
						<?php } ?>
						<a href="<?php echo $list[$i]['href'];?>">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						</a>
					</div>
					<?php if($wset['sns']) { ?>
						<div class="label-share">
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
						</div>
					<?php } ?>
					<?php if($dc) { ?>
						<div class="<?php echo ($cur_price) ? 'label-dc-cur' : 'label-dc';?> en">
							<?php echo $cur_price;?>
							<?php echo $dc;?>%
						</div>
					<?php } ?>
					<div class="text">
						<strong>
							<a href="<?php echo $list[$i]['href'];?>">
								<?php echo $list[$i]['it_name'];?>
							</a>
						</strong>
						<div class="desc">
							<?php echo ($list[$i]['it_basic']) ? $list[$i]['it_basic'] : apms_cut_text($list[$i]['it_explan'], 80); ?>
						</div>
						<div class="details en">
							<div class="pull-left en font-14 text-muted">
								<i class="fa fa-comment"></i> 
								<?php echo ($list[$i]['pt_comment']) ? '<span class="red">'.number_format($list[$i]['pt_comment']).'</span>' : 0;?>
								<?php if($wset['buy']) { ?>
									&nbsp;
									<i class="fa fa-shopping-cart"></i> <?php echo ($list[$i]['it_sum_qty']) ? '<span class="blue">'.number_format($list[$i]['it_sum_qty']).'</span>' : 0;?>
								<?php } ?>
								<?php if($list[$i]['it_point']) { ?>
									&nbsp;
									<i class="fa fa-gift"></i> 
									<span class="green"><?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i]));?></span>
								<?php } ?>
							</div>
							<div class="pull-right font-16 price">
								<b><?php echo ($list[$i]['it_tel_inq']) ? 'Call' : number_format($list[$i]['it_price']);?></b>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<p class="text-muted text-center">등록된 상품이 없습니다.</p>
	<?php } ?>
</div>
