<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//필요한 전역변수 선언
global $at_href, $stx, $q;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

?>

<form name="sideSearchbox" method="get" onsubmit="return side_search_submit(this);" role="form">
	<div class="form-group">
		<select name="opt" class="form-control input-sm">
			<?php if(IS_YC) { ?>
				<option value="<?php echo $at_href['isearch'];?>">아이템 검색</option>
				<option value="<?php echo $at_href['iuse'];?>">후기 검색</option>
				<option value="<?php echo $at_href['iqa'];?>">문의 검색</option>
			<?php } ?>
			<option value="<?php echo $at_href['search'];?>">포스트 검색</option>
			<option value="<?php echo $at_href['tag'];?>">태그 검색</option>
		</select>
	</div>
	<div class="input-group">
		<input type="text" name="stx" class="form-control input-sm" value="<?php echo ($q) ? $q : $stx;?>" placeholder="Search...">
		<span class="input-group-btn">
			<button class="btn btn-color btn-sm" type="submit"><i class="fa fa-search"></i></button>
		</span>	
	</div>
</form>
                        
<script>
	function side_search_submit(f) {

		if (f.stx.value.length < 2) {
			alert("검색어는 두글자 이상 입력하십시오.");
			f.stx.select();
			f.stx.focus();
			return false;
		}

		var url = f.opt.value;

		f.opt.value = '';

		if(url) {
			f.action = url;
		} else {
			f.action = "<?php echo (IS_YC) ? $at_href['isearch'] : $at_href['search'];?>";
		}
		return true;
	}
</script>