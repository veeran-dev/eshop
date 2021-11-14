function fn_saveproducts()
{
	var customerid=$('#hid_cus_id').val();
	var product_codes=$('#product_codes').val();
	var type=1;
	var dataparam = '&customerid=' + customerid+'&product_codes='+product_codes+'&type='+type;
	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: 'corpmasterlist.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
				if(data==1)
				{
					alert("Product codes added successfully");
					$("#filtername").val("");
					$("#product_codes").val("");
				}
				else
				{
					alert("Product codes are not added successfully");
				}
			}
		});
}
function fn_cancel()
{
	$("#filtername").val("");
	$("#product_codes").val("");
}
$(document).ready(function(){
  $("#filtername").autocomplete(
		"corpmasterlist.php?&type=2", {
		selectFirst: false,
		dataType: "json",
		minChars: 3,
		max: 10,
		formatItem: function(data, i, max, value, term) {
			return value;
		},
		parse: function(data) {
			var mytab = new Array();
			for (var i = 0; i < data.length; i++)
				mytab[mytab.length] = { data: data[i].id_customer, value: data[i].firstname+" - "+data[i].company+" - "+ data[i].email };
			return mytab;
		}
	}
  ).result(function(event, data, formatted) {
				$('#filtername').val(formatted);
				$('#hid_cus_id').val(data);
	})
 }
 
 
);
