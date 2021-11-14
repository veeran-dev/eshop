<?php /* Smarty version Smarty-3.1.19, created on 2018-02-09 18:02:03
         compiled from "C:\wamp\www\kobsterEshop\modules\tmfooterlinks\tmfooterlinks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70925a7d94c397eee1-43172231%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c40da6f675a4a9151949b27e3afd42167d67c43d' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\modules\\tmfooterlinks\\tmfooterlinks.tpl',
      1 => 1500012986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70925a7d94c397eee1-43172231',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_dir' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7d94c3a69e44_35210559',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7d94c3a69e44_35210559')) {function content_5a7d94c3a69e44_35210559($_smarty_tpl) {?><div id="tmfooterlinks" class="links-section">
    <div class="footer-block">
        <h4>Information <span class="toggle-icon">&nbsp;</span></h4>
        <ul class="toggle-footer">
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
about.php"><?php echo smartyTranslate(array('s'=>'About Us','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
sell-with-us.php"><?php echo smartyTranslate(array('s'=>'Sell with Us','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
careers.php">Careers</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
blogs/">Blog</a></li>
        </ul>
    </div>
    <div class="footer-block">
        <h4>Policy <span class="toggle-icon">&nbsp;</span></h4>
        <ul class="toggle-footer">
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cms.php?id_cms=3');?>
"><?php echo smartyTranslate(array('s'=>'Terms and Conditions','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cms.php?id_cms=6');?>
"><?php echo smartyTranslate(array('s'=>'Privacy Policy','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cms.php?id_cms=9');?>
"><?php echo smartyTranslate(array('s'=>'Cancellation & Return','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cms.php?id_cms=10');?>
"><?php echo smartyTranslate(array('s'=>'Shipping Policy','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>            
        </ul>
    </div>
    <div class="footer-block">
        <h4>Help <span class="toggle-icon">&nbsp;</span></h4>
        <ul class="toggle-footer">
            <li><a href="/contact.php"><?php echo smartyTranslate(array('s'=>'Contact Us','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account.php');?>
"><?php echo smartyTranslate(array('s'=>'Your Account','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <!--<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('guest-tracking');?>
"><?php echo smartyTranslate(array('s'=>'Order Tracking','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>-->
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('sitemap.php');?>
"><?php echo smartyTranslate(array('s'=>'Sitemap','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
        </ul>
    </div>
    <div class="footer-block">
        <h4>Others <span class="toggle-icon">&nbsp;</span></h4>
        <ul class="toggle-footer" style="display:none">
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('new-products.php');?>
"><?php echo smartyTranslate(array('s'=>'New Products','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('best-sales.php');?>
"><?php echo smartyTranslate(array('s'=>'Top Sellers','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('prices-drop.php');?>
"><?php echo smartyTranslate(array('s'=>'Discounted Products','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('manufacturer.php');?>
"><?php echo smartyTranslate(array('s'=>'Brands','mod'=>'tmfooterlinks'),$_smarty_tpl);?>
</a></li>
        </ul>
    </div>
</div>
    
    <!-- <div class="subscribe-section">
    	<h4>Be first to save</h4>
        <div class="newsletter-form">
        	<input class="form-control" type="text"><button class="red-button">&nbsp;</button>
        </div>
        <div class="social-links">
        	<a class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a>
            <a class="twitter" href="http://www.twitter.com/kobsterindia" target="_blank">&nbsp;</a>
            <a class="google-plus" href="https://plus.google.com/118109165395737937267/about" target="_blank">&nbsp;</a>
            <a class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a>
            <a class="rss" href="https://www.kobster.com/blogs/" target="_blank">&nbsp;</a>
        </div>
    </div> -->
<?php }} ?>
