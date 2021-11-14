<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:51:16
         compiled from "C:\wamp\www\kobsterEshop\pdf\\delivery-slip.addresses-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:71575a7c32acc92985-35399837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5c9e1c421f7c923952dae89eaf3c222e3f3d018' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\delivery-slip.addresses-tab.tpl',
      1 => 1509458554,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71575a7c32acc92985-35399837',
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
  'unifunc' => 'content_5a7c32acd2af53_81311115',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c32acd2af53_81311115')) {function content_5a7c32acd2af53_81311115($_smarty_tpl) {?>
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
