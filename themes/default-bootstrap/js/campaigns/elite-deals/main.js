window.count = 0;
window.history.pushState(null, "", window.location.href);
window.onpopstate = function () {
    window.history.pushState(null, "", window.location.href);
};
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
function removeProduct(id){
    window.count--;
    $('#item_'+id).remove();
    $('#selectProduct'+id).attr("checked", false);
    $('.count').html(window.count);
}
$(document).ready(function(){
    var add = [];
    var remove = [];
    $('.addProduct').on("dblclick", function(e){
        e.preventDefault();  //cancel system double-click event
    });

    $('.addProduct').on('click',function(event){
      event.stopPropagation();
      event.preventDefault();
      var id = $(this).attr('id').replace("_add","");
      if($('#selectProduct'+id).prop("checked")){
        window.count--;
        $('#selectProduct'+id).attr("checked", false);
        $('#item_'+id).remove();
        $('.count').html(window.count);

        $(add).remove();
        add = $("<li/>").addClass('snackbar warning show').html("Product is removed from the list").appendTo($("#snackbar-wrapper")); //main div
        setTimeout(function(){
            $(add).remove();
          }, 1500);
      }
      else{
        window.count++;
        $('#selectProduct'+id).attr("checked", true);
        $('.items-list').append('<div class="item" id="item_'+id+'">\
                                    <div class="name" id="product_name_'+id+'">'+$('#'+id+'_name').html()+'</div>\
                                    <div class="quantity"><input type="number" onkeydown="return event.keyCode !== 69" id="item_qty_'+id+'" name="item_qty" value="1"></div>\
                                    <div class="action"><span onClick="removeProduct('+id+')" class="removeProduct" id="remove_'+id+'">Remove</a></div>\
                                </div>');
        $('.count').html(window.count);

        $(remove).remove();
        remove = $("<li/>").addClass('snackbar show').html("Product is added to the list").appendTo($("#snackbar-wrapper")); //main div
        setTimeout(function(){
            $(remove).remove();
          }, 1500);
      }
    });

    $('.brand-slider').slick({
        arrows: false,
        dots: true
    });

});

function submitForm(){
  var products = [];
  var errors = 0;
  $('.items-list .name').each(function(){
    var id =$(this).attr("id").replace("product_name_","");
    var price = $('#item_qty_'+id).val();
    if($('#item_qty_'+id).val() < 1 || price%1 !=0){
      var add = [];
      products = [];
      errors = 1;
      $(add).remove();
      add = $("<li/>").addClass('snackbar warning show').html("Please add valid quantity").appendTo($("#snackbar-wrapper"));
      setTimeout(function(){
        $(add).remove();
      }, 1500);
      return false;
    }
    else{
      products.push($(this).html()+"~"+$('#item_qty_'+id).val());
    }
  });

  if(errors === 1){
    return false;
  }

  if(products.length > 0){
    dataparam = '&products='+products;
  }
  else{
    var add = [];
    $(add).remove();
    add = $("<li/>").addClass('snackbar warning show').html("Please add atleast 1 product").appendTo($("#snackbar-wrapper")); //main div
    setTimeout(function(){
      $(add).remove();
    }, 1500);
    return false
  }

  d = $('<div class="checkmark-wrapper"><div class="checkmark-container"> <div class="circle-loader ad-complete"><div class="checkmark draw"></div></div><div class="content"><h5>Loading..</h5></div></div></div>');
  d.appendTo($(".categories-section"));

  $.ajax({
        type: 'POST',
        async: true,
        url: 'campaigns.php',
        //dataType:'json',
        cache: true,
        data: dataparam,
        success: function(data)
        {
          console.log(data);
        },
        complete: function() { 
          // $("#requestForm")[0].reset();
          window.count = 0;
          $('.count').html(window.count);
          $(".items-list").html(" ");
          $('.selectProduct').attr("checked", false);
          $('.circle-loader').toggleClass('load-complete');
          $('.checkmark').toggle();
          $('.content').html('<h3>Thank you</h3><h5>Our Relationship manager will contact you shortly</h5>');

          // d = $("<li/>").addClass('snackbar show').html("Thank you, your Relationship manager will contact you.").appendTo($("#snackbar-wrapper")); //main div
          setTimeout(function(){
              $(d).remove();
            }, 3000);
        }
  });
}