// JavaScript Document
/*diasble back button*/
window.rm_portal=0;
window.hide_address_value=0;
window.ordering_type=0;//represent the page type => 0->no backpage 1->purchase list 2->quickbuy
window.po_file_elite;
window.po_file_value_elite;
window.shopingcart = 0;
window.creater_order_approver=0;
window.creater_order_no=0;
var searchquery="";
$(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip(); 

    /*$(".wdgt-row,.childDiv").click(function(){
        dataparam='&customer_id='+id_customer;
        $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-festive.php',
        data: dataparam,
        cache: true,
        success: function(data) 
        {
             $(".festival_banner").fadeOut("slow");
             $("#success_alert").fadeIn("slow");
             $("#success_alert_span").html("<strong>Thank you</strong> Our Relationship Manager will contact you shortly");
             setTimeout(function(){ $("#success_alert").fadeOut("slow"); }, 2500);
        }
        });
    });*/
    
    $("#kob_festiv_cross").click(function(){
         $(".festival_banner").fadeOut("slow");
    });
    var list='';

    if(!id_state_vat)
    {
        dataparam='&type=3';
        $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'B2cState.php',
        data: dataparam,
        cache: true,
        success: function(data)
        {
            if(!data[1])
            {
                $("#stateName").html(data[0].name);
            }
            else
            {
                $(".modalPopLite-mask_class").css('display','block');
                $(".modalPopLite-wrapper_class").css('display','block');
                list+="<select id='selectStateOption'><option value='' >Select State</option>";
                for(var i=0;i<data.length;i++)
                {
                    if(data[i].id_state==id_state_vat)
                    {
                        list+="<option value="+data[i].id_state+" selected>"+data[i].name+"</option>";
                    }
                    else
                    {
                        list+="<option value="+data[i].id_state+">"+data[i].name+"</option>";
                    }
                }
                list+="</select>";
                $("#selectstate").html(list);
                $('#popup-analytics-new #cancel_qutoes').hide();
            }

        }

        });
    }
    else if(id_state_vat)
    {
        $(".modalPopLite-mask_class").css('display','none');
        $(".modalPopLite-wrapper_class").css('display','none');
    }

    $('.rating .star').click(function () {
        $('.rating .star').removeClass('activerate');
        $(this).nextAll('.star').addBack().addClass('activerate');
    });
});


function setState()
{
    var stateId=$("#selectStateOption option:selected").val();
    var stateName=$("#selectStateOption option:selected").text();

    if(!stateId)
    {
        return false;
    }
    $(".modalPopLite-mask_class").css('display','none');
    $(".modalPopLite-wrapper_class").css('display','none');
    dataparam='&type=2&set=1&stateId='+stateId+'&stateName='+stateName;
                $.ajax({
                type: 'POST',
                dataType: 'json',
                async: true,
                url: 'B2cState.php',
                data: dataparam,
                cache: true,
                success: function(data) {
                    location.reload();
                }
            });
}
function showState()
{
    $('#globalAlert').modal('hide');
    if($("#wizard-t-2 .current-info").hasClass("audible"))
    {
        return true;
    }
    else
    {
    dataparam='&type=3';
        $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'B2cState.php',
        data: dataparam,
        cache: true,
        success: function(data) {

            if(data==404)
            {
                var alertmsg = "you have no other states in your address";
                $("#idGlobalAlert").html(alertmsg);
                $('#globalAlert').modal('show');
            }
            else
            {

                var list='';
                $(".modalPopLite-mask_class").css('display','block');
                $(".modalPopLite-wrapper_class").css('display','block');
                $('#popup-analytics-new #cancel_qutoes').show();
                list+="<select id='selectStateOption'><option value='' selected enabled>Select State</option>";
                for(var i=0;i<data.length;i++)
                {
                    list+="<option value="+data[i].id_state+">"+data[i].name+"</option>";
                }
                list+="</select>";
                $("#selectstate").html(list);
            }
        }

        });
    }
}
function showStatus()
{
    if($("#wizard-t-2 .current-info").hasClass("audible"))
    {
        $("#status").css("display","block");
    }
    else
    {
        $("#status").css("display","none");
    }
}
function closeModal()
{
    $(".modalPopLite-mask_class").css('display','none');
    $(".modalPopLite-wrapper_class").css('display','none');
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
                            $('#add_state').append('<option value='+data[i].id_state+'>'+data[i].name+'</option>');
                        loadShopingCart(true);
                    }

               });
});

$(document).ready(function() {

	loadVoucherCode(0);
	$("#dash_user_search_query_top, #dash_user_search_query_mobile").val('');
	$("#dash_user_search_query_top_button, #dash_user_search_query_mobile_button").click(function()
	{
		var queryValue='';
        if($("#dash_user_search_query_top").val())
        {
            queryValue=$("#dash_user_search_query_top").val();
        }
        else if($("#dash_user_search_query_mobile").val())
        {
            queryValue=$("#dash_user_search_query_mobile").val();
        }
        
		if(queryValue=="")
		{
			return false;
		}
		else
		{
		//window.open(baseDir+"search.php?search_query="+queryValue+"&orderby=position&orderway=desc",'_blank');
        $('#index_viewport').html('');
        $("#index_viewport").load("dash-searchproduct.php", function() {
        $('#wizard-p-0').load('dash/dash-search.tpl');
        });
        //$.getScript("dash/js/dash-PurchaseList.js", function(){});
        $('#dash_user_search_query_top, #dash_user_search_query_mobile').val('');
        searchProducts(queryValue,1);

		}
	});
		/*var dataparam = '&id_customer='+id_customer;
		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-loyalty-points.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{

				if(data <= 0)
				{

					$("#display_voucher_button").addClass('disabled');
				}
			$("#customer_points").append("<span>"+data+"</span>");

			}

});*/
 //loadVoucherCode(0);
 $('#pending_orders').slimScroll({
		height:"234px",
		wheelStep: 3,
		railVisible: false,
		alwaysVisible: false
		});
});

$(function(){
    $(".shoppingCartTable").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "4px",
				autohidemode: false
            });

 $('#voucher_height').slimScroll({
        height:"150px",
        wheelStep: 1,
        railVisible: true,
        alwaysVisible: true
        });
});

function searchProducts(queryValue,pagenum)
{
    $searchquery=queryValue;
    $('#search_view').html('');
    $('.toggle-right-box').show();
    var dataparam = '&search_query='+queryValue+'&mode=1&id_customer='+id_customer+'&pagenum='+pagenum;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            url: 'dash-searchproductdata.php',
            data: dataparam,
            cache: true,
            success: function(data) {
                $("#searchresults").html('');
                if(data.length==0)
                {

                   /* var msg='No Products Found';
                    $("#idGlobalAlert").html(msg);
                    $('#globalAlert').modal('show');*/
                    alert("No Products Found");
                    $("#searchresults").html('<center>Make sure that all words are spelled correctly.<br>Try different keywords.<br>For more details contact your Relationship Manager</center>');
                    //return true;
                }
                else
                {
                    $('#searchresults').html("Search results for '"+queryValue+"' ");
                     for(var i=0;i<(data.length);i++)
                    { 
                        if(data[i].discontinued==0)
                        {
                             var prod_name=data[i].pname;
                            var prod_name = prod_name.replace(/(<([^>]+)>)/ig,"");
                            var prod_name = jQuery.trim(data[i]['pname']).substring(0,40).trim(this);
							if(data[i]['description_short'])
							{
								var shortText = data[i]['description_short'].replace(/(<([^>]+)>)/ig,"");
								var shortText = jQuery.trim(shortText).substring(0, 50).trim(this) + "...";
							}
							else
								var shortText = "";
                            var price=data[i].price.substring(3);
                            if(parseInt(price)>0)
                            {
                                prod_price=data[i].price;
                            }
                            else
                            {
                                prod_price="Contact for price";
                            }
                            $('#search_view').append('<div id="product_'+i+'" onmouseout="view(1,'+i+');" onmouseover="view(0,'+i+');" class="col-md-3 div-block-products bordercolor"><div class="col-md-12 img-product"><img class="image-image" src='+data[i]['imageLink']+'></div><div class="col-md-12"><img id="image_'+i+'" class="quickView-img" src="http://www.kobster.com/images/quickView.jpg" onclick="quickView('+data[i].id_product+',0)" ></div><div class="col-md-12 product_name">'+prod_name+'</div><div class="col-md-12 img-reference">Product Code: '+data[i]['reference']+'</div><div class="col-md-12 img-product_desc">'+shortText+'</div><div class="col-md-12 product-price-tag" id="price_'+i+'">'+prod_price+'</div><div id="quickQty_'+i+'" class="col-md-12 quick-qty"><input type="text" id="inp_'+(i+1)+'" class="col-md-4 inp_search" value="1" size="2" maxlength="5" onkeydown="numbersOnly(event)"><span class="col-md-6 fa fa-shopping-cart btn btn-primary quick-btn" onclick=" addToCart(0,'+data[i].id_product+','+(i+1)+')"><span class="quick-btn-label">Buy Now</span></span></div><a class="btn btn-primary add-to-list" onclick="quickView('+data[i].id_product+',0)">Add to List</a></div>');
                            $('.quickView-img').css("display","none");

                            if(!parseInt(price)>0)
                            {
                                $("#quickQty_"+i).hide();
                            }
                            if(data[i].available_for_order==0)
                            {
                                $("#quickQty_"+i).html("<span class='txt-center'>Out Of Stock</span>")
                            }
                        }

                    }
                    pagination(data[0].count,queryValue,pagenum);
                }

            }
        });
}
function view(state,id)
{
    if(state==1)
    {
        $('#image_'+id).css("display","none");
    }
    else
    {
        $('#image_'+id).css("display","block");
    }
}

