<!--<header class="rm_heading">CREATE NEW PURCHASE LIST FOR CUSTOMERS</header>
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
<header class="rm_heading">CREATE NEW PURCHASE LIST FOR CUSTOMERS</header>
<div class="row">
	<section class="panel-body">
 		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
 			<div class="">
				<div class="">
					<!-- SELECT CUSTOMER GROUP -->
					<div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            		<span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                            		<abbr class="select2-search-choice-close"></abbr>
                            		<span class="select2-arrow" role="presentation">
                            			<b role="presentation"></b>
                            		</span>
                            	</a>
                            	<label for="s2id_autogen3" class="select2-offscreen"></label>
                            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer()" required>
                            		<option value="0">Select Company</option>
                             </select>
                    </div>
                    <!-- SELECT CUSTOMER WITH EMAIL ID -->
					<div class="form-group col-md-7 col-sm-7 col-xs-7 col-lg-7">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                            	<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                            		<span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                            		<abbr class="select2-search-choice-close"></abbr>
                            		<span class="select2-arrow" role="presentation">
                            			<b role="presentation"></b>
                            		</span>
                            	</a>
                            	<label for="s2id_autogen3" class="select2-offscreen"></label>
                            	<input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(4);" required>
                            		<option value="0">Select User</option>
                             </select>
							 
                    </div>
                    
                   
				</div>
			</div>
		</div>
		
		
	</section>
</div>

<div id="customer_create_purchase_list" class="panel successSearch">
    <div class="panel">
      <header class="panel-heading padding1">Create Purchase List </header>
      <section class="panel-body">
        <div class="col-xs-8 col-md-8 panel-body errorSearch" id="create_list_div" >
          <input type="text" id="customerpurchaselist" placeholder="Purchase List Name" class="form-control  dash-search-box ac_input ">
        </div>
      	<div class="col-xs-4 col-md-4 panel-body errorSearch" id="add_to_list_div">
          <a class="btn btn-primary" id="createpurchaselist" onclick="createpurchaselist()">Create</a>
        </div>
        </section>
     </div>
</div>

<div  id="customer_view_purchase_list" class="panel successSearch">
  <header class="panel-heading padding1">View Purchase List</header>
   <section class="panel-body">
      <table class="table table-striped table-hover table-bordered" id="customer_rate_contract_table">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Purchase List</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody id="purchase-list-name">
            </tbody>
      </table>
    </section>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="alert_msg" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body"> <span id="id_alert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="pur_list_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Purchase List Name</h4>
      </div>
      <div class="modal-body"> 
        <input type="text" class="form-control" id="pur_list_name" name="pur_list_name">
      </div>
      <div class="modal-footer edit-list-footer">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="dash/js/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/js/dash-quickbuy.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-switch.js"></script>
<link rel="stylesheet" type="text/css" href="dash/css/bootstrap-switch.css">
<link rel="stylesheet" type="text/css" href="dash/bs3/bootstrap.css">
<script type="text/javascript">
$(document).ready( function() {
  getGroups(4);
  $('#group_selection, #customer_selection').select2();
});
 </script>
