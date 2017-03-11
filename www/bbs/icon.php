<?php
include_once('./_common.php');
if(!defined('G5_IS_ADMIN')) {
	define('G5_IS_ADMIN', true);
}
include_once(G5_PATH.'/head.sub.php');
?>
<style>
	body { background:#fff; }
	a { color:#333; margin:7px; text-align:center; width:30px; line-height:30px; display:inline-block; text-decoration:none;}
	a:hover { color:crimson; text-decoration:none; }
	.icon-box { margin:10px 10px 30px; }
	.as-box { background:#333; color:#fff; padding:10px 15px; }
	.as-box-head b { font-family:tahoma; font-size:16px; }
	.input-box { 
		position:fixed;left:0;top:0;width:100%; border:0; background:rgb(223, 17, 25); padding:10px; text-align:center; z-index:2; 
		-webkit-box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
		-moz-box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
		box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
	}
</style>
<?php if(!$fid) { ?>
	<div class="input-box">
		<input type="text" id="fa_content" name="fa_content" value="" class="frm_input" placeholder="아이콘 선택 후 복사해서 붙여넣어 주세요." style="width:80%; height:24px;">
	</div>
	<div style="height:45px;"></div>
<?php } ?>

<div id="web-application">
	<div class="as-box as-box-head">
		<b>Web Application Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('adjust');"><i class="fa fa-adjust fa-2x"></i></a>    
		<a href="javascript:insert_icon('anchor');"><i class="fa fa-anchor fa-2x"></i></a>    
		<a href="javascript:insert_icon('archive');"><i class="fa fa-archive fa-2x"></i></a>    
		<a href="javascript:insert_icon('arrows');"><i class="fa fa-arrows fa-2x"></i></a>    
		<a href="javascript:insert_icon('arrows-h');"><i class="fa fa-arrows-h fa-2x"></i></a>    
		<a href="javascript:insert_icon('arrows-v');"><i class="fa fa-arrows-v fa-2x"></i></a>    
		<a href="javascript:insert_icon('asterisk');"><i class="fa fa-asterisk fa-2x"></i></a>    
		<a href="javascript:insert_icon('at');"><i class="fa fa-at fa-2x"></i></a>
		<a href="javascript:insert_icon('ban');"><i class="fa fa-ban fa-2x"></i></a>    
		<a href="javascript:insert_icon('bar-chart-o');"><i class="fa fa-bar-chart-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('barcode');"><i class="fa fa-barcode fa-2x"></i></a>    
		<a href="javascript:insert_icon('bars');"><i class="fa fa-bars fa-2x"></i></a>    
		<a href="javascript:insert_icon('bed');"><i class="fa fa-bed fa-2x"></i></a>    
		<a href="javascript:insert_icon('beer');"><i class="fa fa-beer fa-2x"></i></a>    
		<a href="javascript:insert_icon('bell');"><i class="fa fa-bell fa-2x"></i></a>    
		<a href="javascript:insert_icon('bell-o');"><i class="fa fa-bell-o fa-2x"></i></a>
		<a href="javascript:insert_icon('bell-slash');"><i class="fa fa-bell-slash fa-2x"></i></a>
		<a href="javascript:insert_icon('bell-slash-o');"><i class="fa fa-bell-slash-o fa-2x"></i></a>
		<a href="javascript:insert_icon('bicycle');"><i class="fa fa-bicycle fa-2x"></i></a>    
		<a href="javascript:insert_icon('binoculars');"><i class="fa fa-binoculars fa-2x"></i></a>    
		<a href="javascript:insert_icon('birthday-cake');"><i class="fa fa-birthday-cake fa-2x"></i></a>    
		<a href="javascript:insert_icon('bolt');"><i class="fa fa-bolt fa-2x"></i></a>    
		<a href="javascript:insert_icon('bomb');"><i class="fa fa-bomb fa-2x"></i></a>    
		<a href="javascript:insert_icon('book');"><i class="fa fa-book fa-2x"></i></a>    
		<a href="javascript:insert_icon('bookmark');"><i class="fa fa-bookmark fa-2x"></i></a>    
		<a href="javascript:insert_icon('bookmark-o');"><i class="fa fa-bookmark-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('briefcase');"><i class="fa fa-briefcase fa-2x"></i></a>    
		<a href="javascript:insert_icon('bug');"><i class="fa fa-bug fa-2x"></i></a>    
		<a href="javascript:insert_icon('building-o');"><i class="fa fa-building-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('bullhorn');"><i class="fa fa-bullhorn fa-2x"></i></a>    
		<a href="javascript:insert_icon('bullseye');"><i class="fa fa-bullseye fa-2x"></i></a>    
		<a href="javascript:insert_icon('bus');"><i class="fa fa-bus fa-2x"></i></a>    
		<a href="javascript:insert_icon('calculator');"><i class="fa fa-calculator fa-2x"></i></a>    
		<a href="javascript:insert_icon('calendar');"><i class="fa fa-calendar fa-2x"></i></a>    
		<a href="javascript:insert_icon('calendar-o');"><i class="fa fa-calendar-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('camera');"><i class="fa fa-camera fa-2x"></i></a>    
		<a href="javascript:insert_icon('camera-retro');"><i class="fa fa-camera-retro fa-2x"></i></a>    
		<a href="javascript:insert_icon('car');"><i class="fa fa-car fa-2x"></i></a>    
		<a href="javascript:insert_icon('caret-square-o-down');"><i class="fa fa-caret-square-o-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('caret-square-o-left');"><i class="fa fa-caret-square-o-left fa-2x"></i></a>    
		<a href="javascript:insert_icon('caret-square-o-right');"><i class="fa fa-caret-square-o-right fa-2x"></i></a>    
		<a href="javascript:insert_icon('caret-square-o-up');"><i class="fa fa-caret-square-o-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('cart-arrow-down');"><i class="fa fa-cart-arrow-down fa-2x"></i></a>
		<a href="javascript:insert_icon('cart-plus');"><i class="fa fa-cart-plus fa-2x"></i></a>    
		<a href="javascript:insert_icon('cc');"><i class="fa fa-cc fa-2x"></i></a>    
		<a href="javascript:insert_icon('certificate');"><i class="fa fa-certificate fa-2x"></i></a>    
		<a href="javascript:insert_icon('check');"><i class="fa fa-check fa-2x"></i></a>    
		<a href="javascript:insert_icon('check-circle');"><i class="fa fa-check-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('check-circle-o');"><i class="fa fa-check-circle-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('check-square');"><i class="fa fa-check-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('check-square-o');"><i class="fa fa-check-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('child');"><i class="fa fa-child fa-2x"></i></a>   
		<a href="javascript:insert_icon('circle');"><i class="fa fa-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('circle-o');"><i class="fa fa-circle-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('circle-o-notch');"><i class="fa fa-circle-o-notch fa-2x"></i></a>    
		<a href="javascript:insert_icon('circle-thin');"><i class="fa fa-circle-thin fa-2x"></i></a>    
		<a href="javascript:insert_icon('clock-o');"><i class="fa fa-clock-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('cloud');"><i class="fa fa-cloud fa-2x"></i></a>    
		<a href="javascript:insert_icon('cloud-download');"><i class="fa fa-cloud-download fa-2x"></i></a>    
		<a href="javascript:insert_icon('cloud-upload');"><i class="fa fa-cloud-upload fa-2x"></i></a>    
		<a href="javascript:insert_icon('code');"><i class="fa fa-code fa-2x"></i></a>    
		<a href="javascript:insert_icon('code-fork');"><i class="fa fa-code-fork fa-2x"></i></a>    
		<a href="javascript:insert_icon('coffee');"><i class="fa fa-coffee fa-2x"></i></a>    
		<a href="javascript:insert_icon('cog');"><i class="fa fa-cog fa-2x"></i></a>    
		<a href="javascript:insert_icon('cogs');"><i class="fa fa-cogs fa-2x"></i></a>    
		<a href="javascript:insert_icon('comment');"><i class="fa fa-comment fa-2x"></i></a>    
		<a href="javascript:insert_icon('comment-o');"><i class="fa fa-comment-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('comments');"><i class="fa fa-comments fa-2x"></i></a>    
		<a href="javascript:insert_icon('comments-o');"><i class="fa fa-comments-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('compass');"><i class="fa fa-compass fa-2x"></i></a>    
		<a href="javascript:insert_icon('copyright');"><i class="fa fa-copyright fa-2x"></i></a>    
		<a href="javascript:insert_icon('credit-card');"><i class="fa fa-credit-card fa-2x"></i></a>    
		<a href="javascript:insert_icon('crop');"><i class="fa fa-crop fa-2x"></i></a>    
		<a href="javascript:insert_icon('crosshairs');"><i class="fa fa-crosshairs fa-2x"></i></a>    
		<a href="javascript:insert_icon('cube');"><i class="fa fa-cube fa-2x"></i></a> 
		<a href="javascript:insert_icon('cubes');"><i class="fa fa-cubes fa-2x"></i></a> 
		<a href="javascript:insert_icon('cutlery');"><i class="fa fa-cutlery fa-2x"></i></a>    
		<a href="javascript:insert_icon('database');"><i class="fa fa-database fa-2x"></i></a> 
		<a href="javascript:insert_icon('desktop');"><i class="fa fa-desktop fa-2x"></i></a>    
		<a href="javascript:insert_icon('diamond');"><i class="fa fa-diamond fa-2x"></i></a>    
		<a href="javascript:insert_icon('dot-circle-o');"><i class="fa fa-dot-circle-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('download');"><i class="fa fa-download fa-2x"></i></a>    
		<a href="javascript:insert_icon('ellipsis-h');"><i class="fa fa-ellipsis-h fa-2x"></i></a>    
		<a href="javascript:insert_icon('ellipsis-v');"><i class="fa fa-ellipsis-v fa-2x"></i></a>    
		<a href="javascript:insert_icon('envelope');"><i class="fa fa-envelope fa-2x"></i></a>    
		<a href="javascript:insert_icon('envelope-o');"><i class="fa fa-envelope-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('envelope-square');"><i class="fa fa-envelope-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('eraser');"><i class="fa fa-eraser fa-2x"></i></a>    
		<a href="javascript:insert_icon('exchange');"><i class="fa fa-exchange fa-2x"></i></a>    
		<a href="javascript:insert_icon('exclamation');"><i class="fa fa-exclamation fa-2x"></i></a>    
		<a href="javascript:insert_icon('exclamation-circle');"><i class="fa fa-exclamation-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('exclamation-triangle');"><i class="fa fa-exclamation-triangle fa-2x"></i></a>    
		<a href="javascript:insert_icon('external-link');"><i class="fa fa-external-link fa-2x"></i></a>    
		<a href="javascript:insert_icon('external-link-square');"><i class="fa fa-external-link-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('eye');"><i class="fa fa-eye fa-2x"></i></a>    
		<a href="javascript:insert_icon('eye-slash');"><i class="fa fa-eye-slash fa-2x"></i></a>    
		<a href="javascript:insert_icon('eyedropper');"><i class="fa fa-eyedropper fa-2x"></i></a>    
		<a href="javascript:insert_icon('fax');"><i class="fa fa-fax fa-2x"></i></a>   
		<a href="javascript:insert_icon('female');"><i class="fa fa-female fa-2x"></i></a>    
		<a href="javascript:insert_icon('fighter-jet');"><i class="fa fa-fighter-jet fa-2x"></i></a>    
		<a href="javascript:insert_icon('film');"><i class="fa fa-film fa-2x"></i></a>    
		<a href="javascript:insert_icon('filter');"><i class="fa fa-filter fa-2x"></i></a>    
		<a href="javascript:insert_icon('fire');"><i class="fa fa-fire fa-2x"></i></a>    
		<a href="javascript:insert_icon('fire-extinguisher');"><i class="fa fa-fire-extinguisher fa-2x"></i></a>    
		<a href="javascript:insert_icon('flag');"><i class="fa fa-flag fa-2x"></i></a>    
		<a href="javascript:insert_icon('flag-checkered');"><i class="fa fa-flag-checkered fa-2x"></i></a>    
		<a href="javascript:insert_icon('flag-o');"><i class="fa fa-flag-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('flask');"><i class="fa fa-flask fa-2x"></i></a>    
		<a href="javascript:insert_icon('folder');"><i class="fa fa-folder fa-2x"></i></a>    
		<a href="javascript:insert_icon('folder-o');"><i class="fa fa-folder-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('folder-open');"><i class="fa fa-folder-open fa-2x"></i></a>    
		<a href="javascript:insert_icon('folder-open-o');"><i class="fa fa-folder-open-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('frown-o');"><i class="fa fa-frown-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('futbol-o');"><i class="fa fa-futbol-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('gamepad');"><i class="fa fa-gamepad fa-2x"></i></a>    
		<a href="javascript:insert_icon('gavel');"><i class="fa fa-gavel fa-2x"></i></a>    
		<a href="javascript:insert_icon('gift');"><i class="fa fa-gift fa-2x"></i></a>    
		<a href="javascript:insert_icon('glass');"><i class="fa fa-glass fa-2x"></i></a>    
		<a href="javascript:insert_icon('globe');"><i class="fa fa-globe fa-2x"></i></a>    
		<a href="javascript:insert_icon('graduation-cap');"><i class="fa fa-graduation-cap fa-2x"></i></a>    
		<a href="javascript:insert_icon('hdd-o');"><i class="fa fa-hdd-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('headphones');"><i class="fa fa-headphones fa-2x"></i></a>    
		<a href="javascript:insert_icon('heart');"><i class="fa fa-heart fa-2x"></i></a>    
		<a href="javascript:insert_icon('heart-o');"><i class="fa fa-heart-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('heartbeat');"><i class="fa fa-heartbeat fa-2x"></i></a>
		<a href="javascript:insert_icon('history');"><i class="fa fa-history fa-2x"></i></a>    
		<a href="javascript:insert_icon('home');"><i class="fa fa-home fa-2x"></i></a>    
		<a href="javascript:insert_icon('inbox');"><i class="fa fa-inbox fa-2x"></i></a>    
		<a href="javascript:insert_icon('info');"><i class="fa fa-info fa-2x"></i></a>    
		<a href="javascript:insert_icon('info-circle');"><i class="fa fa-info-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('key');"><i class="fa fa-key fa-2x"></i></a>    
		<a href="javascript:insert_icon('keyboard-o');"><i class="fa fa-keyboard-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('language');"><i class="fa fa-language fa-2x"></i></a>    
		<a href="javascript:insert_icon('laptop');"><i class="fa fa-laptop fa-2x"></i></a>    
		<a href="javascript:insert_icon('leaf');"><i class="fa fa-leaf fa-2x"></i></a>    
		<a href="javascript:insert_icon('lemon-o');"><i class="fa fa-lemon-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('level-down');"><i class="fa fa-level-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('level-up');"><i class="fa fa-level-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('life-ring');"><i class="fa fa-life-ring fa-2x"></i></a>    
		<a href="javascript:insert_icon('lightbulb-o');"><i class="fa fa-lightbulb-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('location-arrow');"><i class="fa fa-location-arrow fa-2x"></i></a>    
		<a href="javascript:insert_icon('lock');"><i class="fa fa-lock fa-2x"></i></a>    
		<a href="javascript:insert_icon('magic');"><i class="fa fa-magic fa-2x"></i></a>    
		<a href="javascript:insert_icon('magnet');"><i class="fa fa-magnet fa-2x"></i></a>    
		<a href="javascript:insert_icon('mail-reply-all');"><i class="fa fa-mail-reply-all fa-2x"></i></a>    
		<a href="javascript:insert_icon('male');"><i class="fa fa-male fa-2x"></i></a>    
		<a href="javascript:insert_icon('map-marker');"><i class="fa fa-map-marker fa-2x"></i></a>    
		<a href="javascript:insert_icon('meh-o');"><i class="fa fa-meh-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('microphone');"><i class="fa fa-microphone fa-2x"></i></a>    
		<a href="javascript:insert_icon('microphone-slash');"><i class="fa fa-microphone-slash fa-2x"></i></a>    
		<a href="javascript:insert_icon('minus');"><i class="fa fa-minus fa-2x"></i></a>    
		<a href="javascript:insert_icon('minus-circle');"><i class="fa fa-minus-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('minus-square');"><i class="fa fa-minus-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('minus-square-o');"><i class="fa fa-minus-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('mobile');"><i class="fa fa-mobile-phone fa-2x"></i></a>    
		<a href="javascript:insert_icon('money');"><i class="fa fa-money fa-2x"></i></a>    
		<a href="javascript:insert_icon('moon-o');"><i class="fa fa-moon-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('music');"><i class="fa fa-music fa-2x"></i></a>    
		<a href="javascript:insert_icon('newspaper-o');"><i class="fa fa-newspaper-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('paint-brush');"><i class="fa fa-paint-brush fa-2x"></i></a>    
		<a href="javascript:insert_icon('paper-plane');"><i class="fa fa-paper-plane fa-2x"></i></a>    
		<a href="javascript:insert_icon('paper-plane-o');"><i class="fa fa-paper-plane-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('paw');"><i class="fa fa-paw fa-2x"></i></a>    
		<a href="javascript:insert_icon('pencil');"><i class="fa fa-pencil fa-2x"></i></a>    
		<a href="javascript:insert_icon('pencil-square');"><i class="fa fa-pencil-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('pencil-square-o');"><i class="fa fa-pencil-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('phone');"><i class="fa fa-phone fa-2x"></i></a>    
		<a href="javascript:insert_icon('phone-square');"><i class="fa fa-phone-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('picture-o');"><i class="fa fa-picture-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('plane');"><i class="fa fa-plane fa-2x"></i></a>    
		<a href="javascript:insert_icon('plug');"><i class="fa fa-plug fa-2x"></i></a>    
		<a href="javascript:insert_icon('plus');"><i class="fa fa-plus fa-2x"></i></a>    
		<a href="javascript:insert_icon('plus-circle');"><i class="fa fa-plus-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('plus-square');"><i class="fa fa-plus-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('plus-square-o');"><i class="fa fa-plus-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('power-off');"><i class="fa fa-power-off fa-2x"></i></a>    
		<a href="javascript:insert_icon('print');"><i class="fa fa-print fa-2x"></i></a>    
		<a href="javascript:insert_icon('puzzle-piece');"><i class="fa fa-puzzle-piece fa-2x"></i></a>    
		<a href="javascript:insert_icon('qrcode');"><i class="fa fa-qrcode fa-2x"></i></a>    
		<a href="javascript:insert_icon('question');"><i class="fa fa-question fa-2x"></i></a>    
		<a href="javascript:insert_icon('question-circle');"><i class="fa fa-question-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('quote-left');"><i class="fa fa-quote-left fa-2x"></i></a>    
		<a href="javascript:insert_icon('quote-right');"><i class="fa fa-quote-right fa-2x"></i></a>    
		<a href="javascript:insert_icon('random');"><i class="fa fa-random fa-2x"></i></a>    
		<a href="javascript:insert_icon('recycle');"><i class="fa fa-recycle fa-2x"></i></a>    
		<a href="javascript:insert_icon('refresh');"><i class="fa fa-refresh fa-2x"></i></a>    
		<a href="javascript:insert_icon('reply');"><i class="fa fa-reply fa-2x"></i></a>    
		<a href="javascript:insert_icon('reply-all');"><i class="fa fa-reply-all fa-2x"></i></a>    
		<a href="javascript:insert_icon('retweet');"><i class="fa fa-retweet fa-2x"></i></a>    
		<a href="javascript:insert_icon('road');"><i class="fa fa-road fa-2x"></i></a>    
		<a href="javascript:insert_icon('rocket');"><i class="fa fa-rocket fa-2x"></i></a>    
		<a href="javascript:insert_icon('rss');"><i class="fa fa-rss fa-2x"></i></a>    
		<a href="javascript:insert_icon('rss-square');"><i class="fa fa-rss-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('search');"><i class="fa fa-search fa-2x"></i></a>    
		<a href="javascript:insert_icon('search-minus');"><i class="fa fa-search-minus fa-2x"></i></a>    
		<a href="javascript:insert_icon('search-plus');"><i class="fa fa-search-plus fa-2x"></i></a>    
		<a href="javascript:insert_icon('server');"><i class="fa fa-server fa-2x"></i></a>    
		<a href="javascript:insert_icon('share');"><i class="fa fa-share fa-2x"></i></a>    
		<a href="javascript:insert_icon('share-alt');"><i class="fa fa-share-alt fa-2x"></i></a>    
		<a href="javascript:insert_icon('share-alt-square');"><i class="fa fa-share-alt-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('share-square');"><i class="fa fa-share-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('share-square-o');"><i class="fa fa-share-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('shield');"><i class="fa fa-shield fa-2x"></i></a>    
		<a href="javascript:insert_icon('ship');"><i class="fa fa-ship fa-2x"></i></a>    
		<a href="javascript:insert_icon('shopping-cart');"><i class="fa fa-shopping-cart fa-2x"></i></a>    
		<a href="javascript:insert_icon('sign-in');"><i class="fa fa-sign-in fa-2x"></i></a>    
		<a href="javascript:insert_icon('sign-out');"><i class="fa fa-sign-out fa-2x"></i></a>    
		<a href="javascript:insert_icon('signal');"><i class="fa fa-signal fa-2x"></i></a>    
		<a href="javascript:insert_icon('sitemap');"><i class="fa fa-sitemap fa-2x"></i></a>    
		<a href="javascript:insert_icon('sliders');"><i class="fa fa-sliders fa-2x"></i></a>    
		<a href="javascript:insert_icon('smile-o');"><i class="fa fa-smile-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort');"><i class="fa fa-sort fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-alpha-asc');"><i class="fa fa-sort-alpha-asc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-alpha-desc');"><i class="fa fa-sort-alpha-desc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-amount-asc');"><i class="fa fa-sort-amount-asc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-amount-desc');"><i class="fa fa-sort-amount-desc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-asc');"><i class="fa fa-sort-asc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-desc');"><i class="fa fa-sort-desc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-asc');"><i class="fa fa-sort-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-numeric-asc');"><i class="fa fa-sort-numeric-asc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-numeric-desc');"><i class="fa fa-sort-numeric-desc fa-2x"></i></a>    
		<a href="javascript:insert_icon('sort-desc');"><i class="fa fa-sort-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('spinner');"><i class="fa fa-spinner fa-2x"></i></a>    
		<a href="javascript:insert_icon('spoon');"><i class="fa fa-spoon fa-2x"></i></a>    
		<a href="javascript:insert_icon('square');"><i class="fa fa-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('square-o');"><i class="fa fa-square-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('star');"><i class="fa fa-star fa-2x"></i></a>    
		<a href="javascript:insert_icon('star-half');"><i class="fa fa-star-half fa-2x"></i></a>    
		<a href="javascript:insert_icon('star-half-o');"><i class="fa fa-star-half-empty fa-2x"></i></a>    
		<a href="javascript:insert_icon('star-o');"><i class="fa fa-star-o fa-2x"></i></a>
		<a href="javascript:insert_icon('street-view');"><i class="fa fa-street-view fa-2x"></i></a>    		
		<a href="javascript:insert_icon('subscript');"><i class="fa fa-subscript fa-2x"></i></a>    
		<a href="javascript:insert_icon('suitcase');"><i class="fa fa-suitcase fa-2x"></i></a>    
		<a href="javascript:insert_icon('sun-o');"><i class="fa fa-sun-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('superscript');"><i class="fa fa-superscript fa-2x"></i></a>    
		<a href="javascript:insert_icon('tablet');"><i class="fa fa-tablet fa-2x"></i></a>    
		<a href="javascript:insert_icon('tachometer');"><i class="fa fa-tachometer fa-2x"></i></a>    
		<a href="javascript:insert_icon('tag');"><i class="fa fa-tag fa-2x"></i></a>    
		<a href="javascript:insert_icon('tags');"><i class="fa fa-tags fa-2x"></i></a>    
		<a href="javascript:insert_icon('tasks');"><i class="fa fa-tasks fa-2x"></i></a>    
		<a href="javascript:insert_icon('taxi');"><i class="fa fa-taxi fa-2x"></i></a>    
		<a href="javascript:insert_icon('terminal');"><i class="fa fa-terminal fa-2x"></i></a>    
		<a href="javascript:insert_icon('thumb-tack');"><i class="fa fa-thumb-tack fa-2x"></i></a>    
		<a href="javascript:insert_icon('thumbs-down');"><i class="fa fa-thumbs-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('thumbs-o-down');"><i class="fa fa-thumbs-o-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('thumbs-o-up');"><i class="fa fa-thumbs-o-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('thumbs-up');"><i class="fa fa-thumbs-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('ticket');"><i class="fa fa-ticket fa-2x"></i></a>    
		<a href="javascript:insert_icon('times');"><i class="fa fa-times fa-2x"></i></a>    
		<a href="javascript:insert_icon('times-circle');"><i class="fa fa-times-circle fa-2x"></i></a>    
		<a href="javascript:insert_icon('times-circle-o');"><i class="fa fa-times-circle-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('tint');"><i class="fa fa-tint fa-2x"></i></a>    
		<a href="javascript:insert_icon('toggle-off');"><i class="fa fa-toggle-off fa-2x"></i></a>    
		<a href="javascript:insert_icon('toggle-on');"><i class="fa fa-toggle-on fa-2x"></i></a>    
		<a href="javascript:insert_icon('trash');"><i class="fa fa-trash fa-2x"></i></a>    
		<a href="javascript:insert_icon('trash-o');"><i class="fa fa-trash-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('tree');"><i class="fa fa-tree fa-2x"></i></a>    
		<a href="javascript:insert_icon('trophy');"><i class="fa fa-trophy fa-2x"></i></a>    
		<a href="javascript:insert_icon('tty');"><i class="fa fa-tty fa-2x"></i></a>    
		<a href="javascript:insert_icon('truck');"><i class="fa fa-truck fa-2x"></i></a>    
		<a href="javascript:insert_icon('umbrella');"><i class="fa fa-umbrella fa-2x"></i></a>    
		<a href="javascript:insert_icon('university');"><i class="fa fa-university fa-2x"></i></a>    
		<a href="javascript:insert_icon('unlock');"><i class="fa fa-unlock fa-2x"></i></a>    
		<a href="javascript:insert_icon('unlock-alt');"><i class="fa fa-unlock-alt fa-2x"></i></a>    
		<a href="javascript:insert_icon('upload');"><i class="fa fa-upload fa-2x"></i></a>    
		<a href="javascript:insert_icon('user');"><i class="fa fa-user fa-2x"></i></a>    
		<a href="javascript:insert_icon('user-plus');"><i class="fa fa-user-plus fa-2x"></i></a>
		<a href="javascript:insert_icon('user-secret');"><i class="fa fa-user-secret fa-2x"></i></a>
		<a href="javascript:insert_icon('user-times');"><i class="fa fa-user-times fa-2x"></i></a>    
		<a href="javascript:insert_icon('users');"><i class="fa fa-users fa-2x"></i></a>    
		<a href="javascript:insert_icon('video-camera');"><i class="fa fa-video-camera fa-2x"></i></a>    
		<a href="javascript:insert_icon('volume-down');"><i class="fa fa-volume-down fa-2x"></i></a>    
		<a href="javascript:insert_icon('volume-off');"><i class="fa fa-volume-off fa-2x"></i></a>    
		<a href="javascript:insert_icon('volume-up');"><i class="fa fa-volume-up fa-2x"></i></a>    
		<a href="javascript:insert_icon('wheelchair');"><i class="fa fa-wheelchair fa-2x"></i></a>    
		<a href="javascript:insert_icon('wifi');"><i class="fa fa-wifi fa-2x"></i></a>    
		<a href="javascript:insert_icon('wrench');"><i class="fa fa-wrench fa-2x"></i></a>    
	</div>
</div>


<div id="transportation">
	<div class="as-box as-box-head">
		<b>Transportation Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('ambulance');"><i class="fa fa-ambulance fa-2x"></i></a>    
		<a href="javascript:insert_icon('bicycle');"><i class="fa fa-bicycle fa-2x"></i></a>    
		<a href="javascript:insert_icon('bus');"><i class="fa fa-bus fa-2x"></i></a>    
		<a href="javascript:insert_icon('car');"><i class="fa fa-car fa-2x"></i></a>    
		<a href="javascript:insert_icon('fighter-jet');"><i class="fa fa-fighter-jet fa-2x"></i></a>    
		<a href="javascript:insert_icon('motorcycle');"><i class="fa fa-motorcycle fa-2x"></i></a>    
		<a href="javascript:insert_icon('plane');"><i class="fa fa-plane fa-2x"></i></a>    
		<a href="javascript:insert_icon('rocket');"><i class="fa fa-rocket fa-2x"></i></a>    
		<a href="javascript:insert_icon('ship');"><i class="fa fa-ship fa-2x"></i></a>    
		<a href="javascript:insert_icon('space-shuttle');"><i class="fa fa-space-shuttle fa-2x"></i></a>    
		<a href="javascript:insert_icon('subway');"><i class="fa fa-subway fa-2x"></i></a>    
		<a href="javascript:insert_icon('taxi');"><i class="fa fa-taxi fa-2x"></i></a>    
		<a href="javascript:insert_icon('train');"><i class="fa fa-train fa-2x"></i></a>    
		<a href="javascript:insert_icon('truck');"><i class="fa fa-truck fa-2x"></i></a>    
		<a href="javascript:insert_icon('wheelchair');"><i class="fa fa-wheelchair fa-2x"></i></a>    
	</div>
</div>

<div id="transportation">
	<div class="as-box as-box-head">
		<b>Gender Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('circle-thin');"><i class="fa fa-circle-thin fa-2x"></i></a>    
		<a href="javascript:insert_icon('mars');"><i class="fa fa-mars fa-2x"></i></a>    
		<a href="javascript:insert_icon('mars-double');"><i class="fa fa-mars-double fa-2x"></i></a>    
		<a href="javascript:insert_icon('mars-stroke');"><i class="fa fa-mars-stroke fa-2x"></i></a>    
		<a href="javascript:insert_icon('mars-stroke-h');"><i class="fa fa-mars-stroke-h fa-2x"></i></a>    
		<a href="javascript:insert_icon('mars-stroke-v');"><i class="fa fa-mars-stroke-v fa-2x"></i></a>    
		<a href="javascript:insert_icon('mercury');"><i class="fa fa-mercury fa-2x"></i></a>    
		<a href="javascript:insert_icon('neuter');"><i class="fa fa-neuter fa-2x"></i></a>    
		<a href="javascript:insert_icon('transgender');"><i class="fa fa-transgender fa-2x"></i></a>    
		<a href="javascript:insert_icon('transgender-alt');"><i class="fa fa-transgender-alt fa-2x"></i></a>    
		<a href="javascript:insert_icon('venus');"><i class="fa fa-venus fa-2x"></i></a>    
		<a href="javascript:insert_icon('venus-double');"><i class="fa fa-venus-double fa-2x"></i></a>    
		<a href="javascript:insert_icon('venus-mars');"><i class="fa fa-venus-mars fa-2x"></i></a>    
	</div>
</div>

<div id="filetype">
	<div class="as-box as-box-head">
		<b>File Type Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('file');"><i class="fa fa-file fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-archive-o');"><i class="fa fa-file-archive-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-audio-o');"><i class="fa fa-file-audio-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-code-o');"><i class="fa fa-file-code-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-excel-o');"><i class="fa fa-file-excel-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-image-o');"><i class="fa fa-file-image-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-o');"><i class="fa fa-file-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-pdf-o');"><i class="fa fa-file-pdf-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-powerpoint-o');"><i class="fa fa-file-powerpoint-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-text');"><i class="fa fa-file-text fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-text-o');"><i class="fa fa-file-text-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-video-o');"><i class="fa fa-file-video-o fa-2x"></i></a>    
		<a href="javascript:insert_icon('file-word-o');"><i class="fa fa-file-word-o fa-2x"></i></a>    
	</div>
