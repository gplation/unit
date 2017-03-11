<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

if($is_orderable) echo '<script src="'.$item_skin_url.'/shop.js"></script>'.PHP_EOL;

// 이미지처리
$j=0;
if($is_thumbview) { //썸네일보기시에만 사용
	$thumbnails = array();
	$item_image = '';
	$item_image_href = '';
	for($i=1; $i<=10; $i++) {
		if(!$it['it_img'.$i])
			continue;

		$thumb = get_it_thumbnail($it['it_img'.$i], 60, 60);

		if($thumb) {
			$org_url = G5_DATA_URL.'/item/'.$it['it_img'.$i];
			if($j == 0) {
				$item_image = $org_url; // 큰이미지
				$item_image_href = G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i; // 큰이미지 주소
			}
			$thumbnails[$j] = '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i.'" ref="'.$org_url.'" target="_blank" class="thumb_item_image popup_item_image">'.$thumb.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
			$j++;
		}
	}

	$is_thumbview = ($j > 0) ? true : false;
}

$attach_list = '';
if($is_download) {
	for($i=0; $i < count($download); $i++) {
		$download_href = ($download[$i]['href']) ? $download[$i]['href'] : 'javascript:alert(\'구매한 회원만 다운로드할 수 있습니다.\');';
		$attach_list .= '<a class="list-group-item" href="'.$download_href.'">';
		if($download[$i]['free']) {
			if($download[$i]['guest_use']) {
				$attach_list .= '<span class="label label-default pull-right">Free</span>';
			} else {
				$attach_list .= '<span class="label label-primary pull-right">Join</span>'; 
			}
		} else {
			$attach_list .= '<span class="label label-danger pull-right">Paid</span>';
		}
		$attach_list .= '<i class="fa fa-download"></i> '.$download[$i]['source'].' ('.$download[$i]['size'].')</a>'.PHP_EOL;
	}
}

if($is_ramintime) { //이용기간 안내
	$remain_day = (int)(($is_reamintime - G5_SERVER_TIME) / 86400); //남은일수
	$attach_list .= '<a class="list-group-item" href="#"><i class="fa fa-bell"></i> '.date("Y.m.d H:i", $is_remaintime).'('.number_format($remain_day).'일 남음)까지 이용가능합니다.</a>'.PHP_EOL;
}

?>

<?php echo $it_head_html; // 상단 HTML; ?>

<?php include_once('./itembuyform.php'); // 구매폼 ?>

<div class="item-head">
	<h1><?php if($author['photo']) { ?><img src="<?php echo $author['photo'];?>" class="photo" alt=""><?php } ?><?php echo stripslashes($it['it_name']); ?></h1>
	<div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
		<div class="panel-heading">
			<div class="panel-title font-12 en">
				<span class="text-muted">
					<i class="fa fa-user"></i>
					<?php echo $author['name']; //등록자 ?>

					<span class="sp"></span>
					<i class="fa fa-comment"></i>
					<?php echo ($it['pt_comment']) ? '<span class="red">'.number_format($it['pt_comment']).'</span>' : 0; //댓글수 ?>

					<span class="sp"></span>
					<i class="fa fa-shopping-cart"></i>
					<?php echo number_format($it['it_sum_qty']); //판매량 ?>

					<span class="sp"></span>
					<span class="star-rating red"><?php echo apms_get_star($it['it_use_avg']); //평균별점 ?></span>

					<span class="sp"></span>
					<i class="fa fa-pencil"></i>
					<?php echo number_format($item_use_count); //후기수 ?>

					<span class="sp"></span>
					<i class="fa fa-eye"></i>
					<?php echo number_format($it['it_hit']); //조회수 ?>

					<span class="hidden-xs pull-right">
						<i class="fa fa-clock-o"></i>
						<?php echo apms_datetime($it['datetime'], 'Y.m.d H:i'); //시간 ?>
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
</div>

<?php if($is_thumbview) { // 썸네일보기 ?>
	<div class="item-image-box">
		<div class="item-image-autosize">
			<a href="<?php echo $item_image_href;?>" id="item_image_href" class="popup_item_image" target="_blank"><img id="item_image" src="<?php echo $item_image;?>" alt=""></a>
		</div>
		<div class="item-image-thumb text-center">
		<?php for($i=0; $i < count($thumbnails); $i++) { echo $thumbnails[$i]; } ?>
		</div>
	</div>
	<script>
		$(function(){
			$(".thumb_item_image").hover(function() {
				var img = $(this).attr("ref");
				var url = $(this).attr("href");
				$("#item_image").attr("src", img);
				$("#item_image_href").attr("href", url);
				return true;
			});
			// 이미지 크게보기
			$(".popup_item_image").click(function() {
				var url = $(this).attr("href");
				var top = 10;
				var left = 10;
				var opt = 'scrollbars=yes,top='+top+',left='+left;
				popup_window(url, "largeimage", opt);

				return false;
			});
		});
	</script>
<?php } ?>

