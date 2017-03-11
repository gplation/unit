<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사진 들여보이기
$depth_gap = (G5_IS_MOBILE) ? 32 : 64;

?>

<div id="itemcomment" class="item-comment-box">
	<!-- 댓글 시작 { -->
	<section id="it_vc" class="comment-media">
		<?php
		$cmt_amt = count($list);
		for ($i=0; $i<$cmt_amt; $i++) {
			$comment_id = $list[$i]['wr_id'];
			$cmt_depth = ""; // 댓글단계
			$cmt_depth = strlen($list[$i]['wr_comment_reply']) * $depth_gap;
			$comment = $list[$i]['content'];
			$ic_photo_url = apms_photo_url($list[$i]['mb_id']);
			$ic_photo = ($ic_photo_url) ? '<img src="'.$ic_photo_url.'" alt="" class="media-object">' : '<div class="media-object"><i class="fa fa-user"></i></div>';
		 ?>

			<div class="media" id="c_<?php echo $comment_id ?>"<?php echo ($cmt_depth) ? ' style="margin-left:'.$cmt_depth.'px;"' : ''; ?>>
				<div class="photo pull-left"><?php echo $ic_photo;?></div>
				<div class="media-body">
					<h5 class="media-heading">
						<b class="font-13"><?php echo $list[$i]['name'] ?></b>
						<span class="font-11 text-muted">
							<span class="hidden-xs media-info">
								<i class="fa fa-clock-o"></i>
								<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['date']) ?>"><?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i');?></time>
							</span>
							<?php if ($is_admin == 'super') { ?> 
								<span class="hidden-xs media-info"><i class="fa fa-thumb-tack"></i> <?php echo $list[$i]['ip']; ?></span> 
							<?php } // 최고관리자에게는 IP 보임 ?>
							<?php if ($list[$i]['wr_facebook_user']) { ?>
								<a href="https://www.facebook.com/profile.php?id=<?php echo $list[$i]['wr_facebook_user']; ?>" target="_blank">
									<i class="fa fa-facebook"></i><span class="sound_only">페이스북에도 등록됨</span>
								</a>
							<?php } ?>
							<?php if ($list[$i]['wr_twitter_user']) { ?>
								<a href="https://www.twitter.com/<?php echo $list[$i]['wr_twitter_user']; ?>" target="_blank">
									<i class="fa fa-facebook"></i><span class="sound_only">트위터에도 등록됨</span>
								</a>
							<?php } ?>
						</span>
						<?php if($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del'] || $is_shingo || $is_admin) {
							if($w == 'cu') {
								$sql = " select wr_id, wr_content from {$g5['apms_comment']} where wr_id = '$it_id' and wr_id = '$c_id' ";
								$cmt = sql_fetch($sql);
								$c_wr_content = $cmt['wr_content'];
							}
						 ?>
							<div class="pull-right font-11 ">
								<?php if ($list[$i]['is_reply']) { ?>
									<a href="#" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">
										<span class="text-muted">답변</span>
									</a>
								<?php } ?>
								<?php if ($list[$i]['is_edit']) { ?>
									<a href="#" onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;">
										<span class="text-muted media-btn">수정</span>
									</a>
								<?php } ?>
								<?php if ($list[$i]['is_del'])  { ?>
									<a href="#" onclick="apms_delete('itemcomment', '<?php echo $list[$i]['del_href'];?>','<?php echo $list[$i]['del_return'];?>'); return false;">
										<span class="text-muted media-btn">삭제</span>
									</a>
								<?php } ?>
								<?php if ($is_shingo)  { ?>
									<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $comment_id ?>'); return false;">
										<span class="text-muted media-btn">신고</span>
									</a>
								<?php } ?>
								<?php if ($is_admin) { ?>
									<?php if ($list[$i]['is_lock']) { // 글이 잠긴상태이면 ?>
										<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $comment_id;?>', 'unlock'); return false;">
											<span class="text-muted media-btn"><i class="fa fa-unlock fa-lg"></i><span class="sound_only">해제</span></span>
										</a>
									<?php } else { ?>
										<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $comment_id;?>', 'lock'); return false;">
											<span class="text-muted media-btn"><i class="fa fa-lock fa-lg"></i><span class="sound_only">잠금</span></span>
										</a>
									<?php } ?>
								<?php } ?>
							</div>
						<?php } ?>
					</h5>
					<div class="media-content">
						<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><i class="fa fa-lock"></i><?php } ?>
						<?php echo $comment ?>

						<?php if(!G5_IS_MOBILE) { // PC ?>
							<span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
							<span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->
							<input type="hidden" value="<?php echo $itemcomment_url.'&amp;page='.$page; ?>" id="comment_url_<?php echo $comment_id ?>">
							<input type="hidden" value="<?php echo $page; ?>" id="comment_page_<?php echo $comment_id ?>">
							<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
							<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
						<?php } ?>
					</div>
			  </div>
			</div>
			<?php if(G5_IS_MOBILE) { // Mobile ?>
				<span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
				<span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->
				<input type="hidden" value="<?php echo $itemcomment_url.'&amp;page='.$page; ?>" id="comment_url_<?php echo $comment_id ?>">
				<input type="hidden" value="<?php echo $page; ?>" id="comment_page_<?php echo $comment_id ?>">
				<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
				<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
			<?php } ?>
		<?php } ?>
	</section>

	<?php if($total_count > 0) { ?>
		<div class="text-center" style="margin:15px 0px;">
			<ul class="pagination pagination-sm en" style="margin:0;">
				<?php echo apms_ajax_paging('itemcomment', $write_pages, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>
</div>
<!-- } 댓글 끝 -->

<?php if($is_item) { //페이지 이동시 작동안함 ?>
	<?php if ($is_comment_write) { ?>
		<aside id="it_vc_w">
			<div class="panel panel-default" style="margin-top:10px;">
				<div class="panel-body" style="padding-bottom:0px;">
					<form id="fviewcomment" name="fviewcomment" class="form" role="form" action="<?php echo $itemcomment_action_url;?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
						<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
						<input type="hidden" name="it_id" value="<?php echo $it_id ?>">
						<input type="hidden" name="ca_id" value="<?php echo $ca_id;?>">
						<input type="hidden" name="comment_id" value="<?php echo $c_id; ?>" id="comment_id">
						<input type="hidden" name="comment_url" value="" id="comment_url">
						<input type="hidden" name="crows" value="<?php echo $crows;?>">
						<input type="hidden" name="page" value="" id="comment_page">

						<div class="form-group">
							<textarea id="wr_content" name="wr_content" rows=5 maxlength="10000" required class="form-control input-sm"><?php echo $c_wr_content;  ?></textarea>
						</div>
						<div class="comment-btn">
							<div class="form-group pull-right">
								<div class="btn-group">
									<button class="btn btn-color btn-sm" type="button" onclick="apms_comment('itemcomment');" id="btn_submit"><i class="fa fa-comment"></i> <b>등록</b></button>
									<button class="btn btn-black btn-sm" title="이모티콘" type="button" onclick="apms_emoticon();"><i class="fa fa-smile-o fa-lg"></i><span class="sound_only">이모티콘</span></button>
									<button class="btn btn-black btn-sm" title="새댓글" type="button" onclick="comment_box('','c');"><i class="fa fa-pencil fa-lg"></i><span class="sound_only">새댓글 작성</span></button>
									<button class="btn btn-black btn-sm" title="새로고침" type="button" onclick="apms_page('itemcomment','<?php echo $itemcomment_url;?>');"><i class="fa fa-refresh fa-lg"></i><span class="sound_only">댓글 새로고침</span></button>
									<button class="btn btn-black btn-sm" title="늘이기" type="button" onclick="apms_textarea('wr_content','down');"><i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">입력창 늘이기</span></button>
									<button class="btn btn-black btn-sm" title="줄이기" type="button" onclick="apms_textarea('wr_content','up');"><i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">입력창 줄이기</span></button>
								</div>
							</div>
							<div id="it_vc_opt" class="form-group en pull-left">
								<ol>
								<li><label class="font-12"><input type="checkbox" name="wr_secret" value="secret" id="wr_secret"> 비밀글</label></li>
								<?php if($is_comment_sns) { ?>
									<li id="it_vc_send_sns"></li>
								<?php } ?>
								</ol>
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
				</div>
			</div>
		</aside>
	<?php } else { ?>
		<div class="well text-center">
			<?php if($is_author_comment) { ?>
				지정된 회원만 댓글 등록이 가능합니다.
			<?php } else { ?>
				<a href="<?php echo $itemcomment_login_url;?>">로그인한 회원만 댓글 등록이 가능합니다.</a>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>