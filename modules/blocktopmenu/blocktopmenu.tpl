{if $MENU != ''}
	
	<!-- Menu -->
	<div class="sf-contener clearfix">
		<ul class="sf-menu clearfix">
			<li class="">
            <a href="http://localhost/kobster_v_2/index.php?id_category=3&amp;controller=category&amp;id_lang=1" title="Accessories" class="sf-with-ul">Accessories</a>
            <ul class="submenu-container clearfix first-in-line-xs" style="display: none;">
            	<li class="">
                	<a href="http://localhost/kobster_v_2/index.php?id_category=8&amp;controller=category&amp;id_lang=1" title="transand">transand</a>
                 </li>
                 <li>
                 	<a href="http://localhost/kobster_v_2/index.php?id_category=9&amp;controller=category&amp;id_lang=1" title="lather cover">lather cover</a>
                 </li>
              </ul>
             </li>
			{if $MENU_SEARCH}
				<li class="sf-search noBack" style="float:right">
					<form id="searchbox" action="{$link->getPageLink('search')|escape:'html'}" method="get">
						<p>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'html':'UTF-8'}{/if}" />
						</p>
					</form>
				</li>
			{/if}
		</ul>
	</div>
	<div class="sf-right">&nbsp;</div>

	<!--/ Menu -->
{/if}