<?php if ($is_torrent) { // 토렌트 파일정보 ?>
		<?php for($i=0; $i < count($torrent); $i++) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $torrent[$i]['name'];?></h3>
				</div>
				<div class="panel-body">
					<span class="pull-right hidden-xs text-muted en font-11"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i", $torrent[$i]['date']);?></span>
					<?php if ($torrent[$i]['is_size']) { ?>
							<b class="en font-16"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['info']['name'];?> (<?php echo $torrent[$i]['info']['size'];?>)</b>
					<?php } else { ?>
						<p><b class="en font-16"><i class="fa fa-cubes"></i> Total <?php echo $torrent[$i]['info']['total_size'];?></b></p>
						<div class="text-muted font-12">
							<?php for ($j=0;$j < count($torrent[$i]['info']['file']);$j++) { 
								echo ($j + 1).'. '.implode(', ', $torrent[$i]['info']['file'][$j]['name']).' ('.$torrent[$i]['info']['file'][$j]['size'].')<br>'."\n";
							} ?>
						</div>
					<?php } ?>
				</div>
				<ul class="list-group">
					<li class="list-group-item en font-14"><i class="fa fa-magnet"></i> <?php echo $torrent[$i]['magnet'];?></li>
					<li class="list-group-item">
						<div class="text-muted" style="font-size:12px;">
							<?php for ($j=0;$j < count($torrent[$i]['tracker']);$j++) { ?>
								<i class="fa fa-tags"></i> <?php echo $torrent[$i]['tracker'][$j];?><br>
							<?php } ?>
						</div>
					</li>
					<?php if($torrent[$i]['comment']) { ?>
						<li class="list-group-item en font-14"><i class="fa fa-bell"></i> <?php echo $torrent[$i]['comment'];?></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
<?php } ?>

<?php echo apms_link_video($link_video); // 링크 비디오 체크 ?>

<?php if($is_viewer || $is_link) { 
	// 보기용 첨부파일 확장자에 따른 FA 아이콘 - array(이미지, 비디오, 오디오, PDF)
	$viewer_fa = array("picture-o", "video-camera", "music", "file-powerpoint-o");
?>
	<div class="item-view-box">
		<?php if($is_link) { ?>
			<?php for($i=0; $i < count($link); $i++) { ?>
				<a href="<?php echo $link[$i]['url']; ?>" target="_blank" class="at-tip" title="<?php echo ($link[$i]['name']) ? $link[$i]['name'] : '관련링크'; ?>"><i class="fa fa-<?php echo ($link[$i]['fa']) ? $link[$i]['fa'] : 'link';?>"></i></a>
			<?php } ?>
		<?php } ?>

		<?php if($is_viewer) { ?>
			<?php for($i=0; $i < count($viewer); $i++) { $v = ($viewer[$i]['ext'] - 1); ?>
				<?php if($viewer[$i]['href_view']) { ?>
					<a href="<?php echo $viewer[$i]['href_view'];?>" class="view_win at-tip" title="<?php echo ($viewer[$i]['free']) ? '무료보기' : '바로보기';?>">
				<?php } else { ?>
					<a onclick="alert('구매한 회원만 볼 수 있습니다.');" class="at-tip" title="유료보기">
				<?php } ?>
					<i class="fa fa-<?php echo $viewer_fa[$v];?>"></i>
				</a>
			<?php } ?>
		<?php } ?>
		<script>
			var view_win = function(href) {
				var new_win = window.open(href, 'view_win', 'left=0,top=0,width=640,height=480,toolbar=0,location=0,scrollbars=0,resizable=1,status=0,menubar=0');
				new_win.focus();
			}
			$(function() {
				$(".view_win").click(function() {
					view_win(this.href);
					return false;
				});
			});
		</script>
	</div>
<?php } ?>

<?php if ($it['it_explan']) { // 상세설명 ?>
	<div class="item-explan img-resize">
		<?php if ($it['pt_explan']) { // 구매회원에게만 추가로 보이는 상세설명 ?>
			<div class="well"><?php echo apms_explan($it['pt_explan']); ?></div>
		<?php } ?>
		<?php echo apms_explan($it['it_explan']); ?>
	</div>
<?php } ?>

<?php if ($is_ccl) { // CCL ?>
	<div class="well" style="margin-top:20px;"><img src="<?php echo $ccl_img;?>" alt="CCL" />  &nbsp; 본 자료는 <u><?php echo $ccl_license;?></u>에 따라 이용할 수 있습니다.</div>
<?php } ?>

<?php if ($is_good) { ?>
	<div class="item-good-box">
		<span class="item-good">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'good', 'it_good'); return false;">
				<b id="it_good"><?php echo number_format($it['pt_good']) ?></b>
				<br>
				<i class="fa fa-thumbs-up"></i>
			</a>
		</span>
		<span class="item-nogood">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'nogood', 'it_nogood'); return false;">
				<b id="it_nogood"><?php echo number_format($it['pt_nogood']) ?></b>
				<br>
				<i class="fa fa-thumbs-down"></i>
			</a>
		</span>
	</div>
	<p></p>
