<?php /* Smarty version Smarty-3.1.19, created on 2018-09-21 17:41:32
         compiled from "finance\finance-footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:110505ba4dff411fd70-22193996%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8cdaf63c4719cc8fa89ddd35ff96a54e4c85098' => 
    array (
      0 => 'finance\\finance-footer.tpl',
      1 => 1537012484,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110505ba4dff411fd70-22193996',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_dir' => 0,
    'static_token' => 0,
    'token' => 0,
    'cookie' => 0,
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ba4dff42aaa20_61368266',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba4dff42aaa20_61368266')) {function content_5ba4dff42aaa20_61368266($_smarty_tpl) {?> <div aria-hidden="true" aria-labelledby="ModalLabel" role="dialog" tabindex="-1" id="globalAlert" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body"> <span id="idGlobalAlert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>
   	<script type="text/javascript">
  		var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
		var static_token = '<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
';
		var token = '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
';
		var profile = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->profile;?>
';
 	</script>

<!--<script type="text/javascript" src="finance/js/finance-index.js"></script>-->
<script src="dash/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="dash/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="dash/js/jquery.scrollTo.min.js"></script>
<script src="dash/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="dash/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="dash/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="dash/js/data-tables/dataTables.fixedColumns.js"></script>
<script type="text/javascript" src="dash/js/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="dash/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/jquery.msgPop.js"></script>
<script type="text/javascript" src="js/pop-up.js"></script>
<script type="text/javascript" src="rm/js/multiselect/js/select2.min.js"></script>
<script type="text/javascript" src="finance/js/accounting.js"></script>
<script type="text/javascript" src="finance/js/finance-receivables.js"></script>

<!--Easy Pie Chart-->
<!--<script src="dash/js/easypiechart/jquery.easypiechart.js"></script>-->
<!--Sparkline Chart-->
<!--<script src="dash/js/sparkline/jquery.sparkline.js"></script>-->
<!--jQuery Flot Chart-->
<!--<script src="dash/js/flot-chart/jquery.flot.js"></script>
<script src="dash/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="dash/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="dash/js/flot-chart/jquery.flot.resize.js"></script>
<script src="dash/js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="dash/js/chart-js/Chart.js"></script>-->

<!--common script init for all pages-->
<script src="dash/js/scripts.js"></script>

<!--script for this page-->
<script src="dash/js/gritter.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>js/jquery/jquery.autocomplete.js"></script>
<!--<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
js/tools.js"></script>-->
<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>dash/js/canvasjs.min.js"></script>
<script src="dash/js/jquery-steps/jquery.steps.js"></script>
<script src="dash/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="js/autoCompSearch.js"></script>
<script type="text/javascript">
 	$(document).ajaxSend(function()
	{
		$(".coin_loading").show();
	});

	$(document).ajaxComplete(function() 
	{
 		$(".coin_loading").hide();
 		
	});
</script>
<script type="text/javascript">
	$(function()
	 {
 		$('input, textarea').placeholder();
 	 });

	$.ajaxSetup(
	{
		timeout:30000
	});
	
	$( document ).ajaxError(function(event, request, settings,xhr) {
		var message;
		if(request.responseText != "")
			message = request.responseText;
		else
			message = request.status+": "+request.statusText;
		toast(message, "error");

		if(message == 'Your session was expired') {
			setTimeout(function() {
	    		window.location.reload();
	    	}, 2000);
		}
	});

 </script> 
 
<?php }} ?>
