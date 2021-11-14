	/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
 var instantSearchQueries = [];
$(document).ready(function()
{
	if (typeof blocksearch_type == 'undefined')
		return;

	if(page_name == 'shop')
		blocksearch_type = 'home';
		
	$(".search-button").click(function(event){
		if(!$("#search_query_"+blocksearch_type).val())
		{
			event.preventDefault();			
			var category_id=$(".category-dropdown:last option:selected").val();

			if(category_id==0 || !category_id)
				return;
			else				
				var a = document.createElement('a');
				a.href = "?controller=category&id_lang=1&id_category="+category_id;
				document.body.appendChild(a);
				a.click();
		}

	});
	var $input = $("#search_query_" + blocksearch_type);
   	var width_ac_results = 	$input.parent('form').outerWidth();
  	if (typeof ajaxsearch != 'undefined' && ajaxsearch) {
		$input.autocomplete(
			search_url,
			{
				minChars: 2,
				max: 10,
				width: (width_ac_results > 0 ? width_ac_results : 500),
				selectFirst: false,
				scroll: false,
				dataType: "json",
				formatItem: function(data, i, max, value, term) {
					return value;
				},
				parse: function(data) {
 					var mytab = [];
					var disply_result = "", heading = "";
					var category = 0, product = 0, brand = 0;
  					if(data != "") {
						for (var key in data) {
						  if (data.hasOwnProperty(key)) {
						  	for(var i = 0; i < data[key].length; i++) {
						  		disply_result = '<label class="search_category">'+ data[key][i].name + '</label>';
								mytab[mytab.length] = { data: data[key][i], value: disply_result};
						  	}
						  }
						}		
					}

					return mytab;
				},
				extraParams: {
					ajaxSearch: 1,
					id_lang: id_lang,
					suggest: 2 
				}
			}
		)
		.result(function(event, data, formatted) {
 			$input.val(data.name);
 			document.location.href = data.link;
		});
	}

	if (typeof instantsearch != 'undefined' && instantsearch) {
		$input.on('keyup', function(){
			if($(this).val().length > 4)
			{
				stopInstantSearchQueries();
				instantSearchQuery = $.ajax({
					url: search_url + '?rand=' + new Date().getTime(),
					data: {
						instantSearch: 1,
						id_lang: id_lang,
						q: $(this).val()
					},
					dataType: 'html',
					type: 'POST',
					headers: { "cache-control": "no-cache" },
					async: true,
					cache: false,
					global: false,
					success: function(data){
						if ($input.val().length > 0) {
							tryToCloseInstantSearch();
							$('#center_column').attr('id', 'old_center_column');
							$('#old_center_column').after('<div id="center_column" class="' + $('#old_center_column').attr('class') + '">' + data + '</div>').hide();
							// Button override
							ajaxCart.overrideButtonsInThePage();
							$("#instant_search_results a.close").on('click', function() {
								$input.val('');
								return tryToCloseInstantSearch();
							});
							return false;
						}
						else
							tryToCloseInstantSearch();
					}
				});
				instantSearchQueries.push(instantSearchQuery);
			}
			else
				tryToCloseInstantSearch();
		});
	}
});

function tryToCloseInstantSearch()
{
	var $oldCenterColumn = $('#old_center_column');
	if ($oldCenterColumn.length > 0)
	{
		$('#center_column').remove();
		$oldCenterColumn.attr('id', 'center_column').show();
		return false;
	}
}

function stopInstantSearchQueries()
{
	for(var i=0; i<instantSearchQueries.length; i++)
		instantSearchQueries[i].abort();
	instantSearchQueries = [];
}
