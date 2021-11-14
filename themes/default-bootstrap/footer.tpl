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
{if $page_name != 'index'}
{if !isset($content_only) || !$content_only}
					</div><!-- #center_column -->
					{if isset($right_column_size) && !empty($right_column_size)}
						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column equal-height-column">{$HOOK_RIGHT_COLUMN}</div>
					{/if}
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			{if isset($HOOK_FOOTER)}
				<!-- Footer -->
				{if $cookie->is_perks == 1 || $page_name == 'perks'}
					<div class="support-container">
						<div class="container">
							<div class="support-column">
								<img src="{$tpl_uri}img/perks/footer/free-delivery.png" alt="" />
								<h3>Free Delivery</h3>
								<span>Across the 5 Major Cities</span>
								<span class="small">Chennai, Bengaluru, Delhi, Mumbai & Hyderabad</span>
							</div>
							<div class="support-column">
								<img src="{$tpl_uri}img/perks/footer/secure-payments.png" alt="" />
								<h3>Secure Payments</h3>
								<span>All major credit and debit cards are accepted.</span>
							</div>
							<div class="support-column">
								<img src="{$tpl_uri}img/perks/footer/quality.png" alt="" />
								<h3>Brand New and Genuine</h3>
								<span>100% quality products</span>
							</div>
							<div class="support-column">
								<img src="{$tpl_uri}img/perks/footer/tollfree.png" alt="" />
								<h3>Help Center</h3>
								<span>Need help? Call <a href="tel:18001210405">1800-121-0405</a> (Toll Free)</span>
								<span><a href="mailto:perks@kobster.com">perks@kobster.com</a></span>
							</div>
						</div>
					</div>
				{else}
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
				{/if}
				<div class="footer-container">
					<footer id="footer"  class="container">
						{if $cookie->is_perks == 1 || $page_name == 'perks'}
							<p class="footer-links">
							<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">My Account</a>&middot;
							<a href="index.php?controller=cms?id_cms=24">Terms and Conditions</a>&middot;
							<a href="index.php?controller=cms?id_cms=22">Privacy Policy</a>&middot;
							<a href="index.php?controller=cms?id_cms=23">Shipping Policy</a>&middot;
							<a href="index.php?controller=cms?id_cms=21">Cancellation, Return & Replacement Policy</a></p>
						{else}
							{$HOOK_FOOTER}
						{/if}
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
					        	<p><span>Made with <span class="heart">&#10084;</span> in India &#124; </span><span>&copy;</span> <span>{l s='Kobster.com - 2012-2018'}</span></p>
					        </div>
					    </div>
					</footer>
					<a href="#" class="scroll-to-top" title="Back to Top"><span>&nbsp;</span></a>
				</div><!-- #footer -->

				<!-- Checkout page footer -->
				{if $page_name == 'order'}
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
				{/if}
			{/if}
		</div><!-- #page -->
{/if}
{include file="$tpl_dir./global.tpl"}
	{if $page_name == 'index'}
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
	{/if}
	{if $page_name == 'perksDeals'}
		<script src="{$tpl_uri}js/owl.carousel.min.js" type="text/javascript"></script>
		<script src="{$tpl_uri}js/owl.config.js" type="text/javascript"></script>
		{if $mode == 'LIVE'}
			<script>
			{literal}
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-101262119-1', 'auto');
				ga('send', 'pageview');
			{/literal}
			</script>
		{/if}
	{/if}
{/if}
	</body>
}

</html>