<?php } ?>

<br>

<?php if ($is_tag) { // 태그 ?>
	<p class="item-tag"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
<?php } ?>

<div class="row">
	<div class="col-xs-8">
		<div class="form-group">
			<?php include_once(G5_SNS_PATH."/item.sns.skin.php"); ?>
		</div>
	</div>
	<div class="col-xs-4">
		<div class="form-group text-right">
			<a href="#" class="btn btn-black btn-xs" onclick="apms_recommend('<?php echo $it['it_id']; ?>', '<?php echo $ca_id; ?>'); return false;"><i class="fa fa-send big-lg"></i> <span class="hidden-xs">추천</span></a>
			<a href="#" class="btn btn-<?php echo ($is_orderform) ? 'black' : 'color';?> btn-xs" onclick="apms_wishlist('<?php echo $it['it_id']; ?>'); return false;"><i class="fa fa-heart big-lg"></i> <span class="hidden-xs">위시</span></a>
			<?php if($is_orderform) { // 주문가능시에만 출력 ?>
				<a href="#" class="btn btn-color btn-xs" data-toggle="modal" data-target="#cartModal" onclick="return false;"><i class="fa fa-shopping-cart big-lg"></i> <span class="hidden-xs">주문/담기</span></a>
			<?php } ?>
		</div>
	</div>
</div>

<script>
// Wishlist
function apms_wishlist(it_id) {
	if(!it_id) {
		alert("코드가 올바르지 않습니다.");
		return false;
	}

	$.post("./itemwishlist.php", { it_id: it_id },	function(error) {
		if(error != "OK") {
			alert(error.replace(/\\n/g, "\n"));
			return false;
		} else {
			if(confirm("위시리스트에 담겼습니다.\n\n바로 확인하시겠습니까?")) {
				document.location.href = "./wishlist.php";
			}
		}
	});

	return false;
}

// Recommend
function apms_recommend(it_id, ca_id) {
	if (!g5_is_member) {
		alert("회원만 추천하실 수 있습니다.");
	} else {
		url = "./itemrecommend.php?it_id=" + it_id + "&ca_id=" + ca_id;
		opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
		popup_window(url, "itemrecommend", opt);
	}
}
</script>

<div class="panel panel-default view-author">
	<div class="panel-heading">
		<?php if($author['partner']) { ?>
			<span class="pull-right">
				<a href="<?php echo $at_href['myshop'];?>?id=<?php echo $author['mb_id'];?>">
					<span  class="label label-primary font-11 en">My Shop</span>
				</a>
			</span>
		<?php } ?>
		<h3 class="panel-title">Author</h3>
	</div>
	<div class="panel-body">
		<div class="pull-left text-center auth-photo">
			<div class="img-photo">
				<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
			</div>
			<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
				<button type="button" class="btn btn-color btn-sm at-tip" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
					<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($author['liked']) ?></span>
				</button>
				<button type="button" class="btn btn-color btn-sm at-tip" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
					<i class="fa fa-users"></i> <span id="it_follow"><?php echo $author['followed']; ?></span>
				</button>
			</div>
		</div>
		<div class="auth-info">
			<div class="en font-14" style="margin-bottom:6px;">
				<span class="pull-right font-12">Lv.<?php echo $author['level'];?></span>
				<b><?php echo $author['name']; ?></b> &nbsp;<span class="text-muted en font-12"><?php echo $author['grade'];?></span>
			</div>
			<div class="progress progress-striped no-margin">
				<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
					<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
				</div>
			</div>
			<p style="margin-top:6px;">
				<?php echo ($author['mb_signature']) ? apms_explan($author['mb_signature']) : '등록된 서명이 없습니다.'; ?>
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<!-- 위젯에서 해당글 클릭시 이동위치 : icv - 댓글, iuv - 후기, iqv - 문의 -->
<div id="icv"></div>
<div id="iuv"></div>
<div id="iqv"></div>