</div>

<div id="spinner">
	<div class="as-box as-box-head">
		<b>Spinner Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('circle-o-notch');"><i class="fa fa-circle-o-notch fa-2x"></i></a>    
		<a href="javascript:insert_icon('cog');"><i class="fa fa-cog fa-2x"></i></a>    
		<a href="javascript:insert_icon('refresh');"><i class="fa fa-refresh fa-2x"></i></a>    
		<a href="javascript:insert_icon('spinner');"><i class="fa fa-spinner fa-2x"></i></a>    
	</div>
</div>

<div id="form-control">
	<div class="as-box as-box-head">
		<b>Form Control Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('check-square');"><i class="fa fa-check-square fa-2x"></i></a>    
		<a href="javascript:insert_icon('check-square-o');"><i class="fa fa-check-square-o fa-2x"></i></a>
		<a href="javascript:insert_icon('circle');"><i class="fa fa-circle fa-2x"></i></a>
		<a href="javascript:insert_icon('circle-o');"><i class="fa fa-circle-o fa-2x"></i></a>
		<a href="javascript:insert_icon('dot-circle-o');"><i class="fa fa-dot-circle-o fa-2x"></i></a>
		<a href="javascript:insert_icon('minus-square');"><i class="fa fa-minus-square fa-2x"></i></a>
		<a href="javascript:insert_icon('minus-square-o');"><i class="fa fa-minus-square-o fa-2x"></i></a>
		<a href="javascript:insert_icon('plus-square');"><i class="fa fa-plus-square fa-2x"></i></a>
		<a href="javascript:insert_icon('plus-square-o');"><i class="fa fa-plus-square-o fa-2x"></i></a>
		<a href="javascript:insert_icon('square');"><i class="fa fa-square fa-2x"></i></a>
		<a href="javascript:insert_icon('square-o');"><i class="fa fa-square-o fa-2x"></i></a>
	</div>
