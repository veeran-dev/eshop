<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">Master Sales Report</header>
			<div class="panel-body">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-11 col-xs-11">
							<input type="text" readonly="" id="sale_from" placeholder="Click & Select From Date" value="" size="16" class="form-control month">
						</div>
 					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-11 col-xs-11">
							<input type="text" readonly="" id="sale_to" placeholder="Click & Select To Date" value="" size="16" class="form-control month">
						</div>
 					</div>
				</div>
				<div class="row marrginTop15">
					<section class="panel">
						<div class="panel-body">
							<div class="col-md-12">
								<button class="btn btn-success btn-block" id="genereteMasterSalesReport" type="button"><i class="fa fa-cloud-download"></i> Generate Report</button>
							</div>
						</div>					
					</section>
				</div>
			</div>
		</section>
	</div>
</div>
<div class="display-none">
	<form id="master_sales_report_excel"  action="finance-masterSalesReport.php"  method="post" class="display-none">
		<div id="master-sales-hidden-data">
		</div>
	</form>
</div>
 
<script>
$(document).ready(function()
{
	$("#sale_from").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#sale_to').datepicker('setStartDate', minDate);
    });

    $("#sale_to").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        endDate: '+0d'
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#sale_from').datepicker('setEndDate', minDate);
        });

});	

</script>
