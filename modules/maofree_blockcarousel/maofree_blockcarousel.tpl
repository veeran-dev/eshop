<div class="block column-feacherd">
	<h4>{l s='Featured products' mod='maofree_blockcarousel'}</h4>
   <div class="block_content">
		{if $blockcarousel_products}      
			<div class="blockcarousel">
            <div class="jCarouselLite">		    	
			    	<ul>
					   {foreach from=$blockcarousel_products item=product}
				         <li {if $blockcarousel_imagetype eq 'medium'}class="blockcarousel_mediumsize"{elseif $blockcarousel_imagetype eq 'home'}class="blockcarousel_homesize"{/if}>
			               <div>					      			
					            <a href="{$product.link|escape:'htmlall':'UTF-8'}" class="product_img_link" title="{$product.legend|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, $blockcarousel_imagetype)}" height="{$blockcarousel_imagesize.height}" width="{$blockcarousel_imagesize.width}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" /></a>
	                        <div class="blockcarouselname">
				                  {if $blockcarousel_title}
					                  {if $blockcarousel_imagetype eq 'medium'}
					               	   <h5><a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'|truncate:30:'...'}</a></h5><br />
	                              {elseif $blockcarousel_imagetype eq 'home'}
					               	   <h5><a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'|truncate:18:'...'}</a></h5><br />                              
		                           {/if}
	                           {/if}	                           
	                           {if $blockcarousel_price}
					                  <span class="price">{displayWtPrice p=$product.price}</span>
					               {/if}
					            </div>
			               </div>
			            </li>	
					   {/foreach}
					</ul>
			   </div>
		   </div>
		{else}
         <p>{l s='No products' mod='maofree_blockcarousel'}</p>
		{/if}			   
	</div>
</div>