 $('.toggle-right-box, #total_cart_products').show();
$(document).ready(function() {
    $("a[href$='#next']").hide();
    $("a[href$='#previous']").hide();
    /*$('.toggle-right-box .fa-bars').click();*/
    $("#wizard-p-0").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom");
    $("#wizard-p-1").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom");
    $("#wizard-p-2").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom");
    $("#wizard-p-0").css("width", "100% !important");

    $(function() {
        $('#product_list').slimScroll({
            height: '345px',
            wheelStep: 1,
            railVisible: true,
            alwaysVisible: true,
            start: 'top'
        });
    });
    
    $(function() {
        $('#pur_list').slimScroll({
            height: '214px',
            wheelStep: 1,
            railVisible: true,
            alwaysVisible: true,
            start: 'top'
        });
    });
    $(function() {
        $('#tot_list').slimScroll({
            height: '315px',
            wheelStep: 1,
            railVisible: true,
            alwaysVisible: true,
            start: 'top'
        });
    });

    $("#next_buton").show();


});

function openPurchaseList(list_id) {

    $('#totalsummary').show();
    $('#place_order').show();
    var sat = $('#save_status').val();
    $("#start_msg").hide();
    //$('#list_of_products').show();
    var tempVal = $('#list_id').val();


    if (sat != 1 && sat != 2) {
        var productarray = new Array();
        $('input.getQTY').each(function() {
            if ($(this).val() > 0)
                productarray.push(this.id + "-" + $(this).val());
        });
        if (tempVal == list_id)
            return false;
        if (tempVal != list_id) {
            if (productarray != "") {

                if (confirm("Your list are not Added. Press OK to Add the list")) {
                    addToSummary(1, tempVal);
                } else {
                    $('#save_status').val(1);
                    $("#tot_no_qty_" + tempVal).html(0);
                    $("#tot_price_" + tempVal).html(0);
                    openPurchaseList(list_id);

                }

            }
        }
    }
    $('#list_id').val(list_id);
    $('#save_status').val(0);
    $('#selectList').val(0);
    var type = 1;
    var listStatus = 1;
    var dataparam = '&list_id=' + list_id + '&type=' + type + '&id_customer=' + id_customer + '&listStatus=' + listStatus;
	
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-PurchaseList.php',
        data: dataparam,
        cache: true,
        success: function(data) {

             if (data == "")
             {
                var alertmsg = "No Products In Selected List";
                $("#id_alert").html(alertmsg);
                $('#alert_msg').modal('show');
                return false;
             }
            $("#listofproducts").html('');
            $("#list_of_products").show();
            $('.margin-align-bottom .text-muted').hide();

            $("#listTitle").html(data[0].list_name);

            $("#list_heading").html("<span id='heading_name'>" + data[0].list_name + "</span>");
            //$("#loading_img").show();
            for (var i = 0; i < data.length; i++) 
            {
                var str = data[i].description_short;
                //var price = (data[i][1]).toFixed(2);
                var list_name = data[0].list_name;
                var list_id = data[0].id_pur_list;
				var rate_contract_id = data[i].id_rate_contract;
				var product_id = data[i].id_product;
                var str = str.replace(/(<([^>]+)>)/ig, "");

                if (str.length > 65) str = str.substring(0, 65) + "...";
                if (data[i].product_quantity > 0)
                    var price_value = (data[i].product_quantity * data[i].price).toFixed(2);
                else
                    var price_value = "Rs. 0.00";
					
				var tax = data[i].tax_value;
 				//tax = tax.replace(/[^0-9\.]+/ig,"");
				var taxprice = data[i].price_tax_exc * tax / 100 ;
				var price = data[i].price_tax_exc + taxprice;
				if(data[i][2]!=0)
				{
					var points = ("<span class='txt-right'>Loyalty points: <span class='text-danger'><strong>"+data[i][2]+"</strong></span> </span></td>");
				}
				else
				{
					var points = ("<span class='txt-right'>No Loyalty points</span>");
				}
                var available_for_order='';
                if(data[i].available_for_order==0)
                {
                    available_for_order="<td style='width: 10%;'><span class='text-align'>Out Of Stock</span></td><td style='width: 10%;'></td>";
                }
				else if(data[i].available_for_order==1)
                {
                    available_for_order="<td style='width: 10% !important;' class='td_qty_price fontAlign' id='td_qty_" + data[0].id_product + "'><span><input tabindex='" + i + 1 + "' type='text' onchange='updateTotalPrice(" + price + "," + data[i].id_product + ",\"" + list_name + "\"," + list_id + ");' id='" + data[i].id_product + "' style='text-align:center;' class='qv_quantity_wanted fontAlign getQTY' size='3' maxlength='5' placeholder='0'/></span><br><span class='txt-bottom'>Min Qty: "+data[i].minimal_quantity+"</span></td><td style='width: 10%;' class='td_qty_price text-danger priceChange' id='td_price_" + data[i].id_product + "'><strong>" + price_value + "</strong></td>";
                }
                if(data[i].price==0.00)
                {                    
                    available_for_order="<td style='width: 10%;'><span class='text-align'>Contact us for price</span></td><td style='width: 10%;'></td>";
                }
                /*$("#pur_list_products").append("<tr id='tr_pur_id_" + data[i].id_product + "' class='listProdcuts'><td id='td_img_" + i + 1 + "'><img src=" + data[i][0] + "></td><td class='width49'><h5 class='cur-poi' onclick='quickView("+data[i].id_product+",0);'>" + data[i].name + "</h5><span class='txt-left' >Product Code: <span class='text-danger'>" + data[i].reference + "</span></span><span class='txt-right'>Product Price: <span class='text-danger'><strong>Rs. " + (data[i].price_tax_exc).toFixed(2) + "</strong></span></span><br /><br /><span class='td_des_short' id='td_desc_" + data[i].id_product + "'>" + str + "</span><span class='txt-right'>VAT : <span class='text-danger'><strong>" +data[i].tax_value +"</strong></span>&nbsp&nbsp<abbr title='Click here to change VAT'><span class='fa fa-question-circle cur-poi vat_change' onclick='selectState(1);'></span></abbr></span></td><td class='td_qty_price fontAlign'></br><span class='txt-right'>Per Month:<span class='text-danger'><strong> "+data[i].per_month+"&nbsp;units</strong></span></span><br /><br />"+points+"<td class='td_qty_price fontAlign' id='td_qty_" + data[0].id_product + "'><input tabindex='" + i + 1 + "' type='text' onchange='updateTotalPrice(" + price + "," + data[i].id_product + ",\"" + list_name + "\"," + list_id + ");' id='" + data[i].id_product + "' style='text-align:center' class='qv_quantity_wanted fontAlign getQTY' size='3' maxlength='5' value='" + data[i].product_quantity + "' /></td><td class='td_qty_price text-danger priceChange' id='td_price_" + data[i].id_product + "'><strong>" + price_value + "</strong></td><td class='td_qty_price text-danger fontAlign cur-poi'><span class='fa fa-trash-o fontAlign' onclick='deleteProductFromList(" + list_id + ","+ rate_contract_id + ","+ product_id + ");'></span></td></tr>");*/
                $("#pur_list_products").append("<tr id='tr_pur_id_" + data[i].id_product + "' class='listProdcuts'><td id='td_img_" + i + 1 + "' style='width: 12%;'><img src=" + data[i][0] + "></td><td class='width49' style='width: 55% !important;'><h5 class='cur-poi' onclick='quickView("+data[i].id_product+",0);'>" + data[i].name + "</h5><span class='txt-left' >Product Code: <span class='text-danger'>" + data[i].reference + "</span></span><span id='purchase_price_"+i+"' class='txt-right'>Product Price: <span class='text-danger'><strong>Rs. " + (data[i].price_tax_exc).toFixed(2) + "</strong></span></span><br /><br /><span class='td_des_short' id='td_desc_" + data[i].id_product + "'>" + str + "</span><span id='purchaselist_vat_"+i+"' class='txt-right'>VAT : <span class='text-danger'><strong>" +data[i].tax_value +"&nbsp%</strong></span></span></td><td class='td_qty_price fontAlign' style='width: 15%;'></br><span class='txt-right'>Per Month:<span class='text-danger'><strong> "+data[i].per_month+"&nbsp;units</strong></span></span><br /><br />"+points+""+available_for_order+"</tr>");//deleteProductFromList option removed
                if(data[i].price==0.00){
                    $("#purchase_price_"+i).hide();
                    $("#purchaselist_vat_"+i).hide();
                }
				$("#cart_button").show();
                $("#order_button").show();
                updateTotalPrice(price = 0, id = 0, listname = "", list_id);
            }
                $(function() {
                    $('#product_list').slimScroll({
                        start: 'top',
                        height:'400px'
                    });
                });
        }
    });

}


