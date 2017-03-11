<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 사진
$view['photo'] = apms_photo_url($view['mb_id']);

$attach_list = '';
if($view['download_count']) {
	for ($i=0; $i<$view['download_count']; $i++) { // 참부파일
		$attach_list .= '<a class="list-group-item view_file_download" href="'.$view['download_href'][$i].'">';
		$attach_list .= '<i class="fa fa-download"></i> '.$view['download_source'][$i].'</a>'.PHP_EOL;
	}
}

?>

<div class="view-wrap">
	<h1><?php if($view['photo']) { ?><img src="<?php echo $view['photo'];?>" class="photo" alt=""><?php } ?><?php echo $view['subject']; ?></h1>

	<div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
		<div class="panel-heading">
			<div class="panel-title font-12 en">
				<span class="text-muted">
					<i class="fa fa-user"></i>
					<?php echo $view['name']; //등록자 ?>

					<?php if($view['category']) { ?>
						<span class="hidden-xs">
							<span class="sp"></span>
							<i class="fa fa-tag"></i>
							<?php echo $view['category']; //분류 ?>
						</span>
					<?php } ?>

					<?php if($view['hp']) { ?>
						<span class="sp"></span>
						<i class="fa fa-phone"></i>
						<?php echo $view['hp']; //연락처 ?>
					<?php } ?>
					<?php if($view['email']) { ?>
						<span class="sp"></span>
						<i class="fa fa-envelope-o"></i>
						<?php echo $view['email']; //이메일 ?>
					<?php } ?>

					<span class="hidden-xs pull-right">
						<i class="fa fa-clock-o"></i>
						<?php echo apms_datetime(strtotime($view['qa_datetime']), 'Y.m.d H:i'); //시간 ?>
					</span>
				</span>
			</div>
		</div>
	   <?php
			if($attach_list) {
				echo '<div class="list-group font-12">'.$attach_list.'</div>'.PHP_EOL;
			}
		?>
	</div>

	<?php
		// 이미지 출력
		if($view['img_count']) {
			echo '<div class="view-img">'.PHP_EOL;
			for ($i=0; $i<$view['img_count']; $i++) {
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
			}
			echo '</div>'.PHP_EOL;
		}
	 ?>

	<div class="view-content">
		<?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?>
	</div>

	<p class="text-right">
		<?php if($view['qa_type']) { ?>
			<a href="<?php echo $rewrite_href; ?>" class="btn btn-black btn-sm">추가질문</a>
		<?php } ?>
		<?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="btn btn-black btn-sm">수정</a><?php } ?>
		<?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="btn btn-black btn-sm" onclick="del(this.href); return false;">삭제</a><?php } ?>
	</p>

	<?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($skin_path.'/view.answer.skin.php');
        else
            include_once($skin_path.'/view.answerform.skin.php');
    }
    ?>
</div>

<?php if($view['rel_count']) { ?>
	<div class="list-wrap">
		<h3 class="section-title">Relations</h3>

		<?php if(G5_IS_MOBILE) { // 모바일?>
			<div class="list-media" style="margin-top:-10px;">
				<?php for ($i=0; $i<$view['rel_count']; $i++) { 
					$list_img_url = apms_photo_url($rel_list[$i]['mb_id']); // 회원사진
					$list_img = ($list_img_url) ? '<img src="'.$list_img_url.'" alt="" class="media-object">' : '<div class="media-object"><i class="fa fa-user"></i></div>';
					$list_date = strtotime($rel_list[$i]['qa_datetime']);	
				?>
					<div class="media">
						<div class="m-photo img-thumbnail pull-left">
							<a href="<?php echo $rel_list[$i]['href'] ?>">
								<?php echo $list_img;?>
							</a>
						</div>
						<div class="media-body">
							<h5 class="media-heading">
								<?php if($rel_list[$i]['qa_status']) { ?>
									<span class="pull-right font-14">
										<i class="fa fa-comments-o"></i>
									</span>
								<?php } ?>
								<a href="<?php echo $rel_list[$i]['view_href'] ?>">
									<img src="<?php echo $skin_url;?>/img/icon_<?php echo ($rel_list[$i]['qa_status'] ? 'a' : 'q'); ?>.gif" alt="">
									<?php echo $rel_list[$i]['subject'] ?>
								</a>
							</h5>
							<div class="font-11 en text-muted media-info">
								<i class="fa fa-user"></i>
								<?php echo $rel_list[$i]['name'] ?>

								<i class="fa fa-tags"></i>
								<?php echo $rel_list[$i]['category']; ?>

								<i class="fa fa-clock-o hidden-xs"></i>
								<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list_date) ?>" class="hidden-xs"><?php echo apms_datetime($list_date);?></time>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if ($i == 0) { echo '<div class="text-center text-muted list-none">게시물이 없습니다.</div>'; } ?>
			</div>
		<?php } else { ?>
			<div class="table-responsive">
				<table class="table list-tbl">
				<thead>
				<tr class="list-head">
					<th scope="col">분류</th>
					<th scope="col">제목</th>
					<th scope="col">상태</th>
					<th scope="col">등록일</th>
				</tr>
				</thead>
				<tbody>
				<?php for($i=0; $i<$view['rel_count']; $i++) { ?>
				<tr>
					<td class="text-center text-muted font-11"><?php echo get_text($rel_list[$i]['category']); ?></td>
					<td class="list-subject">
						<a href="<?php echo $rel_list[$i]['view_href']; ?>">
							<img src="<?php echo $skin_url;?>/img/icon_<?php echo ($rel_list[$i]['qa_status'] ? 'a' : 'q'); ?>.gif" alt="">
							<?php echo $rel_list[$i]['subject']; ?>
						</a>
					</td>
					<td class="text-center font-11 <?php echo ($rel_list[$i]['qa_status'] ? 'red' : 'text-muted'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></td>
					<td class="text-right en font-11"><?php echo apms_datetime(strtotime($rel_list[$i]['qa_datetime'])); ?></td>
				</tr>
				<?php }?>
				</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<div class="view-btn">
	<span class="pull-left">
		<?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="btn btn-black btn-sm">이전</a><?php } ?>
		<?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="btn btn-black btn-sm">다음</a><?php } ?>
	</span>
	<a href="<?php echo $list_href ?>" class="btn btn-black btn-sm">목록</a>
	<?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn btn-color btn-sm">글쓰기</a><?php } ?>
</div>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });
});
</script>