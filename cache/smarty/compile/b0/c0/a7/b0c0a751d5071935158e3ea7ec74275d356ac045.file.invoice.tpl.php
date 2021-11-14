<?php /* Smarty version Smarty-3.1.19, created on 2018-01-24 16:12:30
         compiled from "C:\wamp\www\kobsterEshop\pdf\\invoice.tpl" */ ?>
<?php /*%%SmartyHeaderCode:265255a686316112966-59510998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0c0a751d5071935158e3ea7ec74275d356ac045' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\invoice.tpl',
      1 => 1510315834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '265255a686316112966-59510998',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style_tab' => 0,
    'addresses_tab' => 0,
    'summary_tab' => 0,
    'product_tab' => 0,
    'tax_tab' => 0,
    'total_tab' => 0,
    'legal_free_text' => 0,
    'HOOK_DISPLAY_PDF' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a6863161565c4_97396702',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6863161565c4_97396702')) {function content_5a6863161565c4_97396702($_smarty_tpl) {?>

<?php echo $_smarty_tpl->tpl_vars['style_tab']->value;?>



<table width="100%" id="body" style="margin:0;">
	<!-- Invoicing -->
	<tr style="margin-bottom: 4px;">
		<td colspan="12">

			<?php echo $_smarty_tpl->tpl_vars['addresses_tab']->value;?>


		</td>
	</tr>

	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>
	<!-- Summary -->
	<tr style="margin-bottom: 4px;">
		<td colspan="12">
			<?php echo $_smarty_tpl->tpl_vars['summary_tab']->value;?>

		</td>
	</tr>

	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>

	<!-- Product -->
	<tr style="margin-bottom: 4px;">
		<td colspan="12">

			<?php echo $_smarty_tpl->tpl_vars['product_tab']->value;?>


		</td>
	</tr>

	<tr>
		<td colspan="12" height="5">&nbsp;</td>
	</tr>

	<!-- TVA -->
	<tr style="border: 1px solid black;margin-bottom: 4px;">
		
		<td colspan="8" class="right">
		<br><br><br><br>
			<?php echo $_smarty_tpl->tpl_vars['tax_tab']->value;?>

		</td>
		<td colspan="4" class="right">

			<?php echo $_smarty_tpl->tpl_vars['total_tab']->value;?>


		</td>
	</tr>


	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="12" class="left small">

			<table>
				<tr>
					<td>
						<p style="font-size: 6pt;text-align: center;"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['legal_free_text']->value, ENT_QUOTES, 'UTF-8', true));?>
</p>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	
	<!-- Hook -->
	<?php if (isset($_smarty_tpl->tpl_vars['HOOK_DISPLAY_PDF']->value)) {?>
	<tr>
		<td colspan="12" height="30">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="10">
			<?php echo $_smarty_tpl->tpl_vars['HOOK_DISPLAY_PDF']->value;?>

		</td>
	</tr>
	<?php }?>

</table>
<?php }} ?>
