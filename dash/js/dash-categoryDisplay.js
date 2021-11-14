  $(document).ready(function() {

				//var dataparam = '&id_customer=' + id_customer;
				 	var type=7;
	var dataparam = '&type='+type+'&customerid='+id_customer;
	window.d1 =[[]];
	window.ticksValue=[[]];
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				//url: 'dash-customer-report.php',
				url: 'dash-reports.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					var str='';
					var li='';
					var deal='';
					ordering_type=1;
					if(data[3].length>0)
					{
						if(data[3][0].reduction!=0)
						{
							if(data[3][0].reduction_type=="amount")
							{
								deal="Rs. "+parseFloat(data[3][0].reduction).toFixed(2)+" off";
							}
							else if(data[3][0].reduction_type=="percentage")
							{
								deal=data[3][0].reduction*100+"% off";
							}
						}
						else
						{
							deal="Save Rs."+(parseFloat(data[3][0].actualPrice)-parseFloat(data[3][0].price)).toFixed(2);
						}
						var pieces = data[3][0].to.substring(0,10).split('-');
						pieces.reverse();
						var reversedDate = pieces.join('-');
						str ="<div class='item text-center active'><div id='deal_img' class='cur-poi' onclick='quickView("+data[3][0].id_product+",0)'><img src="+data[3][0].image+"></div><div id='left_div' class='cur-poi' onclick='quickView("+data[3][0].id_product+",0)'><h5>"+data[3][0].name.substring(0, 50)+"</h5><div id='deal_price' align='center'>"+deal+"</div><p class='valid'>Ends On: "+reversedDate+"</p></div></div>";
						//li="<li data-target='#c-slide' data-slide-to='0' ></li>";
						if(data[3].length>1)
						{	for(var k=1; k<data[3].length; k++)
							{
								if(data[3][k].reduction!=0)
								{
									if(data[3][k].reduction_type=="amount")
									{
										deal="Rs. "+parseFloat(data[3][k].reduction).toFixed(2)+" off";
									}
									else if(data[3][k].reduction_type=="percentage")
									{
										deal=data[3][k].reduction*100+"% off";
									}
								}
								else
								{
									deal="Save Rs."+(parseFloat(data[3][0].actualPrice)-parseFloat(data[3][0].price)).toFixed(2);
								}
								var pieces = data[3][k].to.substring(0,10).split('-');
								pieces.reverse();
								var reversedDate = pieces.join('-');
								//li +="<li data-target='#c-slide' data-slide-to='"+k+"' ></li>";
								str +="<div class='item text-center'><div id='deal_img' class='cur-poi' onclick='quickView("+data[3][k].id_product+",0)'><img src="+data[3][k].image+"></div><div id='left_div' class='cur-poi' onclick='quickView("+data[3][k].id_product+",0)'><h5>"+data[3][k].name.substring(0, 50)+"</h5><div id='deal_price' align='center'>"+deal+"</div><p class='valid'>Ends On: "+reversedDate+"</p></div></div>";
							}
						}
						//$("#top-products-div").html("<div id='deal_head' align='center'>Special Offer</div><div id='deal_img'><img src="+data[3][1]+"></div><div id='left_div'><h5>"+data[3][0].name.substring(0, 50)+"</h5><div id='deal_price' align='center'>Rs."+parseFloat(data[3][0]['price']).toFixed(2)+"</div><div id='buy_deal'><input type='text' class='quickView_quantity_wanted' onkeydown='numbersOnly(event)' maxlength='5' size='2' value='1' class='col-md-4 inp_search' id='inp_1'><span onclick=' addToCart(0,"+data[3][0].id_product+")' class='col-md-6 fa fa-shopping-cart btn btn-primary deal_btn'><span class='quick-btn-label'>Buy Now</span></span></div></div>");

					}
					if(data[4].length>0)
					{
						var discount='';
						/*for(var j=data[3].length;j<(data[4].length+data[3].length);j++)
						{
							li +="<li data-target='#c-slide' data-slide-to='"+j+"' ></li>";
						}*/
						if(data[3].length==0)
						{
							if(data[4][0].id_discount_type==2)
							{
								discount="Rs. "+data[4][0].value+" OFF";
							}
							else if(data[4][0].id_discount_type==1)
							{
								discount=parseInt(data[4][0].value)+"% OFF";
							}
							//str +="<div class='item text-center active'><div id='deal_img' class='cur-poi offer_area' onClick='voucherView(\""+data[4][0].name+"\","+data[4][0].value+",\""+data[4][0].type+"\",\""+data[4][0].description+"\",\""+data[4][0].date_to+"\","+data[4][0].id_discount_type+")' ><img width='75px' src='"+baseDir+"img/coupon-24px.svg' ></div><div id='left_div_voucher' class='cur-poi' onClick='voucherView(\""+data[4][0].name+"\","+data[4][0].value+",\""+data[4][0].type+"\",\""+data[4][0].description+"\",\""+data[4][0].date_to+"\","+data[4][0].id_discount_type+")' ><h4>PromoCode</h4><h5>"+data[4][0].name+"</h5><h6> Use this code and get <h5>"+discount+"</h5></h6><p>*Condition Apply</p></div></div>";
							str +="<div class='item text-center dealImg active'><img  onClick='voucherView(\""+data[4][0].code+"\","+data[4][0].value+",\""+discount+"\",\""+data[4][0].description+"\",\""+data[4][0].date_to+"\","+data[4][0].id_discount_type+")' class='PromoCode cur-poi' src='"+baseDir+"img/voucher0101.png' /><div class='dealDisc'> Promocode: "+data[4][0].code+"</div><div class='dealWrapper cur-poi' onClick='voucherView(\""+data[4][0].code+"\","+data[4][0].value+",\""+discount+"\",\""+data[4][0].description+"\",\""+data[4][0].date_to+"\","+data[4][0].id_discount_type+")'>"+discount+"</div><div class='conditionApply'>*Conditions Apply</div></div>";
							for(var i=1;i<data[4].length;i++)
							{

								if(data[4][i].id_discount_type==2)
								{
									discount="Rs. "+data[4][i].value+" OFF";
								}
								else if(data[4][i].id_discount_type==1)
								{
									discount=parseInt(data[4][i].value)+"% OFF";
								}
								
								//str +="<div class='item text-center'><div id='deal_img' class='cur-poi offer_area ' onClick='voucherView(\""+data[4][i].name+"\","+data[4][i].value+",\""+data[4][i].type+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")' ><img width='75px' src='"+baseDir+"img/coupon-24px.svg' ></div><div id='left_div_voucher' class='cur-poi' onClick='voucherView(\""+data[4][i].name+"\","+data[4][i].value+",\""+data[4][i].type+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")'><h4>PromoCode</h4><h5>"+data[4][i].name+"</h5><h6> Use this code and get <h5>"+discount+"</h5></h6><p>*Condition Apply</p></div></div>";
								str +="<div class='item text-center dealImg'><img  onClick='voucherView(\""+data[4][i].code+"\","+data[4][i].value+",\""+discount+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")' class='PromoCode cur-poi' src='"+baseDir+"img/voucher0101.png' /><div class='dealDisc'> Promocode: "+data[4][i].code+"</div><div class='dealWrapper cur-poi' onClick='voucherView(\""+data[4][i].code+"\","+data[4][i].value+",\""+discount+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")'>"+discount+"</div><div class='conditionApply'>*Conditions Apply</div></div>";
							}
						}
						else
						{
							for(var i=0;i<data[4].length;i++)
							{
								if(data[4][i].id_discount_type==2)
								{
									discount="Rs. "+data[4][i].value+" OFF";
								}
								else if(data[4][i].id_discount_type==1)
								{
									discount=data[4][i].value+"% OFF";
								}
								/*str +="<div class='item text-center'><div id='deal_img' class='cur-poi offer_area' onClick='voucherView(\""+data[4][i].name+"\","+data[4][i].value+",\""+data[4][i].type+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")'><img width='75px' src='"+baseDir+"img/coupon-24px.svg' ></div><div id='left_div_voucher' class='cur-poi' onClick='voucherView(\""+data[4][i].name+"\","+data[4][i].value+",\""+data[4][i].type+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")' ><h4>PromoCode</h4><h5>"+data[4][i].name+"</h5><h6> Use this code and get <h5>"+discount+"</h5></h6><p>*Condition Apply</p></div></div>";*/
								str +="<div class='item text-center dealImg'><img  onClick='voucherView(\""+data[4][i].code+"\","+data[4][i].value+",\""+discount+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")' class='PromoCode cur-poi' src='"+baseDir+"img/voucher0101.png' /><div class='dealDisc'> Promocode: "+data[4][i].code+"</div><div class='dealWrapper cur-poi' onClick='voucherView(\""+data[4][i].code+"\","+data[4][i].value+",\""+discount+"\",\""+data[4][i].description+"\",\""+data[4][i].date_to+"\","+data[4][i].id_discount_type+")'>"+discount+"</div><div class='conditionApply'>*Conditions Apply</div></div>";
							}
						}

					}
					if((data[3].length>0) || (data[4].length>0))
					{
						$("#top-products-div").html("<div class='panel-head ' id='deal_head' align='center'><div class='grid-header'>Special Offers</div><img class='blink' id='offer_img' src='"+baseDir+"img/offer_image.png'></div><div class='carousel slide auto' id='c-slide'><ol class='carousel-indicators out'>"+li+"</ol><div class='carousel-inner'>"+str+"</div><a class='left carousel-control' href='#c-slide' data-slide='prev'><i class='fa fa-angle-left'></i></a><a class='right carousel-control' href='#c-slide' data-slide='next'><i class='fa fa-angle-right'></i></a></div>");
					}
 				var largeValue;
				if(data[0]==""|| data[0]==null)
					 {
        				return false;
    					}
						else
						{
				for(var i=0;i<data[0].length;i++)
					{

						var temp;
						/*temp=parseFloat(data[0][i][2]);
						 d1[i]=[i+1,temp];*/
						temp=parseFloat(data[0][i].indexLabel);
						var name=['test','test','test','test','test','test'];
						 d1[i]=[i+1,temp,name];
						 ticksValue[i]=[i+1,(data[0][i].label).substring(0,3)];
					}
					drawChart(d1,ticksValue);
						}
					var officStationery=0,houseKeeping=0,officeElectronics=0,others=0;
						if(data[1]==""|| data[1]==null)
					 {
        				return false;
    					}
						else
						{
					for(var j=0;j<data[1].length;j++)
								{
									if(data[1][j].indexLabel=="Office Stationery")
									{
										officStationery=parseFloat(data[1][j].y);

									}
									else if(data[1][j].indexLabel=="Office Electronics")
									{
										officeElectronics=parseFloat(data[1][j].y);
									}
									else if(data[1][j].indexLabel=="House Keeping Supplies")
									{
										houseKeeping=parseFloat(data[1][j].y);
									}
									else
									{
										others+=parseFloat(data[1][j].y);
									}
								}
								var pieData=[officStationery,officeElectronics,houseKeeping,others];

						size(true,pieData,"pie-chart-js");
						}
									if(data[2]==""|| data[2]==null)
					 {
        				return false;
    					}
						else
						{
								largeValue=parseInt(data[2][0].y);
								if(data[2].length<5)
								{
									return false;
								}
								for(var j=0;j<5;j++)
								{
									if(largeValue<data[2][j].y)
									{
										largeValue=parseInt(data[2][j].y);
									}
								}
								var average=largeValue/5;
								var total=average+largeValue;
								var firstProduct,secondProduct,thirdProduct,fourthProduct,fifthProduct;
								firstProduct=(parseInt(data[2][0].y)/total)*100;
								secondProduct=(parseInt(data[2][1].y)/total)*100;
								thirdProduct=(parseInt(data[2][2].y)/total)*100;
								fourthProduct=(parseInt(data[2][3].y)/total)*100;
								fifthProduct=(parseInt(data[2][4].y)/total)*100;
					 $("#top-products-div").html("<h5 class='bold-font'>Your Top 5 Products</h5><div class='bar-stats bar-chart-height bar-margin-top'><ul class='progress-stat-bar  clearfix'> <li class='progress-stat-bar-height'><span class='progress-stat-percent progress-stat-percent-max-height pink' style='height:"+firstProduct+"px;'></span></li><li class='progress-stat-bar-height'><span class='progress-stat-percent progress-stat-percent-max-height' style='height:"+secondProduct+"px;'></span></li><li class='progress-stat-bar-height'><span class='progress-stat-percent lightred progress-stat-percent-max-height' style='height:"+thirdProduct+"px;'></span></li><li class='progress-stat-bar-height' ><span class='progress-stat-percent lightblue progress-stat-percent-max-height' style='height:"+fourthProduct+"px;'></span></li><li class='progress-stat-bar-height'><span class='progress-stat-percent yellow-b progress-stat-percent-max-height' style='height:"+fifthProduct+"px;'></span></li></ul><ul class='bar-legend'><li><span class='bar-legend-pointer pink'></span>"+data[2][0].name+" </li><li><span class='bar-legend-pointer green'></span>"+data[2][1].name+"</li><li><span class='bar-legend-pointer lightred'></span>"+data[2][2].name+"</li><li><span class='bar-legend-pointer lightblue'></span>"+data[2][3].name+"</li><li><span class='bar-legend-pointer yellow-b'></span>"+data[2][4].name+"</li></ul></div>");
						}
				}
			});


});
  function voucherView(code,value,valueType,Description,date,disctype)
  {  	
  	$('#voucher-id').html('');
  	var pieces =date.substring(0,10).split('-');
	pieces.reverse();
	var toDate = pieces.join('-');
  	var discount='';
  	if(disctype==2)
	{
		discount="Rs. "+value;
	}
	else if(disctype==1)
	{
		discount=value+"%";
	}
  	var query="<div align='center'><h3>Voucher Details</h3></div><div class='voucherDiv'><div class='voucherLeft'>PromoCode :</div><div class='voucherRight'>"+code+"</div></div><div class='voucherDiv'><div class='voucherLeft'>Offer :</div><div class='voucherRight'>"+discount+"</div></div><div class='voucherDiv'><div class='voucherLeft'>Offer Type</div><div class='voucherRight'>"+valueType+"</div></div><div class='voucherDiv'><div class='voucherLeft'>Description :</div><div class='voucherRight'>"+Description+"</div></div><div class='voucherDiv'><div class='voucherLeft'>Available Upto :</div><div class='voucherRight'>"+toDate+"</div></div>";
  	$("#voucherId").html("<a class='quickViewClose' onclick='$('#voucherDetails').modal('hide');'><button class='close' aria-hidden='true' data-dismiss='modal' type='button'>×</button></a>");
  	$('#voucher-id').append(query);
	$('#voucherDetails').modal('show');
  }
 function drawChart(d1,ticksValue) {
		if ($.fn.plot) {

            var data = ([{
                label: "Order Value",
                data: d1,
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    fillColor: {
                        colors: ["rgba(255,255,255,.1)", "rgba(160,220,220,.8)"]
                    }
                }
            }]);
            var options = {
                grid: {
                    backgroundColor: {
                        colors: ["#fff", "#fff"]
                    },
                    borderWidth: 0,
                    borderColor: "#f0f0f0",
                    margin: 0,
                    minBorderMargin: 0,
                    labelMargin: 20,
                    hoverable: true,
                    clickable: true
                },
                // Tooltip
                tooltip: true,
                tooltipOpts: {
                    content: "Rs.%y",
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: false
                },

                legend: {
                    labelBoxBorderColor: "#ccc",
                    show: false,
                    noColumns: 0
                },
                series: {
                    stack: true,
                    shadowSize: 0,
                    highlightColor: 'rgba(30,120,120,.5)'

                },
                xaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    show: true,
                    min: 1,
					ticks: ticksValue,

                    font: {

                        style: "normal",


                        color: "#666666"
                    }
                },
                yaxis: {
                    ticks: 3,
                    tickDecimals: 0,
                    show: true,
                    tickColor: "#f0f0f0",
                    font: {

                        style: "normal",


                        color: "#666666"
                    }
                },
                //        lines: {
                //            show: true,
                //            fill: true
                //
                //        },
                points: {
                    show: true,
                    radius: 2,
                    symbol: "circle"
                },
                colors: ["#87cfcb", "#48a9a7"]
            };
            var plot = $.plot($("#daily-visit-chart"), data, options);
        }

	}

    var t;
    function size(animate,pieData, canvasId){
        if (animate == undefined){
            animate = false;
        }
        clearTimeout(t);
        t = setTimeout(function(){
            $("#"+canvasId).each(function(i,el){
                $(el).attr({
                    "width":$(el).parent().width(),
                    "height":$(el).parent().outerHeight()
                });
            });
            redraw(animate,pieData);
            var m = 0;
            $(".chartJS").height("");
            $(".chartJS").each(function(i,el){ m = Math.max(m,$(el).height()); });
            $(".chartJS").height(m);
        }, 30);
    }
  //  $(window).on('resize', function(){ size(false); });


    function redraw(animation,pieData){
		var options = {};
        if (!animation){
            options.animation = false;
        } else {
            options.animation = true;
		}



        var pieChartData = [
            {
                value:parseInt(pieData[0]),
                color:"#E67A77"
            },
            {
                value : parseInt(pieData[1]),
                color : "#D9DD81"
            },
            {
                value :parseInt( pieData[2]),
                color : "#79D1CF"
            },
			{
				   value :parseInt( pieData[3]),
                color : "#9972b5"
			}


        ];
	    var myPie = new Chart(document.getElementById("pie-chart-js").getContext("2d")).Pie(pieChartData);
	}