</div>

<div id="payment">
	<div class="as-box as-box-head">
		<b>Payment Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('cc-amex');"><i class="fa fa-cc-amex fa-2x"></i></a>    
		<a href="javascript:insert_icon('cc-discover');"><i class="fa fa-cc-discover fa-2x"></i></a>
		<a href="javascript:insert_icon('cc-mastercard');"><i class="fa fa-cc-mastercard fa-2x"></i></a>
		<a href="javascript:insert_icon('cc-paypal');"><i class="fa fa-cc-paypal fa-2x"></i></a>
		<a href="javascript:insert_icon('cc-stripe');"><i class="fa fa-cc-stripe fa-2x"></i></a>
		<a href="javascript:insert_icon('cc-visa');"><i class="fa fa-cc-visa fa-2x"></i></a>
		<a href="javascript:insert_icon('credit-card');"><i class="fa fa-credit-card fa-2x"></i></a>
		<a href="javascript:insert_icon('google-wallet');"><i class="fa fa-google-wallet fa-2x"></i></a>
		<a href="javascript:insert_icon('paypal');"><i class="fa fa-paypal fa-2x"></i></a>
	</div>
</div>

<div id="chart">
	<div class="as-box as-box-head">
		<b>Chart Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('area-chart');"><i class="fa fa-area-chart fa-2x"></i></a>    
		<a href="javascript:insert_icon('bar-chart');"><i class="fa fa-bar-chart fa-2x"></i></a>
		<a href="javascript:insert_icon('line-chart');"><i class="fa fa-line-chart fa-2x"></i></a>
		<a href="javascript:insert_icon('pie-chart');"><i class="fa fa-pie-chart fa-2x"></i></a>
	</div>
