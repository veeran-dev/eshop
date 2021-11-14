<?php /* Smarty version Smarty-3.1.19, created on 2018-01-24 16:12:29
         compiled from "C:\wamp\www\kobsterEshop\pdf\\invoice.style-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:139315a686315731363-06876346%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca09129ddb136221ba3d56eff55215e373b23bf9' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\invoice.style-tab.tpl',
      1 => 1510312667,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139315a686315731363-06876346',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'color_border' => 0,
    'font_size_product' => 0,
    'font_size_total' => 0,
    'table_padding' => 0,
    'color_border_lighter' => 0,
    'color_line_even' => 0,
    'color_line_odd' => 0,
    'font_size_header' => 0,
    'height_header' => 0,
    'color_header' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a686315856a23_09458670',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a686315856a23_09458670')) {function content_5a686315856a23_09458670($_smarty_tpl) {?>

<?php $_smarty_tpl->tpl_vars['color_header'] = new Smarty_variable("#F0F0F0", null, 0);?>
<?php $_smarty_tpl->tpl_vars['color_border'] = new Smarty_variable("#000000", null, 0);?>
<?php $_smarty_tpl->tpl_vars['color_border_lighter'] = new Smarty_variable("#CCCCCC", null, 0);?>
<?php $_smarty_tpl->tpl_vars['color_line_even'] = new Smarty_variable("#FFFFFF", null, 0);?>
<?php $_smarty_tpl->tpl_vars['color_line_odd'] = new Smarty_variable("#F9F9F9", null, 0);?>
<?php $_smarty_tpl->tpl_vars['font_size_text'] = new Smarty_variable("8pt", null, 0);?>
<?php $_smarty_tpl->tpl_vars['font_size_header'] = new Smarty_variable("8pt", null, 0);?>
<?php $_smarty_tpl->tpl_vars['font_size_product'] = new Smarty_variable("8pt", null, 0);?>
<?php $_smarty_tpl->tpl_vars['font_size_total'] = new Smarty_variable("9pt", null, 0);?>
<?php $_smarty_tpl->tpl_vars['height_header'] = new Smarty_variable("20px", null, 0);?>
<?php $_smarty_tpl->tpl_vars['table_padding'] = new Smarty_variable("4px", null, 0);?>

<style>

	table{
		margin-bottom: 8px; 	
	}
	table, th, td {
		padding: 0pt;
		margin: 0pt;
	}

	table.product {
		border: 1px solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;
		border-collapse: collapse;
	}
	table#addresses-tab{
		border-collapse: collapse;
		padding: 6px;
	}
	table#addresses-tab tr{
		line-height: 4px;
	}
	table#addresses-tab tr td {
		border:1px solid #CCCCCC;
		font-size: 8pt;
	}
	table#addresses-tab span {
		font-weight: bold;
	}
	table#addresses-tab tr td .bold{
		font-weight: bold !important;
	}

	table#summary-tab {
		font-size: <?php echo $_smarty_tpl->tpl_vars['font_size_product']->value;?>
;
		padding: 6px;
		border-collapse: collapse;
		margin-top: 8px;
	}	
	table#summary-tab tr td{
		border: 1px solid #CCCCCC;
		text-align: left;
	}
	table#total-tab {
		font-size: <?php echo $_smarty_tpl->tpl_vars['font_size_total']->value;?>
;
		padding: <?php echo $_smarty_tpl->tpl_vars['table_padding']->value;?>
;
		/*border: 1pt solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;*/
	}
	table#tax-tab {
		padding: <?php echo $_smarty_tpl->tpl_vars['table_padding']->value;?>
;
		border: 1pt solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;
	}
	table#payment-tab {
		padding: <?php echo $_smarty_tpl->tpl_vars['table_padding']->value;?>
;
		border: 1px solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;
	}

	th.product {
		border-bottom: 1px solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;
	}

	tr.discount th.header {
		border-top: 1px solid <?php echo $_smarty_tpl->tpl_vars['color_border']->value;?>
;
	}

	tr.product td {
		border-bottom: 1px solid <?php echo $_smarty_tpl->tpl_vars['color_border_lighter']->value;?>
;
	}

	tr.color_line_even {
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_line_even']->value;?>
;
	}

	tr.color_line_odd {
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_line_odd']->value;?>
;
	}

	tr.customization_data td {
	}

	td.product {
		vertical-align: middle;
		font-size: <?php echo $_smarty_tpl->tpl_vars['font_size_product']->value;?>
;
	}

	th.header {
		font-size: <?php echo $_smarty_tpl->tpl_vars['font_size_header']->value;?>
;
		height: <?php echo $_smarty_tpl->tpl_vars['height_header']->value;?>
;
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_header']->value;?>
;
		vertical-align: middle;
		text-align: center;
		font-weight: bold;
	}

	th.header-right {
		font-size: <?php echo $_smarty_tpl->tpl_vars['font_size_header']->value;?>
;
		height: <?php echo $_smarty_tpl->tpl_vars['height_header']->value;?>
;
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_header']->value;?>
;
		vertical-align: middle;
		text-align: right;
		font-weight: bold;
	}

	th.payment {
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_header']->value;?>
;
		vertical-align: middle;
		font-weight: bold;
	}

	th.tva {
		background-color: <?php echo $_smarty_tpl->tpl_vars['color_header']->value;?>
;
		vertical-align: middle;
		font-weight: bold;
	}

	tr.separator td {
		border-top: 1px solid #000000;
	}
	table#footer-note tr td{
		border: 1px solid black;
	}
	.left {
		text-align: left;
	}

	.fright {
		float: right;
	}

	.right {
		text-align: right;
	}

	.center {
		text-align: center;
	}

	.bold {
		font-weight: bold;
	}

	.border {
		border: 1px solid black;
	}

	.no_top_border {
		border-top:hidden;
		border-bottom:1px solid black;
		border-left:1px solid black;
		border-right:1px solid black;
	}

	.grey {
		text-align: left;
		/*background-color: <?php echo $_smarty_tpl->tpl_vars['color_header']->value;?>
;*/

	}

	/* This is used for the border size */
	.white {
		text-align: left;
		background-color: #FFFFFF;
	}

	.big,
	tr.big td{
		font-size: 110%;
	}
	
	.small, table.small th, table.small td {
		font-size:small;
	}
</style>
<?php }} ?>
