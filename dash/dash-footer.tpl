		<img src="dash/img/elite-logo-print.svg" alt="Kobster Logo" id="eliteLogo" style="display:none;">
		<img src="{$content_dir}img/logo/{$id_default_group}.png" alt="Customer Logo" id="customerLogo" style="display:none;">
		<canvas id="eliteCanvasLogo" style="display:none;"></canvas>
		<canvas id="customerCanvasLogo" style="display:none;"></canvas>
		<script type="text/javascript">
			var baseDir, static_token, username, id_customer, logoutLink, companyName, priceDisplayMethod, role, stateName, cookieStateId, currencyChar, currencyFormat, currencyDecimals, currencyBlank, budgetConfigured, cookieAddressBudget, saleStatus, deliveryRegion, deliveryRegionName, cartProductWithNoRegion, id_state, reorder = 0, cookiePO, poNumber;
			baseDir = '{$content_dir}';
			static_token = '{$static_token}';
			username = '{$cookie->customer_firstname} {$cookie->customer_lastname}';
			id_customer='{$cookie->id_customer}';
			logoutLink = '{$link->getPageLink("dash-login.php&mylogout")}';
			companyName = '{$cookie->companyName}';
			priceDisplayMethod = {$priceDisplay};
			role = '{$cookie->role}';
		    currencyChar = '{$cookie->c_char}';
		    currencyFormat = '{$cookie->c_format}';
		    currencyDecimals = '{$cookie->c_decimals}';
		    currencyBlank = '{$cookie->c_blank}';
		    budgetConfigured = '{$cookie->budget_configured}';
		    cookieAddressBudget = '{$cookie->id_address_budget}';
		    budgetOption = '{$cookie->budget_option}';
		    saleStatus = '{$noSales}';
		    deliveryRegion = '{$cookie->delivery_region}';
		    deliveryRegionName = '{$cookie->delivery_region_name}';
		    cartProductWithNoRegion = '{$cart_region_not_exists}';
		    id_state = '{$cookie->id_state}';
		    cookiePO = '{$cookie->id_purchase_order}';
		    cookiePONumber = '{$cookie->po_number}';
		</script>
		<script type="text/javascript" src="dash/dist/bundle.js"></script>
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
		{literal}
			<script type="text/javascript">
				var $zoho=$zoho||{livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);
			</script>
			<script language='javascript'>window._wfx_widget={"color":"#ED9121", "position":"r", "host":"kobster.com", "label":"Self Help", "title":"Self Help", "mode":"live"};</script><script language='javascript' async='true' type='text/javascript' src='//whatfix.com/embed/embed.nocache.js'></script>
		{/literal}
		<script type="text/javascript" src="dash/common/js/canvasjs.min.js" async></script>
		<script type="text/javascript" src="dash/common/js/jspdf.min.js" async></script>
	</body>
</html>