</div>

<div id="currency">
	<div class="as-box as-box-head">
		<b>Currency Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('btc');"><i class="fa fa-btc fa-2x"></i></a>
		<a href="javascript:insert_icon('eur');"><i class="fa fa-eur fa-2x"></i></a>
		<a href="javascript:insert_icon('gbp');"><i class="fa fa-gbp fa-2x"></i></a>
		<a href="javascript:insert_icon('inr');"><i class="fa fa-inr fa-2x"></i></a>
		<a href="javascript:insert_icon('jpy');"><i class="fa fa-jpy fa-2x"></i></a>
		<a href="javascript:insert_icon('krw');"><i class="fa fa-krw fa-2x"></i></a>
		<a href="javascript:insert_icon('money');"><i class="fa fa-money fa-2x"></i></a>
		<a href="javascript:insert_icon('rub');"><i class="fa fa-rub fa-2x"></i></a>
		<a href="javascript:insert_icon('inr');"><i class="fa fa-rupee fa-2x"></i></a>
		<a href="javascript:insert_icon('try');"><i class="fa fa-try fa-2x"></i></a>
		<a href="javascript:insert_icon('usd');"><i class="fa fa-usd fa-2x"></i></a>
	</div>
</div>

<div id="text-editor">
	<div class="as-box as-box-head">
		<b>Text Editor Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('align-center');"><i class="fa fa-align-center fa-2x"></i></a>
		<a href="javascript:insert_icon('align-justify');"><i class="fa fa-align-justify fa-2x"></i></a>
		<a href="javascript:insert_icon('align-left');"><i class="fa fa-align-left fa-2x"></i></a>
		<a href="javascript:insert_icon('align-right');"><i class="fa fa-align-right fa-2x"></i></a>
		<a href="javascript:insert_icon('bold');"><i class="fa fa-bold fa-2x"></i></a>
		<a href="javascript:insert_icon('chain-broken');"><i class="fa fa-chain-broken fa-2x"></i></a>
		<a href="javascript:insert_icon('clipboard');"><i class="fa fa-clipboard fa-2x"></i></a>
		<a href="javascript:insert_icon('columns');"><i class="fa fa-columns fa-2x"></i></a>
		<a href="javascript:insert_icon('eraser');"><i class="fa fa-eraser fa-2x"></i></a>
		<a href="javascript:insert_icon('file');"><i class="fa fa-file fa-2x"></i></a>
		<a href="javascript:insert_icon('file-o');"><i class="fa fa-file-o fa-2x"></i></a>
		<a href="javascript:insert_icon('file-text');"><i class="fa fa-file-text fa-2x"></i></a>
		<a href="javascript:insert_icon('file-text-o');"><i class="fa fa-file-text-o fa-2x"></i></a>
		<a href="javascript:insert_icon('files-o');"><i class="fa fa-files-o fa-2x"></i></a>
		<a href="javascript:insert_icon('floppy-o');"><i class="fa fa-floppy-o fa-2x"></i></a>
		<a href="javascript:insert_icon('font');"><i class="fa fa-font fa-2x"></i></a>
		<a href="javascript:insert_icon('indent');"><i class="fa fa-indent fa-2x"></i></a>
		<a href="javascript:insert_icon('italic');"><i class="fa fa-italic fa-2x"></i></a>
		<a href="javascript:insert_icon('link');"><i class="fa fa-link fa-2x"></i></a>
		<a href="javascript:insert_icon('list');"><i class="fa fa-list fa-2x"></i></a>
		<a href="javascript:insert_icon('list-alt');"><i class="fa fa-list-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('list-ol');"><i class="fa fa-list-ol fa-2x"></i></a>
		<a href="javascript:insert_icon('list-ul');"><i class="fa fa-list-ul fa-2x"></i></a>
		<a href="javascript:insert_icon('outdent');"><i class="fa fa-outdent fa-2x"></i></a>
		<a href="javascript:insert_icon('paperclip');"><i class="fa fa-paperclip fa-2x"></i></a>
		<a href="javascript:insert_icon('paragraph');"><i class="fa fa-paragraph fa-2x"></i></a>
		<a href="javascript:insert_icon('repeat');"><i class="fa fa-repeat fa-2x"></i></a>
		<a href="javascript:insert_icon('scissors');"><i class="fa fa-scissors fa-2x"></i></a>
		<a href="javascript:insert_icon('strikethrough');"><i class="fa fa-strikethrough fa-2x"></i></a>
		<a href="javascript:insert_icon('subscript');"><i class="fa fa-subscript fa-2x"></i></a>
		<a href="javascript:insert_icon('superscript');"><i class="fa fa-superscript fa-2x"></i></a>
		<a href="javascript:insert_icon('table');"><i class="fa fa-table fa-2x"></i></a>
		<a href="javascript:insert_icon('text-height');"><i class="fa fa-text-height fa-2x"></i></a>
		<a href="javascript:insert_icon('text-width');"><i class="fa fa-text-width fa-2x"></i></a>
		<a href="javascript:insert_icon('th');"><i class="fa fa-th fa-2x"></i></a>
		<a href="javascript:insert_icon('th-large');"><i class="fa fa-th-large fa-2x"></i></a>
		<a href="javascript:insert_icon('th-list');"><i class="fa fa-th-list fa-2x"></i></a>
		<a href="javascript:insert_icon('underline');"><i class="fa fa-underline fa-2x"></i></a>
		<a href="javascript:insert_icon('undo');"><i class="fa fa-undo fa-2x"></i></a>
	</div>
