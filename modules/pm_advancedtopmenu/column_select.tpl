<select name="id_column">
        <option>{l s='Choose' mod='pm_advancedtopmenu'}</option>
        {foreach from=$columns item=column name=loop}
            <option value="{$column.id_column|intval}" {if $column_selected eq $column.id_column}selected=selected{/if}>{$objADTM->getAdminOutputNameValue($column,false)}</option>
        {foreachelse}
        	<option value="">{l s='No column' mod='pm_advancedtopmenu'}</option>
        {/foreach}
</select>