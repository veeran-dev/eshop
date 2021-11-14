<select name="id_wrap">
        <option>{l s='Choose' mod='pm_advancedtopmenu'}</option>
        {foreach from=$columnsWrap item=columnWrap name=loop}
            <option value="{$columnWrap.id_wrap|intval}" {if $columnWrap_selected eq $columnWrap.id_wrap}selected=selected{/if}>{$columnWrap.internal_name}</option>
        {foreachelse}
        	<option value="">{l s='No column' mod='pm_advancedtopmenu'}</option>
        {/foreach}
</select>