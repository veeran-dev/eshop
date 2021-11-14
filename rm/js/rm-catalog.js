$(document).ready(function() {
    //$('.expiry_date').datepicker();

    var table = $('#example').DataTable({ "bSort" : false });
        // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var group_id = tr['0']['id'];
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            var option = $('.btn-container .active').html();

            // Open this row
            if(option == 'Price'){
                if($('#show_price_'+group_id).length <= 0){
                    toast("Sorry data not available", "warning");
                }
                row.child( $('#show_price_'+group_id).html() ).show();
            }
            else{
                if($('#show_others_'+group_id).length <= 0){
                    toast("Sorry data not available", "warning");
                }
                row.child( $('#show_others_'+group_id).html() ).show();
            }

            $('.datepicker').datepicker({format:'yyyy-mm-dd'});
            tr.addClass('shown');
        }
    });

    $('.btn-container .btn').on('click', function () {
        if($(this).html() == 'Price' && !$(this).hasClass('active')){
            $(this).addClass('active');
            $('.btn-container .btn-others').removeClass('active');
        }else if($(this).html() == 'Others' && !$(this).hasClass('active')){
            $(this).addClass('active');
            $('.btn-container .btn-price').removeClass('active');
        }


        if($('.odd').hasClass('shown') || $('.even').hasClass('shown'))
        {
            var tr = $('.shown');
            var row = table.row( tr );
            var group_id = tr['0']['id'];
            if ( row.child.isShown() ) {
                var option = $('.btn-container .active').html();
                // Open this row
                if(option == 'Price'){
                    row.child( $('#show_price_'+group_id).html() ).show();
                }
                else{
                    row.child( $('#show_others_'+group_id).html() ).show();
                }
                $('.datepicker').datepicker({format:'yyyy-mm-dd'});
            }
        }
    });

} );

function readNotifications(element, classname, id){
    $('#example #'+id+' .'+classname+' tr td .read_check:visible').click();
}

function checkRows(id, classname, element)
{
    var current_value;
    if($(element).attr('checked')){
      $("#example #"+id+" ."+classname).each(function () {
        current_value = $("#example #"+id+" ."+classname+"_id_catalog_change").val()+","+$(this).val().replace("_checkbox","");
        $("#example #"+id+" ."+classname+"_id_catalog_change").val(current_value);
      });
    }
    else{
      $("#example #"+id+" ."+classname).each(function () {
        $("#example #"+id+" ."+classname+"_id_catalog_change").val("");
      });
    }
}

function readNotification(element, type, classname, id_company){

    var row = $(element).parent().parent();    
    while($(row).find('td:last .'+classname).hasClass('read_check'))
    {
      if(row.attr('data-row-value') == 0){
        $(row).attr('data-row-value','1');
      }
      else{
        $(row).attr('data-row-value','0');
      }
      row = row.next();
    }

    if($(element).hasClass('fa-exclamation-circle')){
        $(element).removeClass('fa-exclamation-circle');
        $(element).addClass('fa-check-circle');
    }
    else{
        $(element).removeClass('fa-check-circle')
        $(element).addClass('fa-exclamation-circle');
    }

    var arr = [];
    var ids = "";
    $("#"+id_company+"_"+type+" ."+classname+"").each(function(){
        if($(this).val() != "")
        {
          ids = ids+","+$(this).val().replace("_checkbox","");  
        }
    });

    //var dataparam = "&id_catalog_change="+id+"&id_company="+id_company+"";
    var dataparam = "&id_catalog_changes="+ids.replace(/^,/, '')+"&id_company="+id_company+"";
    $.ajax({
            type: 'POST',
            async: true,
            url: 'rm-change-notification.php',
            //dataType:'json',
            cache: true,
            data:dataparam,
            success: function(data)
            {

            }
        });
}

