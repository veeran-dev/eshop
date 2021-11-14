$(document).ready(function(){
    $('.brand-slider').slick({
        arrows: false,
        dots: true
    });

    jQuery.validator.addMethod("notEmpty", function(value, element) { 
      return value.replace(/^\s+|\s+$/g, "").length != 0; 
    }, "Please don't leave it empty");


    // Conatct Form
    $('#requestForm').validate({
        rules: {
          firstname: {
            required: true,
            notEmpty: true
          },
          email: {
              required: true,
              email: true
          },
          designation: "required",
          id_country: "required"
        },
        errorElement: "span",                            
        messages: {
          fullname: "Please enter your sweet name",
          email: "Please enter valid email address",
          designation: "Please enter your job title",
          id_country: "Please choose your country",
        },
        submitHandler: function(form) {
          var dataparam = $('#requestForm').serialize();
          $.ajax({
            type: 'POST',
            async: true,
            url: 'bottomline-ajax.php',
            data: dataparam,
            datatype: 'json',
            cache: true,
            global: false,
            beforeSend: function() { 
              $('#submitContactLabel').html("SUBMITTING...");
            },
            success: function(data) {
              if(data == "success"){
                $('.request-form').hide();
                $('.contact-form-success').show();
                setTimeout(function(){
                  $('.contact-form-success').hide();
                  $('.request-form').show();
                  $('#submitContactLabel').html("GET STARTED");
                }, 60000);
              } else {
                $('#submitContact').addClass('failed');
                $('#submitContactLabel').html("SORRY, TRY AGAIN!");
                setTimeout(function(){
                  $('#submitContact').removeClass('failed');
                  $('#submitContactLabel').html("GET STARTED");
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