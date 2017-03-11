<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<script>
	var sw_url = "<?php echo THEMA_URL;?>";
	var sw_bgcolor = "<?php echo $at_set['body_bgcolor'];?>";
</script>
<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/switcher.css">
<link rel="stylesheet" href="<?php echo THEMA_URL;?>/assets/css/spectrum.css">
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/switcher.js"></script>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/spectrum.js"></script>

<section id="style-switcher">
	<a href="#" class="widget-setup" title="위젯 설정"><i class="fa fa-cogs"></i></a>
	<h2>Style Switcher <a href="#" title="레이아웃 설정"><i class="fa fa-desktop"></i></a></h2>
	<div>
		<div class="switcher-style">
			<label>
				<span class="pull-right"><input type="checkbox" id="switcher-fixed" name="switcher_fixed"></span>
				1. No Fixed Switcher
			</label>
		</div>
		<?php if($is_admin && !$pv) { // 관리자일 경우에만 컬러셋 변경과 값저장 가능하도록 함 ?>
			<form id="themaSwitcher" name="themaSwitcher" action="<?php echo $at_href['switcher_submit'];?>" method="post" onsubmit="return switcher_submit(this);">
			<input type="hidden" name="sw_type" value="<?php echo $sw_type;?>">
			<input type="hidden" name="sw_code" value="<?php echo $sw_code;?>">
			<input type="hidden" name="sw_thema" value="<?php echo THEMA;?>">
			<input type="hidden" name="url" value="<?php echo urldecode($urlencode);?>">
			<input type="hidden" name="at_set[thema]" value="<?php echo THEMA;?>">
		<?php } ?>
		<h3>2. Thema Colorset</h3>
		<div class="layout-style">
			<select id="colorset-style" name="colorset">
				<?php //Colorset
					$srow = thema_switcher('thema', 'colorset', COLORSET);
					for($i=0; $i < count($srow); $i++) {
				?>
					 <option value="<?php echo $srow[$i]['value'];?>"<?php echo ($srow[$i]['selected']) ? ' selected' : '';?>>
						<?php echo $srow[$i]['name'];?>
					</option>
				<?php } ?>
			</select>
		</div>
		<h3>3. Layout Style</h3>
		<div class="layout-style">
			<select id="layout-style" name="at_set[layout]">
				<option value="">Wide</option>
				<option value="boxed"<?php echo ($at_set['layout'] == "boxed") ? ' selected' : '';?>>Boxed</option>
			</select>
		</div>

		<h3>4. Body Background</h3>
		<input type='hidden' id="input-body-background" name="at_set[body_background]" value="<?php echo $at_set['body_background'];?>">
		<div class="color-style">
			<input type='text' class="body-bgcolor" name="at_set[body_bgcolor]" value="<?php echo $at_set['body_bgcolor'];?>">
		</div>
		<p style="margin:8px 0px 15px;">
			<a role="button" class="switcher-win btn btn-black btn-sm btn-block" target="_balnk" href="<?php echo $at_href['switcher'];?>&amp;type=html&amp;fid=input-body-background&amp;cid=body-background">
				<i class="fa fa-picture-o"></i> 배경이미지선택
			</a>
		</p>

		<h3>5. LNB Style</h3>
		<div class="layout-style">
			<select id="lnb-style" name="at_set[lnb]">
				<option value="">White</option>
				<option value="at-lnb-gray"<?php echo ($at_set['lnb'] == "at-lnb-gray") ? ' selected' : '';?>>Gray</option>
				<option value="at-lnb-dark"<?php echo ($at_set['lnb'] == "at-lnb-dark") ? ' selected' : '';?>>Black</option>
			</select>
		</div>

		<h3>6. Menu Style</h3>
		<div class="layout-style">
			<select id="menu-style" name="at_set[menu]">
				<option value="">White</option>
				<option value="navbar-contrasted"<?php echo ($at_set['menu'] == "navbar-contrasted") ? ' selected' : '';?>>Contrasted</option>
			</select>
		</div>

		<h3>7. Head Style - Save</h3>
		<div class="layout-style">
			<select id="header-style" name="at_set[header]">
				<option value="">Normal</option>
				<option value="1"<?php echo ($at_set['header']) ? ' selected' : '';?>>Fixed</option>
			</select>
		</div>

		<h3>8. Main Style - Save</h3>
		<div class="layout-style">
			<select id="main-style" name="at_set[main]">
				<option value="13">Wide One Page</option>
				<option value="12"<?php echo ($at_set['main'] == "12") ? ' selected' : '';?>>Boxed One Page</option>
				<option value="9"<?php echo ($at_set['main'] == "9") ? ' selected' : '';?>>Large Column Grid</option>
				<option value="8"<?php echo ($at_set['main'] == "8") ? ' selected' : '';?>>Medium Column Grid</option>
				<option value="7"<?php echo ($at_set['main'] == "7") ? ' selected' : '';?>>Small Column Grid</option>
			</select>
		</div>

		<h3>9. Page Style - Save</h3>
		<div class="layout-style">
			<select id="page-style" name="at_set[page]">
				<option value="9">Large Column Grid</option>
				<option value="8"<?php echo ($at_set['page'] == "8") ? ' selected' : '';?>>Medium Column Grid</option>
				<option value="7"<?php echo ($at_set['page'] == "7") ? ' selected' : '';?>>Small Column Grid</option>
				<option value="12"<?php echo ($at_set['page'] == "12") ? ' selected' : '';?>>Boxed One Page</option>
				<option value="13"<?php echo ($at_set['page'] == "13") ? ' selected' : '';?>>Wide One Page</option>
			</select>
		</div>

		<h3>10. Side Style - Save</h3>
		<div class="layout-style">
			<select id="side-style" name="at_set[side]">
				<option value="">Right</option>
				<option value="1"<?php echo ($at_set['side']) ? ' selected' : '';?>>Left</option>
			</select>
		</div>

		<h3>11. Font Style</h3>
		<div class="layout-style">
			<select id="font-style" name="at_set[font]">
				<option value="">English</option>
				<option value="ko"<?php echo ($at_set['font'] == "ko") ? ' selected' : '';?>>Korean</option>
			</select>
		</div>
		<?php if($is_admin && !$pv) { ?>
				<div class="save-style at-thema">
					<button class="btn btn-black btn-sm btn-block" type="submit"><i class="fa fa-check"></i> Save</button>
				</div>
			</form>
			<script>
				function switcher_submit(f) {
					if(confirm("<?php echo $sw_msg;?>의 설정으로 저장하시겠습니까?")) {
						return true;
					}
					return false;
				}
			</script>
		<?php } ?>
	</div>
</section>
