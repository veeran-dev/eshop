{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}>
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="utf-8" />
		<title itemprop='name'>{$meta_title|escape:'html':'UTF-8'}</title>
		<link rel="canonical" href="https://www.kobster.com/" itemprop="url">
		{if isset($meta_description) AND $meta_description}
			<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
		{/if}
		{if isset($meta_keywords) AND $meta_keywords}
			<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
		{/if}
		{if isset($mode) AND $mode == 'LIVE'}<meta name="google-site-verification" content="Iu2Zh_cuchynuyRONBC2HOFdxX50OJUXuJQFnyEw1N4" />{/if}
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($mode) AND $mode == 'LIVE'}{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow{else}noindex, nofollow{/if}" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		
		<!-- Various Icons Start -->
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
		<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
		<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="/manifest.json">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="apple-mobile-web-app-title" content="Kobster.com">
		<meta name="application-name" content="Kobster.com">
		<meta name="msapplication-TileColor" content="#ea6153">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<!-- Various Icons End -->
		
		{if isset($css_files) && $page_name != 'index'}
			{foreach from=$css_files key=css_uri item=media}
				<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
			{/foreach}
		{/if}
		{if $page_name =='index'}
			<link rel="preload" href="/homepage/public/component---src-layouts-index-js-146f86397f2331f52738.js" as="script"/>
		<link rel="preload" href="/homepage/public/component---src-pages-index-js-48f90865858ed6a77958.js" as="script"/>
		<link rel="preload" href="/homepage/public/path---index-a0e39f21c11f6a62c5ab.js" as="script"/>
		<link rel="preload" href="/homepage/public/app-637330277229ff08ef2d.js" as="script"/>
		<link rel="preload" href="/homepage/public/commons-64b0fe9dbeeba94c8697.js" as="script"/>
		{/if}
		{if $cookie->is_perks || $page_name == 'perks'}
			<link rel="stylesheet" href="{$content_dir}themes/default-bootstrap/css/perks.css" type="text/css" />
		{/if}

		<!-- BEGIN TRACKJS -->
		<!-- <script type="text/javascript">window._trackJs = { token: '57584b103bb24e8ca29872e7d8b9b579' };</script> -->
		<!-- <script type="text/javascript" src="https://d2zah9y47r7bi2.cloudfront.net/releases/current/tracker.js"></script> -->
		<!-- END TRACKJS -->

		{if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def) && $page_name != 'index'}
			{$js_def}
			{foreach from=$js_files item=js_uri}
			<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
			{/foreach}
		{else}
		    <script src="static/js/jquery-min.js"></script>
		{/if}

		{$HOOK_HEADER}
		
		<!--[start]>
			Css and JS should be changed as per prestashop feature
		<!-->

		<!--<link rel="stylesheet" href="{$base_dir}themes/default-bootstrap/css/modules/blockcart/blockcart.css" type="text/css" media="all" />
		<link rel="stylesheet" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}js/jquery/plugins/bxslider/jquery.bxslider.css" type="text/css" media="all" />

		<script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}js/additionalfeatures.js"></script>
		<script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}js/validate.js"></script>
		-->
		
		<script type='text/javascript'>
(function() {
	window.zarget=true;
	var protocol = ('https:' == document.location.protocol ? 'https:' : 'http:');
	var scriptTag = document.createElement('script');
	scriptTag.type = 'text/javascript';
	scriptTag.async = true;
	scriptTag.src = protocol +'//cdn.freshmarketer.com/206532/723429.js';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(scriptTag, s);
})();
function zargetTimeout() {
	window.zarget = false;
}
window.zargetTimer = setTimeout(zargetTimeout, 3000);
</script>
		{if $mode == 'LIVE'}
			<script>
			  dataLayer = [];
			</script>
			<!-- Google Tag Manager -->
			<noscript>
			    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-WGMT78" height="0" width="0" style="display:none;visibility:hidden"></iframe>
			</noscript>
			<script>
			    (function(w, d, s, l, i) {
			        w[l] = w[l] || [];
			        w[l].push({
			            'gtm.start': new Date().getTime(),
			            event: 'gtm.js'
			        });
			        var f = d.getElementsByTagName(s)[0],
			            j = d.createElement(s),
			            dl = l != 'dataLayer' ? '&l=' + l : '';
			        j.async = true; 
			        j.src =
			            '//www.googletagmanager.com/gtm.js?id=' + i + dl;
			        f.parentNode.insertBefore(j, f);
			    })(window, document, 'script', 'dataLayer', 'GTM-WGMT78');
			</script> 
			<!-- End Google Tag Manager -->
		{/if}
