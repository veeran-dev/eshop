<!--<header class="rm_heading">Procurement Plan</header>
<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
		  <button class="btn btn-primary buttonColor dropdown-toggle padding20" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
		 </div>
	</div>
</div>
</div>-->
<div class="panel" id="">
    <div class="panel-body">
    <div class="text-center panel-heading"><b>Today's Procurement Plan</b></div>
    <section class="panel">
        <table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"  cellspacing="0" width="100%" id="procurement_finance_plan">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th >Order ID</th>
					<th>User Name</th>
                    <th>Fulfillment Center</th>
                    <th >Order Value</th>                    
             	</tr>
            </thead>
            <tbody id="finance_procurement_plan">
            {assign var=i value=1}
            {foreach $financeProcurementPlan as $plan}
                <tr>
                    <td>{$i}</td>
                    <td class="order-id">
                        <a class='cur_poi' target='#' href='kobster_admin/index.php?tab=AdminOrders&id_order={$plan.id_order}&vieworder&token=fa47c37ac87d8ca50a892867f9dcce34'>{$plan.id_order}
                        </a>
                    </td>
                    <td>{$plan.firstname}</td>
                    <td>{$plan.city_name}</td>
                    <td class="amount">{$plan.total_paid}</td>
                </tr>
            {assign var=i value=$i+1}
            {/foreach}
            </tbody>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="amount"></th>
             </tr>
			  
        </tfoot>
        </table>
     </section>
     <form action="finance-procurment-plan.php" target="#">
        <button type="submit" class="btn btn-success">Download</button>    
     </form>     
   </div>
</div>
<script type="text/javascript">
    easySearchProcurement('procurement_finance_plan');
</script>
