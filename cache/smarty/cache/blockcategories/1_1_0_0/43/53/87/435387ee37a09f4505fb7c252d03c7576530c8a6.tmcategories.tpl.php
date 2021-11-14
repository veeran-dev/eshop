<?php /*%%SmartyHeaderCode:31094568792b2d9b3a9-87065103%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '435387ee37a09f4505fb7c252d03c7576530c8a6' => 
    array (
      0 => 'C:\\wamp\\www\\kobster_v_2\\modules\\tmcategories\\tmcategories.tpl',
      1 => 1451715223,
      2 => 'file',
    ),
    'bc714b1353be9e000850ed7b2d87e8a5fa05c680' => 
    array (
      0 => 'C:\\wamp\\www\\kobster_v_2\\modules\\tmcategories\\category-tree-branch.tpl',
      1 => 1451715223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31094568792b2d9b3a9-87065103',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_568b92a8daf219_83070834',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568b92a8daf219_83070834')) {function content_568b92a8daf219_83070834($_smarty_tpl) {?><!-- TM Categories -->
<script type="text/javascript" src="/kobster_v_2/modules/tmcategories/superfish.js"></script>

<script type="text/javascript">
$(document).ready(function() {
$('ul.sf-menu').superfish({
delay: 1000,
animation: {opacity:'show',height:'show'},
speed: 'fast',
autoArrows: false,
dropShadows: false
});
});
$('#cat > ul.subcat1 > li').eq(1).addClass('second')
</script>

<div class="clearblock"></div>
<div id="tmcategories">
	<ul id="cat" class="sf-menu">
						<li class="category-1 sub">
	<a class="<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: currentCategoryId in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28196424</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.3914</td><td bgcolor='#eeeeec' align='right'>28209088</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.3914</td><td bgcolor='#eeeeec' align='right'>28209088</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.3925</td><td bgcolor='#eeeeec' align='right'>28271112</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Trying to get property of non-object in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28196424</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.3914</td><td bgcolor='#eeeeec' align='right'>28209088</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.3914</td><td bgcolor='#eeeeec' align='right'>28209088</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.3925</td><td bgcolor='#eeeeec' align='right'>28271112</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
" href="http://localhost/kobster_v_2/index.php?id_category=2&controller=category&id_lang=1" ><span>iPods</span></a>
			<ul class="subcat1">
					<li class="sub-cat-0">
				<a href="http://localhost/kobster_v_2/index.php?id_category=7&amp;controller=category&amp;id_lang=1">apple</a>
				<img src="img/c/7-category.jpg" alt="" />
				<div>
								</div>
			</li>
				</ul>
	</li>
								<li class="category-2 sub">
	<a class="<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: currentCategoryId in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28271208</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28284552</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28284552</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4025</td><td bgcolor='#eeeeec' align='right'>28302680</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Trying to get property of non-object in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28271208</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28284552</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4024</td><td bgcolor='#eeeeec' align='right'>28284552</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4025</td><td bgcolor='#eeeeec' align='right'>28302680</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
" href="http://localhost/kobster_v_2/index.php?id_category=3&controller=category&id_lang=1" ><span>Accessories</span></a>
			<ul class="subcat1">
					<li class="sub-cat-0">
				<a href="http://localhost/kobster_v_2/index.php?id_category=8&amp;controller=category&amp;id_lang=1">transand</a>
				<img src="img/c/8-category.jpg" alt="" />
				<div>
								</div>
			</li>
					<li class="sub-cat-1">
				<a href="http://localhost/kobster_v_2/index.php?id_category=9&amp;controller=category&amp;id_lang=1">lather cover</a>
				<img src="img/c/9-category.jpg" alt="" />
				<div>
								</div>
			</li>
				</ul>
	</li>
								<li class="category-3 sub">
	<a class="<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: currentCategoryId in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28287576</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28300904</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28300904</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4109</td><td bgcolor='#eeeeec' align='right'>28319032</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Trying to get property of non-object in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28287576</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>62</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28300904</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4108</td><td bgcolor='#eeeeec' align='right'>28300904</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4109</td><td bgcolor='#eeeeec' align='right'>28319032</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
" href="http://localhost/kobster_v_2/index.php?id_category=4&controller=category&id_lang=1" ><span>Laptops</span></a>
			<ul class="subcat1">
					<li class="sub-cat-0">
				<a href="http://localhost/kobster_v_2/index.php?id_category=5&amp;controller=category&amp;id_lang=1">mobile cover</a>
				<img src="img/c/5-category.jpg" alt="" />
				<div>
								</div>
			</li>
					<li class="sub-cat-1">
				<a href="http://localhost/kobster_v_2/index.php?id_category=6&amp;controller=category&amp;id_lang=1">sony</a>
				<img src="img/c/6-category.jpg" alt="" />
				<div>
								</div>
			</li>
				</ul>
	</li>
								<li class="category-4  last">
	<a class="<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: currentCategoryId in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4207</td><td bgcolor='#eeeeec' align='right'>28304128</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>59</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28317776</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28317776</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28335904</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Trying to get property of non-object in C:\wamp\www\kobster_v_2\cache\smarty\compile\bc\71\4b\bc714b1353be9e000850ed7b2d87e8a5fa05c680.file.category-tree-branch.tpl.cache.php on line <i>35</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0009</td><td bgcolor='#eeeeec' align='right'>243344</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.1370</td><td bgcolor='#eeeeec' align='right'>12809464</td><td bgcolor='#eeeeec'>DispatcherCore->dispatch(  )</td><td title='C:\wamp\www\kobster_v_2\index.php' bgcolor='#eeeeec'>..\index.php<b>:</b>28</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.1454</td><td bgcolor='#eeeeec' align='right'>13603784</td><td bgcolor='#eeeeec'>ControllerCore->run(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Dispatcher.php' bgcolor='#eeeeec'>..\Dispatcher.php<b>:</b>367</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.1923</td><td bgcolor='#eeeeec' align='right'>18295208</td><td bgcolor='#eeeeec'>IndexControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\Controller.php' bgcolor='#eeeeec'>..\Controller.php<b>:</b>189</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.1924</td><td bgcolor='#eeeeec' align='right'>18295568</td><td bgcolor='#eeeeec'>FrontControllerCore->initContent(  )</td><td title='C:\wamp\www\kobster_v_2\controllers\front\IndexController.php' bgcolor='#eeeeec'>..\IndexController.php<b>:</b>37</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.3548</td><td bgcolor='#eeeeec' align='right'>27120600</td><td bgcolor='#eeeeec'>HookCore::exec(  )</td><td title='C:\wamp\www\kobster_v_2\classes\controller\FrontController.php' bgcolor='#eeeeec'>..\FrontController.php<b>:</b>580</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27260872</td><td bgcolor='#eeeeec'>HookCore::coreCallHook(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>544</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.3577</td><td bgcolor='#eeeeec' align='right'>27261512</td><td bgcolor='#eeeeec'>TMCategories->hookTop(  )</td><td title='C:\wamp\www\kobster_v_2\classes\Hook.php' bgcolor='#eeeeec'>..\Hook.php<b>:</b>587</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.3899</td><td bgcolor='#eeeeec' align='right'>28131552</td><td bgcolor='#eeeeec'>ModuleCore->display(  )</td><td title='C:\wamp\www\kobster_v_2\modules\tmcategories\tmcategories.php' bgcolor='#eeeeec'>..\tmcategories.php<b>:</b>163</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28132896</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\module\Module.php' bgcolor='#eeeeec'>..\Module.php<b>:</b>2309</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.3900</td><td bgcolor='#eeeeec' align='right'>28133232</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>12</td><td bgcolor='#eeeeec' align='center'>0.3913</td><td bgcolor='#eeeeec' align='right'>28192240</td><td bgcolor='#eeeeec'>content_568792b2de9ed3_42924520(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>13</td><td bgcolor='#eeeeec' align='center'>0.4207</td><td bgcolor='#eeeeec' align='right'>28304128</td><td bgcolor='#eeeeec'>Smarty_Internal_Template->getSubTemplate(  )</td><td title='C:\wamp\www\kobster_v_2\cache\smarty\compile\43\53\87\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php' bgcolor='#eeeeec'>..\435387ee37a09f4505fb7c252d03c7576530c8a6.file.tmcategories.tpl.cache.php<b>:</b>59</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>14</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28317776</td><td bgcolor='#eeeeec'>Smarty_Custom_Template->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_template.php' bgcolor='#eeeeec'>..\smarty_internal_template.php<b>:</b>303</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>15</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28317776</td><td bgcolor='#eeeeec'>Smarty_Internal_TemplateBase->fetch(  )</td><td title='C:\wamp\www\kobster_v_2\classes\SmartyCustom.php' bgcolor='#eeeeec'>..\SmartyCustom.php<b>:</b>308</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>16</td><td bgcolor='#eeeeec' align='center'>0.4208</td><td bgcolor='#eeeeec' align='right'>28335904</td><td bgcolor='#eeeeec'>content_568792b2ef54f4_57880504(  )</td><td title='C:\wamp\www\kobster_v_2\tools\smarty\sysplugins\smarty_internal_templatebase.php' bgcolor='#eeeeec'>..\smarty_internal_templatebase.php<b>:</b>188</td></tr>
</table></font>
" href="http://localhost/kobster_v_2/index.php?id_category=11&controller=category&id_lang=1" ><span>Mobiles</span></a>
	</li>
				</ul>
</div>
<!-- /TM Categories --><?php }} ?>
