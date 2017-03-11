<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//필요한 전역변수 선언
global $member, $is_member, $at_href, $urlencode;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

?>
<div class="amina-widget-outlogin">
	<?php if($is_member) { //Login ?>
		<div class="profile">
			<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo" title="사진등록">
				<div class="photo pull-left">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; //사진 ?>
				</div>
			</a>
			<h3><?php echo $member['mb_nick'];?></h3>
			<div class="font-11 text-muted">
				<?php echo $member['grade'];?>
				<?php if($member['partner']) { ?>
					&nbsp;|&nbsp;
					<a href="<?php echo $at_href['myshop'];?>"><span class="text-muted">마이샵</span></a>
				<?php } ?>
				<?php if($member['admin']) { ?>
					&nbsp;|&nbsp;
					<a href="<?php echo G5_ADMIN_URL;?>"><span class="text-muted">관리</span></a>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="at-tip" data-original-title="<?php echo number_format($member['exp_up']);?>점 추가획득시 레벨업합니다." data-toggle="tooltip" data-placement="top" data-html="true" style="margin:10px 0px;">
			<div class="progress progress-striped" style="margin:0px;">
				<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%;">
					<span class="sr-only">
						Lv.<?php echo $member['level'];?>
					</span>
				</div>
			</div>
			<div class="sr-score pull-right" style="color:#fff; margin-top:-28px;"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</div>
		</div>

		<div class="font-12 text-muted">
			<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point pull-right">
				<i class="fa fa-gift"></i> <?php echo AS_MP;?> <b class="red"><?php echo number_format($member['mb_point']);?></b>
			</a>
			<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
				글반응<?php if ($member['response']) { ?> <span class="red"><?php echo number_format($member['response']);?></span><?php } ?>
			</a>		
			&nbsp;|&nbsp;
			<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
				쪽지함<?php if ($member['memo']) { ?> <span class="blue"><?php echo number_format($member['memo']);?></span><?php } ?>
			</a>		
			<div class="clearfix"></div>
		</div>

		<div style="margin:10px 0px;">
			<a href="<?php echo $at_href['logout'];?>" class="btn btn-color btn-block btn-sm">
				<i class="fa fa-power-off"></i> Logout
			</a>
		</div>

		<div class="form-group font-11 text-muted">
			<div class="pull-left">
				<a href="#" class="asideButton">
					<span class="text-muted">마이메뉴</span>
				</a>
				&nbsp; | &nbsp;
				<a href="<?php echo $at_href['edit'];?>">
					<span class="text-muted">정보수정</span>
				</a>
			</div>
			<div class="pull-right">
				<a href="<?php echo $at_href['leave'];?>" class="leave-me at-tip" data-original-title="<nobr>회원탈퇴</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"">
					<span class="text-muted"><i class="fa fa-sign-out fa-lg"></i></span>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>

	<?php } else { //Logout ?>

		<form name="outloginbox" method="post" action="<?php echo $at_href['login_check'];?>
		<? // 주석 ?>
		"<? /*-- onsubmit="return amina_login(this); */?> " 
		autocomplete="off" role="form" class="form">
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
				<button type="submit" class="btn btn-color btn-block">Login</button>                      
			</div>	

			<div class="form-group font-11">
				<div class="pull-left text-muted hidden-xs">
					<label><input type="checkbox" name="auto_login" value="1" id="remember_me" class="remember-me"> <span class="font-11">자동로그인</span></label>
				</div>
				<div class="pull-right text-muted">
					<a href="<?php echo $at_href['reg'];?>"><span class="text-muted">회원가입</span></a>
					&nbsp; | &nbsp;
					<a href="<?php echo $at_href['lost'];?>" class="win_password_lost"><span class="text-muted">정보찾기</span></a>
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
	<?php } //End ?>
</div>