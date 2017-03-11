<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// SNS 아이콘 출력
$sns_icon = true;

// StyleSheet
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/style.css" type="text/css" media="screen">',0);

//가로 아이템수에 따른 칼럼 계산
switch($list_mods) {
	case '1'	: $item_cols = 12; break;
	case '2'	: $item_cols = 6; break;
	case '3'	: $item_cols = 4; break;
	case '4'	: $item_cols = 3; break;
	case '6'	: $item_cols = 2; break;
	default		: $item_cols = 3; $list_mods = 4; break;
}

$img_height = ($thumb_w > 0 && $thumb_h > 0) ? round(($thumb_h / $thumb_w) * 100, 2) : '';
if(!$img_height) $img_height = 100;

?>

<?php if($is_nav) { // 네비게이션 ?>
	<aside class="list-nav en font-13 hidden-xs">
		<ol class="breadcrumb">
			<?php for($i=0;$i < count($nav); $i++) { ?>
				<li>
					<a href="./list.php?ca_id=<?php echo $nav[$i]['ca_id'];?>"<?php echo ($nav[$i]['on']) ? ' class="active"' : '';?>>
						<?php echo ($i == 0) ? '<i class="fa fa-gift"></i> ' : '';?>
						<?php echo $nav[$i]['name'];?> 
						<span>(<?php echo $nav[$i]['cnt'];?>)</span>
					</a>
				</li>
			<?php } ?>
		</ol>
	</aside>
<?php } ?>

<aside>
	<div class="row en">
		<div class="col-sm-3">
			<?php if($is_cate) { // 하위분류 ?>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-tag"></i></span>
					<select name="ca_id" onchange="location='./list.php?ca_id=' + this.value;" class="form-control input-sm">
						<option value="<?php echo $ca_id;?>">카테고리</option>
						<?php for($i=0;$i < count($cate); $i++) { ?>
							<option value="<?php echo $cate[$i]['ca_id'];?>"<?php echo ($ca_id == $cate[$i]['ca_id']) ? ' selected' : '';?>><?php echo $cate[$i]['name'];?></option>
						<?php } ?>
					</select>
					<?php if($up_href) { ?>
						<span class="input-group-addon"><a href="<?php echo $up_href;?>" title="상위분류"><i class="fa fa-caret-up"></i></a></span>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-sm-6">

		</div>
		<div class="col-sm-3">
			<div class="form-group input-group input-group-sm">
				<span class="input-group-addon"><i class="fa fa-sort"></i></span>
				<select name="sortodr" onchange="location='<?php echo $list_sort_href; ?>' + this.value;" class="form-control input-sm">
					<option value="">정렬하기</option>
					<option value="it_sum_qty&amp;sortodr=desc"<?php echo ($sort == 'it_sum_qty') ? ' selected' : '';?>>판매많은순</option>
					<option value="it_price&amp;sortodr=asc"<?php echo ($sort == 'it_price' && $sortodr == 'asc') ? ' selected' : '';?>>낮은가격순</option>
					<option value="it_price&amp;sortodr=desc"<?php echo ($sort == 'it_price' && $sortodr == 'desc') ? ' selected' : '';?>>높은가격순</option>
					<option value="it_use_avg&amp;sortodr=desc"<?php echo ($sort == 'it_use_avg') ? ' selected' : '';?>>평점높은순</option>
					<option value="it_use_cnt&amp;sortodr=desc"<?php echo ($sort == 'it_use_cnt') ? ' selected' : '';?>>후기많은순</option>
					<option value="pt_good&amp;sortodr=desc"<?php echo ($sort == 'pt_good') ? ' selected' : '';?>>추천많은순</option>
					<option value="pt_comment&amp;sortodr=desc"<?php echo ($sort == 'pt_comment') ? ' selected' : '';?>>댓글많은순</option>
					<option value="it_update_time&amp;sortodr=desc"<?php echo ($sort == 'it_update_time') ? ' selected' : '';?>>최근등록순</option>
				</select>
			</div>
		</div>
	</div>
</aside>

<section>
	<div class="item">
		<div class="row">
		<?php for($i=0; $i < count($list); $i++) { 

			// 새글
			$list[$i]['new'] = ($list[$i]['pt_num'] >= (G5_SERVER_TIME - (24 * 3600))) ? true : false;

			// 이미지
			$list[$i]['img'] = apms_it_thumbnail($list[$i], $thumb_w, $thumb_h, false, true);
			if(!$list[$i]['img']['src']) {
				$list[$i]['img'] = apms_thumbnail($list_skin_url.'/img/no-img.jpg', $thumb_w, $thumb_h, false, true); // no-image
			}

		?>
			<?php if($i > 0 && $i%$list_mods == 0) { ?>
					</div>
				</div>
				<div class="item">
					<div class="row">
			<?php } ?>
			<div class="col-sm-<?php echo $item_cols;?>">
				<div class="list-box">
					<div class="list-item">
						<div class="figure">
							<?php if($list[$i]['it_id'] == $it_id) { ?>
								<div class="label-band label-red">Now</div>
							<?php } else { ?>
								<?php if($list[$i]['new']) {?>
									<div class="label-band label-blue">New</div>
								<?php } ?>
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
					<?php if($sns_icon) { ?>
						<p class="text-center">
							<?php 
								$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it_id'];
								$sns_title = get_text($list[$i]['it_name'].' | '.$config['cf_title']);
								$sns_img = $list_skin_url.'/img';
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
			</div>
		<?php } ?>
		</div>
		<?php if($i == 0) echo '<p class="text-muted text-center">등록된 자료가 없습니다.</p>'.PHP_EOL; ?>
	</div>
</section>

<div style="margin-bottom:20px;">
	<?php if($total_count > 0) { ?>
		<div class="pull-left">
			<ul class="pagination pagination-sm en" style="margin:0; padding:0;">
				<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>
	<div class="pull-right">
		<?php if ($is_event) { ?>
			<a class="btn btn-color btn-sm" href="./event.php">이벤트</a>
		<?php } ?>
		<?php if ($write_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $write_href;?>">등록</a>
		<?php } ?>
		<?php if ($admin_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $admin_href;?>">관리</a>
		<?php } ?>
		<?php if ($config_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $config_href;?>">설정</a>
		<?php } ?>
		<?php if ($rss_href) { ?>
			<a class="btn btn-color btn-sm" title="카테고리 RSS 구독하기" href="<?php echo $rss_href;?>" target="_blank"><i class="fa fa-rss fa-lg"></i></a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>
