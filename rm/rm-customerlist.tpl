
<header class="rm_heading">CREATE DEAL FOR Users</header>
 <!--<div id="pick-customer" class="row">
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
-->
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
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(0)" required>
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
                            <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(7);" required>
                            		<option value="0">Select User</option>
                             </select>
							 
                    </div>
                    
                   
				</div>
			</div>
		</div>
		
		
	</section>
</div>


<div id="deal-product" class="successSearch">
                <h5>Product Name or Code </h5>
                <input type="text" tabindex="1" placeholder="Search" onkeypress="toHideEmptyResult();" class="form-control  dash-search-box ac_input" id="dealInput" autocomplete="off">
                <div class="pro" id="deal-product-not-found">
                    <span id="deal-not-found-span">
                        Product not found.
                    </span>
                </div>
                
                <br>
                <div id="actual-price-div">
                  <label id='deal-price-label'>MRP Price</label>
                  <input type='text' id="mrpPrice" class="form-control actual-deal-price" onkeydown="numbersOnly(event);" disabled="">
                  <p class="font_color">&nbsp&nbsp portal price with country tax </p>
                  <input type="hidden" id="hidden_id" value=""/>
                </div>
                <div id="actual-price-div">
                  <label id='deal-price-label'>Special Price</label>
                  <input type='text' id="specialPrice" class="form-control actual-deal-price" onkeydown="numbersOnly(event);" disabled="">
                  <p class="font_color">&nbsp&nbsp special price if available for this customer(with country tax) </p>
                </div>
                <!--<div id="price-div">
                <label id='deal-price-label'>Deal Price</label>
                  
                  <input type='text' id="deal-price" class="form-control" onkeydown="numbersOnly(event);" placeholder="Deal Price">
                </div >-->
                <div id="date-div">
                  <label id='deal-date'>Date</label>
                  <input type='text' id="deal-from-date" class="form-control datepicker cur-poi" placeholder="from">
                  <input type='text' id="deal-to-date" class="form-control datepicker cur-poi" placeholder="to">
                </div>
                <div id="disc-div">
                  <label id='deal-disc'>Discount</label>
                  <input type='text' id="sp_reduction" class="form-control" onkeydown="numbersOnly(event);" value="0.00">
                  <select class="form-control" id="sp_reduction_type">
                    <option selected="selected">---</option>
                    <option>amount</option>
                    <option>percentage</option>
                  </select>
                </div>

                <label class="btn btn-success" id="make-deal" onclick="makeDeal();">Create Deal</label>
                
                
                
                <div id="deal-processing">Processing........
                    <div class="progress progress-striped active progress-sm">
                        <div class="progress-bar progress-bar-success progress_bar_rm" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">100% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
<br><br>
<div  id="customer_view_deal_list" class="panel successSearch">
   <div class="panel-body">
   <div class="adv-table editable-table ">
    <header class="rm_heading" id="deal_heading">EXISTING DEAL</header>
      <table class="table table-striped table-hover table-bordered" id="editable-sample">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Product</th>
            <th>MRP Price</th>
            <th>Final Price</th>
            <th>Discount</th>
            <th>Discount Type</th>
            <th>From</th>
            <th>To</th>
            <th>Edit</th>
            <th>Action</th>
          </tr>
       </thead>
            <tbody id="deal-list">
            </tbody>
      </table>
    </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="alert_msg" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body"> <span id="id_alert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="dash/js/table-editable.js"></script>
<script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript">
$('#group_selection, #customer_selection').select2();
$(document).ready( function() {
  //getCustomerList(7); 
  getGroups(7);
 $('.datepicker').datepicker({
                      format: 'yyyy-mm-dd'
                  });

 autoCompSearch("#dealInput","deal_search");

});
</script>
