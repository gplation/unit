<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<style>
	.html_title { padding:25px 12px 12px; margin:0px 0px 15px; border:10px solid #efefef; }
	.html_title .html_name { font-weight:bold; font-size:26px; color:#333; letter-spacing:-1px; }
	.html_title .html_desc { font:normal 12px dotum; color:#888; letter-spacing:-1px; }
	.html_content { line-height:1.8; word-break: keep-all; word-wrap: break-word; padding:20px; }
	.html_content .sub_title { color:#0083B9; font-weight:bold; padding-top:30px; padding-bottom:10px; }
	.html_content ul, .html_content ul li { list-style:none; padding:0px; margin:0px; font-weight:normal; }
	.html_content ol { margin-top:0px; margin-bottom:0px; }
	.html_content p { margin:15px 0; padding:0; }
	.html_video { width:640px; height:360px; margin:0px auto; border:10px solid #efefef; background:#efefef; }
	.html_outline li { padding:10px 0px !important; border-bottom:1px solid #ddd; }
	.html_outline li.li_title { padding:40px 0px 10px !important; border-bottom:2px solid #DCE2E2; color:#0083B9; font-weight:bold; }
	.html_tbl {	width:100%; border-collapse:collapse; border:0px; border-top:3px solid #000; padding:0px; margin:0px; } 
	.html_tbl th { border-bottom:1px solid #ddd; padding:0px; padding:7px 0px !important; text-align:center; }
	.html_tbl td { border-bottom:1px solid #ddd; padding:7px 0px !important; }
	.html_tbl2{	width:100%; border-collapse:collapse; border:0px; border-top:3px solid #000; padding:0px; margin:0px; } 
	.html_tbl2 th{ text-align:center; border-bottom:1px solid #ddd; padding:0px; padding:7px 0px !important; }
	.html_tbl2 td { border-bottom:1px solid #ddd; padding:7px 0px !important; text-align:center; }
	ol.ul_li li {  list-style:disc; }
	.p_txt { color:red; font-weight:bold  }
	.pt { text-align:center; }
	#guide .box { display:block; margin: 20px 0px; padding: 15px 30px 15px 15px; border-left-color: rgb(238, 238, 238); border-left-width: 5px; border-left-style: solid; line-height:22px; }
	#guide .danger { border-color: rgb(223, 181, 180); background-color: rgb(252, 242, 242); }
	#guide .warning { border-color: rgb(241, 231, 188); background-color: rgb(254, 251, 237); }
	#guide .info { border-color: rgb(208, 227, 240); background-color: rgb(240, 247, 253); }
	#guide .black { margin:0px; color:#fff; font-weight:bold; border-color: rgb(0, 0, 0); background-color: rgb(51, 51, 51); }
	#guide .gray { border-color: rgb(221, 221, 221); background-color: rgb(250, 250, 250); }
</style>

<div id="guide" class="html_content">

<div class="box black"><i class="fa fa-chevron-circle-right"></i> 이용시 주의사항</div>

<p>본 사이트 이용시 기본적으로 아래 4가지 사항은 반드시 지켜주세요.</p>

<ol>
	<li><b>무분별한 비방성글이나 욕설 금지</b>
	<li><b>무분별한 광고글 및 불법자료 관련글 금지</b>
	<li><b>개인정보 또는 금전거래를 목적으로 하는 글 금지</b>
	<li><b>펌글 또는 이미지는 반드시 출처 기록(저작권 문제)</b>
</ol>


<p>해당되는 게시물은 발견 즉시 차단되며, 해당 게시물을 작성한 회원은 불량회원이 되어 일정기간 접속이 차단됩니다.
욕설이나 광고글 등 분위기를 어지럽히는 글작성으로 차된되거나 불량회원이 되시면 직접 탈퇴하는 것이 불가능하니 주의해 주시길 바랍니다.</p>
                  
<div class="box black"><i class="fa fa-chevron-circle-right"></i> 회원등급 제도 안내</div>

<p>본 사이트는 회원등급에 따라 이용하실 수 있는 서비스에 차이가 발생할 수 있습니다.</p>

<table border=0 class="html_tbl2">
<col width=100><col width=200>
<thead>
<tr><th scope="col">회원등급</th><th scope="col">등급명</th><th scope="col">설명</th><th scope="col">비고</th></tr>
</thead>
<tbody>
<tr><td>Ⅰ</td><td><?php echo $xp['xp_grade1'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅱ</td><td><?php echo $xp['xp_grade2'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅲ</td><td><?php echo $xp['xp_grade3'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅳ</td><td><?php echo $xp['xp_grade4'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅴ</td><td><?php echo $xp['xp_grade5'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅵ</td><td><?php echo $xp['xp_grade6'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅶ</td><td><?php echo $xp['xp_grade7'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅷ</td><td><?php echo $xp['xp_grade8'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅸ</td><td><?php echo $xp['xp_grade9'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Ⅹ</td><td><?php echo $xp['xp_grade10'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
</tbody>
</table>

<br>

<div class="box black"><i class="fa fa-chevron-circle-right"></i> 포인트 제도 안내</div>

<p>본 사이트는 사이트 활성화와 다양한 혜택을 서비스하기 위해 포인트 제도를 운영하고 있습니다.</p>
<ol>
	<li> 포인트 정책은 수시로 변경될 수 있으며, 이를 별도로 통보하지 않습니다.
	<li> 포인트 획득을 위한 도배 및 어뷰징 등의 행위자는 통보없이 "포인트 몰수" 또는 "회원정지" 또는 "사이트 접근차단" 등의 조치를 받을 수 있습니다.
	<li> 적립된 포인트는 사이트내 서비스를 이용하는 목적 이외의 어떠한 효력도 갖고 있지 않습니다.
	<li> 회원가입시 <span class="p_txt"><?php echo number_format($config['cf_register_point']);?></span> 포인트 적립(1회), 로그인시  <span class="p_txt"><?php echo number_format($config['cf_login_point']);?></span> 포인트 적립(매일), 쪽지발송 시 <span class="p_txt"><?php echo number_format($config['cf_memo_send_point']);?></span> 포인트 차감(매회)
</ol>

<br>

<table border=0 class="html_tbl">
<thead>
<tr>
<th scope="col">그룹</th>
<th scope="col">보드</th>
<th scope="col">읽기</th>
<th scope="col">쓰기</th>
<th scope="col">댓글</th>
<th scope="col">다운</th>
</tr>
</thead>
<tbody>
<?php
	for ($i=1; $i < count($menu); $i++) { //메뉴출력 - 배열 0번은 전체통계이므로 1번부터 출력함

		if(!$menu[$i]['sg']) continue;

		$rowspan_cnt = count($menu[$i]['sub']);

		$rowspan = 0;
		for($k=0; $k < $rowspan_cnt; $k++) {
			if($menu[$i]['sub'][$k]['is_page']) continue;
			$rowspan++;
		}
		
		$rs = 0;
		for($k=0; $k < $rowspan_cnt; $k++) {

			if($menu[$i]['sub'][$k]['is_page']) continue;

			$row2 = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$menu[$i]['sub'][$k]['bo_table']}' limit 0,1 ", false);

			$read_point = $row2['bo_read_point'] ? number_format($row2['bo_read_point']) : '-';
			$write_point = $row2['bo_write_point'] ? number_format($row2['bo_write_point']) : '-';
			$cmt_point = $row2['bo_comment_point'] ? number_format($row2['bo_comment_point']) : '-';
			$down_point = $row2['bo_download_point'] ? number_format($row2['bo_download_point']) : '-';
		?>
		<tr>
		<?php if($rs == 0) { ?>
			<td rowspan="<?php echo $rowspan;?>" align="center"><a href="<?php echo $menu[$i]['href']; ?>"<?php echo $menu[$i]['target']; ?>><b><?php echo $menu[$i]['name']; ?></b></a></td>
		<?php } ?>
		<td><a href="<?php echo $menu[$i]['sub'][$k]['href']; ?>"<?php echo $menu[$i]['sub'][$k]['target']; ?>><?php echo $menu[$i]['sub'][$k]['name']; ?></a></td>
		<td class="pt"><?php echo $read_point;?></td>
		<td class="pt"><?php echo $write_point;?></td>
		<td class="pt"><?php echo $cmt_point;?></td>
		<td class="pt"><?php echo $down_point;?></td>
		</tr>
	<?php $rs++; } ?>
<?php } ?>
</tbody>
</table>

<br>

<div class="box black"><i class="fa fa-chevron-circle-right"></i> 레벨별 경험치 안내</div>

<?php
	//Exp
	$xp_point = $xp['xp_point'];
	$xp_max = $xp['xp_max'];
	$xp_rate = $xp['xp_rate'];
?>

<table border=0 class="html_tbl2">
<col width=100><col width=160><col width=160><col width=160>
<thead>
<tr>
<th scope="col">레벨</th>
<th scope="col">최소 경험치</th>
<th scope="col">최대 경험치</th>
<th scope="col">레벨업 경험치</th>
<th scope="col">비고</th>
</tr>
</thead>
<tbody>
<tr>
<td><b><?php echo xp_icon('@member', 1);?></b></td>
<td>0</td>
<td><?php echo number_format($xp_point);?></td>
<td><?php echo number_format($xp_point);?></td>
<td></td>
</tr>
<?php
	$min_xp = $xp_point;
	for ($i=2; $i <= $xp_max; $i++) {
		$xp_plus = $xp_point + $xp_point * ($i - 1) * $xp_rate;
		$max_xp = $min_xp + $xp_plus;
?>
	<tr>
	<td><b><?php echo xp_icon('@member', $i);?></b></td>
	<td><?php echo number_format($min_xp);?></td>
	<td><?php echo number_format($max_xp);?></td>
	<td><?php echo number_format($xp_plus);?></td>
	<td>&nbsp;</td>
	</tr>
		
<?php $min_xp = $max_xp; } ?>
<tr bgcolor="#fafafa">
<td><?php echo xp_icon('@admin', 0);?></td>
<td>관리자</td>
<td>-</td>
<td>-</td>
<td></td>
</tr>
<tr bgcolor="#fafafa">
<td><?php echo xp_icon('@special', 0);?></td>
<td>스페셜</td>
<td>-</td>
<td>-</td>
<td></td>
</tr>
</tbody>
<tfoot>
<tr bgcolor="#fafafa">
<td><?php echo xp_icon('', 0);?></td>
<td>비회원</td>
<td>-</td>
<td>-</td>
<td></td>
</tr>
</tfoot>
</table>

<br>

<div class="box black"><i class="fa fa-chevron-circle-right"></i> 게시물 규제정책</div>

<p>본 사이트의 게시물 규제정책은 방송통신심의위원회의 SafeNet 등급기준에 대한 연령별 권장사항 중 12세 이상 (중학생가) 레벨을 따르고자 노력합니다.</p>

<p>본 사이트의 각종 게시판에 게시자가 올린 게시물이 아래과 같은 게시물에 해당되는 경우 관리자는 사전 통지 없이 해당 게시물을 삭제할 수 있으며, 이를 작성한 게시자는 웹사이트의 이용이 차단될 수 있습니다. 또한, 명예훼손 및 저작권침해에 해당 되는 내용에 대해서는 사이버 명예 훼손 분쟁 조정부(http://www.bj.or.kr) 또는 저작권 보호센터(http://www.cleancopyright.or.kr)에 신고될 수 있습니다.</p>

<ol>
	<li>인종이나 성(性), 국적, 종교적, 정치적 분쟁 등 사회문화적 편견에 기반을 둔 내용의 글
	<li>자신 또는 타인의 전화번호, 주민등록번호, 실명등의 개인정보를 포함하고 있는 글
	<li>회사가 인정하지 않는 프로그램, 부적절한 파일 등의 유포나 사용을 유도하는 글
	<li>회사에서 규정한 게시물 원칙에 어긋나거나, 게시판 성격에 부합하지 않는 글
	<li>와레즈사이트, 토렌트사이트 또는 이와 유사한 사이트를 소개, 권유하는 글
	<li>회사 또는 회사 임직원을 사칭하거나 회사 및 회사 임직원을 비방하는 글
	<li>회사에서 판매하였거나 판매하는 제품을 허락없이 재판매하는 글
	<li>같은 내용을 의도적으로 수 차례에 걸쳐 반복적으로 게재한 글
	<li>도배 또는 욕설, 음란한 단어 및 표현을 포함한 글
	<li>이용약관 및 관련법령에 위배되는 내용의 글
	<li>현행법상 처벌의 근거가 되는 글
	<li>관계법령에 위배된다고 판단되는 글
	<li>불법복제 또는 해킹을 조장하는 내용의 글
	<li>저작권 침해 및 이와 유사한 내용을 담은 글
	<li>타인에게 불쾌감이나 혐오감을 줄 수 있는 글
	<li>기타 게시판의 성격에 맞지 않는다고 판단되는 글
	<li>기타 정당한 권한 없이 타인의 권리를 침해하는 내용
	<li>공공질서 및 미풍양속에 위반되는 내용이나 링크를 포함한 글
	<li>회사의 자산을 악의적으로 평가 저하시키려는 내용이 포함된 글
	<li>계정거래, 현금거래 등 불법적인 시도 또는 타 고객들을 선동하는 글
	<li>허위사실을 유포하거나 다수의 고객에게 오해를 불러일으킬 수 있는 내용의 글
	<li>다른 회원 또는 제3자에게 불쾌감을 주거나 비방함으로써 명예를 손상시키는 글
	<li>회사 또는 타인을 비방하거나 중상 모략으로 명예를 훼손시키거나 모욕을 주는 글
	<li>회사에서 인정하지 않은 영리를 목적으로 하거나 광고 및 홍보 또는 그와 유사한 내용임이 객관적으로 확인되는 글
</ol>

</div>

<br><br>
