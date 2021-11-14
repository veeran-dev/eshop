var purList=0, loadtablevalue = 0, idProduct = 0, ordering_type;
window.id_customer;
window.rm_portal=1;
window.hide_address_value=0;					
window.shopingcart;
window.loyalty_points;
window.cus_default_group = 0;
window.count=0;
window.loading;
window.global_default_group = 0;
window.company_id = 0;
window.state_id = 0;
window.scn_quote_id = 0;
window.tax_rate = 0;
window.global_id_fc = 0;
window.fc_name = "";
window.quote_revise_attempt = true;
window.deliverRegionRm = 0;
window.deliveryAddress = 0;
window.id_fc = 0;
window.fc_name ="";
window.id_group = 0;
window.group_name = "";

 $(function(){
    $(".shoppingCartTable").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "5px",
				autohidemode: false
            });
});
 $(document).ajaxStart(function()
{ 
	loading =0;
});
$(document).ajaxStop(function() 
{
	loading = 1;
 	
});	
	
 
$(document).ready(function()
{
	$('.date-range-block').hide();
	$('.panel .tools .fa').click(function () 
	{
	    var el = $(this).parents(".panel").children(".panel-body");
	    el.slideToggle( "slow" );
	});
    
    $(".ratecontract_edit").die('click').live('click',function() {
        $(this).closest('tr').find('.datepicker').show();
        $(this).closest('tr').find('.ratecontract_save').show();
        $(this).closest('tr').find('.ratecontract_reply').show();
        $(this).hide();
    });
    $(".ratecontract_reply").die('click').live('click',function() {
        $(this).closest('tr').find('.datepicker').hide();
        $(this).closest('tr').find('.ratecontract_save').hide();
        $(this).closest('tr').find('.ratecontract_date').show();
        $(this).closest('tr').find('.ratecontract_edit').show();
        $(this).hide();        
    });

    $(".ratecontract_save").die('click').live('click',function() {
        var date = $(this).closest('tr').find('.datepicker').val();
        var pointer=$(this);
        var id_specific_price = $(this).attr('name');
        if(date == '')
        {
            toast('please enter a valid date','warning');
            return false;
        }

        var dataparam = 'date='+date+'&id_specific_price='+id_specific_price+'&type=5';        

        $.ajax({
                    type: 'POST',
                    async: true,
                    url: 'rm-customerratecontractdata.php',
                    //dataType:'json',
                    cache: true,
                    data:dataparam,
                    beforeSend: function() {$(".ajaxLoaderModal").show();},
                    success: function(data)
                    {
                        if(data == 0)
                        {
                            $('#'+id_specific_price+"_to").show();
                            $('#'+id_specific_price+"_date").hide();
                            
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_save').hide();
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_edit').show();
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_reply').hide();                           
                            toast('Unable to change valid till date','warning');
                        }
                        else
                        {
                            $('#'+id_specific_price+"_to").html(date);
                            $('#'+id_specific_price+"_to").show();
                            $('#'+id_specific_price+"_date").hide();
                            
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_save').hide();
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_edit').show();
                            $('#id_rate_contract_'+id_specific_price).find('.ratecontract_reply').hide();                           
                        }
                    },
                    complete: function(){$(".ajaxLoaderModal").hide();}
                    
            });
    });
});


 //Open Place Order
function placeRMOrder()
{
 	$('#index_viewport').html('');
	$('#index_viewport').load('rm-placeOrder.php');
}
function openPerks()
{
    $('#index_viewport').html('');
    $('#index_viewport').load('rm-perks.php');
}

function openDocs()
{
    $('#index_viewport').html('');
    $('#index_viewport').load('rm-docs.php');
}

function openWaterDelivery()
{
    $('#index_viewport').html('');
    $('#index_viewport').load('rm-waterDelivery.php');
}

function openModal()
{
    $('#newPerks').modal('show');
}

function closeModal()
{
    $('#newPerks').modal('hide');
}

function validate_isEmail(s)
{
    var reg = new RegExp("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$");
    return reg.test(s);
}
function downloadDocs(type)
{
    var invoice_number = $('#invoice').val();
    var delivery_number = $('#dr').val();
    var dataparam = "";
    if(type==1) {
        if(delivery_number == "") {
            toast("Please enter DR number", "error");
            return false;
        }

        dataparam = "&dr="+delivery_number+"";
    }
    else {
        if(invoice_number == "") {
            toast("Please enter invoice number", "error");
            return false;
        }
        dataparam = "&invoice="+invoice_number+"";
    }

    $.ajax({
        type: 'POST',
        async: true,
        url: 'rm-docs-download.php',
        dataType:'json',
        cache: true,
        data: dataparam,
        success: function(data)
        {
            if(type == 2)
            {
                if(data != 0){
                    var link = $('#dwnldInv').html('<a class="text-primary" id="hitme" href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token='+data['token']+'&submitAction=generateInvoicePDF&id_order='+data['order']+'" download>Download Here</a>');
                }
                else
                {
                    toast("please enter valid number","warning");
                }
            }
            else
            {
                if(data != 0){                    
                    var link = $('#dwnldDr').html('<a class="text-primary" href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token='+data['token']+'&submitAction=generatePartialDeliverySlipPDF&id_order='+data['id_order']+'&id_delivery='+data['id_delivery']+'" download>Download Here</a>');
                }
                else
                {
                    toast("please enter valid number","warning");
                }
            }
            
            
        }
    });
}
function savePerks()
{
    var id_group = $('#group_selection').val();
    var email = $('#email').val();
    var city = $('#city option:selected').val();
    var state = $('#state option:selected').val();
    var address1 = $('#address1').val();
    var postcode = $('#postcode').val();
    if(email == '' || id_group == '' || id_group == 0)
    {
        toast('Please enter valid email address and company name','warning');
        return false;
    }
    if(!(validate_isEmail("kobster"+email) && email.charAt(0) == '@'))
    {
        toast('Please enter valid email address','warning');
        return false;
    }

    if((address1 == "" && city == "" && state =="" && postcode == "") || (address1 != "" && city != "" && state !="" && postcode != ""))
    {
        //return true
        if(postcode != ""){
            var reg = /^[0-9]+$/;
            if ((postcode.length)< 6 || (postcode.length)> 6 ){
                toast('Postcode should only be 6 digits','warning');
                return false;
            }

            if (!reg.test(postcode)){
                toast('Postcode should be numbers only','warning');
                return false;
            }    
        }
        
    }
    else
    {
        toast('Please fill all the address fields','warning');
        return false;
    }
    var dataparam ='&type=1&id_group='+id_group+'&email='+email+'&address1='+address1+'&city='+city+'&state='+state+'&postcode='+postcode+'';
    $.ajax({
        type: 'POST',
        async: true,
        url: 'rm-perksData.php',
        dataType:'json',
        cache: true,
        data: dataparam,
        success: function(data)
        {
            if(data == 1)
            {
                toast("Company added successfully","success");
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                openPerks();
            }
            else if(data == 2)
            {
                toast("Domain name already exists","warning");
            }
            else
            {
                toast("Unable to add Company","error");   
            }
        }

    });
}
function getStatusDetails(id_order, delivery_add, invoice_add) {
    var type = 2; //(to get details  for a particular order id)
    $("#history_status").html('');
    $("#productsTable").html('');
    $('#orderflow').html('');
	$('#points_history').modal('hide');
    var dataparam = '&id_order=' + id_order + '&type=' + type + '&delivery_add=' + delivery_add + '&invoice_add=' + invoice_add;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-history.php',
        data: dataparam,
        cache: true,
        success: function(data) {
            $('#reorder_button').html('');
            $('#order_id').html("<strong>" + id_order + "</strong>");
            var order_state_reverse = data[0].reverse();
            for (var i = data[0].length; i > 0; i--) {
                if (data[0][i - 1].hidden == 0) {
                    if (i == 1)
                        var line = 1;
                    //alert(data[0][i-1].name);
                    if((data[0][i-1].name == 'Generate Invoice') && (data[0][i-1].name == 'Offline invoice generated'))
                    {
                        data[0][i-1].name = 'Invoice Generated';
                    }
                    
                    iconSelection(data[0][i - 1].id_order_state, data[0][i - 1].date_add, data[0][i - 1].name, type = 2, line);
                }
            }

            $("#billingAddress").html("<span><strong>Billing Address</strong></span><br><span>" + data[1][0].firstname + "</span><br><span>" + data[1][0].address1 + "</span><br><span>" + data[1][0].city + "</span><br><span>" + data[1][0].state + "</span><br><span>" + data[1][0].postcode + "</span><br><span>" + data[1][0].country + "</span><br><span>" + data[1][0].phone_mobile + "</span>");

            $("#deliveryAddress").html("<span><strong>Delivery Address</strong></span><br><span>" + data[2][0].firstname + "</span><br><span>" + data[2][0].address1 + "</span><br><span>" + data[2][0].city + "</span><br><span>" + data[2][0].state + "</span><br><span>" + data[2][0].postcode + "</span><br><span>" + data[2][0].country + "</span><br><span>" + data[2][0].phone_mobile + "</span>");

            /*This is for ordered products */
            for (var i = 0; i < data[3].length; i++) {
                $("#productsTable").append("<tr><td>"+(i+1)+"</td><td>" + data[3][i].product_reference + "</td><td>" + data[3][i].product_name + "</td><td>" + data[3][i].product_quantity + "</td><td>" + data[3][i].product_price_wt + "</td><td class='price'>" + parseFloat(data[3][i].total_price_tax_incl).toFixed(2) + "</td></tr> ");
            }

            if (data[5].total_shipping != 0 && data[5].total_shipping != "")
                $("#productsTable").append("<tr><td></td><td></td><td></td> <td><strong>Total shipping:</strong></td><td class='price'> <span  > " + data[5].total_shipping + "</span></td></tr>");

            if (data[5].total_paid != 0 && data[5].total_paid != "") {
                if (data[4] == 1) {
                    var taxprice = 'Total Amount (tax incl.):';
					var discount_price_display = 'Discounted Amount:';
                } else {
                    var taxprice = 'Total Amount (tax excl.):';
					var discount_price_display = 'Discounted Amount:';
				}
                 $("#productsTable").append("<tr><td></td> <td></td><td></td><td></td><td><strong>" + discount_price_display + "</strong></td><td class='price'> <span ><strong> " + parseFloat(data[5].total_discounts).toFixed(2) + " </strong></span></td></tr><tr><td></td> <td></td><td></td><td></td> <td><strong>" + taxprice + "</strong></td><td class='price'> <span ><strong> " + parseFloat(data[5].total_paid).toFixed(2) + " </strong></span></td></tr>");
                /*$('#reorder_button').append('<button data-dismiss="modal" style="float:left" onclick="reOrder(' + id_order + ')" class="btn btn-primary" type="button">Reorder</button>');*/
            }
        }
    });

}
function iconSelection(id_order_state, date_add, ostate_name, type, line) {
   
   /* if((ostate_name == 'Generate Invoice')&&(ostate_name == 'Offline invoice generated'))
    {
            ostate_name = 'Invoice Generated';
    }*/
 
    if (id_order_state == 22) /*Awaiting For Cheque payment*/ {
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/22.png">';
    } else if (id_order_state == 19) /*Preparation in progress*/ {
        h1Class = "darkgreen_text";
        var icon_img = '<img src="img/statusIcon/32/19.png">';
    } else if (id_order_state == 4) /*Shipped*/ {
        h1Class = "pink_text";
        var icon_img = '<img src="img/statusIcon/32/4.png">';
    } else if (id_order_state == 5) /*Delivered*/ {
        h1Class = "lightgreen_text";
        var icon_img = '<img src="img/statusIcon/32/5.png">';
    } else if (id_order_state == 6) /*Cancelled*/ {
        h1Class = "cancel_text";
        var icon_img = '<img src="img/statusIcon/32/6.png">';
    } else if (id_order_state == 7) /*Refund*/ {
        h1Class = "violet_text";
        var icon_img = '<img src="img/statusIcon/32/7.png">';
    } else if (id_order_state == 18) /*partially shipped*/ {
        h1Class = "lightred_text";
        var icon_img = '<img src="img/statusIcon/32/18.png">';
    } else if (id_order_state == 20) /*ready to shipped*/ {
        h1Class = "red";
        var icon_img = '<img src="img/statusIcon/32/20.png">';
    } else if (id_order_state == 21) /*partially Delivered*/ {
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/21.png">';
    }
    else if(id_order_state == 28) /*Pending For Approval*/{
        h1Class = "pending_approval_text";
        var icon_img = '<img src="img/statusIcon/32/28.png">';
    }
    else if(id_order_state == 29) /*Approved*/{
        h1Class = "approved_text";
        var icon_img = '<img src="img/statusIcon/32/29.png">';
    }
    else if(id_order_state == 30) /*Rejected*/{
        h1Class = "rejected_text";
        var icon_img = '<img src="img/statusIcon/32/30.png">';
    }
	else if(id_order_state == 30) /*Revised*/{
        h1Class = "approved_text";
        var icon_img = '<img src="img/statusIcon/32/31.png">';
    }
    else if(id_order_state == 32) /*Order Processing Held*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/32.png">';
    }
    else if(id_order_state == 33) /*Packed and Ready to be shipped  */{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/33.png">';
    }
     else if(id_order_state == 34) /*Offline invoice generated*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/34.png">';
    }
    else if(id_order_state == 25) /*Invoice Generated*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/25.png">';
    }
    else if(id_order_state == 35) /*Pending Payment*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/35.png">';
    }
    else if(id_order_state == 36) /*Payment recieved*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/36.png">';
    }
    else if(id_order_state == 37) /*Pending Invoice*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/37.png">';
    }
    else if(id_order_state == 38) /*Order Completed*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/38.png">';
    }
	else if(id_order_state == 39) /*Order Completed*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/39.png">';
    }
    else if(id_order_state == 40) /*Order Completed*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/40.png">';
    }
    else if(id_order_state == 41) /*Customer Verification Pending*/{
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/41.png">';
    }
    else if(id_order_state == 42){ /* customer verified */
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/42.png">';
    }
    /* Level 2 Approval */
    else if(id_order_state == 43){
        h1Class = "yellow_text";
        var icon_img = '<img src="img/statusIcon/32/43.png">';
    }
//	alert(type);
    if (type == 1) {
         
        if(id_order_state == 25 || id_order_state == 34)
        {
             ostate_name = 'Invoice Generated';
        }   
        $('.timeline').append('<article class="timeline-item ' + altClass + ' "><div class="timeline-desk"><div class="panel"><div class="panel-body"><span class="arrow' + spanClass + '"></span><span class="timeline-icon">' + icon_img + '</span><h1 class="' + h1Class + '">' + date_add + '</h1><p >' + ostate_name + '</p></div></div></div></article>');
    }
    else if (type == 2) {
       
        if (line == 1)
            var draw_line = '';
        else
            var draw_line = '<div class="animate-span drawLine"></div>';
		 /*if(ostate_name == 'Generate Invoice') 
			{
				 ostate_name = 'Invoice Generated';
			} 
		if(ostate_name == 'Offline invoice generated') 
			{
				 ostate_name = 'Invoice Generated';
			} */
		 if(id_order_state == 25 || id_order_state == 34)
        {
             ostate_name = 'Invoice Generated';
        }   
      

    $('#orderflow').append('<div style="float:left"><div id="order-status-icon-second-212" class="order-status-icon2 order-status-icon " style="float:left;"></span>' + icon_img + '</div>' + draw_line + '<div style="width: 67px;" ><br><br>' + ostate_name + '</div></div>');
    }
}