function pagination(count,query,pagenum)
{

    $('.searchpagination').html('');
    var prev=pagenum-1;
    var next=pagenum+1;
    var totalpagenum=count/18;  //18 is page size hotcoded,count is total items,pagenum is total pages, if change 18 here change in controller also
    if((totalpagenum*18)-(count)==0)
    {
        totalpagenum++;
    }
    if(pagenum>1)
    {
        $(".searchpagination").append('<label class="search-page" onclick="searchProducts(\''+query+'\','+prev+');">Prev</label>')
    }
    if(totalpagenum>2)
    {
        var start;
        var end;
        if(totalpagenum-pagenum>4)
        {
            start=pagenum;
            end=pagenum+4;
        }
        else
        {
            start=(totalpagenum-4);
            end=(totalpagenum);
            start=Math.round(start);
            end=Math.round(end);
        }
        for(var i=start;i<end;i++)
        {
            if(i>0)
            {
                $(".searchpagination").append("<button class='search-page page_"+i+"' onclick='searchProducts(\""+query+"\","+i+");'>"+i+"</button>");
            }
        }

    }
    if(totalpagenum>0 && (totalpagenum-pagenum)>1)
    {
        $('.searchpagination').append('<label class="search-page" onclick="searchProducts(\''+query+'\','+next+');">Next</label>');
    }
    $(".page_"+pagenum).css("background-color","#377ad7");
    $(".page_"+pagenum).css("color","#ffffff");
}

$(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        if ($("#focusedInput").is(":focus")) {
            $('#dash-corporate-user-add-to-cart').click();
        }
        if ($("#dash_user_search_query_top").is(":focus")) {
            $('#dash_user_search_query_top_button').click();

        }
        if ($("#dash_user_search_query_mobile").is(":focus")) {
            $('#dash_user_search_query_mobile_button').click();

        }

    }
});
//Object.prototype.toString.call(window.operamini) == '[object NetScape]';


if (navigator.appName != 'Microsoft Internet Explorer') {
    window.onload = function() {
        history.pushState(null, null, location.href);
        window.onpopstate = function(event) {
            history.go(1);
        };
    }
}
/*function orderStatusTime()
	{
			var myInterval = setInterval(function () {
				orderStatusTime();
        },900000);

		var type=1;//(to get all orders for particular customer)
	var dataparam = '&id_customer=' + id_customer+'&type=' + type;

	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-history.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
					var mulOrderId=new Array();
				for(var i=0; i<data.length; i++)
				{

					mulOrderId[i]=data[i].id_order;
				}
			getCustomerOrderDetails(mulOrderId);
//			getShippedOrderTime(mulOrderId);this not finalised yet but will use this iin later Stage.
			}

	});
	}orderStatusTime();

	*/

/*
to modify total time, just input on variable totaltime
*/
var totaltime = 24;

function loadQuickbuy() {
    ordering_type == 2;
    $('#index_viewport').html('');
    $("#index_viewport").load("dash-place-order-steps.php", function() {
        $('#wizard-p-0').load('dash-quickbuy.php');
    });
   // loadShopingCart();
}

function loadPurList() {
    var type = 3;

    var dataparam = '&id_customer=' + id_customer + '&api=2&type=' + type;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-PurchaseList.php', //
        data: dataparam,
        cache: true,

        success: function(data) {
             var size = data.length;
            var last = 1;
            for (var i = 0; data.length > i; i++) {
				if( data[i].list_active==1)
                	$("#lists").append("<li><a onclick='openPurchaseList(" + data[i].id_list + ")'>" + data[i].listname + "</a></li>");
            }

        }
    });
}

function loadPurchaseList(option) {
    /* get feedback of completed orders if available*/

    window.option=option;
    if(option==1)
        cataloguelist(1);
    else if(option==2)
        loadQuickbuy();
    else if(option==3)
         orderHistory();

    /*var dataparam = '&type=1';
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-feedback.php',
        data: dataparam,
        cache: true,
        success: function(data) {
            if(data)
            {
                $(".modalPopLite-mask_class").css('display','block');
                $("#idfeedback").css('display','block');
                $("#feedback_orderid").html(data[0].id_order);
                $("#feedback_dateadd").html(data[0].date_add);
                
            }
            else
            {
                if(option==1)
                    cataloguelist(1);
                else if(option==2)
                    loadQuickbuy();
                else if(option==3)
                     orderHistory();
            }
        }
    });*/
}
 
function rating(count)
{
    if(count==1)
    {
         $('#rating_comment').html('Very Bad');
         $("#feedback_rating_score").val(1);
         $("#comment_feedback").show();
    }
    else if(count==2)
    {
        $('#rating_comment').html('Bad');
        $("#feedback_rating_score").val(2);
        $("#comment_feedback").show();
    }
    else if(count==3)
    {
        $('#rating_comment').html('Not Bad');
        $("#feedback_rating_score").val(3);
        $("#comment_feedback").show();
    }
    else if(count==4)
    {
        $('#rating_comment').html('Good');
        $("#feedback_rating_score").val(4);
        $("#comment_feedback").show();
    }
    else if(count==5)
    {
        $('#rating_comment').html('Excellent');
        $("#feedback_rating_score").val(5);
        $("#comment_feedback").hide();
    }
}
function onFeedback()
{
    var comment=$("#comment_feedback").val();
    var rating=$("#feedback_rating_score").val();
    var order_id=$("#feedback_orderid").html();
    var customer=id_customer;

    if(!comment)
    {
        comment="Excellent Work";
    }
    $(".modalPopLite-mask_class").css('display','none');
    $("#idfeedback").css('display','none');


    var dataparam = '&type=2&comments='+comment+'&rating='+rating+'&order_id='+order_id+'&customer_id='+customer;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-feedback.php',
        data: dataparam,
        cache: true,
        success: function(data) {

            $("#success_alert").fadeIn("slow");
             $("#success_alert_span").html("<strong>Thanks for your feedback</strong>");
             setTimeout(function(){ $("#success_alert").fadeOut("slow"); }, 2500);

            $("#feedback_rating_score").val();
            $("#rating_comment").html('');
            $('.rating .star').removeClass('activerate');
            $("#comment_feedback").val('');

            loadPurchaseList(window.option);
        }
    });
}
function purchaselist()
{
    ordering_type = 1;
    $('#index_viewport').html('');
    $("#index_viewport").load("dash-place-order-steps.php", function() {
        $('#wizard-p-0').load('dash/dash-purchaselist.tpl');
        loadPurList();
        //loadShopingCart();
    });
}
function reports(id) {
     $('#report_type').val(id);
     $('#index_viewport').load('dash/dash-reports.tpl');
}

/*This is for Orders */

function orderHistory() {
    ordering_type = 3;
    $('#index_viewport').html('');
    $('#index_viewport').load('dash-orderhistory.php');
    /*load shopping cart by default*/
    //loadShopingCart();
}

function trackOrder() {
    ordering_type = 4;
    $('#index_viewport').html('');
    $('#index_viewport').load('dash/dash-trackorder.tpl');
    //loadShopingCart();
}

function invoice() {
    $('#index_viewport').html('');
    $('#index_viewport').load('dash-invoice.php');
}

