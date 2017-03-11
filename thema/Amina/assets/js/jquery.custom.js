$(document).ready(function() {

	//Tooltip
	$('.at-tip').tooltip();

    $('.switcher-win').click(function() {
		var new_win = window.open(this.href, 'win_switcher', 'left=100,top=100,width=600, height=600, scrollbars=1');
		new_win.focus();
        return false;
    });

	$().UItoTop({ easingType: 'easeOutQuart' });

	// Custom animations
	$(".at-animate-click").click(function(){
		var animation = $(this).data("animate");
		if(animation != undefined){
			$(this).find(".at-animate").addClass(animation);
		}
	});
	
	$(".at-animate-hover").hover(function(){
		var animation = $(this).data("animate");
		if(animation != undefined){
			$(this).find(".at-animate").addClass(animation);
		}
	});

	// Aside Menu
	$(".asideButton").click(function(){
		if($("#asideMenu").is(":visible")){
			$("#asideMenu").hide();
			$("body").removeClass("aside-menu-in");
		} else {
			$("body").addClass("aside-menu-in");
			$("#asideMenu").show();
		}
		return false;	
	});
});
