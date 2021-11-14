/*whenever the update happen in the purchase list the function comes here nad excuite*/
function updateTotalPrice(id_product, price, quantity, totalProducts, id_wishlist, id_product_attribute){
		finalPrice = Number((quantity.value * price).toFixed(2));
		ele_name = "#" + id_product + "_final_price";
		if(isNaN(finalPrice)){
			$(ele_name).html("Invalid!");
		}
		else{
			$(ele_name).html(finalPrice);
			var dataparam = 'id_wishlist=' + id_wishlist + '&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute + '&quantity=' + quantity.value+ '&totalprice=' + finalPrice;
			$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: baseDir + 'modules/blockwishlist/updateProductQuantityPurchaseList.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				$('#total_products_all').val(data[0].totalqty);
				$('#total_price_all').val(data[0].totalprice);
				$('#total_products').val(data[0].cur_qty);
				$('#total_price').val(data[0].cur_price);
			}
		});
		}
	}
	
function fun_position_up()
{
	$(".qv_quantity_wanted").focus(function(e){
	var relativeY = e.pageY - this.offsetTop;
	if(relativeY < -650)
	{
		window.scroll(0,this.offsetTop-300);
		
	}
	});
}