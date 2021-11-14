<!-- <script type="text/javascript" src="{$base_dir}modules/homeOfficeFurniture/homeOfficeFurniture.js"></script> -->
			
<!-- MODULE Home Featured Products -->
{if isset($products) AND $products}
<div class="homecarouseldiv">
<br />
<h4>{l s='Office Furniture' mod='homeOfficeFurniture'}
	<span>
		<khelp class="khelp">Comfortable & Stylish furniture for your office. Quality guaranteed.</khelp>
		<a href="https://www.kobster.com/229-furniture">View All &gt;&gt;</a>
	</span>
</h4>
<div class="homecarouselulwrapper">
<ul id="homecarouselelulfu">
	{foreach from=$products item=product name=officeSta}
		{assign var='productLink' value=$link->getProductLink($product.id_product, $product.link_rewrite)}
		<li onmouseover="document.getElementById('button_bs_{$product.id_product}').style.visibility = 'visible';"
			onmouseout="document.getElementById('button_bs_{$product.id_product}').style.visibility = 'hidden';">
			{if $product.specific_prices.reduction_type == 'percentage'}
				<strong class="discount_container"> 
					<strong class="discount_st">
						{$product.specific_prices.reduction*100}%
					</strong>
				</strong>
			{elseif  $product.specific_prices.reduction_type == 'amount'}
				<strong class="discount_container"> 
					<strong class="discount_st">
						{math equation="round((reductionAmount/productPriceWithoutRedution) * 100)" productPriceWithoutRedution=$product.price_without_reduction reductionAmount=$product.specific_prices.reduction assign=reductionPercentage}						
						{$reductionPercentage}%
					</strong>
				</strong>
			{/if}
		<a href="{$productLink}" title="{$product.legend}" class="product_image"><img class="lazyImage" src="img/loader_gv.gif" data-src="{$link->getImageLink($product.link_rewrite, $product.id_image, $imagetype)}" alt="{$product.legend}" /></a>
		<a onClick="return false;" href="#bs_qvb_{$product.id_product}" class="quickViewButton" id="button_bs_{$product.id_product}"><img src="https://www.kobster.com/images/quickView.jpg"/></a>
		{if $displayname}<h5 class="prod_name"><a href="{$productLink}" title="{$product.name}">{$product.name|escape:htmlall:'UTF-8'|truncate:45}</a></h5>{/if}
		<div id="pl_rating">
			{if $product.averageRating|round eq 0}
				<div class="zero" title="4 Stars"></div>
			{elseif $product.averageRating|round eq 1}
				<div class="one" title="1 Star"></div>
			{elseif $product.averageRating|round eq 2}
				<div class="two" title="2 Stars"></div>
			{elseif $product.averageRating|round eq 3}
				<div class="three" title="3 Stars"></div>
			{elseif $product.averageRating|round eq 4}
				<div class="four" title="4 Stars"></div>
			{elseif $product.averageRating|round eq 5}
				<div class="five" title="5 Stars"></div>
			{/if}
		</div>
		<p class="product_desc">{$product.description_short|strip_tags|truncate:90:'...'}</p>
		
		{if $displayprice}<div class="home_price"><span class="price_beg"></span><span class="price">{displayWtPrice p=$product.price}</span><span class="price_end"></span></div>{/if}
		{if $displayprice && isset($product.reduction) && $product.reduction}<div class="product_mrp">{convertPrice price=$product.price_without_reduction}</div>{/if}
		
					{if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}<div class="carousel_buttons">
						{if ($product.quantity > 0 OR $product.allow_oosp)}
						<span><a class="button" href="{$product.link}" title="{l s='View' mod='homecarousel'}">{l s='View' mod='homecarousel'}</a>
						<input type="text" name="qty" id="{$product.id_product}_hc_quantity_wanted" class="hf_quantity_wanted" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} /></span>
						<span><a class="exclusive hc_ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homecarousel'}">{l s='Add to cart' mod='homecarousel'}</a></span>
						{else}
						<span class="exclusive">{l s='Add to cart' mod='homecarousel'}</span>
						{/if}
					{/if}  
		</div>
		</li>
	{/foreach}
</ul>
</div>
<div class="clearfix"></div>
<!-- <a id="prev4" class="prev" href="#"><img src="https://www.kobster.com/themes/theme335/img/prev.png" atl="&lt;"/></a>
<a id="next4" class="next" href="#"><img src="https://www.kobster.com/themes/theme335/img/next.png" atl="&gt;"/></a> -->
</div>
{else}
<p>{l s='No products for carousel' mod='homecarouselnew'}</p>
{/if}
<!-- /MODULE Home Featured Products --> 