</div>

<div id="directional">
	<div class="as-box as-box-head">
		<b>Directional Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('angle-double-down');"><i class="fa fa-angle-double-down fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-double-left');"><i class="fa fa-angle-double-left fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-double-right');"><i class="fa fa-angle-double-right fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-double-up');"><i class="fa fa-angle-double-up fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-down');"><i class="fa fa-angle-down fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-left');"><i class="fa fa-angle-left fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-right');"><i class="fa fa-angle-right fa-2x"></i></a>
		<a href="javascript:insert_icon('angle-up');"><i class="fa fa-angle-up fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-down');"><i class="fa fa-arrow-circle-down fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-left');"><i class="fa fa-arrow-circle-left fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-o-down');"><i class="fa fa-arrow-circle-o-down fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-o-left');"><i class="fa fa-arrow-circle-o-left fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-o-right');"><i class="fa fa-arrow-circle-o-right fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-o-up');"><i class="fa fa-arrow-circle-o-up fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-right');"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-circle-up');"><i class="fa fa-arrow-circle-up fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-down');"><i class="fa fa-arrow-down fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-left');"><i class="fa fa-arrow-left fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-right');"><i class="fa fa-arrow-right fa-2x"></i></a>
		<a href="javascript:insert_icon('arrow-up');"><i class="fa fa-arrow-up fa-2x"></i></a>
		<a href="javascript:insert_icon('arrows');"><i class="fa fa-arrows fa-2x"></i></a>
		<a href="javascript:insert_icon('arrows-alt');"><i class="fa fa-arrows-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('arrows-h');"><i class="fa fa-arrows-h fa-2x"></i></a>
		<a href="javascript:insert_icon('arrows-v');"><i class="fa fa-arrows-v fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-down');"><i class="fa fa-caret-down fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-left');"><i class="fa fa-caret-left fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-right');"><i class="fa fa-caret-right fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-square-o-down');"><i class="fa fa-caret-square-o-down fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-square-o-left');"><i class="fa fa-caret-square-o-left fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-square-o-right');"><i class="fa fa-caret-square-o-right fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-square-o-up');"><i class="fa fa-caret-square-o-up fa-2x"></i></a>
		<a href="javascript:insert_icon('caret-up');"><i class="fa fa-caret-up fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-circle-down');"><i class="fa fa-chevron-circle-down fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-circle-left');"><i class="fa fa-chevron-circle-left fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-circle-right');"><i class="fa fa-chevron-circle-right fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-circle-up');"><i class="fa fa-chevron-circle-up fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-down');"><i class="fa fa-chevron-down fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-left');"><i class="fa fa-chevron-left fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-right');"><i class="fa fa-chevron-right fa-2x"></i></a>
		<a href="javascript:insert_icon('chevron-up');"><i class="fa fa-chevron-up fa-2x"></i></a>
		<a href="javascript:insert_icon('hand-o-down');"><i class="fa fa-hand-o-down fa-2x"></i></a>
		<a href="javascript:insert_icon('hand-o-left');"><i class="fa fa-hand-o-left fa-2x"></i></a>
		<a href="javascript:insert_icon('hand-o-right');"><i class="fa fa-hand-o-right fa-2x"></i></a>
		<a href="javascript:insert_icon('hand-o-up');"><i class="fa fa-hand-o-up fa-2x"></i></a>
		<a href="javascript:insert_icon('long-arrow-down');"><i class="fa fa-long-arrow-down fa-2x"></i></a>
		<a href="javascript:insert_icon('long-arrow-left');"><i class="fa fa-long-arrow-left fa-2x"></i></a>
		<a href="javascript:insert_icon('long-arrow-right');"><i class="fa fa-long-arrow-right fa-2x"></i></a>
		<a href="javascript:insert_icon('long-arrow-up');"><i class="fa fa-long-arrow-up fa-2x"></i></a>
	</div>
