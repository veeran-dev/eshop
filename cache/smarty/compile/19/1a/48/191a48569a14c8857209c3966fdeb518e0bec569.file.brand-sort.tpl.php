<?php /* Smarty version Smarty-3.1.19, created on 2019-07-20 14:48:25
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\brand-sort.tpl" */ ?>
<?php /*%%SmartyHeaderCode:301485d32dc61a27310-06374380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '191a48569a14c8857209c3966fdeb518e0bec569' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\brand-sort.tpl',
      1 => 1478085889,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '301485d32dc61a27310-06374380',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'b' => 0,
    'request' => 0,
    'category' => 0,
    'link' => 0,
    'manufacturer' => 0,
    'supplier' => 0,
    'base_dir' => 0,
    'manufacturers_total' => 0,
    'manufacturers_list' => 0,
    'paginationId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d32dc61bc1707_26125215',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d32dc61bc1707_26125215')) {function content_5d32dc61bc1707_26125215($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['b']->value)&&$_smarty_tpl->tpl_vars['b']->value) {?>
<!---Hidden by veeran.b -->
<!--
<ul class="display hidden-xs">
	<li class="display-title"><?php echo smartyTranslate(array('s'=>'View:'),$_smarty_tpl);?>
</li>
    <li id="grid"><a rel="nofollow" href="#" title="<?php echo smartyTranslate(array('s'=>'Grid'),$_smarty_tpl);?>
"><i class="icon-th-large"></i><?php echo smartyTranslate(array('s'=>'Grid'),$_smarty_tpl);?>
</a></li>
    <li id="list"><a rel="nofollow" href="#" title="<?php echo smartyTranslate(array('s'=>'List'),$_smarty_tpl);?>
"><i class="icon-th-list"></i><?php echo smartyTranslate(array('s'=>'List'),$_smarty_tpl);?>
</a></li>
</ul>
-->

<?php if (!isset($_smarty_tpl->tpl_vars['request']->value)) {?>
	<!-- Sort products -->
	<?php if (isset($_GET['id_category'])&&$_GET['id_category']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,true), null, 0);?>	<?php } elseif (isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,false,true), null, 0);?>
	<?php } elseif (isset($_GET['id_supplier'])&&$_GET['id_supplier']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,false,true), null, 0);?>
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,true), null, 0);?>
	<?php }?>
<?php }?>
<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['base_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="get" id="brand_filter_form">

	<div class="brand-sub-selector">
        
        <select class="form-control" id="brand_filter" name="id_manufacturer" onchange="brand_page_brand_filter();">
            <option value="all" <?php if ($_smarty_tpl->tpl_vars['b']->value=='all') {?>selected<?php }?>>All Brands</option>
            <?php  $_smarty_tpl->tpl_vars['manufacturers_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manufacturers_list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manufacturers_total']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturers_list']->key => $_smarty_tpl->tpl_vars['manufacturers_list']->value) {
$_smarty_tpl->tpl_vars['manufacturers_list']->_loop = true;
?>
            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturers_list']->value['id_manufacturer'], ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturers_list']->value['link_rewrite'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['manufacturer']->value->id_manufacturer==$_smarty_tpl->tpl_vars['manufacturers_list']->value['id_manufacturer']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['manufacturers_list']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </div>

</form>




<!-- /Sort products -->
	<?php if (!isset($_smarty_tpl->tpl_vars['paginationId']->value)||$_smarty_tpl->tpl_vars['paginationId']->value=='') {?>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('request'=>$_smarty_tpl->tpl_vars['request']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?>
<?php }} ?>
