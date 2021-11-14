$(document).ready(function()
{
	$('#dr-from-date,#dr-to-date').datepicker({
	    prevText:"",
		nextText:"",
		dateFormat:"dd-mm-yy"
	});
	
	var date = new Date(), y = date.getFullYear(), m = date.getMonth();
	var firstDay = new Date(y, m, 1);
	var lastDay = new Date(y, m + 1, 0);
	var find = '/';
	var re = new RegExp(find, 'g');
	$('#dr-from-date').val(firstDay.toLocaleDateString('en-GB').replace(re,'-'));
	$('#dr-to-date').val(lastDay.toLocaleDateString('en-GB').replace(re,'-'));

});

function filterRequests(type)
{
	var from_date = $('#dr-from-date').val();
	var to_date = $('#dr-to-date').val();
	
    $('#index_viewport').html('');
    $("#index_viewport").load("get-delivery-report.php?ajax=true&type="+type+"&from_date="+from_date+"&to_date="+to_date, function(response, status, xhr) {
    	$('#dr-from-date').val(from_date);
		$('#dr-to-date').val(to_date);
    });
}

function generatePerReport(id_fc)
{
	var from_date = $('#dr-from-date').val();
	var to_date = $('#dr-to-date').val();
	
	window.open("generate-delivery-report.php?&from_date=" + from_date + "&to_date=" + to_date + "&id_fc=" + id_fc);
}