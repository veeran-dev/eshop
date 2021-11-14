<?php /* Smarty version Smarty-3.1.19, created on 2019-12-03 22:37:45
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:182865de6966101b215-87421380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ee3d1cef640d5f57208fbb9017fd4ae6ae91ffb' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\header.tpl',
      1 => 1561992136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182865de6966101b215-87421380',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logo_path' => 0,
    'supplier_address' => 0,
    'header' => 0,
    'title' => 0,
    'date' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5de6966114ade1_82609933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de6966114ade1_82609933')) {function content_5de6966114ade1_82609933($_smarty_tpl) {?>
<style>
    .supplier-address{
        font-size: 20px;
    }
</style>

<table class="table-header" style="width: 100%;margin-bottom:0px;">
<tr>
	<td class="supplier-address" style="width: 40%; text-align: left;">
		<?php if ($_smarty_tpl->tpl_vars['logo_path']->value) {?>
			<img style="width: 140px;" src="<?php echo $_smarty_tpl->tpl_vars['logo_path']->value;?>
" />
		<?php }?>
		<br>
		<?php echo $_smarty_tpl->tpl_vars['supplier_address']->value;?>

	</td>
	<td style="width: 20%;">
		<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

	</td>
	<td style="width: 40%;text-align: center;">
		<span style="margin-bottom: 50px;">
			<?php if (isset($_smarty_tpl->tpl_vars['header']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo (" Dt. ").($_smarty_tpl->tpl_vars['date']->value);?>
<?php }?>
		</span>
	</td>
</tr>
</table><?php }} ?>