$(function()
{
	imagePath="img/1.jpg";
	$("#corporatelogo").attr("src",imagePath);
});
$(function()
{
 		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-relationship-manager.php',
			data: {id_customer:id_customer,type:0},
 			cache: true,
 			success: function(data)
			{

				if(data=="" || data=="null")
					 {

        				return false;
    					}
						else
						{
					$("#relationship-manager-name-ali").append(data[0].firstname+"&nbsp;"+data[0].lastname);
					$("#relationship-manager-email-ali").append("<a href='mailto:"+data[0].email+"'>"+data[0].email+"</a>");
					$("#relationship-manager-phone-ali").append("<a href='tel:"+data[0].phone+"'>"+data[0].phone+"</a>");
			}
			}
	});

  	if(role == 1 || role == 0)
	{

		var type=5;
		var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+4;/*+'&orderid='+orderid*/;
		 $.ajax({
				type: 'POST',
				async: false,
				dataType:'json',
				url: 'dash-reports.php',
				data: dataparam,
				cache: false,
				success: function(data)
				{
					if(data=="" || data=="null")
						{
							return false;
						}
						else
						{
				$("#top-5-products").html("");
				if(data.length<4)
				{
					var img_link="";
					for(var i=0;i<data.length;i++)
					{
						if (data[i][0].indexOf('http') > -1) 
						{
							img_link = data[i][0];
						} 
						else 
						{
							img_link ="http://"+data[i][0];
						}
						prod_price="Rs."+data[i].price;
						 if( data[i].quantity <=0 && data[i].out_of_stock !=0 || data[i].quantity >=0 && data[i].out_of_stock !=0)
								$("#top-5-products").append("<div class='price-change-value-div col-md-12 col-lg-12'><div class='float-left col-md-2 padding-align-left  padding-align-right'><img src='"+img_link+"'></div ><div class='col-md-5'><div class='price-change-value-name col-md-12   padding-align-left  top-product-align  padding-align-right cur-poi' onclick='quickView("+data[i].id_product+",0)' >"+data[i].name+"</div><div class='col-md-12 top-product-price  padding-align-left  padding-align-right'><span>Rs."+data[i][1].toFixed(2)+"</span></div></div><div class='col-md-2 padding-align-left  padding-align-right'><input type='text' value='1' id='quantity_"+i+"' onkeydown='numbersOnly(event)' class='tex-ali-cen qv_quantity_wanted' class='quantity-change-value col-md-6 padding-align-left  top-product-align padding-align-right' class='qv_quantity_wanted' maxlength='5' size='3'></div><div class='col-md-3 left_align_buynow'><span><a onClick='topProductBuyNow("+data[i].id_product+","+i+");' class='btn btn-primary kob_button top-product-buy-now' >Buy Now</a></span></div></div>");
					}
				}
				else
				{
					for(var i=0;i<4;i++)
					{
						prod_price="Rs."+data[i].price;
						if( data[i].quantity <=0 && data[i].out_of_stock !=0 || data[i].quantity >=0 && data[i].out_of_stock !=0)
							$("#top-5-products").append("<div class='price-change-value-div col-md-12'><div class='col-md-2 col-xs-2 product-image'><img src='"+data[i][0]+"'></div ><div class='col-md-5 col-xs-5'><div class='price-change-value-name cur-poi' onclick='quickView("+data[i].id_product+",0)'>"+data[i].name+"</div><div class=''><span>Rs."+data[i][1].toFixed(2)+"</span></div></div><div class='col-md-2 col-xs-2 add-product-qty'><input type='text' value='1' id='quantity_"+i+"' onkeydown='numbersOnly(event)' class='tex-ali-cen qv_quantity_wanted' class='quantity-change-value col-md-6' class='qv_quantity_wanted' maxlength='5' size='3'></div><div class='col-md-3 col-xs-3 buynow-btn'><span><a onClick='topProductBuyNow("+data[i].id_product+","+i+");' class='btn btn-primary kob_button top-product-buy-now' >Buy Now</a></span></div></div>");
					}

				}
				}
				}
		 });
	}
	else
	{
  		var type =7;
		var dataparam= '&type='+type+'&customerid='+id_customer;
 		 $.ajax({
					type: 'POST',
					async: false,
					dataType:'json',
					url: 'dash-history.php',
					data: dataparam,
					cache: false,
					success: function(data)
					{
 						for(var i=0;i<data.length;i++)
							$("#child_orders").append("<tr id='child_order_"+data[i].id_order+"'><td><a  onclick='getStatusDetails("+data[i].id_order+","+data[i].delivery+","+data[i].invoice+")' href='#status_history' data-toggle='modal'>"+data[i].id_order+"</a></td><td>"+data[i].firstname+"</td><td>"+data[i].date_add+"</td><td class='table-actions'><a title='Approve Order'><i class='fa fa-check text-success cur-poi' onclick='paymentMode("+data[i].id_order+");' id='success_child_order_"+data[i].id_order+"'></i></a><a title='Revise Order'  href='#revise_order_approver' data-toggle='modal'><i class='fa fa-retweet text-warning cur-poi' onClick='setOrderId("+data[i].id_order+");'  id='revies_child_order_"+data[i].id_order+"'></i></a><a title='Cancel Order'  href='#cancel_order_approver' data-toggle='modal'><i class='fa fa-times text-danger cur-poi' onclick='setOrderId("+data[i].id_order+");' id='cancel_child_order_"+data[i].id_order+"'></i></a></td><tr>");
					}
				});
	}
});
function topProductBuyNow(productId,qty)
{

	ordering_type=0//represent the page type for back purpose
	//ajaxCart.add(productId, null, false, this,1, null);
	/*load shopping cart by default*/
 	var type=7;
		var quick_qty = $('#quantity_'+qty).attr("value");
		var dataparam = '&quick_idProduct='+productId+'&quick_qty='+quick_qty+'&type='+type;
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
 				//$('#error_alert').append("<div><span>1)</span><span>"+data.name+"</span></div>");
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


			$('.qv_quantity_wanted').val('1');
			if(quick_qty<=0)//validates the quantity
			{
				var alertmsg = "Enter a valid Quantity";
				$("#id_alert").html(alertmsg);
				$('#alert_msg').modal('show');
				return false;
			}

		}
	});


	/*$('#index_viewport').html('');
	$('#index_viewport').load("dash-displayaddress.php");*/
	}
	function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
		e.preventDefault();
	}
}
function paymentMode(order_id)
{
	var type=1;
	$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{id_customer:id_customer,type:type},
			success: function(jsonData)
			{
				$('#index_payment_option').html('');

				for(var i=0;i<jsonData.length;i++)
				{
					if(jsonData[i].id_payment==1)
  						$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin width22' ><a  class='' onclick='approver_paymentMode(1,"+order_id+");'><img src='dash/images/cod2.png'/><br/><span>Cash on <br/> Delivery</span></a></div>");

 					else if(jsonData[i].id_payment==2)
 						$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin width22' ><a  class='' onclick='approver_paymentMode(2,"+order_id+");'><img src='dash/images/cheque_icon.png'/><br/><span>Cheque</span></a></div>");

  					else if(jsonData[i].id_payment==3)
 						$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin width22' ><a  class='' onclick='approver_paymentMode(3,"+order_id+");'><img src='dash/images/neft2.png'/><br/><span>NEFT/RETG</span></a></div>");

 					else if(jsonData[i].id_payment==4)
 							$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin width22' ><a  class='' onclick='approver_paymentMode(4,"+order_id+");'><img src='dash/images/net_pay.png'/><br/><span>Card Payment</span></a></div>");
					else if(jsonData[i].id_payment==5)//user=>creater, id_role =>1
 							$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='approver_paymentMode(5,"+order_id+");'><br/><span class='btn btn-primary'>Send Order for Approval</span></a></div>");
 					else if(jsonData[i].id_payment==6)
 							$("#index_payment_option").append("<div id='payment_options"+i+"' class='payment-option-margin width22' ><a  class='' onclick='approver_paymentMode(6,"+order_id+");'><img src='dash/images/credit-payment.png'/><br/><span>Credit</span></a></div>");
 				}
				$("#choose_payment").modal('show');
			}
			});
		/*var type=1;
 		var dataparam = '&orderid='+order_id+'&id_customer='+id_customer+'&type='+type;
  		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url:'dash-approve.php',
			data: dataparam,
			cache: false,
			success: function(data)
				{
					 $("#child_order_"+order_id).remove();
					$("#id_alert").html("Order Approved Successfully");
					$('#alert_msg').modal('show');

				}
			});*/

}
function setOrderId(order_id)
{
	$("#cancel_reason").val('');
	$("#hide_order_id").val(order_id);
	//$("#cancel_order_approver").modal('show');

}

