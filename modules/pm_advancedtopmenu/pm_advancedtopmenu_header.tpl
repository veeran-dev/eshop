{if $smarty.const._PS_VERSION_ < '1.4'}
<!-- MODULE PM_AdvancedTopMenu || Presta-Module.com -->
<!--<link href="{$content_dir}modules/pm_advancedtopmenu/css/pm_advancedtopmenu_base.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$content_dir}modules/pm_advancedtopmenu/css/pm_advancedtopmenu_global.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$content_dir}modules/pm_advancedtopmenu/css/pm_advancedtopmenu_advanced.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$content_dir}modules/pm_advancedtopmenu/css/pm_advancedtopmenu.css" rel="stylesheet" type="text/css" media="all" />
--><!--[if lt IE 8]>
<script type="text/javascript" src="{$content_dir}modules/pm_advancedtopmenu/js/pm_advancedtopmenuiefix.js"></script>
<![endif]-->
<!--<script type="text/javascript" src="{$content_dir}modules/pm_advancedtopmenu/js/pm_advancedtopmenu.js"></script>
-->{if !isset($ajaxsearch) || !$ajaxsearch}
<!--<link rel="stylesheet" type="text/css" href="{$content_dir}css/jquery.autocomplete.css" />
<script type="text/javascript" src="{$content_dir}js/jquery/jquery.autocomplete.js"></script>
-->{/if}
{else}
<!--[if lt IE 8]>
<script type="text/javascript" src="{$content_dir}modules/pm_advancedtopmenu/js/pm_advancedtopmenuiefix.js"></script>
<![endif]-->
{if !isset($ajaxsearch) || !$ajaxsearch}
<!--<link rel="stylesheet" type="text/css" href="{$content_dir}css/jquery.autocomplete.css" />
<script type="text/javascript" src="{$content_dir}js/jquery/jquery.autocomplete.js"></script>
-->{/if}
{/if}
<!-- /MODULE PM_AdvancedTopMenu || Presta-Module.com -->