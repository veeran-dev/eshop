<header class="rm_heading">CREATE NEW PURCHASE LIST FOR CUSTOMERS</header>
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
</div>
<script type="text/javascript">
$(document).ready( function() {
  getCustomerList(8);
});
 </script>