<?php /* Smarty version Smarty-3.1.19, created on 2020-09-22 17:28:13
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\modules\blocksearch\blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20155665575f69e6d57300f9-36384416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49d20588c79bada346d7b71863bc5c5494f1c850' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1498030524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20155665575f69e6d57300f9-36384416',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
    'category_list' => 0,
    'category' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f69e6d6a5af41_03190136',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f69e6d6a5af41_03190136')) {function content_5f69e6d6a5af41_03190136($_smarty_tpl) {?>
<?php if ('isPerks'!=1) {?>
<div class="searchbar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Block search module TOP -->
                <div id="search_block_top" class="">
                    <form id="searchbox" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
                        <input type="hidden" name="controller" value="search" />
                        <input type="hidden" name="orderby" value="position" />
                        <input type="hidden" name="orderway" value="desc" />
                        <input type="hidden" name="search_category" class="search_category_id" id="search_category" value="" />
                        <input class="search_query search-input" type="text" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Type Product name or Product Code or Manufacturer code','mod'=>'blocksearch'),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
                        
                        <!-- <div class="category-dropdown">
                            <div class="dropdown-toggle" type="button" id="custom-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All categories</div>
                            <ul id="categorySelect" class="dropdown-menu" aria-labelledby="custom-dropdown">
                                <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                                    <li value="<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</li>
                                <?php } ?>
                            </ul>
                        </div> -->

                        <select class="form-control noUniform category-dropdown">
                            <option value="">All Categories</option>
                            <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
                        
                        <button type="submit" name="submit_search" class="search-button">
                            <span class="sr-only"><?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
</span>
                        </button>
                    </form>
                </div>
                <!-- /Block search module TOP -->
            </div>
        </div>
    </div>
</div>
<?php }?><?php }} ?>
