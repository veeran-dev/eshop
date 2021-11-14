var Pagination = 0, page_size = 20, product_count=0, categoryid=0;  
$(document).ready(function()
{
 	customerProductList(0);
});
function customerProductList(selected_category)
{	
	var parent_category_id = selected_category;
  	if(parent_category_id !=0)
		category_id = parent_category_id;
	else
		category_id = 0;
	
	var search_word = $("#search_rate_contract").val();
	if(search_word != "" )
		search_key_word = search_word;
	else
		search_key_word = "";
	var type=9;
	var dataparam = '&type=' + type + '&id_customer=' + id_customer+ '&Pagination=' + Pagination+ '&category_id=' + category_id+ '&search_key_word=' + search_key_word;
     $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'dash-PurchaseList.php',
        data: dataparam,
        cache: true,
        success: function(data)
		{
 			$('.loadMoreButton').remove();
  			if(data[1].length >0)
			{
				if(Pagination == 0)
				{
					$("#product_categories").html('');
					$("#product_categories").append("<li><a id='0' name='All Category' onclick='filterCategoryList(this);'>All Categories</a></li>");
					for(var j =0; data[1].length>j; j++)
					{
						$("#product_categories").append("<li><a id="+data[1][j].id_category+" name="+data[1][j].category+" onclick='filterCategoryList(this);'>"+data[1][j].category+"</a></li>");
					}
				}
			}
 			if(data[0].length >0)
			{
				/*if(selected_category ==0)
					$("#catalogue_list").html('');*/
					
 				for (var i = 0; i < data[0].length; i++) 
				{
					if(data[0][i].description_short)
					{
						var str = data[0][i].description_short;
						var str = str.replace(/(<([^>]+)>)/ig, "");
						if (str.length > 65) str = str.substring(0, 65) + "...";
						}
					else
						var str="";
					/*Product id and default value section*/
					var product_id = data[0][i].id_product;
					var price_value = "Rs. 0.00";
					
					/* Price and Inclusive tax price Section*/
					var tax = data[0][i].tax_value;
					//tax = tax.replace(/[^0-9\.]+/ig,"");
					var taxprice = data[0][i].price_tax_exc * tax / 100 ;
					var price = data[0][i].price_tax_exc + taxprice;
					
					/*Loyalty Section*/
					if(data[0][i][2]!=0)
					{
						var points = ("<span class='txt-right'>Loyalty points: <span class='text-danger'><strong>"+data[0][i][2]+"</strong></span> </span></td>");
					}
					else
					{
						var points = ("<span class='txt-right'>No Loyalty points</span>");
					}
					
					/*Check for available section*/
					if(data[0][i].available_for_order==0)
					{
						available_for_order="<td style='width: 10%;'><span class='text-align'>Out Of Stock</span></td><td style='width: 10%;'></td>";
					}
					else if(data[0][i].available_for_order==1)
					{
						var tabindex = i+1;
						available_for_order="<td style='width: 10%;' class='td_qty_price fontAlign' id='td_qty_" + data[0].id_product + "'><span><input tabindex='" + tabindex +"' type='text' onchange='updateTotalPrice(" + price + "," + data[0][i].id_product + ");' id='" + data[0][i].id_product + "' style='text-align:center' class='qv_quantity_wanted fontAlign getQTY' size='3' maxlength='5' placeholder='0' value='' /></span><br><span class='txt-bottom'>Min Qty: "+data[0][i].minimal_quantity+"</span></td><td style='width: 10%;' class='td_qty_price text-danger priceChange' id='td_price_" + data[0][i].id_product + "'><strong>" + price_value + "</strong></td>";
					}
					
					$("#catalogue_list").append("<tr id='tr_pur_id_" + data[0][i].id_product + "' class='listProdcuts'><td id='td_img_" + i + 1 + "' style='width: 12%;'><img src=http://" + data[0][i][0] + "></td><td class='width49' style='width: 55% !important;'><h5 class='cur-poi' onclick='quickView("+data[0][i].id_product+",0);'>" + data[0][i].name + "</h5><span class='txt-left' >Product Code: <span class='text-danger'>" + data[0][i].reference + "</span></span><span class='txt-right'>Product Price: <span class='text-danger'><strong>Rs. " + (data[0][i].price_tax_exc).toFixed(2) + "</strong></span></span><br /><br /><span class='td_des_short' id='td_desc_" + data[0][i].id_product + "'>" + str + "</span><span class='txt-right'>VAT : <span class='text-danger'><strong>" +data[0][i].tax_value +" &nbsp%</strong></span></span></td><td class='td_qty_price fontAlign' style='width: 15%;'></br><span class='txt-right'>Per Month:<span class='text-danger'><strong> "+data[0][i].per_month+"&nbsp;units</strong></span></span><br /><br />"+points+""+available_for_order+"</tr>");
					
					$("#cart_button").show();
					$("#order_button").show();
					
				}
				if(data[0].length >=page_size)
					$("#catalogue_list").append('<tr class="loadMoreButton"><td colspan=5><button class=" btn btn-disable  btn-block" onclick="loadMore();" style="letter-spacing: 6px;color: #5A5757;"> CLICK TO LOAD MORE PRODUCTS <br/><li class="fa fa-arrow-down"></li></button></td></tr>');
				else
					$("#catalogue_list").append('<tr class="loadMoreButton"><td colspan=5><button class=" text-danger btn btn-disable  btn-block" >No More Products To Load</button></td></tr>');
			}
			else
			{
				$("#catalogue_list").append('<tr class="loadMoreButton"><td colspan=5><button class=" text-danger btn btn-disable  btn-block" >No Products Found</button></td></tr>');
			}
			 			
			$(function() {
				$('#category_product_list').slimScroll({
					start: 'top',
					wheelStep: 5,
					height:'400px',
					railVisible: true,
					alwaysVisible: true
				});
			});
		
			}
	});
	
		
}
function loadMore()
{
	Pagination = Pagination+1;
 	if(categoryid !=0)
		customerProductList(categoryid);
  	else
		customerProductList(0);
	
}

$(document).ready(function()
{
    $('#search_rate_contract').keyup(function()
    {
			searchTable($(this).val());
    });
	
});

function searchTable(inputVal)
{
     var table = $('#category_list');
	 var showsize =0;
	 var hidesize =0;
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
			
            if(found == true)
			{				
				$(row).show();
				showsize ++;
			}
			else
			{					
				$(row).hide();
					
 			}
        }
	
    });
  	if(showsize < 1)
	{
		search_rate_contract_products();
	}
  }
 
function search_rate_contract_products()
{
  	Pagination = 0; 
 	product_count = 0;
	$("#catalogue_list").html('');
 	customerProductList(categoryid);
	
  	
	 
}

function filterCategoryList(select_category)
{
 	Pagination = 0; 
 	product_count = 0;
		var productarray = new Array();
		$('input.getQTY').each(function() {
 			if ($(this).val() > 0)
				productarray.push(this.id + "-" + $(this).val());
			
		});
 		if (productarray != "") {
	
			if (confirm("Products from the list were not added to Cart. Please press OK to add the products to cart")) {
 				addToSummary(0,0);
				$("#search_rate_contract").val('');
				$("#catalogue_list").html('');
 				customerProductList(select_category.id);
			} 
			}
		else {
				$("#search_rate_contract").val('');
				$("#catalogue_list").html('');
 				customerProductList(select_category.id);

			}
	categoryid =select_category.id;
	$("#listTitle").html(select_category.name);
}



