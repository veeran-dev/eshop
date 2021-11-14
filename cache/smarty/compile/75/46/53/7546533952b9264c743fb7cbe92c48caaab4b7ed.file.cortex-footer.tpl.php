<?php /* Smarty version Smarty-3.1.19, created on 2018-02-10 01:23:33
         compiled from "C:\wamp\www\kobsterEshop\cortex\cortex-footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82445a7dfc3d908027-76182142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7546533952b9264c743fb7cbe92c48caaab4b7ed' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\cortex\\cortex-footer.tpl',
      1 => 1517921491,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82445a7dfc3d908027-76182142',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_dir' => 0,
    'cookie' => 0,
    'link' => 0,
    'priceDisplay' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7dfc3d97a8e2_11077948',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7dfc3d97a8e2_11077948')) {function content_5a7dfc3d97a8e2_11077948($_smarty_tpl) {?>		<img src="app/assets/img/elite-logo-print.svg" alt="Kobster Logo" id="eliteLogo" style="display:none;">
		<canvas id="eliteCanvasLogo" style="display:none;"></canvas>
		<script type="text/javascript">
			baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
			username = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->lastname;?>
';
			id_employee='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_employee;?>
';
			logoutLink = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink("CortexLogin");?>
&logout';
			priceDisplayMethod = '<?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
';
			role = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->role;?>
';
		    currencyChar = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_char;?>
';
		    currencyFormat = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_format;?>
';
		    currencyDecimals = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_decimals;?>
';
		    currencyBlank = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_blank;?>
';
		    id_state = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_state;?>
';
		</script>
		<script type="text/javascript" src="bundle.js"></script>
		<script type="text/javascript" src="app/assets/js/canvasjs.min.js" async></script>
		<script type="text/javascript" src="app/assets/js/jspdf.min.js" async></script>
	</body>
</html><?php }} ?>
