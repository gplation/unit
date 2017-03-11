<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//필요한 전역변수 선언
global $menu;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

?>
<?php  //Side Category
	for ($i=1; $i < count($menu); $i++) {
		if($menu[$i]['on'] == "on" && $menu[$i]['is_sub']) {
?>
	<div class="amina-widget-category">
		<div class="widget-head"><?php echo $menu[$i]['name'];?></div>
		<div class="widget-body">
			<ul class="highlight">
				<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
					<li>
						<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
							<span class="<?php echo $menu[$i]['sub'][$j]['on'];?>">
								<?php echo $menu[$i]['sub'][$j]['name'];?><i class="fa fa-circle <?php echo $menu[$i]['sub'][$j]['new'];?>"></i>
							</span>
						</a>
					</li>
					<?php if($menu[$i]['sub'][$j]['on'] == 'on') { // 선택메뉴이면 서브 출력 ?>
						<?php for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { ?>
							<li class="sub">
								<a href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>>
									<span class="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['on'];?>">
										<i class="fa fa-caret-right"></i> <?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?>
									</span>
								</a>
							</li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php } } ?>