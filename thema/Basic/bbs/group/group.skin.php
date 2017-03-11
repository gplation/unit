<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 보드추출
$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
$sql = " select bo_table, bo_subject from {$g5[board_table]} where gr_id = '{$gr_id}' and bo_list_level <= '{$member[mb_level]}' and bo_device <> '{$bo_device}' ";
if(!$is_admin) $sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
?>

<div class="container wrap-group">
	<div class="row">
	<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
		<?php if($i > 0 && $i%3 == 0) { ?>
				</div>
			<div class="row">
		<?php } ?>
		<div class="col-sm-4">
			<?php echo apms_group_list($row['bo_table'], 5, 70); ?>
		</div>
	<?php } ?>
	</div>
</div>
