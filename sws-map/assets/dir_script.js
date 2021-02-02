	var count = 0;
	var depth = 8;
	$('document').ready(function(){
	while (count < depth){
    	$('#southwestern-union:hover').first().clone().appendTo('#southwestern-union:hover').css({"top" : count , "left" : count});
	count++;
  	}
	});

function swsToggle(id,myClass) {
	if (id=="X") { var tmp="."+myClass;}
	else { var tmp="#"+id;}	
	
}
	
function showOne(id,groupName) {
	//alert(id + ' | ' + groupName);
	
    $('.'+ groupName).removeClass('showClass');
    $('.'+ groupName).not(id).addClass('hideClass');
	
	switch(id) {
		case("CA"):
			$('.ANP8').addClass('showClass'); 		$('.ANP8').removeClass('hideClass');
			$('.ANPI').addClass('showClass'); 		$('.ANPI').removeClass('hideClass');
			$('.ANPM').addClass('showClass'); 		$('.ANPM').removeClass('hideClass');
			$('.ANPP').addClass('showClass'); 		$('.ANPP').removeClass('hideClass');		
			break;
		case("NY"):
			$('.AN48').addClass('showClass'); 		$('.AN48').removeClass('hideClass');	
			$('.AN4B').addClass('showClass'); 		$('.AN4B').removeClass('hideClass');	
			break;
		default:   	$('.'+ id).removeClass('hideClass'); 	$('.'+ id).addClass('showClass'); 	
			break;	
	}
	
/*	if (id=="CA") { 
	} else if (id=="NY") {
	} else {
  }
	*/
	if (id.length==4) { var temp=id.substr(0,3); // IT's a conference
		$('#us-map').removeClass('showClass');
		$('#us-map').addClass('hideClass');

		$('#chooseCountry').removeClass('showClass');
		$('#returnNAD').removeClass('hideClass');
		$('#chooseCountry').addClass('hideClass');
		$('#returnNAD').addClass('showClass');

	    $('.'+ temp).removeClass('hideClass');
    	$('.'+ temp).addClass('showClass');
	}

	if (id=='us-map') { 
    	$('#'+ id).removeClass('hideClass'); 	
    	$('#'+ id).addClass('showClass'); 	
		
		$('#chooseCountry').removeClass('hideClass'); $('#showUS').prop('checked',true); }
	else { $('#returnNAD').removeClass('hideClass'); $('#chooseCountry').addClass('hideClass');}
	 //$("#"+id).focus();
}   
	

$(".regional").hover(function(){
	$(".conference").addClass("hidden");
	$(".regional").addClass("hidden");
	$(this).removeClass("hidden");
}, function() {
	$(".conference").removeClass("hidden");
	$(".regional").removeClass("hidden");
});

$(document).ready(function() {
			
 $("#showUS").click(function () {
  $('#can-map').addClass('hideClass');
  $('#us-map').removeClass('hideClass');
	});
 
	$("#showCAN").click(function () {
  $('#us-map').addClass('hideClass');
  $('#can-map').removeClass('hideClass'); 
	});
 
});     
