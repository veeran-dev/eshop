<?php /* Smarty version Smarty-3.1.19, created on 2018-04-01 16:10:19
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\perksDeals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138785ac0b7131c7c45-43855820%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '115ac7a7519ab0a9808d92ebc8afe9b51d605822' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\perksDeals.tpl',
      1 => 1522579211,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138785ac0b7131c7c45-43855820',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl_uri' => 0,
    'link' => 0,
    'dealsCategory' => 0,
    'cDeals' => 0,
    'deal' => 0,
    'img' => 0,
    'color' => 0,
    'static_token' => 0,
    'product' => 0,
    'deals' => 0,
    'company_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ac0b7136bcb86_78707273',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac0b7136bcb86_78707273')) {function content_5ac0b7136bcb86_78707273($_smarty_tpl) {?><div class="feedback-float-button">
	<a data-toggle="modal" data-target="#feedbackModal" href="#" title="Feedback">
	<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/face.png" alt="smiley"/> Feedback
	</a>
</div>
<div class="perks-main-banner" style="visibility: hidden;">
	<ul class="perksMainBanner">
		<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink(987236), ENT_QUOTES, 'UTF-8', true);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/main-banner/banner-4.jpg" /></a></li>
		<li><a href="javascript:void(0);"><img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/main-banner/banner-0.jpg" /></a></li>
		<li><a href="#41203071"><img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/main-banner/banner-5.jpg" /></a></li>
	</ul>
	<div class="banner-controls">
		<div class="arrow-button" id="prevBigBanner"></div>
		<div class="arrow-button" id="nextBigBanner"></div>
	</div>
</div>

<div class="perks-pitch">
	<ol class="perks-pitch-list">
		<li class="perks-pitch-list-item">Enjoy Highest Shopping Benefits</li>
		<li class="perks-pitch-list-item">Compare Prices to be Amazed</li>
		<li class="perks-pitch-list-item">Get Free Access Today</li>
	</ol>
</div>

<div class="container category-links">
	<div class="row">
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41202326">
				<div class="category-link-name">
					<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/category/smartphone.jpg" alt="Mobile Phones">
					<span>MOBILE PHONES</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 29% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41203071">
				<div class="category-link-name">	
					<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/category/woman-ambassadors-jewellery.jpg" alt="Woman Ambassador Jewellery">
					<span>WOMAN AMBASSADORS JEWELLERY</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 5% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41202971">
				<div class="category-link-name">
					<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/category/audio-systems.jpg" alt="Music Systems">
					<span>Music Systems</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 20% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		
	</div>
</div>

<?php  $_smarty_tpl->tpl_vars['cDeals'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cDeals']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dealsCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cDeals']->key => $_smarty_tpl->tpl_vars['cDeals']->value) {
$_smarty_tpl->tpl_vars['cDeals']->_loop = true;
?>
	<div class="perks-title">
		<h2 id="<?php echo $_smarty_tpl->tpl_vars['cDeals']->value[0]['id_category'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['cDeals']->value[0]['c_name'];?>
</span></h2>
	</div>
	<div class="perks-product-container">
		<?php  $_smarty_tpl->tpl_vars['deal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['deal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cDeals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['deal']->key => $_smarty_tpl->tpl_vars['deal']->value) {
$_smarty_tpl->tpl_vars['deal']->_loop = true;
?>
		
		<div class="perks-product">
			<div class="product-info">
				<div class="product-visual">
					<?php if (count($_smarty_tpl->tpl_vars['deal']->value['imagesArr'])) {?>
					<div class="product-carousel">
						<div class="owl-carousel owl-theme">
							<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deal']->value['imagesArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['deal']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
" target="_blank">
									<img class="item" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/product-preloader.gif" data-src="<?php echo $_smarty_tpl->tpl_vars['img']->value;?>
">
								</a>
							<?php } ?>
						</div>
					</div>
					<?php } else { ?>
						<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['deal']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
" target="_blank">
							<img class="single-image" src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/product-preloader.gif" data-src="<?php echo $_smarty_tpl->tpl_vars['deal']->value['imageLink2'];?>
"  alt="<?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
" />
						</a>
					<?php }?>
					<div class="product-labels">
					
					<?php if ($_smarty_tpl->tpl_vars['deal']->value['price']>=7000) {?>
						<span class="emi">EMI</span>
					<?php }?>
					<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['deal']->value['description'], $tmp)>1) {?>
						<span class="offers">OFFERS</span>
					<?php }?>
					</div>
					<?php if ($_smarty_tpl->tpl_vars['deal']->value['price']>=7000) {?>
						<div class="emi-details">
							<h4>EMI DETAILS</h4>
							<?php if ($_smarty_tpl->tpl_vars['deal']->value['id_category']==5) {?>
								<h3>No Cost EMI</h3>
								<p>Select COD Option. Swipe your credit card with the delivery executive to avail this.</p>
								<h3>EMI with Interest</h3>
								<p>Select Credit Card Option during Check Out and Opt for EMI in our payment gateway page.</p>
							<?php } else { ?>
								<h3>EMI with Interest</h3>
								<p>Select Credit Card Option during Check Out and Opt for EMI in our payment gateway page.</p>
								<h3>No Cost EMI</h3>
								<p>Not available.</p>
							<?php }?>
						</div>
					<?php }?>
					<?php if (preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['deal']->value['description'], $tmp)>1) {?>
						<div class="offer-details">
							<h4 class="offer-details-title">OFFER DETAILS</h4>
							<?php echo $_smarty_tpl->tpl_vars['deal']->value['description'];?>

						</div>
					<?php }?>
					
					<?php if ($_smarty_tpl->tpl_vars['deal']->value['amazon']||$_smarty_tpl->tpl_vars['deal']->value['flipkart']||$_smarty_tpl->tpl_vars['deal']->value['snapdeal']) {?>
					<div class="other-site-prices">
						<h4>Others Price</h4>
						<?php if ($_smarty_tpl->tpl_vars['deal']->value['amazon']) {?>
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/amazon.png" alt="amazon" height="32px" width="32px" />
									<span>Amazon</span>
								</div>
								<div class="media-body">
									<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['amazon']),$_smarty_tpl);?>
</h4>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['deal']->value['flipkart']) {?>
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/flipkart.png" alt="flipkart" height="32px" width="32px" />
									<span>Flipkart</span>
								</div>
								<div class="media-body">
									<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['flipkart']),$_smarty_tpl);?>
</h4>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['deal']->value['snapdeal']) {?>
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/snapdeal.png" alt="Snapdeal" height="32px" width="32px" />
									<span>Snapdeal</span>
								</div>
								<div class="media-body">
									<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['snapdeal']),$_smarty_tpl);?>
</h4>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
					<?php } else { ?>
					<div class="other-site-prices">
						<div class="product-exclusive">
							<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/exclusive-badge.png" alt="">
							<h4>Exclusively available only on Kobster!</h4>
						</div>
					</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['deal']->value['quantity']<=0) {?>
					<div class="out-of-stock">
						<h3>Out of Stock</h3>
					</div>
					<?php }?>
				</div>
				
				<div class="product-color">
					<?php if (count($_smarty_tpl->tpl_vars['deal']->value['colors'])) {?>
						<?php  $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deal']->value['colors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color']->key => $_smarty_tpl->tpl_vars['color']->value) {
$_smarty_tpl->tpl_vars['color']->_loop = true;
?>
							<div class="palette">
								<input type="radio" id="<?php echo $_smarty_tpl->tpl_vars['color']->value['id_product_attribute'];?>
"  name="productColor" <?php if ($_smarty_tpl->tpl_vars['color']->value['default']==1) {?>checked<?php }?>/>
								<label for="<?php echo $_smarty_tpl->tpl_vars['color']->value['id_product_attribute'];?>
" data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['color']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product']);?>
" class="productColor" style="background-color:<?php echo $_smarty_tpl->tpl_vars['color']->value['value'];?>
" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
"></label>
							</div>
						<?php } ?>
					<?php }?> 
				</div>
				
				<div class="product-title">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['deal']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
" target="_blank">
						<?php echo $_smarty_tpl->tpl_vars['deal']->value['p_name'];?>

					</a>
					<?php if ($_smarty_tpl->tpl_vars['deal']->value['available_now']) {?>
						<p><span class="delivery-info"><?php echo $_smarty_tpl->tpl_vars['deal']->value['available_now'];?>
</span></p>
					<?php }?>
				</div>
				<div class="product-value">
					<div class="product-price">
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['price']),$_smarty_tpl);?>

					</div>
					<div class="offer-percentage">
						
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>($_smarty_tpl->tpl_vars['deal']->value['price_without_reduction']-$_smarty_tpl->tpl_vars['deal']->value['price'])),$_smarty_tpl);?>
 OFF
						<span class="price-seal">Compare with others</span>
					</div>
				</div>
			</div>
			<div class="product-actions">
				<?php $_smarty_tpl->_capture_stack[0][] = array('default', null, null); ob_start(); ?>add=1&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product']);?>
<?php if (isset($_smarty_tpl->tpl_vars['deal']->value['id_product_attribute'])&&$_smarty_tpl->tpl_vars['deal']->value['id_product_attribute']) {?>&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product_attribute']);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['static_token']->value)) {?>&amp;token=<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
				<button data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['deal']->value['product_attribute_minimal_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']>=1) {?><?php echo intval($_smarty_tpl->tpl_vars['deal']->value['product_attribute_minimal_quantity']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['deal']->value['minimal_quantity']);?>
<?php }?>" id="<?php echo $_smarty_tpl->tpl_vars['deal']->value['id_product'];?>
" class="add-to-bag ajax_add_to_cart_button_deals <?php if ($_smarty_tpl->tpl_vars['deal']->value['quantity']<=0) {?>disabled<?php }?>" title="Add to Cart">ADD TO CART</button>
			</div>
		</div>
		<?php } ?>
	</div>
<?php } ?>


<!-- Share Email Modal -->
<div class="modal fade perks-modal" id="emailShare" tabindex='-1' role="dialog" data-keyboard="true" >
	<div class="modal-dialog">
		<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">&nbsp;</button>
		<div class="modal-header">
			<h2>Share this Offer!</h2>
		</div>
		<div class="modal-body">
			<div class="media-object">
				<div class="media-figure">
				Hi
				</div>
				<div class="media-body">
					<h3>Beats EP On-Ear Headphones - Black</h3>
					<p>2,999</p>
				</div>
			</div>
			<div class="form-container">
				<div class="form-group">
					<label for="emailTo">To</label>
					<input type="email" class="form-control" id="emailTo" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="message">Message</label>
					<textarea class="form-control" rows="3" id="message">Some message...</textarea>
				</div>
				<div class="checkbox-vertical">
					<label for="sendCopy">Send me a copy!</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit">SEND EMAIL</button>
		</div>
		</div>
	</div>
</div>

<?php  $_smarty_tpl->tpl_vars['deal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['deal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['deal']->key => $_smarty_tpl->tpl_vars['deal']->value) {
$_smarty_tpl->tpl_vars['deal']->_loop = true;
?>
<!-- Compare Price Modal -->
<div class="modal fade perks-modal compare-modal" id="modal_<?php echo $_smarty_tpl->tpl_vars['deal']->value['id_product'];?>
" tabindex='-1' role="dialog" data-keyboard="true" >
	<div class="modal-dialog">
		<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">&nbsp;</button>
		<div class="modal-header">
			<h2>Price on Other Sites</h2>
		</div>
		<div class="modal-body">
			<div class="media-object our-price">
				<div class="media-figure">
					<img src="<?php echo $_smarty_tpl->tpl_vars['deal']->value['imageLink2'];?>
" style="width: 128px;">
				</div>
				<div class="media-body">
					<h3><?php echo $_smarty_tpl->tpl_vars['deal']->value['name'];?>
</h3>
					<p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['price']),$_smarty_tpl);?>
</p>
					<p class="others-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['price_without_reduction']),$_smarty_tpl);?>
</p>
					<p><span class="delivery-info"><i class="truck-icon"></i><?php echo $_smarty_tpl->tpl_vars['deal']->value['available_now'];?>
</span></p>
					<p class="price-terms">This price is exclusive only for employees of <span class="perks-company-name"><?php echo $_smarty_tpl->tpl_vars['company_name']->value;?>
</span>.<p>
					<div class="product-actions">
					
						<a class="buy_now ajax_add_to_cart_button perks-primary-button" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product']);?>
">BUY NOW</a>
						<button data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['deal']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['deal']->value['product_attribute_minimal_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']>=1) {?><?php echo intval($_smarty_tpl->tpl_vars['deal']->value['product_attribute_minimal_quantity']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['deal']->value['minimal_quantity']);?>
<?php }?>" id="<?php echo $_smarty_tpl->tpl_vars['deal']->value['id_product'];?>
" class="perks-secondary-button ajax_add_to_cart_button_deals" title="Add to Cart">ADD TO CART</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="other-site-prices">
				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/amazon.png" alt="amazon" height="48px" width="48px" />
							<span>Amazon</span>
						</div>
						<div class="media-body">
						<?php if ($_smarty_tpl->tpl_vars['deal']->value['amazon']) {?>
							<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['amazon']),$_smarty_tpl);?>
</h4>
						<?php } else { ?>
							<h4>NA</h4>
						<?php }?>
						</div>
					</div>
				</div>

				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/flipkart.png" alt="flipkart" height="48px" width="48px" />
							<span>Flipkart</span>
						</div>
						<div class="media-body">
							<?php if ($_smarty_tpl->tpl_vars['deal']->value['flipkart']) {?>
								<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['flipkart']),$_smarty_tpl);?>
</h4>
							<?php } else { ?>
								<h4>NA</h4>
							<?php }?>
						</div>
					</div>
				</div>

				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="<?php echo $_smarty_tpl->tpl_vars['tpl_uri']->value;?>
img/perks/others-logo/snapdeal.png" alt="Snapdeal" height="48px" width="48px" />
							<span>Snapdeal</span>
						</div>
						<div class="media-body">
							<?php if ($_smarty_tpl->tpl_vars['deal']->value['snapdeal']) {?>
								<h4><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['deal']->value['snapdeal']),$_smarty_tpl);?>
</h4>
							<?php } else { ?>
								<h4>NA</h4>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['deal']->value['snapdeal']) {?>
			<div class="date-updated">Prices last updated on <?php echo $_smarty_tpl->tpl_vars['deal']->value['date_upd'];?>
</div>
			<?php }?>
		</div>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.productColor').click(function(){
	    console.log($(this));
		var id_product_attribute = $(this).data('id-product-attribute');
		var id_product = $(this).data('id-product');
		$('#'+id_product+'').attr('data-id-product-attribute', id_product_attribute); 
	});
});
</script><?php }} ?>
