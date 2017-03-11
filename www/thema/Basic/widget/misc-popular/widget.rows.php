<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 검색어추출
$list = apms_popular_rows($wset);
$list_cnt = count($list);

// 검색어섞기
if($list_cnt > 0 && $wset['rdm']) {
	shuffle($list);
}

?>

<ul>
<?php for ($i=0; $i < $list_cnt; $i++) { ?>
	<li>
		<a href="<?php echo $list[$i]['href'];?>" class="over-color">
			<i class="fa fa-tags"></i>
			<?php echo $list[$i]['word'];?>
		</a>
	</li>
<?php } ?>
</ul>

<?php if(!$list_cnt) { ?>
	<p class="text-muted text-center">등록된 검색어가 없습니다.</p>
<?php } ?>