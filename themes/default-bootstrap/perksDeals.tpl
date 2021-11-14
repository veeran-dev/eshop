<div class="feedback-float-button">
	<a data-toggle="modal" data-target="#feedbackModal" href="#" title="Feedback">
	<img src="{$tpl_uri}img/perks/face.png" alt="smiley"/> Feedback
	</a>
</div>
<div class="perks-main-banner" style="visibility: hidden;">
	<ul class="perksMainBanner">
		<li><a href="{$link->getProductLink(987236)|escape:'html':'UTF-8'}"><img src="{$tpl_uri}img/perks/main-banner/banner-4.jpg" /></a></li>
		<li><a href="javascript:void(0);"><img src="{$tpl_uri}img/perks/main-banner/banner-0.jpg" /></a></li>
		<li><a href="#41203071"><img src="{$tpl_uri}img/perks/main-banner/banner-5.jpg" /></a></li>
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
					<img src="{$tpl_uri}img/perks/category/smartphone.jpg" alt="Mobile Phones">
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
					<img src="{$tpl_uri}img/perks/category/woman-ambassadors-jewellery.jpg" alt="Woman Ambassador Jewellery">
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
					<img src="{$tpl_uri}img/perks/category/audio-systems.jpg" alt="Music Systems">
					<span>Music Systems</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 20% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		{*
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41202970">
				<div class="category-link-name">
					<img src="{$tpl_uri}img/perks/category/microwave-oven.jpg" alt="Microwave Ovens">
					<span>MICROWAVE OVENS</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 18% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41202328">
				<div class="category-link-name">
					<img src="{$tpl_uri}img/perks/category/refrigerator.jpg" alt="Refrigerators">
					<span>REFRIGERATORS</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 19% OFF on selected brands.</span>
				</div>
			</a>
		</div>
		<div class="col-md-4">
			<a class="category-link-item deals-smooth-scroll" href="#41202338">
				<div class="category-link-name">
					<img src="{$tpl_uri}img/perks/category/washing-machine.jpg" alt="Washing Machines">
					<span>WASHING MACHINES</span>
				</div>
				<div class="category-link-hover">
					<span>Upto 15% OFF on selected brands.</span>
				</div>
			</a>
		</div>*}
	</div>
</div>

