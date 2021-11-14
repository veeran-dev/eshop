<?php /* Smarty version Smarty-3.1.19, created on 2018-02-09 18:02:03
         compiled from "C:\wamp\www\kobsterEshop\themes\default-bootstrap\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161605a7d94c3ef44f8-53551464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ce7e2f909289ee370cbfe174272d9308a312b2a' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\themes\\default-bootstrap\\header.tpl',
      1 => 1510040453,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161605a7d94c3ef44f8-53551464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language_code' => 0,
    'meta_title' => 0,
    'meta_description' => 0,
    'meta_keywords' => 0,
    'mode' => 0,
    'nobots' => 0,
    'nofollow' => 0,
    'css_files' => 0,
    'page_name' => 0,
    'css_uri' => 0,
    'media' => 0,
    'cookie' => 0,
    'content_dir' => 0,
    'js_defer' => 0,
    'js_files' => 0,
    'js_def' => 0,
    'js_uri' => 0,
    'HOOK_HEADER' => 0,
    'base_dir' => 0,
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'logged' => 0,
    'isPerks' => 0,
    'body_classes' => 0,
    'hide_left_column' => 0,
    'hide_right_column' => 0,
    'content_only' => 0,
    'lang_iso' => 0,
    'restricted_country_mode' => 0,
    'geolocation_country' => 0,
    'shop_name' => 0,
    'logo_url' => 0,
    'logo_image_width' => 0,
    'logo_image_height' => 0,
    'HOOK_TOP' => 0,
    'step' => 0,
    'left_column_size' => 0,
    'right_column_size' => 0,
    'HOOK_LEFT_COLUMN' => 0,
    'cols' => 0,
    'img_dir' => 0,
    'link' => 0,
    'tpl_uri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7d94c45b45f3_17814457',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7d94c45b45f3_17814457')) {function content_5a7d94c45b45f3_17814457($_smarty_tpl) {?><?php if (!is_callable('smarty_function_implode')) include 'C:\\wamp\\www\\kobsterEshop\\tools\\smarty\\plugins\\function.implode.php';
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<html<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="utf-8" />
		<title itemprop='name'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_title']->value, ENT_QUOTES, 'UTF-8', true);?>
</title>
		<link rel="canonical" href="https://www.kobster.com/" itemprop="url">
		<?php if (isset($_smarty_tpl->tpl_vars['meta_description']->value)&&$_smarty_tpl->tpl_vars['meta_description']->value) {?>
			<meta name="description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_description']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['meta_keywords']->value)&&$_smarty_tpl->tpl_vars['meta_keywords']->value) {?>
			<meta name="keywords" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_keywords']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['mode']->value)&&$_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?><meta name="google-site-verification" content="Iu2Zh_cuchynuyRONBC2HOFdxX50OJUXuJQFnyEw1N4" /><?php }?>
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="<?php if (isset($_smarty_tpl->tpl_vars['mode']->value)&&$_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?><?php if (isset($_smarty_tpl->tpl_vars['nobots']->value)) {?>no<?php }?>index,<?php if (isset($_smarty_tpl->tpl_vars['nofollow']->value)&&$_smarty_tpl->tpl_vars['nofollow']->value) {?>no<?php }?>follow<?php } else { ?>noindex, nofollow<?php }?>" />
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
		
		<?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)&&$_smarty_tpl->tpl_vars['page_name']->value!='index') {?>
			<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value) {
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
				<link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
			<?php } ?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index') {?>
			<link rel="stylesheet" href="themes/default-bootstrap/css/elite-landing.css" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['cookie']->value->is_perks||$_smarty_tpl->tpl_vars['page_name']->value=='perks') {?>
			<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
themes/default-bootstrap/css/perks.css" type="text/css" />
		<?php }?>

		<!-- BEGIN TRACKJS -->
		<!-- <script type="text/javascript">window._trackJs = { token: '57584b103bb24e8ca29872e7d8b9b579' };</script> -->
		<!-- <script type="text/javascript" src="https://d2zah9y47r7bi2.cloudfront.net/releases/current/tracker.js"></script> -->
		<!-- END TRACKJS -->

		<?php if (isset($_smarty_tpl->tpl_vars['js_defer']->value)&&!$_smarty_tpl->tpl_vars['js_defer']->value&&isset($_smarty_tpl->tpl_vars['js_files']->value)&&isset($_smarty_tpl->tpl_vars['js_def']->value)&&$_smarty_tpl->tpl_vars['page_name']->value!='index') {?>
			<?php echo $_smarty_tpl->tpl_vars['js_def']->value;?>

			<?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value) {
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>
			<script type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['js_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
"></script>
			<?php } ?>
		<?php } else { ?>
		    <script src="static/js/jquery-min.js"></script>
		<?php }?>

		<?php echo $_smarty_tpl->tpl_vars['HOOK_HEADER']->value;?>

		
		<!--[start]>
			Css and JS should be changed as per prestashop feature
		<!-->

		<!--<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
themes/default-bootstrap/css/modules/blockcart/blockcart.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>js/jquery/plugins/bxslider/jquery.bxslider.css" type="text/css" media="all" />

		<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>js/additionalfeatures.js"></script>
		<script type="text/javascript" src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>js/validate.js"></script>
		-->
		<?php if ($_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?>
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
		<?php }?>
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
			var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
			var id_customer='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_customer;?>
';			
			var id_state_vat='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_state_vat;?>
';
			var name_state_vat='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->name_state_vat;?>
';
			var pincode='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->pincode;?>
';
			var logged='<?php echo $_smarty_tpl->tpl_vars['logged']->value;?>
';
			var isLogged = '<?php echo $_smarty_tpl->tpl_vars['logged']->value;?>
';
			var page_name = '<?php echo $_smarty_tpl->tpl_vars['page_name']->value;?>
'
			var voucherCode='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->voucherCode;?>
';
			var reg_error='<?php echo $_smarty_tpl->tpl_vars['cookie']->value->error;?>
';
			var isPerks = '<?php echo $_smarty_tpl->tpl_vars['isPerks']->value;?>
';

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
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?>
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
<?php }?>
	</head>
	
	<body <?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {?> id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> class="<?php if ($_smarty_tpl->tpl_vars['isPerks']->value||$_smarty_tpl->tpl_vars['page_name']->value=="perks") {?>from-perks<?php }?> <?php if ($_smarty_tpl->tpl_vars['page_name']->value=="index") {?>elite-landing <?php }?><?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['body_classes']->value)&&count($_smarty_tpl->tpl_vars['body_classes']->value)) {?> <?php echo smarty_function_implode(array('value'=>$_smarty_tpl->tpl_vars['body_classes']->value,'separator'=>' '),$_smarty_tpl);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['hide_left_column']->value) {?> hide-left-column<?php } else { ?> show-left-column<?php }?><?php if ($_smarty_tpl->tpl_vars['hide_right_column']->value) {?> hide-right-column<?php } else { ?> show-right-column<?php }?><?php if (isset($_smarty_tpl->tpl_vars['content_only']->value)&&$_smarty_tpl->tpl_vars['content_only']->value) {?> content_only<?php }?> lang_<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
">
	<div class="preloader">
		<div class="preloader-animation">
			<div class="gif"></div>
			<p>Loading, please wait...</p>
		</div>
	</div>
	<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['restricted_country_mode']->value) {?>
			<div id="restricted-country">
				<p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['geolocation_country']->value)&&$_smarty_tpl->tpl_vars['geolocation_country']->value) {?> <span class="bold"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['geolocation_country']->value, ENT_QUOTES, 'UTF-8', true);?>
</span><?php }?></p>
			</div>
		<?php }?>
		<div id="page">
			<div class="header-container">
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index') {?>
				<header id="header">
					<?php $_smarty_tpl->_capture_stack[0][] = array('displayBanner', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayBanner'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
					<?php if (Smarty::$_smarty_vars['capture']['displayBanner']) {?>
						<div class="banner">
							<div class="container">
								<div class="row">
									<?php echo Smarty::$_smarty_vars['capture']['displayBanner'];?>

								</div>
							</div>
						</div>
					<?php }?>
					<?php $_smarty_tpl->_capture_stack[0][] = array('displayNav', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayNav'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
					<?php if (Smarty::$_smarty_vars['capture']['displayNav']) {?>
						<div class="nav">
							<div class="container">
								<div class="row">
									<nav><?php echo Smarty::$_smarty_vars['capture']['displayNav'];?>
</nav>
								</div>
							</div>
						</div>
					<?php }?>
					<div class="">
								<!--
                                <div id="header_logo">
									<a href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
										<img class="logo img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value)&&$_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value)&&$_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?>/>
									</a>
								</div>-->
								<?php if (isset($_smarty_tpl->tpl_vars['HOOK_TOP']->value)) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;?>
<?php }?>
					</div>
				</header>
				<?php } else { ?>					
					<header id="header">
					      <div class="header-top clearfix">
					        <a href="https://www.kobster.com" class="logo">
					        	<img class="logo elite-white-logo" src="static/img/elite/elite-logo.png"/>
					            <img class="logo elite-logo" src="static/img/elite/elite-logo.png"/>
					        </a>
					        
					        <a class="btn btn-common elite_login" href="https://elite.kobster.com" >
								Login to Elite
					        </a>

							<!-- <a class="btn btn-common shop-now" href="shop" title="Make a Quick Purchase at Kobster">
								Quick Buy
					        </a> -->
					        
					        <a class="l-right toggle-menu red-menu" href="#">
					          <i></i>
					          <i></i>
					          <i></i>
					          
					          <span>Menu</span>
							  
					        </a>
					      </div>

					      <nav class="hide">
					        <ul id="menu">
					          <li data-menuanchor="Elite">
					            <a href="#Elite" title="Kobster Elite - Sourcing Simplified!">Kobster Elite - Sourcing Simplified!</a>
					          </li>
					          <li data-menuanchor="Benefits">
					            <a href="#Benefits" title="Benefits of Kobster Elite">Benefits of Kobster Elite</a>
					          </li>
					          <li data-menuanchor="Why-Kobster">
					            <a href="#Why-Kobster" title="Why Choose Kobster Elite">Why Choose Kobster Elite</a>
					          </li>
					          <li data-menuanchor="Our-clients">
					            <a href="#Our-clients" title="Our clients">Our Clients</a>
					          </li>
					          <li data-menuanchor="Categories">
					            <a href="#Categories" title="Assorted category of Products">Assorted Category of Products</a>
					          </li>
					          <li data-menuanchor="Become-a-client">
					            <a href="#Become-a-client" title="Become our client now!">Become our Client Now!</a>
					          </li>
							  <li data-menuanchor="About">
					            <a href="#About" title="About Us">More About Us</a>
					          </li>
							  <li>
					            <a class="elite-mobile-login" href="https://elite.kobster.com">Login to Elite</a>
					          </li>
					        </ul>
					      </nav>
					    </header>
				<?php }?>
			</div>
			<div class="columns-container">
				<div id="columns">
					<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'&&$_smarty_tpl->tpl_vars['page_name']->value!='pagenotfound') {?>
						<div class="container">
						    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</div>
					<?php }?>
					<div id="slider_row" class=""><!-- This line had a class of "row" earlier -->
						<?php $_smarty_tpl->_capture_stack[0][] = array('displayTopColumn', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayTopColumn'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
						<?php if (Smarty::$_smarty_vars['capture']['displayTopColumn']) {?>
							<div id="top_column" class="center_column col-xs-12 col-sm-12"><?php echo Smarty::$_smarty_vars['capture']['displayTopColumn'];?>
</div>
						<?php }?>
					</div>
					<div class="<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'&&$_smarty_tpl->tpl_vars['page_name']->value!='product'&&$_smarty_tpl->tpl_vars['page_name']->value!='authentication'&&$_smarty_tpl->tpl_vars['page_name']->value!='search'&&$_smarty_tpl->tpl_vars['page_name']->value!='category'&&$_smarty_tpl->tpl_vars['page_name']->value!='perksDeals'&&!isset($_smarty_tpl->tpl_vars['step']->value)) {?>container<?php } else { ?>wrapper<?php }?> <?php if ($_smarty_tpl->tpl_vars['left_column_size']->value>0||$_smarty_tpl->tpl_vars['right_column_size']->value>0) {?>equal-height-wrapper <?php }?>">
						<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['left_column_size']->value)) {?>
						<div id="left_column" class="column col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['left_column_size']->value);?>
 equal-height-column"><?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>
</div>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&isset($_smarty_tpl->tpl_vars['right_column_size']->value)) {?><?php $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable((12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value), null, 0);?><?php } else { ?><?php $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(12, null, 0);?><?php }?>
						<div id="center_column" class="center_column <?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index') {?> col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
<?php }?>"> <!-- This line had additional classes of "col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
" earlier -->
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
										<p class="b2b-text"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
high-importance-16.png" class="importantance-icon" /> &nbsp; We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</p>
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
												<?php if (isset($_smarty_tpl->tpl_vars['cookie']->value->voucherCode)) {?><?php echo $_smarty_tpl->tpl_vars['cookie']->value->voucherCode;?>
<?php } else { ?>Your Voucher Will Appear Here!<?php }?></span></div>
											</div>
											<div class="pattern">
												<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
voucher-pattern.png" alt="Voucher Pattern">
											</div>											
										</div>
										<div class="form-section" id="voucher-right">
											<h2>Claim Your Voucher Now!</h2>

											<?php if ($_smarty_tpl->tpl_vars['cookie']->value->error) {?><div class="email-error alert">You are an existing user.</div><?php }?>

											<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post">
												<div class="form-group">
													<span class="form-control-icon firstname">&nbsp;</span>
						                            <input placeholder="Name" type="text" class="form-control" data-validate="isName" id="firstname" name="firstname" value="" required>
						                        </div>

						                        <div class="form-group">
						                        	<span class="form-control-icon email-id">&nbsp;</span>
						                            <input placeholder="Email" type="email" class="form-control" data-validate="isEmail" id="email" name="email" value="" required>
						                            <input value="kobster123" id="passwd" name="passwd" type="hidden"></input>
						                            <input value="1" id="generateVoucher" name="generateVoucher" type="hidden"></input>
						                            <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI'];?>
" id="currentUrl" name="currentUrl"></input>
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
										<img class="feedback-thumb" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
/img/perks/feedback.png" alt="feedback">
										<div class="message error" id="feedbackErr"></div>
										<div class="message okay" id="feedbackOk"></div>
										<form id="feebackForm">
											<div class="form-group">
												<textarea class="form-control" rows="5" id="message" name="message" placeholder="Message"></textarea>
											</div>
											<button class="btn btn-ptrimary btn-lg feedback-button" type="submit" name="perks_feedback">SEND FEEDBACK <img class="inline-loading" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/perks-white-loading.gif" alt="loading"/></button>
										</form>
							        </div>
							      </div>						      
							    </div>
						    </div>
							
							
  <?php }?>
<?php }} ?>
