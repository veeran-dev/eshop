<?php /*%%SmartyHeaderCode:32480566fddc8063a94-40622998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cd51c3a785089641b25ac55f816d7b73cf07fbd' => 
    array (
      0 => 'C:\\wamp\\www\\kobstereshop\\themes\\theme335\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1450168100,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32480566fddc8063a94-40622998',
  'variables' => 
  array (
    'link' => 0,
    'ENT_QUOTES' => 0,
    'instantsearch' => 0,
    'search_ssl' => 0,
    'cookie' => 0,
    'ajaxsearch' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_566fddc822b290_20737049',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566fddc822b290_20737049')) {function content_566fddc822b290_20737049($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top_wrapper">
<div id="search_block_top">
	<form method="get" action="http://localhost/kobstereshop/index.php?controller=search" id="searchbox">
		<label>Search</label>
		<input placeholder="SEARCH FROM OVER 10000 PRODUCTS"  class="search_query" type="text" onclick="fn_remove();" id="search_query_top" name="search_query" value="" onFocus="if(this.value=='')this.value='';" onBlur="if(this.value=='')this.value='';" />
		<a href="javascript:document.getElementById('searchbox').submit();"></a>
		
	</form>
</div>
</div>
	<script type="text/javascript">
	
	// <![CDATA[
			
		/*$("#search_query_top").keyup( function() {*/
		$(document).ready(function(){
			$("#search_query_top")
				.autocomplete(
					'http://localhost/kobstereshop/index.php?controller=search', {
						minChars: 3,
						max: 10,
						width: 500,
						selectFirst: false,
						scroll: false,
						dataType: "json",
						formatItem: function(data, i, max, value, term) {
							return value;
						},
						parse: function(data) {
							var mytab = new Array();
							for (var i = 0; i < data.length; i++)
							//	mytab[mytab.length] = { data: data[i], value: data[i].pname };
						mytab[mytab.length] = { data: data[i], value:"<div><span  id='search_image'>"+"<img class='dummy' src="+data[i].imageLink+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].pname+"</span></div>"};
							return mytab;
						},
						extraParams: {
							ajaxSearch: 1,
							id_lang: 1
						}
					}
				)
				.result(function(event, data, formatted) {
					$('#search_query_top').val(data.pname);
					document.location.href = data.link;
				})
		
		});
	
	// ]]>
	function fn_remove()
{
 	$('#search_query_top').attr('placeholder','');
  	$('#search_query_top').focusout(function(){
	$(this).attr('placeholder',"SEARCH FROM OVER 10000 PRODUCTS");
	});
}
	</script>
<!-- /Block search module TOP --><?php }} ?>
