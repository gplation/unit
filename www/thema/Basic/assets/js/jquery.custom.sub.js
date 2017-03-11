$(document).ready(function() {

	//Tooltip
	$('.at-tip').tooltip();

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

});
