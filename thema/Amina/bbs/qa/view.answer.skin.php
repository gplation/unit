<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div class="panel panel-default">
	<div class="panel-heading">
        <span class="pull-right hidden-xs font-11"><i class="fa fa-clock-o"></i> <?php echo apms_datetime(strtotime($answer['qa_datetime']), 'Y.m.d H:i'); //시간 ?></span>
		<h3 class="panel-title"><i class="fa fa-comments-o"></i> <?php echo get_text($answer['qa_subject']); ?></h3>
	</div>
	<div class="panel-body">
		<div class="ans-content">
	        <?php echo conv_content($answer['qa_content'], $answer['qa_html']); ?>
		</div>

		<div class="ans-btn">
			<a href="<?php echo $rewrite_href; ?>" class="btn btn-color btn-sm pull-left">추가질문</a>
			<?php if($answer_update_href) { ?>
				<a href="<?php echo $answer_update_href; ?>" class="btn btn-black btn-sm">답변수정</a>
			<?php } ?>
			<?php if($answer_delete_href) { ?>
				<a href="<?php echo $answer_delete_href; ?>" class="btn btn-black btn-sm" onclick="del(this.href); return false;">답변삭제</a>
			<?php } ?>
		</div>
	</div>
</div>