function delivery() {
    $('#index_viewport').html('');
    $('#index_viewport').load('dash-delivery.php');
}
getCustomerOrderDetails();

function getCustomerOrderDetails() {

   // var status_name = Invoice Generated;
    var tempCount, count, type = 5,
        animateCount, shippedHour, shippedDate;
    var dataparam = '&type=' + type;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-history.php',
        data: dataparam,
        cache: true,
        success: function(data) {
              if (data)
			 {
                $('#order-status-in-process').html('');
                for (var i = 0; i < data.length; i++) {
                    if (data[i] == "" || data == "null") {
                        return false;
                    } else {
                        $('#order-status-in-process').append("<div id='order-status-in-process" + i + "' class='col-md-9 col-xs-9'></div></div><div class='col-md-3 col-xs-3 padding-align-left estimate-time' id='order-state-estimate-time" + i + "'></div><div id='order-status-in-process-text" + i + "' class='col-md-offset-2 col-md-7 col-xs-offset-2 col-xs-7'>");
                        //<div id='order-status-in-process-text" + i + "' class='col-md-4 '></div>
                        tempCount = data[i].length;
                        if (tempCount >= 3) {
                            tempCount = 3;
                            animateCount = tempCount - 1;
                        } else {
                            tempCount = data[i].length;
                            animateCount = tempCount - 1;
                        }

                        $('#order-status-in-process' + i).append("<span class='col-md-3 col-xs-3 track-order-id-value'  id='order-id-in-process" + i + "'><a data-toggle='modal' href='#status_history' onclick='getStatusDetails(" + data[i][0].id_order + "," + data[i][0][0] + "," + data[i][0][1] + ")'>" + data[i][0].id_order + "</a></span>");
                        for (var j = tempCount - 1; j >= 0; j--) {

                            var objAgent = navigator.userAgent;
                            var objOffsetVersion;
                            if ((objOffsetVersion=objAgent.indexOf("Chrome"))!=-1)
                            {
                                var date_add = data[i][j].date_add;
                            }
                            else{
                                var date_add_array = new Array();
                                date_add_array = data[i][j].date_add.split(' ');
                                var date_add = date_add_array[0]+"T"+date_add_array[1];
                            }

                            /*******Being Processed Status***********/
                            if (data[i][j].id_order_state == 19) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /*******Shipped Status********/
                            else if (data[i][j].id_order_state == 4) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }

                            }

                            /*********Delivered Status**********/
                            else if (data[i][j].id_order_state == 5) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order,date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /**********Cancelled***********/
                            else if (data[i][j].id_order_state == 6) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order,date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /************Refund status********/
                            else if (data[i][j].id_order_state == 7) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;

                                }
                            }

                            /************Partially Shipped Status********/
                           else if (data[i][j].id_order_state == 18) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /******Ready to be Shipped Status*****/
                           else if (data[i][j].id_order_state == 20) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /***********Partially Delivered Status***********/
                           else if (data[i][j].id_order_state == 21) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /***********Order Placed Status**************/
                            else if (data[i][j].id_order_state == 22) {
                                //alert(data[i][j].ostate_name);
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /**********Pending for Approval Status***********/
                            else if (data[i][j].id_order_state == 28) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /**********Approved Status*********/
                           else if (data[i][j].id_order_state == 29) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /***********Rejected**************/
                           else if (data[i][j].id_order_state == 30) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
							/*******Revised*********/
							else if (data[i][j].id_order_state == 31) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            /*******    Order Processing Held*******/
                            else if (data[i][j].id_order_state == 32) {
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                               /******* Packed and Ready to be shipped  *******/
                             else if (data[i][j].id_order_state == 33) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                               /******* Offline invoice generated*******/
                              else if (data[i][j].id_order_state == 34) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                                /*******invoice gemerated*******/
                               else if (data[i][j].id_order_state == 25) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                                /*******Pending Payment*******/
                              else if (data[i][j].id_order_state == 35) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                                /*******Payment recieved*******/
                              else if (data[i][j].id_order_state == 36) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                               /*******Pending Invoice*******/
                              else if (data[i][j].id_order_state == 37) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                              /*******Order Completed*******/
                            else if (data[i][j].id_order_state == 38) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
							else if (data[i][j].id_order_state == 39) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
							else if (data[i][j].id_order_state == 40) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                            /* Customer Verification Pending */
                            else if (data[i][j].id_order_state == 41) {

                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                            /* Customer Verified */
                            else if(data[i][j].id_order_state == 42){
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }
                            /* Level 1 Approval */
                            else if(data[i][j].id_order_state == 43){
                                appendOrderStatus(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].ostate_name, i, data[i][j].id_order_state, data[i][0].id_order, date_add, data[i][0][0], data[i][0][1], j);
                                if (animateCount > 0) {
                                    appendAnimateLine(data[i][j].id_order_state + data[i][0].id_order + animateCount, data[i][j].id_order_state);
                                    animateCount--;
                                }
                            }

                            if (data[i][j][2] && data[i][j][2] !== "0000-00-00 00:00:00") {
                                var date = new Date(data[i][j][2]);
								var year = new Array();
								var newyear = new Array();
								year = data[i][j][2].split("T");
								newyear = year[0].split("-");
								if (newyear[0] < "2015")
								{
									$("#order-state-estimate-time" + i).html();
									$("#order-state-estimate-time" + i).append("Not Available");
								}
								else
								{
                                var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                var hours = date.getHours();
                                var minutes = date.getMinutes();
                                var ampm = hours >= 12 ? 'PM' : 'AM';
                                hours = hours % 12;
                                hours = hours ? hours : 12; // the hour '0' should be '12'
                                minutes = minutes < 10 ? "0" + minutes : minutes;
                                $("#order-state-estimate-time" + i).html(date.getDate() + "-" + months[date.getMonth()] + " " + hours + ':' + minutes + ' ' + ampm);
								}
                             }

                        }
                        draw();
                    }
                }
            }
        }

    });
}

function appendOrderStatus(appendCount, ostate_name, i, iconValue, orderId, date, id_address_delivery, id_address_invoice, j) {

    if((ostate_name == 'Offline invoice generated')||(ostate_name == 'Generate Invoice'))
    {
        ostate_name = 'Invoice Generated';
    }
    var date = new Date(date);
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? "0" + minutes : minutes;
    $('#order-status-in-process' + i).append("<span id='order-status-icon-" + iconValue + "-" + appendCount + "'  class='col-md-3 order-status-icon1 order-status-icon '><span  class='track-order-icon-span cur-poi' onmouseout='hideTime(" + orderId + "," + iconValue + "," + j + ");'onmouseover='displayTime(" + orderId + "," + iconValue + "," + j + ");'><a data-toggle='modal' href='#status_history' onclick='getStatusDetails(" + orderId + "," + id_address_delivery + "," + id_address_invoice + ")'><img src='" + baseDir + "img/statusIcon/32/" + iconValue + ".png'><div id='" + orderId + "-div" + iconValue + "order-" + j + "' class='hidden-div-styles' style='display:none;'><a/>" + date.getDate() + "-" + months[date.getMonth()] + " " + hours + ':' + minutes + ' ' + ampm + "</div></span>");
    $('#order-status-in-process-text' + i).append("<span class='order-status-name col-md-4'>" + ostate_name + "</span>");


}

function appendAnimateLine(appendAnimateCount, value) {
    $("#order-status-icon-" + value + "-" + appendAnimateCount).append("<div  class='animate-span'></div>");
}

function draw() {
    setTimeout(function() {
        //$(".animate-span").css("width", "24px");
        $(".animate-span").addClass( "span-width-control" );
    }, 500);
    setTimeout(function() {
        $(".order-status-name").css("display", "inline-block");
    }, 2500);
}

function displayTime(orderId, iconValue, j) {
    $("#" + orderId + "-div" + iconValue + "order-" + j).show();
}