function updateTotalPrice(price, id, listname, list_id) {
    $(".getQTY").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    var qty = $("#" + id).val();
    var totalprice = qty * price;
    var totalprice = (totalprice).toFixed(2);
    $("#td_price_" + id).html("<strong>Rs. " + totalprice + "</strong>");


}

function addToSummary(status, idList) {
        if (idList == 0)
            var list_id = $('#list_id').val();
        else{
            var list_id = idList;
        }
       
        var firstid = "tr_head_" + list_id + "";

        var checkqty = new Array();
        $('input.getQTY').each(function() {
            if ($(this).val() > 0) {
                checkqty.push(this.id + "-" + $(this).val());
            }
        });

        if (checkqty == "") {
            var alertmsg = "No Products To Add";
            $("#id_alert").html(alertmsg);
            $('#alert_msg').modal('show');
            return false;
        }
 

        var productqty = new Array();
        $('input.getQTY').each(function() {
            if ($(this).val() > 0) {
                productqty.push(this.id + "-" + $(this).val());
            }
        });


        $('#save_status').val(1);
        var type = 2;
        var listStatus = 2;
        var dataparam = '&productarray=' + productqty + '&type=' + type + '&id_customer=' + id_customer + '&list_id=' + list_id + '&listStatus=' + listStatus;
        $.ajax({
            //global: false,
            type: 'POST',
            dataType:'json',
            async: true,
            url: 'dash-PurchaseList.php',
            data: dataparam,
            cache: false,
            success: function(data) {
				$('#listoferrors').html('');
  				 /*if(data !="")
				 {*/
				 var success=0;
					 for(var i =0 ; data.length >i; i++)
					 {
						 if(data[i].msg != "success")
						 {
 						 	//var sno=i+1;
						 	//$('#error_alert').append("<div><span>"+sno+")</span><span>"+data[i].name+"</span></div>");
							$('#listoferrors').append("<tr><td>"+data[i].name+"</td><td>"+data[i].msg+"</td></tr>");
							$('#error_cart').modal('show');
						 }
						 else
						 {
							success++; 
						 }
					 }
					
				 /*}*/
                 /*loadShopingCart() in dash-index.js*/
 				 if(success >0)
				 {
                  	loadShopingCart();
					 if ($('#container').hasClass('open-right-panel')) {
 					} 
					 else {
						 //$('#container').addClass('open-right-panel');
						/*$(".shopping-cart").click();
						alert("buton clicked");*/
						$('.shopping-cart').trigger('click');
					 }
				 }
                $('.getQTY').val('0');
				$('.priceChange').html('<strong>Rs. 0.00</strong>	');
                
            }
        });
        if (status == 1)
            sta = 1;
        else
            sta = 0;
        staticMessage(sta);	
        updateTotalPrice();

    }
 function staticMessage(status) {
    if (status != 1) {
        //$('#list_of_products').hide();
        $('#start_msg').show();
    }
}
function deleteProductFromList(list_id,rate_contract_id,product_id)
{
		
		
		
  		var type=5;
		var dataparam ='&list_id='+list_id+'&rate_contract_id='+rate_contract_id+'&type='+type
		$.ajax({
			
			type: 'POST',
            //dataType:'json',
            async: true,
            url: 'dash-PurchaseList.php',
            data: dataparam,
            cache: false,
			 success: function(data)
			 {
				 if(data==1)
				 {
					
					var alertmsg = "Product Deleted Successfully";
					$("#id_alert").html(alertmsg);
					$('#alert_msg').modal('show');
					$("#tr_pur_id_"+ product_id).remove();
					
				}
				 
				 else
				 {
					var alertmsg = "Product Not Deleted";
					$("#id_alert").html(alertmsg);
					$('#alert_msg').modal('show');
				 }
				 	
			 
			 }
		});
		
}

$(document).ready(function()
{
    $('#search-pur-list').keyup(function()
    {
        searchTable($(this).val());
    });
});

function searchTable(inputVal)
{
    var table = $('#pur_list_products');
    table.find('tr').each(function(index, row)
    {
        var allCells = $(row).find('td');
        if(allCells.length > 0)
        {
            var found = false;
            allCells.each(function(index, td)
            {
                var regExp = new RegExp(inputVal, 'i');
                if(regExp.test($(td).text()))
                {
                    found = true;
                    return false;
                }
            });
            if(found == true)$(row).show();else $(row).hide();
        }
    });
}

