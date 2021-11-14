$(document).ready( function () {
        easySearch('bootstrap-table');
});

function triggerBulkQuote(product_id,bq_id,type){
	if(type == 1){
		var type=2;
	 	var dataparam= '&type='+type+'&id_product='+product_id + '&bq_id=' + bq_id;
    	 $.ajax({
			type: 'GET',
			async: false,
			dataType:'json',
			url: 'bq-request-ajax.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				$('.vendor-table-data').html('');
				$('.vendor-list-footer').html('');
				$('.vendor-list-footer').append('<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="Cancel"/>');
				$('.vendor-list-footer').append('<input type="button" name="trigger" onclick="triggerBulkQuote('+product_id+','+bq_id+',0)" class="btn btn-primary" value="Continue"/>');
				var j = 0;
				if(data == ''){
					$('#vendor-list-response-fail').modal('show');
				}
				else{
				for(var i=0;i<data.length;i++)
				$('.vendor-table-data').append('<tr><td data-title="S.No" class="numeric">'+(++j)+'</td><td data-title="Vendor Name" class="numeric">'+data[i].name+'</td></tr>');
				$('#vendor-list-response').modal('show');
				}
			}
		});
	}
	else{
	$('.bq-request-loader').show();
	 var type=1;
	 var dataparam= '&type='+type+'&id_product='+product_id + '&bq_id=' + bq_id;
    	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'bq-request-ajax.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
				$('.bq-request-loader').hide();
				$('#vendor-list-response').modal('hide');
				toast("Bulk Quote Triggered Successfully!","success");
				bqRequest();
			}
		});
    }
}

