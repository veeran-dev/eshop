<div class="row">
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">Purchase Bill </header>
			<div class="panel-body">
				<div class="col-md-6">
					<select type="text" class=" col-md-6 form-control color selectFC" id="purchase_FC"></select>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-11 col-xs-11">
							<input type="text" readonly="" id="purchase_month" placeholder="Click & Select Month" data-date-minviewmode="months" data-date-viewmode="months" data-date-format="mm/yyyy" data-date="102/2012" value="" size="16" class="form-control month">
						</div>
 					</div>
				</div>
				<div class="row marrginTop15">
					<section class="panel">
						<div class="panel-body">
							<div class="col-md-12">
								<button class="btn btn-success btn-block" onclick="exportExcelReport(1);" type="button"><i class="fa fa-cloud-download"></i> Export Purchase Bill</button>
							</div>
						</div>					
					</section>
				</div>
			</div>
		</section>
	</div>
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">Sales Bill </header>
			<div class="panel-body">
				<div class="col-md-6">
					<select type="text" class=" col-md-6 form-control color selectFC" id="sales_FC"></select>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-11 col-xs-11">
 								<input type="text" readonly="" id="sales_month" placeholder="Click & Select Month" data-date-minviewmode="months" data-date-viewmode="months" data-date-format="mm/yyyy" data-date="102/2012" value="" size="16" class="form-control month">
 						</div>

					</div>
				</div>
				<div class="row marrginTop15">
					<section class="panel">
						<div class="panel-body">
							<div class="col-md-12">
								<button class="btn btn-success btn-block" onclick="exportExcelReport(2);" type="button"><i class="fa fa-cloud-download"></i> Export Sales Bill</button>
							</div>
						</div>					
					</section>
				</div>
			</div>
		</section>
	</div>
</div>
<div class="display-none">
	<form id="purchase_sales_bill_excel"  action="finance-pur-sales-excel.php"  method="post" class="display-none">
		<div id="purchase-hidden-data">
		</div>
	</form>
</div>
 
<script>
$(document).ready(function()
{
	getFCs();
	$('.month').datepicker({
			format: 'mm-yyyy'
	});
	if(window.date_sales)
		$("#sales_month").val(date_sales);
	if(window.date_purchase)
		$("#purchase_month").val(date_purchase);
});	

</script>