function setRegion(type) 
{
    if(type == 1) 
    {
        var regionId = $('#region_selection').val();
        var customerId = $('#customer_selection').val();

        if(id_customer != customerId) {
            id_customer = customerId;
        }

        if(regionId != "") {
            $.ajax({
                type: 'POST',
                async: true,
                url: 'B2cState.php',
                dataType:'json',
                cache: true,
                data: {
                    type: 5, 
                    id_customer, 
                    delivery_region: regionId, 
                    rm_request_no_delete: 1 
                },
                success: function(data)
                {
                    deliverRegionRm = regionId;

                    if(data == 1) {
                        showPlaceOrder();
                    }
                    else {
                        $('#listoferrors').html('');
                        $('#listoferrors').append("<tr><td>"+data[0].name+"</td><td>"+data[0].msg+"</td></tr>");
                        $('#error_cart').modal('show');
                        $('#errorFooter').show();
                    }
                }
            });
        }
    }
    else if(type == 2) {
        var regionId = $('#region_selection').val();
        var customerId = $('#customer_selection').val();

        if(id_customer != customerId) {
            id_customer = customerId;
        }

        if(regionId != "") {
            $.ajax({
                type: 'POST',
                async: true,
                url: 'B2cState.php',
                dataType:'json',
                cache: true,
                data:{ 
                    type: 5, 
                    id_customer, 
                    delivery_region: regionId, 
                    rm_request_no_delete: 0 
                },
                success: function(data)
                {
                    deliverRegionRm = regionId;
                    $('#error_cart').modal('hide');
                    $('#errorFooter').hide();
                    showPlaceOrder();
                }
            });
        }
    }
}

function showPlaceOrder() {
    var id_customer_details = $('#customer_selection').val();
    var id_customer = id_customer_details.split('~');
    var customer_id = id_customer[0];
    var shopping_cart_rm = $('.rmshoppingCartTr').html();
    if(shopping_cart_rm) {
      if ($('#container').hasClass('open-right-panel')) {}
    }
    else {  
        $('.toggle-right-box .fa-shopping-cart').click();
    }

    $( "#index_viewport" ).load( "rm-place-order-steps.php", function() {
        $('#wizard-p-0').load('rm-order.php');
        $('span#listTitle').html(customer_id.innerHTML);
        $('#next_button').show();
    });

    setTimeout(function(){
        $('span#listTitle').html(id_customer[2]);
        $('span#listTitle').css('cursor', 'default');
    },1000);

    $('div#place-order').show();
    
    searchRateContract();
    $("#rateContractSearchButton").css("background-color", "#4280EB");
    loadShopingCart();
}

