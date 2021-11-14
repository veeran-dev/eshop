AOS.init({
	easing: 'ease-in-out-sine'
});

$(document).ready(function() {


// Client Slider
$('.brand_slider').bxSlider({			
	minSlides: 1,
	maxSlides: 6,
	slideWidth: 220,
	pager: false,
	moveSlides:1,
	infiniteLoop:true,
	hideControlOnEnd: false,
	nextText: ' ',
	prevText: ' '
});

// Carusel
$('.owl-carousel').owlCarousel({
items:1,
loop:true,
dots: true,
dotsEach: false,
pagination : true,
paginationNumbers: false,
autoplay:true,
autoplayTimeout:4000,
animateOut: false,
responsiveClass:true,
autoplayHoverPause:true
});

// info  Graph
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

$(".hide ul li a").click(function(){
	$(".toggle-menu").parent().toggleClass('open-menu');
});

});

//Dial interaction