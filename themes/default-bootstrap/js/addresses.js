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
$(document).ready(function() {
	if (typeof addressesConfirm !== 'undefined' && addressesConfirm)
	{
		$('a[data-id="addresses_confirm"]').click(function(){
			//return confirm(addressesConfirm);
			var href = $(this).attr('href');
			if (!$('#dataConfirmModal').length) {
				$('body').append(
					`<div id="dataConfirmModal" class="modal fade in" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;</button>
									<h3 id="dataConfirmLabel">Please Confirm</h3>
								</div>
								<div class="modal-body">
									<p>Are you sure you want to delete this address?</p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
									<a class="btn btn-primary" id="dataConfirmOK">OK</a>
								</div>
							</div>
						</div>
					</div>`
				);
			} 
			$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
			$('#dataConfirmOK').attr('href', href);
			$('#dataConfirmModal').modal({show:true});
			return false;
			});
	}
});
