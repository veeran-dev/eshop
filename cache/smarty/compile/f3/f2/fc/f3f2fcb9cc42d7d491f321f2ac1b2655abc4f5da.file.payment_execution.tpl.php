<?php /* Smarty version Smarty-3.1.19, created on 2020-05-07 04:04:48
         compiled from "home\payment_execution.tpl" */ ?>
<?php /*%%SmartyHeaderCode:295515eb33b88599748-49388890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3f2fcb9cc42d7d491f321f2ac1b2655abc4f5da' => 
    array (
      0 => 'home\\payment_execution.tpl',
      1 => 1588804464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '295515eb33b88599748-49388890',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'account_id' => 0,
    'reference_no' => 0,
    'total' => 0,
    'description' => 0,
    'name' => 0,
    'address' => 0,
    'city' => 0,
    'postal_code' => 0,
    'country' => 0,
    'email' => 0,
    'phone' => 0,
    'return_url' => 0,
    'secure_hash' => 0,
    'mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5eb33b886282c6_05617785',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eb33b886282c6_05617785')) {function content_5eb33b886282c6_05617785($_smarty_tpl) {?>
<!DOCTYPE html>
<html lang="en">
<body>
	<div id="ebs_block">
		<form name="checkout_confirmation" id="checkout_confirmation" action="https://www.kobster.com" method="POST">
			<input type="hidden" name="account_id" value="<?php echo $_smarty_tpl->tpl_vars['account_id']->value;?>
" />
			<input type="hidden" name="reference_no" value="<?php echo $_smarty_tpl->tpl_vars['reference_no']->value;?>
" />
			<input name="amount" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
" />
			<input name="description" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />

			<input name="name" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" />
			<input name="address" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['address']->value;?>
" />
			<input name="city" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['city']->value;?>
" />
			<input name="postal_code" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['postal_code']->value;?>
" />
			<input name="country" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['country']->value;?>
" />
			<input name="email" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" />
			<input name="phone" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
" />
			<input name="return_url" type="hidden" size="60" value="<?php echo $_smarty_tpl->tpl_vars['return_url']->value;?>
" />
			<input name="secure_hash" type="hidden" size="100" value="<?php echo $_smarty_tpl->tpl_vars['secure_hash']->value;?>
" />
			<input name="mode" type="hidden" size="60" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
" />				
		</form>
	</div>
</body>
<script type="text/javascript">
	document.getElementById("checkout_confirmation").submit();
 </script>
</html><?php }} ?>
