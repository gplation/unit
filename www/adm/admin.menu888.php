<?php
	if(IS_YC) {
		$menu['menu888'] = array (
			array('888001', '파트너관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=basic', 'apms_basic'),
			array('888001', '기본설정', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=basic', 'apms_basic'),
			array('888002', '파트너관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=plist', 'apms_plist'),
			array('888003', '배송관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=delivery', 'apms_delivery', 1),
			array('888004', '출금관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=payment', 'apms_payment', 1),
		);
	}
?>