<!-- Zarget code starts here-->


	<script type='text/javascript'>
	(function() {
		window.zarget=true;
		var protocol = ('https:' == document.location.protocol ? 'https:' : 'http:');
		var scriptTag = document.createElement('script');
		scriptTag.type = 'text/javascript';
		scriptTag.async = true;
		scriptTag.src = protocol +'//cdn.zarget.com/91548/133153.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(scriptTag, s);
	})();
	function zargetTimeout() {
		window.zarget = false;
	}
	window.zargetTimer = setTimeout(zargetTimeout, 3000);
	</script>
	
<!-- Zarget code Ends here-->

		<script type="text/javascript">
			window.count=0;
			var baseDir = '{$content_dir}';
			var id_customer='{$cookie->id_customer}';			
			var id_state_vat='{$cookie->id_state_vat}';
			var name_state_vat='{$cookie->name_state_vat}';
			var pincode='{$cookie->pincode}';
			var logged='{$logged}';
			var isLogged = '{$logged}';
			var page_name = '{$page_name}'
			var voucherCode='{$cookie->voucherCode}';
			var reg_error='{$cookie->error}';
			var isPerks = '{$isPerks}';

			/*$(document).ready(function() {
				if (!localStorage.clickcount)
				{
					localStorage.clickcount = 1;
				}
				
				if(localStorage.clickcount == 2)
				{
					
					//$('#kob_state').modal('show');
					if(isLogged)
					{
						//$('#voucher-signup').modal('show');
						//$('#voucher-right').html("<h3>Hurray!</h3><h3>We are excited to give you a flat ₹ 100 off on your first buy. Use this voucher at the time of checkout.</h3><h3>Happy Shopping!</h3>");
						localStorage.clickcount = 3;
					}
					else if(reg_error)
					{
						localStorage.clickcount = 3;
						//$('#voucher-signup').modal('show');
					}

				}
				else if(localStorage.clickcount ==1 && page_name != 'index')
				{
					localStorage.clickcount = 2;
					//$('#voucher-signup').modal('show');
					$('#kob_state').modal('show');
				}
				else
				{
					//$('#voucher-signup').modal('hide');
				}
				
				$(".current_state").click(function(){
					$('#kob_state').modal('show');
				});
				$("#kob_state_close").click(function(){
					$('#kob_state').modal('hide');
				});
				
				$("#kob_state_select_btn").click(function(){
					var pincode=$("#pincode_select").val();
					if(isNaN(pincode) || pincode.length!=6 )
					{
						$("#pincode_error").show();
						return;
					}
			        var type=2;
					dataparam='&pincode='+pincode+'&type='+type;
					//console.log(dataparam);
			        $.ajax({
			        type: 'POST',
			        dataType: 'json',
			        async: true,
			        url: baseDir+'kob-select-state.php',
			        data: dataparam,
			        cache: true,
			        success: function(data) 
				        {
				        	var sort=$(".address_delivery input[name='id_address_delivery']:checked").val();
				        	var state_name=$("#address_delivery_"+sort+" .address_state_name").html();
				        	console.log(typeof state_name);
				        	if(state_name != '' && typeof state_name != 'undefined'){
    				        	state_name=state_name.toUpperCase();	
    	                        state_name=removeDiacritics(state_name);	
				        	}
				        	//console.log(state_name.toUpperCase());
				        	if(data=='678'){
				        		$("#pincode_error").show();
								return;
				        	}
				        	else if(state_name == data)
				        	{
				        	    name_state_vat = state_name;
				        		submitProcessAddress();
				        	}
				        	else{
				        		var url = window.location + '';
				        		window.location.replace(url);
				        		$('#kob_state').modal('hide');
				        	}
						}
					});
				});
				function setState(name)
				{
					//var state_id=$("#kob_state_select option:selected").val();
					//var state_name=$("#kob_state_select option:selected").text();
					var type=2;
					dataparam='&state_name='+name+'&type='+type;
					//console.log(dataparam);
			        $.ajax({
			        type: 'POST',
			        dataType: 'json',
			        async: true,
			        url: 'kob-select-state.php',
			        data: dataparam,
			        cache: true,
			        success: function(data) 
				        {
				        	//location.reload();
				        	var url = window.location + '';
				        	window.location.replace(url);
						},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
							alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
						}
					});

				}
			});*/

			// Form Validation
			$("#phone_mobile").keyup(function() {
			    var e = $("#phone_mobile");
			    if(isNaN(e.val())){
			        e.val(e.val().match(/[0-9]*/));
			    }
			});
			$("#postcode").keyup(function() {
			    var e = $("#postcode");
			    if(isNaN(e.val())){
			        e.val(e.val().match(/[0-9]*/));
			    }
			});
			
