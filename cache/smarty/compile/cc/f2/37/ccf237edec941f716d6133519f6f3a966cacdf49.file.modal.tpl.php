<?php /* Smarty version Smarty-3.1.19, created on 2020-05-30 20:02:10
         compiled from "C:\wamp64\www\kobsterEshop\kobster_admin\themes\default\template\helpers\modules_list\modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:196055ed26e6addc1b3-98784314%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ccf237edec941f716d6133519f6f3a966cacdf49' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\helpers\\modules_list\\modal.tpl',
      1 => 1478085951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '196055ed26e6addc1b3-98784314',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed26e6ade4462_03999495',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed26e6ade4462_03999495')) {function content_5ed26e6ade4462_03999495($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
