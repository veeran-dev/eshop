//WOW Scroll Spy
var wow = new WOW({
    //disabled for mobile
    mobile: false,
    offset:       100
});
wow.init();

//Contact Form

$('#submit').click(function(){

$.post("assets/php/send.php", $(".contact-form").serialize(),  function(response) {   
 $('#success').html(response);
});
return false;

});

$(document).ready(function(){
	
	$(".technology").click(function() {
		$(".technology_info").show();
		$(".circle-container a").hide();
	});
	$(".delivery").click(function() {
		$(".delivery_info").show();
		$(".circle-container a").hide();
	});
	$(".finance").click(function() {
		$(".finance_info").show();
		$(".circle-container a").hide();
	});
	$(".catalogue").click(function() {
		$(".catalogue_info").show();
		$(".circle-container a").hide();
	});
	$(".support").click(function() {
		$(".support_info").show();
		$(".circle-container a").hide();
	});
	
	$(".close-dial").click(function() {
		$(".reveal").hide();
		$(".circle-container a").show();
	});
	
});