function selectCustomer(name, page, deletecall, default_group, user_name)//page=>1 - rm placeorder for customer, page=>2 - customer rateContract page, default_group->customer default group
{
	global_default_group = default_group;
 	oldCustomer = id_customer;
	
	id_customer = name;

	cus_default_group = default_group;
    
 	if(page == 1) {
		$.ajax({
			type: 'POST',
			async: true,
			url: 'rm-setCustomerId.php',
			dataType:'json',
			cache: true,
			data: {
                id_customer, 
                type:1,
                id_employee
            },
			success: function(data)
			{
                if(data) {
                    $.ajax({
                        type: 'POST',
                        async: true,
                        url: 'B2cState.php',
                        dataType:'json',
                        cache: true,
                        data: { 
                            type: 7, 
                            id_customer
                        },
                        success: function(data)
                        {
                            var place_order = false;

                            if(data && data[1]) {
                                deliverRegionRm = data[1];
                                place_order = true;
                            }
                            else {
                                var states = data[0];
                                $('#region_selection').html('');
                                $('#region_selection').append('<option value="">Select Region</option>');
                                for(var i = 0; i < states.length; i++) {
                                    $('#region_selection').append('<option value="'+states[i].id_state+'">' + states[i].name + '</option>');
                                }
                                $('#region_selection').select2();
                                $('#region-selection').show();
                            }

                            if(place_order) 
                            {
                                showPlaceOrder();
                            }

                        }   
                    });
                }
			}	
		});
	}
 	else if(page==2 || page==3)//customer rate contract
 	{
  		if(loadtablevalue != 0)
		{
			$("#customer_rate_contract_table").dataTable().fnDestroy();
		}
		$.ajax({
				type: 'POST',
				async: true,
				url: 'rm-customerratecontractdata.php',
				dataType:'json',
				cache: true,
				data:{id_group:default_group,type:1,setcookie:1},
				beforeSend: function() {$(".ajaxLoaderModal").show();},
				success: function(data)
				{
    					$('#customer_rate_contract').removeClass('successSearch');
					$('#ratecontract_products').html('');
					$('.purchase_lists').html('');
					
 					for(var i=0; i<data.length; i++)
					{
  						var sno= i+1;
						var deleteoption="";
						if(data[i].deal_available)
						{
							dealavailable="*Deal";
						}
						else
							dealavailable=" ";
						
   						$('#ratecontract_products').append('<tr id="id_rate_contract_'+data[i].id_specific_price+'">\
 															<input type="hidden" value="'+sno+'" id="s_no_'+i+'" class="sNo"/>\
 															<td>'+sno+'</td>\
 															<td>'+data[i].reference+'</td>\
 															<td><a target="#">'+data[i].name+'</a></td>\
 															<td>'+parseFloat(data[i].sp_price).toFixed(2)+'<span class="txt-right">'+dealavailable+'</td>\
                                                            <td><span id="'+data[i].id_specific_price+'_to" class="ratecontract_date">'+data[i].to+'</span><span class="col-md-3" ><input type="text" id="'+data[i].id_specific_price+'_date" class="datepicker form-control"></span></td>\
                                                            <td>'+data[i].date_update+'</td>\
                                                            <td>'+data[i].available_regions+'</td>\
                                                            <td>'+data[i].product_status+'</td>\
 															<td class="contractListTd"><input type="hidden" id="delete_row_'+i+'"  value="'+i+'" />\
 															<span class="fa fa-trash-o cur-poi deleteRow" onClick="ExpireSpecificPrice('+data[i].id_product+','+default_group+','+i+')"></span>\
                                                            <span class="ratecontract_edit"><i aria-hidden="true" class="fa fa-edit cur-poi"></i></span>\
                                                            <span name='+data[i].id_specific_price+' class="ratecontract_save" ><i aria-hidden="true" class="fa fa-save cur-poi"></i></span>\
                                                            <span class="ratecontract_reply"><i aria-hidden="true" class="fa fa-reply cur-poi"></i></span>\
 															</td></tr>');

						$("#purchase_listname_"+sno+"").append('<option value="0">Select List</option>');
						
					 }	
					 var tempvalue=loadtablevalue+1;
					 loadtablevalue=tempvalue;
                     $('.datepicker').datepicker({
                          format: 'yyyy-mm-dd'
                     });
                    editableTable();
				},
				complete: function(){$(".ajaxLoaderModal").hide();}
				
		});
		$('span#listTitle').html(name.innerHTML);
		$('div#place-order').show();
	}
	
	else if(page==4)
	{
		$('#customer_create_purchase_list').removeClass('successSearch');
		$('#customer_view_purchase_list').removeClass('successSearch');
		
		var type = 1;
		var dataparam = '&id_customer=' + id_customer + '&type=' + type;
    			  $.ajax({
						type: 'POST',
 						async: true,
						dataType:'json',
						url: 'rm-purchaselist.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
							$('#purchase-list-name').html('');
							if(data==='')
							{
								$('#purchase-list-name').append('<tr><td>No Records Found</td></tr>');
							}
							else
							{
								for (var i = 0; data.length > i; i++)
								{
									$('#purchase-list-name').append('<tr id="pur_list_'+data[i].id_list+'">\
																		 <td>'+(i+1)+'</td>\
																		 <td><div class="list_name_'+data[i].id_list+'">'+data[i].listname+'</div></td>\
																		 <td>\
																			 <div class="col-md-3 labelSwitch">\
																			 	<input id="'+data[i].id_list+'" type="checkbox" name="my-checkbox" checked data-animated="false">\
																			 	<input id="hidden_'+data[i].id_list+'" type="hidden" value="'+data[i].list_active+'">\
																			 </div>\
																			 <button class="col-md-2 btn-round btn btn-primary pur-list-edit" title="Edit purchase list" onclick="changeListName('+data[i].id_list+',0,'+default_group+')"><i class="fa fa-edit">Edit List</i></button>\
																			 <input id="list_id_'+data[i].id_list+'" type="hidden" value="'+data[i].id_list+'">\
																			 <input id="list_name_'+data[i].id_list+'" type="hidden" value="'+data[i].listname+'">\
																			 <input id="customer_'+data[i].id_list+'" type="hidden" value="'+id_customer+'">\
																		</td>\
																	</tr>');
									if(data[i].list_active==0)
									{
										$("#"+data[i].id_list).bootstrapSwitch('toggleState');
									}
									
								}
							$('input[name="my-checkbox"]').bootstrapSwitch().on("switch-change", function() {
								changeStatus(this.id);
							});	
							$(".switch-right").html('Deactive');
							$(".switch-right").addClass("switch-danger labelSwitch");
							$(".switch-left").html('Active');
							$(".switch-left").addClass("switch-success labelSwitch");

						}
						
					}
				});
		//$('span#listTitle').html(name.innerHTML);
		$('div#place-order').show();
		$('#create_list_div').removeClass('errorSearch');
		$('#add_to_list_div').removeClass('errorSearch');
		$('#customerpurchaselist').focus();
	}
	else if(page==5)
	{
		$('#customer_view_payment_option').removeClass('successSearch');
		//$('#customer-payment-option-header').text(+"'s payment options");
		var type = 1;
		var dataparam = '&id_customer=' + id_customer + '&type=' + type;
    			  $.ajax({
						type: 'POST',
 						async: true,
						dataType:'json',
						url: 'rm-paymentoption.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
							var payment_option;
							$('#payment-option-list').html('');
							if(data==='')
							{
								$('#payment-option-list').append('<tr>No Records Found</tr>');
							}
							else
							{
								$('#payment-option-list').append('<tr><td>1</td><td>CASH ON DELIVERY</td><td><div class="col-md-3 labelSwitch"><input id="toggle_1" type="checkbox" name="my-checkbox" value="1"></div> </td></tr>\
                                        <tr><td>2</td><td>CHEQUE</td><td><div class="col-md-3 labelSwitch"><input id="toggle_2" type="checkbox" name="my-checkbox" value="2"></div></td></tr>\
                                        <tr><td>3</td><td>NEFT</td><td><div class="col-md-3 labelSwitch"><input id="toggle_3" type="checkbox" name="my-checkbox" value="3"></div></td></tr>\
                                        <tr><td>4</td><td>EBS</td><td><div class="col-md-3 labelSwitch"><input id="toggle_4" type="checkbox" name="my-checkbox" value="4"></div></td></tr>\
                                        <tr><td>5</td><td>PENDING FOR APPROVAL</td><td><div class="col-md-3 labelSwitch"><input id="toggle_5" type="checkbox" name="my-checkbox" value="5"></div></td></tr>\
                                        <tr><td>6</td><td>Credit</td><td><div class="col-md-3 labelSwitch"><input id="toggle_6" type="checkbox" name="my-checkbox" value="6"></div> </td></tr>\
                                        <tr><td>7</td><td>EPAYLATER</td><td><div class="col-md-3 labelSwitch"><input id="toggle_7" type="checkbox" name="my-checkbox" value="7"></div></td></tr>');
								for(var i=0;i<data.length;i++)
								{
									payment_option=data[i].id_payment;
									if(payment_option=="1")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
									else if(payment_option=="2")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
									else if(payment_option=="3")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
									else if(payment_option=="4")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
									else if(payment_option=="5")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
									else if(payment_option=="6")
									{
										$("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
									}
                                    else if(payment_option=="7")
                                    {
                                        $("#toggle_"+data[i].id_payment).bootstrapSwitch('toggleState');
                                    }
									
								}
								$('input[name="my-checkbox"]').bootstrapSwitch().on("switch-change", function() {
								changePaymentOption(this.id);
							});	
							$(".switch-right").html('Deactive');
							$(".switch-right").addClass("switch-danger labelSwitch");
							$(".switch-left").html('Active');
							$(".switch-left").addClass("switch-success labelSwitch");
							}
						}
				});
		$('span#listTitle').html(name.innerHTML);
		$('div#place-order').show();
		$('#create_list_div').removeClass('errorSearch');
		$('#add_to_list_div').removeClass('errorSearch');
	}
	else if(page==6)//To get purchase list of a customer 
	{
		$.ajax({
				type: 'POST',
				async: true,
				url: 'rm-setCustomerId.php',
				dataType:'json',
				cache: true,
				data:{
                    id_customer,
                    type:1,
                    id_employee
                },
				success: function(data)
				{
					defaultExecution();
					$('span#listTitle').html(name.innerHTML);
				}
				
		});
	}
	else if(page==7)
	{
		$('span#listTitle').html(name.innerHTML);
		customer_name=name.innerHTML;
		if(name.id==oldCustomer)
		{
			return false;
		}
		$('#deal-product').removeClass('successSearch');
		$('#customer_view_deal_list').removeClass('successSearch');
		$('#deal-product-not-found').hide();
		$('#deal-processing').hide();
		$.ajax({
				type: 'POST',
				async: true,
				url: 'rm-setCustomerId.php',
				dataType:'json',
				cache: true,
				data:{
                    id_customer,
                    type:1,
                    id_employee
                },
				success: function(data)
				{
				
				}
				
		});
		
		/*$('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });*/
		showDeal();
	}
	else if(page==8)
	{
		/*$('#orderHistory').removeClass('successSearch');
		$('span#listTitle').html(name.innerHTML);
		customer_name=name.innerHTML;
		ordering_type=3//represent the page type for the back purpose of steps
	 	var type=1;//(to get all orders for particular customer)
		var dataparam = '&id_customer=' + id_customer+'&type=' +type+'&id_employee='+id_employee;
		$("#customer_orders").dataTable().fnClearTable();
		$("#customer_orders").dataTable().fnDestroy();		
	  	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'dash-history.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
 					var pdf;
	 				for(var i=0; i<data.length; i++)
					{
						if(data[i].invoice_number == "0" ){
							pdf="<span style='margin-left:25px;'>&mdash;</span>";
						}
						else{
							pdf='<a href='+baseDir+'kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&submitAction=generateConsolidatedInvoicePDF&token='+data[i].token_pdf+''+data[i].orderids+'><span class="fa fa-download download"></span></a>';
						}
						if($.isNumeric(data[i].bill_age))		
						{
							if(data[i].bill_age>0)
								data[i].bill_age ="<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"<input id='order_id_"+data[i].id_order+"' type='hidden' value='"+data[i].credit_alert_date+"'></span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-primary' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
							else if(data[i].bill_age<=0)
								data[i].bill_age = "<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"<input id='order_id_"+data[i].id_order+"' type='hidden' value='"+data[i].credit_alert_date+"'></span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-danger' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
						}
						var fields = data[i].id_order+","+data[i].id_address_delivery+","+data[i].id_address_invoice;
						var date = data[i].added_date;
						var newdate = new Array();
						newdate = date.split("-");
					
						var monthname = newdate[1];
						
						
						
						$("#order_history").append("<tr><td>"+monthname+"</td><td><a data-toggle='modal' onclick='getStatusDetails("+fields+");' href='#status_history'>"+data[i].id_order+"</a></td><td><a onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+data[i].added_date+"</a></td><td><a  onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+parseFloat(data[i].total_paid).toFixed(2)+"</a></td><td>"+data[i].bill_age+"</td><td><a  onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+data[i].payment+"</a></td><td>"+data[i].order_state+"</td><td>"+pdf+"</td></tr>");
							if(i<10)
							$('#listOfOrders').append("<tr id='order-detail-"+data[i].id_order+"'class='cur-poi' onclick='getTrackOrderDetails("+fields+")'><td>"+monthname+"</td><td>"+data[i].id_order+"</td><td>"+data[i].added_date+"</td></tr>");
					}
					easySearch('customer_orders');//calling index.js easysearch();			
				}
		});
		$('#orderHistory').slimScroll({
			height:"450px",
			wheelStep: 1,
			railVisible: true,
			alwaysVisible: true
			});
		$('#history_popup').slimScroll({
			height:"600px",
			wheelStep: 1,
			railVisible: true,
			alwaysVisible: true
			});
		$('#timelinediv').slimScroll({
		height:"450px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});*/
	}
	else if(page==9)//Quotation part
	{
 		openQuoteList(0,0,default_group,0);
		
	}
	else if(page == 10)//Verify Customer
	{
		var type = 1;
		var req_type = 1;
		
		var dataparam = '&id_group='+default_group+'&type='+type+'&req_type='+req_type;
 		//( "cus-verification.php?ajax=true&req_type="+req_type+"&type="+type+"", function( response, status, xhr ) 
	  	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'cus-verification.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
   					if(data.length > 0 )
					{
 						$("#group-verification-table").removeClass('hidden');
						var status="";
						var document_doc ="";
						var document="";
						$("#id_group").html("");
						$("#customer_firstname").html("");
						$("#verification_status").html("");
						$("#verification_document").html("");
						$("#upload_document").html(""); 
						if(data[0].verification_status == 0)
						{
							status = "<span class=text-danger>Not Verified</span>";
							document_doc="<form enctype='multipart/form-data' id='submit-document-"+data[0].id_group+"' method='post' onsubmit='uploadGroupDocument("+data[0].id_group+"); return false;' ><input type='file' class='padding5' id='buyer-document-"+data[0].id_group+"' name='buyer-document-"+data[0].id_group+"' /><input type='hidden' id='id_customer_"+data[0].id_group+"' name='id_customer_"+data[0].id_group+"' value="+data[0].id_group+"><button title='Upload Document' type='submit' class='btn btn-success btn-round'><i class='fa fa-arrow-up'>Upload</i></button></form>";
						}
						else
						{
							status = "<span class=text-success>Verified</span>";
							document_doc = "<span>Verified</span>";
						}
						if(data[0].verification_document == 0 || data[0].verification_document== null)
							document = "<span>Not Available</span>";
						else
						{					
							var doc_name=  data[0].name;
							var doc_name= doc_name.toLowerCase();
							var doc = data[0].verification_document;
							var doc_result = doc.split(".");
							var doc_exe = doc_result[1];
							document = "<a href='Buyer_Verification_Document/"+data[0].id_group+"-"+doc_name+"."+doc_exe+"' download></i><span>"+doc_name+"."+doc_exe+"	</span>&nbsp;(<i class='fa fa-download download-group-document'>)</a>";
						}		
								
						 $("#id_group").html(data[0].id_group);
						 $("#customer_firstname").html(data[0].name);
						 $("#verification_status").html(status);
						 $("#verification_document").html(document);
						 $("#upload_document").html(document_doc);
					}
					else
						$("#group-verification-table").addClass("hidden");
				}
		});
	}
	else if(page == 11)
	{
		
 		var request_type = 1;
		//var req_type = 1;
 		var dataparam = '&id_group='+default_group+'&request_type='+request_type;
 		//( "cus-verification.php?ajax=true&req_type="+req_type+"&type="+type+"", function( response, status, xhr ) 
	  	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-customer-configure.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
   					$('#group_address').remove();
   					$('#address-table').append('<tbody id="group_address"></tbody>');
					
 					$("#address-table").dataTable().fnDestroy();
 					for(var i=0; i<data[0].length;i++) {
						$('#customer_selection').append('<option value="'+data[0][i].id_customer+'~'+data[0][i].default_group+'~'+data[0][i].name+'">' + data[0][i].name + ' &nbsp;[' + data[0][i].email + '] </option>');
                    }
 					
					for(var i=0; i<data[1].length;i++)
					{
						var address = data[1][i].cus_company+"</br>"+data[1][i].alias+"</br>"+data[1][i].poc_add1+"</br>"+data[1][i].city+","+data[1][i].state+","+data[1][i].postcode;
						var edit = " <button class='btn btn-primary disabled' onclick='editAddress("+data[1][i].address_id+")'><i class='fa fa-edit'></i>Edit</button>";
						var address_delete="<button class='btn btn-warning disabled' onclick='deleteAddress("+data[1][i].address_id+","+data[1][i].id_customer+")'><i class='fa fa-trash-o'></i> Delete</button>";
						
						var sno = i+1;

						$('#group_address').append('<tr id="tr_'+data[1][i].address_id+'"><td>'+sno+'</td><td id="address_'+data[1][i].address_id+'">'+address+'</td><td id="contact_'+data[1][i].address_id+'">'+data[1][i].poc_person+'</td><td id="mobile_'+data[1][i].address_id+'">'+data[1][i].poc_mobile+'</td><td>'+edit+'</td><td>'+address_delete+'</td><td class="assignaddress"><div class="col-md-3 labelSwitch bottonToggle"><input class="activate_address" id="'+data[1][i].address_id+'" type="checkbox" name="my-checkbox" value="0"></div></td></tr>');	  
					} 
					
                    $(".has-switch").bootstrapSwitch('setState',false);
					
					$('input[name="my-checkbox"]').bootstrapSwitch().on("switch-change", function() 
					{
						
						if(loading==1)
					{ 
						assignAddressToUser(id_customer,this.id,$(this).val());
						loading=0;
					}
						
					});
 							
					$(".switch-right").html('Deactive');
					$(".switch-right").addClass("switch-danger labelSwitch");
					$(".switch-left").html('Active');
					$(".switch-left").addClass("switch-success labelSwitch");
					$(".bottonToggle").hide();
					easySearch('address-table');
 				}
		});
		
	}
	else if(page == 12)
	{
		
		if(id_customer == 0)
		{ 
			$("#group_address button").addClass("disabled");
			$("#creat_address_button").addClass("disabled");
			$(".bottonToggle").hide();
 			}
		else
		{
			$("#group_address button").removeClass("disabled");
			$("#creat_address_button").removeClass("disabled");
			$(".bottonToggle").show();
		}
 		 
		$('.has-switch div').each(function(){
			$(this).removeClass('switch-on');
			$(this).addClass('switch-off');
			//$('.has-switch input').val("0");
			$(this).find('input').val(0);
		});
  		var request_type = 3;
 		var dataparam = '&id_customer='+id_customer+'&request_type='+request_type;
 	  	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-customer-configure.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
  					if(data)
					{
  						for(var i=0; i<data.length; i++)
						{
							$("#"+data[i].id_address).val(1);
   							$("#"+data[i].id_address).bootstrapSwitch('setState',true);
						}
						
		 
 					}
						
				},
				complete: function(){loading = 1}
				 
		});

		}
	

		
}
function orderCredit(order_id,credit_day)
{
	$('#orderCredit').modal('show');
	$("#hiddenOrderId").val(order_id);	
	$("#creditDaysNumber").val(credit_day);
	$("#creditAvailable").html(credit_day);
	$("#externId").html(order_id);
	$("#creditRemaining").html($("#creditDays_"+order_id).text());
	
	if($('#order_id_'+order_id).val()> '0000-00-00 00:00:00')
	{
		$("#lastCreditAlert").show();
		$("#alertDate").html($('#order_id_'+order_id).val());
	}
	else
	{
		$("#lastCreditAlert").hide();
	}
	
	
}
function sendCreditAlert()
{
	var order_id=$("#hiddenOrderId").val();	
	$('#orderCredit').modal('hide');
	var dataparam="&order_id="+order_id+"&type=2";
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-credit.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{					
					toast("Credit alert E-mail sent","success");					
				}
			});
}
function changeCreditDays()
{
	var days=$("#creditDaysNumber").val();
	var order_id=$("#hiddenOrderId").val();	
	var dataparam="&days="+days+"&order_id="+order_id+"&type=1";
	$('#orderCredit').modal('hide');
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-credit.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
					selectCustomer(id_customer,8,1,2);					
					toast("credit days changed","success");					
				}
			});

}
function initEditableTable()
{ 
	editableTable();
}
function showDeal()
{
	
	//$('#editable-sample').dataTable().fnDestroy();
	//$('#editable-sample').dataTable().fnClearTable();	
	$("#deal_heading").html("EXISTING DEALS");
	var dataparam='&type=2&id_customer='+id_customer;
		 $.ajax({      
			      type: 'POST',
			      dataType: 'json',
			      async: true,
			      url: 'rm-deal.php', //
			      data: dataparam,
			      cache: true,
			      success: function(data) 
			      {
			        $("#deal-list").html('');
			        if(data.length>0)
			        {
			        	var price;
			        	var d = new Date();
    					var strDate = d.getFullYear() + "-" + ((d.getMonth()+1)<10 ? '0'+(d.getMonth()+1):''+(d.getMonth()+1) )+ "-" + ((d.getDate())<10 ? '0'+(d.getDate()):''+(d.getDate()) )+" "+ d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
			        	for(var i=0;i<data.length;i++)
			        	{
							var reduction;
							var active='';
							var mrp_price= parseFloat(data[i].orginalMrp).toFixed(2);
				        	if(mrp_price =="")
				        	{
				        		mrp_price="-";
				        	}
				        	if(data[i].reduction_type=='amount')
				        	{
				        		reduction=parseFloat(data[i].reduction).toFixed(2);
				        		price=parseFloat(mrp_price-reduction).toFixed(2);
				        	}
				        	else if(data[i].reduction_type=='percentage')
				        	{
				        		reduction=parseFloat(data[i].reduction*100);
				        		reduction_price=((mrp_price*reduction)/100).toFixed(2);
				        		price=parseFloat(mrp_price-reduction_price).toFixed(2);
				        	}

				        	if(data[i].to<strDate && data[i].active==1)
				        	{
				        		active="<label class='actionBtn expired'>Expired</label>";	
				        	}
				        	else if(data[i].active==1)
				        	{
				        		active="<label class='actionBtn btn btn-primary'>Activated</label>";
				        	}
				        	else
				        	{
				        		active="<label class='actionBtn btn btn-danger'>Deactivated</label>";
				        	}
				        	if(data[i].reduction_type=='percentage')
				        		var selectOption="<select id='selectOption"+data[i].id_product+"' class='noBorder' disabled><option name='percentage' value='percentage' selected>percentage</option><option name='amount' value='amount'>amount</option></select>";
				        	else
				        		var selectOption="<select id='selectOption"+data[i].id_product+"' class='noBorder' disabled><option name='percentage' value='percentage' >percentage</option><option name='amount' value='amount' selected>amount</option></select>";

							$("#deal-list").append("<tr id='row_"+data[i].id_product+"' class='row_"+i+"' value='"+data[i].id_specific_price+"'><td class='deal-products-row-no'>"+(i+1)+"</td><td class='sorting_1 dealId' value='"+data[i].id_deal+"'>"+data[i]['name'][1]+"</td><td>"+mrp_price+"</td><td>"+price+"</td><td><input id='reduction_"+data[i].id_product+"' value="+reduction+" class='noBorder' disabled></td><td>"+selectOption+"</td><td><input id='from_"+data[i].id_product+"' class='noBorder datepickerNew' value="+data[i].from+" disabled></td><td><input id='to_"+data[i].id_product+"' class='noBorder datepickerNew' value="+data[i].to+" disabled></td><td><a id='editRow_"+data[i].id_product+"' onClick='editRow("+data[i].id_product+");' class='edit' href='javascript:;'>Edit</a></td><td><a class='delete' id='activeOrDeactive_"+data[i].id_product+"' onClick='activeDeactive("+data[i].id_product+");' href='javascript:;'>"+active+"</a></td></tr>");
			        	}
			        	if(window.count==0)
			        		initEditableTable();
			        }
			        else
			        {
			        	if(window.count==0)
			        		initEditableTable();
			        }
			        window.count++;		        
			      }
			    });

}

