 <div aria-hidden="true" aria-labelledby="ModalLabel" role="dialog" tabindex="-1" id="globalAlert" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body"> <span id="idGlobalAlert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var baseDir = '{$content_dir}';
	var static_token = '{$static_token}';
	var token = '{$token}';
	var profile = '{$cookie->profile}';
	var currency_format_value = '{$cookie->currency_format_value}';
</script>
<script type="text/javascript" src="scn/js/scn-index.js"></script>
<script type="text/javascript" src="scn/js/scn-bq-requests.js"></script>
<script type="text/javascript" src="dash/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="dash/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="dash/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="dash/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="dash/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="dash/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/jquery.msgPop.js"></script>
<script type="text/javascript" src="js/pop-up.js"></script>
<script type="text/javascript" src="js/autoCompSearch.js"></script>
<!--Easy Pie Chart-->
<!--<script src="dash/js/easypiechart/jquery.easypiechart.js"></script>-->
<!--Sparkline Chart-->
<!--<script src="dash/js/sparkline/jquery.sparkline.js"></script>-->
<!--jQuery Flot Chart-->
<!--<script src="dash/js/flot-chart/jquery.flot.js"></script>
<script src="dash/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="dash/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="dash/js/flot-chart/jquery.flot.resize.js"></script>
<script src="dash/js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="dash/js/chart-js/Chart.js"></script>-->

<!--common script init for all pages-->
<script src="dash/js/scripts.js"></script>
<!--script for this page-->
<script src="dash/js/gritter.js" type="text/javascript"></script>
<script type="text/javascript" src="catalog/js/jquery-ui.js"></script>
<script type="text/javascript" src="{$content_dir}js/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript" src="dash/js/jquery.notify.min.js"></script>
<!--<script type="text/javascript" src="{$content_dir}modules/blockcart/ajax-cart.js"></script>
<script type="text/javascript" src="{$content_dir}js/tools.js"></script>-->
<script type="text/javascript" src="{$content_dir}dash/js/canvasjs.min.js"></script>
<!--<script src="dash/js/jquery-steps/jquery.steps.js"></script>-->
<script src="dash/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="dash/js/jspdf.debug.js"></script>
<script type="text/javascript" src="scn/js/moment.js"></script>
<script type="text/javascript" src="scn/js/bootstrap-datetimepicker.min.js"></script>
<!--<script type="text/javascript" src="dash/js/jspdf.min.js"></script>-->
 


 <!-- data table js for easy search  -->
 
<script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="dash/js/data-tables/dataTables.fixedColumns.js"></script>
<script type="text/javascript" src="dash/js/data-tables/DT_bootstrap.js"></script>
 <!-- -->

<script type="text/javascript">
	$(function()
	 {
 		$('input, textarea').placeholder();
 	 });

	$.ajaxSetup(
	{
		timeout:30000
	});
	/*$body = $("body");*/
	/*$(document).ready(function()
	{
		$(".ajaxLoaderModal").hide();
	});*/
 	$(document).ajaxStart(function()
	{
 		$(".ajaxLoaderModal").show();
	});

	$(document).ajaxStop(function() 
	{
  		$(".ajaxLoaderModal").hide();
 		
	});
	/*$(document).ajaxSuccess(function() 
	{
		//alert("");
		$(".ajaxLoaderModal").hide();
	});*/
	$( document ).ajaxError(function(event, request, settings,xhr) {
		var message;
		if(request.responseText != "")
			message = request.responseText;
		else
			message = request.status+": "+request.statusText;
		toast(message, "error");

		if(message == 'Your session was expired') {
			setTimeout(function() {
	    		window.location.reload();
	    	}, 2000);
		}
	});

 </script> 
 
 