function hideTime(orderId, iconValue, j) {
    $("#" + orderId + "-div" + iconValue + "order-" + j).hide();
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
				 var total_price = data[3][i].total_wt;
				 total_price = parseFloat(total_price).toFixed(2);
                $("#productsTable").append("<tr><td>"+(i+1)+"</td><td>" + data[3][i].product_reference + "</td><td>" + data[3][i].product_name + "</td><td>" + data[3][i].product_quantity + "</td><td>" + data[3][i].product_price_wt + "</td><td class='price'>" + total_price + "</td></tr> ");
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
                 $('#reorder_button').append('<button data-dismiss="modal" style="float:left" onclick="reOrder(' + id_order + ')" class="btn btn-primary" type="button">Reorder</button>');
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
function reOrder(orderid)
{
	$("#hide_order_id").val(orderid);
	if(shopingcart !=0)
	{
 		$("#remove_cart").modal('show');
	}
	else
	{
		reOrderCart(orderid);
	}
}
function clearAndAddtoCart()
{
	var order_id=$("#hide_order_id").val();
	cartClear(order_id);
 }
function AddtoCart()
{
	var order_id=$("#hide_order_id").val();
 	reOrderCart(order_id);
}
function reOrderCart(orderid)
{
    var type = 3;
    ordering_type = 3;
    var dataparam = '&id_order=' + orderid + '&type=' + type;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-history.php',
        data: dataparam,
        cache: true,
        success: function(data) {$('#error_alert').html('');
				//$('#error_alert').html('');
				loadShopingCart(false);
				$('#listoferrors').html('');
				var success=0;
  				 if(data !="")
				 {
					 for(var i =0 ; data.length >i; i++)
					 {
						 if(data[i].msg != "success")
							 {
								var sno=i+1;
								//$('#error_alert').append("<div><span>"+sno+")</span><span>"+data[i].name+"</span></div>");
								$('#listoferrors').append("<tr><td>"+data[i].name+"</td><td>"+data[i].msg+"</td></tr>");
								$('#error_cart').modal('show');
							 }
							 else
							 {
								success++;
							 }
					 }
				 }
  				/*else
            	{*/
                /*loadShopingCart() in dash-index.js*/
                if(success >0)
				{

					if ($('#container').hasClass('open-right-panel')) {
					}
					else
					{
						$('.toggle-right-box .fa-shopping-cart').click();
					}
				}
                /*$('#index_viewport').html('');
					$('#index_viewport').load("dash-displayaddress.php");*/

                /*load shopping cart by default*/
                 $("#index_viewport").load("dash-place-order-steps.php", function()
				 {
                    $("a[href$='#next']").click();
                    if (ordering_type == 3) {
                        $('#wizard-t-0').click(function() {
                            orderHistory();
                        });
                    }
                    if (ordering_type == 4) {
                        $('#wizard-t-0').click(function() {
                            trackOrder();
                        });
                    }

                    $('.actions').hide();
				 });
           /* }*/
        }
    });
}
function addToCart(idList,id_product,id) {
    var qty;
    if(id)
    {
        qty=$("#inp_"+id).val();
        $("#inp_"+id).val('1');
    }
    else
    {
        qty=$('.quickView_quantity_wanted').val();
    }
    if(qty<=0)
    {
        var alertmsg = "No Products To Add";
        $("#idGlobalAlert").html(alertmsg);
        $('#globalAlert').modal('show');
        return false;
    }
    var type = 2;
    var listStatus = 2;
    var productqty= id_product+'-'+qty;
    var dataparam = '&productarray=' + productqty + '&type=' + type + '&id_customer=' + id_customer + '&list_id=0&listStatus=' + listStatus;
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
                var success=0;
                    for(var i =0 ; data.length >i; i++)
                     {
                         if(data[i].msg != "success")
                         {
                            $('#listoferrors').append("<tr><td>"+data[i].name+"</td><td>"+data[i].msg+"</td></tr>");
                            $('#error_cart').modal('show');
                         }
                         else
                         {
                            success++;
                            /*var alertmsg = "Product added to cart Successfully";
                            $("#id_alert").html(alertmsg);
                            $('#alert_msg').modal('show');*/
                         }
                     }

                 if(success >0)
                 {
                    loadShopingCart();
                    if($("#cart-products-row-sno_1").length==0)
                    {
                        if ($('#container').hasClass('open-right-panel'))
                        {}
                        else
                        {
                            $('.shoppingcart').click();
                        }
                    }
                    else
                    {
                        $('#main-content').addClass('panel-open');
                        if($("#wizard-t-2").parent().hasClass('current'))
                        {
                            $('.toggle-right-box').hide();
                            $('#container').removeClass('open-right-panel');
                            $('.header').removeClass('merge-header');
                            $('.right-sidebar').removeClass('open-right-bar');
                            $("#total_cart_products").hide();
                            loadViewContent();
                        }
                    }
                 }
                //$('.qv_quantity_wanted').val('0');
                $('.priceChange').html('<strong>Rs. 0.00</strong>   ');
                $('#quick_msg').modal('hide');
        }
    });
    }


/*function getShippedOrderTime(mulOrderId) this not finalised yet but will use this iin later Stage.
{

		var type=6,shipCount;//(to get shipped order time for particular customer)
	var dataparam = '&mulOrderId=' + mulOrderId+'&type=' + type;
	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-history.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
				$("#time-to-delivery").html("");
					if(data.length>=3)
					{
						shipCount=3;
					}
					else
					{
						shipCount=data.length;
					}

 					for (var i=0; i<shipCount; i++ )
					{
					if(data[i][0].id_order_state==4 && data[i][0].shippingtime<24)
					{
						$("#time-to-delivery").append("<div id='"+data[i][0].id_order+"' class='col-md-6  panel-body-override' ><div class='col-md-12 bold-font  panel-body-override'>Order ID :"+data[i][0].id_order+"</div><div class='pie degree col-md-12' id='pie"+data[i][0].id_order+"'><span class='time' id='time"+(data[i][0].id_order)+"'>"+(24-data[i][0].shippingtime)+"</span></div></div>");
						startTime(data[i][0].id_order);
    				}
			}
	});
}
function update(percent,id_order) {
    var deg;
    if (percent < (totaltime / 2)) {
        deg = 90 + (360 * percent / totaltime);
        $('#pie'+id_order).css('background-image',
            'linear-gradient(' + deg + 'deg, transparent 50%, white 50%),linear-gradient(90deg, white 50%, transparent 50%)'
        );
    } else if (percent >= (totaltime / 2)) {
        deg = -90 + (360 * percent / totaltime);
        $('#pie'+id_order).css('background-image',
            'linear-gradient(' + deg + 'deg, transparent 50%, #AEC785 50%),linear-gradient(90deg, white 50%, transparent 50%)'
        );
    }
}

function startTime(id_order){
	var count = parseInt($('#time'+id_order).text());
    count +=-1 ;
	    update(count,id_order);
		    $('#time'+id_order).html(count);
		if(count==0)
		{
		clearInterval(myInterval);
		}

}
*/


