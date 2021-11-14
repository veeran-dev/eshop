<header class="rm_heading m-bot20">Procurement Plan</header>
<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
		  <button class="btn btn-primary buttonColor dropdown-toggle padding20" type="button" data-toggle="dropdown">
			<span id="listTitle">Select Fulfillment Center</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
		 </div>
	</div>
</div>
<!-- <div class="panel hideProcurementPlan">
    <div class="panel-body">
    <section class="panel">
        <table  id="procurement-plan" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  <tbody id="purchase_plan">
		  </tbody>
		</table>
     </section>
	</div>
</div> -->
<div class="row hideProcurementPlan">
	<div class="col-sm-12">
            <section >
                <div >
                    <!-- <button class="btn btn-primary disabled" id="download_table" onclick="demoFromHTML();" type="button">
                    	Download As PDF
                    </button> -->
					<button class="btn btn-primary" id="download_excel_table" onclick="downloadProcurementExcel();" type="button">
						Download As Excel
					</button>
					<button class="btn btn-primary" id="new_procurement_paln" onclick="downloadNewProcurementExcel();" type="button">
						New Procurement Plan
					</button>
                 </div>
            </section>
    </div>

<div class="display-none">
	<form id="form-purchase-plan"  action="procurement-excel.php"  method="post" class="display-none">
		<div id="purchase-plan-hidden-data"> </div> 
	</form>
</div>
		
</div>
<img src="img/logo_invoice.jpg"  style="display:none" id="kobster_logo"/>
<canvas id="plan_logo" style="display:none"></canvas>

<script type="text/javascript">
$(document).ready( function() {
  getFC();
  
$('.hideProcurementPlan').hide();
 });
</script>