function readAllNotfication(element, id_company, type){
    var arr = [];
    var ids = "";
    $('#example #'+id_company+'_'+type+' .hidden_id_catalog_change').each(function(){
        if($(this).val() != ""){
          ids = ids+$(this).val();  
        }
    });
    if(ids.length == 0){
        toast("please select rows", "warning");
        return false;
    }
    arr = ids.replace(/^,/, '').split(',');
    var dataparam = "&id_catalog_changes="+ids.replace(/^,/, '')+"&id_company="+id_company+"";
    $.ajax({
        type: 'POST',
        async: true,
        url: 'rm-change-notification.php',
        //dataType:'json',
        cache: true,
        data:dataparam,
        success: function(data)
        {
            if(data == 1){
                jQuery.each( arr, function( i, val ) {
                      if($('#'+id_company+'_'+type+' tbody tr td #'+val+'').hasClass('fa-exclamation-circle')){
                            $('#'+id_company+'_'+type+' tbody tr td #'+val+'').addClass('fa-check-circle');
                            $('#'+id_company+'_'+type+' tbody tr td #'+val+'').removeClass('fa-exclamation-circle');
                      }
                      else{
                            $('#'+id_company+'_'+type+' tbody tr td #'+val+'').addClass('fa-exclamation-circle');
                            $('#'+id_company+'_'+type+' tbody tr td #'+val+'').removeClass('fa-check-circle');
                      }
                });

            }
            else{
                toast("Something went wrong, please check", "error");
            }
        }
    });
}
function downloadQuote(id_company){

    var data = [];
    var now = new Date();
    //var id_company = $('.shown').attr('id');

    $('.rate_contract').each(function(i){
        var price = $(this).find('.price').val();
        var expiry_date = $(this).find('.datepicker').val();
        var current_date = new Date(expiry_date);
        var id_product = $(this).find('.product_id').val();
        var product_name = $(this).find('.product_name').val();
        var product_price = $(this).find('.product_price').val();
        if(price && expiry_date && id_product)
        {
            if(isNaN(price) || price < 0){
                toast('please enter a valid price','warning');
                return false;
            }
            else if (current_date < now) {
                toast('please enter a valid date','warning');
                return false;
            }
            else 
            {
                if(parseFloat(product_price) < parseFloat(price)) {
                  toast('MRP exceeds for product '+product_name, 'warning');
                  return false;
                }

                data.push({
                    price: parseFloat(price), 
                    expiry_date: expiry_date,
                    id_product: id_product
                });
            }
        }
    });
    
    if(data.length === 0){
        return false;
    }

    var dataparam = "&quote=1&id_company="+id_company+"&quote_details="+JSON.stringify(data)+"";
    $.ajax({
        type: 'POST',
        async: true,
        url: 'rm-change-notification.php',
        dataType:'json',
        cache: true,
        data:dataparam,
        success: function(data)
        {
            if(data != 0){
                $('#quotation-history-hidden-data').empty();
                $('#quotation-history-hidden-data').append('<input id=quote-excel-' + data + ' type="text" name="id-quotation" value=' + data + '>');
                $('#form_quotation_excel').submit();
            }
            else{
                toast("Sorry unable to download quotation", "error");
            }
        }
    });
}

function sortTable(n, element,  type) {
    if($(element).hasClass('fa-chevron-up')){
        $(element).addClass('fa-chevron-down');
        $(element).removeClass('fa-chevron-up');
    }
    else{
        $(element).addClass('fa-chevron-up');
        $(element).removeClass('fa-chevron-down');
    }
  var table_id, table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  var id = $('.shown').attr('id');
  table_id = $(element).closest('table').attr('id');
  table = document.getElementById(table_id);

  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = $(rows[i]).attr('data-row-value');
      y = $(rows[i+1]).attr('data-row-value');

      // x = rows[i].getElementsByTagName("TD")[n];
      // y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if ($(rows[i]).attr('data-row-value') > $(rows[i+1]).attr('data-row-value')) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if ($(rows[i]).attr('data-row-value') < $(rows[i+1]).attr('data-row-value')) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}


function sortTableDate(n, element,  type, id) {
    if($(element).hasClass('fa-chevron-up')){
        $(element).addClass('fa-chevron-down');
        $(element).removeClass('fa-chevron-up');
    }
    else{
        $(element).addClass('fa-chevron-up');
        $(element).removeClass('fa-chevron-down');
    }
  var table_id, table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table_id = $(element).closest('table').attr('id');
  table = document.getElementById(table_id);

  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = $(rows[i]).attr('data-row-id');
      y = $(rows[i+1]).attr('data-row-id');

      // x = rows[i].getElementsByTagName("TD")[n];
      // y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if ($(rows[i]).attr('data-row-id') > $(rows[i+1]).attr('data-row-id')) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if ($(rows[i]).attr('data-row-id') < $(rows[i+1]).attr('data-row-id')) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}