{foreach from=$products item=product name=products key=k}
<div id="bs_qvb_{$product.id_product}" class="quickView">
		<a onClick="return false;" class="quickViewClose" href="#bs_qvb_{$product.id_product}"><img src="https://www.kobster.com/images/Close.png" /></a>
		<div class="quickView_left">
			<a href="{$product.link|escape:'htmlall':'UTF-8'}" class="quickView_product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}"><img class="lazyImage" src="img/loader_qv.gif" data-src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" width="300px" height="300px" /></a>
			<p class="quickView_product_desc">{$product.description_short|strip_tags:'UTF-8'|truncate:200}</p>		
		</div>
		
		<div class="quickView_right">
			<h3 class="quickView_name">{$product.name|escape:'htmlall':'UTF-8'}</h3>
			<!--<div id="p_rating">
				{if $product.averageRating|round eq 0}
					<div class="zero" title="4 Stars"></div>
				{elseif $product.averageRating|round eq 1}
					<div class="one" title="1 Star"></div>
				{elseif $product.averageRating|round eq 2}
					<div class="two" title="2 Stars"></div>
				{elseif $product.averageRating|round eq 3}
					<div class="three" title="3 Stars"></div>
				{elseif $product.averageRating|round eq 4}
					<div class="four" title="4 Stars"></div>
				{elseif $product.averageRating|round eq 5}
					<div class="five" title="5 Stars"></div>
				{/if}
			</div>-->
			<!--<p class="qv_prod_desc">{$product.description|truncate:300:'...'|strip_tags:'UTF-8'}</p>
			<br />
				<a class="qv_more_details" href="{$product.link|escape:'htmlall':'UTF-8'}">Click here to know more details & customization options about this product</a>
			<br /><br />-->
            <div id="quick_price_sec" {if ($product.reference == "")} style="display:none"{/if}>
                {if $product.manufacturer_name}
                    <span class="qv_label">{l s='Manufactured By:'}</span>
                    <span id="availability_value">
                        {$product.manufacturer_name}
                    </span>
                    <br /><br />
                {/if}
                {if $product.reference}
                    <span class="qv_label">{l s='Product Code:'}</span>
                    <span id="availability_value">
                        {$product.reference}
                    </span>
                    <br /><br />
                {/if}
                {if $product.available_now}
                    <span class="qv_label">{l s='Delivered in:'}</span>
                    <span id="availability_value">
                        {$product.available_now}
                    </span>
                    <br /><br />
                {/if}
                {if $product.available_later && $product.available_later <> 'C0'}
                    <span class="qv_label">{l s='Delivered to:'}</span>
                    <span id="availability_value">
                        {$product.available_later} only
                    </span>
                {/if}
			</div>
            <div id="price_section" >
                 <div id="price_div" style="width:50%">
                 	 <div id="mrp_div" >
                         {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode) && isset($product.reduction) && $product.reduction}
                             <div class="quickView_mrp">
                             	<b> <strike>{convertPrice price=$product.price_without_reduction}</strike></b>
                             </div><br/>
                             {/if}
                     </div>
					 <div class="qv_product_price">
                        {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
                            <div class="quickView_price">
                                <span class="quick_price">
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                </span>
                            </div>
                        {/if}
					</div>
                        <div class="quickView_discount_container"> 
                            {if $product.specific_prices.reduction_type == 'percentage'}
                                <div class="quickView_discount_st">
                                    {math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmount}
                                    <span class="qv_discount_price">{l s='Saving: '}<span style="color:#009900;">{convertPrice price=$reductionAmount}</span></span>
                                </div>
                            
                            {elseif  $product.specific_prices.reduction_type == 'amount'}
                                <div class="quickView_discount_st">
                                    {math equation="round((reductionAmount/productPriceWithoutRedution) * 100)" productPriceWithoutRedution=$product.price_without_reduction reductionAmount=$product.specific_prices.reduction assign=reductionPercentage}
                                    {math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmt}
                                    <span class="qv_discount_price">{l s='Saving: '}<span style="color:#009900;">{convertPrice price=$reductionAmt}</span></span>
                                </div>
                            {/if}
                        </div>
                    </div>
            
                    {if $product.specific_prices.reduction_type == 'percentage'}
                    	{math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmount}
                        <div id="price_tag">
                            <div class="tag_h" ></div>
                            	<span class="qv_discount_percent_h">{$product.specific_prices.reduction*100}{l s=' % OFF '}</span>
                            <div id="tag_tail_h"></div>
                        </div>
                    {elseif  $product.specific_prices.reduction_type == 'amount'}
                        {math equation="round((reductionAmount/productPriceWithoutRedution) * 100)" productPriceWithoutRedution=$product.price_without_reduction reductionAmount=$product.specific_prices.reduction assign=reductionPercentage}
                        {math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmt}
                        <div id="price_tag">
                            <div class="tag_h" ></div>
                            	<span class="qv_discount_percent_h">{$reductionPercentage}{l s=' % OFF! '}</span>
                            <div id="tag_tail_h"></div>
                        </div>
                    {/if}
			</div>
			<div class="quickView_carousel_buttons">
                <div id="quick_quanity">
                	<div id="quick_quantity_div">QTY: </div>
                	<input type="text" name="qty" id="{$product.id_product}_hc_qv_quantity_wanted" class="quickView_quantity_wanted" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
                </div>
                <div id="quick_button">
                	<a class="hc_qv_ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart.php')}?add&amp;id_product={$product.id_product|intval}&amp;{if isset($static_token)}&amp;token={$static_token}{/if}" title="{l s='BUY NOW'}"><label id="quick_buynow">BUY NOW</label></a>
                	<div id="quick_call2buy">Call 044 64573222 to Buy </div>
                </div>
              </div>
		</div>
        <div id="quick_bottom">
            <div id="quick_gen">
            	<span id="static_100" style="color:#7f7f7f; margin-left:40px;">100% GENUINE & BRAND NEW PRODUCTS</span>
            </div>
            <div id="quick_ship">
            	<span id="static_ship" style="color:#7f7f7f; margin-left:100px;">FREE SHIPPING ON ORDER ABOVE <b>Rs. 1000</b></span>
            </div>
        </div>
	</div>
{/foreach}

<div class="backgroundQuickView"></div>
<script>
 $(".quickView_quantity_wanted").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
</script>