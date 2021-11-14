(function($) {

    /* ---------------------------------------------- /*
	 * Preloader
	/* ---------------------------------------------- */

    $(window).load(function() {
        $('#status').fadeOut();
        $('#preloader').delay(300).fadeOut('slow');
    });

    $(document).ready(function() {

        /* ---------------------------------------------- /*
		 * Smooth scroll / Scroll To Top
		/* ---------------------------------------------- */

        $('a[href*=#]').bind("click", function(e) {

            var anchor = $(this);
            if($(anchor.attr('href')).length){
                $('html, body').stop().animate({
                    scrollTop: $(anchor.attr('href')).offset().top
                }, 1000);
            }
            e.preventDefault();
        });

        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.scroll-up').fadeIn();
            } else {
                $('.scroll-up').fadeOut();
            }
        });

        /* ---------------------------------------------- /*
		 * Navbar
		/* ---------------------------------------------- */

        $('.header').sticky({
            topSpacing: 0
        });

        $('body').scrollspy({
            target: '.navbar-custom',
            offset: 70
        })


        /* ---------------------------------------------- /*
		 * Skills
        /* ---------------------------------------------- */
        //var color = $('#home').css('backgroundColor');

        $('.skills').waypoint(function() {
            $('.chart').each(function() {
                $(this).easyPieChart({
                    size: 140,
                    animate: 2000,
                    lineCap: 'butt',
                    scaleColor: false,
                    barColor: '#FF5252',
                    trackColor: 'transparent',
                    lineWidth: 10
                });
            });
        }, {
            offset: '80%'
        });


        /* ---------------------------------------------- /*
		 * Quote Rotator
		/* ---------------------------------------------- */

        $(function() {
            /*
				- how to call the plugin:
				$( selector ).cbpQTRotator( [options] );
				- options:
				{
					// default transition speed (ms)
					speed : 700,
					// default transition easing
					easing : 'ease',
					// rotator interval (ms)
					interval : 8000
				}
				- destroy:
				$( selector ).cbpQTRotator( 'destroy' );
				*/

            $('#cbp-qtrotator').cbpQTRotator();

        });


        /* ---------------------------------------------- /*
		 * Home BG
		/* ---------------------------------------------- */

        $(".screen-height").height($(window).height());

        $(window).resize(function() {
            $(".screen-height").height($(window).height());
        });

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $('#home').css({
                'background-attachment': 'scroll'
            });
        } else {
            $('#home').parallax('50%', 0.1);
        }


        /* ---------------------------------------------- /*
		 * WOW Animation When You Scroll
		/* ---------------------------------------------- */

        wow = new WOW({
            mobile: false
        });
        wow.init();
    });

})(jQuery);

/* ---------------------------------------------- /*
 * Contact form ajax
/* ---------------------------------------------- */
$(document).ready(function() {
    var response = $('#contact-form .ajax-response');
    $("#contact-form").validate({
        // Specify the validation rules
        rules: {
            c_name: "required",
            c_message: "required",
            c_email: {
                required: true,
                email: true
            }
        },
        // Specify the validation error messages
        messages: {
            c_name: "Please enter your name.",
            c_message: "Please enter your message / product details.",
            c_email: "Please enter a valid email address.",
        },

        submitHandler: function(form) {
            var dataparam = '&type=2' + '&' + $("#contact-form").serialize();
            $.post("bq-request-ajax.php", dataparam)
                .done(function() {
                    $('#success-response').modal('show'); //on success show message
                })
                .fail(function() {
                    $('#failure-response').modal('show'); //for if any failure happened
                })
                .always(function() {
                    // Reset form
                    $("#contact-form").find("input[type='text'], input[type='email'],textarea").val('');
                });
        }
    });

    $("#msform").validate({
        // Specify the validation rules
        // errorPlacement: function (error, element) {
        //    element.attr("placeholder", error[0].outerText);
        //    error.addClass('text-danger');
        // },
        rules: {
            est_qty: {
                required: true,
                number: true
            },
            tar_price: {
                required: true,
                number: true
            },
            pin_code: {
                required: true,
                number: true,
                minlength: 6
            },
            acc_email: {
                required: true,
                email: true
            },
            acc_pass: "required",
            acc_name: "required",
            acc_phone: {
                required: true,
                number: true
            }
        },
        // Specify the validation error messages
        messages: {
            est_qty: {
                required: "Please enter estimated quantity.",
                number: "Please enter digits only"
            },
            tar_price: {
                required: "Please enter target price.",
                number: "Please enter digits only"
            },
            pin_code: {
                required: "Please enter your pincode.",
                number: "Please enter digits only",
                minlength: "Should contain 6 characters long"
            },
            acc_email: "Please enter your email",
            acc_pass: "Please provide password",
            acc_name: "Please provide your name",
            acc_phone: {
                required: "Please provide your mobile number",
                number: "Please enter digits only"
            }
        }
    });


    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function() {

        if ($("#msform").valid()) {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(1)'
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_fs.hide();
                    animating = false;
                },
                // //this comes from the custom easing plugin
                // easing: 'easeInOutBack'
            });
        }
    });

    $(".previous").click(function() {
        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            // //this comes from the custom easing plugin
            // easing: 'easeInOutBack'
        });
    });
});

