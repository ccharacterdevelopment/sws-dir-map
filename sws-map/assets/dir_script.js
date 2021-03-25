$ = jQuery;
$(".regional").hover(function(){
	$(".conference").addClass("hidden");
	$(".regional").addClass("hidden");
	$(this).removeClass("hidden");
}, function() {
	$(".conference").removeClass("hidden");
	$(".regional").removeClass("hidden");
});