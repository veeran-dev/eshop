<?php /* Smarty version Smarty-3.1.19, created on 2020-08-28 15:59:55
         compiled from "C:\wamp64\www\kobsterEshop\modules\blocksocial\blocksocial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12654505405f48dca37f8bb4-48335656%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '830ab6fb8b8b4fe7171b5f254dfa99817a52a6ce' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\blocksocial\\blocksocial.tpl',
      1 => 1478086018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12654505405f48dca37f8bb4-48335656',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facebook_url' => 0,
    'twitter_url' => 0,
    'rss_url' => 0,
    'youtube_url' => 0,
    'google_plus_url' => 0,
    'pinterest_url' => 0,
    'vimeo_url' => 0,
    'instagram_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f48dca3817b04_32787392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f48dca3817b04_32787392')) {function content_5f48dca3817b04_32787392($_smarty_tpl) {?>

<div id="social_block">
	<h4 class="title_block"><?php echo smartyTranslate(array('s'=>'Follow us','mod'=>'blocksocial'),$_smarty_tpl);?>
</h4>
	<ul>
		<?php if ($_smarty_tpl->tpl_vars['facebook_url']->value!='') {?><li class="facebook"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebook_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['twitter_url']->value!='') {?><li class="twitter"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['twitter_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['rss_url']->value!='') {?><li class="rss"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['rss_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'RSS','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['youtube_url']->value!='') {?><li class="youtube"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['youtube_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'YouTube','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['google_plus_url']->value!='') {?><li class="google_plus"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['google_plus_url']->value, ENT_QUOTES, 'UTF-8', true);?>
" rel="publisher"><?php echo smartyTranslate(array('s'=>'Google+','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['pinterest_url']->value!='') {?><li class="pinterest"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pinterest_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Pinterest','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['vimeo_url']->value!='') {?><li class="vimeo"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['vimeo_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Vimeo','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['instagram_url']->value!='') {?><li class="instagram"><a class="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['instagram_url']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Instagram','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
	</ul>
</div>
<?php }} ?>
