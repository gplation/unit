<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

global $menu;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

$accordion_id = apms_id();

?>
<div class="panel-group widget-misc-category" id="<?php echo $accordion_id;?>" role="tablist" aria-multiselectable="true">
	<?php  
		$m = 1; //메뉴 카운팅
		$is_on = false;
		for ($i=1; $i < count($menu); $i++) {
			if($menu[$i]['on'] == "on" && $menu[$i]['is_sub']) {
				for($j=0; $j < count($menu[$i]['sub']); $j++) {
					if($menu[$i]['sub'][$j]['on'] == 'on' && $menu[$i]['sub'][$j]['is_sub']) { //현재 선택메뉴이고 서브메뉴가 있으면 출력
						$is_on = true;

	?>
			<div class="panel panel-default">
				<div class="panel-heading" id="<?php echo $accordion_id;?>H<?php echo $m;?>" role="tab">
					<h4 class="panel-title font-13">
						<a aria-expanded="true" data-parent="#<?php echo $accordion_id;?>" aria-controls="<?php echo $accordion_id;?>G<?php echo $m;?>" href="#<?php echo $accordion_id;?>G<?php echo $m;?>" data-toggle="collapse">
							<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
								<i class="fa fa-circle red pull-right new-icon"></i>
							<?php } ?>
							<b><?php echo $menu[$i]['sub'][$j]['name'];?></b>
						</a>
					</h4>
				</div>
				<div class="list-group panel-collapse collapse in" id="<?php echo $accordion_id;?>G<?php echo $m;?>" role="tabpanel" aria-expanded="true" aria-labelledby="<?php echo $accordion_id;?>H<?php echo $m;?>">
					<?php for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { ?>
						<a class="list-group-item" href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>>
							<?php if($menu[$i]['sub'][$j]['sub'][$k]['on'] == 'on') { // 현재위치 표시 ?>
								<b><?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?></b>
								<i class="fa fa-spinner fa-spin red"></i>
							<?php } else { ?>
								<?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?>
							<?php } ?>
							<?php if($menu[$i]['sub'][$j]['sub'][$k]['new'] == "new") { ?>
								<i class="fa fa-circle red pull-right new-icon"></i>
							<?php } ?>
						</a>
					<?php } ?>
				</div>
			</div>

	<?php $m++;
					}
				} 
			} 
		} 
	?>

	<?php  for ($i=1; $i < count($menu); $i++) { //전체 메뉴출력 ?>
		<div class="panel panel-default">
			<div class="panel-heading <?php echo $menu[$i]['new'];?>" id="<?php echo $accordion_id;?>H<?php echo $m;?>" role="tab">
				<h4 class="panel-title font-13">
					<?php if($menu[$i]['is_sub']) { //서브메뉴 있으면 ?>
						<a aria-expanded="true" data-parent="#<?php echo $accordion_id;?>" aria-controls="<?php echo $accordion_id;?>G<?php echo $m;?>" href="#<?php echo $accordion_id;?>G<?php echo $m;?>" data-toggle="collapse">
					<?php } else { ?>
						<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
					<?php } ?>
						<?php if($menu[$i]['on'] == 'on') { // 현재위치 표시 ?>
							<b><?php echo $menu[$i]['name'];?></b>
							<i class="fa fa-spinner fa-spin red"></i>
						<?php } else { ?>
							<?php echo $menu[$i]['name'];?>
						<?php } ?>
						<?php if($menu[$i]['new'] == "new") { ?>
							<i class="fa fa-circle red pull-right new-icon"></i>
						<?php } ?>
					</a>
				</h4>
			</div>
			<?php if($menu[$i]['is_sub']) { //서브메뉴 있으면 ?>
				<div class="list-group panel-collapse collapse<?php echo (!$is_on && $menu[$i]['on'] == 'on') ? ' in' : '';?>" id="<?php echo $accordion_id;?>G<?php echo $m;?>" role="tabpanel" aria-expanded="true" aria-labelledby="<?php echo $accordion_id;?>H<?php echo $m;?>">
					<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
						<a class="list-group-item" href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
							<?php if($menu[$i]['sub'][$j]['on'] == 'on') { // 현재위치 표시 ?>
								<b><?php echo $menu[$i]['sub'][$j]['name'];?></b>
								<i class="fa fa-spinner fa-spin red"></i>
							<?php } else { ?>
								<?php echo $menu[$i]['sub'][$j]['name'];?>
							<?php } ?>
							<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
								<i class="fa fa-circle red pull-right new-icon"></i>
							<?php } ?>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	<?php $m++; } ?>
</div>