</div>

<div id="video-player">
	<div class="as-box as-box-head">
		<b>Video Player Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('arrows-alt');"><i class="fa fa-arrows-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('backward');"><i class="fa fa-backward fa-2x"></i></a>
		<a href="javascript:insert_icon('compress');"><i class="fa fa-compress fa-2x"></i></a>
		<a href="javascript:insert_icon('eject');"><i class="fa fa-eject fa-2x"></i></a>
		<a href="javascript:insert_icon('expand');"><i class="fa fa-expand fa-2x"></i></a>
		<a href="javascript:insert_icon('fast-backward');"><i class="fa fa-fast-backward fa-2x"></i></a>
		<a href="javascript:insert_icon('fast-forward');"><i class="fa fa-fast-forward fa-2x"></i></a>
		<a href="javascript:insert_icon('forward');"><i class="fa fa-forward fa-2x"></i></a>
		<a href="javascript:insert_icon('pause');"><i class="fa fa-pause fa-2x"></i></a>
		<a href="javascript:insert_icon('play');"><i class="fa fa-play fa-2x"></i></a>
		<a href="javascript:insert_icon('play-circle');"><i class="fa fa-play-circle fa-2x"></i></a>
		<a href="javascript:insert_icon('play-circle-o');"><i class="fa fa-play-circle-o fa-2x"></i></a>
		<a href="javascript:insert_icon('step-backward');"><i class="fa fa-step-backward fa-2x"></i></a>
		<a href="javascript:insert_icon('step-forward');"><i class="fa fa-step-forward fa-2x"></i></a>
		<a href="javascript:insert_icon('stop');"><i class="fa fa-stop fa-2x"></i></a>
		<a href="javascript:insert_icon('youtube-play');"><i class="fa fa-youtube-play fa-2x"></i></a>
	</div>