function loadShopingCart(load_loyalty_point) {
    $('#top-nav-dropdown-menu').removeClass("open");
	var type = 0;
	var dataparam = '&type=' + type;
 	$.ajax({
        type: 'POST',
        url: 'dash-getcartproduct.php',
        async: true,
        cache: false,
        global: false,
		data: dataparam,
        dataType: "json",
        success: function(jsonData)
		{
			//console.log(jsonData);
  				if ($('#container').hasClass('open-right-panel')) {}
				shopingcart = jsonData.length;
				$("#total_cart_products, .total_cart_products_desktop").html(shopingcart);
				//$("#shopping_shipping").html("");
				$("#shopping_tax").html("");
				$(".shopping_Total").html("");
				$("#loyalty_points").html("");

				$(".cart_total_elite").html("");
 				$('#cart-products-list-body').html('');
				$("#shopping_cart").html("");
 				for (var i = 0; i < jsonData.length; i++)
				{
                    prod_price=jsonData[i].total;
                    prod_price="Rs."+prod_price;
					var product_name = jsonData[i].name;
					if (product_name.length > 15) product_name = product_name.substring(0, 15) + "...";
					$("#shopping_cart").append("<tr class='shoppingCartTr' id='shoppingCartRow_" + jsonData[i].id_product + "'><td class='cur-poi' onclick='quickView("+jsonData[i].id_product+",0)'>" + product_name + "</td><td><input type='text' value='"+jsonData[i].quantity+"' maxlength='5' size='3' class='productquantity tex-ali-cen qv_quantity_wanted_cart' onchange='forChangeInQuantityCart("+jsonData[i].id_product+","+jsonData[i].total+","+jsonData[i].minimal_quantity+");' onkeydown='numbersOnly(event)' id='right_qty_"+jsonData[i].id_product+"'></td><td id='price_"+jsonData[i].id_product+"'>Rs." + jsonData[i].total + "</td><td><span class='fa fa-times cur-poi' onclick='toRemoveShoppingCartProduct(" + jsonData[i].id_product + ","+jsonData[i].id_product_attribute+",null," + jsonData[i].id_product + ")'></span></td></tr>");
 				}
                if(jsonData !="")
                {
					//$("#vouchercode span").removeClass('disabled');
					var discountids= [];// get the vouchers which are added in cart
					
					if(jsonData[0][5] !="")
					{
						var discountValue =0;
						
						for (var j=0; j<jsonData[0][5].length; j++)
						{
							
 							discountValue += parseFloat(jsonData[0][5][j].reduction_amount);
                            discountids.push(jsonData[0][5][j].id_cart_rule);
  						}
					}
					else
					{
					var discountValue=0;
					}
 					//if(discountValue !=0)
                     var currency = (jsonData[0][4]).split(' ');
					$('#discount').html(currency[0]+" "+parseFloat(discountValue));
					//$("#shopping_shipping").html(currency[0]+" "+'0.00');
    				$("#shopping_tax").html(jsonData[0][4]);
					$("#loyalty_points").html(jsonData[0][6]);
					$("#loyalty_points_summary").html(jsonData[0][6]);
					$(".shopping_Total").html(jsonData[0][3]);
    				$(".cart_total_elite").html($('.shoppingCartTr').index()+1);
                    $('#shopping_detail').show();
 
				}
                else{
                    $('#shopping_cart').html('');
                    $('#shopping_cart').html('<tr><th></th></tr><tr><th></th><td><center style="color:#dc2d3c">No Products in cart.</center></td></tr>').css({'font-size':'12px','border':'none'});
                    $('#shopping_cart th,#shopping_cart td').css({'border':'none'});
                    $('.shoppingCartList tr th').css({'text-align':'center'});
                    $('#shopping_detail').hide();
                }


				if(jsonData.length == 0)
				{

					$("#vouchercode span").addClass('disabled');

				}
				else
				{
					$("#vouchercode span").removeClass('disabled');
				}


				if(jsonData.length!=0)
				{
					if(jsonData==" ")
					{
						$("#globalAlert").show('show');
						$("#idGlobalAlert").html("No Products In Your Shoping Cart");
					}
					$('#cart-products-list-body').html('');

					for(var i=0;i<jsonData.length;i++)
					{

					$("<tr id='cart-products-row-id"+jsonData[i].id_product+"' class='odd'><td class='col-md-1 cart-products-row-no' id='cart-products-row-sno_"+(jsonData.length-i)+"'>"+(jsonData.length-i)+"</td><td class='col-md-2' ><img src='"+jsonData[i][0]+"'></td><td class='col-md-4 cart-product-name'><a target='_blank' href='"+jsonData[i].link+"'>"+jsonData[i].name+"</a></td><td class='col-md-2 tex-ali-cen' ><input id='qty_"+jsonData[i].id_product+"' onkeydown='numbersOnly(event)' onchange='forChangeInQuantity("+jsonData[i].id_product+","+jsonData[i].price.toFixed(2)+","+jsonData[i].minimal_quantity+");' class='productquantity tex-ali-cen qv_quantity_wanted' size='4' type='text' maxlength='5' value='"+jsonData[i].quantity+"'  /></td><td id='price_"+jsonData[i].id_product+"'class='col-md-3' >Rs. "+jsonData[i].total+"</td><td class='sorting_1 '><a onClick='toRemoveCartProduct("+jsonData[i].id_product+","+null+","+jsonData[i].id_customization+","+jsonData[i].id_product+");' class='fa fa-trash-o delete-option' ></a></td></tr>").prependTo('table > #cart-products-list-body');
					}



					var discountids= [];// get the vouchers which are added in cart
					if(jsonData[0][5] !="")
					{
						var discountValue =0;
						for (var j=0; j<jsonData[0][5].length; j++)
						{
 							/*var discount_value = (jsonData[0][5][j].value).split(' ');
                            discountValue = discount_value[0];
                            discountValue = discountValue.replace(',',"");
                            discountValue += parseFloat(discount_value[0]);
                            discountids.push(jsonData[0][5][j].id_discount);*/
							 discountValue += parseFloat(jsonData[0][5][j].reduction_amount);
                            discountids.push(jsonData[0][5][j].id_cart_rule);
							


						}
					}
					else
					{
						var discountValue=0;
					}
					//if(discountValue !=0)
					$('#discount').html(currency[0]+" "+parseFloat(discountValue).toFixed(2));


				}
				else
				{
					$('#vouchercode span').addClass('disabled');
					//alert(shopingcart);
				}


		}
    });

}
function toRemoveShoppingCartProduct(id_product, id_combination, id_customization, id) {
    var elite_cart_count = $('.shoppingCartTr').index()+1;
    if(elite_cart_count > 1){
    	$("#shoppingCartRow_" + id).remove();
    }
	 else {
    	$('.shoppingcart').click();
    	if(ordering_type == 6){
            setTimeout(function(){
             var alertmsg = "Your cart is empty, Redirecting to home page";
            $("#id_alert").html(alertmsg);
            $('#alert_msg').modal('show');
            },1000);
            location.reload();
    	}
    	else if(ordering_type == 7){
    		cataloguelist();
    	}
    	else if(ordering_type == 2){
    		loadQuickbuy();
    	}
    	else if(ordering_type == 3){
    		orderHistory();
    	}
    	else if(ordering_type == 4){
    		trackOrder();
    	}
    }
    $.ajax({
        type: 'POST',
        url: 'cart.php',
        async: true,
        cache: false,
        dataType: "json",
        data: 'delete=1&id_product=' + id_product + '&ipa=' + ((id_combination != null && parseInt(id_combination)) ? id_combination : '') + ((id_customization && id_customization != null) ? '&id_customization=' + id_customization : '') + '&token=' + static_token + '&ajax=true',
        success: function(jsonData) {
            ajaxCart.updateCart(jsonData);
            if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc')
                deletProductFromSummary(idProduct + '_' + idCombination);
             loadShopingCart(true);
        },
        error: function() {
            alert('ERROR: unable to delete the product');
        }
    });






}

function checkOutProcess() {
    //ordering_type =0;
    if (shopingcart == 0) {
        var alertmsg = "No Products in Cart";
        $("#idGlobalAlert").html(alertmsg);
        $('#globalAlert').modal('show');
        return false;

    }

    $("#index_viewport").load("dash-place-order-steps.php", function() {
        $("a[href$='#next']").click();
         if (ordering_type == 0) {
            $("#wizard-t-0").parent().addClass('disabled');
            ordering_type = 6;
        } else if (ordering_type == 1) {
            $('#wizard-p-0').load('dash/dash-purchaselist.tpl');
            loadPurList();
        } else if (ordering_type == 2) {
            $('#wizard-p-0').load('dash-quickbuy.php');
        }
		else if (ordering_type == 7) {
            $('#wizard-p-0').load('dash/dash-cataloguelist.tpl');
        }

        $('.actions').hide();
    });
}

function next() {
    var tr = new Array();
    $('.shoppingCartTr').each(function() {
        tr.push(this.id);
    });
    if (tr != "") {

        $("a[href$='#next']").click();

    } else {
        var alertmsg = "No Products in Cart";
        $("#idGlobalAlert").html(alertmsg);
        $('#globalAlert').modal('show');
        return false;
    }
}

function openShoppingCart(page) {
    if(page==1)
	{
        var shopping_cart_rm = $('.rmshoppingCartTr').html();
        if(shopping_cart_rm)
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
     				$('.shoppingcart').click();
                    $('#container').addClass('open-right-panel');
    				$('.right-sidebar').addClass('open-right-bar');
    				$('.header').addClass('merge-header');
    				$('#main-content').removeClass('merge-left');
    				$("#total_cart_products").show();
     			}

    			if ($('#sidebar').hasClass('hide-left-bar')) {
    				$('#sidebar').removeClass('hide-left-bar');
    			}
        }
	}
    if (page == 0) {
		var shopping_cart_elite = $('.shoppingCartTr').html();
		if(shopping_cart_elite){
        if ($('#container').hasClass('open-right-panel')) {
        } else {
            $('.shoppingcart').click();
        }
        }
    }
}

$('.toggle-right-box .fa-shopping-cart').click(function() {
    $('#top-corporuser-info').removeClass("open");
    $('#main-content').toggleClass('panel-open');
});