</script>		
{if $mode == 'LIVE'}
	<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "Organization",
		  "url": "https://www.kobster.com",
          "logo": "https://static.kobster.com/img/hover.png",
          "contactPoint": [
		    { "@type": "ContactPoint",
		      "telephone": "+91-1800-121-0405",
		      "contactType": "customer service",
              "contactOption" : "TollFree"
		    }
		  ],
          "sameAs": [
		    "https://www.facebook.com/kobsterIndia",
		    "https://twitter.com/kobsterOfficial",
		    "https://www.linkedin.com/company/kobster"
		  ]
		}
	</script>
{/if}
	</head>
	
	<body {if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if $isPerks ||  $page_name =="perks"}from-perks{/if} {if $page_name =="index"}elite-landing {/if}{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{else} show-left-column{/if}{if $hide_right_column} hide-right-column{else} show-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso}">
	{if $page_name !='index'}
	<div class="preloader">
		<div class="preloader-animation">
			<div class="gif"></div>
			<p>Loading, please wait...</p>
		</div>
	</div>
	{/if}
	{if !isset($content_only) || !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
			<div id="restricted-country">
				<p>{l s='You cannot place a new order from your country.'}{if isset($geolocation_country) && $geolocation_country} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span>{/if}</p>
			</div>
		{/if}
		<div id="page">
			<div class="header-container">
				{if $page_name !='index'}
				<header id="header">
					{capture name='displayBanner'}{hook h='displayBanner'}{/capture}
					{if $smarty.capture.displayBanner}
						<div class="banner">
							<div class="container">
								<div class="row">
									{$smarty.capture.displayBanner}
								</div>
							</div>
						</div>
					{/if}
					{capture name='displayNav'}{hook h='displayNav'}{/capture}
					{if $smarty.capture.displayNav}
						<div class="nav">
							<div class="container">
								<div class="row">
									<nav>{$smarty.capture.displayNav}</nav>
								</div>
							</div>
						</div>
					{/if}
					<div class="">
								<!--
                                <div id="header_logo">
									<a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}">
										<img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}/>
									</a>
								</div>-->
								{if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
					</div>
				</header>
				{else}					
					
				{/if}
			</div>
			<div class="columns-container">
				<div id="columns">
					{if $page_name !='index' && $page_name !='pagenotfound'}
						<div class="container">
						    {include file="$tpl_dir./breadcrumb.tpl"}
						</div>
					{/if}
					<div id="slider_row" class=""><!-- This line had a class of "row" earlier -->
						{capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
						{if $smarty.capture.displayTopColumn}
							<div id="top_column" class="center_column col-xs-12 col-sm-12">{$smarty.capture.displayTopColumn}</div>
						{/if}
					</div>
					<div class="{if $page_name !='index' && $page_name !='product' && $page_name!='authentication' && $page_name !='search' && $page_name !='category' && $page_name !='perksDeals' && !isset($step)}container{else}wrapper{/if} {if $left_column_size>0 || $right_column_size>0}equal-height-wrapper {/if}">
						{if isset($left_column_size) && !empty($left_column_size)}
						<div id="left_column" class="column col-xs-12 col-sm-{$left_column_size|intval} equal-height-column">{$HOOK_LEFT_COLUMN}</div>
						{/if}
						{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
						<div id="center_column" class="center_column {if $page_name !='index'} col-xs-12 col-sm-{$cols|intval}{/if}"> <!-- This line had additional classes of "col-xs-12 col-sm-{$cols|intval}" earlier -->
						{if $page_name !='index'}
							<div class="modal fade" id="kob_state" tabindex='-1' role="dialog" data-backdrop="static" data-keyboard="true" >
							    <div class="modal-dialog">
							      <div class="modal-content">
							        <div class="modal-body">
	                                	<button id="kob_state_close"  type="button" class="close" data-dismiss="modal">&nbsp;</button>
							          	<p class="lead">Share pincode to get faster delivery. This will also impact your tax rates.</p>
										<div class="pincode-form">
											<div class="pincode-input">
												<span class="map-marker-icon"></span>
												<input value="" id="pincode_select" class="form-control" maxlength="6" placeholder="Enter Pincode">
											</div>
											<button id="kob_state_select_btn" type="button" class="pincode-proceed">Proceed</button>
											<div class="alert alert-error" id="pincode_error">Please enter valid pincode</div>
										</div>
										<p class="b2b-text"><img src="{$img_dir}high-importance-16.png" class="importantance-icon" /> &nbsp; We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</p>
							        </div>
							      </div>
							    </div>
							</div>

							<!--Start Voucher Popup-->
							<div class="modal fade voucher-popup" tabindex='-1' role="dialog" data-backdrop="static" data-keyboard="true" id="voucher-signup">
							    <div class="modal-dialog">
							      <div class="modal-content">
							      	<button type="button" class="close" data-dismiss="modal">&nbsp;</button>
							        <div class="modal-body">
										<div class="voucher-section">
											<div class="content">
												<h2>Get flat ₹ 100 off on your first buy.</h2>

												<div class="get-voucher"><div class="scissor"></div><span>
												{if isset($cookie->voucherCode)}{$cookie->voucherCode}{else}Your Voucher Will Appear Here!{/if}</span></div>
											</div>
											<div class="pattern">
												<img src="{$img_dir}voucher-pattern.png" alt="Voucher Pattern">
											</div>											
										</div>
										<div class="form-section" id="voucher-right">
											<h2>Claim Your Voucher Now!</h2>

											{if $cookie->error}<div class="email-error alert">You are an existing user.</div>{/if}

											<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post">
												<div class="form-group">
													<span class="form-control-icon firstname">&nbsp;</span>
						                            <input placeholder="Name" type="text" class="form-control" data-validate="isName" id="firstname" name="firstname" value="" required>
						                        </div>

						                        <div class="form-group">
						                        	<span class="form-control-icon email-id">&nbsp;</span>
						                            <input placeholder="Email" type="email" class="form-control" data-validate="isEmail" id="email" name="email" value="" required>
						                            <input value="kobster123" id="passwd" name="passwd" type="hidden"></input>
						                            <input value="1" id="generateVoucher" name="generateVoucher" type="hidden"></input>
						                            <input type="hidden" value="{$smarty.server.REQUEST_URI}" id="currentUrl" name="currentUrl"></input>
						                        </div>
						                        
						                        <div class="form-group">
						                        	<span class="form-control-icon phone-number">&nbsp;</span>
						                            <input placeholder="Mobile" type="text" class="form-control" id="phone_mobile" name="phone_mobile" value="" inputmode="numeric" maxlength="10" required>
						                        </div>

												<div class="form-group">
													<span class="form-control-icon industry">&nbsp;</span>
						                            <select name="id_buyer" id="id_buyer" class="form-control" required>
						                                <option value="" disabled selected>Industry</option>    
						                                <option value="9">Corporate</option>
						                                <option value="5">SMEs</option>
						                                <option value="6">Retailer</option>
						                                <option value="7">Others</option>
						                            </select>
						                        </div>

						                        <div class="form-group">
						                        	<span class="form-control-icon pincode">&nbsp;</span>
						                            <input placeholder="Pincode" type="text" maxlength="6" class="form-control" id="postcode" name="postcode" value="" inputmode="numeric" required>
						                        </div>

						                        

						                        <button type="submit" name="submitAccount" id="submitAccount" class="button-black">Show my Voucher Code Now! </button>
											</form>
										</div>
							        </div>
							      </div>
							    </div>
							</div>
							<!--End Voucher Popup-->

						    <div class="modal fade" id="error_modal" tabindex='-1' role="dialog" data-backdrop="static" data-keyboard="true" >
							    <div class="modal-dialog">						    
							      <!-- Modal content-->
							      <div class="modal-content">							      
							        <div class="modal-body">
							        	<button type="button" class="close" data-dismiss="modal">&times;</button>
							        	<div class="modal-error"></div>
							        </div>
							      </div>						      
							    </div>
						    </div>
							<!-- Feedback Form -->
							<div class="modal fade" id="feedbackModal" tabindex='-1' role="dialog" data-backdrop="static" data-keyboard="true" >
							    <div class="modal-dialog">						    
							      <!-- Modal content-->
							      <div class="modal-content">							      
							        <div class="modal-body">
							        	<button  type="button" class="close" data-dismiss="modal">&nbsp;</button>
										<h2 class="feedback-title">Feedback</h2>
										<img class="feedback-thumb" src="{$tpl_uri}/img/perks/feedback.png" alt="feedback">
										<div class="message error" id="feedbackErr"></div>
										<div class="message okay" id="feedbackOk"></div>
										<form id="feebackForm">
											<div class="form-group">
												<textarea class="form-control" rows="5" id="message" name="message" placeholder="Message"></textarea>
											</div>
											<button class="btn btn-ptrimary btn-lg feedback-button" type="submit" name="perks_feedback">SEND FEEDBACK <img class="inline-loading" src="{$tpl_uri}img/perks/perks-white-loading.gif" alt="loading"/></button>
										</form>
							        </div>
							      </div>						      
							    </div>
						    </div>
							
						{/if}
  {/if}
