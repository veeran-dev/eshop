
// variables
var $header_top = $('.header-top');
var $nav = $('nav');



// toggle menu 
$header_top.find('.toggle-menu').on('click', function() {
  $(this).parent().toggleClass('open-menu');
});


if ($(window).width() > 1000) {
	// fullpage customization
	
	//$(".elite_signup").attr("href", "#Elite");
	
	$('#transcroller-body').fullpage({
	  sectionsColor: ['#fff', '#fff', '#fff', '#eee', '#fff', '#fff'],
	  sectionSelector: '.vertical-scrolling',
	  slideSelector: '.horizontal-scrolling',
	  navigation: false,
	  slidesNavigation: false,
	  controlArrows: false,
	  anchors: ['Elite', 'Benefits', 'Why-Kobster', 'Our-clients', 'Categories', 'Become-a-client', 'About'],
	  menu: '#menu',
	  

	
	  afterLoad: function(anchorLink, index) {
		//$header_top.css('background', 'rgba(0, 47, 77, .3)');
		//$nav.css('background', 'rgba(0, 47, 77, .25)');
		if (index == 6) {
			$('.elite_signup').hide();
		  }
		  if(index == 1) {
			$('.header-top').removeClass("fixed_top");
			$('.elite-logo').hide();
			$('.elite-white-logo').show();
			$('.toggle-menu').removeClass("red-menu");
			$('.elite_signup').hide();
			
		  }
	  },
	
	  onLeave: function(index, nextIndex, direction) {
		if(index == 6) {
		  $('.elite_signup').show();
		}
		if(index == 1) {
			$('.header-top').addClass("fixed_top");
			$('.elite-logo').show();
			$('.elite-white-logo').hide();
			$('.toggle-menu').addClass("red-menu");
			$('.elite_signup').show();
			
		}
		
	  },
	
	  afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex) {
		if(anchorLink == 'fifthSection' && slideIndex == 1) {
		  $.fn.fullpage.setAllowScrolling(false, 'up');
		  $header_top.css('background', 'transparent');
		  $nav.css('background', 'transparent');
		  $(this).css('background', '#374140');
		  $(this).find('h2').css('color', 'white');
		  $(this).find('h3').css('color', 'white');
		  $(this).find('p').css(
			{
			  'color': '#DC3522',
			  'opacity': 1,
			  'transform': 'translateY(0)'
			}
		  );
		}
	  },
	
	  onSlideLeave: function( anchorLink, index, slideIndex, direction) {
		if(anchorLink == 'fifthSection' && slideIndex == 1) {
		  $.fn.fullpage.setAllowScrolling(true, 'up');
		  //$header_top.css('background', 'rgba(0, 47, 77, .3)');
		  //$nav.css('background', 'rgba(0, 47, 77, .25)');
		}
	  } 
	});
}
else{
	
	//$(".elite_signup").attr("href", "#elite_lead_form2");
	$(".Elite").attr('id', 'Elite');
	$(".Benefits").attr('id', 'Benefits');
	$(".Why-Kobster").attr('id', 'Why-Kobster');
	$(".Our-clients").attr('id', 'Our-clients');
	$(".Categories").attr('id', 'Categories');
	$(".Become-a-client").attr('id', 'Become-a-client');
	$(".About").attr('id', 'About');
	
	
	$('.header-top').addClass("fixed_top");
			$('.elite-logo').show();
			$('.elite-white-logo').hide();
			$('.toggle-menu').addClass("red-menu");
}




