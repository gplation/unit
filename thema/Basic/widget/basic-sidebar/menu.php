<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
?>
<!-- user.php와 합체 -->
<div class="sidebar-login">
	<?php if($is_member) { //Login ?>
		<div class="profile">
			<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo" title="사진등록">
				<div class="photo pull-left">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user-plus"></i>'; //사진 ?>
				</div>
			</a>
			<h3><?php echo $member['mb_nick'];?></h3>
			<div class="font-12 text-muted" style="letter-spacing:-1px;">
				<?php echo $member['grade'];?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="progress progress-striped sidebar-tip cursor" style="height:10px; margin:10px 0px 0px;" data-original-title="레벨업까지 <?php echo number_format($member['exp_up']);?>점 남았습니다." data-toggle="tooltip" data-html="true">
			<div class="progress-bar progress-bar-blue" style="width: <?php echo round($member['exp_per']);?>%;"></div>
		</div>

		<div class="font-12" style="padding:5px 0px 8px;">
			<span class="pull-right">
				Exp <?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)
			</span>
			레벨 <?php echo $member['level'];?> 
		</div>

		<div class="btn-group btn-group-justified" role="group">
			<?php if($member['admin']) { ?>
				<a href="<?php echo G5_ADMIN_URL;?>" class="btn btn-navy btn-sm">관리자</a>
			<?php } ?>
			<?php if($member['partner']) { ?>
				<a href="<?php echo $at_href['myshop'];?>" class="btn btn-navy btn-sm">마이샵</a>
			<?php } ?>
			<a href="<?php echo $at_href['logout'];?>" class="btn btn-navy btn-sm">나가기</a>
		</div>
		
		<div class="h15"></div>

		<!-- Service -->
		<div class="div-title-underline-thin en">
			<b>MY MENU</b>
		</div>

		<ul class="sidebar-list list-links">
			<li>
				<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point no-fa">
					<span class="pull-right"><?php echo number_format($member['mb_point']);?> 점</span>
					<?php echo AS_MP;?>
				</a>
			</li>
			<?php if($member['as_date']) { // 기간제 회원 ?>
				<li>
					<a class="no-fa">
						<span class="pull-right">
							<?php echo date("Y.m.d H:i", $member['as_date']);?>
							(<?php echo number_format(($member['as_date'] - G5_SERVER_TIME) / 86400);?>일)
						</span>
						프리미엄
					</a>		
				</li>
			<?php } ?>
			<li>
				<?php if ($member['response']) { ?>
					<a href="#" onclick="sidebar_open('sidebar-response'); return false;" class="no-fa">
						<span class="pull-right"><?php echo number_format($member['response']);?> 건</span>
				<?php } else { ?>
					<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
				<?php } ?>
					내글반응
				</a>		
			</li>
			<li>
				<?php if ($member['memo']) { ?>
					<a href="#" onclick="sidebar_open('sidebar-response'); return false;" class="no-fa">
						<span class="pull-right"><?php echo number_format($member['memo']);?> 개</span>
				<?php } else { ?>
					<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
				<?php } ?>
					쪽지함
				</a>		
			</li>
<!-- 
			<li>
				<a href="<?php echo $at_href['follow'];?>" target="_blank" class="win_memo">
					팔로우
				</a>		
			</li>
			<li>
				<a href="<?php echo $at_href['scrap'];?>" target="_blank" class="win_scrap">
					스크랩
				</a>		
			</li>
 -->
			<?php if(IS_YC) { //영카트 ?>
<!-- 
				<li>
					<?php if ($member['as_coupon']) { ?>
						<a href="<?php echo $at_href['coupon']; ?>" target="_blank" class="win_point no-fa">
							<span class="pull-right"><?php echo number_format($member['as_coupon']);?> 장</span>
					<?php } else { ?>
						<a href="<?php echo $at_href['coupon']; ?>" target="_blank" class="win_point">
					<?php } ?>
						마이쿠폰
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['shopping']; ?>" target="_blank" class="win_memo">
						쇼핑리스트
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['wishlist']; ?>">
						위시리스트
					</a>
				</li>
 -->
			<?php } ?>
			<li>
				<a href="<?php echo $at_href['mypage']; ?>">
					마이페이지
				</a>
			</li>
			<li>
				<a href="<?php echo $at_href['mypost']; ?>" target="_blank" class="win_memo">
					내글관리
				</a>
			</li>
			<!-- 
			<li>
				<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo">
					사진등록
				</a>
			</li>
			 -->
			<li>
				<a href="<?php echo $at_href['edit'];?>">
					정보수정
				</a>
			</li>
