<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 썸네일
$wset['thumb_w'] = 80;
$wset['thumb_h'] = 80;

// 글추출
$list = apms_item_post_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = apms_fa($wset['icon']);

// 노이미지 주소
$no_img = $widget_url.'/img/no-img.jpg';

?>

<?php for ($i=0; $i < $list_cnt; $i++) {
	$list[$i]['img']['src'] = ($list[$i]['img']['src']) ? $list[$i]['img']['src'] : $list[$i]['photo']; // 이미지가 없으면 사진으로 대체
	$list[$i]['img']['src'] = ($list[$i]['img']['src']) ? $list[$i]['img']['src'] : apms_thumbnail($no_img, $wset['thumb_w'], $wset['thumb_h'], false, true); // no-image
?>
	<div class="media">
		<div class="photo pull-left">
			<a href="<?php echo $list[$i]['href'];?>">
				<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
			</a>
		</div>
		<div class="media-body">
			<a href="<?php echo $list[$i]['href'];?>">
				<?php if($wset['icon']) { ?>
					<span class="icon">
						<?php if($list[$i]['new']) { ?>
							<span class="<?php echo $wset['new'];?>"><?php echo $icon;?></span>
						<?php } else { ?>
							<?php echo $icon;?>
						<?php } ?>
					</span>
				<?php } ?>
				<?php echo $list[$i]['subject'];?>
			</a>
			<div class="info font-11 text-muted">
				<?php echo $list[$i]['it_name'];?>
			</div>
		</div>
	</div>
<?php } ?>

<?php if(!$list_cnt) { ?>
	<p class="text-muted text-center">글이 없습니다.</p>
<?php } ?>