<?php /* Smarty version Smarty-3.1.19, created on 2019-07-20 14:48:25
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\catagory-sort.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22635d32dc6126ca33-03134475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c6a9ce852d42bee98c5cf5cc7c73fd292ad35d4' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\catagory-sort.tpl',
      1 => 1478085889,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22635d32dc6126ca33-03134475',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'c' => 0,
    'request' => 0,
    'category' => 0,
    'link' => 0,
    'manufacturer' => 0,
    'supplier' => 0,
    'orderby' => 0,
    'orderway' => 0,
    'b' => 0,
    'category_list' => 0,
    'paginationId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d32dc616ee2e6_75393071',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d32dc616ee2e6_75393071')) {function content_5d32dc616ee2e6_75393071($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['c']->value)&&$_smarty_tpl->tpl_vars['c']->value) {?>
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

<div class="brand-sub-selector">
    <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['request']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="get">
        
        <!--<input  type="hidden" name="controller" value="manufacturer" />
        <input  type="hidden" name="id_manufacturer" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value->id_manufacturer, ENT_QUOTES, 'UTF-8', true);?>
" />-->
        
        <?php if (isset($_smarty_tpl->tpl_vars['orderby']->value)) {?><input  type="hidden" name="orderby" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderby']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['orderway']->value)) {?><input  type="hidden" name="orderway" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderway']->value, ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
        
        <input  type="hidden" name="b" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['b']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
        
        <select class="form-control" name="c" id="category_filter" onchange="this.form.submit();">
            <option value="all" <?php if ($_smarty_tpl->tpl_vars['c']->value=='all') {?>selected<?php }?>>All Catagory</option>
            <?php  $_smarty_tpl->tpl_vars['category_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category_list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category_list']->key => $_smarty_tpl->tpl_vars['category_list']->value) {
$_smarty_tpl->tpl_vars['category_list']->_loop = true;
?>
            <option value="<?php echo $_smarty_tpl->tpl_vars['category_list']->value['id_category'];?>
" <?php if ($_smarty_tpl->tpl_vars['c']->value==$_smarty_tpl->tpl_vars['category_list']->value['id_category']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['category_list']->value['name'];?>
</option>
            <?php } ?>
        </select>
    </form>
</div>



<!-- /Sort products -->
	<?php if (!isset($_smarty_tpl->tpl_vars['paginationId']->value)||$_smarty_tpl->tpl_vars['paginationId']->value=='') {?>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('request'=>$_smarty_tpl->tpl_vars['request']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?>
<?php }} ?>
