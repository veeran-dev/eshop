<?php /* Smarty version Smarty-3.1.19, created on 2020-08-28 15:59:52
         compiled from "C:\wamp64\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4718257915f48dca03c9af7-29578903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ea4772bec669781763993b9e0735b2dbf9b3840' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_header.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4718257915f48dca03c9af7-29578903',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ASSearchUrlForm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f48dca0450412_73297474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f48dca0450412_73297474')) {function content_5f48dca0450412_73297474($_smarty_tpl) {?><!-- MODULE PM_AdvancedSearch4 || Presta-Module.com -->
<script type="text/javascript">
var ASPath = '<?php echo @constant('__PS_BASE_URI__');?>
modules/pm_advancedsearch4/';
var ASSearchUrl = '<?php echo $_smarty_tpl->tpl_vars['ASSearchUrlForm']->value;?>
';
var ASParams = {};
var ASHash = {};
var ASPSVersion = '<?php echo @constant('_PS_VERSION_');?>
';
$(document).ready(function() { asInitAsHashChange(); });
</script>
<!-- MODULE PM_AdvancedSearch4 || Presta-Module.com --><?php }} ?>
