<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 썸네일
$wset['thumb_w'] = 80;
$wset['thumb_h'] = 80;

// 글추출
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = apms_fa($wset['icon']);

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

// 제목자르기
if(!$wset['cut']) $wset['cut'] = 25;

?>

<ul class="widget-photo-list">
	<?php for ($i=0; $i < $list_cnt; $i++) {
		// 이미지가 없으면 사진으로 대체
		$list[$i]['img']['src'] = ($list[$i]['img']['src']) ? $list[$i]['img']['src'] : $list[$i]['photo'];
	?>
		<li>
			<a href="<?php echo $list[$i]['href'];?>">
				<?php if($list[$i]['img']['src']) { ?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>" class="img-thumbnail pull-left">
				<?php } else { ?>
					<b class="pull-left"><i class="fa fa-user fa-4x"></i></b>
				<?php } ?>
			</a>
			<p>
				<a href="<?php echo $list[$i]['href'];?>">
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
					<?php echo apms_cut_text($list[$i]['subject'], $wset['cut']);?>
					<?php echo ($list[$i]['comment']) ? ' <small>'.$list[$i]['comment'].'</small>' : '';?>
					<?php echo ($list[$i]['secret']) ? ' <i class="fa fa-lock lightgray"></i>' : '';?>
				</a> 
				<span class="info">
					<i class="fa fa-user lightgray"></i> <?php echo $list[$i]['name'];?>
					&nbsp;
					<i class="fa fa-clock-o lightgray"></i> <?php echo apms_datetime($list[$i]['date'], 'm.d');?>
				</span>
			</p>
		</li>
	<?php } ?>
</ul>
<?php if(!$list_cnt) { ?>
	<p class="text-muted text-center">글이 없습니다.</p>
<?php } ?>