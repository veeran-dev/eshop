<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:51:16
         compiled from "C:\wamp\www\kobsterEshop\pdf\\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:258235a7c32ac87e172-31876386%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e51d870b59397dcc052cc91f2f6f6dbe3a6052bb' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\footer.tpl',
      1 => 1510315847,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '258235a7c32ac87e172-31876386',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'signature' => 0,
    'available_in_your_account' => 0,
    'shop_address' => 0,
    'shop_phone' => 0,
    'shop_fax' => 0,
    'shop_details' => 0,
    'free_text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7c32ac9572d6_91535030',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c32ac9572d6_91535030')) {function content_5a7c32ac9572d6_91535030($_smarty_tpl) {?>

<table id="footer-note" cellpadding="2px" height="250px;" >
	<tr class="signature-head bold">
		<td style="border: 1px solid black;font-size: 8pt;text-align: center;background: #ccc;" valign="middle" height="20px">Signature of Receiver</td>
		<td></td>
		<td style="border: 1px solid black;font-size: 8pt;text-align: center;background: #ccc;" valign="middle" height="20px">For Kobster E-shop Private Ltd.</td>
	</tr>
	<tr class="signature-body">
		<td style="border: 1px solid black;" height="40px"></td>
		<td style="text-align: center; font-size: 8pt; color: #444;">
            <!-- {:pnp:} / {:ptp:} -->
        </td>
		<td height="20px" style="font-size: 6pt; text-align: left;border: 1px solid black; height: 20px;">
		Authorized Signatory
		<img src="<?php echo $_smarty_tpl->tpl_vars['signature']->value;?>
" >
		</td>
	</tr>
	<tr>
		<!-- <td style="text-align: center; font-size: 6pt; color: #444;  width:87%;">
			<?php if ($_smarty_tpl->tpl_vars['available_in_your_account']->value) {?>
				<?php echo smartyTranslate(array('s'=>'An electronic version of this invoice is available in your account. To access it, log in to our website using your e-mail address and password (which you created when placing your first order).','pdf'=>'true'),$_smarty_tpl);?>

				<br />
			<?php }?>
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_address']->value, ENT_QUOTES, 'UTF-8', true);?>
<br />

			<?php if (!empty($_smarty_tpl->tpl_vars['shop_phone']->value)||!empty($_smarty_tpl->tpl_vars['shop_fax']->value)) {?>
				<?php echo smartyTranslate(array('s'=>'For more assistance, contact Support:','pdf'=>'true'),$_smarty_tpl);?>
<br />
				<?php if (!empty($_smarty_tpl->tpl_vars['shop_phone']->value)) {?>
					<?php echo smartyTranslate(array('s'=>'Tel: %s','sprintf'=>array(htmlspecialchars($_smarty_tpl->tpl_vars['shop_phone']->value, ENT_QUOTES, 'UTF-8', true)),'pdf'=>'true'),$_smarty_tpl);?>

				<?php }?>

				<?php if (!empty($_smarty_tpl->tpl_vars['shop_fax']->value)) {?>
					<?php echo smartyTranslate(array('s'=>'Fax: %s','sprintf'=>array(htmlspecialchars($_smarty_tpl->tpl_vars['shop_fax']->value, ENT_QUOTES, 'UTF-8', true)),'pdf'=>'true'),$_smarty_tpl);?>

				<?php }?>
				<br />
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['shop_details']->value)) {?>
				<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_details']->value, ENT_QUOTES, 'UTF-8', true);?>
<br />
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['free_text']->value)) {?>
				<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['free_text']->value, ENT_QUOTES, 'UTF-8', true);?>
<br />
			<?php }?>
		</td> -->
		<!-- <td style="text-align: right; font-size: 8pt; color: #444;  width:13%;">
            {:pnp:} / {:ptp:}
        </td> -->
	</tr>
</table><?php }} ?>
