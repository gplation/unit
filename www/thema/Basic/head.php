<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
@include_once(THEMA_PATH.'/assets/thema.php');
?>

<div class="wrapper <?php echo $at_set['layout'];?> <?php echo $at_set['font'];?><?php echo (G5_IS_MOBILE) ? ' font-14' : ''; //Mobile 14px?>">

	<!-- Hidden Sidebar -->
	<aside id="asideMenu" class="at-sidebar sidebar">
		<?php echo apms_widget('misc-sidebar'); // 사이드바 위젯 ?>
	</aside>

	<!-- LNB -->
	<aside>
		<div class="<?php echo $at_set['lnb'];?> at-lnb">
			<div class="container">
				<nav class="at-lnb-icon hidden-xs">
					<ul class="menu">
						<li>
							<a href="javascript://" onclick="this.style.behavior = 'url(#default#homepage)'; this.setHomePage('<?php echo $at_href['home'];?>');" class="at-tip" data-original-title="<nobr>시작페이지</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
								<i class="fa fa-bug fa-lg"></i><span class="sound_only">시작페이지</span>
							</a>
						</li>
						<li>
							<a href="javascript://" onclick="window.external.AddFavorite(parent.location.href,document.title);" class="at-tip" data-original-title="<nobr>북마크</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
								<i class="fa fa-bookmark-o fa-lg"></i><span class="sound_only">북마크</span>
							</a>
						</li>
						<li>
							<a href="<?php echo $at_href['rss'];?>" target="_blank" data-original-title="<nobr>RSS 구독</nobr>" class="at-tip" data-toggle="tooltip" data-placement="bottom" data-html="true">
								<i class="fa fa-rss fa-lg"></i><span class="sound_only">RSS 구독</span>
							</a>
						</li>
					</ul>
				</nav>

				<nav class="at-lnb-menu">
					<ul class="menu">
						<?php if($is_member) { $alarm_cnt = $member['response'] + $member['memo']; ?>
							<li class="asideButton cursor"><a><i class="fa fa-user"></i><?php echo $member['mb_nick'];?><?php echo ($alarm_cnt > 0) ? ' <span class="count">('.$alarm_cnt.')</span>' : '';?></a></li>
							<?php if($member['admin']) {?>
								<li><a href="<?php echo G5_ADMIN_URL;?>"><i class="fa fa-cog"></i>관리자</a></li>
							<?php } ?>
							<li>
								<a href="<?php echo $at_href['logout'];?>">
									<i class="fa fa-power-off"></i><span class="hidden-xs">로그아웃</span>
								</a>
							</li>
						<?php } else { ?>
							<li  class="asideButton cursor"><a><i class="fa fa-power-off"></i>로그인</a></li>
							<li><a href="<?php echo $at_href['reg'];?>"><i class="fa fa-sign-in"></i><span class="hidden-xs">회원</span>가입</a></li>
							<li><a href="<?php echo $at_href['lost'];?>" class="win_password_lost"><i class="fa fa-search"></i>정보찾기</a></li>
						<?php } ?>
						<li class="hidden-xs"><a href="<?php echo $at_href['connect'];?>"><i class="fa fa-comments" title="현재 접속자"></i><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<span class="count">'.number_format($stats['now_mb']).'</span>)' : ''; ?> 명</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</aside>

	<header>
		<div class="navbar <?php echo $at_set['menu'];?> at-navbar en" role="navigation">
			<div class="container">
				<div class="navbar-header">

					<!-- Logo -->
					<a class="navbar-logo" href="<?php echo $at_href['home'];?>">
						<b>AMINA</b>
						<span class="hidden-xs">세상을 바꾸는 작은 힘 - 아미나</span>
					</a>

					<div class="navbar-btn btn-group pull-right">
						<button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target=".navbar-collapse">
							<i class="fa fa-bars fa-2x"></i>
						</button>
						<?php if(IS_YC) { // 영카트 이용시 ?>
							<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
								<a href="<?php echo G5_URL;?>" role="button" class="btn btn-default btn-xs">
									<span class="blue"><i class="fa fa-coffee fa-2x"></i></span>
								</a>
							<?php } else { // 커뮤니티일 때 ?>
								<a href="<?php echo G5_SHOP_URL;?>" role="button" class="btn btn-default btn-xs">
									<span class="red"><i class="fa fa-shopping-cart fa-2x"></i></span>
								</a>
							<?php } ?>
						<?php } ?>			
						<button type="button" class="btn btn-default btn-xs navbar-toggle-asideMenu asideButton">
							<i class="fa fa-outdent fa-2x"></i>
						</button>
					</div>
					<div class="clearfix"></div>
				</div>

				<!-- Menu -->
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li<?php echo ($is_main && !$gid) ? ' class="active"' : '';?>>
							<a href="<?php echo $at_href['home'];?>">메인</a>
						</li>
						<?php for ($i=1; $i < count($menu); $i++) { //메뉴출력 - 1번부터 출력?>
							<?php if($menu[$i]['is_sub']) { //서브메뉴가 있을 때 ?>
								<li class="dropdown<?php echo ($menu[$i]['on'] == "on") ? ' active' : '';?>">
									<a href="<?php echo $menu[$i]['href'];?>" class="dropdown-toggle" <?php echo(G5_IS_MOBILE) ? 'data-toggle="dropdown"' : 'data-hover="dropdown"';?> data-close-others="true"<?php echo $menu[$i]['target'];?>>
										<?php echo $menu[$i]['name'];?><i class="fa fa-circle <?php echo $menu[$i]['new'];?>"></i>
									</a>
									<ul class="dropdown-menu">
									<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
										<?php if(!G5_IS_MOBILE && $menu[$i]['sub'][$j]['is_sub']) { //서브메뉴가 있을 때 ?>
											<li class="dropdown-submenu<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' sub-on' : '';?>">
												<a tabindex="-1" href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
													<span class="pull-right lightgray"><i class="fa fa-caret-right"></i></span>
													<?php echo $menu[$i]['sub'][$j]['name'];?><i class="fa fa-circle sub-<?php echo $menu[$i]['sub'][$j]['new'];?>"></i>
												</a>
												<ul class="dropdown-menu dropdown-menu-sub">
												<?php for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { ?>
													<li<?php echo ($menu[$i]['sub'][$j]['sub'][$k]['on'] == "on") ? ' class="sub-on"' : '';?>>
														<a tabindex="-1" href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>><?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?></a>
													</li>
												<?php } ?>
												</ul>
											</li>
										<?php } else { //서브메뉴가 없을 때 ?>
											<li<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' class="sub-on"' : '';?>>
												<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
													<?php echo $menu[$i]['sub'][$j]['name'];?><i class="fa fa-circle <?php echo $menu[$i]['sub'][$j]['new'];?>"></i>
												</a>
											</li>
										<?php } ?>
									<?php } ?>
									</ul>
								</li>
							<?php } else { //서브메뉴가 없을 때 ?>
								<li<?php echo ($menu[$i]['on'] == "on") ? ' class="active"' : '';?>>
									<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
										<?php echo $menu[$i]['name'];?><i class="fa fa-circle <?php echo $menu[$i]['new'];?>"></i>
									</a>
								</li>
							<?php } ?>
						<?php } //자동메뉴 ?>
						<?php if(IS_YC) { // 영카트 이용시 ?>
							<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
								<li class="hidden-xs at-tip" data-original-title="<nobr>커뮤니티로 이동</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
									<a href="<?php echo G5_URL;?>">
										<i class="fa fa-coffee fa-lg blue"></i>
									</a>
								</li>
							<?php } else { // 커뮤니티일 때 ?>
								<li class="hidden-xs at-tip" data-original-title="<nobr>쇼핑몰로 이동</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
									<a href="<?php echo G5_SHOP_URL;?>">
										<i class="fa fa-shopping-cart fa-lg red"></i>
									</a>
								</li>
							<?php } ?>
						<?php } ?>	
						<li class="hidden-xs at-tip asideButton" data-original-title="<nobr>Open Sidebar</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
							<a href="#" class="dropdown-toggle dropdown-form-toggle">
								<i class="fa fa-outdent fa-lg"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<?php if(!$is_main && $page_title) { // 페이지 타이틀 ?>
		<div class="page-title">
			<div class="container">
				<h2><?php echo $page_title;?></h2>
				<ol class="breadcrumb hidden-xs">
					<li class="active"><?php echo $page_desc;?></li>
				</ol>
			</div>
		</div>
	<?php } else if($is_main) { 
			if(IS_YC && IS_SHOP) {
				echo apms_widget('misc-title', 'idx-shop-title1'); // 쇼핑몰 타이틀 위젯
			} else {
				echo apms_widget('misc-title', 'idx-title1'); // 커뮤니티 타이틀 위젯
			}
		} 
	?>

	<div class="at-content">
		<?php if($col_name) { ?>
			<div class="container">
			<?php if($col_name == "two") { ?>
				<div class="row">
					<div class="col-md-<?php echo $col_content;?><?php echo ($at_set['side']) ? ' pull-right' : '';?> contentArea">		
			<?php } ?>
		<?php } ?>