</div>

<div id="brand">
	<div class="as-box as-box-head">
		<b>Brand Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('adn');"><i class="fa fa-adn fa-2x"></i></a>
		<a href="javascript:insert_icon('android');"><i class="fa fa-android fa-2x"></i></a>
		<a href="javascript:insert_icon('angellist');"><i class="fa fa-angellist fa-2x"></i></a>
		<a href="javascript:insert_icon('apple');"><i class="fa fa-apple fa-2x"></i></a>
		<a href="javascript:insert_icon('behance');"><i class="fa fa-behance fa-2x"></i></a>
		<a href="javascript:insert_icon('behance-square');"><i class="fa fa-behance-square fa-2x"></i></a>
		<a href="javascript:insert_icon('bitbucket');"><i class="fa fa-bitbucket fa-2x"></i></a>
		<a href="javascript:insert_icon('bitbucket-square');"><i class="fa fa-bitbucket-square fa-2x"></i></a>
		<a href="javascript:insert_icon('btc');"><i class="fa fa-btc fa-2x"></i></a>
		<a href="javascript:insert_icon('buysellads');"><i class="fa fa-buysellads fa-2x"></i></a>
		<a href="javascript:insert_icon('codepen');"><i class="fa fa-codepen fa-2x"></i></a>
		<a href="javascript:insert_icon('connectdevelop');"><i class="fa fa-connectdevelop fa-2x"></i></a>
		<a href="javascript:insert_icon('css3');"><i class="fa fa-css3 fa-2x"></i></a>
		<a href="javascript:insert_icon('dashcube');"><i class="fa fa-dashcube fa-2x"></i></a>
		<a href="javascript:insert_icon('delicious');"><i class="fa fa-delicious fa-2x"></i></a>
		<a href="javascript:insert_icon('deviantart');"><i class="fa fa-deviantart fa-2x"></i></a>
		<a href="javascript:insert_icon('digg');"><i class="fa fa-digg fa-2x"></i></a>
		<a href="javascript:insert_icon('dribbble');"><i class="fa fa-dribbble fa-2x"></i></a>
		<a href="javascript:insert_icon('dropbox');"><i class="fa fa-dropbox fa-2x"></i></a>
		<a href="javascript:insert_icon('drupal');"><i class="fa fa-drupal fa-2x"></i></a>
		<a href="javascript:insert_icon('empire');"><i class="fa fa-empire fa-2x"></i></a>
		<a href="javascript:insert_icon('facebook');"><i class="fa fa-facebook fa-2x"></i></a>
		<a href="javascript:insert_icon('facebook-official');"><i class="fa fa-facebook-official fa-2x"></i></a>
		<a href="javascript:insert_icon('facebook-square');"><i class="fa fa-facebook-square fa-2x"></i></a>
		<a href="javascript:insert_icon('flickr');"><i class="fa fa-flickr fa-2x"></i></a>
		<a href="javascript:insert_icon('forumbee');"><i class="fa fa-forumbee fa-2x"></i></a>
		<a href="javascript:insert_icon('foursquare');"><i class="fa fa-foursquare fa-2x"></i></a>
		<a href="javascript:insert_icon('git');"><i class="fa fa-git fa-2x"></i></a>
		<a href="javascript:insert_icon('git-square');"><i class="fa fa-git-square fa-2x"></i></a>
		<a href="javascript:insert_icon('github');"><i class="fa fa-github fa-2x"></i></a>
		<a href="javascript:insert_icon('github-alt');"><i class="fa fa-github-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('github-square');"><i class="fa fa-github-square fa-2x"></i></a>
		<a href="javascript:insert_icon('gittip');"><i class="fa fa-gittip fa-2x"></i></a>
		<a href="javascript:insert_icon('google');"><i class="fa fa-google fa-2x"></i></a>
		<a href="javascript:insert_icon('google-plus');"><i class="fa fa-google-plus fa-2x"></i></a>
		<a href="javascript:insert_icon('google-plus-square');"><i class="fa fa-google-plus-square fa-2x"></i></a>
		<a href="javascript:insert_icon('hacker-news');"><i class="fa fa-hacker-news fa-2x"></i></a>
		<a href="javascript:insert_icon('html5');"><i class="fa fa-html5 fa-2x"></i></a>
		<a href="javascript:insert_icon('ils');"><i class="fa fa-ils fa-2x"></i></a>
		<a href="javascript:insert_icon('instagram');"><i class="fa fa-instagram fa-2x"></i></a>
		<a href="javascript:insert_icon('ioxhost');"><i class="fa fa-ioxhost fa-2x"></i></a>
		<a href="javascript:insert_icon('joomla');"><i class="fa fa-joomla fa-2x"></i></a>
		<a href="javascript:insert_icon('jsfiddle');"><i class="fa fa-jsfiddle fa-2x"></i></a>
		<a href="javascript:insert_icon('lastfm');"><i class="fa fa-lastfm fa-2x"></i></a>
		<a href="javascript:insert_icon('lastfm-square');"><i class="fa fa-lastfm-square fa-2x"></i></a>
		<a href="javascript:insert_icon('leanpub');"><i class="fa fa-leanpub fa-2x"></i></a>
		<a href="javascript:insert_icon('linkedin');"><i class="fa fa-linkedin fa-2x"></i></a>
		<a href="javascript:insert_icon('linkedin-square');"><i class="fa fa-linkedin-square fa-2x"></i></a>
		<a href="javascript:insert_icon('linux');"><i class="fa fa-linux fa-2x"></i></a>
		<a href="javascript:insert_icon('maxcdn');"><i class="fa fa-maxcdn fa-2x"></i></a>
		<a href="javascript:insert_icon('meanpath');"><i class="fa fa-meanpath fa-2x"></i></a>
		<a href="javascript:insert_icon('medium');"><i class="fa fa-medium fa-2x"></i></a>
		<a href="javascript:insert_icon('openid');"><i class="fa fa-openid fa-2x"></i></a>
		<a href="javascript:insert_icon('pagelines');"><i class="fa fa-pagelines fa-2x"></i></a>
		<a href="javascript:insert_icon('pied-piper');"><i class="fa fa-pied-piper fa-2x"></i></a>
		<a href="javascript:insert_icon('pied-piper-alt');"><i class="fa fa-pied-piper-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('pinterest');"><i class="fa fa-pinterest fa-2x"></i></a>
		<a href="javascript:insert_icon('pinterest-p');"><i class="fa fa-pinterest-p fa-2x"></i></a>
		<a href="javascript:insert_icon('pinterest-square');"><i class="fa fa-pinterest-square fa-2x"></i></a>
		<a href="javascript:insert_icon('qq');"><i class="fa fa-qq fa-2x"></i></a>
		<a href="javascript:insert_icon('rebel');"><i class="fa fa-rebel fa-2x"></i></a>
		<a href="javascript:insert_icon('reddit');"><i class="fa fa-reddit fa-2x"></i></a>
		<a href="javascript:insert_icon('reddit-square');"><i class="fa fa-reddit-square fa-2x"></i></a>
		<a href="javascript:insert_icon('renren');"><i class="fa fa-renren fa-2x"></i></a>
		<a href="javascript:insert_icon('sellsy');"><i class="fa fa-sellsy fa-2x"></i></a>
		<a href="javascript:insert_icon('share-alt');"><i class="fa fa-share-alt fa-2x"></i></a>
		<a href="javascript:insert_icon('share-alt-square');"><i class="fa fa-share-alt-square fa-2x"></i></a>
		<a href="javascript:insert_icon('shirtsinbulk');"><i class="fa fa-shirtsinbulk fa-2x"></i></a>
		<a href="javascript:insert_icon('simplybuilt');"><i class="fa fa-simplybuilt fa-2x"></i></a>
		<a href="javascript:insert_icon('skyatlas');"><i class="fa fa-skyatlas fa-2x"></i></a>
		<a href="javascript:insert_icon('skype');"><i class="fa fa-skype fa-2x"></i></a>
		<a href="javascript:insert_icon('slack');"><i class="fa fa-slack fa-2x"></i></a>
		<a href="javascript:insert_icon('slideshare');"><i class="fa fa-slideshare fa-2x"></i></a>
		<a href="javascript:insert_icon('soundcloud');"><i class="fa fa-soundcloud fa-2x"></i></a>
		<a href="javascript:insert_icon('spotify');"><i class="fa fa-spotify fa-2x"></i></a>
		<a href="javascript:insert_icon('stack-exchange');"><i class="fa fa-stack-exchange fa-2x"></i></a>
		<a href="javascript:insert_icon('stack-overflow');"><i class="fa fa-stack-overflow fa-2x"></i></a>
		<a href="javascript:insert_icon('steam');"><i class="fa fa-steam fa-2x"></i></a>
		<a href="javascript:insert_icon('steam-square');"><i class="fa fa-steam-square fa-2x"></i></a>
		<a href="javascript:insert_icon('stumbleupon');"><i class="fa fa-stumbleupon fa-2x"></i></a>
		<a href="javascript:insert_icon('stumbleupon-circle');"><i class="fa fa-stumbleupon-circle fa-2x"></i></a>
		<a href="javascript:insert_icon('tencent-weibo');"><i class="fa fa-tencent-weibo fa-2x"></i></a>
		<a href="javascript:insert_icon('trello');"><i class="fa fa-trello fa-2x"></i></a>
		<a href="javascript:insert_icon('tumblr');"><i class="fa fa-tumblr fa-2x"></i></a>
		<a href="javascript:insert_icon('tumblr-square');"><i class="fa fa-tumblr-square fa-2x"></i></a>
		<a href="javascript:insert_icon('twitch');"><i class="fa fa-twitch fa-2x"></i></a>
		<a href="javascript:insert_icon('twitter');"><i class="fa fa-twitter fa-2x"></i></a>
		<a href="javascript:insert_icon('twitter-square');"><i class="fa fa-twitter-square fa-2x"></i></a>
		<a href="javascript:insert_icon('viacoin');"><i class="fa fa-viacoin fa-2x"></i></a>
		<a href="javascript:insert_icon('vimeo-square');"><i class="fa fa-vimeo-square fa-2x"></i></a>
		<a href="javascript:insert_icon('vine');"><i class="fa fa-vine fa-2x"></i></a>
		<a href="javascript:insert_icon('vk');"><i class="fa fa-vk fa-2x"></i></a>
		<a href="javascript:insert_icon('weibo');"><i class="fa fa-weibo fa-2x"></i></a>
		<a href="javascript:insert_icon('weixin');"><i class="fa fa-weixin fa-2x"></i></a>
		<a href="javascript:insert_icon('whatsapp');"><i class="fa fa-whatsapp fa-2x"></i></a>
		<a href="javascript:insert_icon('windows');"><i class="fa fa-windows fa-2x"></i></a>
		<a href="javascript:insert_icon('wordpress');"><i class="fa fa-wordpress fa-2x"></i></a>
		<a href="javascript:insert_icon('xing');"><i class="fa fa-xing fa-2x"></i></a>
		<a href="javascript:insert_icon('xing-square');"><i class="fa fa-xing-square fa-2x"></i></a>
		<a href="javascript:insert_icon('yahoo');"><i class="fa fa-yahoo fa-2x"></i></a>
		<a href="javascript:insert_icon('yelp');');"><i class="fa fa-yelp fa-2x"></i></a>
		<a href="javascript:insert_icon('youtube');"><i class="fa fa-youtube fa-2x"></i></a>
		<a href="javascript:insert_icon('youtube-play');"><i class="fa fa-youtube-play fa-2x"></i></a>
		<a href="javascript:insert_icon('youtube-square');"><i class="fa fa-youtube-square fa-2x"></i></a>
	</div>
