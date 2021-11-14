// JavaScript Document

$(document).ready(function()
{
	var type=1;
	var dataparam = '&type='+type;
	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: 'AddWishListProduct.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				//alert(data);
				for (var i=0; i<data.length; i++)
				{
					$('#cust_names').append("<option value="+ data[i].id_customer +">" + data[i].firstname +" - "+ data[i].email + "</option>");
				}
			}
	});
});
function fn_cus_name()
{
	$('#cust_wishlist').html('');
	var cus_id=$('#cust_names').val();
 	var type=2;
	var dataparam = '&type='+type+'&cus_id='+cus_id;
	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: 'AddWishListProduct.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				$('#cust_wishlist').append("<option value='0'>--Select wishlist--</option>");
 				for (var i=0; i<data.length; i++)
				{
					$('#cust_wishlist').append("<option value="+ data[i].id_wishlist +">" + data[i].name + "</option>");
				}
			}
	});
}
function fn_save()
{
	var cus_id=$('#cust_names').val();
	var cus_wish_id=$('#cust_wishlist').val();
	var product_code=$('#product_code').val();
 	var type=3;
	var dataparam = '&type='+type+'&cus_id='+cus_id+'&cus_wish_id='+cus_wish_id+'&product_code='+product_code;
 	$.ajax({
			type: 'GET',
			async: true,
 			url: 'AddWishListProduct.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
 				if(data==1)
				{
					alert("products added successfully");
					/*$('#cust_names').val('');*/
					$('#product_code').val('');
					/*$('#cust_wishlist').val('');
					$('#cust_wishlist').html('');
					$('#cust_wishlist').append("<option value='0'>--Select wishlist--</option>");*/
					 
				}
				if(data==0)
				{
					alert("products already exist");
					$('#product_code').val('');
				}
				if(data==2)
				{
					alert("product not found");
 				}
			}
	});
}