<!-- 
			<li>
				<a href="<?php echo $at_href['leave'];?>" class="leave-me">
					탈퇴하기
				</a>
			</li>
 -->
		</ul>

	<?php } else { //Logout ?>

		<form id="sidebar_login_form" name="sidebar_login_form" method="post" action="<?php echo $at_href['login_check'];?>" autocomplete="off" role="form" class="form" onsubmit="return sidebar_login(this);">
		<input type="hidden" name="url" value="<?php echo $urlencode; ?>">
			<div class="form-group">	
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user gray"></i></span>
					<input type="text" name="mb_id" id="mb_id" class="form-control input-sm" placeholder="아이디" tabindex="91">
				</div>
			</div>
			<div class="form-group">	
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock gray"></i></span>
					<input type="password" name="mb_password" id="mb_password" class="form-control input-sm" placeholder="비밀번호" tabindex="92">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-navy btn-block" tabindex="93">Login</button>    
			</div>	

			<label class="text-muted" style="letter-spacing:-1px;">
				<input type="checkbox" name="auto_login" value="1" id="remember_me" class="remember-me" tabindex="94">
				자동로그인 및 로그인 상태 유지
			</label>
		</form>

		<div class="h10"></div>

		<?php if($sns_login_icon) { // 소셜로그인 ?>
			<!-- SNS Login -->
			<div class="div-title-underline-thin en">
				<b>SNS LOGIN</b>
			</div>
			<div class="sidebar-sns-login">
				<?php echo $sns_login_icon; ?>
				<div class="clearfix"></div>
			</div>
			<div class="h20"></div>
		<?php } ?>

		<!-- Member -->
		<div class="div-title-underline-thin en">
			<b>MEMBER</b>
		</div>
		<ul class="sidebar-list list-links">
			<li><a href="<?php echo $at_href['reg'];?>">회원가입</a></li>
			<li><a href="<?php echo $at_href['lost'];?>" class="win_password_lost">아이디/비밀번호 찾기</a></li>
		</ul>
	<?php } //End ?>
</div>
<!-- user.php와 합체 끄읕-->
<!-- 
<div class="sidebar-icon-tbl">
	<div class="sidebar-icon-cell">
		<a href="<?php echo $at_href['home']; ?>">
			<i class="fa fa-home circle light-circle normal"></i>
			<span>홈으로</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_event;?>">
			<i class="fa fa-gift circle light-circle normal"></i>
			<span>이벤트</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_chulsuk;?>">
			<i class="fa fa-calendar-check-o circle light-circle normal"></i>
			<span>출석부</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo $at_href['secret'];?>">
			<i class="fa fa-commenting circle light-circle normal"></i>
			<span>1:1 문의</span>
		</a>
	</div>
</div>
 -->
<!-- Categroy -->
		<div class="h15"></div>
<div class="div-title-underline-thin en">
	<b>MENU</b>
</div>
<div class="sidebar-menu panel-group" id="<?php echo $menu_id;?>" role="tablist" aria-multiselectable="true">
	<?php 
		for($i=1; $i < $menu_cnt; $i++) { 
			$cate_id = $menu_id.'_c'.$i;
			$sub_id = $menu_id.'_s'.$i;
	?>
		<?php if($menu[$i]['is_sub']) { //서브메뉴가 있을 때 ?>
			<div class="panel">
				<div class="ca-head<?php echo ($menu[$i]['on'] == "on") ? ' active' : '';?>" role="tab" id="<?php echo $cate_id;?>">
					<a href="#<?php echo $sub_id;?>" data-toggle="collapse" data-parent="#<?php echo $menu_id;?>" aria-expanded="true" aria-controls="<?php echo $sub_id;?>" class="is-sub">
						<span class="ca-href pull-right" onclick="sidebar_href('<?php echo $menu[$i]['href']; ?>');">&nbsp;</span>
						<?php echo $menu[$i]['name']; ?>
						<?php echo ($menu[$i]['new'] == "new") ? $menu_new : '';?>
					</a>
				</div>
				<div id="<?php echo $sub_id;?>" class="panel-collapse collapse<?php echo ($menu[$i]['on'] == "on") ? ' in' : '';?>" role="tabpanel" aria-labelledby="<?php echo $cate_id;?>">
					<ul class="ca-sub">
					<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
						<?php if($menu[$i]['sub'][$j]['line']) { //구분라인 ?>
							<li class="ca-line">
								<?php echo $menu[$i]['sub'][$j]['line'];?>
							</li>
						<?php } ?>
						<li<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' class="on"' : '';?>>
							<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
								<?php echo $menu[$i]['sub'][$j]['name']; ?>
								<?php echo ($menu[$i]['sub'][$j]['new'] == "new") ? $menu_new : '';?>
							</a>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
		<?php } else { ?>
			<div class="panel">
				<div class="ca-head<?php echo ($menu[$i]['on'] == "on") ? ' active' : '';?>" role="tab">
					<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?> class="no-sub">
						<?php echo $menu[$i]['name'];?>
						<?php echo ($menu[$i]['new'] == "new") ? $menu_new : '';?>
					</a>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</div>





<div class="h20"></div>

<!-- Stats -->
<div class="div-title-underline-thin en">
	<b>STATS</b>
</div>

<ul style="padding:0px 15px; margin:0; list-style:none;">
	<li><a href="<?php echo $at_href['connect'];?>">
		<span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b class="orangered">'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span>현재 접속자</a>
	</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span>오늘 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_yesterday']); ?> 명</span>어제 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_max']); ?> 명</span>최대 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span>전체 방문자</li>
	<li><span class="pull-right"><?php echo number_format($menu[0]['count_write']); ?> 개</span>전체 게시물</li>
	<li><span class="pull-right"><?php echo number_format($menu[0]['count_comment']); ?> 개</span>전체 댓글수</li>
	<li><span class="pull-right sidebar-tip" data-original-title="<nobr>오늘 <?php echo $stats['join_today'];?> 명 / 어제 <?php echo $stats['join_yesterday'];?> 명</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($stats['join_total']); ?> 명</span>전체 회원수
	</li>
</ul>
