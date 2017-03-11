<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
		<?php if($col_name) { ?>
			<?php if($col_name == "two") { ?>
					</div>
					<div class="col-md-<?php echo $col_side;?><?php echo ($at_set['side']) ? ' pull-left' : '';?> sideArea">
						<?php include_once(THEMA_PATH.'/side.php'); ?>
					</div>
				</div>
			<?php } ?>
			</div>
		<?php } ?>
	</div><!-- .at-content -->

	<footer class="at-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="col">
						<h4>About</h4>
						<p> 사이트 소개를 입력해 주세요. </p>
						<div>
							<?php 
								$sns_url  = G5_URL;
								$sns_title = get_text($config['cf_title']);
								$sns_icon_url = THEMA_URL.'/assets/img';
								echo  get_sns_share_link('facebook', $sns_url, $sns_title, $sns_icon_url.'/sns_fb_s.png').' ';
								echo  get_sns_share_link('twitter', $sns_url, $sns_title, $sns_icon_url.'/sns_twt_s.png').' ';
								echo  get_sns_share_link('googleplus', $sns_url, $sns_title, $sns_icon_url.'/sns_goo_s.png').' ';
								echo  get_sns_share_link('kakaostory', $sns_url, $sns_title, $sns_icon_url.'/sns_kakaostory_s.png').' ';
								echo  get_sns_share_link('kakaotalk', $sns_url, $sns_title, $sns_icon_url.'/sns_kakao_s.png').' ';
								echo  get_sns_share_link('naverband', $sns_url, $sns_title, $sns_icon_url.'/sns_naverband_s.png').' ';
							?>
						 </div>
					 </div>
				</div>
				
				<div class="col-md-3">
					<div class="col">
						<h4>Information</h4>
						<ul>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보 취급방침</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=noemail">이메일 무단수집거부</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=disclaimer">책임의 한계와 법적고지</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=guide">이용안내</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/qalist.php">문의하기</a></li>
						</ul>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="col">
						<h4>Statistics</h4>
						<ul>
							<li><a href="<?php echo $at_href['connect'];?>">
								현재 접속자 <span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '('.number_format($stats['now_mb']).')' : ''; ?> 명</span></a>
							</li>
							<li>오늘 방문자 <span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span></li>
							<li>어제 방문자 <span class="pull-right"><?php echo number_format($stats['visit_yesterday']); ?> 명</span></li>
							<li>최대 방문자 <span class="pull-right"><?php echo number_format($stats['visit_max']); ?> 명</span></li>
							<li>전체 방문자 <span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span></li>
							<li>전체 회원수	<span class="pull-right at-tip" data-original-title="<nobr>오늘 <?php echo $stats['join_today'];?> 명 / 어제 <?php echo $stats['join_yesterday'];?> 명</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($stats['join_total']); ?> 명</span>
							</li>
							<li>전체 게시물	<span class="pull-right at-tip" data-original-title="<nobr>글 <?php echo number_format($menu[0]['count_write']);?> 개/ 댓글 <?php echo number_format($menu[0]['count_comment']);?> 개</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($menu[0]['count_write'] + $menu[0]['count_comment']); ?> 개</span>
							</li>
						</ul>

					</div>
				</div>

				 <div class="col-md-3">
					<div class="col">
						<h4>Contact</h4>
						<ul>
							<li><?php echo $default['de_admin_company_name']; ?> (<?php echo $default['de_admin_company_owner']; ?>)</li>
							<li><address><?php echo $default['de_admin_company_addr']; ?></address></li>
							<li>전화 : <?php echo $default['de_admin_company_tel']; ?>
								<?php if($default['de_admin_company_fax']) echo '(Fax : '.$default['de_admin_company_fax'].')';?>
							</li>
							<li>사업자등록번호 : <a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank"><?php echo $default['de_admin_company_saupja_no']; ?></a></li>
							<li>개인정보관리책임자 : <?php echo $default['de_admin_info_name']; ?></li>
							<li>이메일 : <?php echo $default['de_admin_info_email']; ?></li>
							<li>통신판매업신고번호 : <?php echo $default['de_admin_tongsin_no']; ?></li>
							<?php if ($default['de_admin_buga_no']) echo '<li>부가통신사업신고번호 : '.$default['de_admin_buga_no'].'</li>'; ?>
						</ul>
						<a href="<?php echo $as_href['pc_mobile'];?>" class="btn btn-black btn-xs btn-block font-11" style="margin-top:5px;">
							<?php echo (G5_IS_MOBILE) ? 'PC' : '모바일';?>버전
						</a>
					</div>
				</div>
			</div>

			<hr>

			<div class="row">
				<!-- Copyright -->
				<div class="col-md-12 copyright en">
					Copyright &copy; 2014 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
				</div>
			</div>
		</div>
	</footer>
</div><!-- .wrapper -->

<!-- JavaScript -->
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/bs3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/jquery.bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/jquery.ui.totop.min.js"></script>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/jquery.custom.js"></script>
<?php if($at_set['header']) { ?>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/jquery.custom.sticky.js"></script>
<?php } ?>

<?php if($is_admin || $is_demo) include(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/respond.js"></script>
<![endif]-->