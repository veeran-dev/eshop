<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <div class="panel-body " id="customer_order_history">
      	<header class="panel-heading">Company's Purchase Details ( Last 3 Months )</header>
        <table class="table table-bordered"  id="customer_order_history">
          <thead align="center">
            <tr>
              <th >Company</th>
			  <th id="month_1"></th>
              <th id="month_2"></th>
              <th id="month_3"></th>
             
            </tr>
          </thead>
          <tbody id="order_history_month_view">
          </tbody> 
        </table>
      </div>
  </div>
</div>
<form class="hidden" id="customer_detail_bill" name="customer_detail_bill" action="rm-customer-bills-excel.php" method="post">
<input type="hidden" id="id_group" value="" name="id_group"/>
<input type="hidden" id="request_detail_month" value="" name="request_detail_month"/>
<input type="hidden" id="id_employee" value="" name="id_employee"/>
</from>
<script>
	$(document).ready( function() {
 	getCustomerReports();	
});
</script>