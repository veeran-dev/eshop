$(document).ready(function(){
	$(".manufacturerslide .jCarouselLite").jCarouselLite({
		visible: items_vis_manu,
		vertical: vertical_manu,
		easing: type_effect_manu,
		circular: true,
		auto: time_transition_manu,
		mouseWheel: mouse_wheel_manu,
		speed: time_effect_manu
	});
});