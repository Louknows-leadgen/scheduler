$(document).ready(function() {
	$("div#contentz").hide();

	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
		$("div#contentz").show();
		$("div#contentz").slideDown("slow");
		
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
		$("div#contentz").slideUp("slow");	
	});
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});	
		
		
});