</div>

<div id="medical">
	<div class="as-box as-box-head">
		<b>Medical Icons</b>
	</div>
	<div class="icon-box">
		<a href="javascript:insert_icon('ambulance');');"><i class="fa fa-ambulance fa-2x"></i></a>
		<a href="javascript:insert_icon('h-square');');"><i class="fa fa-h-square fa-2x"></i></a>
		<a href="javascript:insert_icon('hospital-o');');"><i class="fa fa-hospital-o fa-2x"></i></a>
		<a href="javascript:insert_icon('medkit');');"><i class="fa fa-medkit fa-2x"></i></a>
		<a href="javascript:insert_icon('plus-square');');"><i class="fa fa-plus-square fa-2x"></i></a>
		<a href="javascript:insert_icon('stethoscope');');"><i class="fa fa-stethoscope fa-2x"></i></a>
		<a href="javascript:insert_icon('user-md');');"><i class="fa fa-user-md fa-2x"></i></a>
		<a href="javascript:insert_icon('wheelchair');');"><i class="fa fa-wheelchair fa-2x"></i></a>
	</div>
</div>

<div class="btn_confirm01 btn_confirm">
	<button onclick="window.close();" type="button">닫기</button>
</div>

<br>

<script> 
	function insert_icon(icon){
		<?php if($fid) { ?>
			var fa = "{아이콘:" + icon + "}";
			$("#<?php echo $fid;?>",opener.document).val(fa);
			<?php if($sid) { ?>
				opener.document.getElementById("<?php echo $sid;?>").innerHTML = "<i class=\"fa fa-" + icon + "\"></i>";
			<?php } ?>
			window.close();
		<?php } else { ?>
			var fa = document.getElementById("fa_content");
			fa.value = "{아이콘:" + icon + "}";
			fa.focus();
		<?php } ?>
	}
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>
