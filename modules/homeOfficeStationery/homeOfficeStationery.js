$(function() {
  /*
  $('#homecarouselulst').carouFredSel({
			auto: false,
			prev: '#prev2',
			next: '#next2',
			mousewheel: false,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});*/
		
				
				$("#officestationery-div").hover(
		      function(){
				  $(".os-visual-cue").show();
			  			},
		      function(){
				  $(".os-visual-cue").hide();
			  			});
					
		
	$(".os-visual-cue").hover(
		function(){
				var x=$("#"+(this.id)).offset();
				var y=$("#"+(this.id)+"-div").width();
				var z=(y/2)-4;
	 			$("#"+(this.id)+"-div").css({top: x.top-92, left: x.left-(z),});
				$("#"+(this.id)+"-div").show();
				},
	 	function(){
			$("#"+(this.id)+"-div").bind({
				mouseover:function(){
			    $("#"+(this.id)).show();
		    	},
				mouseout:function(){
				$("#"+(this.id)).hide();
				}
				});
		$("#"+(this.id)+"-div").hide();	
		});
		
		
		
});
		

