{if $page_name == 'index'}
<!-- tmbannerblock -->
<div id="tmbannerblock">
{counter name=banner_count start=0 skip=1 print=false}	
            {foreach from=$xml->link item=home_link name=links}
                    <a class="banner{counter name=banner_count}" href='{$home_link->url}'><img src='{$this_path}{$home_link->img}'alt="" title="{$home_link->desc}" /></a>
            {/foreach}
</div>
<div class="clearblock"></div>
<!-- /tmbannerblock -->
{/if}