/* ================================================================= */
/* Basic Thema Setup
====================================================================== */

window.console = window.console || (function(){
	var c = {}; c.log = c.warn = c.debug = c.info = c.error = c.time = c.dir = c.profile = c.clear = c.exception = c.trace = c.assert = function(){};
	return c;
})();

function switcher_background(type, fid, cid, url) {
	if(type == "html") {
		$("body").css("background-image", "url('" + url + "')");
	} else {
		$("." + cid).attr("style", "background-image:url('" + url + "')");
	}
	$("#" + fid).val(url);
	return false;
}

function switcher_bgcolor(color) {
	$("body").css("background-color", color.toHexString());
	return false;
}

jQuery(document).ready(function($) {

	//Switcher Open & Close
	$("#style-switcher h2 a").click(function(e){
		e.preventDefault();
		var div = $("#style-switcher");
		console.log(div.css("left"));
		if (div.css("left") === "-206px") {
			$("#style-switcher").animate({
				left: "0px"
			}); 
		} else {
			$("#style-switcher").animate({
				left: "-206px"
			});
		}
	});

	//Switcher Fixed & Relative
	$("#switcher-fixed").click(function(e){
		if($("#switcher-fixed").is(":checked")) {
			$("#style-switcher").css("position", "absolute");
		} else {
			$("#style-switcher").css("position", "fixed");
		}
		return true;
	});

	//ColorSet Style
	$("#colorset-style").change(function(e){
		var new_colorset = $(this).val();
		$(".thema-colorset" ).attr("href", sw_url + "/colorset/" + new_colorset + "/colorset.css");
		return false;
	});

	//Layout Style
	$("#layout-style").change(function(e){
		if($(this).val() == "boxed"){
			$(".wrapper").addClass("boxed");
			$(window).resize();
		} else{
			$(".wrapper").removeClass("boxed"); 
			$(window).resize();
		}
	});

	//Background Color Change
	$(".body-bgcolor").spectrum({
		showInitial: true,
		color: sw_bgcolor,
		preferredFormat: "hex6",
		showInput: true,
		move: switcher_bgcolor
	});

	//LNB Style
	$("#lnb-style").change(function(e){
		if($(this).val() == "at-lnb-dark"){
			$(".at-lnb").removeClass("at-lnb-gray");
			$(".at-lnb").addClass("at-lnb-dark");
			$(window).resize();
		} else if($(this).val() == "at-lnb-gray"){
			$(".at-lnb").removeClass("at-lnb-dark");
			$(".at-lnb").addClass("at-lnb-gray");
			$(window).resize();
		} else{
			$(".at-lnb").removeClass("at-lnb-gray");
			$(".at-lnb").removeClass("at-lnb-dark");
			$(window).resize();
		}
	});

	//Menu Style
	$("#menu-style").change(function(e){
		if($(this).val() == "navbar-contrasted"){
			$(".at-navbar").addClass("navbar-contrasted");
			$(window).resize();
		} else{
			$(".at-navbar").removeClass("navbar-contrasted");
			$(window).resize();
		}
	});

	//Side Style
	$("#side-style").change(function(e){
		if($(this).val() == 1){
			$(".contentArea").addClass("pull-right");
			$(".sideArea").addClass("pull-left");
			$(window).resize();
		} else{
			$(".contentArea").removeClass("pull-right");
			$(".sideArea").removeClass("pull-left");
			$(window).resize();
		}
	});	

	//Font Style
	$("#font-style").change(function(e){
		if($(this).val() == "ko"){
			$(".wrapper").addClass("ko");
			$(window).resize();
		} else{
			$(".wrapper").removeClass("ko"); 
			$(window).resize();
		}
	});

});