function makeDeal()
{
	/*$('#editable-sample').dataTable().fnClearTable();
	$('#editable-sample').dataTable().fnDestroy();*/
  var id_product=$("#hidden_id").val();
  var sprice=$("#deal-price").val();
  var from=$("#deal-from-date").val();
  var to=$("#deal-to-date").val();
  var reduction = (parseFloat)($('#sp_reduction').val());
  if(!reduction)
  {
  	reduction=0.00;
  }
  var reduction_type = !reduction ? 'amount' : $('#sp_reduction_type').val(); 

  if(!reduction || reduction<0 ||(reduction_type=='percentage' && reduction>=100) || (reduction_type=='amount' && reduction>=sprice))
  {
  	toast("check price and discount values","warning");
  	return;
  }

  if(!id_product)
  {
    alert("Kindly Set Product");
    showDeal();
    return ;
  }
  else if(!from && !to)
  {
    alert("Kindly Check date");
    showDeal();
    return ;
  }
  else if(from > to)
  {
    alert("check from and to dates ");
    showDeal();
    return ;
  }
  from =from+" 00:00:00";
  to =to+" 23:59:59";

    var type = 1;
    var dataparam = '&type='+type+'&id_product='+id_product+'&sprice='+sprice+'&from='+from+'&to='+to+'&reduction='+reduction+'&reduction_type='+reduction_type+'&id_customer='+id_customer+ '&id_employee=' + id_employee;

    $.ajax({
      
      type: 'POST',
      dataType: 'json',
      async: true,
      url: 'rm-deal.php', //
      data: dataparam,
      cache: true,
      success: function(data) 
      {
        
         $("#hidden_id").val();
		  $("#deal-price").val('');
		  $("#deal-from-date").val('');
		  $("#deal-to-date").val('');
		  $('#sp_reduction').val('0.00');
		  $('#sp_reduction_type').val('');
		  $('#dealInput').val('');
		  $('.actual-deal-price').val('');
		  
		  if(data=="2")
		  	toast("Product already available in existing deal","warning");
		  else
		  	toast("Deal Created Successfully","success");

		  showDeal();
      }
    });
    
}
function toHideEmptyResult()
{

	$("#deal-product-not-found").hide();	
}
function searchRateContract(){
	$("#focusedInput").unbind();
	var url = "dash-quickbuysearch.php?auto=2&id_customer=";
	bindAutoComplete(url, id_customer);
	$("#rateContractSearchButton").addClass('kob_button_white');
	$("#catalogueSearchButton,#addNewProductButton").removeClass('kob_button_white').addClass('kob_button');
}

function searchEntireCatalogue()
{
	autoCompSearch("#focusedInput","rm_cat_search");
	$("#catalogueSearchButton").addClass('kob_button_white');
	$("#addNewProductButton,#rateContractSearchButton").removeClass('kob_button_white').addClass('kob_button');
}

function addNewProductFromSearch(){
	

		$.ajax({
				type: 'POST',
				async: true,
				url: 'rm-setCustomerId.php',
				dataType:'json',
				cache: true,
				data:{
                    id_customer,
                    type:1,
                    id_employee
                },
				success: function(data)
				{
				}
		});
	$("#addNewProductButton").addClass('kob_button_white');
	$("#rateContractSearchButton,#catalogueSearchButton").removeClass('kob_button_white').addClass('kob_button');
	$('#addNewProductFromSearch').modal('show');
	$('#createNewProdEx')[0].reset();
	
		//Add Purchase List Names to Create New Product Express Form
		var dataparam = '&id_customer=' + id_customer+'&api=2&type=3';
		
		$.ajax({
				
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'dash-PurchaseList.php',
				data: dataparam,
				cache: true,
				
				success: function(data)
				{
					$('#purlist').html("");
					$('#purlist').append('<option value="0">SelectList</option>');
			
					for(var i=0; data.length > i; i++)
					{ 
						
						$("#purlist").append('<option value='+data[i].id_list+'>'+data[i].listname+'</option>');
					}	
					purList = 1;
				}
				
		});

		var dataparam = '&type=29';
		$.ajax(
		{
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'scn-quotation-ajax.php',
			cache: true,
			data: dataparam,
			success: function(result)
			{ 
				var result = result.reverse();
				$('#id_tax_rules_group').html('');
				for(var i = 0; i< result.length; i++){
					$('#id_tax_rules_group').append('<option value='+result[i].id_tax_rules_group+'>'+result[i].name+'</option>');
				}
			}
		});

	
}

 
function getCustomer(view_page)
{
	var id_group = $('#group_selection').val();

    if(id_group == null || id_group == 0)
    {
        id_group = $('#group_selection2').val();
    }

    if(view_page == 12)
    {
        id_group = $('#group_selection_4').val();   
    }

	var type = 1;

	var dataparam = '&id_group='+id_group+'&type='+type;
	
	//Loading alert
	$("#customer_selection option[value='0']").html("Loading users");
	
	$.ajax({
			type: 'POST',
			async: true,
			url: 'rm-getCustomerListData.php',
			dataType:'json',
			cache: false,
			data: dataparam,
			success: function(data)
			{
 				$('#customer_selection').html('');
				$('#select2-customer_selection-container').html('Select User');

				if(view_page == 11)
					$('#address-table').dataTable().fnDestroy();

   				if(view_page != 0 && view_page != 12)
				{
 					$('#customer_selection ').append('<option>Select User</option>');
					selectCustomer(0,view_page,0,id_group,null);
				}
                else if(view_page == 12)
                {
                    $('#edit_customer_selection').html('');

                    for(var i = 0; i < data.length; i++)
                    {
                        if(i == 0)
                            $('#edit_customer_selection ').append('<option>Select User</option>');

                        $('#edit_customer_selection').append('<option value="'+data[i].id_customer+'~'+data[i].default_group+'~'+data[i].name+'">' + data[i].name + ' &nbsp;[' + data[i].email + '] &nbsp;[' + data[i].role + ']</option>');
                    }

                    if(data.length == 0)
                    {
                        $("#noUsers").removeClass("hidden");
                    }
                    else if(!$("#noUsers").hasClass("hidden"))
                    {
                        $("#noUsers").addClass("hidden");
                    }
                }
				else
				{
 					$('#customer_selection').html('');

  					for(var i = 0; i < data.length; i++) {
						if(i == 0)
 							$('#customer_selection ').append('<option>Select User</option>');

						$('#customer_selection').append('<option value="'+data[i].id_customer+'~'+data[i].default_group+'~'+data[i].name+'">' + data[i].name + ' &nbsp;[' + data[i].email + '] &nbsp;[' + data[i].role + ']</option>');
					}
				}
			}
	});
}

function calcPriceTE(){
	
	var noTax;
	if($('#id_tax_rules_group option:selected').val() == 0)
		noTax = 1;
	else
		noTax = 0;
		
	var priceTI = parseFloat(document.getElementById('priceTI').value.replace(/,/g, '.'));
	
	if(noTax){
		document.getElementById('priceTE').value =	priceTI;
		return 0;
	}
	else{
		var tax = $('#id_tax_rules_group option:selected').text();
 		tax = tax.split('(');
		tax = tax[1].split('-');
		tax = parseFloat(tax[1]);
		var newPrice = priceTI / ((tax / 100) + 1);
		document.getElementById('priceTE').value =	(isNaN(newPrice) == true || newPrice < 0) ? '' : newPrice.toFixed(6);
	}
}


