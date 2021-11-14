<?php /* Smarty version Smarty-3.1.19, created on 2019-10-28 16:03:06
         compiled from "scn\scn-orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:254925db6c3e251aba7-45125681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb64172b6a0c68bf3fff314b44a9dbc05c265ae9' => 
    array (
      0 => 'scn\\scn-orders.tpl',
      1 => 1531649293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '254925db6c3e251aba7-45125681',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'conversation' => 0,
    'order_detail' => 0,
    'single_order' => 0,
    'tab' => 0,
    'orderBy' => 0,
    'orderWay' => 0,
    'page' => 0,
    'paginationCount' => 0,
    'pages' => 0,
    'i' => 0,
    'jump_page' => 0,
    'perPage' => 0,
    'id_order' => 0,
    'group' => 0,
    'customer' => 0,
    'buyer_type' => 0,
    'state_array' => 0,
    'data' => 0,
    'state' => 0,
    'order_total_list' => 0,
    'payment' => 0,
    'order_state' => 0,
    'order_status' => 0,
    'fc' => 0,
    'id_fc' => 0,
    'from_date' => 0,
    'to_date' => 0,
    'orders' => 0,
    'currency' => 0,
    'order_id' => 0,
    'company' => 0,
    'stateObj' => 0,
    'currentState' => 0,
    'states' => 0,
    'block_account' => 0,
    'fc_city' => 0,
    'order' => 0,
    'carriers' => 0,
    'cart' => 0,
    'order_po_name' => 0,
    'budget' => 0,
    'baseDir' => 0,
    'order_placed_by' => 0,
    'cookie' => 0,
    'order_messages' => 0,
    'tax_exclusive' => 0,
    'perksCustomerFile' => 0,
    'product_detail' => 0,
    'k' => 0,
    'customerObj' => 0,
    'cus_total_performance' => 0,
    'shipping_address' => 0,
    'invoice_address' => 0,
    'consolidated_invoice' => 0,
    'token' => 0,
    'invoice_number' => 0,
    'invoices_collection' => 0,
    'invoice_file' => 0,
    'delivery_slip' => 0,
    'file' => 0,
    'history' => 0,
    'messages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5db6c3e38b82e3_28602774',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db6c3e38b82e3_28602774')) {function content_5db6c3e38b82e3_28602774($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp64\\www\\kobsterEshop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><?php if (!$_smarty_tpl->tpl_vars['conversation']->value) {?>
<div class="row" id="ordersTemplate">
    <div class="panel-body">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="navTab">
                <li role="presentation" class="<?php if (!$_smarty_tpl->tpl_vars['order_detail']->value) {?>active<?php }?>">
                    <a href="#allOrdersList" id="tab_0" aria-controls="allOrdersList" role="tab" data-toggle="tab">
                        <i class="icon-time"></i> All Orders List
                    </a>
                </li>
                <li role="presentation">
                    <a href="#singleOrderView" id="tab_1" class="<?php if (!$_smarty_tpl->tpl_vars['single_order']->value) {?>disabledTab<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value==1) {?> active<?php }?>" aria-controls="singleOrderView" role="tab" data-toggle="tab">
                        <i class="icon-money"></i> Single Order View
                    </a>
                </li>
                <li role="presentation">
                    <a href="#customerInfo" id="tab_2" class="<?php if (!$_smarty_tpl->tpl_vars['single_order']->value) {?>disabledTab<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value==2) {?> active<?php }?>" aria-controls="customerInfo" role="tab" data-toggle="tab">
                        <i class="icon-user"></i> Customer Info & DRs
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" id="tabContent">
                <div role="tabpanel" class="tab-pane fade<?php if (!$_smarty_tpl->tpl_vars['order_detail']->value) {?>in active<?php }?>" id="allOrdersList">
                    <div class="panel-body">
                        <div class="col-md-12 m-bot20">
                            <div class="ordersFullList" id="ordersFullList">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <ul class="pagination">
                                            <li>
                                                <a href="javascript:void(0)" aria-label="First" onclick="openOrders(0,0,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                                    <span aria-hidden="true">
									        		&laquo;
									        	</span>
                                                </a>
                                            </li>
                                            <?php if ($_smarty_tpl->tpl_vars['page']->value==0) {?>
                                            <li class="disabled">
                                                <a href="javascript:void(0)">
                                                    <span>
										    			Prev
										    		</span>
                                                </a>
                                            </li>
                                            <?php } else { ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="openOrders(0,<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                                    <span>
										    			Prev
										    		</span>
                                                </a>
                                            </li>
                                            <?php }?> <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['paginationCount']->value) {?><?php $_smarty_tpl->tpl_vars['pages'] = new Smarty_variable($_smarty_tpl->tpl_vars['page']->value, null, 0);?><?php } else { ?><?php $_smarty_tpl->tpl_vars['pages'] = new Smarty_variable(($_smarty_tpl->tpl_vars['page']->value+6), null, 0);?><?php }?> <?php if ($_smarty_tpl->tpl_vars['page']->value>=0) {?> <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['pages']->value+1 - (($_smarty_tpl->tpl_vars['page']->value)) : ($_smarty_tpl->tpl_vars['page']->value)-($_smarty_tpl->tpl_vars['pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = ($_smarty_tpl->tpl_vars['page']->value), $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?> <?php if ($_smarty_tpl->tpl_vars['i']->value>=$_smarty_tpl->tpl_vars['paginationCount']->value) {?> <?php } else { ?>
                                            <li id="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
_no" class="<?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['i']->value) {?>active<?php }?>">
                                                <a href="javascript:void(0)" onclick="openOrders(0,<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
											              <?php echo $_smarty_tpl->tpl_vars['i']->value+1;?>

											          </a>
                                            </li>
                                            <?php }?> <?php }} ?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['page']->value==($_smarty_tpl->tpl_vars['paginationCount']->value-1)) {?>
                                            <li class="disabled">
                                                <a href="javascript:void(0)">
                                                    <span>
										    			Next
										    		</span>
                                                </a>
                                            </li>
                                            <?php } else { ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="openOrders(0,<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                                    <span>
										    			Next
										    		</span>
                                                </a>
                                            </li>
                                            <?php }?>
                                            <li>
                                                <a href="javascript:void(0)" aria-label="Last" onclick="openOrders(0,<?php echo $_smarty_tpl->tpl_vars['paginationCount']->value-1;?>
,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                                    <span aria-hidden="true">
									         	&raquo;
									         </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" placeholder="Jump to Page" class="form-control input-sm scn-order-jump-page scn-order-page-margin" value="<?php if ($_smarty_tpl->tpl_vars['jump_page']->value&&$_smarty_tpl->tpl_vars['jump_page']->value!=0) {?><?php echo $_smarty_tpl->tpl_vars['jump_page']->value+1;?>
<?php }?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm scn-order-per-page scn-order-page-margin" name="order-per-page" onchange="openOrders(0,0,'',1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
									  <option value="20" <?php if ($_smarty_tpl->tpl_vars['perPage']->value==20) {?>selected="true"<?php }?>>20</option>
									  <option value="50" <?php if ($_smarty_tpl->tpl_vars['perPage']->value==50) {?>selected="true"<?php }?>>50</option>
									  <option value="100" <?php if ($_smarty_tpl->tpl_vars['perPage']->value==100) {?>selected="true"<?php }?>>100</option>
									  <option value="300" <?php if ($_smarty_tpl->tpl_vars['perPage']->value==300) {?>selected="true"<?php }?>>300</option>
									</select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary scn-order-page-margin btn-sm" onclick="openOrders(0,0,'',0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">Submit</button>
                                        <button type="button" class="btn btn-default btn-sm" onclick="openOrders(0,0,50,1,'id_order','DESC',0)">Reset</button>
                                    </div>
                                    <table class="table table-striped table-condensed no-more-tables" id="scn-orders">
                                        <thead>
                                            <tr class="scn-orders-head">
                                                <th>Id
                                                    <a href="#" onclick="openOrders(0,0,50,1,'id_order','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'id_order','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Company
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>User
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','ASC',1)">
                                                        <span class='cur-poi'>
                                                            <i class="fa fa-sort-asc"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'customer','DESC',1)">
                                                        <span class='cur-poi'>
                                                            <i class="fa fa-sort-desc"></i>
                                                        </span>
                                                    </a>
                                                </th>
                                                <th>Type
                                                    <a href="#" onclick="openOrders(0,0,50,1,'buyer_type','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'buyer_type','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Delivery State
                                                    <a href="#" onclick="openOrders(0,0,50,1,'state_name','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'state_name','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Total
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_total','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_total','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Payment
                                                    <a href="#" onclick="openOrders(0,0,50,1,'payment','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'payment','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Status
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_state_name','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'order_state_name','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Fc
                                                    <a href="#" onclick="openOrders(0,0,50,1,'fc_city','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'fc_city','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>
                                                <th>Date
                                                    <a href="#" onclick="openOrders(0,0,50,1,'date_added','ASC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-asc"></i>
						            					</span>
                                                    </a>
                                                    <a href="#" onclick="openOrders(0,0,50,1,'date_added','DESC',1)">
                                                        <span class='cur-poi'>
						            						<i class="fa fa-sort-desc"></i>
						            					</span>
                                                    </a>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="scn-orders-filters">
                                                <td data-title="Id">
                                                    <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['id_order']->value) {?><?php echo $_smarty_tpl->tpl_vars['id_order']->value;?>
<?php }?>" name="id_order" class="form-control input-sm" id="idOrder">
                                                </td>
                                                <td data-title="Company">
                                                    <input type="text" name="company" value="<?php if ($_smarty_tpl->tpl_vars['group']->value) {?><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
<?php }?>" class="form-control input-sm" id="companyName">
                                                </td>
                                                <td data-title="Customer">
                                                    <input type="text" name="customer" value="<?php if ($_smarty_tpl->tpl_vars['customer']->value) {?><?php echo $_smarty_tpl->tpl_vars['customer']->value;?>
<?php }?>" class="form-control input-sm" id="customerName">
                                                </td>
                                                <td data-title="Type">
                                                    <select class="form-control input-sm" name="id_buyer" id="idBuyer">
					            					  <option value="">--</option>
													  <option value="3" <?php if ($_smarty_tpl->tpl_vars['buyer_type']->value==3) {?>selected=""<?php }?>>B</option>
													  <option value="9" <?php if ($_smarty_tpl->tpl_vars['buyer_type']->value==9) {?>selected=""<?php }?>>C</option>
                                                      <option value="10" <?php if ($_smarty_tpl->tpl_vars['buyer_type']->value==10) {?>selected=""<?php }?>>P</option>
													</select>
                                                </td>
                                                <td data-title="Delivery State">
                                                    <select class="form-control input-sm" name="id_state" id="idState">
					            					    <option value="">-------</option>
													  <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['state_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
													  	<option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_state'];?>
" <?php if ($_smarty_tpl->tpl_vars['state']->value==$_smarty_tpl->tpl_vars['data']->value['id_state']) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
</option>
													  <?php } ?>
													</select>
                                                </td>
                                                <td data-title="Total">
                                                    <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['order_total_list']->value) {?><?php echo $_smarty_tpl->tpl_vars['order_total_list']->value;?>
<?php }?>" name="order_total" class="form-control input-sm" id="orderTotal">
                                                </td>
                                                <td data-title="Payment">
                                                    <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['payment']->value) {?><?php echo $_smarty_tpl->tpl_vars['payment']->value;?>
<?php }?>" class="form-control input-sm" name="payment_type" id="paymentType">
                                                </td>
                                                <td data-title="Status">
                                                    <select class="form-control input-sm" name="id_order_state" id="idOrderState">
					            						<option value="">-------</option>
					            					  <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_state']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
													  	<option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_state'];?>
" <?php if ($_smarty_tpl->tpl_vars['order_status']->value==$_smarty_tpl->tpl_vars['data']->value['id_order_state']) {?>selected=""<?php }?>>
													  		<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>

													  	</option>
													  <?php } ?>
													</select>
                                                </td>
                                                <td data-title="Fc">
                                                    <select class="form-control input-sm" name="id_fc" id="idFc">
					            						<option value="">----</option>
													  <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fc']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_fulfillment_centre'];?>
" 
														<?php if ($_smarty_tpl->tpl_vars['id_fc']->value==$_smarty_tpl->tpl_vars['data']->value['id_fulfillment_centre']) {?>selected="true"<?php }?>>
															<?php echo $_smarty_tpl->tpl_vars['data']->value['city_name'];?>

														</option>
													  <?php } ?>
													</select>
                                                </td>
                                                <td data-title="Date" class="scn-orders-filters-date-search">
                                                    <div class="scn-orders-filters-date">
                                                        <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['from_date']->value) {?><?php echo $_smarty_tpl->tpl_vars['from_date']->value;?>
<?php }?>" name="from_date" id="order-date-from" placeholder="From Date" class="form-control input-sm">
                                                        <input type="text" name="to_date" value="<?php if ($_smarty_tpl->tpl_vars['to_date']->value) {?><?php echo $_smarty_tpl->tpl_vars['to_date']->value;?>
<?php }?>" id="order-date-to" placeholder="To Date" class="form-control input-sm">
                                                    </div>
                                                    <div class="scn-orders-filters-search">
                                                        <button type="submit" id="submitFilterButtonorder" name="submitFilter" class="btn btn-white btn-sm" data-list-id="order" onclick="openOrders(0,0,50,0,'id_order','DESC',1)">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                            <tr class="order-data-scn" id=<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
>
                                                <td data-title="Id" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['splitOrder']) {?>
                                                        <i class="splitOrderAction fa fa-plus-circle" id="i_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
"></i>
                                                    <?php }?>
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
                                                     
                                                </td>
                                                <td data-title="Company" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['company']&&$_smarty_tpl->tpl_vars['data']->value['company']!='Default') {?><?php echo $_smarty_tpl->tpl_vars['data']->value['company'];?>
<?php } elseif ($_smarty_tpl->tpl_vars['data']->value['address_company']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['address_company'];?>
<?php } elseif ($_smarty_tpl->tpl_vars['data']->value['cus_name']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['cus_name'];?>
<?php } else { ?>----<?php }?>
                                                </td>
                                                <td data-title="User" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['cus_name']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['cus_name'];?>
<?php } else { ?>----<?php }?>
                                                </td>
                                                <td data-title="Type" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['buyer_type']==3) {?>
                                                    <span>(B)</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['buyer_type']==10) {?>
                                                    <span>(P)</span> <?php } else { ?>
                                                    <span>(C)</span> <?php }?>
                                                </td>
                                                <td data-title="Delivery State" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['state_name'];?>

                                                </td>
                                                <td data-title="Total" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>(Tools::ps_round(Tools::convertPrice($_smarty_tpl->tpl_vars['data']->value['order_total'],$_smarty_tpl->tpl_vars['currency']->value))),'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>

                                                </td>
                                                <td data-title="Payment" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['payment'];?>

                                                </td>
                                                <td data-title="Status" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <span class="label color_field" style="color: #383838;background-color: <?php echo $_smarty_tpl->tpl_vars['data']->value['color'];?>
;"><?php echo $_smarty_tpl->tpl_vars['data']->value['order_state_name'];?>
</span>
                                                </td>
                                                <td data-title="FC" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['fc_city']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['fc_city'];?>
<?php } else { ?>---<?php }?>
                                                </td>
                                                <td data-title="Date" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="cur-poi">
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['date_added'];?>

                                                </td>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['tab']->value!='') {?>
                <div role="tabpanel" class="tab-pane fade" id="singleOrderView">
                    <div class="panel-body">
                        <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="col-md-9 m-bot15">
                                <h4>#<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['company']->value->name[1];?>
 - ( <?php echo $_smarty_tpl->tpl_vars['stateObj']->value->name;?>
 )</h4>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="cur-poi btn btn-round btn-primary pull-right" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,0, '<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
', 1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Order Status</header>
                                <div class="panel-body panel scn-fc-grid">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <h5><strong><?php echo $_smarty_tpl->tpl_vars['currentState']->value['name'];?>
</strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="img/statusIcon/32/<?php echo $_smarty_tpl->tpl_vars['currentState']->value['id_order_state'];?>
.png" class="img-rounded">
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control input-sm" name="order_state_change" id="order_state_change">
		                                    <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['states']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
		                                        <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_state'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['id_order_state']==$_smarty_tpl->tpl_vars['currentState']->value['id_order_state']) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
</option>
		                                    <?php } ?>
		                                </select>
                                    </div>
                                    <div class="col-md-3 m-bot20">
                                        <button class="btn btn-primary btn-sm" onclick="changeStatus(2,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" <?php if ($_smarty_tpl->tpl_vars['block_account']->value) {?>disabled<?php }?>>
		                                    Change
		                                </button>
                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['block_account']->value) {?>
                                    <div class="col-md-12 text-danger_new">
                                        Sorry we cannot process this order
                                    </div>
                                    <?php }?>
                                    <div class="col-md-12 pull-left">
                                        <a href="#viewAllStatus_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
" class="view-all-status-scn" data-toggle="modal">View Status History</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Fulfillment Centre</header>
                                <div class="panel-body panel scn-fc-grid">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <h5><strong><?php echo $_smarty_tpl->tpl_vars['fc_city']->value->city_name;?>
</strong></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="img/icons/city-icons/<?php echo $_smarty_tpl->tpl_vars['order']->value->id_fc;?>
.png" class="image-responsive scn-icons-opacity" width="30" height="30">
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control input-sm" id="fc_block_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
">
                                            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fc']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_fulfillment_centre'];?>
" 
                                                <?php if ($_smarty_tpl->tpl_vars['data']->value['id_fulfillment_centre']==$_smarty_tpl->tpl_vars['order']->value->id_fc) {?>selected=""<?php }?>>
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['city_name'];?>

                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="changeFc(7,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
', 1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
		                                    Change
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Estimated Delivery time</header>
                                <div class="panel-body panel scn-est-del-grid" style="position: relative; width: auto; height: 190px;">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-0"></div>
                                        <div class="col-md-12">
                                            <h5><strong>
    	                                    	<?php if ($_smarty_tpl->tpl_vars['order']->value->estimated_delivery_time=="0000-00-00 00:00:00") {?>
    	                                    		<span class="text-danger">Not Available</span>
    	                                    	<?php } else { ?>
    	                                    		<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['order']->value->estimated_delivery_time,"%B %e, %Y, %I:%M %p");?>

    	                                    	<?php }?></strong>
                                        	</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-calendar-check-o" style="font-size:30px;"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control input-sm" id="estimated_delivery_time" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->estimated_delivery_time;?>
">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="changeDelTime(8,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
		                                    Change
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-3 m-bot20">
                            <div class="col-md-12">
                                <header class="panel-heading">Shipping Details</header>
                                <div class="panel-body panel scn-est-del-grid" style="position: relative; overflow: hidden; width: auto; height: 190px;">
                                    <div class="col-md-12 m-bot15">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                             <select class="form-control input-sm" id="tracking_no_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
">
                                            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carriers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_carrier'];?>
" 
                                                <?php if ($_smarty_tpl->tpl_vars['data']->value['id_carrier']==$_smarty_tpl->tpl_vars['order']->value->id_carrier) {?>selected=""<?php }?>>
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>

                                                </option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-truck"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control input-sm" id="tracking_number" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->shipping_number;?>
">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" onclick="setTrackingNumber(9,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
		                                    Save
		                                </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 m-bot15">
                                <div class="col-md-12">
                                <header class="panel-heading">Order Detail</header>
                                <div class="panel scn-order-detail">
                                    <!-- <div class="m-bot25"> -->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Original Cart</td>
                                                    <td><strong>Cart #<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['cart']->value->id);?>
</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Mode</td>
                                                    <td class="payment_mode">
                                                        <strong>
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->payment) {?><?php echo Tools::substr($_smarty_tpl->tpl_vars['order']->value->payment,0,32);?>
<?php } else { ?>---<?php }?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Customer PO</td>
                                                    <td>
                                                        <strong>
                                                        <?php if ($_smarty_tpl->tpl_vars['order_po_name']->value) {?>
                                                            <?php echo $_smarty_tpl->tpl_vars['order_po_name']->value;?>
 
                                                            <?php if ($_smarty_tpl->tpl_vars['budget']->value) {?>
                                                                <form id="budgetPoDownload" action="<?php echo $_smarty_tpl->tpl_vars['baseDir']->value;?>
purchase-order.php">
                                                                    <a href="javascript::void(0)" title="Download Customer PO" onclick="downloadBudgetPo()" class="text-success">
                                                                        ( <span class="fa fa-download"> )</span>
                                                                    </a>
                                                                    <input type="hidden" name="type" value="4" />
                                                                    <input type="hidden" name="po_string" value="<?php echo mb_strtolower($_smarty_tpl->tpl_vars['order_po_name']->value, 'UTF-8');?>
" />
                                                                </form>
                                                            <?php } else { ?>
                                                                <a href="customer_PO/<?php echo $_smarty_tpl->tpl_vars['order_po_name']->value;?>
" title="Download Customer PO" download class="text-success">
                                                                    ( <span class="fa fa-download"> )</span>
                                                                </a>
                                                            <?php }?>
                                                        <?php } else { ?>
                                                            <?php if (isset($_smarty_tpl->tpl_vars['order']->value->po_number)&&$_smarty_tpl->tpl_vars['order']->value->po_number) {?><span><?php echo $_smarty_tpl->tpl_vars['order']->value->po_number;?>
</span><?php } else { ?>---<?php }?>
                                                        <?php }?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php if (isset($_smarty_tpl->tpl_vars['order_placed_by']->value)&&$_smarty_tpl->tpl_vars['order_placed_by']->value) {?>
                                                    <tr>
                                                        <td>Order Placed By</td>
                                                        <td>
                                                            <strong>
                                                            <?php echo $_smarty_tpl->tpl_vars['order_placed_by']->value;?>

                                                            </strong>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                                <tr>
                                                    <td>Product Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        <?php echo Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_paid_tax_excl,$_smarty_tpl->tpl_vars['currency']->value,false);?>

                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tax Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        <?php echo Tools::displayPrice(($_smarty_tpl->tpl_vars['order']->value->total_paid_tax_incl-$_smarty_tpl->tpl_vars['order']->value->total_paid_tax_excl),$_smarty_tpl->tpl_vars['currency']->value,false);?>

                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Discount Value</td>
                                                    <td align="right">
                                                        <strong>
                                                        <?php echo Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_discounts,$_smarty_tpl->tpl_vars['currency']->value,false);?>

                                                        </strong>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td align="right"><strong><?php echo Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_paid_tax_incl,$_smarty_tpl->tpl_vars['currency']->value,false);?>
</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- </div> -->
                                </div>
                                </div>
                            </div>
                            <div class="col-md-8 m-bot15">
                                <div class="col-md-12">
                                    <header class="panel-heading">Order Comments <i class="fa fa-expand pull-right text-info cur-poi" onclick="getFullConversation(<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_employee;?>
)" title="Expand Conversation" aria-hidden="true"></i></header>
                                    <div class="panel-body panel" id="orderMessages_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
">
                                    	<div class="message-body-order" style="height:200px;">
                                            <?php if ($_smarty_tpl->tpl_vars['order_messages']->value) {?> 
                                                <?php if (($_smarty_tpl->tpl_vars['cookie']->value->profile==5)) {?>
                                                    <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['private']!=4) {?>
                                                            <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_employee==$_smarty_tpl->tpl_vars['data']->value['id_employee']) {?>
                                                                <div class="col-md-12 m-bot20">
                                                                    <div class="col-md-6 col-md-offset-5">
                                                                        <div class="talk-bubble tri-right right-top">
                                                                            <div class="talktext">
                                                                                <p>
                                                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                                                        <span class="text-danger">Private:</span><br/> 
                                                                                    <?php }?> 
                                                                                    <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
<br>
                                                                                    <span class="order-comment-time">
                                                                                        <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                                                                        <?php } else { ?>
                                                                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                                                                        <?php }?>
                                                                                    </span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="col-md-12 m-bot20">
                                                                    <div class="col-md-6">
                                                                        <div class="talk-bubble tri-right left-top">
                                                                            <div class="talktext">
                                                                                <p>
                                                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                                                        <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                                                                    <?php }?> 
                                                                                    <span class="text-info">
                                                                                        <strong>From <?php if ($_smarty_tpl->tpl_vars['data']->value['efirstname']) {?>
                                                                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['efirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['elastname'];?>

                                                                                                <?php } else { ?>
                                                                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['cfirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['clastname'];?>

                                                                                                <?php }?>
                                                                                        </strong>
                                                                                    </span><br/> 
                                                                                    <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
 <br>
                                                                                    <span class="order-comment-time">
                                                                                        <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                                                                       <?php } else { ?>
                                                                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                                                                       <?php }?>
                                                                                    </span><br />
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }?> 
                                                        <?php }?>
                                                    <?php } ?>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['cookie']->value->profile==6) {?>
                                                    <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?> 
                                                        <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_employee==$_smarty_tpl->tpl_vars['data']->value['id_employee']) {?>
                                                        <div class="col-md-12 m-bot20">
                                                            <div class="col-md-6 col-md-offset-5">
                                                                <div class="talk-bubble tri-right right-top">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                                                <span class="text-danger">Private:</span><br/>
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['private']==4) {?>
                                                                                <span class="text-danger">SCN Only</span><br/>
                                                                            <?php }?> 
                                                                            <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
<br>
                                                                            <span class="order-comment-time">
                                                                                <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                                                                <?php } else { ?>
                                                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                                                                <?php }?>
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="col-md-12 m-bot20">
                                                            <div class="col-md-6">
                                                                <div class="talk-bubble tri-right left-top">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                                                <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                                                            <?php }?> 
                                                                            <span class="text-info">
                                                                                <strong>From <?php if ($_smarty_tpl->tpl_vars['data']->value['efirstname']) {?>
                                                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['efirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['elastname'];?>

                                                                                        <?php } else { ?>
                                                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['cfirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['clastname'];?>

                                                                                        <?php }?>
                                                                                </strong>
                                                                            </span><br/> 
                                                                            <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
 <br>
                                                                            <span class="order-comment-time">
                                                                                <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                                                               <?php } else { ?>
                                                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                                                               <?php }?>
                                                                            </span><br />
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }?> 
                                                    <?php } ?>
                                                <?php }?>
                                            <?php } else { ?>
                                                <h5 class="text-center text-danger">Messages Not Available.</h5>
                                            <?php }?>
                                        </div>
                                        <form action="" onsubmit="submitMessage(<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,1,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
); return false;" id="submitMessage">
    	                                    <div class="col-md-12" id="scn-add-order-comment">
    	                                    	<div class="col-md-6">
    	                                    		<textarea class="form-control" placeholder="Type comment here" name="message" id="text_message" rows="2" required maxlength="1600"></textarea>
    	                                    	</div>
                                                <?php if (($_smarty_tpl->tpl_vars['cookie']->value->profile==5)) {?>
    		                               		<div class="col-md-3 orderCommentDisplay">
    			                               			<label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusFalse" value="1" checked="checked"> Kobster
                                                            </label>
    				                                         <label class="radio-inline">
    				                                          <input type="radio" name="visibility" id="displayToCusTrue" value="0"> Customer
    				                                        </label> 
    				                                    </label>
    		                               		</div>
                                                <?php }?>
                                                <?php if (($_smarty_tpl->tpl_vars['cookie']->value->profile==6)) {?>
                                                <div class="col-md-3 orderCommentDisplay">
                                                        <label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusFalse" value="1" checked="checked"> RM + SCN
                                                            </label>
                                                             <label class="radio-inline">
                                                              <input type="radio" name="visibility" id="displayToCusTrue" value="4"> SCN only
                                                            </label> 
                                                        </label>
                                                </div>
                                                <?php }?>
    		                               		<div class="col-md-1">
    		                               			<a class="cur-poi" title="Send" onclick="$('#submitMessageBtn').click();"><img src="img/icons/chat_send.png" class="image-responsive scn-icons-opacity"></a>
    			                               	    <button type="submit" id="submitMessageBtn" class="btn btn-primary display-none">Submit</button>
                                                </div>
    			                               	<input type="hidden" name="id_order_single" value="<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
">
    				                            <input type="hidden" name="type" value="1">
    				                            <input type="hidden" name="smarty" value="0">
    				                            <input type="hidden" name="tab" value="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
">
                                                
    		                               	</div>
    	                               	</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                <header class="panel-heading"><?php if ($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==$_smarty_tpl->tpl_vars['tax_exclusive']->value) {?>PRODUCT LIST (TAX EXCL.)<?php } else { ?>PRODUCT LIST(TAX INCL.)<?php }?></header>
                                <?php if ($_smarty_tpl->tpl_vars['perksCustomerFile']->value!='') {?>
                                <div class="col-md-12 btn-success">
                                  <div class="col-md-12">
                                    <span><h3>Perks Order</h3></span>
                                    <p>Please download and verify the ID PROOF by clicking <a href="<?php echo $_smarty_tpl->tpl_vars['perksCustomerFile']->value;?>
" target="_blank" style="color: #F44336;text-decoration: underline;">here</a> and process the order.</p>
                                  </div>
                                </div>
                                <?php }?>
                                <div class="panel-body panel">
                                    <?php if ($_smarty_tpl->tpl_vars['product_detail']->value) {?>
                                    <div class="m-bot20"><?php if (!Configuration::get('PS_ORDER_RETURN')) {?>( Merchandise returns are disabled )<?php } else { ?><?php }?></div>
                                    <form id="productListOrder" action="" method="post">
                                        <div class="no-more-tables">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th></th>
                                                        <th>Product</th>
                                                        <th class="text-right">Price</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-right">Total</th>
                                                        <th class="text-center">Delivered</th>
                                                        <th>
                                                            <label class="checkbox-inline">
				                                              <input type="checkbox" id="select-all-product" class="input-sm" value=""> Select
				                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?> <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['product_detail']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
                                                    <tr>
                                                        <td data-title="S.No">
                                                            <?php echo $_smarty_tpl->tpl_vars['i']->value++;?>

                                                        </td>
                                                        <td data-title="">
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['image_link'];?>
" alt="..." class="img-rounded">
                                                        </td>
                                                        <td data-title="Name">
                                                            <div><?php echo $_smarty_tpl->tpl_vars['data']->value['product_name'];?>
</div>
                                                            <div><?php if ($_smarty_tpl->tpl_vars['data']->value['product_reference']) {?>Ref: <?php echo $_smarty_tpl->tpl_vars['data']->value['product_reference'];?>
<?php } else { ?><?php }?></div>
                                                            <div><?php if ($_smarty_tpl->tpl_vars['data']->value['product_supplier_reference']) {?>Ref Supplier: <?php echo $_smarty_tpl->tpl_vars['data']->value['product_supplier_reference'];?>
<?php } else { ?><?php }?></div>
                                                        </td>
                                                        <td data-title="Price" class="text-right">
                                                            <?php echo Tools::displayPrice($_smarty_tpl->tpl_vars['data']->value['product_price_true'],$_smarty_tpl->tpl_vars['currency']->value,false);?>

                                                        </td>
                                                        <td data-title="Quantity" class="text-center">
                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_true'];?>

                                                            <input type="hidden" id="updateQuantity_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_true'];?>
">
                                                        </td>
                                                        <td data-title="Total" class="text-right">
                                                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>(Tools::ps_round($_smarty_tpl->tpl_vars['data']->value['product_price_true'],2)*($_smarty_tpl->tpl_vars['data']->value['product_quantity']-$_smarty_tpl->tpl_vars['data']->value['customizationQuantityTotal'])),'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>

                                                        </td>
                                                        <td id="delivered_qty_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
" data-title="Delivered" class="text-center">
                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_delivered'];?>

                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline cancelCheck">
				                                              <input type="checkbox" name="id_order_detail[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
]" onchange="setCancelQuantity(this, <?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
, <?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_in_stock']-$_smarty_tpl->tpl_vars['data']->value['customizationQuantityTotal']-$_smarty_tpl->tpl_vars['data']->value['product_quantity_reinjected'];?>
)" class="quantity-checkbox input-sm" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
">
				                                              <input type="hidden" name="totalQtyReturn" class="totalQtyReturn" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_return'];?>
" />
															  <input type="hidden" name="totalQty" class="totalQty" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['product_quantity_true'];?>
" />
															  <input type="hidden" name="productName" class="productName" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['product_name'];?>
" />
				                                              <input type="text" name="cancelQuantity[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
]" id="quantity_box_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
" class="form-control cancelQuantity input-sm quantity_box_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
">
                                                              <input type="hidden" id="po_number" name="po_number" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->po_number;?>
">
                                                              <input type="hidden" id="po_file" name="po_file" value="<?php if ($_smarty_tpl->tpl_vars['order_po_name']->value) {?><?php echo $_smarty_tpl->tpl_vars['order_po_name']->value;?>
<?php }?>" >
				                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if ($_smarty_tpl->tpl_vars['block_account']->value) {?>
                                            <div class="col-md-12 text-danger_new">
                                                Kindly request the user to process the pending payments to resume our services
                                            </div>
                                            <?php } else { ?>
                                            
                                            <div class="padding10">
                                                <?php if (Configuration::get('PS_ORDER_RETURN')&&!$_smarty_tpl->tpl_vars['order']->value->isInvoiceGenerated()) {?>
                                                <label class="checkbox-inline">
				                                      <input type="checkbox" name="generateDiscount" id="generateDiscount" value="1" onclick="toogleShippingCost(this)"> Generate a Voucher
				                                    </label>
                                                <label class="checkbox-inline display-none" id="spanShippingBack">
				                                      <input type="checkbox" name="shippingBack" id="repayShippingCheck" value="1"> Repay Shipping Costs
				                                    </label> <?php }?>
                                            </div>
                                            
                                            <div class="text-center col-md-12 m-bot15">
                                                <?php if (!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()) {?>
                                                <button type="button" class="btn btn-primary btn-sm prod-action-btn" onclick="cancelProduct(1,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">Cancel/Remove Products</button> 
                                                <?php } else { ?>
                                                    <button type="button" disabled="" class="btn btn-primary btn-sm prod-action-btn-disabled" onclick="cancelProduct(1,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">Cancel/Remove Products</button> 
                                                <?php }?>
                                                
                                                <?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenShipped()||$_smarty_tpl->tpl_vars['order']->value->hasBeenPartiallyShipped()||$_smarty_tpl->tpl_vars['order']->value->packedandreadytobeshipped())&&!$_smarty_tpl->tpl_vars['order']->value->isInvoiceGenerated()) {?>
                                                    <button type="button" class="btn btn-primary btn-sm prod-action-btn" onclick="$('#dr-label-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
').slideToggle();">Generate DR</button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-primary btn-sm prod-action-btn-disabled" disabled="" onclick="$('#dr-label-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
').slideToggle();">Generate DR</button>
                                                <?php }?>
                                                <?php if (!$_smarty_tpl->tpl_vars['order']->value->hasBeenShipped()&&!$_smarty_tpl->tpl_vars['order']->value->hasBeenPartiallyShipped()&&!$_smarty_tpl->tpl_vars['order']->value->packedandreadytobeshipped()&&$_smarty_tpl->tpl_vars['order']->value->total_discounts==0) {?>
                                                    <button type="button"  <?php if ($_smarty_tpl->tpl_vars['order']->value->payment!='EBS') {?><?php } else { ?>disabled=""<?php }?> class="btn btn-sm btn-primary prod-action-btn-danger <?php if (count($_smarty_tpl->tpl_vars['product_detail']->value)==1&&$_smarty_tpl->tpl_vars['product_detail']->value[0]['product_quantity_true']==1) {?>hidden<?php }?>" onclick="confirmSplit(1,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
', 1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">Split Order</button>
                                                <?php }?>
                                            </div>
                                            <?php }?>
                                            <div class="col-md-2"></div>
                                            <div class="clear"></div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8 scn-label-grid">
                                                <div class="padding10 box-edit display-none" id="dr-label-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
">
                                                    <div class="form-group">
                                                        <label for="kobsterLabel">Kobster boxes</label>
                                                        <input type="text" name="kob_box" class="form-control" id="kobsterLabel" required placeholder="Enter required kobster boxes" value="0">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="otherLabel">Other boxes</label>
                                                        <input type="text" name="other_box" class="form-control" id="otherLabel" required placeholder="Enter required other boxes" value="0">
                                                    </div>
                                                    <button type="button" onclick="generateDR(1,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <input type="hidden" name="tab" value="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
" />
                                        <input type="hidden" name="id_order_single" value="<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
" />
                                    </form>
                                    <?php } else { ?>
                                    <h5 class="text-center text-danger">No Products Available</h5> <?php }?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="customerInfo">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-md-9 m-bot15">
                                <h4>#<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['company']->value->name[1];?>
 - ( <?php echo $_smarty_tpl->tpl_vars['stateObj']->value->name;?>
 )</h4>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="cur-poi btn btn-round btn-primary pull-right" onclick="orderDetail(<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,0, '<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
', 2, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <header class="panel-heading">Customer Details</header>
                            <div class="col-md-12 panel scn-customer-detail">
                                <!-- <div class="m-bot25"> -->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Company</td>
                                                <td><strong><?php echo $_smarty_tpl->tpl_vars['company']->value->name[1];?>
</strong></td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>
                                                    <strong>
                                                    <?php echo $_smarty_tpl->tpl_vars['customerObj']->value->firstname;?>
<?php echo $_smarty_tpl->tpl_vars['customerObj']->value->lastname;?>

                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User ID</td>
                                                <td>
                                                    <strong>
                                                    <?php echo $_smarty_tpl->tpl_vars['customerObj']->value->id;?>

                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User Email</td>
                                                <td>
                                                    <strong>
                                                    <?php echo $_smarty_tpl->tpl_vars['customerObj']->value->email;?>

                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Registered On</td>
                                                <td>
                                                    <strong>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['customerObj']->value->date_add,"%A, %B %e, %Y, %r");?>

                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Orders Placed Since</td>
                                                <td>
                                                    <strong>
                                                    <?php echo $_smarty_tpl->tpl_vars['cus_total_performance']->value['nb_orders'];?>

                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tansaction Amount Total</td>
                                                <td>
                                                    <strong>
                                                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>(Tools::ps_round(Tools::convertPrice($_smarty_tpl->tpl_vars['cus_total_performance']->value['total_orders'],$_smarty_tpl->tpl_vars['currency']->value))),'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>

                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Shipping Address</header>
                                <div class="padding10 panel scn-address-grid">
                                    <?php echo $_smarty_tpl->tpl_vars['shipping_address']->value;?>

                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice Address</header>
                                <div class="padding10 panel scn-address-grid">
                                    <?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice</header>
                                <div class="panel-body panel scn-invoice-grid">
                                    <?php if (Configuration::get('PS_INVOICE')&&$_smarty_tpl->tpl_vars['consolidated_invoice']->value!=''&&$_smarty_tpl->tpl_vars['order']->value->invoice_number) {?>
                                    <h5 class="text-center">Download Invoice</h5>
                                    <h5 class="text-center">
			                            <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&submitAction=generateConsolidatedInvoicePdf<?php echo $_smarty_tpl->tpl_vars['consolidated_invoice']->value;?>
" download>
			                                #IN<?php echo $_smarty_tpl->tpl_vars['invoice_number']->value;?>
  (<i class="fa fa-download text-success" title="Download Invoice"></i>)
			                            </a>
			                        </h5> 
                                    <?php } elseif (Configuration::get('PS_INVOICE')&&count($_smarty_tpl->tpl_vars['invoices_collection']->value)&&$_smarty_tpl->tpl_vars['order']->value->invoice_number) {?>
                                    <h5 class="text-center">Download Invoice</h5>
                                    <h5 class="text-center">
			                            <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&submitAction=generateInvoicePDF&id_order=<?php echo intval($_smarty_tpl->tpl_vars['order']->value->id);?>
" download>
			                                #IN<?php echo $_smarty_tpl->tpl_vars['invoice_number']->value;?>
 (<i class="fa fa-download text-success" title="Download Invoice"></i>)
			                            </a>
			                        </h5> 
                                    <?php } else { ?>
                                    <h5 class="text-center text-danger">Invoice Not Available</h5> 
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-md-6 m-bot20">
                                <header class="panel-heading">Invoice Acknowledgement</header>
                                <div class="panel-body panel scn-invoice-grid">
                                <?php if ($_smarty_tpl->tpl_vars['invoice_file']->value!='') {?>
                                    <h5 class="text-center">Download Invoice Acknowledgement</h5>
                                    <h4 class="text-center">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['invoice_file']->value;?>
" download>
                                            (<i class="fa fa-download text-success" title="Download Invoice ACK"></i>)
                                        </a>
                                    </h4> 
                                <?php } else { ?>
                                    <h5 class="text-center text-danger">Invoice Acknowledgement Not Available</h5> 
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <header class="panel-heading">Delivery Receipt & Label</header>
                            <div class="panel-body panel">
                                <?php if ($_smarty_tpl->tpl_vars['delivery_slip']->value) {?>
                                <div class="col-md-12">
                                    <div class="col-md-2"><h5 class="text-left">Download DR</h5></div>
                                    <div class="col-md-2"><h5 class="text-left">Download Label</h5></div>
                                    <div class="col-md-8"></div>
                                </div>
                                <div class="col-md-12">
                                    <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['delivery_slip']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                    <form onsubmit="updateDeliverySlip('scanned-dr-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
',<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
, 2,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
', <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
); return false;" id="submit-document-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" method="post" enctype="multipart/form-data">
                                        <div class="col-md-2">
                                            <h5>
    		                                        <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&submitAction=generatePartialDeliverySlipPDF&id_order=<?php echo $_smarty_tpl->tpl_vars['id_order']->value;?>
&id_delivery=<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" download title="Download Delivery Slip">#<?php echo $_smarty_tpl->tpl_vars['data']->value['delivery_number'];?>
 ( <i class="fa fa-download text-success"></i> )
    		                                        </a>
    		                                    </h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>
    		                                        <a href="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&submitAction=generateDeliveryLabel&id_delivery_label=<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" download title="Download Label"> #<?php echo $_smarty_tpl->tpl_vars['data']->value['delivery_label'];?>
 ( <i class="fa fa-download text-success"></i> )
    		                                        </a>
    		                                    </h5>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="btn btn-white" onclick="$('#dr-label-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
').slideToggle();">
                                                        Edit Label <i class="fa fa-edit"></i>
                                                    </div>
                                                    <span class="btn btn-white btn-file">
    		                                                        <span class="fileupload-new">
    		                                                            <i class="fa fa-paper-clip"></i> 
    		                                                                Select Scanned DR copy <i class="fa fa-hand-o-up"></i>
    		                                                            </span>
                                                    <span class="fileupload-exists">
    		                                                            <i class="fa fa-undo"></i> Change
    		                                                            </span>
                                                    <input type="file" id="scanned-dr-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" class="default">
                                                    </span>
                                                    <span class="fileupload-preview marginleft5"></span>
                                                    <button class="btn btn-info" type="submit" title="Click here to upload scanned DR."><i class="fa fa-cloud-upload"> Upload</i></button> 
                                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['dr_file_name']&&empty($_smarty_tpl->tpl_vars['data']->value['files'])) {?>
                                                    <a href="scanedDRs/<?php echo $_smarty_tpl->tpl_vars['data']->value['dr_file_name'];?>
" download>
                                                        <span class="btn btn-primary">Download Scanned Copy 
    		                                                                <i class="fa fa-download"></i>
    		                                                            </span>
                                                    </a>
                                                    <?php } else { ?>
                                                        <?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
                                                            <a class="text-info" href="<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
" download>#<?php echo $_smarty_tpl->tpl_vars['data']->value['delivery_number'];?>
</a>
                                                        <?php } ?>
                                                    <?php }?>
                                                    <a href="#" class="close fileupload-exists scn-fileupload-exists marginleft5" data-dismiss="fileupload"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-7 col-md-offset-4 padding10 display-none" id="dr-label-<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
">
                                        <div class="padding10 box-edit">
                                            <form onsubmit="updateLabels('',<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
, 2,<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
); return false;">
                                                <div class="form-group">
                                                    <label for="kobsterLabel">Kobster boxes</label>
                                                    <input type="text" class="form-control" id="kobsterLabel_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" required placeholder="Enter required kobster boxes" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['kob_boxes'];?>
">
                                                </div>
                                                <div class="form-group">
                                                    <label for="otherLabel">Other boxes</label>
                                                    <input type="text" class="form-control" id="otherLabel_<?php echo $_smarty_tpl->tpl_vars['data']->value['id_delivery'];?>
" required placeholder="Enter required other boxes" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['other_boxes'];?>
">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <?php } ?></div><?php } else { ?>
                                <h5 class="text-center text-danger">Delivery Slip Not Available</h5> <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewAllStatus_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center modal-text-font">Order Status History</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-center">
                            <table class="table">
                                <tbody>
                                 <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['history']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                                    <tr>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['data']->value['id_order_state']==$_smarty_tpl->tpl_vars['currentState']->value['id_order_state']) {?>order_status_active<?php }?>">
                                            <img src="img/statusIcon/32/<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_state'];?>
.png" class="img-rounded">
                                        </td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['data']->value['id_order_state']==$_smarty_tpl->tpl_vars['currentState']->value['id_order_state']) {?>order_status_active<?php }?>">
                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['ostate_name'];?>
 
                                        </td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['data']->value['id_order_state']==$_smarty_tpl->tpl_vars['currentState']->value['id_order_state']) {?>order_status_active<?php }?>">
                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['employee_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['employee_lastname'];?>

                                        </td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['data']->value['id_order_state']==$_smarty_tpl->tpl_vars['currentState']->value['id_order_state']) {?>order_status_active<?php }?>">
                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['date_add'];?>

                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK" />
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
   <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
   <link href="dash/css/style.css" rel="stylesheet">
   <div class="panel-body panel" id="orderMessages_<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
">
    <div class="message-body col-md-10 col-md-offset-1">
    <header class="rm_heading m-bot20">Order Comment History for Order #<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
</header>
    <?php if ($_smarty_tpl->tpl_vars['messages']->value) {?> 
        <?php if (($_smarty_tpl->tpl_vars['cookie']->value->profile==5)) {?>
            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['data']->value['private']!=4) {?>
                    <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_employee==$_smarty_tpl->tpl_vars['data']->value['id_employee']) {?>
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-6 col-md-offset-5">
                                <div class="talk-bubble tri-right right-top">
                                    <div class="talktext">
                                        <p>
                                            <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                <span class="text-danger">Private:</span><br/> 
                                            <?php }?> 
                                            <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
<br>
                                            <span class="order-comment-time">
                                                <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                                <?php } else { ?>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                                <?php }?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 m-bot20">
                            <div class="col-md-6">
                                <div class="talk-bubble tri-right left-top">
                                    <div class="talktext">
                                        <p>
                                            <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                                <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                            <?php }?> 
                                            <span class="text-info">
                                                <strong>From <?php if ($_smarty_tpl->tpl_vars['data']->value['efirstname']) {?>
                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['efirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['elastname'];?>

                                                        <?php } else { ?>
                                                            <?php echo $_smarty_tpl->tpl_vars['data']->value['cfirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['clastname'];?>

                                                        <?php }?>
                                                </strong>
                                            </span><br/> 
                                            <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
 <br>
                                            <span class="order-comment-time">
                                                <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                               <?php } else { ?>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                               <?php }?>
                                            </span><br />
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?> 
                <?php }?>
            <?php } ?>
        <?php } elseif ($_smarty_tpl->tpl_vars['cookie']->value->profile==6) {?>
            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?> 
                <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_employee==$_smarty_tpl->tpl_vars['data']->value['id_employee']) {?>
                <div class="col-md-12 m-bot20">
                    <div class="col-md-6 col-md-offset-5">
                        <div class="talk-bubble tri-right right-top">
                            <div class="talktext">
                                <p>
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                        <span class="text-danger">Private:</span><br/>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['data']->value['private']==4) {?>
                                        <span class="text-danger">SCN Only</span><br/>
                                    <?php }?> 
                                    <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
<br>
                                    <span class="order-comment-time">
                                        <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                        <?php } else { ?>
                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                        <?php }?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-md-12 m-bot20">
                    <div class="col-md-6">
                        <div class="talk-bubble tri-right left-top">
                            <div class="talktext">
                                <p>
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['private']==1) {?>
                                        <span class="text-danger">Private:&nbsp;&nbsp;</span>
                                    <?php }?> 
                                    <span class="text-info">
                                        <strong>From <?php if ($_smarty_tpl->tpl_vars['data']->value['efirstname']) {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['efirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['elastname'];?>

                                                <?php } else { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['data']->value['cfirstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['clastname'];?>

                                                <?php }?>
                                        </strong>
                                    </span><br/> 
                                    <?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['message'], ENT_QUOTES);?>
 <br>
                                    <span class="order-comment-time">
                                        <?php if ((smarty_modifier_date_format(time(),"%D"))==(smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%D"))) {?>
                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p");?>

                                       <?php } else { ?>
                                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['date_add'],"%I:%M %p, %B %e, %Y");?>

                                       <?php }?>
                                    </span><br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?> 
            <?php } ?>
        <?php }?>
    <?php } else { ?>
        <h5 class="text-center text-danger">Messages Not Available.</h5>
    <?php }?>
<?php }?>


<div class="split-modal modal fade in" id="orderResultModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm prod-action-btn" id="new_order_btn"></button>
        <button type="button" class="splitClose btn btn-primary btn-sm prod-action-btn" data-dismiss="modal" id="old_order_btn"></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="split-modal modal fade in" id="splitcnfrm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Split Order - Confirmation</h4>
      </div>
      <div class="modal-body">
        <p>The Order <span id="splitcnfrmId"></span> will be split into different orders.The selected orders will be removed from this order and a new order will be placed.</p>
        <br>
        <p>Do you really want to split this order?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="splitClose btn btn-sm red-btn" id="new_order_btn">NO</button>
        <button type="button" class="btn btn-sm green-btn"  id="old_order_btn" onclick="splitOrder(<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
,0,'<?php echo $_smarty_tpl->tpl_vars['orderBy']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['orderWay']->value;?>
',1, <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">YES, SPLIT THE ORDER</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="split-modal modal fade in" id="splitError">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="splitClose close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="splitClose modal-title">Split Order - Failed</h4>
      </div>
      <div class="modal-body">
        <p>Unable to split the order <span id="splitErrorId"></span></p>
        <p>Please check if you have selected correct products,if this issue still exists kindly contact your manager.</p>
        <br>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="scn/js/scn-orders.js"></script>
<script src="scn/js/htmlbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var hb = $("#text_message").htmlbox({
        icons:"default",
        skin:"default"
    });
    $("#text_message_html").height("100");
    $(".text_message_tb").hide();
</script>
<style type="text/css">
    .text-danger_new{
        padding: 8px;
        background-color: #dc2d3c;
        color: white;
    }
</style><?php }} ?>
