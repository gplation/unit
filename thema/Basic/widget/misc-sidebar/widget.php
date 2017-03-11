<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//필요한 전역변수 선언
global $member, $is_member, $at_href, $urlencode;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

?>

<div class="en">
	<div class="close-box">
		<button class="btn btn-close asideButton" type="button" title="Hide sidebar"><i class="fa fa-times"></i></button>
	</div>

	<?php if($is_member) { //Login ?>
		<div class="profile-box">
			<div class="profile">
				<div class="profile-photo pull-left">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; //사진 ?>
				</div>
				<h3><?php echo $member['mb_nick'];?></h3>
				<p><?php echo $member['grade'];?></p>
				<div class="clearfix"></div>
			</div>

			<?php if($member['admin'] || $member['partner']) { ?>
				<div class="btn-group btn-group-justified">
					<?php if(IS_YC && $member['partner']) { ?>
						<a href="<?php echo $at_href['myshop'];?>" class="btn btn-upload btn-sm"><i class="fa fa-shopping-cart"></i> 마이샵</a>
					<?php } ?>
					<?php if($member['admin']) { ?>
						<a href="<?php echo G5_ADMIN_URL;?>" class="btn btn-admin btn-sm"><i class="fa fa-cog"></i> 관리자</a>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="at-tip" data-original-title="<?php echo number_format($member['exp_up']);?>점 추가획득시 레벨업합니다." data-toggle="tooltip" data-placement="top" data-html="true" style="padding:15px 0px;">
				<div class="progress progress-striped" style="margin:0px; background: #444;">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%;">
						<span class="sr-only">
							Lv.<?php echo $member['level'];?>
						</span>
					</div>
				</div>
				<div class="sr-score pull-right" style="color:#fff; margin-top:-28px;"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</div>
			</div>
		</div>

		<h5 class="sidebar-title">My Menu</h5>
		<div class="sidebar-nav">
			<ul>
				<li>
					<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point">
						<span class="badge bg-blue pull-right"><?php echo number_format($member['mb_point']);?></span>
						<i class="fa fa-gift"></i> <?php echo AS_MP;?>
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
						<?php if ($member['response']) { ?>
							<span class="badge bg-violet pull-right"><?php echo number_format($member['response']);?></span>
						<?php } ?>
						<i class="fa fa-retweet"></i> 내글반응
					</a>		
				</li>
				<li>
					<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
						<?php if ($member['memo']) { ?>
							<span class="badge bg-green pull-right"><?php echo number_format($member['memo']);?></span>
						<?php } ?>
						<i class="fa fa-envelope-o"></i> 쪽지함
					</a>		
				</li>
				<li>
					<a href="<?php echo $at_href['follow'];?>" target="_blank" class="win_memo">
						<i class="fa fa-users"></i> 팔로우
					</a>		
				</li>
				<li>
					<a href="<?php echo $at_href['scrap'];?>" target="_blank" class="win_scrap">
						<i class="fa fa-inbox"></i> 스크랩
					</a>		
				</li>
				<?php if(IS_YC) { //영카트 ?>
					<li>
						<a href="<?php echo $at_href['coupon']; ?>" target="_blank" class="win_point">
							<i class="fa fa-book"></i> 마이쿠폰
						</a>
					</li>
					<li>
						<a href="<?php echo $at_href['shopping']; ?>" target="_blank" class="win_memo">
							<i class="fa fa-shopping-cart"></i> 쇼핑리스트
						</a>
					</li>
					<li>
						<a href="<?php echo $at_href['wishlist']; ?>">
							<i class="fa fa-heart"></i> 위시리스트
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="<?php echo $at_href['mypage']; ?>">
						<i class="fa fa-user"></i> 마이페이지
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['mypost']; ?>" target="_blank" class="win_memo">
						<i class="fa fa-pencil"></i> 내글관리
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo">
						<i class="fa fa-camera"></i> 사진등록
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['edit'];?>">
						<i class="fa fa-pencil"></i> 정보수정
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['leave'];?>" class="leave-me">
						<i class="fa fa-sign-out"></i> 탈퇴하기
					</a>
				</li>
			</ul>

			<div style="padding:15px 20px 0px;">
				<a href="<?php echo $at_href['logout'];?>" class="btn btn-color btn-block btn-sm">
					<i class="fa fa-power-off"></i> Logout
				</a>
			</div>
		</div>

	<?php } else { //Logout ?>

		<div class="sidebar-box">
			<form name="loginbox" method="post" action="<?php echo $at_href['login_check'];?>" autocomplete="off" role="form" class="form">
			<input type="hidden" name="url" value="<?php echo $urlencode; ?>">
				<div class="form-group">	
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user gray"></i></span>
						<input type="text" name="mb_id" id="mb_id" class="form-control input-sm" required placeholder="아이디">
					</div>
				</div>
				<div class="form-group">	
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock gray"></i></span>
						<input type="password" name="mb_password" id="mb_password" class="form-control input-sm" required placeholder="비밀번호">
					</div>
				</div>	
				<div class="form-group">
					<button type="submit" class="btn btn-color btn-block">Sign In</button>                      
				</div>	
				<label><input type="checkbox" name="auto_login" value="1" id="remember_me" class="remember-me"> Remember me</label>
			</form>
		</div>

		<h5 class="sidebar-title">Member</h5>
		<div class="sidebar-nav">
			<ul>
				<li><a href="<?php echo $at_href['reg'];?>"><i class="fa fa-sign-in"></i> 회원가입</a></li>
				<li><a href="<?php echo $at_href['lost'];?>" class="win_password_lost"><i class="fa fa-search"></i> 정보찾기</a></li>
			</ul>
		</div>
	<?php } //End ?>

	<?php if(IS_YC) { //영카트 ?>
		<h5 class="sidebar-title">Shopping</h5>
		<div class="sidebar-nav">
			<ul>
				<li><a href="<?php echo $at_href['cart']; ?>"><i class="fa fa-shopping-cart"></i> 장바구니</a></li>
				<li><a href="<?php echo $at_href['inquiry']; ?>"><i class="fa fa-truck"></i> 주문/배송</a></li>
				<li><a href="<?php echo $at_href['ppay']; ?>"><i class="fa fa-ticket"></i> 개인결제</a></li>
				<li><a href="<?php echo $at_href['secret'];?>"><i class="fa fa-comments"></i> 1:1문의</a>
				</li>
			</ul>
		</div>
	<?php } ?>

	<h5 class="sidebar-title">Search</h5>
	<div class="sidebar-nav">
		<ul>
			<li><a href="<?php echo $at_href['faq'];?>"><i class="fa fa-question-circle"></i> FAQ</a></li>
			<?php if(IS_YC) { ?>
				<li><a href="<?php echo $at_href['isearch'];?>"><i class="fa fa-shopping-cart"></i> 아이템 검색</a></li>
				<li><a href="<?php echo $at_href['iuse']; ?>"><i class="fa fa-pencil"></i> 후기 검색</a></li>
				<li><a href="<?php echo $at_href['iqa']; ?>"><i class="fa fa-comments-o"></i> 문의 검색</a></li>
			<?php } ?>	
			<li><a href="<?php echo $at_href['search'];?>"><i class="fa fa-search"></i> 포스트 검색</a></li>
			<li><a href="<?php echo $at_href['tag'];?>"><i class="fa fa-tags"></i> 태그 검색</a></li>
		</ul>
	</div>

	<h5 class="sidebar-title">Misc</h5>
	<div class="sidebar-nav">
		<ul>
			<li><a href="<?php echo $at_href['new'];?>"><i class="fa fa-refresh"></i> 새글모음</a></li>
			<li><a href="<?php echo $at_href['connect'];?>"><i class="fa fa-link"></i> 현재접속자</a></li>
		</ul>
	</div>
</div>