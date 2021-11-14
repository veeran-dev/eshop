{if $page_name !== 'index'}
<div id="manufacturers_block_left" class="block blockmanufacturer">
	<h4>{if $display_link_manufacturersslide}<a href="{$link->getPageLink('manufacturer.php')}" title="{l s='Manufacturers' mod='maofree_blockmanufacturer'}">{/if}{l s='Manufacturers' mod='maofree_blockmanufacturer'}{if $display_link_manufacturersslide}</a>{/if}</h4>
   <div class="block_content">
		{if $manufacturersslide}
			<div class="manufacturerslide">
            <div class="jCarouselLite">		    	
			    	<ul>
					   {foreach from=$manufacturersslide item=manufacturer name=manufacturersslide}
				         <li>
			               <div>					      			
                           <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$manufacturer.name|escape:'htmlall':'UTF-8'}"><img src="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}-medium.jpg" height="{$manufacturers_imagesize.height}" width="{$manufacturers_imagesize.width}" alt="{$manufacturer.legend|escape:'htmlall':'UTF-8'}" /></a>
                           <div class="manufacturerdesc">
				               	<h5><a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$manufacturer.name|escape:html:'UTF-8'}">{$manufacturer.name|escape:'htmlall':'UTF-8'|truncate:20:'...'}</a></h5>
	                           <p style="font-weight: normal"><a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}">{$manufacturer.description|strip_tags:'UTF-8'|truncate:50:'...'}</a></p>
                           </div>
			               </div>
			            </li>	
					   {/foreach}
					</ul>
			   </div>
		   </div>
		{else}
         <p>{l s='No manufacturer' mod='maofree_blockmanufacturer'}</p>
		{/if}
	</div>
</div>
{/if}