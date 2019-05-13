$(function(){
	$("body").append("<div id='mom_layer'></div><div id='kids_layer'></div>");
	$("#mom_layer").click(function(){
		$(this).hide();
		$("#kids_layer").hide();
	});
	$("a.modal").click(function(){
		$("#mom_layer").show();
		$("#kids_layer").show().html("<img src='img/close.png' class='close' />"+"<img src='"+$(this).attr("href")+"'>");
		$("#kids_layer img.close").click(function(){
		$("#kids_layer").hide();
		$("#mom_layer").hide();
		});
		return false;
	});
});