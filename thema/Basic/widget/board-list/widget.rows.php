<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 글추출
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = apms_fa($wset['icon']);

// 랭킹시작
$rank = ($wset['page'] > 1) ?  (($wset['page'] - 1) * $wset['rows'] + 1) : 1;

?>

<ul>
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<li>
			<a href="<?php echo $list[$i]['href'];?>">
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
			</a> 
		</li>
	<?php } ?>
</ul>
<?php if(!$list_cnt) { ?>
	<p class="text-muted text-center">글이 없습니다.</p>
<?php } ?>