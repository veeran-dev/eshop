<?php /* Smarty version Smarty-3.1.19, created on 2018-02-09 18:02:04
         compiled from "C:\wamp\www\kobsterEshop\themes\default-bootstrap\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188155a7d94c4e40836-08402255%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93f43c1cfbed265633fd8221c862476174f31844' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\themes\\default-bootstrap\\footer.tpl',
      1 => 1510040453,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188155a7d94c4e40836-08402255',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'right_column_size' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'cookie' => 0,
    'page_name' => 0,
    'tpl_uri' => 0,
    'link' => 0,
    'mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7d94c4f3df21_56900214',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7d94c4f3df21_56900214')) {function content_5a7d94c4f3df21_56900214($_smarty_tpl) {?>
<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
					</div><!-- #center_column -->
					<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
						<div id="right_column" class="col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
 column equal-height-column"><?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>
</div>
					<?php }?>
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
				<!-- Footer -->
				<?php if ($_smarty_tpl->tpl_vars['cookie']->value->is_perks==1||$_smarty_tpl->tpl_vars['page_name']->value=='perks') {?>
					<div class="support-container">
						<div class="container">
							<div class="support-column">
								<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/footer/free-delivery.png" alt="" />
								<h3>Free Delivery</h3>
								<span>Across the 5 Major Cities</span>
								<span class="small">Chennai, Bengaluru, Delhi, Mumbai & Hyderabad</span>
							</div>
							<div class="support-column">
								<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/footer/secure-payments.png" alt="" />
								<h3>Secure Payments</h3>
								<span>All major credit and debit cards are accepted.</span>
							</div>
							<div class="support-column">
								<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/footer/quality.png" alt="" />
								<h3>Brand New and Genuine</h3>
								<span>100% quality products</span>
							</div>
							<div class="support-column">
								<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/footer/tollfree.png" alt="" />
								<h3>Help Center</h3>
								<span>Need help? Call <a href="tel:18001210405">1800-121-0405</a> (Toll Free)</span>
								<span><a href="mailto:perks@kobster.com">perks@kobster.com</a></span>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="support-container">
						<div class="container">
							<div class="support-column">
								<h3>Business Friendly Partner</h3>
								<span>Focusing only the Corporates, SMEs, Professionals &amp; Resellers</span>
							</div>
							<div class="support-column">
								<h3>Pan India Delivery</h3>
								<span>Safe Shipment across the country</span>
							</div>
							<div class="support-column">
								<h3>Secure Payment</h3>
								<span>Credit / Debit / COD</span>
							</div>
							<div class="support-column">
								<!--<a href="https://elite.kobster.com" target="_blank">-->
								<a href="/index.php?controller=dash-login" target="_blank">
								
									<h3 class="elite-link">Kobster Elite</h3>
									<span>Centralized Procurement Platform</span>
								</a>
							</div>
							<div class="support-column">
								<h3>Customer Service</h3>
								<span>1800-121-0405 (Toll Free) / support@kobster.com</span>
							</div>
						</div>
					</div>
				<?php }?>
				<div class="footer-container">
					<footer id="footer"  class="container">
						<?php if ($_smarty_tpl->tpl_vars['cookie']->value->is_perks==1||$_smarty_tpl->tpl_vars['page_name']->value=='perks') {?>
							<p class="footer-links">
							<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
">My Account</a>&middot;
							<a href="index.php?controller=cms?id_cms=24">Terms and Conditions</a>&middot;
							<a href="index.php?controller=cms?id_cms=22">Privacy Policy</a>&middot;
							<a href="index.php?controller=cms?id_cms=23">Shipping Policy</a>&middot;
							<a href="index.php?controller=cms?id_cms=21">Cancellation, Return & Replacement Policy</a></p>
						<?php } else { ?>
							<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

						<?php }?>
						<div class="clearfix"></div>
					    <div class="copyright">
					    	<div class="payment-methods-wrapper">
					    		<div class="payment-methods visa" title="Visa"></div>
					    		<div class="payment-methods master-card" title="Maestro"></div>
					    		<div class="payment-methods maestro" title="Master Card"></div>
					    		<!-- <div class="payment-methods net-banking" title="Net Banking"></div> -->
					    		<!-- <div class="payment-methods cheque" title="Cheque Payment"></div> -->
					    		<div class="payment-methods cod" title="Cash on Delivery"></div>
					    		<!-- <div class="payment-methods credit" title="Credit Payment"></div> -->
					    	</div>
					        <div class="copyright-info">
					        	<p><span>Made with <span class="heart">&#10084;</span> in India &#124; </span><span>&copy;</span> <span><?php echo smartyTranslate(array('s'=>'Kobster.com - 2012-2017'),$_smarty_tpl);?>
</span></p>
					        </div>
					    </div>
					</footer>
					<a href="#" class="scroll-to-top" title="Back to Top"><span>&nbsp;</span></a>
				</div><!-- #footer -->

				<!-- Checkout page footer -->
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='order') {?>
					<div class="minimal-footer copyright">
						<div class="help-info">
							<p>Need instant help? Call <a href="tel:18001210405"><strong>1800-121-0405</strong></a></p>
						</div>
						<div class="payment-methods-wrapper">
							<div class="payment-methods visa" title="Visa"></div>
							<div class="payment-methods master-card" title="Maestro"></div>
							<div class="payment-methods maestro" title="Master Card"></div>
							<div class="payment-methods cod" title="Cash on Delivery"></div>
						</div>
					</div>
				<?php }?>
			<?php }?>
		</div><!-- #page -->
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index') {?>
		<script src="static/js/jquery.fullPage.min.js"></script>
		<script src="static/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="static/js/aos.js"></script>
		<script src="static/js/jquery.bxslider.js"></script>
		<script src="static/js/smooth-on-scroll.js"></script>
		<script src="static/js/smooth-scroll.js"></script>						    
		<script src="static/js/static-validate.js" type="text/javascript"></script> 
		<script src="static/js/owl.carousel.min.js"></script>						    
		<script src="static/js/fullPage.custom.js"></script>
		<script src="static/js/custom.js"></script>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='perksDeals') {?>
		<script src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
js/owl.carousel.min.js" type="text/javascript"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
js/owl.config.js" type="text/javascript"></script>
		<?php if ($_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?>
			<script>
			
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-101262119-1', 'auto');
				ga('send', 'pageview');
			
			</script>
		<?php }?>
	<?php }?>
	</body>
</html><?php }} ?>