<?php if($is_event) { // 관련 이벤트 : 배너가 등록된 것만 출력됨 ?>
	<br>
	<h3 class="section-title">Event</h3>
	<div class="carousel slide item-event-banner" id="item_event_<?php echo $it_id;?>" data-ride="carousel" data-interval="5000">
		<div class="carousel-nav">
			<a class="left" href="#<?php echo $carousel_id;?>" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
			<a class="right" href="#<?php echo $carousel_id;?>" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
		</div>
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<div class="row">
					<?php for($i=0; $i < count($event); $i++) { 
						$img = apms_thumbnail($event[$i]['ev_mimg'], 400, 225, false, true);
					?>
						<?php if($i > 0 && $i%3 == 0) { ?>
								</div>
							</div>
							<div class="item">
								<div class="row">
						<?php } ?>
							<div class="col-sm-4">
								<div class="img" style="padding-bottom:56.25%;">
									<a href="<?php echo $event[$i]['ev_href'];?>">
										<img src="<?php echo $img['src'];?>" alt="<?php echo $event[$i]['ev_subject'];?>">
									</a>
								</div>
							</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div style="margin-top:15px;">
	<ul class="nav nav-pills nav-justified">
		<?php if($is_comment) { ?>
			<li><a href="#tab2-1" data-toggle="tab" class="en font-14">Comments (<?php echo number_format($it['pt_comment']);?>)</a></li>
		<?php } ?>
		<li><a href="#tab2-2" data-toggle="tab" class="en font-14">Review (<?php echo number_format($item_use_count);?>)</a></li>
		<li><a href="#tab2-3" data-toggle="tab" class="en font-14">Q & A (<?php echo number_format($item_qa_count);?>)</a></li>
		<?php if ($is_relation) { ?>
			<li><a href="#tab2-4" data-toggle="tab" class="en font-14">Relation (<?php echo number_format($item_relation_count);?>)</a></li>
		<?php } ?>
	</ul>

	<div id="item_tab_content" class="tab-content">
		<?php if($is_comment) { ?>
			<div class="tab-pane active" id="tab2-1">
				<h3 class="section-title">Comments</h3>
				<?php include_once('./itemcomment.php'); ?>
			</div>
		<?php } ?>

		<div class="tab-pane<?php echo ($is_comment) ? '' : ' active';?>" id="tab2-2">
			<h3 class="section-title">Review</h3>
			<div id="itemuse">
				<?php include_once('./itemuse.php'); ?>
			</div>
		</div>

		<div class="tab-pane" id="tab2-3">
			<h3 class="section-title">Q & A</h3>
			<div id="itemqa">
				<?php include_once('./itemqa.php'); ?>
			</div>
		</div>
		<?php if ($is_relation) { ?>
			<div class="tab-pane" id="tab2-4">
				<h3 class="section-title">Relation</h3>
				<div id="itemrelation">
					<?php include_once('./itemrelation.php'); ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<?php echo $it_tail_html; // 하단 HTML ?>

<div class="btn-group btn-group-justified" style="margin:20px 0;">
	<?php if($prev_href) { ?>
		<a class="btn btn-black" href="<?php echo $prev_href;?>" title="<?php echo $prev_item;?>">이전</a>
	<?php } ?>
	<?php if($next_href) { ?>
		<a class="btn btn-black" href="<?php echo $next_href;?>" title="<?php echo $next_item;?>">다음</a>
	<?php } ?>
	<?php if($edit_href) { ?>
		<a class="btn btn-black" href="<?php echo $edit_href;?>">수정</a>
	<?php } ?>
	<?php if ($write_href) { ?>
		<a class="btn btn-black" href="<?php echo $write_href;?>">등록</a>
	<?php } ?>
	<?php if($item_href) { ?>
		<a class="btn btn-black" href="<?php echo $item_href;?>">관리</a>
	<?php } ?>
	<a class="btn btn-color" href="<?php echo $list_href;?>">목록</a>
</div>

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});
});
</script>

<?php include_once('./itemlist.php'); // 분류목록 ?>
