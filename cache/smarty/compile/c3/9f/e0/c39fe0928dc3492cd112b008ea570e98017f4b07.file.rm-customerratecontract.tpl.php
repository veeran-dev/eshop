<?php /* Smarty version Smarty-3.1.19, created on 2017-11-30 12:11:14
         compiled from "rm\rm-customerratecontract.tpl" */ ?>
<?php /*%%SmartyHeaderCode:154825a1fa80a11a584-33117881%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c39fe0928dc3492cd112b008ea570e98017f4b07' => 
    array (
      0 => 'rm\\rm-customerratecontract.tpl',
      1 => 1503904901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '154825a1fa80a11a584-33117881',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a1fa80a1c3541_33431914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1fa80a1c3541_33431914')) {function content_5a1fa80a1c3541_33431914($_smarty_tpl) {?><header class="rm_heading">VIEW USER RATE CONTRACT PRODUCTS</header>
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
</div>-->
<script type="text/javascript">
	$('#group_selection, #customer_selection').select2();
 </script>
<div class="row">
	<section class="panel-body">
		
		<div class="col-xs-12 col-md-12 col-sm-12 panel-body">
 			<div class="panel">
				<div class="panel-body">
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
                            <!--<select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(2);" required>-->
								<select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer(2);" required>
                            		<option value="0">Select Company</option>
                            		
                            </select>
                    </div>
			</div>
			
        </div>
		</div>
		
		
	</section>
</div>

<div class="panel successSearch" id="customer_rate_contract">
	 	
	<div class="">
		<section class="panel">	
		
		<header class="panel-heading">View & Edit PROUCTS RATE CONTRACT </header>
		<div class="panel-body">
			<table class="table table-striped table-hover table-bordered" id="customer_rate_contract_table">
				<thead>
					<tr>
						<th>S.No</th>
					  <th>Product Code</th>
					  <th>Name</th>
					  <th>Price (tax excl)</th>
                      <th>Valid Till</th>
					  <!--<th>Category</th>-->
                      <th>Published Date</th>
					  <th class="action">Action</th>					
					</tr>
				</thead>
				<tbody id="ratecontract_products">
 				</tbody>
			</table>
			 
		 </section>
	   </div>
</div>

<!--<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletecontractproduct" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
	  <div class="modal-body">
	  <div id="delete_product">
		  
	  </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
      </div>
    </div>
  </div>
</div>-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addNewProductFromSearch" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" id="addNewProductExContent">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Add New Product - Express</h4>
                            </div>
                            <div class="modal-body">

                                <form id="createNewProdEx" name="createNewProdEx" onSubmit="createNewProductExpress(3); return false;">
                                    <div class="form-group">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name" required="">
                                        <p class="help-block">Format: &lt;Brand Name&gt; &lt;Product Name&gt; &lt;Product Code&gt; &lt;Colour, Size, Volume&gt;</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="priceTI">MRP (Rs.) (Tax Incl.)</label>
                                        <input type="text" class="form-inline" id="priceTI" name="priceTI" placeholder="Enter the MRP" required="">
                                        
                                        <label for="id_tax_rules_group">Tax Group</label>
                                        <select name="id_tax_rules_group" id="id_tax_rules_group" class="form-inline input-sm m-bot15" required="">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mrp">Customer Price (Rs.) (Tax Excl.)</label>
                                        <input type="text" class="form-inline" name="custPrice" placeholder="Enter the Customer Price" >
                                    </div>
                                    
                                    <input type="hidden" name="customerId" id="customerId" />
                                    <input type="hidden" name="priceTE" id="priceTE" />
                                    <button type="submit" class="btn btn-success">Create Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>dash/js/dash-quickbuy.js"></script>

 
<script type="text/javascript" src="rm/js/rm-addproduct.js"></script>
<script type="text/javascript" src="rm/js/rm-index.js"></script>
<script type="text/javascript">

$(document).ready( function() {
 	getGroups(3);
   $('[data-toggle="tooltip"]').tooltip();
 });
</script>
<?php }} ?>