function bindAutoComplete(url, id_customer){
	$("#dash-corporate-user-add-to-cart").unbind();
	$("#focusedInput").autocomplete(url+id_customer,
	{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;},
			
		parse: function(data){
 			return false;
 			if(data=="")
			{
				$("#quickbuy-processing").hide();	
				$("#quickbuy-product-not-found").show();	
				return data;
			}
			else{
				$("quickbuy-product-not-found").hide();	
				var mytab = new Array();
 				for(var i = 0; i < data.length; i++)
					mytab[mytab.length] = { data: data[i].id_product+"~" +data[i].name+"~" +data[i][1].toFixed(2)+"~" +data[i].link, value:"<div><span  id='search_image'>"+"<img class='dummy' src="+data[i][0]+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].name+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs."+(data[i][1]).toFixed(2)+"</span></div>"};
				
				return mytab;
			}
		},
	}).result(
	function(event, data, formatted, value) {
		var separate=data.split("~");
		product={productLink:separate[3],productname:separate[1],idProduct:separate[0],id_product_attribute:separate[2], quantity:$("#dash-corporate-user-quantity-value").val(),price:(product.quantity*product.id_product_attribute)};
 		//*product={productLink:separate[3],productname:separate[1],idProduct:separate[0]/*,id_product_price:separate[2]*/,quantity:$("#dash-corporate-user-quantity-value").val(),price:separate[2]};*/
	$('#focusedInput').val(product.productname);
 		idProduct=separate[0];
	
		toChangeFocus();
		
		$("#quickbuy-product-not-found").hide();	
		//$("#dash-corporate-user-add-to-cart").unbind();
	});	
	
	$("#dash-corporate-user-add-to-cart").click(function() {
		var quickbuy = $("#focusedInput").val();

		if(quickbuy == "")
		{
			alert("Please select the product.");
			return false;
		}

 		if($("#dash-corporate-user-quantity-value").val()<1)
		{
			$('#minimumquantity').modal('show');
		}
 		else
		{	
			var type = 7;
			var quick_qty = $("#dash-corporate-user-quantity-value").val();
			var dataparam = '&quick_idProduct='+idProduct+'&quick_qty='+quick_qty+'&type='+type;

 			$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url:'dash-PurchaseList.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				 $('#listoferrors').html('');
 					 if(data.msg != "success")
					 {
						$('#listoferrors').append("<tr><td>"+data.name+"</td><td>"+data.msg+"</td></tr>");
						$('#error_cart').modal('show');
					 }
					 else
					 {
 						loadShopingCart();
						if ($('#container').hasClass('open-right-panel')) {
						}
						else
						{	
							$('.toggle-right-box .fa-shopping-cart').click();
						}
					 }
				/*loadShopingCart() in dash-index.js*/
 				$("#focusedInput").val("");
				$("#dash-corporate-user-quantity-value").val(1);
				$("#focusedInput").focus();
				$("#focusedInput").select();
				  idProduct="";
 				
			}
		});
		}
	});
}
/*To get all the order durations for a particular RM */
$(document).ready(function()
{
	var dataparam = '&type=6';
	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			$('#id-fc-rm').html('');
			$('#id-fc-rm').append('<option value="0">Select Fulfillment Center</option>');
			for(var i = 0; i < data.length; i++){
				$('#id-fc-rm').append('<option value="'+data[i].id_fulfillment_centre+'">'+data[i].city_name+'</option>');
			}
		}
	});

	var customer_name='';	
	getCustomerOrders(0);
  	setInterval(function(){ getCustomerOrders(1); }, 300000);
});

/*get the orders and its details using  duration and status*/
function openCustmomerDetails(duration,order_status)
{
	var type=2;
	var id_fc = $('#id-fc-rm').val();  	
	var dataparam = '&id_employee=' + id_employee+'&type=' + type+'&order_status=' + order_status+'&duration=' + duration +'&id_fc='+id_fc;
	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			if(data !="")
			{
				$("#status_orders").html('');

				$("#modal-heading").html('<h5>Orders in <b>'+data[0][0].name+'</b> Status</h5>');

				for(var i=0; i<data[0].length; i++)
				{
				  $("#status_orders").append("<tr><td><a target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[0][i].orderid+"&vieworder&token="+data[1]+"'>"+data[0][i].orderid+"</a></td><td>"+data[0][i].firstname+"</td><td>"+data[0][i].total_paid+"</td><td>"+data[0][i].name+"</td><td>"+data[0][i].DATE_ADD+"</td></tr>");
				}
			}
			else
			{
				$("#modal-heading").html('No Orders to Show');
				$("#status_orders").html('');
			}
			$('#rm_customer_order').modal('show');
		}
		
	});
}

function toChangeFocus()
{
 	$("#dash-corporate-user-quantity-value").focus();
	$("#dash-corporate-user-quantity-value").select();
	
}
function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 190) || (key == 110) || (key == 9) || (key == 110) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}
function loadShopingCart()
{
	var type=0;
	var dataparam = '&type=' + type;
 	$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			global:false,
			data : dataparam,
			dataType : "json",
 			success: function(jsonData)
			{
 				if ($('#container').hasClass('open-right-panel')) {}
    			shopingcart = jsonData.length;
 				$("#total_cart_products").html(shopingcart);
 				$("#shopping_shipping_rm").html("");
				$("#shopping_tax_rm").html("");
				$(".shopping_Total").html("");
 				//$('#cart-products-list-body').html('');
				$("#rm_shopping_cart").html('');
				$('#shopping_detail_rm').hide();
				for(var i=0;i<jsonData.length;i++)
				{
 					var product_name = jsonData[i].name;
					if(product_name.length > 15) product_name = product_name.substring(0,15)+"...";
					$("#rm_shopping_cart").append("<tr class='rmshoppingCartTr' id='rmshoppingCartRow_"+jsonData[i].id_product+"'><td>"+product_name+"</td><td><input type='text' value='"+jsonData[i].quantity+"' maxlength='5' size='3' class='productquantity tex-ali-cen qv_quantity_wanted_rm' onchange='forChangeInQuantityCart("+jsonData[i].id_product+","+jsonData[i].total+","+jsonData[i].minimal_quantity+");' onkeydown='numbersOnly(event)' id='qty_"+jsonData[i].id_product+"'></td><td id='price_"+jsonData[i].id_product+"'>Rs."+jsonData[i].total+"</td><td><span class='fa fa-times cur-poi' onclick='toRemoveShoppingCartProduct(" + jsonData[i].id_product + "," + (jsonData[i].id_product_attribute ? jsonData[i].id_product_attribute : null) + ",null," + jsonData[i].id_product + ")'></span></td></tr>");
					
				}
            		if(jsonData !="")
            		{
						
						loyalty_points = jsonData[0][6];
				
						$("#shopping_loyalty_points_rm").html(jsonData[0][6]);
						$("#shopping_shipping_rm").html(jsonData[0][2]);
						$("#shopping_tax_rm").html(jsonData[0][4]);
						$(".shopping_Total").html(jsonData[0][3]);
						$(".cart_total_rm").html($('.rmshoppingCartTr').index()+1);
	                	$('#shopping_detail_rm').show();
                    }
                    else{
                    	$('#rm_shopping_cart').html('');
                    	$('#rm_shopping_cart').html('<tr><th></th></tr><tr><th></th><td><center style="color:#dc2d3c">No Products in cart.</center></td></tr>').css({'font-size':'12px','border':'none'});
	                    $('#rm_shopping_cart th,#rm_shopping_cart td').css({'border':'none'});
	                    $('.shoppingCartList tr th').css({'text-align':'center'});
	                    $('#shopping_detail_rm').hide();
                    }
				}
				
			});
}
function toRemoveShoppingCartProduct(id_product,id_combination,id_customization,id)
{
  	var rm_cart_count = $('.rmshoppingCartTr').index()+1;
    if(rm_cart_count > 1){
    	$("#rmshoppingCartRow_" + id).remove(); 
    }
	 else { 
    	$('.shoppingcart').click();
    }
	
 		$.ajax({
			type: 'POST',
			url: 'cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data: 'delete=1&id_product=' + id_product + '&ipa=' + ((id_combination != null && parseInt(id_combination)) ? id_combination : '') + ((id_customization && id_customization != null) ? '&id_customization=' + id_customization : '') + '&token=' + static_token + '&ajax=true',
			success: function(jsonData)	
			{
				if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc') {
					deletProductFromSummary(idProduct+'_'+idCombination);
                }

				loadShopingCart();
			},
			error: function() {alert('ERROR: unable to delete the product');}
		});
}

function checkOutProcess()
{
 	if(shopingcart==0)
	{
 		var alertmsg = "No Products in Cart";
		$("#idGlobalAlert").html(alertmsg);
		$('#globalAlert').modal('show');
		return false;
 	}
	else
	{	
		$("a[href$='#next']").click();
		$('.actions').hide();
		if($("#wizard-t-1").parent().hasClass('current'))
		{
			$("#next_button").hide();
			
		}
		
        $('#wizard-t-1').click(function(){
				$('#next_button').hide();
		});
		$("#wizard-t-0").click(function()
		{
			if($("#wizard-t-0").parent().hasClass('current'))
			{
		 		$("#next_button").show();
		  	}
			$('#main-content').addClass('panel-open');
			//$('.toggle-right-box .fa-shopping-cart').click();
			$('#container').addClass('open-right-panel');
			$('.right-sidebar').addClass('open-right-bar');
			$('.header').addClass('merge-header');
			$('#main-content').removeClass('merge-left');
			$("#total_cart_products").show();			
			$("#next_buton").show();
		});
	}
}

function next()
{
 	var tr = new Array();
	$('.rmshoppingCartTr').each(function ()
	 {
			 tr.push(this.id);
	 } );
 	if(tr !="")
	{
		
  		$("a[href$='#next']").click();
		
	}
 	else
	{
		var alertmsg = "No Products in Cart";
		$("#idGlobalAlert").html(alertmsg);
		$('#globalAlert').modal('show');
		return false;
	}
}
function openShoppingCart(page)
{
	if(page==0)
	{
		if ($('#container').hasClass('open-right-panel')) {
		}
		else
		{	
			$('.toggle-right-box .fa-shopping-cart').click();
		}
	}
	if(page==1)
	{
		if ($('#container').hasClass('open-right-panel')) 
		{
                $('#container').removeClass('open-right-panel');
				$('.right-sidebar').removeClass('open-right-bar');
				$('.header').removeClass('merge-header');
				$("#total_cart_products").hide();
        }
		else
		{
			 $('#container').addClass('open-right-panel');
			$('.right-sidebar').addClass('open-right-bar');
			$('.header').addClass('merge-header');
			$('#main-content').removeClass('merge-left');
			$("#total_cart_products").show();
		} 
		
		if ($('#sidebar').hasClass('hide-left-bar'))  
			$('#sidebar').removeClass('hide-left-bar');
			 
	}
}
 
function getCustomerOrders(id)
{
	var current_time = new Date();
  	var hours = new Date().getHours();
    var hours = (hours+24)%24; 
    var mid='am';
    if(hours==0) //At 00 hours we need to show 12 am
    	hours=12;
    else if(hours>12)
	{
		hours=hours%12;
		mid='pm';
    }
 	$('#refreshtiming').html(hours + ":" + current_time.getMinutes() + ":" + current_time.getSeconds()+ "  "  + mid);
	
 	var type=1;
	
	/*if(id==1)
	{
		$.ajaxSetup({
 			global: false,
 		});
	}
	else
	{
		$.ajaxSetup({
 			global: true,
 		});
	}*/
	var id_fc = $('#id-fc-rm').val();  	
   	var dataparam = '&id_employee=' + id_employee+'&type=' + type +'&id_fc='+id_fc;

   	$.ajax({
			type: 'GET',
			dataType:'json',
            global: false,
			async: true,
			url: 'rm-indexdata.php',
 			data: dataparam,
			cache: true,
 			success: function(data)
			{
				var order_status_var = '';
				$('#order-state-rm,#order-state-scn,#order-state-finance,#order-state-tech,#order-state-other').html('');

				for(var i = 0; i < data[1].length; i++)
				{
					$('.state_in_'+data[1][i].id_order_state+'_24').html('');
					$('.state_in_'+data[1][i].id_order_state+'_48').html('');
					$('.state_in_'+data[1][i].id_order_state+'_72').html('');
					
					if(data[1][i].id_profile == 5)
						order_status_var = "order-state-rm";
					else if(data[1][i].id_profile == 6)
						order_status_var = "order-state-scn";
					else if(data[1][i].id_profile == 11)
						order_status_var = "order-state-finance";
					else if(data[1][i].id_profile == 13)
						order_status_var = "order-state-tech";
					else if(data[1][i].id_profile == 14)
						order_status_var = "order-state-other";

					$('#'+order_status_var+'').append('<tr id="order_state_'+data[1][i].id_order_state+'">\
									                    <td class="tex-ali-cen">'+data[1][i].name+'</td>\
									                    <td class="success"><div class="padding5 state_in_'+data[1][i].id_order_state+'_24"></div></td>\
									                    <td class="warning"><div class="padding5 state_in_'+data[1][i].id_order_state+'_48"></div></td>\
									                    <td class="danger"><div class="padding5 state_in_'+data[1][i].id_order_state+'_72"></div></td>\
									                  </tr>');
				}

				for(var i = 0; i < data[0].length; i++){
					if(data[0][i].id_order_state){
						if(data[0][i].hours == 24){
							$('.state_in_'+data[0][i].id_order_state+'_24').html('');
							$('.state_in_'+data[0][i].id_order_state+'_24').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+')"><span>'+data[0][i].totalorder+'</span></div>');
						}
							else if(data[0][i].hours == 48){
								$('.state_in_'+data[0][i].id_order_state+'_48').html('');
								$('.state_in_'+data[0][i].id_order_state+'_48').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+')"><span>'+data[0][i].totalorder+'</span></div>');
							}
								else if(data[0][i].hours == 72){
									$('.state_in_'+data[0][i].id_order_state+'_72').html('');
									$('.state_in_'+data[0][i].id_order_state+'_72').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+')"><span>'+data[0][i].totalorder+'</span></div>');
								}
					}
				}
			}
	});
}


$('.toggle-right-box .fa-shopping-cart').click(function()
	{
		$('#top-corporuser-info').removeClass("open");
		$('#main-content').toggleClass('panel-open');
	});

/*Customer rateContract products*/
function openCustomerList() {
	$('#index_viewport').html('');
	$('#index_viewport').load('rm-customerratecontract.php', { smarty: true });	
}
 
