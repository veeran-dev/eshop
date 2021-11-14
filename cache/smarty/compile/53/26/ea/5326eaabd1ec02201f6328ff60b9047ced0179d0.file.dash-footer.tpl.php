<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:50:32
         compiled from "dash\dash-footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:62925a7c328098dc33-33541170%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5326eaabd1ec02201f6328ff60b9047ced0179d0' => 
    array (
      0 => 'dash\\dash-footer.tpl',
      1 => 1511934029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62925a7c328098dc33-33541170',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_dir' => 0,
    'id_default_group' => 0,
    'static_token' => 0,
    'cookie' => 0,
    'link' => 0,
    'priceDisplay' => 0,
    'noSales' => 0,
    'cart_region_not_exists' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7c3280a76c77_80824331',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c3280a76c77_80824331')) {function content_5a7c3280a76c77_80824331($_smarty_tpl) {?>		<img src="dash/img/elite-logo-print.svg" alt="Kobster Logo" id="eliteLogo" style="display:none;">
		<img src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
img/logo/<?php echo $_smarty_tpl->tpl_vars['id_default_group']->value;?>
.png" alt="Customer Logo" id="customerLogo" style="display:none;">
		<canvas id="eliteCanvasLogo" style="display:none;"></canvas>
		<canvas id="customerCanvasLogo" style="display:none;"></canvas>
		<script type="text/javascript">
			var baseDir, static_token, username, id_customer, logoutLink, companyName, priceDisplayMethod, role, stateName, cookieStateId, currencyChar, currencyFormat, currencyDecimals, currencyBlank, budgetConfigured, cookieAddressBudget, saleStatus, deliveryRegion, deliveryRegionName, cartProductWithNoRegion, id_state, reorder = 0;
			baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
			static_token = '<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
';
			username = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
';
			id_customer='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_customer;?>
';
			logoutLink = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink("dash-login.php&mylogout");?>
';
			companyName = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->companyName;?>
';
			priceDisplayMethod = <?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
;
			role = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->role;?>
';
		    currencyChar = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_char;?>
';
		    currencyFormat = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_format;?>
';
		    currencyDecimals = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_decimals;?>
';
		    currencyBlank = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->c_blank;?>
';
		    budgetConfigured = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->budget_configured;?>
';
		    cookieAddressBudget = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_address_budget;?>
';
		    budgetOption = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->budget_option;?>
';
		    saleStatus = '<?php echo $_smarty_tpl->tpl_vars['noSales']->value;?>
';
		    deliveryRegion = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->delivery_region;?>
';
		    deliveryRegionName = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->delivery_region_name;?>
';
		    cartProductWithNoRegion = '<?php echo $_smarty_tpl->tpl_vars['cart_region_not_exists']->value;?>
';
		    id_state = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_state;?>
';
		</script>
		<script type="text/javascript" src="dash/bundle.js"></script>
		<script type="text/javascript">
		    document.onreadystatechange = function() {
			  if (document.readyState === 'complete') {
			  	if(saleStatus == 1 && localStorage.getItem('shopSaleStatus') != 1) {
			  		document.getElementById("shopSaleStatus").setAttribute("style", "display: flex; display: -webkit-flex;");
			  		document.body.classList.add('modal-open');
			  	}

			  	if(cartProductWithNoRegion == 1) {
			  		document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
            		document.body.classList.add('modal-open');
			  	}

			  	setTimeout(function (){
			  		if(budgetConfigured == 1 && (cookieAddressBudget == "" || cookieAddressBudget == undefined)) {
			  			document.getElementById("addressSelection").setAttribute("style", "display: flex; display: -webkit-flex;");
			  			document.body.classList.add('modal-open');
			  		}
			  	}, 500);
			  }
			}
		</script>
		
			<script type="text/javascript">
				var $zoho=$zoho||{livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);
			</script>
			<script language='javascript'>window._wfx_widget={"color":"#ED9121", "position":"r", "host":"kobster.com", "label":"Self Help", "title":"Self Help", "mode":"live"};</script><script language='javascript' async='true' type='text/javascript' src='//whatfix.com/embed/embed.nocache.js'></script>
		
		<script type="text/javascript" src="dash/common/js/canvasjs.min.js" async></script>
		<script type="text/javascript" src="dash/common/js/jspdf.min.js" async></script>
	</body>
</html><?php }} ?>
