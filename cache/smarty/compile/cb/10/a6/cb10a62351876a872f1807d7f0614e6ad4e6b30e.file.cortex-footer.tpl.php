<?php /* Smarty version Smarty-3.1.19, created on 2019-08-03 15:08:42
         compiled from "C:\wamp64\www\kobsterEshop\cortex\cortex-footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:102895d4556227f8e46-37924506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb10a62351876a872f1807d7f0614e6ad4e6b30e' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\cortex\\cortex-footer.tpl',
      1 => 1549611186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102895d4556227f8e46-37924506',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_dir' => 0,
    'cookie' => 0,
    'profile' => 0,
    'link' => 0,
    'priceDisplay' => 0,
    'token' => 0,
    'js_files' => 0,
    'js_uri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d455622903b70_75126261',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d455622903b70_75126261')) {function content_5d455622903b70_75126261($_smarty_tpl) {?>		<img src="app/assets/img/elite-logo-print.svg" alt="Kobster Logo" id="eliteLogo" style="display:none;">
        <script src="socket.io-client/socket.io.js"></script>
		<canvas id="eliteCanvasLogo" style="display:none;"></canvas>
		<script type="text/javascript">
		baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
		username = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->lastname;?>
';
		firstname = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->firstname;?>
';
		id_employee='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_employee;?>
';
		id_profile = '<?php echo $_smarty_tpl->tpl_vars['profile']->value;?>
';
		logoutLink = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink("CortexLogin");?>
&logout';
		priceDisplayMethod = '<?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
';
		role = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->role;?>
';
		admin_token = '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
'
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
	    gapi_access_token = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->gapi_access_token;?>
';	
		</script>
		<?php if (isset($_smarty_tpl->tpl_vars['js_files']->value)) {?>
			<?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value) {
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>
			<script type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['js_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
"></script>
			<?php } ?>
		<?php }?>
	</body>
</html>
<?php }} ?>
