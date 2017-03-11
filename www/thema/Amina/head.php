<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(THEMA_PATH.'/assets/thema.php');
?>

<!-- Hidden Sidebar -->
<aside id="asideMenu" class="at-sidebar sidebar">
	<?php echo apms_widget('amina-widget-sidebar');?>
</aside>
<div class="wrapper <?php echo $at_set['layout'];?> <?php echo $at_set['font'];?><?php echo (G5_IS_MOBILE) ? ' font-14' : ''; //Mobile 14px?>">
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
						<?php if($is_member) { ?>
							<li class="asideButton cursor"><a><i class="fa fa-user"></i><?php echo $member['mb_nick'];?></a></li>
							<?php if($member['response']) { ?>
								<li>
									<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
										<i class="fa fa-retweet"></i>반응 <span class="count"><?php echo number_format($member['response']);?></span>
									</a>
								</li>
							<?php } ?>
							<?php if($member['memo']) { ?>
								<li>
									<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
										<i class="fa fa-envelope-o"></i>쪽지 <span class="count"><?php echo number_format($member['memo']);?></span>
									</a>
								</li>
							<?php } ?>
							<?php if($member['admin']) {?>
								<li><a href="<?php echo G5_ADMIN_URL;?>"><i class="fa fa-cog"></i>관리</a></li>
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
						<li class="hidden-xs"><a href="<?php echo $at_href['connect'];?>"><i class="fa fa-comments" title="현재 접속자"></i><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<span class="count">'.number_format($stats['now_mb']).'</span>)' : ''; ?></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</aside>

	<header>
		<!-- Logo -->
		<div class="at-header">
			<div class="container">
				<div class="header-logo text-center pull-left">
					<a href="http://unit.kr/">
						<img src="http://unit1987.cafe24.com/img/bottom.png" border=0>
					</a>
					<div class="header-desc">
						대학연합레져스포츠동아리 - UNIT
					</div>
				</div>

<!-- 검색 및 뉴스티커 제거 - 신재훈

				<div class="header-search pull-left">
					<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
						<div class="input-group input-group-sm">
							<input type="text" name="stx" class="form-control input-sm" value="<?php echo $stx;?>">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-black"><i class="fa fa-search fa-lg"></i></button>
							</span>
						</div>
					</form>
					<script>
						function tsearch_submit(f) {

							if (f.stx.value.length < 2) {
								alert("검색어는 두글자 이상 입력하십시오.");
								f.stx.select();
								f.stx.focus();
								return false;
							}

							f.action = "<?php echo G5_BBS_URL;?>/search.php";

							return true;
						}
					</script>
					

					<!-- 모바일에서는 안보이도록 수정
					<?php if(!G5_IS_MOBILE) { ?>
					<?php echo apms_widget('amina-widget-newsticker', 'amina-widget-newsticker1'); // 뉴스티커 ?>
					<?php } ?>

				</div>

검색 및 뉴스티커 제거 - 신재훈 END -->

<!-- 구글 광고 -->
				<div class="pull-right visible-lg">
					<div style="width:486px; height:60px; line-height:60px; text-align:center; background:#f5f5f5;">
					<script type="text/javascript">
						google_ad_client = "ca-pub-2562502091444002";
						google_ad_slot = "6023234809";
						google_ad_width = 468;
						google_ad_height = 60;
					</script>
					<!-- 468*60 unit_kr -->
					<script type="text/javascript"
					src="//pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>						
					</div>
				</div>

<!-- 상단 배너추가 - 신재훈 -->
				<?php if(!G5_IS_MOBILE) { ?>
				<div class="pull-right">

		<!--명동커피 배너 삭제
				<a href="http://unit1987.cafe24.com/bbs/board.php?bo_table=sponsor&wr_id=6" target=_blank><img src="http://unit1987.cafe24.com/img/myungdong-cafe.gif" height=60 border=0></a>
				-->
		<!--초코블라썸 배너 삭제
				<a href="http://unit1987.cafe24.com/bbs/board.php?bo_table=sponsor&wr_id=3" target=_blank><img src="http://unit1987.cafe24.com/img/choco_blossom.gif" height=60 border=0></a>
				-->
		<!--페이스북 배너-->
				<a href="http://www.facebook.com/clubunit" target=_blank><img src="http://unit1987.cafe24.com/img/banner1.jpg" height=60 border=0></a>&nbsp
		<!--싸이월드 배너-->
				<a href="http://club.cyworld.com/unit1987" target=_blank><img src="http://unit1987.cafe24.com/img/banner2.png" height=60 border=0></a>
				</div>
				<?php } ?>
<!-- 상단 배너추가 - 신재훈 -->

				<div class="clearfix"></div>
			</div>
		</div>

		<div class="navbar <?php echo $at_set['menu'];?> at-navbar" role="navigation">

			<div class="text-center navbar-toggle-box">
				<button type="button" class="navbar-toggle btn btn-dark pull-left" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i> Menu
				</button>

				<div class="pull-right">\
					<!-- 모바일에서는 안보이도록 수정-->
					<?php if(!G5_IS_MOBILE) { ?>
						<?php if(IS_YC) { // 영카트 이용시 ?>
							<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
								<a href="<?php echo G5_URL;?>" class="navbar-toggle btn btn-dark">
									<i class="fa fa-users"></i>
								</a>
							<?php } else { // 커뮤니티일 때 ?>
								<a href="<?php echo G5_SHOP_URL;?>" class="navbar-toggle btn btn-dark">
									<i class="fa fa-shopping-cart"></i>
								</a>
							<?php } ?>
						<?php } ?>	
					<?php } ?>	
					<button type="button" class="navbar-toggle btn btn-dark asideButton">
						<i class="fa fa-outdent"></i>
					</button>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="container">

				<!-- Right Menu -->
				<div class="hidden-xs pull-right navbar-menu-right">

					<!--영카트 삭제
					<?php if(IS_YC) { // 영카트 이용시 ?>
						<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
							<a href="<?php echo G5_URL;?>" class="hidden-xs btn btn-dark at-tip" data-original-title="<nobr>커뮤니티로 이동</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
								<i class="fa fa-users"></i>
							</a>
						<?php } else { // 커뮤니티일 때 ?>
							<a href="<?php echo G5_SHOP_URL;?>" class="hidden-xs btn btn-dark at-tip" data-original-title="<nobr>쇼핑몰로 이동</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
								<i class="fa fa-shopping-cart"></i>
							</a>
						<?php } ?>
					<?php } ?>
					영카트 삭제-->

					<a href="#" class="btn btn-dark asideButton">
						<i class="fa fa-outdent"></i>
					</a>
				</div>
				


				<!-- Left Menu -->
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
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
										<?php if(!G5_IS_MOBILE && $menu[$i]['sub'][$j]['is_sub']) { //모바일이 아니고 서브메뉴가 있을 때 ?>
											<li class="dropdown-submenu<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' sub-on' : ' sub-off';?>">
												<a tabindex="-1" href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
													<?php echo $menu[$i]['sub'][$j]['name'];?><i class="fa fa-circle sub-<?php echo $menu[$i]['sub'][$j]['new'];?>"></i>
													<i class="fa fa-caret-right sub-caret pull-right"></i>
												</a>
												<ul class="dropdown-menu dropdown-menu-sub">
												<?php for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { ?>
													<li class="<?php echo ($menu[$i]['sub'][$j]['sub'][$k]['on'] == "on") ? 'sub-on' : 'sub-off';?>">
														<a tabindex="-1" href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>><?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?></a>
													</li>
												<?php } ?>
												</ul>
											</li>
										<?php } else { //서브메뉴가 없을 때 ?>
											<li class="<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? 'sub-on' : 'sub-off';?>">
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
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="navbar-menu-bar"></div>
		</div>
	</header>

	<?php if($page_title) { // 페이지 타이틀 ?>
		<div class="page-title">
			<div class="container">
				<h2><?php echo ($bo_table) ? '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'"><span>'.$page_title.'</span></a>' : $page_title;?></h2>
				<?php if($page_desc) { // 페이지 설명글 ?>
					<ol class="breadcrumb hidden-xs">
						<li class="active"><?php echo $page_desc;?></li>
					</ol>
				<?php } ?>
			</div>
		</div>
	<?php } ?>

	<div class="at-content">
		<?php if($col_name) { ?>
			<div class="container">
			<?php if($col_name == "two") { ?>
				<div class="row">
					<div class="col-md-<?php echo $col_content;?><?php echo ($at_set['side']) ? ' pull-right' : '';?> contentArea">		
			<?php } ?>
		<?php } ?>
