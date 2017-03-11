<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css">', 0);

?>

<!-- 현재접속자 목록 시작 { -->
<div class="table-responsive">
    <table class="table">
    <tbody>
    <tr class="bg-black">
        <th class="text-center" scope="col"><b>번호</b></th>
        <th class="text-center" scope="col"><b>이름</b></th>
        <th class="text-center" scope="col"><b>위치</b></th>
    </tr>
    <?php
    for ($i=0; $i<count($list); $i++) {
        //$location = conv_content($list[$i]['lo_location'], 0);
        $location = $list[$i]['lo_location'];
        // 최고관리자에게만 허용
        // 이 조건문은 가능한 변경하지 마십시오.
        if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
        else $display_location = $location;
    ?>
        <tr>
            <td class="text-center"><?php echo $list[$i]['num'] ?></td>
            <td><?php echo $list[$i]['name'] ?></td>
            <td><?php echo $display_location ?></td>
        </tr>
    <?php } ?>
	<?php if ($i == 0) { ?>
        <tr><td colspan="3" class="text-muted text-center" style="padding:50px 0px;">현재 접속자가 없습니다.</td></tr>
	<?php } ?>
    </tbody>
    </table>
</div>
<!-- } 현재접속자 목록 끝 -->