/*************************************************************************/
function submitMyAddress()//to get the new user address
	{
  		var alias=$('#alias').val();
		var firstname = $('#add_firstname').val();
		var address1 = $('#add_address1').val();
		var postcode=$('#add_postcode').val();
		var city = $('#add_city').val();
		var state = $('#add_state').val();
		var country = $('#add_country').val();
		var company = $('#company').val();
		var phone_mobile = $('#add_phone_mobile').val();
		var error=0;
		if(alias =="")
		{
			$('#alias').val('');
			$('#alias').attr("placeholder",'please Enter Address Alias');
 			error=1;
 		}
		if(firstname =="")
		{
			$('#add_firstname').val('');
			$('#add_firstname').attr("placeholder",'please Enter name');
 			error=1;
 		}
		if(address1 =="")
		{
			$('#add_address1').val('');
			$('#add_address1').attr("placeholder",'please Enter Current Address');
 			error=1;
 		}
		if(postcode =="")
		{
			$('#add_postcode').val('');
			$('#add_postcode').attr("placeholder",'please Enter Pincode');
 			error=1;
 		}
		if(city =="")
		{
			$('#add_city').val('');
			$('#add_city').attr("placeholder",'please Enter City');
 			error=1;
 		}
		if(state ==0)
		{
			$('#add_state_error').html('');
			$('#add_state_error').html('please Select State');
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
			$('#add_phone_mobile').val('');
			$('#add_phone_mobile').attr("placeholder",'please Enter Mobile Number');
 			error=1;
 		}
		if(isNaN(phone_mobile))
		{
			$('#add_phone_mobile').val('');
			$('#add_phone_mobile').attr("placeholder",'please Enter  Number Only');
 			error=1;
		}
		if(phone_mobile.length  < 10)
		{
			$('#add_phone_mobile').val('');
			$('#add_phone_mobile').attr("placeholder",'please Enter 10 digit valid mobile Number');
 			error=1;
		}
		if(postcode.length < 6)
		{
			$('#add_postcode').val('');
			$(add_postcode).attr("placeholder",'please Enter  6 digit valid Pincode');
 			error=1;
		}
		if(isNaN(postcode))
		{
			$('#add_postcode').val('');
			$('#add_postcode').attr("placeholder",'please Enter  Number Only');
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
								$('#globalAlert').modal('show');
								$("#idGlobalAlert").html("Address Added Successfully");
 								if(hide_address_value!=0)
									checkOutProcess();

								if($('#wizard-t-1').parent().hasClass('current'))
								{
                                    $('#wizard-t-1').click();
 									//checkOutProcess();
								}
								setTimeout(function()
								{
									$('#globalAlert').modal('hide')
								},2000);

							}
						}
			  });
	}
}
function imgError(image) {
    image.onerror = "";
    image.src = baseDir+"img/logo/1.png";
    return true;
}



function forChangeInQuantityCart(productId,price,minimal_quantity)
{
        var type=8;

        var productarray = new Array();
            var productQty=$("#right_qty_"+productId).val();

    if(productQty < minimal_quantity)
    {
            var alertmsg = "Please enter quantity of "+minimal_quantity+" or above.";
            var minimum_quantity = "(Reason : Minimum quantity limit is "+minimal_quantity+")";
            $("#idGlobalAlert").html("<center>"+alertmsg+"<br>"+minimum_quantity+"</center>");
            $('#globalAlert').modal('show');
            $('#shoppingCartRow_'+productId+' '+'.qv_quantity_wanted_cart').val(minimal_quantity);
            productQty=$("#right_qty_"+productId).val();
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
                 toUpdatePrice(productId);
            }
    });
    $("#right_qty_"+productId).val(productQty);
}


/*$(document).ready(function()
{
	$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			//data:{id_customer:id_customer},
			success: function(jsonData)
			{

				if(jsonData.length!=0)
				{
					if(jsonData==" ")
					{
						$("#globalAlert").show('show');
						$("#idGlobalAlert").html("No Products In Your Shoping Cart");
					}
					$('#cart-products-list-body').html('');

					for(var i=0;i<jsonData.length;i++)
					{

					$("<tr id='cart-products-row-id"+jsonData[i].id_product+"' class='odd'><td class='col-md-1 cart-products-row-no' id='cart-products-row-sno_"+(jsonData.length-i)+"'>"+(jsonData.length-i)+"</td><td class='col-md-2' ><img src='"+jsonData[i][0]+"'></td><td class='col-md-4 cart-product-name'><a target='_blank' href='"+jsonData[i].link+"'>"+jsonData[i].name+"</a></td><td class='col-md-2 tex-ali-cen' ><input id='qty_"+jsonData[i].id_product+"' onkeydown='numbersOnly(event)' onchange='forChangeInQuantity("+jsonData[i].id_product+","+jsonData[i].price.toFixed(2)+","+jsonData[i].minimal_quantity+");' class='productquantity tex-ali-cen qv_quantity_wanted' size='4' type='text' maxlength='5' value='"+jsonData[i].quantity+"'  /></td><td id='price_"+jsonData[i].id_product+"'class='col-md-3' >Rs. "+jsonData[i].total+"</td><td class='sorting_1 '><a onClick='toRemoveCartProduct("+jsonData[i].id_product+","+null+","+jsonData[i].id_customization+","+jsonData[i].id_product+");' class='fa fa-trash-o delete-option' ></a></td></tr>").prependTo('table > #cart-products-list-body');
					}



					var discountids= [];// get the vouchers which are added in cart
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
					//if(discountValue !=0)
					$('#discount').html(discountValue.toFixed(2));
					loadVoucherCode(discountids);

				}
				else
				{
					$('#vouchercode span').addClass('disabled');
					//alert(shopingcart);
				}



		}
});
});*/

function openVoucher()
{
	$("#view_voucher").modal('show');

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
 					$("#view_voucher").modal('hide');
					$("#globalAlert").modal('show');
					$("#idGlobalAlert").html("Voucher Added to cart successfully");

					$("#delete_"+id).show();
					$("#add_discount_"+id).hide();
                    loadShopingCart(true);
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

								 loadShopingCart(true);
							 $("#delete_"+data[2]).show();
							$("#add_discount_"+data[2]).hide();
						 }

					}

				}
				else
				{
 					$("#view_voucher").modal('hide');
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
					loadShopingCart(true);
 			}
	});
}
/*var dataparam = '&id_customer='+id_customer;
		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-loyalty-points.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{

				if(data <= 0)
				{

					$("#display_voucher_button").addClass('disabled');
				}
			$("#customer_points").append("<span class='normal_font_weight'>"+data+"</span>");

			}

});*/

function loadVoucherCode(discountids)
{
 	if(discountids != 0)
		var discountids = discountids;
 	var type=1;
	var dataparam= '&type='+type+'&id_customer='+id_customer;
   	$.ajax({
			type: 'POST',
			url: 'dash-shopping-cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data:dataparam,
 			success: function(data)
			{
				$("#vouchercode, #customer_points").html('');
				/*loyalty-points section starts here*/
					if(data[2] <= 0)
					{

						$("#display_voucher_button").addClass('disabled');
					}
					$("#customer_points").append(data[2]);
				/*loyalty-points section Ends here*/

				var discount=[];
				if(data[0] == 0)
				{

					$('#voucher_display_height').html("");
					$('#voucher_display_height').append("<div class='voucher_display'>No Active Vouchers</div>");
				}

  				for(var i=0; i<data[0].length; i++)
				{
					var name= data[0][i].name;
                    var reduction_val=(data[0][i].reduction_amount!=0)?'Rs.'+data[0][i].reduction_amount:data[0][i].reduction_percent+'%';

					$("#vouchercode").append("<tr class='discountClass' id='"+data[0][i].id_cart_rule+"'><td id='vocher_name_"+data[0][i].id_cart_rule+"'>"+data[0][i].name+"</td><td id='vocher_code_"+data[0][i].id_cart_rule+"'>"+reduction_val+"</td><td>"+data[0][i].description+"</td><td><span id='add_discount_"+data[0][i].id_cart_rule+"' class='btn btn-success btn-xs' onclick='addDiscount("+data[0][i].id_cart_rule+",0,\""+name+"\");'>Apply</span><span id='delete_"+data[0][i].id_cart_rule+"' style='display:none;' class='btn btn-danger btn-xs btn-xs' onclick='deleteDiscount("+data[0][i].id_cart_rule+");'>Cancel</span></td></tr>");
					discount.push(data[0][i].id_cart_rule);
 				}

				for(var i=0; i<data[1].length; i++)
				{
					if ($.inArray(data[1][i].id_cart_rule, discount) < 0)
					{
						var name= data[1][i].name;
						$("#vouchercode").append("<tr class='discountClass' id='"+data[1][i].id_cart_rule+"'><td id='vocher_name_"+data[1][i].id_cart_rule+"'>"+data[1][i].name+"</td><td>"+data[1][i].description+"</td><td><span id='add_discount_"+data[1][i].id_cart_rule+"' class='btn btn-success btn-xs apply' onclick='addDiscount("+data[1][i].id_cart_rule+",0,\""+name+"\");'>Apply</span><span id='delete_"+data[1][i].id_cart_rule+"' style='display:none;' class='btn btn-danger btn-xs btn-xs' onclick='deleteDiscount("+data[1][i].id_cart_rule+");'>Cancel</span></td></tr>");
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
				 var rowCount = $('#shopping_cart tr').length;
				 if($('#shopping_cart tr').length >0)
					 $("#apply").addClass("disabled");
				 //alert(rowCount);

					$('#show_voucher_count').html('');
					$('#show_voucher_count').append(data[0].length);

			}

	});


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
                if(data == 1 && order_id !=0)
                   {
                         reOrderCart(order_id);
                   }
                else
                    {
                        $('.cancel-selection').click();
                        loadShopingCart(true);
                        $('.shoppingcart').click();

                            if(ordering_type == 6){
                                var alertmsg = "Your cart is empty, Redirecting to home page";
                                $("#id_alert").html(alertmsg);
                                $('#alert_msg').modal('show');
                                location.reload();
                            }
                            else if(ordering_type == 7){
                                cataloguelist();
                            }
                            else if(ordering_type == 2){
                                loadQuickbuy();
                            }
                            else if(ordering_type == 3){
                                orderHistory();
                            }
                            else if(ordering_type == 4){
                                trackOrder();
                            }
                    }
            }
        });
}

