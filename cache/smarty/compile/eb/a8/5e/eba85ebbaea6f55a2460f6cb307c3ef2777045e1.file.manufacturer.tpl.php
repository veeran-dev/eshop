<?php /* Smarty version Smarty-3.1.19, created on 2019-07-20 14:48:24
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\manufacturer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149615d32dc60bbc633-71707787%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eba85ebbaea6f55a2460f6cb307c3ef2777045e1' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\manufacturer.tpl',
      1 => 1478085910,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149615d32dc60bbc633-71707787',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'img_manu_dir' => 0,
    'manufacturer' => 0,
    'totalProducts' => 0,
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d32dc60d03f17_39429856',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d32dc60d03f17_39429856')) {function content_5d32dc60d03f17_39429856($_smarty_tpl) {?>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if (!isset($_smarty_tpl->tpl_vars['errors']->value)||!sizeof($_smarty_tpl->tpl_vars['errors']->value)) {?>
<div class="brand-header-wrapper">
	<div class="brand-header">
		<div class="brand-logo">
            <img class="img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value->image, ENT_QUOTES, 'UTF-8', true);?>
-medium_default.jpg" alt="" />
		</div>
		<div class="brand-details">
			<h1 class="page-heading product-listing"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</h1>
				<div class="description_box rte">
                
                	<p><strong><?php echo $_smarty_tpl->tpl_vars['totalProducts']->value;?>
</strong> <?php echo smartyTranslate(array('s'=>'products to choose from'),$_smarty_tpl);?>
</p>

					<?php if (!empty($_smarty_tpl->tpl_vars['manufacturer']->value->short_description)) {?>
						<p>Known for: <?php echo $_smarty_tpl->tpl_vars['manufacturer']->value->short_description;?>
</p>
					<?php }?>
                    
		            <?php if (!empty($_smarty_tpl->tpl_vars['manufacturer']->value->description)) {?>
						<p><?php echo $_smarty_tpl->tpl_vars['manufacturer']->value->description;?>
</p>
					<?php }?>
		            
		            
		            
		            <?php if (isset($_smarty_tpl->tpl_vars['manufacturer']->value->nb_products)&&$_smarty_tpl->tpl_vars['manufacturer']->value->nb_products==1) {?>
		                <?php echo smartyTranslate(array('s'=>'%d product','sprintf'=>intval($_smarty_tpl->tpl_vars['manufacturer']->value->nb_products)),$_smarty_tpl);?>

		            <?php } else { ?>
		              <?php if (isset($_smarty_tpl->tpl_vars['manufacturer']->value->nb_products)&&$_smarty_tpl->tpl_vars['manufacturer']->value->nb_products>0) {?>
		                <?php echo smartyTranslate(array('s'=>'%d products','sprintf'=>intval($_smarty_tpl->tpl_vars['manufacturer']->value->nb_products)),$_smarty_tpl);?>

		              <?php }?>
		            <?php }?>
				</div>
				<!--<div class="most-searched-products">
					<span>Most Searched Products:</span> <a href="#">First Product 001</a>, <a href="#">First Product 002</a>, <a href="#">First Product 003</a>, <a href="#">First Product 003</a>
				</div>-->
		</div>
        
		<div class="col-md-4 brand_head_wrap_right pull-right">
            <div class="brand-filter">
                <?php echo $_smarty_tpl->getSubTemplate ("./catagory-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                <?php echo $_smarty_tpl->getSubTemplate ("./brand-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            </div>
        </div>
        
	</div>
</div>
<div class="brand-content-wrapper">
	<div class="brand-content">
	<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>
			<div class="content_sortPagiBar">
		    	<div class="sortPagiBar clearfix">
					<?php echo $_smarty_tpl->getSubTemplate ("./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                    <?php echo $_smarty_tpl->getSubTemplate ("./nbr-product-page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
		    	<div class="top-pagination-content clearfix">
		        	<?php echo $_smarty_tpl->getSubTemplate ("./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('no_follow'=>1), 0);?>

		        </div>
			</div>

			<?php echo $_smarty_tpl->getSubTemplate ("./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>


			<div class="content_sortPagiBar">
		        <div class="bottom-pagination-content clearfix">
		        	<?php echo $_smarty_tpl->getSubTemplate ("./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<?php echo $_smarty_tpl->getSubTemplate ("./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('no_follow'=>1,'paginationId'=>'bottom'), 0);?>

		        </div>
			</div>
		<?php } else { ?>
			<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'No products for this manufacturer.'),$_smarty_tpl);?>
</p>
		<?php }?>
	<?php }?>
	</div>
</div><?php }} ?>
