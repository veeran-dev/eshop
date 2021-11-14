<?php /* Smarty version Smarty-3.1.19, created on 2020-05-30 20:02:12
         compiled from "C:\wamp64\www\kobsterEshop\kobster_admin\themes\default\template\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:154795ed26e6c4e8a32-11251423%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '237373d5eef71c13fb300fcca2ddbe90edf216f4' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\footer.tpl',
      1 => 1500012988,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '154795ed26e6c4e8a32-11251423',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'display_footer' => 0,
    'content_dir' => 0,
    'timer_start' => 0,
    'php_errors' => 0,
    'modals' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed26e6c54b7f5_96818963',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed26e6c54b7f5_96818963')) {function content_5ed26e6c54b7f5_96818963($_smarty_tpl) {?>

	</div>
</div>
<?php if ($_smarty_tpl->tpl_vars['display_footer']->value) {?>
<div id="footer" class="bootstrap hide">

	<div class="col-sm-2 hidden-xs">
		<a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
" class="_blank">Kobster&trade;</a>
		-
		<span id="footer-load-time"><i class="icon-time" title="<?php echo smartyTranslate(array('s'=>'Load time: '),$_smarty_tpl);?>
"></i> <?php echo number_format(microtime(true)-$_smarty_tpl->tpl_vars['timer_start']->value,3,'.','');?>
s</span>
	</div>

	<div class="col-sm-2 hidden-xs">
		<div class="social-networks">
		
		</div>
	</div>
	<div class="col-sm-5">
		<div class="footer-contact">
		
		</div>
	</div>

	<div class="col-sm-3">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayBackOfficeFooter"),$_smarty_tpl);?>

	</div>

	<div id="go-top" class="hide"><i class="icon-arrow-up"></i></div>
</div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['php_errors']->value)) {?>
	<?php echo $_smarty_tpl->getSubTemplate ("error.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['modals']->value)) {?>
<div class="bootstrap">
	<?php echo $_smarty_tpl->tpl_vars['modals']->value;?>

</div>
<?php }?>

</body>
</html>
<?php }} ?>