function edgeBqAccCheck(type) {
    if (type == 0) {
    	$('#acc-hint h4').html('Sign Up to Continue');
    	$('#sign-in-previous').hide();
        $('#sign-in-edge').hide();
        $('.bq_new_acc').show();
        $('#sign-up-previous').show();
        $('#sign-up-edge').show();
        $('#acc-create-link').hide();
    } else {
    	$('#acc-hint h4').html('Sign In to Continue');
        $('#sign-in-edge').show();
        $('#sign-in-previous').show();
        $('.bq_new_acc').hide();
        $('#sign-up-previous').hide();
        $('#sign-up-edge').hide();
        $('#acc-create-link').show();
    }
}

function getQuote(name,id){
	$('#product_name').val(name);
	$('#product_name_h3').html(name);
	$('#id_product').val(id);
	$('#product-content').hide();
	$('#msform').show();
}


function saveRequest(logged)
{
    $(".edge-loader").show();
	var credit = $('#radio-btn-edge .active input').data('value');
	var dataparam = 'credit='+credit+'&'+'logged='+logged+'&'+$('#msform').serialize();
            $.post("edge-process-bq-request.php", dataparam,function(data){         	
            })
                .done(function() {
                    $(".edge-loader").hide();
                    $('#complete-response').modal('show');//on success show message                  
                    $('#msform').hide();
					$('#get-started').show();
                })
                .fail(function(data) {

                    $('#failure-response').modal('show'); //for if any failure happened
                })
                .always(function() {
                    // Reset form
                    $("#msform").find("input[type='text'], input[type='email'],input[type='password'],textarea").val('');
                    $('#qty_type,#price_type').prop('selectedIndex',0);
                    var curr_fieldset = $('.previous').parent();
                    curr_fieldset.hide();
                    $("#progressbar li:nth-child(3)").removeClass("active");
                    $('.previous').click();
                    $('.previous').parent().prev();
                    $('#bq-acc-exists').hide();
                    $('#sign-in-link').click();
                    $('.default-payment-yes').removeClass('active');
                    $('.default-payment-no').addClass('active');
                });
}

function createNewAccount()
{
	if($('#msform').valid()){
    $(".edge-loader").show();
	var dataparam = 'email=' + $('#acc_email').val() +'&password='+$('#acc_pass').val() +'&name='+$('#acc_name').val() +'&phone='+$('#acc_phone').val() + '&type=1';
   	$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'createNewAccount.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
                $(".edge-loader").hide();
				if(data != 2)
				{
					$("#bq_id_customer").val(data);
					saveRequest(1);
				}
				else
				{
					$('#bq-acc-exists').show();
				}
			}			
	});
   }
}

function bqSignIn()
{
     
	if($('#msform').valid()){
    $(".edge-loader").show();
	var dataparam = 'email=' + $('#acc_email').val() +'&password='+$('#acc_pass').val();
  	$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'authenticateCheck.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
                 $(".edge-loader").hide();
				if(data == 1)
				{	
					saveRequest(0);
				}
				else
				{
					$('#bq-acc-error').show();
				}
			}
	});
  }
}

function completeEdge(){
	$('#complete-response').modal('hide');
}

$(".intro").niceScroll({
                cursorcolor: "#878787",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "4px",
                autohidemode: false
            });
			
function getStartedButton()
{
	$('#get-started').hide();
	$('#product-content').show();
}

function goToProduct(){
    $('#product-content').show();
    $('#msform').hide();
}