/*Delete product from ratecontract*/
/*function openDeleteModal(id_rate_contract,id_pur_list,active,row,id_product,id_customer)
{
	$("#delete_product").html('');
	
	$("#delete_product").append("<div class='row'><div class='col-md-1'></div><input class='btn btn-primary col-md-10' type='button' id='delete_ratecontract_product' name='delete_ratecontract_product_"+id_rate_contract+"' value='Delete Product from RateContract ' onclick='delteProduct("+id_rate_contract+",0,"+row+","+id_product+","+id_customer+");' /></div><br/> <div class='row'><div class='col-md-1'></div><input class='btn btn-primary col-md-10' type='button' id='delete_purchaselist_product_"+id_rate_contract+"' name='delete_purchaselist_product' value='Delete Product from purchase list ' onclick='delteProduct("+id_rate_contract+","+id_pur_list+");' /></div>");
	
	$('#deletecontractproduct').modal('show');
	
	var deletebutton= $("#listname_"+id_rate_contract+"_"+id_pur_list).text();
	if(deletebutton=="---")
		$('#delete_purchaselist_product_'+id_rate_contract).addClass('disabled');
}*/
 function changeStatus(id_pur_list)
 {
 	var status_new=$('#hidden_'+id_pur_list).val();
 	if(status_new>0)
 	{
 		status_new=0;
 		$("#hidden_"+id_pur_list).val(0);	
 	}
 	else
 	{
 		status_new=1;
 		$("#hidden_"+id_pur_list).val(1);	
 	}
 	var type=2;
 	var dataparam ='&id_pur_list='+id_pur_list+'&status='+status_new+'&type='+type;
 	$.ajax({
 		type: 'POST',
 		async: true,
 		dataType:'json',
 		url: 'rm-purchaselist.php',
 		data: dataparam,
 		cache: true,
 		success: function(data)
 		{
 			return true;
		}
 	});
 }
 
/*function delteProduct(id_rate_contract,id_pur_list,i,id_product,id_customer)
{
	var row=$("#s_no_"+id_rate_contract).val()-1;
    $.ajax({
			type: 'POST',
			//dataType:'json',
			async: true,
			url: 'rm-customerratecontractdata.php',
 			data: {id_rate_contract:id_rate_contract,type:2,id_pur_list:id_pur_list,id_product:id_product,id_customer:id_customer},
			cache: true,
 			success: function(data)
			{
 				$('#deletecontractproduct').modal('hide');
				if(data == 1)
				{
 					$('#listname_'+id_rate_contract+"_"+id_pur_list).html('---');
					toast("Product Deleted successfully from Purchaselist","success");
				}
				else if(data == 2)
				{
					var i=0;
					$('.contractListTd input').each(function(){
						$(this).val(i);
 						i++;
					});
					var j=0;
					$('.sNo').each(function(){
 						$(this).val(j);
						j++;
					});
					
					
					//selectCustomer(id_customer,2,1);
					toast("Product Deleted successfully from Rate Contract","success");
					$("#customer_rate_contract_table").dataTable().fnDeleteRow( row );
				}
			}
	});
}*/
function ExpireSpecificPrice(id_product,default_group,sno)
{
	var row=$("#s_no_"+sno).val()-1;
	$.ajax({
			type: 'POST',
			//dataType:'json',
			async: true,
			url: 'rm-customerratecontractdata.php',
 			data: {type:2,id_product:id_product,id_group:default_group},
			cache: true,
 			success: function(data)
			{
  				if(data==404)
				{
					toast("This Product already exist in deal.so it will be shown untill the deal ends","warning");
					//selectCustomer(id_customer,2,1);
				}
				else(data == 1)
				{
					toast("Product Deleted Successfully","success");
					//selectCustomer(id_customer,2,1);
					$("#customer_rate_contract_table").dataTable().fnDeleteRow( row );
				}	
				
			}
			
		});
}
function editableTable()
{		
				var oTable = $('#customer_rate_contract_table').dataTable({
					"aLengthMenu": [
						/*[25, 50, 100, -1],
						[25, 50, 100, "All"]*/ // change per page values here
						[10, 50, 100, -1],
						[10, 50, 100, "All"]
					],
					// set the initial value
					"iDisplayLength": 10,
					
					
					"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_ records per page",
						"oPaginate": {
							"sPrevious": "Prev",
							"sNext": "Next"
						}
					},			
	
					"aoColumnDefs": [{
							'bSortable': true,
							'aTargets': [0]
						}
					]
				});
				 }
function submitMyAddress()//to get the new user address
	{
 		var alias=$('#alias').val();
		var firstname = $('#firstname').val();
		var address1 = $('#address1').val();
		var postcode = ($('#postcode').val()).replace(/ +/g, "");
		var city = $('#city').val();
		var state = $('#state').val();
		var country = $('#country').val();
		var company = $('#company').val();
		var phone_mobile = $('#phone_mobile').val();
		var error=0;
		if(alias =="")  
		{
			$('#alias').val('');
			$('#alias').attr("placeholder",'please Enter Address Alias');
 			error=1;
 		}
		if(firstname =="")  
		{
			$('#firstname').val('');
			$('#firstname').attr("placeholder",'please Enter name');
 			error=1;
 		}
		if(address1 =="")  
		{
			$('#address1').val('');
			$('#address1').attr("placeholder",'please Enter Current Address');
 			error=1;
 		}
		if(postcode =="")  
		{
			$('#postcode').val('');
			$('#postcode').attr("placeholder",'please Enter Pincode');
 			error=1;
 		}
		if(city =="")  
		{
			$('#city').val('');
			$('#city').attr("placeholder",'please Enter City');
 			error=1;
 		}
		if(state ==0)  
		{
			$('#state_error').text('');
			$('#state_error').text('Please select state');
            $('#state_error').show();
            
 			error=1;
 		}
		
		if(company =="")  
		{
			$('#company').val('');
			$('#company').attr("placeholder",'please Enter Company Name');
 			error=1;
 		}
		if(phone_mobile =="")  
		{
			$('#phone_mobile').val('');
			$('#phone_mobile').attr("placeholder",'please Enter Mobile Number');
 			error=1;
 		}
		if(isNaN(phone_mobile))
		{
			$('#phone_mobile').val('');
			$('#phone_mobile').attr("placeholder",'please Enter  Number Only');
 			error=1;
		}
		if(phone_mobile.length  < 10)
		{
			$('#phone_mobile').val('');
			$('#phone_mobile').attr("placeholder",'please Enter 10 digit valid mobile Number');
 			error=1;
		}
		if(postcode.length < 6)
		{
			$('#postcode').val('');
			$('#postcode').attr("placeholder",'please Enter  6 digit valid Pincode');
 			error=1;
		}
		if(isNaN(postcode))
		{
			$('#postcode').val('');
			$('#postcode').attr("placeholder",'please Enter  Number Only');
 			error=1;
		}
		if(error!=0)
		{
  			return false;
		}
		else
		{
		var type = 6;
 		
 		var dataparam ='&alias=' + alias+'&firstname=' + firstname+'&address1=' + address1+'&postcode=' + postcode+'&city=' + city+'&state=' + state+'&id_country=' + country+'&company=' + company+'&type=' + type+'&mobile=' + phone_mobile;
   			  $.ajax({
						type: 'POST',
 						async: true,
						url: 'dash-address.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
							if(data==1)
							{
								$('.myAddress').val('');
								$("#state").val(0);
								$('#myaddress').modal('hide');
								toast("Address Added Successfully","success");
							
								$("#index_viewport").load("rm-place-order-steps.php", function() {
								
									$("a[href$='#next']").click();
									
										$('#wizard-p-0').load('rm/rm-placeorder.tpl');
										
								});
							}
						}
			  });
	}
}
	$(document).ready(function() {
        var type = 7;
 		var dataparam ='&type='+type;
    			  $.ajax({
						type: 'POST',
 						async: true,
						dataType:'json',
						url: 'dash-address.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
 							for(var i=0; i<data.length; i++)
								$('#state').append('<option value='+data[i].id_state+'>'+data[i].name+'</option>');
						}
		
			 	   });
    });

function addProducts()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('rm/rm-addproduct.tpl');
	
}
function openCustomerPurchaseList()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('rm-customerpurchaselist.php', { data: 'rm/rm-customerpurchaselist.tpl' } );		
}
function openCustomerDeals()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('rm-customerlist.php', { data: 'rm/rm-customerlist.tpl' } );		
}
function openCatalog()
{
    $('#index_viewport').html('');
    $('#index_viewport').load('rm-catalog.php', { data: 'rm/rm-catalogDetails.tpl' } );      
}
function openCustomerPaymentOption()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('rm-customerpaymentoption.php', { data: 'rm/rm-customerpaymentoption.tpl' } );		
}
function createpurchaselist()
{
	if(!($('#customerpurchaselist').val()))
	{
		$('#customerpurchaselist').attr('placeholder',"Enter Purchase List Name");
	}
	else
	{
		var list_name=$('#customerpurchaselist').val();
		var type=4;
		var dataparam ='&id_customer='+id_customer+'&list_name='+list_name+'&type='+type;
    			  $.ajax({
						type: 'POST',
 						async: true,
						dataType:'json',
						url: 'rm-purchaselist.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
 							toast("Purchase List Name Added","success");
							$('#customerpurchaselist').val(" ");
							selectCustomer(id_customer,4,1);
						}
		
			 	   });
	}
}
function changePaymentOption(id_payment_option)
{
	var payment_option=$('#'+id_payment_option).val();
	var type=2;
	var dataparam = '&id_customer=' + id_customer + '&type=' + type +'&payment_option=' + payment_option;
    			  $.ajax({
						type: 'POST',
 						async: true,
						url: 'rm-paymentoption.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
							
						}
					});
 }
 function forChangeInQuantityCart(productId,price,minimal_quantity)
{
        var type=8;

        var productarray = new Array();
            var productQty=$("#qty_"+productId).val();
            
    if(productQty < minimal_quantity)
    {
            var alertmsg = "Please enter quantity of "+minimal_quantity+" or above.";
            var minimum_quantity = "(Reason : Minimum quantity limit is "+minimal_quantity+")";
            $("#idGlobalAlert").html("<center>"+alertmsg+"<br>"+minimum_quantity+"</center>");
            $('#globalAlert').modal('show');
            $('#rmshoppingCartRow_'+productId+' '+'.qv_quantity_wanted_rm').val(minimal_quantity);
            productQty=$("#qty_"+productId).val();
            $('#price_'+productId).html('Rs.00.00');
            }
productarray.push(productId+"-"+productQty);
if(productarray=="")
    {   
    $('#noproduct').modal('show');
        return false;
    }
    var dataparam = '&productarray='+productarray+'&type='+type;
        $.ajax({
            type: 'POST',
            dataType:'json',
            async: true,
            url:'dash-shopping-cart.php',
            data: dataparam,
            cache: false,
            success: function(data)
            {
                
                toUpdatePriceRM(productId);
            }
    });
    $("#qty_"+productId).val(productQty);   
}
function openVoucher()
{
	$('#voucher').modal('show');
	
}
function addDiscount(id,pagetype,name)
{	
	if(pagetype==1)
	{
 		var vouchername= $('#name_vouchercode').val();
 		if(vouchername=="")
		{
			$("#globalAlert").modal('show');
			$("#idGlobalAlert").html("Please Enter Voucher Code");
			return false;
		}
		
	}
	else
	{
 		 		var vouchername = name;
	}
	
	var type=2;
	var dataparam= '&type='+type+'&id_discount='+id+'&discount_name='+vouchername;
     	$.ajax({
			type: 'POST',
			url: 'dash-shopping-cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data:dataparam,
 			success: function(data)
			{
 				if(data[0] == "success")
				{
 					$('#voucher').modal('hide');
					toast("Voucher Added to cart successfully!.","success");
 					//
					$("#delete_"+id).show();
					$("#add_discount_"+id).hide();
					if(data[2] != false)
					{
						var checkdiscount = new Array();
						$('.discountClass').each(function ()
						 {	
 								checkdiscount.push(this.id);
						 });
 						 var discountpresent= $.inArray(data[2],checkdiscount);
 						 if (discountpresent == -1) 
						{
							
 							$("#vouchercode").append("<tr class='discountClass' id='"+data[2]+"'><td id='vocher_name_"+data[2]+"'>"+data[1]+"</td><td>---</td><td><span id='add_discount_"+data[2]+"' class='btn btn-success btn-xs' style='display:none;' onclick='addDiscount("+data[2]+",0);'>Apply</span><span id='delete_"+data[2]+"'  class='btn btn-danger btn-xs btn-xs' onclick='deleteDiscount("+data[2]+");'>Cancel</span></td></tr>");
						 }
						 else
						 {
							 if($("#wizard-t-2").parent().hasClass('current'))
							 {
								 loadViewContent(1);
							 }
 							 else
								 
								 loadShopingCart();
							 $("#delete_"+data[2]).show();
							$("#add_discount_"+data[2]).hide();
						 }
						 
					}
					
				}
				else
				{
 					$('#voucher').modal('hide');
					$("#globalAlert").modal('show');
					$("#idGlobalAlert").html(data);
 					return false;
				}
 			}
	});
}
function deleteDiscount(id)
{
 	$("#delete_"+id).hide();
	$("#add_discount_"+id).show();
 	var type=3;
	var dataparam= '&type='+type+'&id_discount='+id;
    	$.ajax({
			type: 'POST',
			url: 'dash-shopping-cart.php',
			async: true,
			cache: false,
			//dataType : "json",
			data:dataparam,
 			success: function(data)
			{
				
 				//loadViewContent(1);
				if($("#wizard-t-2").parent().hasClass('current'))			 
					{
								 
							loadViewContent(1);
					}
				else
					loadShopingCart();
 			}
	});
}

