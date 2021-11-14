$('.footer-block h4').on('click', function(e){
	if (($(window).width()) <= 768){
	$(this).toggleClass('active');
	}
	else{
		$(this).removeClass('active')
	}
	e.preventDefault();
});