function cancelOrderApprover()
{

	var order_id = $("#hide_order_id").val();
	var cancel_reason = $("#cancel_reason").val();
	if(cancel_reason == "")
		cancel_reason="0";
	var type=2;
	var dataparam = '&orderid='+order_id+'&id_customer='+id_customer+'&type='+type+'&cancel_reason='+cancel_reason;
  	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url:'dash-approve.php',
		data: dataparam,
		cache: false,
		success: function(data)
			{
				getCustomerOrderDetails();
				$("#cancel_order_approver").modal('hide');
				$("#child_order_"+order_id).remove();
				$("#id_alert").html("Order Cancelled Successfully");
				$('#alert_msg').modal('show');
				getCustomerOrderDetails();
			}
		});
}
function approver_paymentMode(payment_type,order_id)
{
	var type=1;
	$("#choose_payment").modal('hide');
	if(payment_type !=4)
	{

		var dataparam = '&orderid='+order_id+'&id_customer='+id_customer+'&type='+type+'&payment_type='+payment_type;
		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url:'dash-approve.php',
			data: dataparam,
			cache: false,
			success: function(data)
				{

						$("#child_order_"+order_id).remove();
						$("#id_alert").html("Order Approved Successfully");
						$('#alert_msg').modal('show');
						getCustomerOrderDetails();
				}
			});
	}
	else
	{
		$("#choose_payment").modal('hide');
 		creater_order_approver = 1;//global var declare in index.js for diff the payment whether approver pay for his/her child user
		creater_order_no=order_id;

		$('#hidden-info').load('dash-EBS.php');
		getCustomerOrderDetails();

	}
}
function reviesOrderApprover()
{
	var order_id = $("#hide_order_id").val();
	var type=3;

	var dataparam = '&orderid='+order_id+'&type='+type+'&id_customer='+id_customer;
	$.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-approve.php',
        data: dataparam,
        cache: true,
        success: function(data) {
  			loadShopingCart();
			$('#revise_order_approver').modal('hide');
 				 $("#index_viewport").load("dash-place-order-steps.php", function()
				 {
					$('#wizard-p-0').load('dash-quickbuy.php');
					$(".shoppingcart").click();
                    $('.actions').hide();
				 });
 			}
		});


}
