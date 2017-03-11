<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// StyleSheet
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);

?>

<?php // 주문서폼 시작 - id 변경불가 & 삭제하면 안됨 ?>
<form name="forderform" id="forderform" method="post" action="<?php echo $action_url; ?>" autocomplete="off" role="form" class="form-horizontal"<?php echo $form_submit_script;?>>
