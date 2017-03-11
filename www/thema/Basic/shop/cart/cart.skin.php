<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<script src="<?php echo THEMA_URL;?>/shop/shop.js"></script>

<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<div id="mod_option_box"></div>
	  </div>
    </div>
  </div>
</div>

<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $action_url; ?>" class="form" role="form">
    <div class="table-responsive">
		<table class="table bsk-tbl">
        <tbody>
        <tr class="bg-black">
            <th scope="col" align="center">
                <label for="ct_all" class="sound_only">상품 전체</label>
                <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
            </th>
			<th scope="col">이미지</th>
            <th scope="col">상품명</th>
            <th scope="col">총수량</th>
            <th scope="col">판매가</th>
            <th scope="col">소계</th>
            <th scope="col">포인트</th>
            <th scope="col">배송비</th>
		</tr>
		<?php for($i=0;$i < count($item); $i++) { ?>
			<tr>
				<td class="text-center">
					<label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
					<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
				</td>
				<td class="text-center">
					<div class="item-img">
						<?php echo get_it_image($item[$i]['it_id'], 100, 100); ?>
						<div class="item-type">
							<?php echo $item[$i]['pt_it']; ?>
						</div>
					</div>
				</td>
				<td>
					<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $item[$i]['it_id']; ?>">
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($item[$i]['it_name']); ?>">
					<a href="./item.php?it_id=<?php echo $item[$i]['it_id'];?>">
						<b><?php echo stripslashes($item[$i]['it_name']); ?></b>
					</a>
					<?php if($item[$i]['it_options']) { ?>
						<div class="well well-sm"><?php echo $item[$i]['it_options'];?></div>
						<button type="button" class="btn btn-primary btn-sm btn-block mod_options">선택사항수정</button>
					<?php } ?>
				</td>
				<td class="text-center"><?php echo number_format($item[$i]['qty']); ?></td>
				<td class="text-right"><?php echo number_format($item[$i]['ct_price']); ?></td>
				<td class="text-right"><span id="sell_price_<?php echo $i; ?>"><?php echo number_format($item[$i]['sell_price']); ?></span></td>
				<td class="text-right"><?php echo number_format($item[$i]['point']); ?></td>
				<td class="text-center"><?php echo $item[$i]['ct_send_cost']; ?></td>
			</tr>
		<?php } ?>
        <?php if ($i == 0) { ?>
            <tr><td colspan="7" class="text-center text-muted"><p style="padding:50px 0;">장바구니가 비어 있습니다.</p></td></tr>
		<?php } ?>
        </tbody>
        </table>
    </div>

    <?php if ($tot_price > 0 || $send_cost > 0) { ?>
		<div class="well">
			<div class="row">
				<?php if ($send_cost > 0) { // 배송비가 0 보다 크다면 (있다면) ?>
					<div class="col-xs-6">배송비</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($send_cost); ?> 원</strong>
					</div>
				<?php } ?>
				<?php if ($tot_price > 0) { ?>
					<div class="col-xs-6"> 총계 가격/포인트</div>
					<div class="col-xs-6 text-right">
						<strong><?php echo number_format($tot_price); ?> 원 / <?php echo number_format($tot_point); ?> 점</strong>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>

    <div style="margin-bottom:15px; text-align:center;">
        <?php if ($i == 0) { ?>
	        <a href="<?php echo G5_SHOP_URL; ?>/" class="btn btn-color btn-sm">계속하기</a>
        <?php } else { ?>
			<input type="hidden" name="url" value="./orderform.php">
			<input type="hidden" name="records" value="<?php echo $i; ?>">
			<input type="hidden" name="act" value="">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<div class="form-group">
						<button type="button" onclick="return form_check('buy');" class="btn btn-color btn-block btn-lg">주문하기</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn btn-black btn-block btn-sm">계속하기</a>
						</div>
						<div class="btn-group">
							<button type="button" onclick="return form_check('seldelete');" class="btn btn-black btn-block btn-sm">선택삭제</button>
						</div>
						<div class="btn-group">
							<button type="button" onclick="return form_check('alldelete');" class="btn btn-black btn-block btn-sm">비우기</button>
						</div>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
		<?php } ?>
    </div>

</form>


<script>
	$(function() {
		var close_btn_idx;

		// 선택사항수정
		$(".mod_options").click(function() {
			var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
			var $this = $(this);
			close_btn_idx = $(".mod_options").index($(this));
			$('#cartModal').modal('show');
			$.post(
				"./cartoption.php",
				{ it_id: it_id },
				function(data) {
					$("#mod_option_form").remove();
					//$this.after("<div id=\"mod_option_frm\"></div>");
					$("#mod_option_box").html(data);
					price_calculate();
				}
			);
		});

		// 모두선택
		$("input[name=ct_all]").click(function() {
			if($(this).is(":checked"))
				$("input[name^=ct_chk]").attr("checked", true);
			else
				$("input[name^=ct_chk]").attr("checked", false);
		});

		// 옵션수정 닫기
		$("#mod_option_close").live("click", function() {
			$('#cartModal').modal('hide');
			//$("#mod_option_frm").remove();
			$("#mod_option_form").remove();
			$(".mod_options").eq(close_btn_idx).focus();
		});
		$("#win_mask").click(function () {
			$('#cartModal').modal('hide');
			//$("#mod_option_frm").remove();
			$("#mod_option_form").remove();
			$(".mod_options").eq(close_btn_idx).focus();
		});

	});

	function form_check(act) {
		var f = document.frmcartlist;
		var cnt = f.records.value;

		if (act == "buy")
		{
			if($("input[name^=ct_chk]:checked").size() < 1) {
				alert("주문하실 상품을 하나이상 선택해 주십시오.");
				return false;
			}

			f.act.value = act;
			f.submit();
		}
		else if (act == "alldelete")
		{
			f.act.value = act;
			f.submit();
		}
		else if (act == "seldelete")
		{
			if($("input[name^=ct_chk]:checked").size() < 1) {
				alert("삭제하실 상품을 하나이상 선택해 주십시오.");
				return false;
			}

			f.act.value = act;
			f.submit();
		}

		return true;
	}
</script>
