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
	.html_tbl th { border-bottom:1px solid #ddd; padding:0px; padding:7px 0px !important; }
	.html_tbl td { border-bottom:1px solid #ddd; padding:7px 0px !important; }
	.html_tbl2{	width:100%; border-collapse:collapse; border:0px; border-top:3px solid #000; padding:0px; margin:0px; } 
	.html_tbl2 th{ text-align:center; border-bottom:1px solid #ddd; padding:0px; padding:7px 0px !important; }
	.html_tbl2 td { border-bottom:1px solid #ddd; padding:7px 0px !important; text-align:center; }
	ol.ul_li li {  list-style:disc; }
	.p_txt { color:red; font-weight:bold  }
	.pt { text-align:center; }
	#disclaimer .box { display:block; margin: 20px 0px; padding: 15px 30px 15px 15px; border-left-color: rgb(238, 238, 238); border-left-width: 5px; border-left-style: solid; line-height:22px; }
	#disclaimer .danger { border-color: rgb(223, 181, 180); background-color: rgb(252, 242, 242); }
	#disclaimer .warning { border-color: rgb(241, 231, 188); background-color: rgb(254, 251, 237); }
	#disclaimer .info { border-color: rgb(208, 227, 240); background-color: rgb(240, 247, 253); }
	#disclaimer .black { margin:0px; color:#fff; font-weight:bold; border-color: rgb(0, 0, 0); background-color: rgb(51, 51, 51); }
	#disclaimer .gray { border-color: rgb(221, 221, 221); background-color: rgb(250, 250, 250); }
</style>

<div id="disclaimer" class="html_content">

<div class="box black"><i class="fa fa-chevron-circle-right"></i> 책임의 한계</div>

<p>본 사이트는 링크, 다운로드, 광고 등을 포함하여 본 사이트에 포함되어 있거나, 본 사이트를 통해 배포, 전송되거나, 본 사이트에 포함되어 있는 서비스로부터 접근되는 정보(이하 "자료")의 정확성이나 신뢰성에 대해 어떠한 보증도 하지 않으며, 서비스상의, 또는 서비스와 관련된 광고, 기타 정보 또는 제안의 결과로서 디스플레이, 구매 또는 취득하게 되는 제품 또는 기타 정보(이하 "제품")의 질에 대해서도 어떠한 보증도 하지 않습니다.</p>

<p>귀하는 자료에 대한 신뢰 여부가 전적으로 귀하의 책임임을 인정합니다. 사이트는 자료 및 서비스의 내용을 수정할 의무를 지지 않으나, 필요에 따라 개선할 수는 있습니다.</p>

<p>사이트는 자료와 서비스를 "있는 그대로" 제공하며, 서비스 또는 기타 자료 및 제품과 관련하여 상품성, 특정 목적에의 적합성에 대한 보증을 포함하되 이에 제한되지 않고 모든 명시적 또는 묵시적인 보증을 명시적으로 부인합니다. 어떠한 경우에도 서비스, 자료 및 제품과 관련하여 직접, 간접, 부수적, 징벌적, 파생적인 손해에 대해서 책임을 지지 않습니다.</p>

<p>본 사이트를 통하여 인터넷을 접속함에 있어 사용자의 개인적인 판단에 따라 하시기를 바랍니다. </p>

<p>본 사이트를 통해 일부 사람들이 불쾌하거나 부적절 하다고 여기는 정보가 포함되어 있는 사이트로 연결될 수 있습니다. 
이와 관련하여 본 사이트 또는 자료에 열거되어 있는 사이트의 내용을 검토하려는 노력과 관련하여 어떠한 보증도 하지 않습니다. 또한 본 사이트 또는 자료에 열거되어 있는 사이트 상의 자료의 정확성, 저작권 준수, 적법성 또는 도덕성에 대해 아무런 책임을 지지 않습니다. </p>

<p>본 사이트는 지적재산권을 포함한 타인의 권리를 존중하며, 사용자들도 마찬가지로 행동해 주시기를 기대합니다. 본 사이트는 필요한 경우 그 재량에 의해 타인의 권리를 침해하거나 위반하는 사용자에 대하여 사전 통지 없이 서비스 이용 제한 조치를 취할 수 있습니다.</p> 

<div class="box gray"><b><i class="fa fa-chevron-circle-right"></i> 책임의 한계와 법적고지의 변경</b></div>

<p>본 사이트는 책임의 한계와 법적고지의 내용을 인터넷산업의 상관례에 맞추어 적절한 방법으로 사전 통지없이 수시로 변경할 수 있습니다. </p>

<div class="box gray"><b><i class="fa fa-chevron-circle-right"></i> 책임의 한계와 법적고지의 효력</b></div>

<p>책임의 한계와 법적고지사항에서 다루고 있는 세부사항들은 관계당사자들간의 총체적인 합의사항이며, 본 사이트의 개별서비스에서 정하고 있는 별도의 약관, 고지사항 등과 상충되는 경우에는 별도의 약관 또는 고지사항을 우선 적용합니다. </p>

</div>

<br><br><br>