{foreach $dealsCategory as $cDeals}
	<div class="perks-title">
		<h2 id="{$cDeals[0].id_category}"><span>{$cDeals[0].c_name}</span></h2>
	</div>
	<div class="perks-product-container">
		{foreach $cDeals as $deal}
		{* {$deal|@var_export:true|nl2br} *}
		<div class="perks-product">
			<div class="product-info">
				<div class="product-visual">
					{if count($deal.imagesArr)}
					<div class="product-carousel">
						<div class="owl-carousel owl-theme">
							{foreach $deal.imagesArr as $img}
								<a href="{$deal.link|escape:'html':'UTF-8'}" title="{$deal.name}" target="_blank">
									<img class="item" src="{$tpl_uri}img/product-preloader.gif" data-src="{$img}">
								</a>
							{/foreach}
						</div>
					</div>
					{else}
						<a href="{$deal.link|escape:'html':'UTF-8'}" title="{$deal.name}" target="_blank">
							<img class="single-image" src="{$tpl_uri}img/product-preloader.gif" data-src="{$deal.imageLink2}"  alt="{$deal.name}" title="{$deal.name}" />
						</a>
					{/if}
					<div class="product-labels">
					{* Check whether it is a mobile category *}
					{if $deal.price >= 7000 }
						<span class="emi">EMI</span>
					{/if}
					{if $deal.description|count_characters > 1}
						<span class="offers">OFFERS</span>
					{/if}
					</div>
					{if $deal.price >= 7000 }
						<div class="emi-details">
							<h4>EMI DETAILS</h4>
							{if $deal.id_category == 5 }
								<h3>No Cost EMI</h3>
								<p>Select COD Option. Swipe your credit card with the delivery executive to avail this.</p>
								<h3>EMI with Interest</h3>
								<p>Select Credit Card Option during Check Out and Opt for EMI in our payment gateway page.</p>
							{else}
								<h3>EMI with Interest</h3>
								<p>Select Credit Card Option during Check Out and Opt for EMI in our payment gateway page.</p>
								<h3>No Cost EMI</h3>
								<p>Not available.</p>
							{/if}
						</div>
					{/if}
					{if $deal.description|count_characters > 1}
						<div class="offer-details">
							<h4 class="offer-details-title">OFFER DETAILS</h4>
							{$deal.description}
						</div>
					{/if}
					
					{if $deal.amazon || $deal.flipkart || $deal.snapdeal }
					<div class="other-site-prices">
						<h4>Others Price</h4>
						{if $deal.amazon}
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="{$tpl_uri}img/perks/others-logo/amazon.png" alt="amazon" height="32px" width="32px" />
									<span>Amazon</span>
								</div>
								<div class="media-body">
									<h4>{convertPrice price = $deal.amazon}</h4>
								</div>
							</div>
						</div>
						{/if}
						{if $deal.flipkart}
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="{$tpl_uri}img/perks/others-logo/flipkart.png" alt="flipkart" height="32px" width="32px" />
									<span>Flipkart</span>
								</div>
								<div class="media-body">
									<h4>{convertPrice price = $deal.flipkart}</h4>
								</div>
							</div>
						</div>
						{/if}
						{if $deal.snapdeal}
						<div class="other-site">
							<div class="media-object">
								<div class="media-figure">
									<img src="{$tpl_uri}img/perks/others-logo/snapdeal.png" alt="Snapdeal" height="32px" width="32px" />
									<span>Snapdeal</span>
								</div>
								<div class="media-body">
									<h4>{convertPrice price = $deal.snapdeal}</h4>
								</div>
							</div>
						</div>
						{/if}
					</div>
					{else}
					<div class="other-site-prices">
						<div class="product-exclusive">
							<img src="{$tpl_uri}img/perks/exclusive-badge.png" alt="">
							<h4>Exclusively available only on Kobster!</h4>
						</div>
					</div>
					{/if}
					{if $deal.quantity <= 0}
					<div class="out-of-stock">
						<h3>Out of Stock</h3>
					</div>
					{/if}
				</div>
				
				<div class="product-color">
					{if count($deal.colors)}
						{foreach $deal.colors as $color name=colorbox}
							<div class="palette">
								<input type="radio" id="{$color.id_product_attribute}"  name="productColor" {if $color.default == 1}checked{/if}/>
								<label for="{$color.id_product_attribute}" data-id-product-attribute="{$color.id_product_attribute|intval}" data-id-product="{$deal.id_product|intval}" class="productColor" style="background-color:{$color.value}" data-toggle="tooltip" title="{$color.name}"></label>
							</div>
						{/foreach}
					{/if} 
				</div>
				
				<div class="product-title">
					<a href="{$deal.link|escape:'html':'UTF-8'}" title="{$deal.name}" target="_blank">
						{$deal.p_name}
					</a>
					{if $deal.available_now}
						<p><span class="delivery-info">{$deal.available_now}</span></p>
					{/if}
				</div>
				<div class="product-value">
					<div class="product-price">
						{convertPrice price = $deal.price}
					</div>
					<div class="offer-percentage">
						{* {number_format(((($deal.price_without_reduction - $deal.price)/$deal.price_without_reduction)*100), 0)}% OFF *}
						{convertPrice price = ($deal.price_without_reduction - $deal.price)} OFF
						<span class="price-seal">Compare with others</span>
					</div>
				</div>
			</div>
			<div class="product-actions">
				{capture}add=1&amp;id_product={$deal.id_product|intval}{if isset($deal.id_product_attribute) && $deal.id_product_attribute}&amp;ipa={$deal.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
				<button data-id-product-attribute="{$deal.id_product_attribute|intval}" data-id-product="{$deal.id_product|intval}" data-minimal_quantity="{if isset($deal.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$deal.product_attribute_minimal_quantity|intval}{else}{$deal.minimal_quantity|intval}{/if}" id="{$deal.id_product}" class="add-to-bag ajax_add_to_cart_button_deals {if $deal.quantity <= 0}disabled{/if}" title="Add to Cart">ADD TO CART</button>
			</div>
		</div>
		{/foreach}
	</div>
{/foreach}


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

{foreach $deals as $deal}
<!-- Compare Price Modal -->
<div class="modal fade perks-modal compare-modal" id="modal_{$deal.id_product}" tabindex='-1' role="dialog" data-keyboard="true" >
	<div class="modal-dialog">
		<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">&nbsp;</button>
		<div class="modal-header">
			<h2>Price on Other Sites</h2>
		</div>
		<div class="modal-body">
			<div class="media-object our-price">
				<div class="media-figure">
					<img src="{$deal.imageLink2}" style="width: 128px;">
				</div>
				<div class="media-body">
					<h3>{$deal.name}</h3>
					<p>{convertPrice price = $deal.price}</p>
					<p class="others-price">{convertPrice price = $deal.price_without_reduction}</p>
					<p><span class="delivery-info"><i class="truck-icon"></i>{$deal.available_now}</span></p>
					<p class="price-terms">This price is exclusive only for employees of <span class="perks-company-name">{$company_name}</span>.<p>
					<div class="product-actions">
					{*
						{capture}add=1&amp;id_product={$deal.id_product|intval}{if isset($deal.id_product_attribute) && $deal.id_product_attribute}&amp;ipa={$deal.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
						<a href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" title="Buy now">
							<button type="button" class="perks-primary-button">BUY NOW</button>
						</a>
					*}
						<a class="buy_now ajax_add_to_cart_button perks-primary-button" data-id-product="{$deal.id_product|intval}">BUY NOW</a>
						<button data-id-product-attribute="{$deal.id_product_attribute|intval}" data-id-product="{$deal.id_product|intval}" data-minimal_quantity="{if isset($deal.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$deal.product_attribute_minimal_quantity|intval}{else}{$deal.minimal_quantity|intval}{/if}" id="{$deal.id_product}" class="perks-secondary-button ajax_add_to_cart_button_deals" title="Add to Cart">ADD TO CART</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="other-site-prices">
				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="{$tpl_uri}img/perks/others-logo/amazon.png" alt="amazon" height="48px" width="48px" />
							<span>Amazon</span>
						</div>
						<div class="media-body">
						{if $deal.amazon}
							<h4>{convertPrice price = $deal.amazon}</h4>
						{else}
							<h4>NA</h4>
						{/if}
						</div>
					</div>
				</div>

				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="{$tpl_uri}img/perks/others-logo/flipkart.png" alt="flipkart" height="48px" width="48px" />
							<span>Flipkart</span>
						</div>
						<div class="media-body">
							{if $deal.flipkart}
								<h4>{convertPrice price = $deal.flipkart}</h4>
							{else}
								<h4>NA</h4>
							{/if}
						</div>
					</div>
				</div>

				<div class="other-site">
					<div class="media-object">
						<div class="media-figure">
							<img src="{$tpl_uri}img/perks/others-logo/snapdeal.png" alt="Snapdeal" height="48px" width="48px" />
							<span>Snapdeal</span>
						</div>
						<div class="media-body">
							{if $deal.snapdeal}
								<h4>{convertPrice price = $deal.snapdeal}</h4>
							{else}
								<h4>NA</h4>
							{/if}
						</div>
					</div>
				</div>
			</div>
			{if $deal.snapdeal}
			<div class="date-updated">Prices last updated on {$deal.date_upd}</div>
			{/if}
		</div>
		</div>
	</div>
</div>
{/foreach}
<script type="text/javascript">
$(document).ready(function(){
	$('.productColor').click(function(){
	    console.log($(this));
		var id_product_attribute = $(this).data('id-product-attribute');
		var id_product = $(this).data('id-product');
		$('#'+id_product+'').attr('data-id-product-attribute', id_product_attribute); 
	});
});
</script>