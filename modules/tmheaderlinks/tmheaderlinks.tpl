<ul id="tmheaderlinks">
	<li><a href="{$link->getPageLink('index.php')}"{if $page_name == 'index'} class="active"{/if}>{l s='home' mod='tmheaderlinks'}</a></li>
	<li><a href="{$link->getPageLink('prices-drop.php')}"{if $page_name == 'prices-drop'} class="active"{/if}>{l s='specials' mod='tmheaderlinks'}</a></li>
	<li><a href="{$link->getPageLink('cms.php?id_cms=1')}"{if $page_name == 'cms'} class="active"{/if}>{l s='Delivery' mod='tmheaderlinks'}</a></li>
	<li><a href="{$link->getPageLink('contact-form.php')}"{if $page_name == 'contact-form'} class="active"{/if}>{l s='contact' mod='tmheaderlinks'}</a></li>
</ul>