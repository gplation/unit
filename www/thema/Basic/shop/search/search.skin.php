<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// SNS 아이콘 출력
$sns_icon = true;

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

$img_height = ($thumb_w > 0 && $thumb_h > 0) ? round(($thumb_h / $thumb_w) * 100, 2) : 100;

?>

<aside>
	<form id="frmdetailsearch" name="frmdetailsearch" class="form-horizontal" role="form">
	<input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
	<input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
	<input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
		<div class="well" style="padding-bottom:0px;">
			<div class="form-group">
				<label class="col-sm-2 control-label hidden-xs"><b>검색범위</b></label>
				<div class="col-sm-10">
					<label class="control-label label-sp"><input type="checkbox" name="qname" id="ssch_qname" value="1" <?php echo $qname_check?'checked="checked"':'';?>> 제목</label>
					<label class="control-label label-sp"><input type="checkbox" name="qexplan" id="ssch_qexplan" value="1" <?php echo $qexplan_check?'checked="checked"':'';?>> 설명</label>
					<label class="control-label label-sp"><input type="checkbox" name="qid" id="ssch_qid" value="1" <?php echo $qid_check?'checked="checked"':'';?>> 코드</label>
					<label class="control-label"><input type="checkbox" name="qtag" id="ssch_qtag" value="1" <?php echo $qtag_check?'checked="checked"':'';?>> 태그</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label hidden-xs"><b>상품가격 (원)</b></label>
				<div class="col-sm-10">
					<label for="ssch_qfrom" class="sound_only">최소 가격</label>
					<label class="label-none">
						<input type="text" name="qfrom" value="<?php echo $qfrom; ?>" id="ssch_qfrom" class="form-control input-sm" size="10" placeholder="최소 가격">
					</label>
					<label> ~ </label>
					<label for="ssch_qto" class="sound_only">최대 가격</label>
					<label class="label-none">
						<input type="text" name="qto" value="<?php echo $qto; ?>" id="ssch_qto" class="form-control input-sm" size="10" placeholder="최대 가격">
					</label>
				</div>
			</div>

			<div class="form-group">
				<label for="ssch_q" class="col-sm-2 control-label hidden-xs"><b>검색어</b></label>
				<div class="col-sm-4">
					<input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="form-control input-sm" size="40" maxlength="30" placeholder="검색어">
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-color btn-block btn-sm search-btn"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>

			<div class="form-group">
				<label for="ssch_q" class="col-sm-2 control-label hidden-xs"><b>검색안내</b></label>
				<div class="col-sm-10">
					검색범위을 선택하지 않거나, 상품가격을 입력하지 않으면 전체에서 검색합니다.<br>
					검색어는 최대 30글자까지, 여러개의 검색어를 공백으로 구분하여 입력 할수 있습니다.
				</div>
			</div>
		</div>
	</form>

	<script>
		function set_sort(qsort) {
			var f = document.frmdetailsearch;
			var qorder = "desc";

			if(qsort == "it_price_min") {
				qsort = "it_price";
				qorder = "asc";
			}
			f.qsort.value = qsort;
			f.qorder.value = qorder;
			f.submit();
		}

		function set_ca_id(qcaid) {
			var f = document.frmdetailsearch;
			f.qcaid.value = qcaid;
			f.submit();
		}
	</script>

</asde>

<aside>
	<div class="row en">
		<div class="col-sm-3">
			<div class="form-group input-group input-group-sm">
				<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				<select name="sortodr" onchange="set_ca_id(this.value); return false;" class="form-control input-sm">
					<option value="">전체분류(<?php echo number_format($total_count);?>)</option>
					<?php for($i=0;$i < count($category); $i++) { ?>
						<option value="<?php echo $category[$i]['ca_id'];?>"<?php echo ($qcaid == $category[$i]['ca_id']) ? ' selected' : '';?>><?php echo $category[$i]['ca_name'];?>(<?php echo number_format($category[$i]['cnt']);?>)</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-sm-6">

		</div>
		<div class="col-sm-3">
			<div class="form-group input-group input-group-sm">
				<span class="input-group-addon"><i class="fa fa-sort"></i></span>
				<select name="sortodr" onchange="set_sort(this.value); return false;" class="form-control input-sm">
					<option value="">정렬하기</option>
					<option value="it_sum_qty"<?php echo ($qsort == 'it_sum_qty') ? ' selected' : '';?>>판매많은순</option>
					<option value="it_price_min"<?php echo ($qsort == 'it_price' && $qorder == 'asc') ? ' selected' : '';?>>낮은가격순</option>
					<option value="it_price"<?php echo ($qsort == 'it_price' && $qorder == 'desc') ? ' selected' : '';?>>높은가격순</option>
					<option value="it_use_avg"<?php echo ($qsort == 'it_use_avg') ? ' selected' : '';?>>평점높은순</option>
					<option value="it_use_cnt"<?php echo ($qsort == 'it_use_cnt') ? ' selected' : '';?>>후기많은순</option>
					<option value="pt_good"<?php echo ($qsort == 'pt_good') ? ' selected' : '';?>>추천많은순</option>
					<option value="pt_comment"<?php echo ($qsort == 'pt_comment') ? ' selected' : '';?>>댓글많은순</option>
					<option value="it_update_time"<?php echo ($qsort == 'it_update_time') ? ' selected' : '';?>>최근등록순</option>
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
				$list[$i]['img'] = apms_thumbnail(THEMA_URL.'/assets/img/no-img.jpg', $thumb_w, $thumb_h, false, true); // no-image
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
			</div>
		<?php } ?>
		<?php if($i == 0) echo '<div class="col-sm-12"><p align="center">검색된 자료가 없습니다.</p></div>'.PHP_EOL; ?>
		</div>
	</div>
</section>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<?php if($admin_href) { ?>
	<p class="text-center">
		<a href="<?php echo $admin_href;?>" class="btn btn-black btn-sm">검색설정</a>
	</p>
<?php } ?>