<?php /* Smarty version Smarty-3.1.19, created on 2019-12-03 22:37:47
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\delivery-slip.product-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31155de696632505b2-30034599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45df96498deb6ce8e8b9c990b6a3a10eac9b793a' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\delivery-slip.product-tab.tpl',
      1 => 1554795440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31155de696632505b2-30034599',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_details' => 0,
    'bgcolor_class' => 0,
    'order_detail' => 0,
    'display_product_images' => 0,
    'customizationPerAddress' => 0,
    'customization' => 0,
    'customization_infos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5de696636a1dc8_69093385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de696636a1dc8_69093385')) {function content_5de696636a1dc8_69093385($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include 'C:\\wamp64\\www\\kobsterEshop\\tools\\smarty\\plugins\\function.cycle.php';
?>
<table class="product" width="100%" cellpadding="4" cellspacing="0">
	
	<thead>
		<tr>
			<th class="product header small" width="11%"><?php echo smartyTranslate(array('s'=>'S.No','pdf'=>'true'),$_smarty_tpl);?>
</th>
			<th class="product header small" width="14%"><?php echo smartyTranslate(array('s'=>'Reference','pdf'=>'true'),$_smarty_tpl);?>
</th>
			<th class="product header small" width="65%"><?php echo smartyTranslate(array('s'=>'Product','pdf'=>'true'),$_smarty_tpl);?>
</th>
			<th class="product header small" width="10%"><?php echo smartyTranslate(array('s'=>'Qty','pdf'=>'true'),$_smarty_tpl);?>
</th>
		</tr>
	</thead>

	<tbody>
		<!-- PRODUCTS -->
		<?php  $_smarty_tpl->tpl_vars['order_detail'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order_detail']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_details']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order_detail']->key => $_smarty_tpl->tpl_vars['order_detail']->value) {
$_smarty_tpl->tpl_vars['order_detail']->_loop = true;
?>
			<?php echo smarty_function_cycle(array('values'=>array("color_line_even","color_line_odd"),'assign'=>'bgcolor_class'),$_smarty_tpl);?>

			<tr class="product <?php echo $_smarty_tpl->tpl_vars['bgcolor_class']->value;?>
">
				<td class="product center">
					<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['i'];?>

				</td>
				<td class="product center">
					<?php if (empty($_smarty_tpl->tpl_vars['order_detail']->value['product_reference'])) {?>
						---
					<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['product_reference'];?>

					<?php }?>
				</td>
				<td class="product left">
					<?php if (isset($_smarty_tpl->tpl_vars['display_product_images']->value)) {?>
						<table width="100%">
							<tr>
								<td width="15%">
									<?php if (isset($_smarty_tpl->tpl_vars['order_detail']->value['image'])&&$_smarty_tpl->tpl_vars['order_detail']->value['image']->id) {?>
										<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['image_tag'];?>

									<?php }?>
								</td>
								<td width="5%">&nbsp;</td>
								<td width="80%">
									<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['product_name'];?>

								</td>
							</tr>
						</table>
					<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['product_name'];?>

					<?php }?>
				</td>
				<td class="product center">
				<?php if ($_smarty_tpl->tpl_vars['order_detail']->value['quantity']) {?>
					<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['quantity'];?>

				<?php } else { ?>
					<?php echo $_smarty_tpl->tpl_vars['order_detail']->value['product_quantity'];?>

				<?php }?>
				</td>
				
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['order_detail']->value['customizedDatas'])) {?>
			<?php  $_smarty_tpl->tpl_vars['customizationPerAddress'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customizationPerAddress']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_detail']->value['customizedDatas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customizationPerAddress']->key => $_smarty_tpl->tpl_vars['customizationPerAddress']->value) {
$_smarty_tpl->tpl_vars['customizationPerAddress']->_loop = true;
?>
				<?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization']->_loop = false;
 $_smarty_tpl->tpl_vars['customizationId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customizationPerAddress']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value) {
$_smarty_tpl->tpl_vars['customization']->_loop = true;
 $_smarty_tpl->tpl_vars['customizationId']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
					<tr class="customization_data <?php echo $_smarty_tpl->tpl_vars['bgcolor_class']->value;?>
">
						<td class="center"> &nbsp;</td>

						<td>
							<?php if (isset($_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_TEXTFIELD])&&count($_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_TEXTFIELD])>0) {?>
								<table style="width: 100%;">
									<?php  $_smarty_tpl->tpl_vars['customization_infos'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization_infos']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_TEXTFIELD]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customization_infos']->key => $_smarty_tpl->tpl_vars['customization_infos']->value) {
$_smarty_tpl->tpl_vars['customization_infos']->_loop = true;
?>
										<tr>
											<td style="width: 30%;">
												<?php ob_start();?><?php echo smartyTranslate(array('s'=>'%s:','pdf'=>'true'),$_smarty_tpl);?>
<?php $_tmp7=ob_get_clean();?><?php echo sprintf($_tmp7,$_smarty_tpl->tpl_vars['customization_infos']->value['name']);?>

											</td>
											<td><?php echo $_smarty_tpl->tpl_vars['customization_infos']->value['value'];?>
</td>
										</tr>
									<?php } ?>
								</table>
							<?php }?>

							<?php if (isset($_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_FILE])&&count($_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_FILE])>0) {?>
								<table style="width: 100%;">
									<tr>
										<td style="width: 30%;"><?php echo smartyTranslate(array('s'=>'image(s):','pdf'=>'true'),$_smarty_tpl);?>
</td>
										<td><?php echo count($_smarty_tpl->tpl_vars['customization']->value['datas'][Product::CUSTOMIZE_FILE]);?>
</td>
									</tr>
								</table>
							<?php }?>
						</td>

						<td class="center">
							(<?php if ($_smarty_tpl->tpl_vars['customization']->value['quantity']==0) {?>1<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
<?php }?>)
						</td>

					</tr>
				<?php } ?>
			<?php } ?>
			<?php }?>
			
			
			
		<?php } ?>
		<!-- END PRODUCTS -->
	</tbody>
</table>
<?php }} ?>
