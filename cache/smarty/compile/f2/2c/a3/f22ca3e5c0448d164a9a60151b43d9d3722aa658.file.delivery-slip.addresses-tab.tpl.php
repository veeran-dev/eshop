<?php /* Smarty version Smarty-3.1.19, created on 2019-12-03 22:37:46
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\delivery-slip.addresses-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:288375de6966294ed29-69406975%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f22ca3e5c0448d164a9a60151b43d9d3722aa658' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\delivery-slip.addresses-tab.tpl',
      1 => 1554795440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '288375de6966294ed29-69406975',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fc_address' => 0,
    'delivery_address' => 0,
    'invoice_address' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5de69662aa70a8_42823686',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de69662aa70a8_42823686')) {function content_5de69662aa70a8_42823686($_smarty_tpl) {?>
<table id="addresses-tab" >
	<tr style="line-height:4px;">
		<!-- <td width="33%">
			<span class="bold"><?php echo smartyTranslate(array('s'=>'Ship From:','pdf'=>'true'),$_smarty_tpl);?>
</span><br>
			<?php echo $_smarty_tpl->tpl_vars['fc_address']->value;?>

		</td> -->
		<td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Ship To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

			<?php }?>
		</td>
		<!-- <?php if (!empty($_smarty_tpl->tpl_vars['invoice_address']->value)) {?>
			<td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Ship To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
					<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

				<?php }?>
			</td>
			<td width="33%"><span class="bold"><?php echo smartyTranslate(array('s'=>'Bill To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

			</td>
		<?php } else { ?>
			<td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Bill To & Ship To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
					<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

				<?php }?>
			</td>
		<?php }?> -->
	</tr>
</table>
<?php }} ?>
