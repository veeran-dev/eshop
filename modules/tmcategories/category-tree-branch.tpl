
<li class="{cycle values="category-1,category-2,category-3,category-4,category-5,category-6,category-7"} {if $node.children|@count > 0}sub{/if}{if isset($last) && $last == 'true'} last{/if}">
	<a class="{if $node.id == $currentCategoryId} selected{/if}" href="{$node.link}" {if isset($currentCategoryId) && ($node.id == $currentCategoryId)}class="selected"{/if}><span>{$node.name|escape:html:'UTF-8'}</span></a>
	{if $node.children|@count > 0}
		<ul class="subcat1">
		{foreach from=$node.children item=child key=k}
			<li class="sub-cat-{$k}">
				<a href="{$child.link|escape:html:'UTF-8'}">{$child.name|escape:html:'UTF-8'}</a>
				<img src="img/c/{$child.id}-category.jpg" alt="" />
				<div>
				{if $child.children|@count > 0}
				<ul class="subcat2">
					{foreach from=$child.children item=child2}
					<li><a href="{$child2.link|escape:html:'UTF-8'}">{$child2.name|escape:html:'UTF-8'}</a></li>
					{/foreach}
				</ul>
				{/if}
				</div>
			</li>
		{/foreach}
		</ul>
	{/if}
</li>