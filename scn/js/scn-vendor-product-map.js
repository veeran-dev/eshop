$(function()
{
	$('#product-vendor-table-list').slimScroll({
		height:"330px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
	});
	
	$('#brand-vendor-table-list').slimScroll({
		height:"330px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
	});
	$('#category-vendor-table-list').slimScroll({
		height:"330px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
	});
});

$(document).ready(function() {
		var auto=2;
window.vendorProduct={};
	window.vendorProductsArray=[];
	window.brandProductsArray=[];
	window.brandProducts;
	window.categoryProductsArray=[];
	window.categoryProducts;
	window.idProduct;
    $("#vendor-name").autocomplete("scn-vendor-search.php?auto="+auto+"&type="+2,
	{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;
	},
	parse: function(data){
	
var mytab = new Array();
		for(var i = 0; i < data.length; i++)
	
				mytab[mytab.length] = { data:data[i], value:"<div class='ul-font-size col-xs-6 col-md-10' id='vendor_search_details'>"+data[i].name+"</div>"};
			return mytab;
}
	}).result(
	function(event, data, formatted, value) {
				$('#vendor-name').val(data.name);
				window.vendor=data.id_vendor;

				$.ajax({
			type: 'POST',
			url: 'scn-vendor-search.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{case:3,vendorId:data.id_vendor},
			success: function(jsonData)
			{
				$('#vendor-address').html('');	
				$('#vendor-poc').html('');
					
				$('#vendor-address').append('<option value="">Select Vendors Address</option>');
				$('#vendor-poc').append('<option value="">Select Vendors POC</option>');

				if(jsonData[0]=="" || jsonData[0]=="null")
				{
					return false;
				}
				else
				{
					for(var j=0;j<jsonData[0].length;j++)
					{	
						if(jsonData[0][j].id_default_address==jsonData[0][j].id_address)
						{
							$('#vendor-address').append("<option selected='selected' class='col-md-12' value='"+jsonData[0][j].id_address+"'>"+jsonData[0][j].alise+"</option>");
						}
						else
						{
							$('#vendor-address').append("<option class='col-md-12' value='"+jsonData[0][j].id_address+"'>"+jsonData[0][j].alise+"</option>");
						}
					}
				}
				if(jsonData[1]=="" || jsonData[1]=="null")
				{
					return false;
				}
				else
				{
				
				for(var j=0;j<jsonData[1].length;j++)
				{
				if(jsonData[1][j].id_default_poc==jsonData[1][j].id_poc)
				{
					$('#vendor-poc').append("<option selected='selected' class='col-md-12' value='"+jsonData[1][j].id_poc+"'>"+jsonData[1][j].firstname+"</option>");
				}
				else
				{
					$('#vendor-poc').append("<option class='col-md-12' value='"+jsonData[1][j].id_poc+"'>"+jsonData[1][j].firstname+"</option>");
				}
				}
				}
			}
				});
	});
	//product autocomplete
    autoCompSearch("#product-name","prod_ven_map");

$('#product-map-add-button').click(function()
{
if(!idProduct || $('#product-name').val()=="" || $('#vendor-name').val()=="" )
{
return false;
}
else
{
$('#product-name').val('');
vendorProductsArray.push(vendorProduct);
$("#vendor-product-list-body").html("");
for(var i=0;i<vendorProductsArray.length;i++)
{
$("<tr id='vendor-product"+vendorProductsArray[i].productId+"' class='odd'><td class='quickbuylist-product-name'>"+vendorProductsArray[i].name+"</td><td class='sorting_1 '><a class='fa fa-trash-o delete-option' onClick='toDeleteVendorProduct("+vendorProductsArray[i].productId+");'>Delete</a></td></tr>").prependTo('table > #vendor-product-list-body');
}
}
});
$('#product-map-Save-button').click(function()
{ 
$.ajax({
type: 'POST',
url: 'scn-vendor.php',
async: true,
cache: false,
dataType : "json",

data:{data:vendorProductsArray,type:9},
success: function(jsonData)
{
$("#vendor-product-list-body").html("");
vendorProduct=0;
vendorProductsArray.length=0;
}
});

});
$('#product-map-Clear-button').click(function()
{
$("#vendor-product-list-body").html("");
vendorProduct=0;
vendorProductsArray.length=0;
});

	 $("#category-name").autocomplete("scn-vendor-search.php?auto="+auto+"&type="+3,
	{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;
	},
	parse: function(data){
	
var mytab = new Array();
		for(var i = 0; i < data.length; i++)
	
				mytab[mytab.length] = { data:data[i], value:"<div class='ul-font-size col-xs-6 col-md-10' id='vendor_search_category_details'>"+data[i].name+"</div>"};
			return mytab;
}
	}).result(
	function(event, data, formatted, value) {
				$('#category-name').val(data.name);
					$.ajax({
			type: 'POST',
			url: 'scn-vendor-search.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{case:2,categoryId:data.id_category},
			success: function(jsonData)
			{
				if(jsonData=="null")
				{
					alert("No products in this category");
				}
				else if(jsonData==1)
				{
					alert("Please try to add some subCategory.");
				}
				else
				{
					var pocId=$('#vendor-poc').val();
				var addressId=$('#vendor-address').val();
				var vendorType=$('#vendor-type').val();
				categoryProducts={data:jsonData,vendorId:vendor,addressId:addressId,pocId:pocId,vendorType:vendorType,categoryId:data.id_category};
				}
			}
					});
	});
	$('#category-map-add-button').click(function()
	{
		if(categoryProducts.data=="" || categoryProducts.data==null || $('#category-name').val()=="" || $('#vendor-name').val()=="")
		{
			return false;
		}
		else
		{
			$('#category-name').val('');
		categoryProductsArray.push(categoryProducts);
		$("#vendor-category-list-body").html("");
		for(var i=0;i<categoryProductsArray.length;i++)
		 {
			for(var j=0;j<categoryProductsArray[i].data.length;j++)
		 {
	$("<tr id='vendor-category"+categoryProductsArray[i].data[j].id_product+"' class='odd'><td class='quickbuylist-category-name quickbuylist-brand-name col-md-9 padding-align-right padding-align-left' >"+categoryProductsArray[i].data[j].name+"</td><td class='sorting_1  col-md-3 padding-align-right padding-align-left'><a class='fa fa-trash-o delete-option' onClick='toDeleteVendorcategoryProduct("+categoryProductsArray[i].data[j].id_product+");'>Delete</a></td></tr>").prependTo('table > #vendor-category-list-body');
			}
		 }
		}
	});
	$('#category-map-Save-button').click(function()
	{
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{data:categoryProductsArray,type:12},
			success: function(jsonData)
			{
				$("#vendor-category-list-body").html("");
				categoryProducts=0;
				categoryProductsArray.length=0;
			}
			});
		
	});
	$('#category-map-Clear-button').click(function()
	{
				$("#vendor-category-list-body").html("");
				categoryProducts=0;
				categoryProductsArray.length=0;

	});
	 $("#brand-name").autocomplete("scn-vendor-search.php?auto="+auto+"&type="+4,
	{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;
	},
	parse: function(data){
	
var mytab = new Array();
		for(var i = 0; i < data.length; i++)
	
				mytab[mytab.length] = { data:data[i], value:"<div class='ul-font-size col-xs-6 col-md-10' id='vendor_search_category_details'>"+data[i].name+"</div>"};
			return mytab;
}
	}).result(
	function(event, data, formatted, value) {
				$('#brand-name').val(data.name);
					$.ajax({
			type: 'POST',
			url: 'scn-vendor-search.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{case:1,brandId:data.id_manufacturer},
			success: function(jsonData)
			{
				if(jsonData=="null" || jsonData=="")
				{
					alert("No products in this brand");
				}
				else
				{
					var pocId=$('#vendor-poc').val();
				var addressId=$('#vendor-address').val();
				var vendorType=$('#vendor-type').val();
				brandProducts={data:jsonData,vendorId:vendor,addressId:addressId,pocId:pocId,vendorType:vendorType};
				}
			}
					});
	});
	
	$('#brand-map-add-button').click(function()
	{
		if(brandProducts=="" || brandProducts==null || $('#brand-name').val()=="" || $('#vendor-name').val()=="")
		{
			return false;
		}
		else
		{
			$('#brand-name').val('');
		brandProductsArray.push(brandProducts);
		$("#vendor-brand-list-body").html("");
		for(var i=0;i<brandProductsArray.length;i++)
		 {
			for(var j=0;j<brandProductsArray[i].data.length;j++)
		 {
	$("<tr id='vendor-brand"+brandProductsArray[i].data[j].id_product+"' class='odd'><td class='quickbuylist-brand-name col-md-9 padding-align-right padding-align-left'>"+brandProductsArray[i].data[j].name+"</td><td class='sorting_1 col-md-3 padding-align-right padding-align-left'><a class='fa fa-trash-o delete-option' onClick='toDeleteVendorBrandProduct("+brandProductsArray[i].data[j].id_product+");'>Delete</a></td></tr>").prependTo('table > #vendor-brand-list-body');
			}
		 }
		}
	});
	$('#brand-map-Save-button').click(function()
	{
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{data:brandProductsArray,type:10},
			success: function(jsonData)
			{
				$("#vendor-brand-list-body").html("");
				brandProducts=0;
				brandProductsArray.length=0;
			}
			});
		
	});
	$('#brand-map-Clear-button').click(function()
	{
				$("#vendor-brand-list-body").html("");
				brandProducts=0;
				brandProductsArray.length=0;
	});
});