function loadVoucherCode(discountids)
{
	if(discountids != 0)
		var discountids = discountids;
 	var type=1;
	var dataparam= '&type='+type;
   	$.ajax({
			type: 'POST',
			url: 'dash-shopping-cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data:dataparam,
 			success: function(data)
			{
				 
   				$("#vouchercode").html('');
 				var discount=[];
  				for(var i=0; i<data[0].length; i++)
				{
  					var name= data[0][i].name;
 					$("#vouchercode").append("<tr class='discountClass' id='"+data[0][i].id_discount+"'><td id='vocher_name_"+data[0][i].id_discount+"'>"+data[0][i].name+"</td><td>"+data[0][i].description+"</td><td><span id='add_discount_"+data[0][i].id_discount+"' class='btn btn-success btn-xs' onclick='addDiscount("+data[0][i].id_discount+",0,\""+name+"\");'>Apply</span><span id='delete_"+data[0][i].id_discount+"' style='display:none;' class='btn btn-danger btn-xs btn-xs' onclick='deleteDiscount("+data[0][i].id_discount+");'>Cancel</span></td></tr>");
					discount.push(data[0][i].id_discount);
 				}
				
				for(var i=0; i<data[1].length; i++)
				{	
					if ($.inArray(data[1][i].id_discount, discount) < 0) 
					{
						var name= data[1][i].name;
						$("#vouchercode").append("<tr class='discountClass' id='"+data[1][i].id_discount+"'><td id='vocher_name_"+data[1][i].id_discount+"'>"+data[1][i].name+"</td><td>"+data[1][i].description+"</td><td><span id='add_discount_"+data[1][i].id_discount+"' class='btn btn-success btn-xs' onclick='addDiscount("+data[1][i].id_discount+",0,\""+name+"\");'>Apply</span><span id='delete_"+data[1][i].id_discount+"' style='display:none;' class='btn btn-danger btn-xs btn-xs' onclick='deleteDiscount("+data[1][i].id_discount+");'>Cancel</span></td></tr>");
					}
 				}
				 if(discountids !=0)
				 {
					for(var k=0; k<discountids.length; k++)
					{
						$("#delete_"+discountids[k]).show();
						$("#add_discount_"+discountids[k]).hide();
					}
				 }
					$('#show_voucher_count').html('');
					$('#show_voucher_count').append("Vouchers: " +data[0].length);
				 
			}
	});
}
/*Customer Reports */
function reports(id) 
{
	 if(id != 5)
	 {
		 $('#report_type').val(id);
		 $('#index_viewport').load('dash/dash-reports.tpl');
	 }
	 else
	 {	 
		 $('#index_viewport').html('');
		$('#index_viewport').load('rm/rm-customer-reports.tpl');
	 }
}

function cancelSelection(){
    $('.cancel-selection').click();
}

function cartClear(order_id){
    var type=1;
    var dataparam= '&type='+type;
    $.ajax({
            type: 'POST',
            url: 'getcartproduct.php',
            async: true,
            cache: false,
            /*dataType : "json",*/
            data:dataparam,
            success: function(data)
            {
               if($("#wizard-t-1").parent().hasClass('current'))
				{
					$("#wizard-t-0").click();
				}
				
                $('.cancel-selection').click();
                loadShopingCart();
                $('.shoppingcart').click();
               
            }
        });
}

function easySearchQuotation(table_id)
{   
    if(table_id == "address-table")
        var limit = 100;
    else
        var limit = 10;
    var oTable = $('#'+table_id).dataTable({
        "aLengthMenu": [
            /*[25, 50, 100, -1],
            [25, 50, 100, "All"]*/ // change per page values here
            [10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        "bRetrieve": true,
        "bDestroy": true,
        
        // set the initial value
        "iDisplayLength": limit,
        
        "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },          

        "aoColumnDefs": [{
                'bSortable': true,
                'aTargets': []
            }
        ],
        "aaSorting": [[0, "desc"]]
    });             
}

function easySearch(table_id)
{	
	if(table_id == "address-table")
		var limit = 100;
	else
		var limit = 10;

	var oTable = $('#'+table_id).dataTable({
		"aLengthMenu": [
			/*[25, 50, 100, -1],
			[25, 50, 100, "All"]*/ // change per page values here
			[10, 50, 100, -1],
			[10, 50, 100, "All"]
		],
		"bRetrieve": true,
		"bDestroy": true,
        
		// set the initial value
		"iDisplayLength": limit,
		
		"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page",
			"oPaginate": {
				"sPrevious": "Prev",
				"sNext": "Next"
			}
		},			

		"aoColumnDefs": [{
				'bSortable': true,
				'aTargets': []
			}
		],
		"aaSorting": []
	});
				 
}

function openQuoteList(types,id_quotation,id_group,id_state) {
	var type,dataparam;
	if(types == 0) {
	
	type = 3;
	dataparam = '&type=' + type + '&id_employee=' + id_employee+ '&id_group=' + id_group+ '&id_state=' + id_state;
	}
	else if(types == 1){
	type = 4;
	dataparam = '&type=' + type + '&id_quotation=' + id_quotation+ '&id_state=' + id_state;
	$('#view-block-download-div-rm').empty();
	$('#view-block-download-div-rm').append('<button type="button" class="btn btn-primary publish-btn-rm" id="publish-block-rm" onclick="publishQuotation(2,'+ id_quotation +')">\
											 Publish&nbsp;&nbsp;<i class="fa fa-edit"></i></button>\
											<button type="button" onclick="downloadQuotation(' + id_quotation + ',' + id_state + ')" style="float:right;" class="btn btn-success" id="view-block-download-div-rm">\
											<i class="fa fa-download"></i>&nbsp;&nbsp;Download</button>');
	}
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			if(types == 0)
			{
				$("#quote-rm").removeClass("hidden");
 				$('#quotation_history_rm').html('');
				if(data != "" || data != undefined || data != null)
				{
					for (var i = 0; i < data.length; i++)
					{
						if(data[i].rm_published == 1) 
                        {
                            $('#quotation_history_rm').append("<tr>\
                                        <td>" + data[i].id_quotation + "</td>\
                                        <td>" + data[i].firstname + "</td>\
                                        <td id='quote_name_" + data[i].id_quotation + "'>" + data[i].quote_name + "</td>\
                                        <td>" + data[i].quote_version + "</td>\
                                        <td>"+ data[i].id_employee + "</td>\
                                        <td>" + data[i].date_generated + "</td>\
                                        <td>\
                                            <span onclick='downloadQuotation(" + data[i].id_quotation + "," + data[i].id_state + ")' class='cur-poi padding5'>\
                                                <i title='Download'  class='fa fa-download   text-success' style='width:12px;'></i></span>&nbsp;&nbsp;&nbsp;\
                                                <a href='#viewQuoteProductsRm' data-toggle='modal' onclick='openQuoteList(1," + data[i].id_quotation + ",0," + data[i].id_state + ")'>\
                                                    <span class='cur-poi padding5'>\
                                                    <i title='View' class='fa fa-eye text-info'></i>  </span>\
                                                </a>\
                                                <span class='text-danger padding5'>Published</span>\
                                        </td>\
                                        </tr>");
                        }
                        else 
                        {
                            $('#quotation_history_rm').append("<tr>\
                                        <td>" + data[i].id_quotation + "</td>\
                                        <td>" + data[i].firstname + "</td>\
                                        <td id='quote_name_" + data[i].id_quotation + "'>" + data[i].quote_name + "</td>\
                                        <td>" + data[i].quote_version + "</td>\
                                        <td>"+ data[i].id_employee + "</td>\
                                        <td>" + data[i].date_generated + "</td>\
                                        <td>\
                                            <span onclick='downloadQuotation(" + data[i].id_quotation + "," + data[i].id_state + ")' class='cur-poi padding5'>\
                                                <i title='Download'  class='fa fa-download   text-success' style='width:12px;'></i></span>&nbsp;&nbsp;&nbsp;\
                                                <a href='#viewQuoteProductsRm' data-toggle='modal' onclick='openQuoteList(1," + data[i].id_quotation + ",0," + data[i].id_state + ")'>\
                                                    <span class='cur-poi padding5'>\
                                                    <i title='View' class='fa fa-eye text-info'></i>  </span>\
                                                </a>\
                                            &nbsp;&nbsp;&nbsp;<a href='#publishQuoteConfirmation' data-toggle='modal' onclick='publishQuotation(0," + data[i].id_quotation + ")'><span class='cur-poi padding5'><i  title='Publish' class='fa fa-upload text-warning'></i></span></a>\
                                        </td>\
                                        </tr>");
                        }
					}
				}
				easySearchQuotation('id_quotation_history_rm');
			}
			else{
				$('#quotation_history_view_rm').html('');
 				for (var i = 0; i < data[0].length; i++)
				{
 					if (data[0][i].product_code != null)
					{
						if (data[0][i].product_name.length > 15) data[0][i].product_name = data[0][i].product_name.substring(0, 23) + "...";
						$('#quotation_history_view_rm').append("<tr><td class='col-xs-4'>" + data[0][i].product_name + "</td><td class='col-xs-3'>" + data[0][i].product_code + "</td><td class='col-xs-2'>" + data[1][i][0].tax_rate + " %</td><td class='col-xs-3'>" + parseFloat(data[0][i].price).toFixed(2) + "</td><td class='product-id-hide' style='display:none;'>" + data[0][i].product_id + "</td></tr>");
					}
				}
			}
		}
	});
}

function downloadQuotation(quote_id,id_state)
{
	var type = 5;
	var dataparam = '&type='+type+'&id_quotation='+quote_id+'&id_state='+id_state;
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			$('#quotation-history-hidden-data-rm').empty();
			$('#quotation-history-hidden-data-rm').append('<input id=quote-excel-' + quote_id + ' type="text" name="id-quotation" value=' + quote_id + '><input id=quote-excel-' + quote_id + ' type="text" name="id_address" value=' + data + '>');
			$('#form_quotation_excel_rm').submit();
		}
	});
}

function toUpdatePriceRM(productId)
{
 	$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			success: function(jsonData)
				{
   					if(jsonData=="")
					{
						var alertmsg = "Your cart is empty, Redirecting to home page";
						$("#id_alert").html(alertmsg);
						$('#alert_msg').modal('show');
						setTimeout(function(){
							location.reload();//when the cart is empty the page is redirected to index page
						},500);
						
						//$("#cart-product-price").html("<div class='priceincart'><span class='price-margin-right' ><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> Rs.0 </span></div><br/><div class='priceincart'><span  class='price-margin-right' ><i class='fa fa-money total-money'></i>Total :</span><div class='price-font'> Rs.0</div></div>");
					}
					else
					{
					for(var i=0;i<jsonData.length;i++)
					{

						if(jsonData[i].id_product==productId)
						{	
							$("#price_"+productId).html("Rs. "+jsonData[i].total);
						}
					}
					var discountids= [];
					if(jsonData[0][5] !="")
					{
						var discountValue =0;
						for (var j=0; j<jsonData[0][5].length; j++)
						{
							
							discountValue += parseFloat(jsonData[0][5][j].value);
							discountids.push(jsonData[0][5][j].id_discount);
							
						}
					}
					else
					{
						var discountValue=0;
					}
					
					$('#discount').html(discountValue.toFixed(2));
					loyalty_points = jsonData[0][6];
					$('#shopping-cost').html('Rs 0.00');
					$('#tax').html(jsonData[0][4]);
					$('#loyalty_points_summary').html(jsonData[0][6]);
					$('#loyalty_points').html(jsonData[0][6]);
					$('#total-shopping-cost').html(jsonData[0][3]);
					$(".shopping_Total").html(jsonData[0][3]);
					$("#shopping_loyalty_points_rm").html(jsonData[0][6]);
					$('#uploadFile').hide();
					$("#points_display").append(jsonData[0][6]);
 				}
				loadShopingCart();
 				}
	});


}
function EBS()
{
	$('#hidden-info').load('dash-EBS.php' );
	
}

