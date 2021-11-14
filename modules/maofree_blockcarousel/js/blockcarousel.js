$(document).ready(function(){
	$(".blockcarousel .jCarouselLite").jCarouselLite({
		visible: blockcarousel_items_vis,
		vertical: blockcarousel_vertical,
		easing: blockcarousel_type_effect,
		circular: true,
		auto: blockcarousel_time_transition,
		speed: blockcarousel_time_effect,
		mouseWheel: blockcarousel_mouse_wheel
	});
});