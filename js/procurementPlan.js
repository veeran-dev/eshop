jQuery.download = function(url, data, method){
    //url and data options required
    if( url ){
		var inputs = '';
		if( data ) {
			//data can be string of parameters or array/object
			data = typeof data == 'string' ? data : jQuery.param(data);
			//split params into form inputs
			jQuery.each(data.split('&'), function(){ 
				var pair = this.split('=');
				inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
			});
		}
        //send request
        jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
        .appendTo('body').submit().remove();
    };
};

function generatePlan(){
	var selectedOrders = "";
	var i = 0;
	$("input[name='selectorder']").each( function () {
		if($(this).is(':checked')){
			selectedOrders = selectedOrders + i + '=' + $(this).val()+"&"
			i++;
		}
	});
	selectedOrders = selectedOrders.substring(0, selectedOrders.length - 1);

	$.download('procurement-plan.php', selectedOrders ,'POST');
}