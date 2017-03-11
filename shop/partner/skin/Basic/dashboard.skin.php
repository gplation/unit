<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">',0);

?>

<h1><i class="fa fa-dashboard"></i> My Dashboard</h1>

<?php if($notice) { // 전체 알림 ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $notice;?>
	</div>
<?php } ?>

<div class="row en font-14">
	<div class="col-lg-3">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-4 hidden-xs">
						<i class="fa fa-shopping-cart fa-5x"></i>
					</div>
					<div class="col-sm-8 col-xs-12 text-right">
						<p class="announcement-heading"><?php echo number_format($today_sales);?></p>
						<p class="announcement-text">Today's Sales</p>
					</div>
				</div>
			</div>
			<a href="./?ap=saleitem">
				<div class="panel-footer announcement-bottom">
					<div class="row">
						<div class="col-xs-6">
							View Sale Items
						</div>
						<div class="col-xs-6 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-4">
						<i class="fa fa-comment fa-5x"></i>
					</div>
					<div class="col-xs-8 text-right">
						<p class="announcement-heading"><?php echo number_format($today_comments);?></p>
						<p class="announcement-text">Today's Comments</p>
					</div>
				</div>
			</div>
			<a href="./?ap=comment">
				<div class="panel-footer announcement-bottom">
					<div class="row">
						<div class="col-xs-6">
							View Comments
						</div>
						<div class="col-xs-6 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-4">
						<i class="fa fa-question-circle fa-5x"></i>
					</div>
					<div class="col-xs-8 text-right">
						<p class="announcement-heading"><?php echo number_format($today_questions);?></p>
						<p class="announcement-text">Today's Questions</p>
					</div>
				</div>
			</div>
			<a href="./?ap=qalist">
				<div class="panel-footer announcement-bottom">
					<div class="row">
						<div class="col-xs-6">
							View Questions
						</div>
						<div class="col-xs-6 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-4">
						<i class="fa fa-star fa-5x"></i>
					</div>
					<div class="col-xs-8 text-right">
						<p class="announcement-heading"><?php echo number_format($today_reviews);?></p>
						<p class="announcement-text">Today's Reviews</p>
					</div>
				</div>
			</div>
			<a href="./?ap=uselist">
				<div class="panel-footer announcement-bottom">
					<div class="row">
						<div class="col-xs-6">
							View Reviews
						</div>
						<div class="col-xs-6 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="./?ap=salelist">
					<h3 class="panel-title white">
						<i class="fa fa-arrow-circle-right pull-right"></i>
						<i class="fa fa-line-chart"></i> My Sales Statistics for 30 days
					</h3>
				</a>
			</div>
			<div class="panel-body">
				<div id="morris-chart-area"></div>
			</div>
		</div>
	</div>
</div><!-- /.row -->

<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script>
	Morris.Area({
	  // ID of the element in which to draw the chart.
	  element: 'morris-chart-area',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: [
		<?php for ($i=0; $i < count($list); $i++) { ?>
		  { d: '<?php echo $list[$i]['date'];?>', sales: <?php echo $list[$i]['sale'];?> },
		<?php } ?>
	  ],
	  // The name of the data record attribute that contains x-visitss.
	  xkey: 'd',
	  // A list of names of data record attributes that contain y-visitss.
	  ykeys: ['sales'],
	  // Labels for the ykeys -- will be displayed when you hover over the
	  // chart.
	  labels: ['Sales'],
	  // Disables line smoothing
	  smooth: false,
	});
</script>


<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-coffee"></i> My Information</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive" style="margin-bottom:0px;">
					<table class="table" style="margin-bottom:0px;">
					<tbody>
					<tr>
						<td>기업정보 : <?php echo $company_info; ?></td>
					</tr>
					<tr>
						<td>담당정보 : <?php echo ($partner['pt_name']) ? $partner['pt_name'].' ('.$partner['pt_hp'].', '.$partner['pt_email'].')' : '미등록'; ?></td>
					</tr>
					<tr>
						<td>정산유형 : <?php echo ($partner['pt_company']) ? $partner['pt_company'] : '미등록'; ?></td>
					</tr>
					<tr>
						<td>정산방법 : <?php echo $account_info;?></td>
					</tr>
					<tr>
						<td>입금계좌 :
							<?php if($partner['pt_bank_name']) { ?>
								<?php echo $partner['pt_bank_name'];?>
								<?php echo $partner['pt_bank_account'];?>
								<?php echo $partner['pt_bank_holder'];?>
							<?php } else { ?>
								미등록
							<?php } ?>
						</td>
					</tr>
					</tbody>
					</table>

					<?php if($message) { // 메시지 ?>
						<div class="well" style="margin:10px 0px 0px;">
							<?php echo $message;?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
  	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-calculator"></i> My Account</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table" style="margin-bottom:13px;">
					<tbody>
					<tr class="active" style="font-weight:bold;">
						<td class="text-center" scope="col">상태</td>
						<td class="text-center" scope="col">신청일</td>
						<td class="text-center" scope="col">접수번호</td>
						<td class="text-center" scope="col">신청금액</td>
						<td class="text-center" scope="col">출금방법</td>
					</tr>
					<?php for ($i=0; $i < count($account); $i++) { ?>
						<tr>
							<td class="text-center"><?php echo $account[$i]['pp_confirm'];?></td>
							<td class="text-center"><?php echo $account[$i]['pp_date'];?></td>
							<td class="text-center"><?php echo $account[$i]['pp_no'];?></td>
							<td class="text-right"><?php echo number_format($account[$i]['pp_amount']);?></td>
							<td class="text-center"><?php echo $account[$i]['pp_means'];?></td>
						</tr>
					<?php } ?>
					<?php if ($i == 0) { ?>
						<tr><td colspan="5" class="text-center">등록된 자료가 없습니다.</td></tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
                <div class="text-right font-14 en">
                  <a href="./?ap=paylist">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
			</div>
		</div>
	</div>
</div><!-- /.row -->
