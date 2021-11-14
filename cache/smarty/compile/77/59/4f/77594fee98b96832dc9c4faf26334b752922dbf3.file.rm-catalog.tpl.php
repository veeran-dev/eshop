<?php /* Smarty version Smarty-3.1.19, created on 2017-11-30 10:58:24
         compiled from "rm\rm-catalog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:244585a1f96f8a7b203-86437693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77594fee98b96832dc9c4faf26334b752922dbf3' => 
    array (
      0 => 'rm\\rm-catalog.tpl',
      1 => 1507801650,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '244585a1f96f8a7b203-86437693',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'customer_details' => 0,
    'customer' => 0,
    'product_details_others' => 0,
    'product' => 0,
    'group' => 0,
    'k' => 0,
    'currency' => 0,
    'read' => 0,
    'i' => 0,
    'hide' => 0,
    'product_details_price' => 0,
    'group2' => 0,
    'l' => 0,
    'j' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a1f96f942e5c5_27605097',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1f96f942e5c5_27605097')) {function content_5a1f96f942e5c5_27605097($_smarty_tpl) {?><link type="text/css" rel="stylesheet" href="dash/js/bootstrap-datepicker/css/datepicker.css" />
<script type="text/javascript" src="./rm/js/rm-catalog.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<div id="quotation-history-hidden" class="display-none">
    <form id="form_quotation_excel" name="form_invoice" action="scn-quote-excel.php" autocomplete="off" method="post" class="display-none">
        <div id="quotation-history-hidden-data">
        </div>
    </form>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Customer - Catalog history</div>
    <div class="panel-body">
    	<table id="example" class="display" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th class="table-header">
	                	<div>
	                		<div class="btn-container"><span class="btn btn-price active">Price</span><span class="btn btn-others">Others</span></div>
                		</div>
                	</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php  $_smarty_tpl->tpl_vars['customer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customer_details']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customer']->key => $_smarty_tpl->tpl_vars['customer']->value) {
$_smarty_tpl->tpl_vars['customer']->_loop = true;
?>
	        	<tr id="<?php echo $_smarty_tpl->tpl_vars['customer']->value['id_group'];?>
">
	        		<td class="details-control"><span><?php echo $_smarty_tpl->tpl_vars['customer']->value['name'];?>
</span> <label><?php echo $_smarty_tpl->tpl_vars['customer']->value['read_count'];?>
</label><span class="fa fa-chevron-down"></span></td>
	        	</tr>
	        	<?php } ?>	        	
	        </tbody>
	    </table>

		<div id="hidden_product_details" class="hidden">
		<?php $_smarty_tpl->tpl_vars['group'] = new Smarty_variable("0", null, 0);?>
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
		<?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable(1, null, 0);?>


		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_details_others']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
		<?php if ($_smarty_tpl->tpl_vars['product']->value['type']!=3&&$_smarty_tpl->tpl_vars['product']->value['type']!=4) {?>
			<?php if ($_smarty_tpl->tpl_vars['group']->value!=$_smarty_tpl->tpl_vars['product']->value['id_group']) {?>
				<?php $_smarty_tpl->tpl_vars['group'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_group'], null, 0);?>
				<div id="show_others_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
" class="active">
				<table class="product_details" id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_product_details">
					<thead>
						<th>S.no</th>
						<th>Product</th>
						<th>Notification</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTableDate(0, this, 'others', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
)"></span>
							</span>
							Date added
						</th>
						<th>Rate Contract</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTable(0, this, 'others')"></span>
							</span>
							Read / Unread 
							<input type="checkbox" onclick="readNotifications(this, 'show_others', '<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_product_details')" class="read_all">
						</th>
					</thead>
					<tbody class="show_others">
						<tr data-row-value="<?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>
" data-row-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['sort_date'];?>
">
							<td><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
 <br /> Ref: <?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['product']->value['notification'];?>
</td>
							<td class="date"><?php echo $_smarty_tpl->tpl_vars['product']->value['date_added'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
 <?php echo round($_smarty_tpl->tpl_vars['product']->value['sp'],2);?>
 upto <br /><?php echo $_smarty_tpl->tpl_vars['product']->value['expires'];?>
</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['status']==0) {?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-exclamation-circle", null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-check-circle", null, 0);?>
								<?php }?>
								<span id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
" onclick="readNotification(this, 'product_details', '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
);" class="read_notification fa <?php echo $_smarty_tpl->tpl_vars['read']->value;?>
"></span>
								<input value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
_checkbox" onchange="checkRows('<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_product_details', '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read', this)" class="read_check <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read" type="checkbox" name="" >
								<input type="hidden" class="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read_id_catalog_change hidden_id_catalog_change">
							</td>
						</tr>
				<?php if ($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['id_group']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value]['id_group']) {?>
					</tbody>
				</table>
				<div class="action-row">
					<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
, 'product_details')">Mark as read/unread</button>
				</div>
				</div>
				<?php }?>
			<?php } elseif ($_smarty_tpl->tpl_vars['group']->value==$_smarty_tpl->tpl_vars['product']->value['id_group']) {?>
						<tr class="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_row" data-row-value="<?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>
" data-row-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['sort_date'];?>
">
							<td>
								<?php if (($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name'])) {?>
								<?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable($_smarty_tpl->tpl_vars['k']->value+1, null, 0);?>
									<?php echo $_smarty_tpl->tpl_vars['k']->value;?>

								<?php } else { ?>
								<?php }?>
							</td>
							<td>
								<?php if (($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name'])) {?>
									<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
 <br /> Ref: <?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>

									<?php $_smarty_tpl->tpl_vars['hide'] = new Smarty_variable('', null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['hide'] = new Smarty_variable("hidden", null, 0);?>
								<?php }?>
							</td>
							<td> <?php echo $_smarty_tpl->tpl_vars['product']->value['notification'];?>
</td>
							<td class="date"> <?php echo $_smarty_tpl->tpl_vars['product']->value['date_added'];?>
</td>
							<td>
								<?php if (($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['name'])) {?>
									<?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
 <?php echo round($_smarty_tpl->tpl_vars['product']->value['sp'],2);?>
 upto <br /><?php echo $_smarty_tpl->tpl_vars['product']->value['expires'];?>

								<?php }?>
							</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['status']==0) {?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-exclamation-circle", null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-check-circle", null, 0);?>
								<?php }?>
							
								<span id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
" onclick="readNotification(this, 'product_details', '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
);" class="read_notification fa <?php echo $_smarty_tpl->tpl_vars['read']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['hide']->value;?>
"></span>
								<input value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
_checkbox" onchange="checkRows('<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_product_details', '<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read', this)" class="read_check <?php echo $_smarty_tpl->tpl_vars['hide']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read" type="checkbox" name="" >
								<?php if ($_smarty_tpl->tpl_vars['hide']->value=='') {?>
									<input type="hidden" class="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_read_id_catalog_change hidden_id_catalog_change">
								<?php }?>							
							</td>
						</tr>
				<?php if ($_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value-1]['id_group']!=$_smarty_tpl->tpl_vars['product_details_others']->value[$_smarty_tpl->tpl_vars['i']->value]['id_group']) {?>
						</tbody>
					</table>
					<div class="action-row">
						<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
, 'product_details')">Mark as read/unread</button>
					</div>
				</div>
				<?php $_smarty_tpl->tpl_vars['k'] = new Smarty_variable(1, null, 0);?>
				<?php }?>
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
		<?php }?>	
		<?php } ?>

		<?php $_smarty_tpl->tpl_vars['group2'] = new Smarty_variable("0", null, 0);?>
		<?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable(1, null, 0);?>
		<?php $_smarty_tpl->tpl_vars['l'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_details_price']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
		<?php if ($_smarty_tpl->tpl_vars['product']->value['type']==3||$_smarty_tpl->tpl_vars['product']->value['type']==4) {?>
			<?php if ($_smarty_tpl->tpl_vars['group2']->value!=$_smarty_tpl->tpl_vars['product']->value['id_group']) {?>
				<?php $_smarty_tpl->tpl_vars['group2'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_group'], null, 0);?>
				<div id="show_price_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
" class="unactive">
				<table class="product_details" id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_price_details">
					<thead>
						<th>S.no</th>
						<th>Product</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTableDate(0, this, 'price', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
)"></span>
							</span>
							Date added
						</th>
						<th>Location</th>
						<th>Changes</th>
						<th>Rate Contract</th>
						<th>New Quote</th>
						<th>
							<span class="sort">
								<span class="fa fa-chevron-up" onclick="sortTable(0, this, 'price')"></span>
							</span>
							Read / Unread 
							<input type="checkbox" onclick="readNotifications(this, 'show_price', '<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_price_details')" class="read_all">
						</th>
					</thead>
					<tbody class="show_price">
						<tr data-row-value="<?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>
" data-row-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['sort_date'];?>
">
							<td><?php echo $_smarty_tpl->tpl_vars['l']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
 <br /> Ref: <?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>
</td>
							<td class="date"><?php echo $_smarty_tpl->tpl_vars['product']->value['date_added'];?>
</td>
							<td><?php if ($_smarty_tpl->tpl_vars['product']->value['city_name']) {?><?php echo $_smarty_tpl->tpl_vars['product']->value['city_name'];?>
<?php } else { ?>All India<?php }?></td>
							<td><?php echo $_smarty_tpl->tpl_vars['product']->value['from'];?>
 -- <?php echo $_smarty_tpl->tpl_vars['product']->value['to'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
 <?php echo round($_smarty_tpl->tpl_vars['product']->value['sp'],2);?>
 upto <br /><?php echo $_smarty_tpl->tpl_vars['product']->value['expires'];?>
</td>
							<td class="rate_contract">
								<div>
									<input type="text" placeholder="New Price" name="Price" class="price">
								</div>
								<div>
									<input type="text" placeholder="Expiry" name="Expiry" class="datepicker">
								</div>
								<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" name="id_product" class="product_id">
							</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['status']==0) {?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-exclamation-circle", null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-check-circle", null, 0);?>
								<?php }?>
								<span id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
" onclick="readNotification(this, 'price_details', '<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
);" class="read_notification fa <?php echo $_smarty_tpl->tpl_vars['read']->value;?>
"></span>
								<input value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
_checkbox" onchange="checkRows('<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_price_details', '<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read', this)" class="read_check <?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read" type="checkbox" name="" >
								<input type="hidden" class="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read_id_catalog_change hidden_id_catalog_change">
							</td>
						</tr>
					<?php if ($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['id_group']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value]['id_group']) {?>
					</tbody>
				</table>
				<div class="action-row">
					<button class="btn btn-primary" onclick="downloadQuote(<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
)">Download Quote</button>
					<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
, 'price_details')">Mark as read/unread</button>
				</div>
				</div>
				<?php }?>
			<?php } elseif ($_smarty_tpl->tpl_vars['group2']->value==$_smarty_tpl->tpl_vars['product']->value['id_group']) {?>
						<tr data-row-value="<?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>
" data-row-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['sort_date'];?>
">
							<td>
								<?php echo $_smarty_tpl->tpl_vars['product']->value['status'];?>

								<?php if (($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name'])) {?>
								<?php $_smarty_tpl->tpl_vars['l'] = new Smarty_variable($_smarty_tpl->tpl_vars['l']->value+1, null, 0);?>
									<?php echo $_smarty_tpl->tpl_vars['l']->value;?>

								<?php } else { ?>
								<?php }?>
							</td>
							<td>
								<?php if (($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name'])) {?>
									<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
 <br /> Ref: <?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>

									<?php $_smarty_tpl->tpl_vars['hide'] = new Smarty_variable('', null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['hide'] = new Smarty_variable("hidden", null, 0);?>
								<?php }?>
							</td>
							<td class="date"><?php echo $_smarty_tpl->tpl_vars['product']->value['date_added'];?>
</td>
							<td><?php if ($_smarty_tpl->tpl_vars['product']->value['city_name']) {?><?php echo $_smarty_tpl->tpl_vars['product']->value['city_name'];?>
<?php } else { ?>All India<?php }?></td>
							<td><?php echo $_smarty_tpl->tpl_vars['product']->value['from'];?>
 -- <?php echo $_smarty_tpl->tpl_vars['product']->value['to'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['currency']->value;?>
 <?php echo round($_smarty_tpl->tpl_vars['product']->value['sp'],2);?>
 upto <br /><?php echo $_smarty_tpl->tpl_vars['product']->value['expires'];?>
</td>
							<td class="rate_contract">
							<?php if (($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']==$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name']&&$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['sort_date']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['sort_date'])||($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-2]['name']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['name'])) {?>
								<div>
									<input type="text" placeholder="New Price" class="price">
								</div>
								<div>
									<input type="text" placeholder="Expiry" name="Expiry" class="datepicker">
								</div>
								<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" name="id_product" class="product_id">
							<?php }?>
							</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['status']==0) {?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-exclamation-circle", null, 0);?>
								<?php } else { ?>
									<?php $_smarty_tpl->tpl_vars['read'] = new Smarty_variable("fa-check-circle", null, 0);?>
								<?php }?>
							
								<span id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
" onclick="readNotification(this, 'price_details', '<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read', <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
);" class="read_notification fa <?php echo $_smarty_tpl->tpl_vars['read']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['hide']->value;?>
"></span>
								<input value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_catalog_change'];?>
_checkbox" onchange="checkRows('<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
_price_details', '<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read', this)" class="read_check <?php echo $_smarty_tpl->tpl_vars['hide']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read" type="checkbox" name="" >
								<?php if ($_smarty_tpl->tpl_vars['hide']->value=='') {?>
									<input type="hidden" class="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
_read_id_catalog_change hidden_id_catalog_change">
								<?php }?>
							</td>
						</tr>
				<?php if ($_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value-1]['id_group']!=$_smarty_tpl->tpl_vars['product_details_price']->value[$_smarty_tpl->tpl_vars['j']->value]['id_group']) {?>
						</tbody>
					</table>
					<div class="action-row">
						<button class="btn btn-primary" onclick="downloadQuote(<?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
)">Download Quote</button>
						<button class="btn btn-info mark_as_read" onclick="readAllNotfication(this, <?php echo $_smarty_tpl->tpl_vars['product']->value['id_group'];?>
, 'price_details')">Mark as read/unread</button>
					</div>
					</div>
					<?php $_smarty_tpl->tpl_vars['l'] = new Smarty_variable(1, null, 0);?>
				<?php }?>
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable($_smarty_tpl->tpl_vars['j']->value+1, null, 0);?>
		<?php }?>
		<?php } ?>
		</div>
    </div>

<style type="text/css">
	table{
		font-family: roboto;
	}
	table th{
		font-weight: 400;
	}
	table th .sort{
	    display: inline-block;
	    background: #fff;
	    border-radius: 16px;
	    color: #666666;
	    padding: 4px;
	}
	table th .sort .fa{
		display: block;
	}
	.details-control .fa-chevron-down{
	    /*color: #428bca;
    	padding: 8px 56px;*/
    	color: #428bca;
	    /* padding: 8px 56px; */
	    float: right;
	    padding: 6px;
	    /* background: #428bca; */
	    border: 1px solid #428bca;
	}
	.details-control span{
	    text-transform: uppercase;
    	font-size: 14px;
    	font-weight: 500;
	}

	table tbody tr .details-control label{
		border: 1px solid #ececec;
	    width: 24px;
	    height: 24px;
	    background: rgb(66, 139, 202);
	    border-radius: 14px;
	    font-weight: 400;
	    padding: 2px;
	    margin: 0px 20px;
	    color: #fff;
	    text-align: center;
	}
	table tbody tr .details-control{
		border: 1px solid #ccc;
		padding: 4px 8px 4px 16px;
	}
	.action-row{
		text-align: right;
		padding: 4px;
	}
	.product_details	{
		width: 100%;
	}
	.product_details thead tr th{
		padding: 8px;
	}
	.product_details thead{
		background: #428bca;
	    border: 1px solid #428bca;
    	color: #fff;
	}
	.product_details tbody tr td{
	    padding: 8px;
    	border: 1px solid #dddddd;
	}
	.product_details tbody tr{
		/*border: 1px solid #428bca !important;*/
	}
	.btn-container{
		text-align: center;
		padding: 4px;
	}
	.btn-container .active{
		background: #428bca !important;
		color: #fff !important;
		border: 1px solid #428bca !important;
		border-radius: 0px !important;
	}
	.btn-container .btn{
		background: #fff;
		color: #428bca;
		border: 1px solid #428bca;
		border-radius: 0px;
	}
	.rate_contract input{
        padding: 4px;
	    margin: 2px;
	    border: none;
	    border-radius: 0px;
	    border: 1px solid #ccc;
	    text-align: center;
	}
	.fa-exclamation-circle, .fa-check-circle{
		font-size: 24px;
		transition: 300ms ease;
	}
	.fa-check-circle{
		color: green;
	}
	.fa-exclamation-circle{
		color: orange;
	}

	input[type="checkbox"] {
    	margin: 8px;
	    width: 14px;
	    height: 14px;
	}

	input::-webkit-input-placeholder {
	color: #888888 !important;
	}
	 
	input:-moz-placeholder { /* Firefox 18- */
	color: #888888 !important;
	}
	 
	input::-moz-placeholder {  /* Firefox 19+ */
	color: #888888 !important;
	}
	 
	input:-ms-input-placeholder {  
	color: #888888 !important;
	}
	button{
		border-radius: 0px !important;
	}
	.btn-primary{
		background: #428bca;
		border-color: #428bca;
		color: #fff;
	}
	.btn-primary:hover, .btn-primary:active{
		background: #428bca !important;
		border-color: #428bca !important;
		color: #fff !important;
	}
	.btn-info{
		background: #fff !important;
		border-color: #428bca !important;
		color: #428bca !important;
	}
	.btn-info:hover, .btn-info:active{
		background: #fff !important;
		border-color: #428bca !important;
		color: #428bca !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		console.log("alert");
		$('.sidebar-toggle-box .fa-bars').click();
	});
</script><?php }} ?>
