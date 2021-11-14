$(document).ready(function() {
  // Scroll Down
  $('a.smooth-scroll').on('click',function (e) {
    e.preventDefault();
    var target = this.hash;
    var $target = $(target);
    $('html, body').stop().animate({
        scrollTop: $target.offset().top
    }, 1200, 'swing')
  });
  // Contact Form
  $('#requestForm').validate({
      rules: {
        fullname: "required",
        email: {
            required: true,
            email: true
        },
        company: "required",
        city: "required",         
        mobile: {
          required: true,
          number: true,
          minlength:10,
          maxlength:10
        }
      },
      errorElement: "span",                            
      messages: {
        fullname: "Please enter your sweet name",
        email: "Please enter valid email address",
        company: "Please enter your company name",
        city: "Please choose your city",
        mobile: "Please enter 10 digit mobile number"
      },
      submitHandler: function(form) {
        var dataparam = $('#requestForm').serialize();
        $.ajax({
          type: 'POST',
          async: true,
          url: 'campaigns.php',
          data: dataparam,
          datatype: 'json',
          cache: true,
          global: false,
          beforeSend: function() { 
            $('#submitContactLabel').html("SUBMITTING...");
          },
          success: function(data) {
            if(data == 'success'){
              $('.contact-title').hide();
              $('.contact-form').hide();
              $('.contact-form-success').show();
              setTimeout(function(){
                $('.contact-form-success').hide();
                $('.contact-title').show();
                $('.contact-form').show();
                $('#submitContactLabel').html("KNOW MORE");
              }, 60000);
            } else {
              $('#submitContact').addClass('failed');
              $('#submitContactLabel').html("SORRY, TRY AGAIN!");
              setTimeout(function(){
                $('#submitContact').removeClass('failed');
                $('#submitContactLabel').html("KNOW MORE");
              }, 5000);
            }
          },
          complete: function() { 
            $("#requestForm")[0].reset();
          }
        });
      }                
  });
});