function toDeleteVendorProduct(todelete)
{
	for(var j=0;j<vendorProductsArray.length;j++)
		{
			if(vendorProductsArray[j].productId==todelete)
			{
				vendorProductsArray.splice(j,1);
			}
			
		}
		$('#vendor-product'+todelete).remove();
}
function toDeleteVendorBrandProduct(productId)
{
	for(var i=0;i<brandProductsArray.length;i++)
		 {
			for(var j=0;j<brandProductsArray[i].data.length;j++)
		 {	
		 if(brandProductsArray[i].data[j].id_product==productId)
			{
				brandProductsArray[i].data.splice(j,1);
			}
		 }
		}		

		$('#vendor-brand'+productId).remove();
}
function toDeleteVendorcategoryProduct(productId)
{
	for(var i=0;i<categoryProductsArray.length;i++)
		 {
			for(var j=0;j<categoryProductsArray[i].data.length;j++)
		 {	
		 if(categoryProductsArray[i].data[j].id_product==productId)
			{
				categoryProductsArray[i].data.splice(j,1);
			}
		 }
		}		

		$('#vendor-category'+productId).remove();
}
$("#product-name").attr("disabled","disabled");
$('#vendor-name').change(function(){
	if('#vendor-name:selected'){
		$('#product-name').removeAttr('disabled');
	}
});