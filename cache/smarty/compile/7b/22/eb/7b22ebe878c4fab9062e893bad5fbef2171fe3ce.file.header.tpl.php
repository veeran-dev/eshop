<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:51:16
         compiled from "C:\wamp\www\kobsterEshop\pdf\\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101105a7c32ac8234b7-13364757%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b22ebe878c4fab9062e893bad5fbef2171fe3ce' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\header.tpl',
      1 => 1517917335,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101105a7c32ac8234b7-13364757',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logo_path' => 0,
    'header' => 0,
    'qrLink' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7c32ac861c80_77767509',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c32ac861c80_77767509')) {function content_5a7c32ac861c80_77767509($_smarty_tpl) {?>


<table class="table-header" style="width: 100%;margin-bottom:0px;">
<tr>
	<td style="width: 40%; font-size: 18px; text-align: left;">
		<?php if ($_smarty_tpl->tpl_vars['logo_path']->value) {?>
			<img style="width: 140px;" src="<?php echo $_smarty_tpl->tpl_vars['logo_path']->value;?>
" />
		<?php }?>
		<br>
		<b>KOBSTER E-SHOP PVT LTD</b><br>
		54/32, Mount Poonamalle Main Road, ST Thomas Mount<br>
		Chennai - 600016, Tamil Nadu, India <br>
		CIN: U74999TN2012PTC086489<br>
		PAN: AAECK8223C<br>
	</td>
	<td style="width: 20%;">
		<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

	</td>
	<td style="width: 40%;text-align: center;">
		<img  src="<?php echo $_smarty_tpl->tpl_vars['qrLink']->value;?>
" title="Link to Google.com" /><br>
		<span style="margin-bottom: 50px;
		"><?php if (isset($_smarty_tpl->tpl_vars['header']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
	</td>
</tr>
</table>
<?php }} ?>
