function apms_colorset(t_id, s_id, c_id, size) {
	$.get("./apms.colorset.php?t_id="+t_id+"&c_id="+c_id+"&size="+size, function (data) {
		$("#"+s_id).html(data);
	});
}

$(function(){
    $(".apms-del").click(function() {
	    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
		    document.location.href = encodeURI(this.href);
		}
        return false;
    });
});