function EBS()
{
 	$('#hidden-info').load('dash-EBS.php' );
}
function showPendingOrders()
{
     $('#index_viewport').html('');
    $('#index_viewport').load('dash-childorder.php');
}

/* dataTable() is from dash/js/data-tables/jquery.dataTables.js
AND dash/js/data-tables/DT_bootstrap.js */
function easySearch(table_id)
{



	var oTable = $('#'+table_id).dataTable({
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
				'aTargets': []
			}
		],
		"aaSorting": []

	});

}
if($("#wizard-t-1").parent().hasClass('current'))
{

	$.getScript("dash/js/dash-user-address.js", function(){});
}
if($("#wizard-t-2").parent().hasClass('current'))
{
	$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			//data:{id_customer:id_customer},
			success: function(jsonData)
			{

				if(jsonData.length!=0)
				{
					if(jsonData==" ")
					{
						$("#globalAlert").show('show');
						$("#idGlobalAlert").html("No Products In Your Shoping Cart");
					}
					$('#cart-products-list-body').html('');

					for(var i=0;i<jsonData.length;i++)
					{

					$("<tr id='cart-products-row-id"+jsonData[i].id_product+"' class='odd'><td class='col-md-1 cart-products-row-no' id='cart-products-row-sno_"+(jsonData.length-i)+"'>"+(jsonData.length-i)+"</td><td class='col-md-2' ><img src='"+jsonData[i][0]+"'></td><td class='col-md-4 cart-product-name'><a target='_blank' href='"+jsonData[i].link+"'>"+jsonData[i].name+"</a></td><td class='col-md-2 tex-ali-cen' ><input id='qty_"+jsonData[i].id_product+"' onkeydown='numbersOnly(event)' onchange='forChangeInQuantity("+jsonData[i].id_product+","+jsonData[i].price.toFixed(2)+","+jsonData[i].minimal_quantity+");' class='productquantity tex-ali-cen qv_quantity_wanted' size='4' type='text' maxlength='5' value='"+jsonData[i].quantity+"'  /></td><td id='price_"+jsonData[i].id_product+"'class='col-md-3' >Rs. "+jsonData[i].total+"</td><td class='sorting_1 '><a onClick='toRemoveCartProduct("+jsonData[i].id_product+","+null+","+jsonData[i].id_customization+","+jsonData[i].id_product+");' class='fa fa-trash-o delete-option' ></a></td></tr>").prependTo('table > #cart-products-list-body');
					}
 					var discountids= [];// get the vouchers which are added in cart
					if(jsonData[0][5] !="")
					{
						var discountValue =0;
						for (var j=0; j<jsonData[0][5].length; j++)
						{

							/*var discount_value = (jsonData[0][5][j].value).split(' ');
                            discountValue = discount_value[0];
                            discountValue = discountValue.replace(',',"");
                            discountValue += parseFloat(discount_value[0]);
                            discountids.push(jsonData[0][5][j].id_cart_rule);*/
							discountValue += parseFloat(jsonData[0][5][j].reduction_amount);
                            discountids.push(jsonData[0][5][j].id_cart_rule);


						}
					}
					else
					{
						var discountValue=0;
					}
					//if(discountValue !=0)
					$('#discount').html(parseFloat(discountValue)+" "+discount_value[1]);
					loadVoucherCode(discountids);

				}
				else
				{
					$('#vouchercode span').addClass('disabled');
					//alert(shopingcart);
				}
			}
	});
}


 function quickView(id,idList)
{
    //var price=specific_price.substring(3);
    var val=1;
    var type=8;
    var dataparam = '&product_id=' + id + '&type=' + type+'&id_customer='+id_customer ;

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-PurchaseList.php',
        data: dataparam,
        cache: true,
        success: function(data) 
		{
			
			var str=data.description_short;
			if(str)
			{
				
				str = str.replace(/(<([^>]+)>)/ig,"");
				str = jQuery.trim(str).substring(0, 220).trim(this);
			}
			else
				var str = "";
                if($("#qty_"+id).val()>0)
                {
                    val=$("#qty_"+id).val();
                }
            
            var old_price=data[5];
            if(data[5].substring(3) ==data[3].substring(3))
            {
                old_price="";
            }
            $("#modal-id").addClass("quickviewpurchaselist");
            if(data[3] == "\u20b9 0.00" || data[3] == "Rs. 0.00" || data[3] == "&#8377; 0.00" || data[3] == "₹  0.00" || data[3] == "₹ 0.00")
             {
                old_price="";
                data[3] = "Contact for price";
				$('.quickView_carousel_buttons').addClass('hidden');
             }
            $("#id_quick").html("<a class='quickViewClose' onclick='closeQuickView();'><button class='close' aria-hidden='true' data-dismiss='modal' type='button'>×</button></a><div class='quickviewpurchaselistleft'><div class='quickViewproductimglink'><img src="+data[0]+"></div><div class='quickviewpurchaselistdesc'>"+str+"</div></div><div class='quickviewpurchaselistright' ><h3 class='quickviewheader'>"+data.name+"</h3><div id='quickviewsec'><div id='Manufactured-id'><span>Manufactured by:</span><span class='data'>"+data[1]+"</span></div><br><div class='product_code'><span>Product Code:</span><span class='data'>"+data.reference+"</span></div><br></div><div id='price_section'><div class='quick_price'><span class='span_float_left' ><h5 class='old_price'>"+old_price+"</h5>"+data[3]+"</span></span><span id='quick-label' class='text-muted search-nolist'></span></div></div><div id='Addtolist' ></div><div class='quickView_carousel_buttons col-md-12'><div id='quick_quantity' class='col-md-6' ><label class='col-md-6' id='quick_quantity_div'>QTY: </label><input type='text' onkeydown='numbersOnly(event)' class='quickView_quantity_wanted col-md-6' maxlength='5' size='4' value='"+val+"'><label id='error_qty'></label><label class='txt-bottom col-md-12'>Minimum quantity:"+data['minimal_quantity']+"</label></div><label id='quick_button' class='col-md-6' onclick='addToCart(0,"+data.id_product+")'><span class='fa fa-shopping-cart quick_cart'></span> <label id='quick_buynow'>Buy Now</label></label></div><div align='center' class='col-md-12 mar_width_10'><label class='btn btn-primary col-md-5 marg_width_25' onClick='bulkEnquiry(\""+data.name+"\","+data.id_product+");' >Bulk Enquiry</label></div><div id='quick_call2buy' class='col-md-12'>Contact your Relationship Manager for any queries</div></div> <div id='quick_bottom'><div id='quick_gen'><span id='static_100' style='color:#7f7f7f;'>100% GENUINE & BRAND NEW PRODUCTS</span></div><div id='quick_ship'><span='static_ship' style='color:#7f7f7f;'>FREE SHIPPING FOR ALL CORPORATE CUSTOMER</span></div></div> </div>");

            if(idList==2)
            {
                $("#change_state_poi").removeClass("fa fa-question-circle cur-poi");
            }
            
            if(data[3] === "Contact for price")
            {
                 old_price="";
                $("#quick_button").css('display','none');
                $("#quick-label").css('display','none');
                $(".quickView_carousel_buttons").css('display','none');
            }

            $("#quick-label").html('<label class="label_left">Tax Exclusive Price:</label><label class="label_right">'+data[4]+'</label> <br><label class="label_left"> Tax Amount: </label><label class="label_right">Rs.'+(parseFloat(data[3].substring(3).replace(",",""))-parseFloat(data[4].substring(3).replace(",",""))).toFixed(2)+'</label><br><label class="label_left"> Total Price:</label><label class="label_right">'+data[3]+'</label>');
            $('#quick_msg').modal('show');
            if(!data[1])
            {
                $('#Manufactured-id').html('');
            }
            /*if(data[2]==1)
            {
                $('#Addtolist').html('');
                $('#Addtolist').addClass("search-nolist");
                $('#Addtolist').html('Product is already added in your List');
            }
            else
            {
                showPruchaseList(data.id_product);
            }*/
            if(data['available_for_order']==0)
            {
                $("#quick_quantity").html('Out Of Stock');
                 $("#quick_quantity").addClass("txt-quick-center");
                $("#quick_button").css("display","none");
            }
            val=1;
        }
    });

}
function getQuote()
{
    $("#blk_price_err").hide();
    $("#blk_qty_err").hide();
    $("#blk-credit-error").hide();
    $("#blk-pin-code-error").hide();

    var bq_target_price=$("#blk_enqry_price").val();
    var bq_quantity=$("#blk_enqry_qty").val();
    var bq_qty_unit=$("#blk_enqry_units option:selected").val();
    var bq_other_details=$("#blk_enqry_textarea").val();
    var bq_credit =$("input[name=creditFacility]:checked").val()
    var bq_pincode=bqValidatePinCode();
    var id_product=$("#pName").val();
    var product_name=$("#pName").html();


    if(!bq_quantity || bq_quantity=='')
    {
        $("#blk_qty_err").show();
        return false;
    }
    if(!bq_target_price || bq_target_price=='')
    {
        $("#blk_price_err").show();
        return false;
    }
    if(!bq_credit || bq_credit=='')
    {
        $("#blk-credit-error").show();
        return false;
    }
    if(!bq_pincode || bq_pincode=='')
    {
        $("#blk-pin-code-error").show();
        return false;
    }

    dataparam='ajax=true&logged=1&bq_select_price=inr&bq_target_price='+bq_target_price+'&bq_quantity='+bq_quantity+'&bq_qty_unit='+bq_qty_unit+'&bq_pincode='+bq_pincode+'&bq_credit='+bq_credit+'&bq_other_details='+bq_other_details+'&id_product='+id_product+'&product_name='+product_name+'&bq_id_customer='+id_customer;
    $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            url:'bqProcessRequest.php',
            data: dataparam,
            cache: true,
            success: function(data)
            {
                if(data==1)
                {
                    $("#blkQuery").modal("hide");
                    kobsterEdge();
                }

            }

    });
}
function kobsterEdge()
{
    $("#kobsterEdge").modal('show');
}
function bqComplete()
{
    $("#kobsterEdge").modal('hide');
}
function bqValidatePinCode()
{
    if($('#blk_enqry_pincode').val() && $.isNumeric($('#blk_enqry_pincode').val()) && $('#blk_enqry_pincode').val().length == 6)
    {
        $('#blk-pin-code-error').hide();
        return $('#blk_enqry_pincode').val();
    }
    else
    {
        $('#blk-pin-code-error').show();
        return false;
    }
}
function showPruchaseList(idProduct)
{
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
                if(data=='')
                {
                    alertmsg="No PurchaseList found"
                }
                else
                {
                    alertmsg="<select class='btn btn-white dropdown-toggle' id='selectoptionpurlist'><option>Select List</option>";
                    for(var k=0 ; data.length>k; k++)
                    {
                        if(data[k].list_active==1)
                        {
                            alertmsg +=" <option id="+data[k].id_list+">"+data[k].listname+"</option>";
                        }
                    }
                    alertmsg+="</select><button id='selectpurlist' class='btn btn-success' onclick='addpurlist("+idProduct+");'>Add to List</button>";


                }
                $('#Addtolist').html(alertmsg);
            }
        });
}
function bulkEnquiry(pname,id)
{
    closeQuickView();
    $("#blkQuery").modal('show');
    $("#pName").html(pname);
    $("#pName").val(id);

    $("#blk_price_err").hide();
    $("#blk_qty_err").hide();
    $("#blk-credit-error").hide();
    $("#blk-pin-code-error").hide();

}
function addpurlist(idProduct){

    var id=$('#selectoptionpurlist option:selected').attr('id');
     if(!id)
    {
        return false;
    }
    var dataparam = '&id_product='+idProduct+'&id_customer='+id_customer+'&id_list='+id+'&type=3';
    $.ajax({
        type: 'POST',
        async: true,
        url: 'rm-addtorate.php',
        data: dataparam,
        success: function(data)
        {
            closeQuickView();
            var alertmsg="Product added to list Successfully";
            $("#id_alert").html(alertmsg);
            $('#alert_msg').modal('show');
        }
    });
}
function closeQuickView()
{
	$('#quick_msg').modal('hide');
}
function toUpdatePrice(productId)
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

							var discount_value = (jsonData[0][5][j].value).split(' ');
                            discountValue = discount_value[0];
                            discountValue = discountValue.replace(',',"");
                            discountValue += parseFloat(discount_value[0]);
                            discountids.push(jsonData[0][5][j].id_cart_rule);

						}
					}
					else
					{
						var discountValue=0;
					}
					//$("#cart-product-price").html("<div class='pull-left '><span><input type='text' value='' placeholder='Enter Voucher Code' id='name_vouchercode' name='name_vouchercode' /></span><span id='voucher_apply' class='btn btn-info btn-xs' onclick='addDiscount(0,1);'>Apply</span>&nbsp;/&nbsp;<span class='btn btn-info btn-xs'id='voucherCount' onclick=openVoucher();>View Vouchers</span><div class='upload_block_po'><span><input type='file' name='uploadFile' id='uploadFile'><span><input type='text' value='' id='name_upload_po' placeholder='Upload Your PO' name='name_upload_po' />&nbsp;&nbsp;<span><input type='submit' id='po_upload' class='btn btn-info btn-xs' name='send_qutoes_detail' value='Upload'/></span></div> </div><div class='priceincart'><span  class='price-margin-right'><i class=''></i>Discount :</span><span class='price-font'> "+discountValue.toFixed(2)+" </span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'>Rs 0.00</span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-money total-money'></i>Tax :</span><span class='price-font'>Rs. "+jsonData[0][4]+"</span></div><br/><div class='priceincart'><span  class='price-margin-right' ><i class='fa fa-money total-money'></i>Total :</span><div class='price-font'> "+jsonData[0][3]+"</div></div>");
					var currency = (jsonData[0][4]).split(' ');
                    $('#discount').html(currency[0]+" "+parseFloat(discountValue));
					loyalty_points = jsonData[0][6];
					$('#shopping-cost').html(currency[0]+" "+'0.00');
					$('#tax').html(jsonData[0][4]);
					$('#loyalty_points_summary').html(jsonData[0][6]);
					$('#loyalty_points').html(jsonData[0][6]);
					$('#total-shopping-cost').html(jsonData[0][3]);
					$(".shopping_Total").html(jsonData[0][3]);
					$("#shopping_loyalty_points_rm").html(jsonData[0][6]);
					$('#uploadFile').hide();
					$("#points_display").append(jsonData[0][6]);

 				}
				loadShopingCart(true);
				}
	});


}
$(document).ready(function(){
			var $zoho= $zoho || {livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);
		});

function cataloguelist()
{
	ordering_type = 7;
    $('#index_viewport').html('');
    $("#index_viewport").load("dash-place-order-steps.php", function() {
        $('#wizard-p-0').load('dash/dash-cataloguelist.tpl');
        //loadShopingCart();
    });
}