function publishQuotation(action_type,id_quotation){
	if(action_type == 0){
		$('.quote-confirm-footer').html('');
		$('.quote-confirm-footer').append('<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="Cancel"/>');
		$('.quote-confirm-footer').append('<input type="button" name="trigger" onclick="publishQuotation(1,'+id_quotation+')" class="btn btn-primary" value="Continue"/>');
	}
	else if(action_type == 2){
		$('.quote-confirm-footer').html('');
		$('.quote-confirm-footer').append('<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="Cancel"/>');
		$('.quote-confirm-footer').append('<input type="button" name="trigger" onclick="publishQuotation(1,'+id_quotation+')" class="btn btn-primary" value="Continue"/>');
		$('#viewQuoteProductsRm').modal('hide');
		$('#publishQuoteConfirmation').modal('show');
	}
	else{
	$('.rm-quote-publish-loader').show();
	var type = 5;
	var dataparam = '&type=' + type + '&id_quotation=' + id_quotation+ '&id_group=' + global_default_group;
	$('#globalAlert').hide();
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-publish-quotation.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			if(data == 2){
				$('.rm-quote-publish-loader').hide();
				$('#publishQuoteConfirmation').modal('hide');
				$('#publishFailedGroup').modal('show');
			}
			else{
				if(data != 1){
                openQuoteList(0,0,global_default_group,0);
				$('.rate-contract,.specific-update,.specific-add').html('');

				if(data.rate_contract == 0)
					data.rate_contract = "No Changes in Rate Contract";
				else
					data.rate_contract = " Number of products<span style='font-weight:bold;color:#40a412;'> added in Rate Contract</span>: <span style='font-weight:bold;color:#656565;'> "+data.rate_contract+"</span>";

				if(data.specific_update == 0)
					data.specific_update = "No Changes in Specific Price Updation";
				else
					data.specific_update = " Number of products<span style='font-weight:bold;color:#e8853e;'> price updated in Specific Price</span>: <span style='font-weight:bold;color:#656565;'>"+data.specific_update+"</span>";

				if(data.specific_add == 0)
					data.specific_add = "No Changes in adding Specific Price";
				else
					data.specific_add = " Number of products <span style='font-weight:bold;color:#4898e9;'> price added in Specific Price</span>: <span style='font-weight:bold;color:#656565;'>"+data.specific_add+"</span>";

				$('.rate-contract').append('<div>'+data.rate_contract+'</div>');
				$('.specific-update').append('<div>'+data.specific_update+'</div>');
				$('.specific-add').html('<div>'+data.specific_add+'</div>');

				$('.rm-quote-publish-loader').hide();
				$('#publishQuoteConfirmation').modal('hide');
				$('#publish-quote-success').modal('show');

				}
				else{
					$('.rm-quote-publish-loader').hide();
					$('#publishQuoteConfirmation').modal('hide');
					$('#publishFailed').modal('show');
				}
			}
		}
	});
}
}

function loadPurListId(id)
{
	$('#id_pur_'+id+'').val($('#purchase_listname_'+id+'').val());
}


function cusVerification(type)
{
	$('#index_viewport').html('');
	$( "#index_viewport" ).load( "rm/rm-cus-verification.tpl") 
}

function groupVerification(type,req_type)
{
	$('#index_viewport').html('');
	$( "#index_viewport" ).load( "rm/rm-group-verification.tpl"); 
}

function cusConfigure(type)
{
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("rm-customer-configure.php?ajax=true&type="+type+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});

}
function setselectCustomer(view_page)
{
	if(view_page == 12)
		loading = 0;

    var id_customer_details = $('#customer_selection').val();

	if(view_page != 11 )
	{
		var id_customer = id_customer_details.split('~');
		var customer_id = id_customer[0];
		var customer_group_id = id_customer[1];
		$('.date-range-block').show();
		selectCustomer(customer_id,view_page,0,customer_group_id,id_customer[2]);
	}
	else
	{
		selectCustomer(id_customer_details,view_page,0,0,0);
	}
	
	
}
function editCusAccount()
{
    var exp = new RegExp('[a-zA-Z]*');
    var id_customer = $('#edit_customer_selection option:selected').val();
    var firstName = $('#customer-edit-form #firstName').val();
    var lastName = $('#customer-edit-form #lastName').val();
    var email = $('#customer-edit-form #emailId').val();
    var mobile = $('#customer-edit-form #mobileNum').val();

    if(!firstName.match(/^[a-zA-Z0-9\s]+$/))
    {
        toast("invalid first name","warning");
        return false;
    }

    if(!lastName.match(/^[a-zA-Z0-9\s]+$/))
    {
        toast("invalid last name","warning");
        return false;
    }

    if(!validate_isEmail(email)) {
        toast("Invalid email Id", "error");
        return false;
    }

    if(mobile.length < 10) {
        toast("Mobile number should have minimum of 10 numbers", "error");
        return false;
    }

    dataparam = '&request_type=9 &id_customer='+id_customer+' &firstname='+firstName+'&lastName='+lastName+'&email='+email+'&mobile='+mobile;
    $.ajax({
        type: 'POST',
        dataType:'json',
        async: true,
        url: 'rm-customer-configure.php',
        data: dataparam,
        cache: true,
        success: function(data)
        {
            if(data == 0)
            {
                toast("successfully Updated","success");
            }
            else
            {
                toast("Error in updation","warning");   
            }
            $('#customer-edit-form #firstName').val('');
            $('#customer-edit-form #lastName').val('');
            $('#customer-edit-form #emailId').val('');
            $('#customer-edit-form #mobileNum').val('');
            $('#group_selection3').val('0');
            $('#edit_customer_selection').val('0');
            $('#editCustomer').modal('hide');
        }
    });
}
function setCustomerDetails()
{
    var id_customer = $('#edit_customer_selection option:selected').val();
    dataparam = '&request_type=8&id_customer='+id_customer;
    $.ajax({
        type: 'POST',
        dataType:'json',
        async: true,
        url: 'rm-customer-configure.php',
        data: dataparam,
        cache: true,
        success: function(data)
        {
            $('#customer-edit-form #firstName').val(data[0]);
            $('#customer-edit-form #lastName').val(data[1]);
            $('#customer-edit-form #emailId').val(data[2]);
            $('#customer-edit-form #mobileNum').val(data[3]);
            var emp_id = id_customer.split("`");
            $('#customer-edit-form #employee_id').val(emp_id[0]);

        }
    });
}

function getGroups(page)
{
	$.ajax({
			type: 'POST',
			async: true,
			url: 'rm-getCustomerList.php',
			dataType:'json',
			cache: true,
			
			success: function(data)
			{
  				for(var i=0; data.length > i; i++)
				{
					if(page!=99){
						$("#group_selection").append('<option value="'+data[i].id_group+'">' + data[i].name + '</option>');
					}
					else if($('.group_selection3').find())
					{
						$(".group_selection3").append('<option value="'+data[i].id_group+'">' + data[i].name + '</option>');
					}
					else{
						$("#group_selection2").append('<option value="'+data[i].id_group+'">' + data[i].name + '</option>');
				}
 				}
			}
	});
}
function getCustomerReports()
{
	var d = new Date();
	var month = new Array();
	month[0] = "Jan";
	month[1] = "Feb";
	month[2] = "Mar";
	month[3] = "Apr";
	month[4] = "May";
	month[5] = "Jun";
	month[6] = "Jul";
	month[7] = "Aug";
	month[8] = "Sep";
	month[9] = "Oct";
	month[10] = "Nov";
	month[11] = "Dec";
	var n = month[d.getMonth()];
	
	var type = 7;
	var dataparam = '&type=' + type + '&id_employee=' + id_employee;
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			
			var order_current_month = month[d.getMonth()];
			var order_last_month ;
			var order_last_before_month ;
			
			$("#month_3").html(month[d.getMonth()]);
			 
 			if(month[d.getMonth()] == "Jan")
			{
				$("#month_2").html(month[11]);
				order_last_month = 12;
				order_last_before_month=11;
				$("#month_1").html(month[10]);
				
			}
			else if(month[d.getMonth()] == "Feb")
			{
				$("#month_2").html(month[0]);
				$("#month_1").html(month[11]);
				order_last_month = 1;
				order_last_before_month=12;
			}
 			else
			{
				$("#month_2").html(month[d.getMonth()-1]);
				$("#month_1").html(month[d.getMonth()-2]);
				order_last_month = month[d.getMonth()-1];
				order_last_before_month=month[d.getMonth()-2];
			}
			 
			
			for(var i=0; i<data.length; i++)
			{
				
				if(data[i].last_before_month > 0)
 					var last_before_month = "<span  class='cur-poi' onClick='getCustomerDetailMonthView("+(order_last_before_month)+","+data[i].id_default_group+")'>"+data[i].last_before_month+"</span>";
 				else
 					var last_before_month = "<span >"+data[i].last_before_month+"</span>";
				
 				if(data[i].last_month > 0)
				{
					var view_last_month_bill = "<span class='cur-poi' onClick='getCustomerDetailMonthView("+(order_last_month)+","+data[i].id_default_group+")'>"+data[i].last_month+"</span>";
				}
				else
				{
					var view_last_month_bill = "<span >"+data[i].last_month+"</span>";
				}
				
				if(data[i].current_month > 0)
				{
					var view_current_month_bill = "<span  class='cur-poi' onClick='getCustomerDetailMonthView("+(d.getMonth()+1)+","+data[i].id_default_group+");'>"+data[i].current_month+"</span>";
				}
				else
				{
					var view_current_month_bill = "<span >"+data[i].current_month+"</span>";
				}
				
 				$("#order_history_month_view").append("<tr><td >"+data[i].company+"</td><td align='right'>Rs. "+last_before_month+"</td><td align='right'>Rs. "+view_last_month_bill+"</td><td align='right'>Rs. "+view_current_month_bill+"</td></tr>");
			}
		}
	});
}

function assignAddressToUser(id_customer,id_address,address_val)
{
 	var type = 8;
	var action = $("#"+id_address).val();
	var dataparam = '&type=' + type + '&id_customer=' + id_customer+ '&id_address=' + id_address+ '&action=' + action;
 	
	$(".ajaxLoaderModal").show();
   	$.ajax(
	{
		type: 'POST',
 		async: true,
		url: 'rm-indexdata.php',
		data: dataparam,
		cache: true,
		global:false,
        beforeSend: function() {$(".ajaxLoaderModal").show();},
 		success: function(data)
		{
 			if(data == "1")
			{
				$("#"+id_address).val(1);
 			}
			else
			{
				$("#"+id_address).val(0);
 			}
			loading = 1;
 			
  		}
	});
    $(".ajaxLoaderModal").hide();
}
function getCustomerDetailMonthView(request_detail_month,id_default_group)
{
	$("#id_group").val(id_default_group);
	$("#request_detail_month").val(request_detail_month);
	$("#id_employee").val(id_employee);
	$("#customer_detail_bill").submit();
}

//param1: type,param2: page,param3:order_per_page,param4: Tabs,param5: orderBy,param6: orderWay
function openOrders(type, page, order_per_page, tab, orderBy, orderWay, filter_type)
{

    $('#sidebar').addClass('hide-left-bar');
    $('#main-content').addClass('merge-left');
    
    var dataparam,jump_page = "", per_page = "", id_order = "", cus_name = "",grp_name = "", id_buyer = "", order_state = "", order_total = "", payment_type = "", order_status = "", fc = "", orderDateFrom = "", orderDateTo = "";

    jump_page = $('.scn-order-jump-page').val();
    per_page = $('.scn-order-per-page').val();
    id_order = $('#idOrder').val();
    cus_name = encodeURIComponent($('#customerName').val());
    grp_name = encodeURIComponent($('#companyName').val());
    id_buyer = $('#idBuyer').val();
    order_state = $('#idState').val();
    order_total = $('#orderTotal').val();
    payment_type = $('#paymentType').val();
    order_status = $('#idOrderState').val();
    fc = $('#idFc').val();
    orderDateFrom = $('#order-date-from').val();
    orderDateTo = $('#order-date-to').val();

    if(filter_type == 1)
        dataparam = "smarty=1&type="+type+"&page="+page+"&order_per_page="+order_per_page+"&tab="+tab+"&order_by="+orderBy+"&order_way="+orderWay+"&order_per_page="+per_page+"&jump_page="+jump_page+"&id_order="+id_order+"&cus_name="+cus_name+"&grp_name="+grp_name+"&id_buyer="+id_buyer+"&state="+order_state+"&status="+order_status+"&total="+order_total+"&payment="+payment_type+"&fc="+fc+"&from_date="+orderDateFrom+"&to_date="+orderDateTo+"";
    else
        dataparam = "smarty=1&type="+type+"&page="+page+"&order_per_page="+order_per_page+"&tab="+tab+"&order_by="+orderBy+"&order_way="+orderWay+"";

    $('#index_viewport').html('');
    $(".ajaxLoaderModal").show();
    $("#index_viewport").load("scn-orders.php?"+dataparam+"",function( response, status, xhr ) 
                                    {
                                      $(".ajaxLoaderModal").hide();
                                    });
}

function openQuote() {
    $('#index_viewport').html('');
    $('#index_viewport').load('rm/rm-quotation.tpl');
}

function openQuoteModule() {
    $('.sidebar-toggle-box .fa-bars').click();
    $('#index_viewport').html('');
    $("#index_viewport").load("rm/rm-quotations.tpl");
}